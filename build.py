import requests, pathlib


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
    pass


if __name__ == '__main__':
    main()
pass
