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
		'heading_desc_mobile' => 'OTPs, payment alerts, and offers<br>delivered on time, so customers log in,<br>pay, and buy without delay.',
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
				'label'        => 'Banking &amp; Finance',
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
				'image' => 'https://listings.selectvia.com/wp-content/uploads/2026/10/SMSS.png',
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
				'category'   => 'Retail &amp; E-commerce',
				'icon'       => 'https://listings.selectvia.com/wp-content/uploads/2026/09/b2b2b7f574fbf057d99b14b444ceb891c4499dd6.png',
				'modifier'   => 'tanishq',
				'image'      => 'https://listings.selectvia.com/wp-content/uploads/2026/09/Group-648.png',
				'desc'       => 'Growtele enables Clovia to connect with shoppers through SMS, RCS, and WhatsApp, delivering timely sale alerts, new collection launches, order updates, and delivery notifications. Our reliable communication solutions help Clovia drive customer engagement and ensure seamless messaging, even during peak sale periods.',
				'stats'      => array(
					array( 'value' => '99.9%', 'label' => 'Delivery Reliability' ),
					array( 'value' => '5 Years', 'label' => 'Long-Term Partner' ),
				),
				'quote'      => 'We have been partnering with Growtele for over five years for our SMS and WhatsApp communication needs. Their superior delivery rates, competitive pricing, and proactive support make them a reliable CPaaS partner. The team is professional, responsive, and always a pleasure to work with. We highly recommend Growtele.',
				'author'     => 'Shilpa Bararia',
				'role'       => 'CRM Marketing Lead, Clovia',
			),
			array(
				'name'     => 'TradeIndia',
				'category' => 'B2B &amp; E-commerce',
				'icon'     => 'https://listings.selectvia.com/wp-content/uploads/2026/09/3027b4c8bdd8d985756019898c70cc08de8e55b3.png',
				'modifier' => 'klinicapp',
				'image'    => 'https://listings.selectvia.com/wp-content/uploads/2026/09/4a809f22961c78ddb2fea31cb3b03bcc040b0bb7.png',
				'desc'     => 'Growtele powers TradeIndia’s business communication across SMS, WhatsApp, and WhatsApp Chatbot, enabling timely lead alerts, account updates, promotional campaigns, and trade event reminders. By supporting high-volume communication across its extensive B2B network, Growtele helps TradeIndia connect buyers and suppliers, respond to enquiries faster, and drive meaningful business engagement.',
				'stats'    => array(
					array( 'value' => '99.9%', 'label' => 'Delivery Reliability' ),
					array( 'value' => '4 Years', 'label' => 'Long-Term Partner' ),
				),
				'quote'    => 'Growtele’s reliable SMS delivery and timely support help us communicate effectively with buyers and suppliers across our B2B marketplace. Their responsive team and seamless execution make them a dependable communication partner for TradeIndia.',
				'author'   => 'Praveen Gaur',
				'role'     => 'CFO- Trade India',
			),
			array(
				'name'       => 'Unstop',
				'category'   => 'Education & Careers',
				'icon'       => 'https://listings.selectvia.com/wp-content/uploads/2026/09/5c52727434eda4705d2dbceafa49aa1ef0f533d5.png',
				'icon_class' => 'dabur',
				'modifier'   => 'dabur',
				'image'      => 'https://listings.selectvia.com/wp-content/uploads/2026/09/cda3f580f602248aa01b75dec8787e54a4d0b97f.png',
				'desc'       => 'Growtele enables Unstop to connect students and professionals with career opportunities through dependable SMS, and OTP services. From job and internship alerts to application updates and secure user verification, Growtele helps Unstop keep its growing community informed, engaged, and connected at every step of their career journey.',
				'stats'      => array(
					array( 'value' => '99.9%', 'label' => 'Delivery Reliability' ),
					array( 'value' => '3 Years', 'label' => 'Long-Term Partner' ),
				),
				'quote'      => 'We have been using Growtele’s SMS services; Consistently positive experience. Their reliable delivery, timely support, and seamless execution help us manage high-volume campaigns efficiently. The team is responsive, professional, and quick to resolve issues. We appreciate their partnership and recommend Growtele as a dependable SMS service provider.',
				'author'     => 'Tushar Mehta',
				'role'       => 'Director, Unstop',
			),
			array(
				'name'     => 'Jaro Education',
				'category' => 'Education',
				'icon'     => 'jaro-logo.png',
				'modifier' => 'jaro',
				'image'    => 'sections/case-study-jaro.png',
				'desc'     => 'Growtele supports Jaro’s communication needs through reliable SMS services. From delivering opportunity alerts, application deadline reminders, and event updates to enabling secure user verification through OTPs, Growtele helps Jaro engage students and professionals at scale, ensuring timely communication and a seamless user experience.',
				'stats'    => array(
					array( 'value' => '99.9%', 'label' => 'Delivery Reliability' ),
					array( 'value' => '5 Years', 'label' => 'Long-Term Partner' ),
				),
				'quote'    => 'With Growtele, we ensure timely OTP delivery for our learner verification and enrolment processes. Their consistent service helps us maintain a smooth user experience, while their dependable support gives us confidence in managing our communication needs at scale.',
				'author'   => 'Supriya',
				'role'     => 'GM – Jaro',
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
