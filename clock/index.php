<?php use function ANTHeader\create_head3;

require_once "{$_SERVER['DOCUMENT_ROOT']}/require/header3/head3.php";
create_head3($title = 'DNSCond\'s Clock Api Docs', [
        'siteOverride' => "https://dnscond.github.io", 'noVent' => true,
        'base' => ("{$_GET['isntLocalhost']}") ? '/clock/' : '/dnscond.github.io/clock/', 'bread' => [
                ['text' => 'DNSCond.Github.io', 'href' => 'https://dnscond.github.io'],
                ['text' => $title, 'href' => '/clock/'],
        ], 'localhostIconOverride' => '/dnscond.github.io/favicon.ico',
        'canonical' => 'https://dnscond.github.io/clock/',
]);
header_remove('content-security-policy'); ?>
<div class=divs>
    <h1><?= $title ?></h1>
    <script type=module src=index.js></script>
    <favicond-svgclock datetime=2026-09-19T19:12:06Z autoupdate with-milliseconds></favicond-svgclock>
</div>
