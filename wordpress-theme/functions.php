<?php
/**
 * Growtele Theme Functions
 *
 * @package Growtele
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GROWTELE_VERSION', '2.7.7' );
define( 'GROWTELE_DIR', get_template_directory() );
define( 'GROWTELE_URI', get_template_directory_uri() );

require GROWTELE_DIR . '/inc/theme-setup.php';
require GROWTELE_DIR . '/inc/enqueue.php';
require GROWTELE_DIR . '/inc/elementor.php';
require GROWTELE_DIR . '/inc/customizer.php';
require GROWTELE_DIR . '/inc/template-tags.php';
require GROWTELE_DIR . '/inc/static-pages.php';
require GROWTELE_DIR . '/inc/theme-activation.php';
