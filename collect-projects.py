from html.parser import HTMLParser
import markdown, pathlib, json


class HTMLToJSONMLParser(HTMLParser):
    def __init__(self):
        super().__init__()
        self.stack = []
        self.root = None

    def handle_starttag(self, tag, attrs):
        # Convert attribute list [(key, val)] into a dictionary
        attr_dict = {k: v for k, v in attrs if v is not None}

        # Create JSONML element structure: [tagname, attrs_dict]
        element = [tag.lower()]
        if attr_dict:
            # noinspection bad-argument-type
            element.append(attr_dict)
        else:
            # noinspection bad-argument-type
            element.append(dict())

        if not self.stack:
            self.root = element
        else:
            self.stack[-1].append(element)

        self.stack.append(element)

    def handle_endtag(self, tag):
        if self.stack:
            self.stack.pop()

    def handle_data(self, data):
        # Strip whitespace-only text nodes
        cleaned_text = data  # .strip()
        if cleaned_text and self.stack:
            self.stack[-1].append(cleaned_text)


def html_to_jsonml(html_string):
    parser = HTMLToJSONMLParser()
    parser.feed(html_string)
    return parser.root


def md_to_html_to_json(gfm_text: str):
    html_output = markdown.markdown(
        gfm_text,
        extensions=[
            'tables',
            'fenced_code',
            'pymdownx.tilde',  # For strikethrough (~~text~~ or ~text~)
            'pymdownx.tasklist',  # For task lists (- [x])
            'pymdownx.superfences'  # For enhanced code blocks
        ]
    )

    return html_to_jsonml(f"<div>{html_output}</div>")


def main():
    array = [
        r"D:\var\www\BOTs\devvit-tester\autoban-ext",
        r"D:\var\www\BOTs\devvit-tester\texthelpermd"
    ]
    rt_data = dict(entries=list())
    for li in array:
        result = dict()
        path = pathlib.Path(li)
        # noinspection unresolved-references
        with open(path / 'README.md', 'rt', encoding='utf8') as file:
            ht_data = md_to_html_to_json(file.read())
            for dt in ht_data[2:]:
                if dt[0] == "h1":
                    result['title'] = ''.join(dt[2:])
            # ht_data[1]['class'] = 'sans-serif'
            ht_data[1]['slot'] = 'desc'
            ht_data[0] = 'article'
            result['desc'] = ht_data
        rt_data['entries'].append(result)

    with open('data.json', 'wt', encoding='utf8') as file:
        file.write(json.dumps(rt_data, indent=2))


if __name__ == '__main__':
    main()
pass
