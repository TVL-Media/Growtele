<?php
/**
 * Default footer content (matches current theme output).
 *
 * @package Growtele
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'brand_description' => "Growtele's global network solutions enable every business sector to optimize their business across the globe.",
	'get_in_touch_image' => array(
		'attachment_id' => 0,
		'url'           => '',
		'fallback'      => 'icons/get-in-touch.png',
	),
	'logo'               => array(
		'attachment_id' => 0,
		'url'           => '',
		'fallback'      => 'icons/logo.png',
	),
	'columns'            => array(
		'products' => array(
			'title' => 'Products',
			'links' => array(
				array(
					'label' => 'Whatsapp API',
					'url'   => '',
					'slug'  => 'whatsapp',
				),
				array(
					'label' => 'SMS API',
					'url'   => '',
					'slug'  => 'sms',
				),
				array(
					'label' => 'RCS API',
					'url'   => '',
					'slug'  => 'rcs',
				),
				array(
					'label' => 'E-Mail API',
					'url'   => '',
					'slug'  => 'email',
				),
				array(
					'label' => 'Cloud Telephony',
					'url'   => '',
					'slug'  => 'cloud-telephony',
				),
			),
		),
		'company'  => array(
			'title' => 'Company',
			'links' => array(
				array(
					'label' => 'About Us',
					'url'   => '',
					'slug'  => 'about-us',
				),
				array(
					'label' => 'Careers',
					'url'   => '',
					'slug'  => 'career',
				),
				array(
					'label' => 'Contact Us',
					'url'   => '',
					'slug'  => 'contact',
				),
				array(
					'label' => 'Growinfinity.io',
					'url'   => '',
					'slug'  => 'growtele-io',
				),
			),
		),
		'resources' => array(
			'title' => 'Resources',
			'links' => array(
				array(
					'label' => 'Pricing',
					'url'   => '',
					'slug'  => 'pricing',
				),
				array(
					'label' => 'API Documentation',
					'url'   => '',
					'slug'  => 'api-documentation',
				),
				array(
					'label' => 'Blog',
					'url'   => '',
					'slug'  => 'blogs',
				),
			),
		),
	),
	'social'             => array(
		array(
			'label' => 'Facebook',
			'url'   => 'https://www.facebook.com/Growtele',
		),
		array(
			'label' => 'X',
			'url'   => 'https://x.com/growtele',
		),
		array(
			'label' => 'Instagram',
			'url'   => 'https://www.instagram.com/growtele/',
		),
		array(
			'label' => 'YouTube',
			'url'   => 'https://www.youtube.com/@growtele4803',
		),
		array(
			'label' => 'LinkedIn',
			'url'   => 'https://www.linkedin.com/company/growtele/?viewAsMember=true',
		),
	),
	'contact_heading'    => 'Contact Us',
	'follow_heading'     => 'Follow Us',
	'legal'              => array(
		array(
			'label' => 'Privacy Policy',
			'url'   => '',
			'slug'  => 'privacy-policy',
		),
		array(
			'label' => 'Terms & Condition',
			'url'   => '',
			'slug'  => 'terms-and-condition',
		),
		array(
			'label' => 'Security',
			'url'   => '',
			'slug'  => 'security',
		),
		array(
			'label' => 'Partners Term of Use',
			'url'   => '',
			'slug'  => 'partners-term-of-use',
		),
	),
	'copyright'          => 'Growtele © 2026. All rights reserved.',
);
