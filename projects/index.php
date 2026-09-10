<?php use function ANTHeader\create_head3;

require_once "{$_SERVER['DOCUMENT_ROOT']}/require/header3/head3.php";
create_head3($title = 'DNSCond\'s Github pages', [
        'siteOverride' => "https://dnscond.github.io", 'noVent' => true,
        'base' => ("{$_GET['toGithub']}") ? '/' : '/dnscond.github.io/', 'bread' => [
                ['text' => 'DNSCond.Github.io', 'href' => 'https://dnscond.github.io'],
                ['text' => 'DNSCond\'s Projects', 'href' => 'https://dnscond.github.io/projects/'],
        ], 'localhostIconOverride' => '/dnscond.github.io/favicon.ico',
        'canonical' => 'https://dnscond.github.io/',
        'stylelinks' => ['style.css'],
]) ?>
<div class=divs>
    <h1><?= $title ?></h1>
    <p>To Do: Fix Projects page</p>
    <!--<?= 'TEMPLATE-SPOT-->';
    echo '</div>';
    return;
    ob_start() ?>-->
    <TEMPLATE shadowrootmode=open>
        <details>
            <summary>
                <slot name=title>Project Title</slot>
            </summary>
            <slot name=desc>Project Description</slot>
        </details>
        <!--<div><slot name=links>Project Links</slot></div>-->
    </TEMPLATE><?= "<!--TEMPLATE-END-->";
    $template = "\x3c!--TEMPLATE-START" . preg_replace('/\\s+/', ' ', ob_get_clean());
    echo '<div class=sans-serif>';
    function mkHTMLFromJSON(mixed $desc): string
    {
        $result = "<$desc[0]";
        foreach ($desc[1] as $name => $value) {
            $result .= "\x20$name=\"$value\"";
        }
        $result .= ">";
        foreach ($desc as $pos => $val) {
            if ($pos == 0 || $pos == 1) continue;
            $result .= is_string($val) ? $val : mkHTMLFromJSON($val);
        }
        return "$result</$desc[0]>";
    }

    foreach (json_decode(file_get_contents(__DIR__ . '/../data.json'), true)['entries'] as $item) {
        echo "<PROJECT-LI>$template<span slot=title>{$item['title']}</span>\n" . mkHTMLFromJSON($item['desc']) . "</PROJECT-LI>";
    }
    echo '</div>' ?></div>
