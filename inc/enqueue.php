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
function growtele_enqueue_assets() {
	if ( is_page() ) {
		$slug  = get_post_field( 'post_name', get_queried_object_id() );
		$pages = growtele_static_page_map();

		if ( isset( $pages[ $slug ] ) ) {
			return;
		}
	}

	wp_enqueue_style(
		'growtele-google-fonts',
		'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700;900&display=swap',
		array(),
		null
	);

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
		$deps = array( 'growtele-google-fonts', 'growtele-tomato-grotesk' );
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
		'growtele-image-performance',
		GROWTELE_URI . '/assets/js/image-performance.js',
		array(),
		GROWTELE_VERSION,
		false
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
		'growtele-main',
		GROWTELE_URI . '/assets/js/main.js',
		array( 'growtele-smooth-scroll' ),
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

/**
 * Preload hero background video on the front page.
 */
function growtele_preload_hero_video() {
	if ( ! is_front_page() ) {
		return;
	}

	printf(
		'<link rel="preload" href="%s" as="video" type="video/mp4" fetchpriority="low" />' . "\n",
		esc_url( growtele_get_cdn_video( 'hero' ) )
	);
}
add_action( 'wp_head', 'growtele_preload_hero_video', 1 );

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
		$urls[] = array(
			'href'        => 'https://listings.selectvia.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'growtele_resource_hints', 10, 2 );
