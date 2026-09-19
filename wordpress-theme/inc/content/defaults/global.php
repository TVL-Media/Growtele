<?php
/**
 * Default global content (matches current theme output).
 *
 * @package Growtele
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'header' => array(
		'cta_text' => "Let's Get Started",
		'cta_url'  => '', // Resolved at runtime via growtele_get_page_url( 'contact' ) when empty.
	),
	'nav' => array(
		'home'      => 'Home',
		'products'  => 'Products',
		'industries'=> 'Industry Solutions',
		'company'   => 'Company',
		'mega'      => array(
			'sms'             => array(
				'title' => 'SMS',
				'desc'  => 'Powerful SMS solutions that connect businesses with customers',
			),
			'email'           => array(
				'title' => 'E-Mail',
				'desc'  => 'Engage customers with personalized, reliable emails that drive conversations',
			),
			'cloud-telephony' => array(
				'title' => 'Cloud Telephony',
				'desc'  => 'Connect, engage, and support customers with powerful cloud-based calling',
			),
			'whatsapp'        => array(
				'title' => 'WhatsApp',
				'desc'  => 'Connect with customers on WhatsApp through engaging conversations',
			),
			'rcs'             => array(
				'title' => 'RCS',
				'desc'  => 'RCS is the next generation of business messaging that transforms.',
			),
		),
		'feature'   => array(
			'title' => 'True Market Leaders for CPass',
			'desc'  => 'True Market Leaders in CPaaS — empowering businesses with seamless, scalable, and intelligent customer communications.',
		),
	),
	'contact_email' => 'enquiry@growtele.com',
	'container_width' => 1480,
);
