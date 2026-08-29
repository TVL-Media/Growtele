<?php
/**
 * Elementor compatibility
 *
 * @package Growtele
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Elementor theme locations.
 *
 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager Theme manager.
 */
function growtele_register_elementor_locations( $elementor_theme_manager ) {
	$elementor_theme_manager->register_all_core_location();
}
add_action( 'elementor/theme/register_locations', 'growtele_register_elementor_locations' );

/**
 * Add Elementor kit support and disable default colors/fonts conflict.
 */
function growtele_elementor_setup() {
	if ( ! did_action( 'elementor/loaded' ) ) {
		return;
	}

	add_theme_support( 'elementor' );
}
add_action( 'after_setup_theme', 'growtele_elementor_setup' );

/**
 * Set Elementor defaults on theme activation.
 */
function growtele_elementor_activation() {
	if ( ! did_action( 'elementor/loaded' ) ) {
		return;
	}

	update_option( 'elementor_disable_color_schemes', 'yes' );
	update_option( 'elementor_disable_typography_schemes', 'yes' );
	update_option( 'elementor_container_width', '1200' );
}
add_action( 'after_switch_theme', 'growtele_elementor_activation' );

/**
 * Check if current page is built with Elementor.
 *
 * @return bool
 */
function growtele_is_elementor_page() {
	if ( ! did_action( 'elementor/loaded' ) ) {
		return false;
	}

	$post_id = get_the_ID();
	if ( ! $post_id ) {
		return false;
	}

	return \Elementor\Plugin::$instance->db->is_built_with_elementor( $post_id );
}

/**
 * Register custom Elementor widget category.
 *
 * @param Elementor\Elements_Manager $elements_manager Elements manager.
 */
function growtele_add_elementor_widget_categories( $elements_manager ) {
	$elements_manager->add_category(
		'growtele',
		array(
			'title' => esc_html__( 'Growtele Sections', 'growtele' ),
			'icon'  => 'fa fa-plug',
		)
	);
}
add_action( 'elementor/elements/categories_registered', 'growtele_add_elementor_widget_categories' );

/**
 * Enqueue Elementor editor styles for design tokens preview.
 */
function growtele_elementor_editor_styles() {
	wp_enqueue_style(
		'growtele-elementor-editor',
		GROWTELE_URI . '/assets/css/global.css',
		array(),
		GROWTELE_VERSION
	);
}
add_action( 'elementor/editor/after_enqueue_styles', 'growtele_elementor_editor_styles' );
