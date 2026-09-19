<?php
/**
 * Growtele Theme Functions
 *
 * @package Growtele
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GROWTELE_VERSION', '2.10.89' );
define( 'GROWTELE_DIR', get_template_directory() );
define( 'GROWTELE_URI', get_template_directory_uri() );

$growtele_includes = array(
	'/inc/theme-setup.php',
	'/inc/enqueue.php',
	'/inc/elementor.php',
	'/inc/customizer.php',
	'/inc/content/loader.php',
	'/inc/template-tags.php',
	'/inc/static-pages.php',
	'/inc/theme-activation.php',
);

foreach ( $growtele_includes as $growtele_include ) {
	$growtele_file = GROWTELE_DIR . $growtele_include;
	if ( is_readable( $growtele_file ) ) {
		require $growtele_file;
	}
}
