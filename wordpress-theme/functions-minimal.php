<?php
/**
 * Growtele Theme Functions - Minimal WordPress Version
 *
 * @package Growtele
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GROWTELE_VERSION', '2.10.73' );
define( 'GROWTELE_DIR', get_template_directory() );
define( 'GROWTELE_URI', get_template_directory_uri() );

/**
 * Theme Setup
 */
function growtele_theme_setup() {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'align-wide' );
	
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'growtele' ),
		'footer'  => esc_html__( 'Footer Menu', 'growtele' ),
	) );
}
add_action( 'after_setup_theme', 'growtele_theme_setup' );

/**
 * Enqueue styles
 */
function growtele_enqueue_assets() {
	wp_enqueue_style( 'growtele-style', get_stylesheet_uri(), array(), GROWTELE_VERSION );
}
add_action( 'wp_enqueue_scripts', 'growtele_enqueue_assets' );

/**
 * Register widget areas
 */
function growtele_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'growtele' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'growtele_widgets_init' );
