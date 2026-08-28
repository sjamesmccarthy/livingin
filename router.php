<?php

/**
 * Router for `php -S localhost:3006 router.php`, mapping the hyphenated
 * public URLs (matching the source Next.js site) to this repo's directory
 * names (e.g. /carson-city -> /carsoncity/index.php).
 */

$map = [
    '/northern-nevada-city-guides' => '/index.php',

    '/dayton' => '/dayton/index.php',
    '/dayton/dayton-valley' => '/dayton/dayton-valley/index.php',
    '/dayton/santa-maria-ranch' => '/dayton/santa-maria-ranch/index.php',
    '/dayton/new-empire' => '/dayton/new-empire/index.php',
    '/dayton/sutro-heights' => '/dayton/sutro-heights/index.php',
    '/dayton/riverpark' => '/dayton/riverpark/index.php',
    '/washoe-valley' => '/washoe-valley/index.php',
    '/incline-village' => '/incline-village/index.php',
    '/spanish-springs' => '/spanish-springs/index.php',
    '/verdi' => '/verdi/index.php',
    '/fernley' => '/fernley/index.php',
    '/yerington' => '/yerington/index.php',
    '/smith-valley' => '/smith-valley/index.php',
];

$path = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$path = $path === '' ? '/' : $path;

if (isset($map[$path])) {
    require __DIR__ . $map[$path];
    return true;
}

$file = __DIR__ . $path;
if ($path !== '/' && file_exists($file) && !is_dir($file)) {
    return false; // serve the requested static asset as-is
}

require __DIR__ . '/index.php';
