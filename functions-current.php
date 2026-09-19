<?php
/**
 * Growtele Theme Functions - WordPress Safe Version
 *
 * @package Growtele
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Theme constants
define( 'GROWTELE_VERSION', '2.10.73' );
define( 'GROWTELE_DIR', get_template_directory() );
define( 'GROWTELE_URI', get_template_directory_uri() );

/**
 * Theme Setup
 */
function growtele_theme_setup() {
	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails
	add_theme_support( 'post-thumbnails' );

	// Enable support for responsive embeds
	add_theme_support( 'responsive-embeds' );

	// Enable support for custom logo
	add_theme_support( 'custom-logo', array(
		'height'      => 50,
		'width'       => 196,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	// Register navigation menus
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'growtele' ),
		'footer'  => esc_html__( 'Footer Menu', 'growtele' ),
	) );

	// Switch default core markup to output valid HTML5
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	) );

	// Add theme support for selective refresh for widgets
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add support for full and wide align images
	add_theme_support( 'align-wide' );

	// Add support for editor styles
	add_theme_support( 'editor-styles' );

	// Custom image sizes
	add_image_size( 'growtele-hero', 1920, 1080, true );
	add_image_size( 'growtele-card', 800, 600, true );
	add_image_size( 'growtele-thumb', 400, 300, true );
}
add_action( 'after_setup_theme', 'growtele_theme_setup' );

/**
 * Set the content width in pixels
 */
function growtele_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'growtele_content_width', 1200 );
}
add_action( 'after_setup_theme', 'growtele_content_width', 0 );

/**
 * Register widget areas
 */
function growtele_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'growtele' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'growtele' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget Area', 'growtele' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Footer widget area.', 'growtele' ),
		'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="footer-widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'growtele_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function growtele_enqueue_assets() {
	// Google Fonts
	wp_enqueue_style(
		'growtele-tomato-grotesk',
		'https://api.fontshare.com/v2/css?f[]=tomato-grotesk@400,500,600,700,800&display=swap',
		array(),
		null
	);

	// Main stylesheet
	wp_enqueue_style(
		'growtele-style',
		get_stylesheet_uri(),
		array(),
		GROWTELE_VERSION
	);

	// Theme styles
	$styles = array(
		'growtele-global'     => '/assets/css/global.css',
		'growtele-header'     => '/assets/css/header.css',
		'growtele-hero'       => '/assets/css/hero.css',
		'growtele-services'   => '/assets/css/services.css',
		'growtele-about'      => '/assets/css/about.css',
		'growtele-footer'     => '/assets/css/footer.css',
		'growtele-responsive' => '/assets/css/responsive.css',
	);

	foreach ( $styles as $handle => $path ) {
		$file_path = GROWTELE_DIR . $path;
		if ( file_exists( $file_path ) ) {
			wp_enqueue_style(
				$handle,
				GROWTELE_URI . $path,
				array( 'growtele-tomato-grotesk' ),
				GROWTELE_VERSION
			);
		}
	}

	// Mobile responsive styles
	$mobile_css = GROWTELE_DIR . '/assets/css/responsive-mobile.css';
	if ( file_exists( $mobile_css ) ) {
		wp_enqueue_style(
			'growtele-responsive-mobile',
			GROWTELE_URI . '/assets/css/responsive-mobile.css',
			array( 'growtele-style' ),
			GROWTELE_VERSION
		);
	}

	// Scripts
	wp_enqueue_script(
		'growtele-main',
		GROWTELE_URI . '/assets/js/main.js',
		array( 'jquery' ),
		GROWTELE_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'growtele_enqueue_assets' );

/**
 * Customizer additions
 */
function growtele_customize_register( $wp_customize ) {
	$wp_customize->add_section( 'growtele_theme_options', array(
		'title'    => esc_html__( 'Growtele Options', 'growtele' ),
		'priority' => 30,
	) );

	$wp_customize->add_setting( 'growtele_cta_text', array(
		'default'           => esc_html__( "Let's Get Started", 'growtele' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'growtele_cta_text', array(
		'label'   => esc_html__( 'Header CTA Text', 'growtele' ),
		'section' => 'growtele_theme_options',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'growtele_cta_url', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( 'growtele_cta_url', array(
		'label'   => esc_html__( 'Header CTA URL', 'growtele' ),
		'section' => 'growtele_theme_options',
		'type'    => 'url',
	) );
}
add_action( 'customize_register', 'growtele_customize_register' );

/**
 * Load additional theme files if they exist
 */
$growtele_includes = array(
	'/inc/template-tags.php',
	'/inc/static-pages.php',
	'/inc/theme-activation.php',
);

foreach ( $growtele_includes as $growtele_include ) {
	$growtele_file = GROWTELE_DIR . $growtele_include;
	if ( file_exists( $growtele_file ) && is_readable( $growtele_file ) ) {
		require_once $growtele_file;
	}
}
