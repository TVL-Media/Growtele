<?php
/**
 * Default shared blocks (pre-footer CTA, etc.).
 *
 * @package Growtele
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'cta' => array(
		'heading_line_1' => 'Reach Every Customer',
		'heading_line_2' => 'on the Right Channel',
		'description'    => 'Send OTPs, alerts, promotions, and support messages on SMS, WhatsApp, RCS, Email, and Voice from one dependable platform built for enterprise volumes',
		'button_text'    => 'Get Started',
		'button_url'     => '',
		'image'          => array(
			'attachment_id' => 0,
			'url'           => '',
			'fallback'      => 'sections/group-525.webp',
			'alt'           => 'WhatsApp interface',
			'width'         => 438,
			'height'        => 351,
		),
	),
);
