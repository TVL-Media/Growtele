<?php
/**
 * Theme activation: create static pages and set front page.
 *
 * @package Growtele
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create default pages on theme activation.
 */
function growtele_on_theme_activation() {
	$pages = array(
		'sms'               => array(
			'title'    => 'SMS',
			'template' => 'page-templates/page-sms.php',
		),
		'whatsapp'          => array(
			'title'    => 'WhatsApp',
			'template' => 'page-templates/page-whatsapp.php',
		),
		'email'             => array(
			'title'    => 'Email',
			'template' => 'page-templates/page-email.php',
		),
		'rcs'               => array(
			'title'    => 'RCS',
			'template' => 'page-templates/page-rcs.php',
		),
		'cloud-telephony'   => array(
			'title'    => 'Cloud Telephony',
			'template' => 'page-templates/page-cloud-telephony.php',
		),
		'retail'            => array(
			'title'    => 'Retail',
			'template' => 'page-templates/page-retail.php',
		),
		'health'            => array(
			'title'    => 'Health',
			'template' => 'page-templates/page-health.php',
		),
		'banking'           => array(
			'title'    => 'Banking',
			'template' => 'page-templates/page-banking.php',
		),
		'travelling'        => array(
			'title'    => 'Travelling',
			'template' => 'page-templates/page-travelling.php',
		),
		'ecommerce'         => array(
			'title'    => 'E-Commerce',
			'template' => 'page-templates/page-ecommerce.php',
		),
		'education'         => array(
			'title'    => 'Education',
			'template' => 'page-templates/page-education.php',
		),
		'logistic'          => array(
			'title'    => 'Logistic',
			'template' => 'page-templates/page-logistic.php',
		),
		'about-us'          => array(
			'title'    => 'About Us',
			'template' => 'page-templates/page-about-us.php',
		),
		'blogs'             => array(
			'title'    => 'Blogs',
			'template' => 'page-templates/page-blogs.php',
		),
		'career'            => array(
			'title'    => 'Career',
			'template' => 'page-templates/page-career.php',
		),
		'contact'           => array(
			'title'    => 'Contact',
			'template' => 'page-templates/page-contact.php',
		),
	);

	foreach ( $pages as $slug => $page ) {
		$existing = get_page_by_path( $slug );

		if ( $existing instanceof WP_Post ) {
			update_post_meta( $existing->ID, '_wp_page_template', $page['template'] );
			continue;
		}

		$page_id = wp_insert_post(
			array(
				'post_title'   => $page['title'],
				'post_name'    => $slug,
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '',
			)
		);

		if ( ! is_wp_error( $page_id ) && $page_id ) {
			update_post_meta( $page_id, '_wp_page_template', $page['template'] );
		}
	}

	$home = get_page_by_path( 'home' );
	if ( $home instanceof WP_Post ) {
		$home_id = $home->ID;
	} else {
		$home_id = wp_insert_post(
			array(
				'post_title'   => 'Home',
				'post_name'    => 'home',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '',
			)
		);
	}

	if ( ! is_wp_error( $home_id ) && $home_id ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', (int) $home_id );
	}

	if ( ! get_option( 'permalink_structure' ) ) {
		update_option( 'permalink_structure', '/%postname%/' );
	}

	flush_rewrite_rules( false );
}

/**
 * Create missing static pages and keep templates assigned on first load.
 */
function growtele_ensure_static_pages() {
	if ( get_option( 'growtele_static_pages_ready' ) === GROWTELE_VERSION ) {
		return;
	}

	growtele_on_theme_activation();
	update_option( 'growtele_static_pages_ready', GROWTELE_VERSION );
}

add_action( 'after_switch_theme', 'growtele_on_theme_activation' );
add_action( 'init', 'growtele_ensure_static_pages', 20 );
