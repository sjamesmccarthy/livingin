<?php

// Serves a Markdown copy of a page for `Accept: text/markdown` requests
// (see .htaccess). Fetches the HTML page from this same host and converts it.
require_once __DIR__ . '/config.php';

$path = '/' . ltrim((string)($_GET['path'] ?? ''), '/');
if (strpos($path, '..') !== false || preg_match('#^/(assets|includes|\.)#', $path)) { http_response_code(404); exit('Not found'); }

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$origin = $scheme . '://' . $_SERVER['HTTP_HOST'];
$ctx = stream_context_create(['http' => ['header' => "Accept: text/html\r\nX-MD-Internal: 1\r\n", 'timeout' => 10, 'ignore_errors' => true, 'follow_location' => 1]]);
$html = @file_get_contents($origin . $path, false, $ctx);
$status = 200;
foreach (($http_response_header ?? []) as $h) if (preg_match('#^HTTP/\S+ (\d+)#', $h, $mm)) $status = (int)$mm[1];
if ($html === false || $status >= 400) { http_response_code($status >= 400 ? $status : 502); exit('Not available'); }

libxml_use_internal_errors(true);
$doc = new DOMDocument();
$doc->loadHTML('<?xml encoding="utf-8"?>' . $html);
$xp = new DOMXPath($doc);
foreach ($xp->query('//script|//style|//noscript|//svg|//header|//footer|//nav|//form|//button|//iframe|//*[@id="mobile-menu"]|//*[contains(@class,"site-header")]') as $n) $n->parentNode->removeChild($n);
$title = trim($doc->getElementsByTagName('title')->item(0)->textContent ?? '');
$root = $doc->getElementsByTagName('body')->item(0);

function md_inline(DOMNode $n): string
{
    $s = '';
    foreach ($n->childNodes as $c) {
        if ($c->nodeType === XML_TEXT_NODE) { $s .= preg_replace('/\s+/', ' ', $c->textContent); continue; }
        if ($c->nodeType !== XML_ELEMENT_NODE) continue;
        $t = strtolower($c->nodeName);
        $inner = md_inline($c);
        if ($t === 'a' && $c->getAttribute('href') !== '') $s .= '[' . trim($inner) . '](' . $c->getAttribute('href') . ')';
        elseif ($t === 'strong' || $t === 'b') $s .= '**' . trim($inner) . '**';
        elseif ($t === 'em' || $t === 'i') $s .= '*' . trim($inner) . '*';
        elseif ($t === 'br') $s .= "\n";
        elseif ($t === 'img') continue;
        else $s .= $inner;
    }
    return $s;
}

function md_block(DOMNode $n): string
{
    $out = '';
    foreach ($n->childNodes as $c) {
        if ($c->nodeType === XML_TEXT_NODE) { $x = trim(preg_replace('/\s+/', ' ', $c->textContent)); if ($x !== '') $out .= $x . "\n\n"; continue; }
        if ($c->nodeType !== XML_ELEMENT_NODE) continue;
        $t = strtolower($c->nodeName);
        if (preg_match('/^h([1-6])$/', $t, $m)) { $x = trim(md_inline($c)); if ($x !== '') $out .= str_repeat('#', (int)$m[1]) . ' ' . $x . "\n\n"; }
        elseif ($t === 'p') { $x = trim(md_inline($c)); if ($x !== '') $out .= $x . "\n\n"; }
        elseif ($t === 'ul' || $t === 'ol') {
            $i = 1;
            foreach ($c->childNodes as $li) {
                if (strtolower($li->nodeName) !== 'li') continue;
                $x = trim(preg_replace('/\s+/', ' ', md_inline($li)));
                if ($x !== '') $out .= ($t === 'ol' ? ($i++) . '. ' : '- ') . $x . "\n";
            }
            $out .= "\n";
        }
        elseif ($t === 'a' || $t === 'span' || $t === 'strong' || $t === 'em') { $x = trim(md_inline($c)); if ($x !== '') $out .= $x . "\n\n"; }
        else $out .= md_block($c);
    }
    return $out;
}

$md = ($title !== '' ? "# $title\n\n" : '') . 'Source: ' . $origin . $path . "\n\n" . trim(preg_replace("/\n{3,}/", "\n\n", md_block($root))) . "\n";
header('Content-Type: text/markdown; charset=utf-8');
header('Vary: Accept');
echo $md;
