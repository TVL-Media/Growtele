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
	'brand_description' => "Growtele helps businesses in every sector reach customers on SMS, WhatsApp, RCS, Email, and Voice worldwide.",
	'get_in_touch_image' => array(
		'attachment_id' => 0,
		'url'           => '',
		'fallback'      => 'icons/get-in-touch.webp',
	),
	'logo'               => array(
		'attachment_id' => 0,
		'url'           => '',
		'fallback'      => 'icons/logo.webp',
	),
	'columns'            => array(
		'products' => array(
			'title' => 'Products',
			'links' => array(
				array(
					'label' => 'SMS',
					'url'   => '',
					'slug'  => 'sms',
				),
				array(
					'label' => 'Email',
					'url'   => '',
					'slug'  => 'email',
				),
				array(
					'label' => 'Voice',
					'url'   => '',
					'slug'  => 'cloud-telephony',
				),
				array(
					'label' => 'WhatsApp',
					'url'   => '',
					'slug'  => 'whatsapp',
				),
				array(
					'label' => 'RCS',
					'url'   => '',
					'slug'  => 'rcs',
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
					'slug'  => 'growinfinity-io',
				),
			),
		),
		'resources' => array(
			'title' => 'Resources',
			'links' => array(
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
			'label' => 'Terms & Conditions',
			'url'   => '',
			'slug'  => 'terms-and-condition',
		),
		array(
			'label' => 'Security',
			'url'   => '',
			'slug'  => 'security',
		),
		array(
			'label' => 'Partner Terms of Use',
			'url'   => '',
			'slug'  => 'partners-term-of-use',
		),
	),
	'copyright'          => 'Growtele © 2026. All rights reserved.',
);
