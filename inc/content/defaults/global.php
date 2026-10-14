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
		'cta_text' => "Book a Demo",
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
				'desc'  => 'Bulk SMS for OTPs, alerts, and promotions, all DLT-compliant',
			),
			'email'           => array(
				'title' => 'Email',
				'desc'  => 'Transactional and promotional emails delivered through Email API and SMTP',
			),
			'cloud-telephony' => array(
				'title' => 'Voice',
				'desc'  => 'IVR, number masking, missed call services, and outbound calling (OBD)',
			),
			'whatsapp'        => array(
				'title' => 'WhatsApp',
				'desc'  => 'WhatsApp Business Platform for alerts, sales, and live support',
			),
			'rcs'             => array(
				'title' => 'RCS',
				'desc'  => 'RCS Business Messaging with verified sender IDs and rich media',
			),
		),
		'feature'   => array(
			'title' => 'Every Channel. One Platform.',
			'desc'  => 'Reach every customer on SMS, WhatsApp, RCS, Email, and Voice from one CPaaS platform built for enterprise traffic.',
		),
	),
	'contact_email' => 'enquiry@growtele.com',
	'container_width' => 1480,
);
