<?php use function ANTHeader\create_head3;

require_once "{$_SERVER['DOCUMENT_ROOT']}/require/header3/head3.php";
create_head3($title = 'Convert Any Image File To Image/PNG if they are supported (renderable by your browser)', [
        'siteOverride' => "https://dnscond.github.io", 'noVent' => true,
        'base' => ("{$_GET['isntLocalhost']}") ? '/' : '/dnscond.github.io/', 'bread' => [
                ['text' => 'DNSCond.Github.io', 'href' => 'https://dnscond.github.io'],
                ['text' => 'To PNG', 'href' => '/topng/'],
        ], 'localhostIconOverride' => '/dnscond.github.io/favicon.ico',
        'canonical' => '/topng/', 'stylelinks' => ['style.css'],
]) ?>
<div class=divs>
    <h1><?= $title ?></h1>
    <label>File to convert to png: <input type=file accept=image/*></label>
    <button type=submit>convert in browser</button>
    <noscript>please enable javascript</noscript>
    <a class=a hidden>Download</a>
    <ol></ol>
    <script type=module>
        const input = document.querySelector('input[type=file]'),
            a = document.querySelector('a.a'), ol = document.querySelector('ol');
        document.querySelector('button[type=submit]').addEventListener('click',
            () => createImageBitmap(input.files[0]).then(imageBitmap => {
                const offscreenCanvas = new OffscreenCanvas(imageBitmap.width, imageBitmap.height),
                    ctx = offscreenCanvas.getContext("2d");
                ctx.drawImage(imageBitmap, 0, 0, imageBitmap.width, imageBitmap.height);
                return offscreenCanvas.convertToBlob();
            }).then(blob => {
                a.download = Date();
                const blobHref = URL.createObjectURL(blob);
                a.href = blobHref;
                a.click();
                return new Promise(resolve => setTimeout(resolve, 5000)).then(() => blobHref);
            }).then(URL.revokeObjectURL).catch(error => ol.append(Object.assign(document.createElement('li'), {textContent: String(error),})),));
    </script>
</div>
