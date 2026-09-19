<?php
/**
 * Merge all default content trees.
 *
 * @package Growtele
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load defaults from a file under defaults/.
 *
 * @param string $file Basename without extension.
 * @return array
 */
function growtele_content_load_defaults_file( $file ) {
	$path = GROWTELE_DIR . '/inc/content/defaults/' . $file . '.php';
	if ( ! is_readable( $path ) ) {
		return array();
	}
	$data = include $path;
	return is_array( $data ) ? $data : array();
}

/**
 * Full default content structure for growtele_content_v1.
 *
 * @return array
 */
function growtele_content_get_defaults() {
	static $defaults = null;

	if ( null !== $defaults ) {
		return $defaults;
	}

	$defaults = array(
		'schema_version' => GROWTELE_CONTENT_SCHEMA_VERSION,
		'global'         => growtele_content_load_defaults_file( 'global' ),
		'footer'         => growtele_content_load_defaults_file( 'footer' ),
		'shared'         => growtele_content_load_defaults_file( 'shared' ),
		'home'           => growtele_content_load_defaults_file( 'home' ),
		'products'       => growtele_content_load_defaults_file( 'products' ),
		'industries'     => growtele_content_load_defaults_file( 'industries' ),
		'company'        => growtele_content_load_defaults_file( 'company' ),
		'media'          => growtele_content_load_defaults_file( 'media' ),
	);

	/**
	 * Filter default Growtele CMS content.
	 *
	 * @param array $defaults Defaults tree.
	 */
	$defaults = apply_filters( 'growtele_content_defaults', $defaults );

	return $defaults;
}
