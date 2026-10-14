<?php
/**
 * Home page default content data (source of truth for current homepage).
 *
 * @package Growtele
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'hero'           => array(
		'video'          => array(
			'attachment_id' => 0,
			'url'           => '',
			'fallback_key'  => 'hero',
		),
		'badge_icon'     => array(
			'attachment_id' => 0,
			'url'           => '',
			'fallback'      => 'icons/sparkle.png',
		),
		'badge_text'     => 'Reach Customers Fast',
		'badge_strong'   => 'On Every Channel.',
		'title_line_1'   => 'Messaging That',
		'title_line_2'   => 'Customers Respond To',
		'subtitle_line_1' => 'Deliver OTPs, transaction alerts, and order updates',
		'subtitle_line_2' => 'across SMS, WhatsApp, RCS, Email, and Voice',
		'features'       => array(
			array(
				'label' => 'Omnichannel Messaging API',
				'icon'  => array(
					'attachment_id' => 0,
					'url'           => '',
					'fallback'      => 'icons/chat-1.png',
				),
			),
			array(
				'label' => 'DLT-Compliant SMS',
				'icon'  => array(
					'attachment_id' => 0,
					'url'           => '',
					'fallback'      => 'icons/chat-2.png',
				),
			),
			array(
				'label' => 'Real-Time Reports',
				'icon'  => array(
					'attachment_id' => 0,
					'url'           => '',
					'fallback'      => 'icons/chat-3.png',
				),
			),
		),
		'trust_label'    => 'Trusted by Leading Brands',
		'trust_icon'     => array(
			'attachment_id' => 0,
			'url'           => '',
			'fallback'      => 'icons/shield.png',
		),
		'trust_brands'   => array(
			array( 'url' => 'https://listings.selectvia.com/wp-content/uploads/2026/09/bfbd550d61661382c2e5e8228e00258e6269f60a-1-scaled.png', 'modifier' => '' ),
			array( 'url' => 'https://listings.selectvia.com/wp-content/uploads/2026/09/0be164e05541b34c2903ad52b8059a0e1205d37a.png', 'modifier' => '' ),
			array( 'url' => 'https://listings.selectvia.com/wp-content/uploads/2026/09/002d1da0167b0f32cdbb229f4f66d8754be89681-scaled.png', 'modifier' => 'gt-marquee__item--marquee-brand-lg' ),
			array( 'url' => 'https://listings.selectvia.com/wp-content/uploads/2026/09/2bcafc13072d2a941f952e4d568d0f11551ea9c8-1-scaled.png', 'modifier' => '' ),
			array( 'url' => 'https://listings.selectvia.com/wp-content/uploads/2026/09/0a961bf18c7d6f41b94d149373c25244d2acdacc-scaled.png', 'modifier' => '' ),
			array( 'url' => 'https://listings.selectvia.com/wp-content/uploads/2026/09/image-126.png', 'modifier' => '' ),
			array( 'url' => 'https://listings.selectvia.com/wp-content/uploads/2026/09/fd7ee27e8ba7eaa0caf058c29ca36d8c87abf58b.png', 'modifier' => '' ),
			array( 'url' => 'https://listings.selectvia.com/wp-content/uploads/2026/09/fe7c0238d21b7ee371bd8b936e8875c696c0ece1.png', 'modifier' => '' ),
		),
	),
	'outcomes'       => array(
		'heading_title' => 'Customer Messages<br>That Drive Real Results',
		'heading_desc'  => 'OTPs, payment alerts, and offers delivered on time,<br>so customers log in, pay, and buy without delay.',
		'card_title'    => 'Engagement at Every Stage',
		'card_desc'     => 'Reach customers at every step of their journey, from the welcome message and login OTP to order updates, payment reminders, feedback requests, and support replies, on SMS, WhatsApp, RCS, Email, and Voice.',
		'stat_1'        => array(
			'counter' => '36',
			'suffix'  => 'B+',
			'label'   => 'Messages Delivered Globally',
		),
		'stat_2'        => array(
			'counter' => '500',
			'suffix'  => '+',
			'label'   => 'Enterprise Clients Served',
		),
		'card_bg'       => array(
			'attachment_id' => 0,
			'url'           => '',
			'fallback'      => 'sections/outcomes-mask.svg',
		),
		'video'         => array(
			'attachment_id' => 0,
			'url'           => '',
			'fallback_key'  => 'outcomes',
		),
	),
	'industries'     => array(
		'heading_title' => 'Built for the Unique Needs of Every Industry',
		'heading_desc'  => 'Helping businesses connect, engage, and grow through reliable communication solutions tailored to their needs.',
		'items'         => array(
			'banking'    => array(
				'label'        => 'Banking & Finance',
				'icon'         => 'bankic.png',
				'panel_icon'   => 'panel-icon-banking.png',
				'panel_visual' => 'panel-visual-banking.png',
				'panel_style'  => '1',
				'desc'         => 'Deliver login OTPs, transaction alerts, EMI reminders, and fraud warnings within seconds, and let customers complete KYC over WhatsApp.',
			),
			'shopping'   => array(
				'label'        => 'E-commerce',
				'icon'         => 'commic.png',
				'panel_icon'   => 'panel-icon-shopping.png',
				'panel_visual' => 'panel-visual-shopping.png',
				'panel_style'  => '2',
				'desc'         => 'Recover abandoned carts, confirm COD orders, and share order tracking and return-pickup updates on WhatsApp to bring shoppers back.',
			),
			'retail'     => array(
				'label'        => 'Retail',
				'icon'         => 'retailic.png',
				'panel_icon'   => 'panel-icon-retail.png',
				'panel_visual' => 'panel-visual-retail.png',
				'panel_style'  => '1',
				'desc'         => 'Bring shoppers in store and online with new-arrival alerts, loyalty point updates, and quick feedback surveys after each visit.',
			),
			'healthcare' => array(
				'label'        => 'Healthcare',
				'icon'         => 'healthcareic.png',
				'panel_icon'   => 'panel-icon-healthcare.png',
				'panel_visual' => 'https://listings.selectvia.com/wp-content/uploads/2026/09/Group-679.png',
				'panel_style'  => '2',
				'desc'         => 'Send appointment reminders, lab test reports, and health alerts securely, and cut no-shows with one-tap confirmations on WhatsApp.',
			),
			'education'  => array(
				'label'        => 'Education',
				'icon'         => 'educationic.png',
				'panel_icon'   => 'panel-icon-education.png',
				'panel_visual' => 'https://listings.selectvia.com/wp-content/uploads/2026/09/Eduu.png',
				'panel_style'  => '1',
				'desc'         => 'Answer admission enquiries, share fee reminders and timetable updates, and notify parents regarding attendance and exams on WhatsApp and SMS.',
			),
			'travelling' => array(
				'label'        => 'Travel',
				'icon'         => 'travelic.png',
				'panel_icon'   => 'panel-icon-travelling.png',
				'panel_visual' => 'panel-visual-travelling.png',
				'panel_style'  => '2',
				'desc'         => 'Send booking confirmations, e-tickets, PNR and flight status alerts, and web check-in reminders on SMS, WhatsApp, and Email.',
			),
			'logistic'   => array(
				'label'        => 'Logistics',
				'icon'         => 'logisticic.png',
				'panel_icon'   => 'panel-icon-logistic.png',
				'panel_visual' => 'panel-visual-logistic.png',
				'panel_style'  => '1',
				'desc'         => 'Share shipment tracking, delivery OTPs, and NDR follow-ups, and mask rider-to-customer phone calls to minimise failed deliveries and RTO.',
			),
		),
	),
	'channels'       => array(
		'heading_title' => 'One Platform for Every Customer Interaction',
		'heading_desc'  => 'SMS for OTPs, WhatsApp for promotions, Email for statements, Voice for reminders, controlled from one dashboard.',
		'items'         => array(
			array(
				'slug'  => 'cltele',
				'class' => 'card-1',
				'label' => 'Voice',
				'desc'  => 'IVR, voice OTPs, missed calls, and call masking.',
				'image' => 'cltele.png',
			),
			array(
				'slug'  => 'rcs',
				'class' => 'card-2',
				'label' => 'RCS',
				'desc'  => 'Verified, branded rich media messages.',
				'image' => 'rcs.png',
			),
			array(
				'slug'  => 'sms',
				'class' => 'active',
				'label' => 'SMS',
				'desc'  => 'OTPs and alerts that arrive in seconds.',
				'image' => 'sms.png',
			),
			array(
				'slug'  => 'whatsapp',
				'class' => 'card-4',
				'label' => 'WhatsApp',
				'desc'  => 'Chatbots, catalogs, and shared inbox.',
				'image' => 'https://listings.selectvia.com/wp-content/uploads/2026/09/Group-661.png',
			),
			array(
				'slug'  => 'email',
				'class' => 'card-5',
				'label' => 'Email',
				'desc'  => 'Invoices, receipts, and newsletters that land in the inbox.',
				'image' => 'email.png',
			),
		),
	),
	'case_studies'   => array(
		'heading_title'   => 'Trusted by Brands. Measured by Results.',
		'heading_desc'    => 'Discover how Clovia, TradeIndia, Unstop, and Jaro Education use Growtele\'s SMS and WhatsApp messaging for offers, lead alerts, and reminders.',
		'cycle_ms'        => '5000',
		'read_button_text' => 'Read Full Case Study',
		'read_button_url'  => '#',
		'items'           => array(
			array(
				'name'       => 'Clovia',
				'category'   => 'Retail & E-commerce',
				'icon'       => 'https://listings.selectvia.com/wp-content/uploads/2026/09/b2b2b7f574fbf057d99b14b444ceb891c4499dd6.png',
				'modifier'   => 'tanishq',
				'image'      => 'https://listings.selectvia.com/wp-content/uploads/2026/09/Group-648.png',
				'desc'       => 'Clovia uses Growtele to send offers, sale alerts, new-collection launches, order updates, and delivery notifications on SMS and WhatsApp. Shoppers get each offer in time to act, always know where their order is, and messages keep flowing during peak sale periods.',
				'stats'      => array(
					array( 'value' => '99.9%', 'label' => 'Delivery Reliability' ),
					array( 'value' => '3 Years', 'label' => 'Long-Term Partner' ),
				),
				'quote'      => 'Growtele has helped us connect with our customers more effectively through timely and personalized communication. Its reliable infrastructure and seamless messaging capabilities have supported our campaigns and customer engagement across multiple touchpoints.',
				'author'     => 'Shilpa Bararia',
				'role'       => 'Assistant Manager, Clovia',
			),
			array(
				'name'     => 'TradeIndia',
				'category' => 'B2B & E-commerce',
				'icon'     => 'https://listings.selectvia.com/wp-content/uploads/2026/09/3027b4c8bdd8d985756019898c70cc08de8e55b3.png',
				'modifier' => 'klinicapp',
				'image'    => 'https://listings.selectvia.com/wp-content/uploads/2026/09/4a809f22961c78ddb2fea31cb3b03bcc040b0bb7.png',
				'desc'     => 'TradeIndia uses Growtele to reach buyers and suppliers on SMS and WhatsApp. New lead alerts, account updates, promotional campaigns, and trade event reminders go out on time at high volume, so members across a vast network of businesses can answer enquiries while still fresh.',
				'stats'    => array(
					array( 'value' => '99.9%', 'label' => 'Delivery Reliability' ),
					array( 'value' => '3 Years', 'label' => 'Long-Term Partner' ),
				),
				'quote'    => 'Growtele has been a valuable communication partner for our business. Their reliable infrastructure, consistent delivery, and responsive support have helped us engage with our buyers and suppliers more effectively. The platform consistently delivers the performance and scalability we need at our scale.',
				'author'   => 'Praveen Gaur',
				'role'     => 'Chief Financial Officer',
			),
			array(
				'name'       => 'Unstop',
				'category'   => 'Education & Careers',
				'icon'       => 'https://listings.selectvia.com/wp-content/uploads/2026/09/5c52727434eda4705d2dbceafa49aa1ef0f533d5.png',
				'icon_class' => 'dabur',
				'modifier'   => 'dabur',
				'image'      => 'https://listings.selectvia.com/wp-content/uploads/2026/09/cda3f580f602248aa01b75dec8787e54a4d0b97f.png',
				'desc'       => 'Unstop uses Growtele to reach students and professionals on SMS and WhatsApp. Opportunity alerts, application deadline reminders, event updates, and personal notifications reach a large, varied audience on time, so users never miss a competition, internship, or job opening they have signed up for.',
				'stats'      => array(
					array( 'value' => '99.9%', 'label' => 'Delivery Reliability' ),
					array( 'value' => '3 Years', 'label' => 'Long-Term Partner' ),
				),
				'quote'      => 'Growtele has been a reliable communication partner for our business. Their robust infrastructure, consistent delivery, and responsive support have helped us engage with our students and users more effectively. The platform consistently delivers the performance and scalability we need at our scale.',
				'author'     => 'Unstop Team',
				'role'       => 'Growth & Marketing',
			),
			array(
				'name'     => 'Jaro Education',
				'category' => 'Education',
				'icon'     => 'jaro-logo.png',
				'modifier' => 'jaro',
				'image'    => 'sections/case-study-jaro.png',
				'desc'     => 'Jaro Education uses Growtele to send automated SMS and WhatsApp messages for course updates, class reminders, and enrollment confirmations. Learners get the right nudge before every live online session, stay on track, and more of them complete their courses, helping Jaro build stronger trust with its learner community.',
				'stats'    => array(
					array( 'value' => '99.9%', 'label' => 'Delivery Reliability' ),
					array( 'value' => '3 Years', 'label' => 'Long-Term Partner' ),
				),
				'quote'    => 'Growtele has helped us transform how we communicate with learners. Their reliable platform, automation capabilities, and proactive support have played a key role in improving engagement and driving better outcomes for our programs.',
				'author'   => 'Supriya',
				'role'     => 'General Manager',
			),
		),
	),
	'enterprise'     => array(
		'heading_title' => 'SMS, WhatsApp, and Voice at Enterprise Scale',
		'heading_desc'  => 'Hundreds of businesses send billions of OTPs, transaction alerts, and campaigns through Growtele, and messages keep moving even during festive traffic peaks.',
		'bg_image'      => array(
			'attachment_id' => 0,
			'url'           => '',
			'fallback'      => 'sections/enterprise-bg.jpeg',
		),
		'cards'         => array(
			'clients'   => array(
				'counter' => '500',
				'suffix'  => '+',
				'decimals' => '',
				'title'   => 'Enterprise Clients',
				'desc'    => '500+ brands in banking, retail, education, travel, and logistics.',
			),
			'messages'  => array(
				'counter' => '36',
				'suffix'  => 'B+',
				'decimals' => '',
				'title'   => 'Messages Delivered',
				'desc'    => 'Billions of OTPs, bank alerts, and offers sent on time every month.',
			),
			'uptime'    => array(
				'counter' => '99.99',
				'suffix'  => '%',
				'decimals' => '2',
				'title'   => 'Platform Uptime',
				'desc'    => 'OTPs and alerts keep flowing, even during festive-season sale peaks.',
			),
			'support'   => array(
				'counter' => '24',
				'counter_secondary' => '7',
				'suffix'  => '',
				'decimals' => '',
				'title'   => 'Expert Support',
				'desc'    => 'Real people on phone and email, ready when you need help.',
			),
		),
		'image_tall_1'  => array(
			'attachment_id' => 0,
			'url'           => '',
			'fallback'      => 'sections/enterprise-card-2.png',
			'alt'           => 'Enterprise meeting',
		),
		'image_tall_2'  => array(
			'attachment_id' => 0,
			'url'           => '',
			'fallback'      => 'sections/enterprise-card-1.png',
			'alt'           => 'Customer support',
		),
	),
	'integrations'   => array(
		'title'       => 'Integrates With Salesforce, Shopify, Zoho CRM, and More',
		'description' => 'Trigger order alerts, cart reminders, and campaign messages straight from your CRM, store, or marketing automation tool.',
		'button_text' => 'Learn More',
		'button_url'  => '#',
		'bg_image'    => array(
			'attachment_id' => 0,
			'url'           => '',
			'fallback'      => 'integrations/integrations-bg.png',
		),
	),
);
