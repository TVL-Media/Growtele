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
		'badge_text'     => 'Smarter Communication.',
		'badge_strong'   => 'Stronger Connection',
		'title_line_1'   => 'Powering Smarter',
		'title_line_2'   => 'Customer Conversations',
		'subtitle_line_1' => 'Deliver secure, real-time communication experiences',
		'subtitle_line_2' => 'across SMS, WhatsApp, RCS, Email, and Voice',
		'features'       => array(
			array(
				'label' => 'Omnichannel Communication',
				'icon'  => array(
					'attachment_id' => 0,
					'url'           => '',
					'fallback'      => 'icons/chat-1.png',
				),
			),
			array(
				'label' => 'Secure & Reliable',
				'icon'  => array(
					'attachment_id' => 0,
					'url'           => '',
					'fallback'      => 'icons/chat-2.png',
				),
			),
			array(
				'label' => 'Seamless Experience',
				'icon'  => array(
					'attachment_id' => 0,
					'url'           => '',
					'fallback'      => 'icons/chat-3.png',
				),
			),
		),
		'trust_label'    => 'Trusted By Leading Brands',
		'trust_icon'     => array(
			'attachment_id' => 0,
			'url'           => '',
			'fallback'      => 'icons/shield.png',
		),
		'trust_brands'   => array(
			array( 'url' => 'https://listings.selectvia.com/wp-content/uploads/2026/09/lhba-scaled.png', 'modifier' => '' ),
			array( 'url' => 'https://listings.selectvia.com/wp-content/uploads/2026/09/lhbb.png', 'modifier' => 'gt-marquee__item--tanishq' ),
			array( 'url' => 'https://listings.selectvia.com/wp-content/uploads/2026/09/lhbc-scaled.png', 'modifier' => '' ),
			array( 'url' => 'https://listings.selectvia.com/wp-content/uploads/2026/09/lhbd-scaled.png', 'modifier' => 'gt-marquee__item--tanishq' ),
			array( 'url' => 'https://listings.selectvia.com/wp-content/uploads/2026/09/lhbe-scaled.png', 'modifier' => '' ),
			array( 'url' => 'https://listings.selectvia.com/wp-content/uploads/2026/09/lhbf.png', 'modifier' => '' ),
			array( 'url' => 'https://listings.selectvia.com/wp-content/uploads/2026/09/lhbg.png', 'modifier' => '' ),
			array( 'url' => 'https://listings.selectvia.com/wp-content/uploads/2026/09/lhbh.png', 'modifier' => '' ),
		),
	),
	'outcomes'       => array(
		'heading_title' => 'Communication That<br>Drives Business Outcomes',
		'heading_desc'  => 'Reliable, secure, and scalable communication solutions<br>built to help businesses connect, engage, and grow.',
		'card_title'    => 'Smarter Customer Engagement',
		'card_desc'     => 'Deliver meaningful, personalized conversations across SMS, WhatsApp, RCS, Email, and Voice with intelligent communication solutions designed to help businesses connect with customers at every stage of their journey.',
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
				'label'        => 'Banking',
				'icon'         => 'bankic.png',
				'panel_icon'   => 'panel-icon-banking.png',
				'panel_visual' => 'panel-visual-banking.png',
				'panel_style'  => '1',
				'desc'         => 'Deliver secure and real-time banking communication with OTP verification, transaction alerts and personalized customer engagement experiences.',
			),
			'shopping'   => array(
				'label'        => 'E-Commerce',
				'icon'         => 'commic.png',
				'panel_icon'   => 'panel-icon-shopping.png',
				'panel_visual' => 'panel-visual-shopping.png',
				'panel_style'  => '2',
				'desc'         => 'Drive conversions with automated order updates, cart recovery messages, and personalized promotional campaigns across multiple channels.',
			),
			'retail'     => array(
				'label'        => 'Retail',
				'icon'         => 'retailic.png',
				'panel_icon'   => 'panel-icon-retail.png',
				'panel_visual' => 'panel-visual-retail.png',
				'panel_style'  => '1',
				'desc'         => 'Enhance in-store and online retail experiences with timely notifications, loyalty program updates, and customer feedback collection.',
			),
			'healthcare' => array(
				'label'        => 'Healthcare',
				'icon'         => 'healthcareic.png',
				'panel_icon'   => 'panel-icon-healthcare.png',
				'panel_visual' => 'https://listings.selectvia.com/wp-content/uploads/2026/09/Group-679.png',
				'panel_style'  => '2',
				'desc'         => 'Send appointment reminders, health alerts, and secure patient communications while maintaining compliance with healthcare regulations.',
			),
			'education'  => array(
				'label'        => 'Education',
				'icon'         => 'educationic.png',
				'panel_icon'   => 'panel-icon-education.png',
				'panel_visual' => 'https://listings.selectvia.com/wp-content/uploads/2026/09/Eduu.png',
				'panel_style'  => '1',
				'desc'         => 'Improve student engagement through automated course updates, enrollment confirmations, and personalized learning notifications via WhatsApp and SMS.',
			),
			'travelling' => array(
				'label'        => 'Travelling',
				'icon'         => 'travelic.png',
				'panel_icon'   => 'panel-icon-travelling.png',
				'panel_visual' => 'panel-visual-travelling.png',
				'panel_style'  => '2',
				'desc'         => 'Keep travelers informed with booking confirmations, itinerary updates, and real-time alerts across SMS, WhatsApp, and email.',
			),
			'logistic'   => array(
				'label'        => 'Logistic',
				'icon'         => 'logisticic.png',
				'panel_icon'   => 'panel-icon-logistic.png',
				'panel_visual' => 'panel-visual-logistic.png',
				'panel_style'  => '1',
				'desc'         => 'Streamline delivery operations with shipment tracking updates, dispatch alerts, and driver coordination through reliable omnichannel messaging.',
			),
		),
	),
	'channels'       => array(
		'heading_title' => 'One Platform for Every Customer Interaction',
		'heading_desc'  => 'Deliver meaningful customer experiences through intelligent communication solutions built for performance and scale.',
		'items'         => array(
			array(
				'slug'  => 'cltele',
				'class' => 'card-1',
				'label' => 'Cloud Telephony',
				'desc'  => 'Engage customers with voice alerts and reminders.',
				'image' => 'cltele.png',
			),
			array(
				'slug'  => 'rcs',
				'class' => 'card-2',
				'label' => 'RCS',
				'desc'  => 'Create smarter customer conversations.',
				'image' => 'rcs.png',
			),
			array(
				'slug'  => 'sms',
				'class' => 'active',
				'label' => 'SMS',
				'desc'  => 'Engage customers with real-time alerts.',
				'image' => 'sms.png',
			),
			array(
				'slug'  => 'whatsapp',
				'class' => 'card-4',
				'label' => 'WhatsApp',
				'desc'  => 'Build meaningful customer engagement.',
				'image' => 'https://listings.selectvia.com/wp-content/uploads/2026/09/Group-661.png',
			),
			array(
				'slug'  => 'email',
				'class' => 'card-5',
				'label' => 'Email',
				'desc'  => 'Personalized email campaigns engage customers with reminders.',
				'image' => 'email.png',
			),
		),
	),
	'case_studies'   => array(
		'heading_title'   => 'Trusted by Businesses. Proven by Results.',
		'heading_desc'    => 'Discover how businesses across industries leverage Growtele to improve customer engagement, streamline communication, and achieve measurable growth.',
		'cycle_ms'        => '5000',
		'read_button_text' => 'Read Full Case Study',
		'read_button_url'  => '#',
		'items'           => array(
			array(
				'name'       => 'Clovia',
				'category'   => 'Retail & E-Commerce',
				'icon'       => 'https://listings.selectvia.com/wp-content/uploads/2026/09/b2b2b7f574fbf057d99b14b444ceb891c4499dd6.png',
				'modifier'   => 'tanishq',
				'image'      => 'https://listings.selectvia.com/wp-content/uploads/2026/09/Group-648.png',
				'desc'       => 'Growtele helped Clovia deliver seamless customer experiences through personalized SMS and WhatsApp communication. From promotional campaigns and offers to order updates and customer notifications, the platform enabled timely, reliable, and engaging communication at scale.',
				'stats'      => array(
					array( 'value' => '99.9%', 'label' => 'Platform Reliability' ),
					array( 'value' => '3 Years', 'label' => 'Trusted Partnership' ),
				),
				'quote'      => 'Growtele has helped us connect with our customers more effectively through timely and personalized communication. Its reliable infrastructure and seamless messaging capabilities have supported our campaigns and customer engagement across multiple touchpoints.',
				'author'     => 'Shilpa Bararia',
				'role'       => 'Assistant Manager, Clovia',
			),
			array(
				'name'     => 'Trade India',
				'category' => 'B2B & E-Commerce',
				'icon'     => 'https://listings.selectvia.com/wp-content/uploads/2026/09/3027b4c8bdd8d985756019898c70cc08de8e55b3.png',
				'modifier' => 'klinicapp',
				'image'    => 'https://listings.selectvia.com/wp-content/uploads/2026/09/4a809f22961c78ddb2fea31cb3b03bcc040b0bb7.png',
				'desc'     => 'Growtele helps Tradelndia engage with buyers and suppliers through high-performance SMS and WhatsApp communication. From lead notifications and account updates to promotional campaigns and event alerts, the platform enables timely, reliable, and scalable communication across a vast network.',
				'stats'    => array(
					array( 'value' => '99.9%', 'label' => 'Platform Reliability' ),
					array( 'value' => '3 Years', 'label' => 'Trusted Partnership' ),
				),
				'quote'    => 'Growtele has been a valuable communication partner for our business. Their reliable infrastructure, consistent delivery, and responsive support have helped us engage with our buyers and suppliers more effectively. The platform consistently delivers the performance and scalability we need at our scale.',
				'author'   => 'Praveen Gaur',
				'role'     => 'Chief Financial Officers',
			),
			array(
				'name'       => 'Unstop',
				'category'   => 'Education & Careers',
				'icon'       => 'https://listings.selectvia.com/wp-content/uploads/2026/09/5c52727434eda4705d2dbceafa49aa1ef0f533d5.png',
				'icon_class' => 'dabur',
				'modifier'   => 'dabur',
				'image'      => 'https://listings.selectvia.com/wp-content/uploads/2026/09/cda3f580f602248aa01b75dec8787e54a4d0b97f.png',
				'desc'       => 'Growtele helps Unstop engage with students and professionals through high-performance SMS and WhatsApp communication. From opportunity alerts and application reminders to event updates and personalized notifications, the platform enables timely, reliable, and scalable communication across a diverse audience.',
				'stats'      => array(
					array( 'value' => '99.9%', 'label' => 'Platform Reliability' ),
					array( 'value' => '3 Years', 'label' => 'Trusted Partnership' ),
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
				'desc'     => 'Jaro Education partnered with Growtele to enhance learner engagement and streamline communication. With automated SMS and WhatsApp notifications for course updates, class reminders, and enrollment confirmations, Jaro improved learner experience, increased course completions, and strengthened trust across their learner community.',
				'stats'    => array(
					array( 'value' => '99.9%', 'label' => 'Platform Reliability' ),
					array( 'value' => '3 Years', 'label' => 'Trusted Partnership' ),
				),
				'quote'    => 'Growtele has helped us transform how we communicate with learners. Their reliable platform, automation capabilities, and proactive support have played a key role in improving engagement and driving better outcomes for our programs.',
				'author'   => 'Supriya',
				'role'     => 'General Manager',
			),
		),
	),
	'enterprise'     => array(
		'heading_title' => 'Delivering Communication at Enterprise Scale',
		'heading_desc'  => 'Trusted by hundreds of businesses to power billions of customer interactions through secure, scalable, and reliable communication all over worldwide solutions.',
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
				'desc'    => 'Trusted by 500+ leading brands and enterprises across industries.',
			),
			'messages'  => array(
				'counter' => '36',
				'suffix'  => 'B+',
				'decimals' => '',
				'title'   => 'Message Delivered',
				'desc'    => 'Billions of messages delivered every month with speed and reliability.',
			),
			'uptime'    => array(
				'counter' => '99.99',
				'suffix'  => '%',
				'decimals' => '2',
				'title'   => 'Platform Uptime',
				'desc'    => 'Enterprise-grade infrastructure ensuring reliability you can count on.',
			),
			'support'   => array(
				'counter' => '24',
				'counter_secondary' => '7',
				'suffix'  => '',
				'decimals' => '',
				'title'   => 'Expert Support',
				'desc'    => 'Our support team is always available to help you succeed.',
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
		'title'       => 'Building Strong Relationships That Drive Business Growth',
		'description' => 'Trusted by leading brands and enterprises to deliver reliable, scalable, and impactful customer communication experiences.',
		'button_text' => 'Learn More',
		'button_url'  => '#',
		'bg_image'    => array(
			'attachment_id' => 0,
			'url'           => '',
			'fallback'      => 'integrations/integrations-bg.png',
		),
	),
);
