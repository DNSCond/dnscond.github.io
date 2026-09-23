import requests, pathlib, json, re, time
from math import floor


def main():
    fetch_queue = (
        # path url, path fs,
        ('dnscond.github.io/index.php', 'index.php',),
        ('dnscond.github.io/projects/index.php', 'projects/index.php',),
        ('require/Nav.css', 'require/Nav.css',),
        ('require/head2/ANTStylesheet.css', 'require/head2/ANTStylesheet.css',),
        ('require/JSONScript.js', 'require/JSONScript.js',),
        ('require/head2/domContentLoadedPromise.js', 'require/head2/domContentLoadedPromise.js',),
        ('gallery/favicon.ico', 'gallery/favicon.ico',),
        ('dnscond.github.io/clock/index.php', 'clock/index.php',),
    )

    basepath = pathlib.Path(r'D:\var\www\BOTs\dnscond.github.io')

    for i in fetch_queue:
        path = basepath / i[1]
        url = f'http://localhost/{i[0]}?isntLocalhost=1'
        resp = requests.get(url)
        path = path.with_suffix('.html') if path.suffix == '.php' else path
        path.parent.mkdir(parents=True, exist_ok=True)
        with open(path, 'wb') as file:
            file.write(resp.content)
    for i in pathlib.Path('blog').iterdir():
        if i.suffix == '.php':
            url = f'http://localhost/dnscond.github.io/blog/{i.name}?isntLocalhost=1'
            resp = requests.get(url)
            # noinspection unresolved-references
            path = basepath / 'blog' / i.with_suffix('.html').name
            with open(path, 'wb') as file:
                cont = resp.content
                cont = re.sub(
                    b'type=application/prs\\.blog\\+json>([^<]+)</script>',
                    (lambda match: replacer(match, cont)), cont)
                file.write(cont)
    for level in pathlib.Path('tutorials').iterdir():
        for chapter in level.iterdir():
            print(chapter)

    pass


def replacer(match, _html):
    # return match.group(0)
    inner_content = json.loads(match.group(1))  # , indent=2
    inner_content['content-type'] = 'text/html'
    inner_content['buildTimeMS'] = floor(time.time()) * 1000
    modified_content = json.dumps(inner_content, indent=2).replace('<', '\\u003c').encode('utf8')
    return b'type=application/prs.blog+json>' + modified_content + b'</script>'


if __name__ == '__main__':
    main()
pass
