<?php
/**
 * Elementor compatibility (lazy-loaded after Elementor boots).
 *
 * @package Growtele
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Elementor hooks only when Elementor is active.
 */
function growtele_bootstrap_elementor() {
	if ( ! did_action( 'elementor/loaded' ) || ! class_exists( '\Elementor\Plugin' ) ) {
		return;
	}

	add_action( 'elementor/theme/register_locations', 'growtele_register_elementor_locations' );
	add_action( 'elementor/elements/categories_registered', 'growtele_add_elementor_widget_categories' );
	add_action( 'elementor/editor/after_enqueue_styles', 'growtele_elementor_editor_styles' );
	add_action( 'after_setup_theme', 'growtele_elementor_theme_support', 20 );
}
add_action( 'plugins_loaded', 'growtele_bootstrap_elementor', 20 );

/**
 * Register Elementor theme locations when Theme Builder is available.
 *
 * @param mixed $elementor_theme_manager Theme manager instance.
 */
function growtele_register_elementor_locations( $elementor_theme_manager ) {
	if ( ! is_object( $elementor_theme_manager ) ) {
		return;
	}

	if ( method_exists( $elementor_theme_manager, 'register_all_core_location' ) ) {
		$elementor_theme_manager->register_all_core_location();
	}
}

/**
 * Add Elementor theme support.
 */
function growtele_elementor_theme_support() {
	add_theme_support( 'elementor' );
}

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
 * @param int|null $post_id Optional post ID.
 * @return bool
 */
function growtele_is_elementor_page( $post_id = null ) {
	if ( ! did_action( 'elementor/loaded' ) || ! class_exists( '\Elementor\Plugin' ) ) {
		return false;
	}

	$post_id = $post_id ? (int) $post_id : (int) get_the_ID();
	if ( ! $post_id ) {
		return false;
	}

	$plugin = \Elementor\Plugin::$instance;
	if ( ! is_object( $plugin ) ) {
		return 'builder' === get_post_meta( $post_id, '_elementor_edit_mode', true );
	}

	if ( isset( $plugin->documents ) && is_object( $plugin->documents ) && method_exists( $plugin->documents, 'get' ) ) {
		$document = $plugin->documents->get( $post_id );
		if ( $document && method_exists( $document, 'is_built_with_elementor' ) ) {
			return (bool) $document->is_built_with_elementor();
		}
	}

	if ( isset( $plugin->db ) && is_object( $plugin->db ) && method_exists( $plugin->db, 'is_built_with_elementor' ) ) {
		return (bool) $plugin->db->is_built_with_elementor( $post_id );
	}

	return 'builder' === get_post_meta( $post_id, '_elementor_edit_mode', true );
}

/**
 * Register custom Elementor widget category.
 *
 * @param mixed $elements_manager Elements manager.
 */
function growtele_add_elementor_widget_categories( $elements_manager ) {
	if ( ! is_object( $elements_manager ) || ! method_exists( $elements_manager, 'add_category' ) ) {
		return;
	}

	$elements_manager->add_category(
		'growtele',
		array(
			'title' => esc_html__( 'Growtele Sections', 'growtele' ),
			'icon'  => 'fa fa-plug',
		)
	);
}

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
