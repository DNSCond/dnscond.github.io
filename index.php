<?php use function ANTHeader\create_head3;

require_once "{$_SERVER['DOCUMENT_ROOT']}/require/header3/head3.php";
create_head3($title = 'DNSCond\'s Github pages', [
        'siteOverride' => "https://dnscond.github.io", 'noVent' => true,
        'base' => ("{$_GET['toGithub']}") ? '/' : '/dnscond.github.io/', 'bread' => [
                ['text' => 'DNSCond.Github.io', 'href' => 'https://dnscond.github.io']
        ], 'localhostIconOverride' => '/dnscond.github.io/favicon.ico',
]) ?>
<div class=divs>
    <h1><?= $title ?></h1>
    <p>Under Construction.
</div>
