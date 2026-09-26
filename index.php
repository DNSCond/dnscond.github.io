<?php use function ANTHeader\create_head3;

require_once "{$_SERVER['DOCUMENT_ROOT']}/require/header3/head3.php";
create_head3($title = 'DNSCond\'s Github pages', [
        'siteOverride' => "https://dnscond.github.io", 'noVent' => true,
        'base' => ("{$_GET['isntLocalhost']}") ? '/' : '/dnscond.github.io/', 'bread' => [
                ['text' => 'DNSCond.Github.io', 'href' => 'https://dnscond.github.io'],
        ], 'localhostIconOverride' => '/dnscond.github.io/favicon.ico',
        'canonical' => 'https://dnscond.github.io/',
        'stylelinks' => ['style.css'],
]) ?>
<div class=divs>
    <h1><?= $title ?></h1>
    <p>Things i made
    <ul>
        <li><a referrerpolicy=no-referrer
               href='https://antrequest.nl/hstspreloadhistory/'
            >HSTS Preload List History Viewer</a>. Manually updated. <a
                    href=https://github.com/DNSCond/hstspreloadhistory
                    referrerpolicy=no-referrer>GitHub Repository</a>.
        <li><a referrerpolicy=no-referrer href='https://antrequest.nl/'
            >Character gallery</a>. Manually updated. <a
                    href=https://github.com/DNSCond/gallery
                    referrerpolicy=no-referrer>GitHub Repository</a>.
        <li><a referrerpolicy=no-referrer href=topng/index.html>PNG Converter</a>.</li>
    </ul>
</div>
