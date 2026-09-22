<?php
/**
 * Content-facing CSS background media defaults.
 *
 * @package Growtele
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$media_field = function ( $fallback ) {
	return array(
		'attachment_id' => 0,
		'url'           => '',
		'fallback'      => $fallback,
	);
};

return array(
	'footer_bg'                => $media_field( 'https://listings.selectvia.com/wp-content/uploads/2026/09/Group-593-1-1.png' ),
	'product_hero_bg'          => $media_field( 'https://listings.selectvia.com/wp-content/uploads/2026/09/Group-593-1-3.png' ),
	'industry_dark_bg'         => $media_field( 'https://listings.selectvia.com/wp-content/uploads/2026/09/bgo-1.png' ),
	'about_hero_bg'            => $media_field( 'https://listings.selectvia.com/wp-content/uploads/2026/09/About-Us-BG.png' ),
	'industry_box_bg'          => $media_field( '' ),
	'product_journey_card_bg'  => $media_field( '' ),
	'product_benefits_bg'      => $media_field( '' ),
	'product_benefits_visual'  => $media_field( '' ),
	'email_benefit_tab1'       => $media_field( 'https://listings.selectvia.com/wp-content/uploads/2026/09/0f3cfb246890f57945e18c91cd2549bed1c668a8.png' ),
	'email_benefit_tab2'       => $media_field( 'https://listings.selectvia.com/wp-content/uploads/2026/09/51163c4b0aa4a8c87cd9694b6d53a0bf882d1542.png' ),
	'email_benefit_tab3'       => $media_field( 'https://listings.selectvia.com/wp-content/uploads/2026/09/6966a362d6c33885f37e97de1017648ffcd4d5a0.png' ),
	'email_benefit_tab4'       => $media_field( 'https://listings.selectvia.com/wp-content/uploads/2026/09/46c9808fbb57c8a3c26c7e5b83f1e975a189c26d.png' ),
	'io_value_prop_bg'         => $media_field( 'https://listings.selectvia.com/wp-content/uploads/2026/09/bgo.png' ),
	'io_value_prop_card'       => $media_field( 'https://listings.selectvia.com/wp-content/uploads/2026/09/dsvd.png' ),
	'io_apis_visual'           => $media_field( 'https://listings.selectvia.com/wp-content/uploads/2026/09/bqb.png' ),
	'io_navy_card'             => $media_field( 'https://listings.selectvia.com/wp-content/uploads/2026/09/Group-603.png' ),
	'io_cta_mid_bg'            => $media_field( 'https://listings.selectvia.com/wp-content/uploads/2026/09/bgo-1.png' ),
	'io_chart_card'            => $media_field( 'https://listings.selectvia.com/wp-content/uploads/2026/09/bqb-1.png' ),
	'io_reporting_bg'          => $media_field( 'https://listings.selectvia.com/wp-content/uploads/2026/09/DARKKK.png' ),
);
