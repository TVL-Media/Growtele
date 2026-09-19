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
		'heading_line_1' => 'Power Smarter Customer',
		'heading_line_2' => 'Conversations at Scale',
		'description'    => 'Engage customers across SMS, WhatsApp, RCS, Email, and Voice through one unified communication platform built for reliability, performance, and growth',
		'button_text'    => 'Get Started',
		'button_url'     => '',
		'image'          => array(
			'attachment_id' => 0,
			'url'           => '',
			'fallback'      => 'sections/group-525.png',
			'alt'           => 'WhatsApp interface',
			'width'         => 438,
			'height'        => 351,
		),
	),
);
