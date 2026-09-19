<?php
/**
 * Enqueue scripts and styles
 *
 * @package Growtele
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register and enqueue front-end assets.
 */
if ( ! function_exists( 'growtele_enqueue_assets' ) ) {
function growtele_enqueue_assets() {
	if ( is_page() && function_exists( 'growtele_static_page_map' ) ) {
		$slug  = get_post_field( 'post_name', get_queried_object_id() );
		$pages = growtele_static_page_map();

		if ( isset( $pages[ $slug ] ) ) {
			return;
		}
	}

	wp_enqueue_style(
		'growtele-tomato-grotesk',
		'https://api.fontshare.com/v2/css?f[]=tomato-grotesk@400,500,600,700,800&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'lenis',
		'https://cdn.jsdelivr.net/npm/lenis@1.1.18/dist/lenis.css',
		array(),
		'1.1.18'
	);

	$styles = array(
		'growtele-global'     => '/assets/css/global.css',
		'growtele-header'     => '/assets/css/header.css',
		'growtele-hero'       => '/assets/css/hero.css',
		'growtele-services'   => '/assets/css/services.css',
		'growtele-about'      => '/assets/css/about.css',
		'growtele-footer'     => '/assets/css/footer.css',
		'growtele-responsive' => '/assets/css/responsive.css',
		'growtele-snap-scroll'=> '/assets/css/snap-scroll.css',
	);

	foreach ( $styles as $handle => $path ) {
		$deps = array( 'growtele-tomato-grotesk' );
		if ( 'growtele-snap-scroll' === $handle ) {
			$deps[] = 'lenis';
		}

		wp_enqueue_style(
			$handle,
			GROWTELE_URI . $path,
			$deps,
			GROWTELE_VERSION
		);
	}

	if ( ! is_front_page() ) {
		wp_enqueue_style(
			'growtele-sms-nav',
			GROWTELE_URI . '/pages/sms/css/sms-nav.css',
			array( 'growtele-header' ),
			GROWTELE_VERSION
		);
	}

	wp_enqueue_style(
		'growtele-style',
		get_stylesheet_uri(),
		array( 'growtele-global' ),
		GROWTELE_VERSION
	);

	wp_enqueue_style(
		'growtele-responsive-mobile',
		GROWTELE_URI . '/assets/css/responsive-mobile.css',
		array( 'growtele-style' ),
		GROWTELE_VERSION
	);

	wp_enqueue_script(
		'growtele-resolve-asset',
		GROWTELE_URI . '/assets/js/resolve-asset-url.js',
		array(),
		GROWTELE_VERSION,
		array(
			'in_footer' => false,
			'strategy'  => 'defer',
		)
	);

	wp_add_inline_script(
		'growtele-resolve-asset',
		'window.GROWTELE_THEME_URI=' . wp_json_encode( untrailingslashit( GROWTELE_URI ) ) . ';',
		'before'
	);

	wp_enqueue_script(
		'growtele-image-performance',
		GROWTELE_URI . '/assets/js/image-performance.js',
		array( 'growtele-resolve-asset' ),
		GROWTELE_VERSION,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);

	wp_enqueue_script(
		'lenis',
		'https://cdn.jsdelivr.net/npm/lenis@1.1.18/dist/lenis.min.js',
		array(),
		'1.1.18',
		true
	);

	wp_enqueue_script(
		'gsap',
		'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.7/gsap.min.js',
		array(),
		'3.12.7',
		true
	);

	wp_enqueue_script(
		'gsap-scrolltrigger',
		'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.7/ScrollTrigger.min.js',
		array( 'gsap' ),
		'3.12.7',
		true
	);

	wp_enqueue_script(
		'growtele-smooth-scroll',
		GROWTELE_URI . '/assets/js/smooth-scroll.js',
		array( 'lenis', 'gsap-scrolltrigger' ),
		GROWTELE_VERSION,
		true
	);

	wp_enqueue_script(
		'growtele-channels-cards',
		GROWTELE_URI . '/assets/js/channels-cards.js',
		array( 'gsap', 'gsap-scrolltrigger', 'growtele-smooth-scroll' ),
		GROWTELE_VERSION,
		true
	);

	wp_enqueue_script(
		'growtele-industries-scroll',
		GROWTELE_URI . '/assets/js/industries-scroll.js',
		array( 'growtele-smooth-scroll' ),
		GROWTELE_VERSION,
		true
	);

	wp_enqueue_script(
		'growtele-nav-current',
		GROWTELE_URI . '/assets/js/nav-current.js',
		array(),
		GROWTELE_VERSION,
		true
	);

	wp_enqueue_script(
		'growtele-main',
		GROWTELE_URI . '/assets/js/main.js',
		array( 'growtele-smooth-scroll', 'growtele-nav-current' ),
		GROWTELE_VERSION,
		true
	);

	wp_enqueue_script(
		'growtele-animations',
		GROWTELE_URI . '/assets/js/animations.js',
		array( 'growtele-smooth-scroll', 'growtele-main' ),
		GROWTELE_VERSION,
		true
	);

	wp_localize_script(
		'growtele-main',
		'growteleData',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'themeUri' => GROWTELE_URI,
			'homeUrl'  => home_url( '/' ),
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'growtele_enqueue_assets' );
}

/**
 * Remove plugin/block assets not used on the theme front page.
 */
function growtele_dequeue_unused_front_page_assets() {
	if ( ! is_front_page() || ( function_exists( 'growtele_is_elementor_page' ) && growtele_is_elementor_page() ) ) {
		return;
	}

	$style_handles = array(
		'wp-block-library',
		'classic-theme-styles',
		'global-styles',
		'hostinger-reach-subscription-block',
		'gutenverse-google-font',
		'fontawesome-gutenverse',
		'gutenverse-iconlist',
	);

	global $wp_styles;

	if ( $wp_styles && ! empty( $wp_styles->registered ) ) {
		foreach ( $wp_styles->registered as $handle => $style ) {
			if ( 0 === strpos( $handle, 'gutenverse-form-frontend-form-' ) ) {
				$style_handles[] = $handle;
			}
		}
	}

	foreach ( array_unique( $style_handles ) as $handle ) {
		wp_dequeue_style( $handle );
		wp_deregister_style( $handle );
	}

	wp_dequeue_script( 'hostinger-reach-subscription-block-view' );
	wp_dequeue_script( 'gutenverse-frontend-event' );
}
add_action( 'wp_enqueue_scripts', 'growtele_dequeue_unused_front_page_assets', 999 );

/**
 * Preload the header logo on the front page to improve LCP.
 */
function growtele_preload_lcp_logo() {
	if ( ! is_front_page() || growtele_is_elementor_page() ) {
		return;
	}

	$logo_url = '';

	if ( has_custom_logo() ) {
		$logo_id = get_theme_mod( 'custom_logo' );

		if ( $logo_id ) {
			$logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
		}
	}

	if ( ! $logo_url && function_exists( 'growtele_get_image' ) ) {
		$logo_url = growtele_get_image( 'icons/logo.png' );
	}

	if ( ! $logo_url ) {
		return;
	}

	printf(
		'<link rel="preload" href="%s" as="image" fetchpriority="high" />' . "\n",
		esc_url( $logo_url )
	);
}
add_action( 'wp_head', 'growtele_preload_lcp_logo', 1 );

/**
 * Add preconnect for Google Fonts.
 */
function growtele_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
		$urls[] = array(
			'href' => 'https://api.fontshare.com',
			'crossorigin',
		);
		$urls[] = array(
			'href' => 'https://cdn.fontshare.com',
			'crossorigin',
		);
		$urls[] = array(
			'href' => 'https://cdn.jsdelivr.net',
			'crossorigin',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'growtele_resource_hints', 10, 2 );

/**
 * Prioritize the custom logo for LCP.
 *
 * @param string[] $attr       Image attributes.
 * @param WP_Post  $attachment Attachment post.
 * @param string   $size       Image size.
 * @return string[]
 */
function growtele_priority_custom_logo_attrs( $attr, $attachment, $size ) {
	unset( $attachment, $size );

	if ( empty( $attr['class'] ) || false === strpos( $attr['class'], 'custom-logo' ) ) {
		return $attr;
	}

	$attr['loading']       = 'eager';
	$attr['fetchpriority'] = 'high';
	$attr['decoding']      = 'async';

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'growtele_priority_custom_logo_attrs', 10, 3 );
