<?php
/**
 * Theme setup and supports
 *
 * @package Growtele
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register theme supports, menus, and image sizes.
 */
if ( ! function_exists( 'growtele_theme_setup' ) ) {
function growtele_theme_setup() {
	load_theme_textdomain( 'growtele', GROWTELE_DIR . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'elementor' );

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 50,
			'width'       => 196,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'growtele' ),
			'footer'  => esc_html__( 'Footer Menu', 'growtele' ),
		)
	);

	add_image_size( 'growtele-hero', 1920, 1080, true );
	add_image_size( 'growtele-card', 800, 600, true );
	add_image_size( 'growtele-thumb', 400, 300, true );
}
add_action( 'after_setup_theme', 'growtele_theme_setup' );
}

/**
 * Set content width for Elementor and media.
 */
function growtele_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'growtele_content_width', 1200 );
}
add_action( 'after_setup_theme', 'growtele_content_width', 0 );

/**
 * Register widget areas.
 */
function growtele_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'growtele' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Main sidebar widget area.', 'growtele' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Widget Area', 'growtele' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Footer widget area.', 'growtele' ),
			'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="footer-widget-title">',
			'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'growtele_widgets_init' );

/**
 * Add homepage body classes for smooth scroll.
 *
 * @param string[] $classes Body classes.
 * @return string[]
 */
function growtele_body_classes( $classes ) {
	if ( is_front_page() && ! growtele_is_elementor_page() ) {
		$classes[] = 'gt-smooth-scroll';
	}

	return $classes;
}
add_filter( 'body_class', 'growtele_body_classes' );
