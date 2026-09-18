<?php use function ANTHeader\create_head3;

// it is assumed this page only runs at build time in a trusted environment.
global $title, $datetime;
$basename = basename($_SERVER['SCRIPT_NAME'], '.php');
require_once "{$_SERVER['DOCUMENT_ROOT']}/require/header3/head3.php";
create_head3("$title | DNSCond Articles", [
    'siteOverride' => "https://dnscond.github.io", 'noVent' => true,
    'base' => ("{$_GET['isntLocalhost']}") ? '/' : '/dnscond.github.io/', 'bread' => [
        ['text' => 'DNSCond.Github.io', 'href' => 'https://dnscond.github.io'],
        ['text' => 'DNSCond Articles', 'href' => '/blog/'],
        ['text' => $title, 'href' => "/blog/$basename.html"],
    ], 'localhostIconOverride' => '/dnscond.github.io/favicon.ico',
    'canonical' => "https://dnscond.github.io/blog/$basename.html",
    'stylelinks' => ['style.css'],
]);
$json = json_encode(['title' => $title, 'datetimeMS' => strtotime($datetime) * 1000,
    'content-type' => 'application/x-httpd-php'], JSON_HEX_TAG);
echo "<script type=application/prs.blog+json>$json</script>\n";
