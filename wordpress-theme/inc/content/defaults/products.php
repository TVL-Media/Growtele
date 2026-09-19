<?php
/**
 * Product page CMS defaults (must match pages/{slug}/index.html exactly).
 *
 * @package Growtele
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$shared_cta = array(
	'heading'     => "              Power Smarter Customer<br>\n              Conversations at Scale",
	'description' => 'Engage customers across SMS, WhatsApp, RCS, Email, and Voice through one unified communication platform built for reliability, performance, and growth',
	'button_text' => 'Get Started',
	'button_url'  => '',
);

$funnel_sms = array(
	'acquisition' => array(
		'src' => 'https://listings.selectvia.com/wp-content/uploads/2026/09/Group-689.png',
		'alt' => 'Acquisition campaign flow',
	),
	'engagement'  => array(
		'src' => 'https://listings.selectvia.com/wp-content/uploads/2026/09/Group-679-1.png',
		'alt' => 'Engagement campaign flow',
	),
	'retention'   => array(
		'src' => 'https://listings.selectvia.com/wp-content/uploads/2026/09/Group-690.png',
		'alt' => 'Retention campaign flow',
	),
);

$funnel_whatsapp = array(
	'acquisition' => array(
		'src' => 'https://listings.selectvia.com/wp-content/uploads/2026/09/1b4bd0cbc9f3603f77704c574dd2ab333f364839-1.png',
		'alt' => 'Discovery campaign flow',
	),
	'engagement'  => array(
		'src' => 'https://listings.selectvia.com/wp-content/uploads/2026/09/fece317fe37c9cccd3c628247abf71ef36eaca5f.png',
		'alt' => 'Engagement campaign flow',
	),
	'retention'   => array(
		'src' => 'https://listings.selectvia.com/wp-content/uploads/2026/09/da2baeb8533e6edb03764ddc3aa3e02b8386dce4-1.png',
		'alt' => 'Retention campaign flow',
	),
);

$funnel_email = array(
	'acquisition' => array(
		'src' => 'assets/email-acquica.png',
		'alt' => 'Acquisition campaign flow',
	),
	'engagement'  => array(
		'src' => 'assets/email-Enagement Card.png',
		'alt' => 'Engagement campaign flow',
	),
	'retention'   => array(
		'src' => 'assets/email-retim.png',
		'alt' => 'Retention campaign flow',
	),
);

$funnel_rcs = array(
	'acquisition' => array(
		'src' => 'assets/rcs-acquica.png',
		'alt' => 'Acquisition campaign flow',
	),
	'engagement'  => array(
		'src' => 'assets/rcs-Enagement Card.png',
		'alt' => 'Engagement campaign flow',
	),
	'retention'   => array(
		'src' => 'assets/rcs-retim.png',
		'alt' => 'Retention campaign flow',
	),
);

$funnel_cloud = array(
	'acquisition' => array(
		'src' => 'assets/cloud-telephony-acquica.png',
		'alt' => 'Acquisition campaign flow',
	),
	'engagement'  => array(
		'src' => 'assets/cloud-telephony-Enagement Card.png',
		'alt' => 'Engagement campaign flow',
	),
	'retention'   => array(
		'src' => 'assets/cloud-telephony-retim.png',
		'alt' => 'Retention campaign flow',
	),
);

return array(
	'sms'               => array(
		'hero'    => array(
			'title'    => 'Power Business<br>Communication Through<br>Enterprise SMS',
			'subtitle' => 'Reach customers in seconds with reliable SMS communication built for OTPs, alerts, notifications, promotions.',
			'cta_text' => 'Let?s Get Started',
			'cta_url'  => '',
		),
		'pills'   => array(
			'Instant OTP Delivery',
			'Global SMS Coverage',
			'Seamless Experience',
		),
		'journey' => array(
			'title' => 'Reliable SMS for Every<br>Customer Journey',
			'lead'  => 'Keep customers informed and engaged with instant OTPs, order updates, appointment reminders, promotional offers, and personalized notifications?all from one enterprise-grade messaging platform.',
		),
		'scale'   => array(
			'title' => 'Built for Scale. <span>Designed for Reliability.</span>',
			'lead'  => 'Helping businesses connect, engage, and grow through reliable communication solutions tailored to their needs.',
		),
		'benefits' => array(
			'title' => 'Benefits That Drive<br>Your Business Forward.',
			'lead'  => 'Growtele SMS helps you deliver critical messages at the<br>right time with highest reliability and complete visibility.',
		),
		'why'     => array(
			'title' => 'Why SMS Remains the<br>Most Trusted Channel',
			'lead'  => 'From authentication and transaction alerts to promotions and customer engagement, SMS delivers unmatched reach',
		),
		'funnel_heading' => array(
			'title' => 'Power every stage of<br>your marketing funnel',
			'lead'  => 'From attracting new customers to retaining your best ones,<br>Growtele SMS API helps you engage, convert and retain every step.',
		),
		'faq'     => array(
			'title' => 'Everything You Need to Know<br>About Growtele SMS',
			'lead'  => 'Find answers to common questions about SMS delivery, OTP authentication, integrations, analytics, security, and platform capabilities.',
			'items' => array(
				array(
					'question' => 'How quickly are SMS messages delivered?',
					'answer'   => "SMS messages are typically delivered within seconds. Our optimized<br>routing and strong carrier network ensure fast and reliable delivery<br>across 190+ countries.",
				),
				array(
					'question' => 'Does Growtele support OTP authentication?',
					'answer'   => "SMS messages are typically delivered within seconds. Our optimized<br>routing and strong carrier network ensure fast and reliable delivery<br>across 190+ countries.",
				),
				array(
					'question' => 'Do you provide delivery reports and analytics?',
					'answer'   => "SMS messages are typically delivered within seconds. Our optimized<br>routing and strong carrier network ensure fast and reliable delivery<br>across 190+ countries.",
				),
				array(
					'question' => 'Is Growtele SMS suitable for enterprise businesses?',
					'answer'   => "SMS messages are typically delivered within seconds. Our optimized<br>routing and strong carrier network ensure fast and reliable delivery<br>across 190+ countries.",
				),
				array(
					'question' => 'Can I send bulk SMS campaigns?',
					'answer'   => "SMS messages are typically delivered within seconds. Our optimized<br>routing and strong carrier network ensure fast and reliable delivery<br>across 190+ countries.",
				),
			),
		),
		'funnel'  => $funnel_sms,
		'cta'     => $shared_cta,
	),
	'whatsapp'          => array(
		'hero'    => array(
			'title'    => 'Power Business<br>Communication Through<br>WhatsApp Business',
			'subtitle' => 'Deliver rich, interactive conversations with WhatsApp Business. Engage customers with product catalogs, order updates?all from one intelligent communication platform.',
			'cta_text' => "Let's Get Started",
			'cta_url'  => '',
		),
		'pills'   => array(
			"Instant Whatsapp<br>Delivery",
			"Global<br>Coverage",
			"Seamless<br>Experience",
		),
		'journey' => array(
			'title' => 'Everything You Need to Power<br>WhatsApp Conversations',
			'lead'  => 'Keep customers engaged with interactive messaging, rich media, product catalogs, automated replies, and personalized conversations that drive better customer experiences',
		),
		'scale'   => array(
			'title' => 'Built for Scale. Designed for<br>Meaningful Conversations.</span>',
			'lead'  => 'Empower businesses to engage customers through personalized messaging WhatsApp Business solutions.',
		),
		'benefits' => array(
			'title' => 'Benefits That Grow Customer Engagement',
			'lead'  => 'Boost customer engagement with personalized WhatsApp conversations, rich media messaging and real-time support.',
		),
		'why'     => array(
			'title' => 'Power Every Customer<br>Journey Through WhatsApp',
			'lead'  => 'Deliver personalized conversations that engage customers before, during, and after every purchase.',
		),
		'funnel_heading' => array(
			'title' => 'Power Every Stage of<br>WhatsApp Customer Journey',
			'lead'  => 'Guide customers from discovery to loyalty with personalized WhatsApp conversations and intelligent automation.',
		),
		'faq'     => array(
			'title' => 'Everything You Need to Know<br>About WhatsApp Business',
			'lead'  => 'Find answers to common questions about WhatsApp Business messaging, automation, verification, customer engagement, security, and platform capabilities.',
			'items' => array(
				array( 'question' => 'What is the WhatsApp Business Platform?' ),
				array( 'question' => 'Can Growtele automate WhatsApp conversations?' ),
				array( 'question' => 'Can I send product catalogs through WhatsApp?' ),
				array( 'question' => 'Is WhatsApp suitable for customer support?' ),
				array( 'question' => 'Can I integrate WhatsApp with my CRM?' ),
			),
		),
		'funnel'  => $funnel_whatsapp,
		'cta'     => $shared_cta,
	),
	'email'             => array(
		'hero'    => array(
			'title'    => 'Power Business<br>Communication<br>Through Enterprise Email',
			'subtitle' => 'Reach customers with secure, personalized, and high-performing email campaigns, transactional notifications, newsletters, and automated customer journeys.',
			'cta_text' => "Let's Get Started",
			'cta_url'  => '',
		),
		'pills'   => array(
			'High Inbox Delivery',
			'Global Coverage',
			'Advanced Analytics',
		),
		'journey' => array(
			'title' => 'Reliable Email for Every<br>Customer Journey',
			'lead'  => 'Keep customers engaged with transactional emails, promotional campaigns, newsletters, and automated lifecycle communication.',
		),
		'scale'   => array(
			'title' => 'Built for Scale. <span>Designed for Deliverability.</span>',
			'lead'  => 'Power business communication with enterprise-grade email infrastructure built for high inbox placement and reliable delivery.',
		),
		'benefits' => array(
			'title' => 'Benefits That Drive<br>Business Growth.',
			'lead'  => 'Grow your business with personalized email campaigns, intelligent automation, and powerful performance insights.',
		),
		'why'     => array(
			'title' => 'Why Email Remains the Most<br>Powerful Business Channel',
			'lead'  => 'Growtele Email helps businesses deliver meaningful customer experiences.',
		),
		'funnel_heading' => array(
			'title' => 'Power every stage of<br>Customer Email Journey',
			'lead'  => 'Guide customers from first contact to long-term loyalty with personalized, automated email communication.',
		),
		'faq'     => array(
			'title' => 'Everything You Need to Know<br>About Growtele Email',
			'lead'  => 'Find answers to common questions about email delivery, automation, analytics, security, templates, and campaign management.',
			'items' => array(),
		),
		'funnel'  => $funnel_email,
		'cta'     => $shared_cta,
	),
	'rcs'               => array(
		'hero'    => array(
			'title'    => 'Power Interactive<br>Customer Engagement<br>Through RCS',
			'subtitle' => 'Deliver branded, interactive, and media-rich messaging experiences with verified sender profiles, rich cards, carousels, suggested replies, and real-time customer engagement.',
			'cta_text' => "Let's Get Started",
			'cta_url'  => '',
		),
		'pills'   => array(
			'High Inbox Delivery',
			'Global Coverage',
			'Real-Time Analytics',
		),
		'journey' => array(
			'title' => 'Reliable RCS for Every<br>Customer Journey',
			'lead'  => 'Deliver engaging customer experiences with branded messages, rich media, interactive cards, product carousels, and actionable conversations.',
		),
		'scale'   => array(
			'title' => 'Built for Scale. <span>Designed for Engagement.</span>',
			'lead'  => 'Deliver visually rich conversations that increase customer engagement and improve conversion rates.',
		),
		'benefits' => array(
			'title' => 'Benefits That Drive<br>Customer Engagement',
			'lead'  => 'Create meaningful conversations with interactive messaging, personalized content, and real-time customer interactions.',
		),
		'why'     => array(
			'title' => 'Why RCS is the Future of<br>Business Messaging',
			'lead'  => 'Deliver app-like messaging experiences that combine branding, multimedia, and interactivity within the native messaging app.',
		),
		'funnel_heading' => array(
			'title' => 'Power Every Stage of the<br>Customer RCS Journey',
			'lead'  => 'Guide customers from discovery to conversion through personalized RCS conversations.',
		),
		'faq'     => array(
			'title' => 'Everything You Need to Know<br>About Growtele RCS',
			'lead'  => 'Find answers to common questions about verified messaging, rich media, interactive features, analytics, and enterprise communication.',
			'items' => array(),
		),
		'funnel'  => $funnel_rcs,
		'cta'     => $shared_cta,
	),
	'cloud-telephony'   => array(
		'hero'    => array(
			'title'    => 'Power Business<br>Communication Through<br>Cloud Telephony',
			'subtitle' => 'Manage inbound and outbound calls, IVR, call routing, virtual numbers, and real-time customer conversations from a single cloud-based platform.',
			'cta_text' => "Let's Get Started",
			'cta_url'  => '',
		),
		'pills'   => array(
			'Smart Call Routing',
			"Multi-<br>Level IVR",
			'Real-Time Analytics',
		),
		'journey' => array(
			'title' => 'Reliable Cloud Telephony<br>for Every Customer Journey',
			'lead'  => 'Handle every customer call with intelligent routing, automated IVR, call tracking, and enterprise-grade voice infrastructure.',
		),
		'scale'   => array(
			'title' => 'Built for Scale. Designed<br>for Reliable Conversations.</span>',
			'lead'  => 'Power customer communication with cloud-based voice infrastructure built for speed, reliability, and business continuity.',
		),
		'benefits' => array(
			'title' => 'Benefits That Drive Better<br>Customer Communication',
			'lead'  => 'Deliver seamless voice experiences with intelligent call management, automation, and actionable insights',
		),
		'why'     => array(
			'title' => 'Why Cloud Telephony Powers<br>Modern Customer Support',
			'lead'  => 'Deliver seamless voice communication with automated call handling, intelligent routing, and cloud-based reliability.',
		),
		'funnel_heading' => array(
			'title' => 'Power Every Stage of the<br>Customer Call Journey',
			'lead'  => 'Deliver seamless voice experiences from the first call to post-support follow-ups with intelligent cloud telephony.',
		),
		'faq'     => array(
			'title' => 'Everything You Need to Know<br>About Growtele Cloud Telephony',
			'lead'  => 'Find answers about IVR, call routing, virtual numbers, call recording, analytics, and enterprise voice solutions.',
			'items' => array(),
		),
		'funnel'  => $funnel_cloud,
		'cta'     => $shared_cta,
	),
);
