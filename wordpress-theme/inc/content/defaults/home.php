<?php
/**
 * Home defaults loader.
 *
 * @package Growtele
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$path = GROWTELE_DIR . '/inc/content/defaults/home-data.php';
if ( ! is_readable( $path ) ) {
	return array();
}

$data = include $path;
return is_array( $data ) ? $data : array();
