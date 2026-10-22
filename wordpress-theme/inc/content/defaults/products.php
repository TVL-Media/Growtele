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
	'heading'     => "              Reach Every Customer<br>\n              on the Right Channel",
	'description' => 'Send OTPs, alerts, promotions, and support messages on SMS, WhatsApp, RCS, Email, and Voice from one dependable platform built for enterprise volumes',
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
		'alt' => 'SMS engagement campaign',
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
		'alt' => 'WhatsApp engagement flow',
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
		'alt' => 'RCS engagement campaign',
	),
	'retention'   => array(
		'src' => 'assets/rcs-retim.png',
		'alt' => 'Retention campaign flow',
	),
);

$funnel_cloud = array(
	'acquisition' => array(
		'src' => 'https://listings.selectvia.com/wp-content/uploads/2026/10/52f4d20d63be4bb3cc39a2f8d69dd56826f48de9.png',
		'alt' => 'Acquisition campaign flow',
	),
	'engagement'  => array(
		'src' => 'https://listings.selectvia.com/wp-content/uploads/2026/10/7de953a47463ef06e535efbdcd02e4dc8d50e570.png',
		'alt' => 'Engagement campaign flow',
	),
	'retention'   => array(
		'src' => 'https://listings.selectvia.com/wp-content/uploads/2026/10/d796b4e36ec731801877aa1fdb3c53b2ba6037cc.png',
		'alt' => 'Retention campaign flow',
	),
);

return array(
	'sms'               => array(
		'hero'    => array(
			'title'    => 'Reach Everyone<br>on Any Mobile Phone<br>With  SMS',
			'subtitle' => 'Send OTPs, payment alerts, and festive offers that reach any mobile in seconds, without internet or apps.',
			'cta_text' => "Book a Demo",
			'cta_url'  => '',
		),
		'pills'   => array(
			'OTPs Within Seconds',
			'DLT-Ready Templates',
			'Real-Time Reports',
		),
		'journey' => array(
			'title' => 'The Right  SMS for<br>Every Touchpoint',
			'lead'  => 'Send login OTPs, order and shipping updates, appointment reminders, and festive promotions, then answer whenever customers text back, all from one Growtele dashboard built for volume.',
		),
		'scale'   => array(
			'title' => 'Built for Scale. <span>Designed for Reliability.</span>',
			'lead'  => 'Send millions of SMS daily with intelligent routing, DLT-ready templates, and delivery reports for each one.',
		),
		'benefits' => array(
			'title' => 'What You Gain With<br>the Growtele SMS API.',
			'lead'  => 'Growtele SMS helps you deliver critical messages at the<br>right time with highest reliability and complete visibility.',
		),
		'why'     => array(
			'title' => 'Why SMS Stays the<br>Most Trusted Channel',
			'lead'  => 'SMS reaches every handset without apps or internet, so banks and retailers depend on it for authentication.',
		),
		'funnel_heading' => array(
			'title' => ' SMS for every<br>stage of your funnel',
			'lead'  => 'From attracting new customers to retaining your best ones,<br>Growtele SMS API helps you engage, convert and retain every step.',
		),
		'faq'     => array(
			'title' => 'Everything You Need to Know<br>About Growtele SMS',
			'lead'  => 'Quick answers about SMS delivery speed, OTP authentication, delivery reports, enterprise volumes, DLT rules, and  campaigns.',
			'items' => array(
				array(
					'question' => 'How fast do SMS messages get delivered?',
					'answer'   => "Growtele delivers OTPs, alerts, and  SMS campaigns in seconds,<br>with live delivery reports for each message, to phones in India and<br>across 190+ countries.",
				),
				array(
					'question' => 'Does Growtele support OTP authentication?',
					'answer'   => "Yes. Our OTP API sends login, sign-up, and payment codes over priority transactional routes, so they reach customers within seconds, and you can track the delivery status of every code.",
				),
				array(
					'question' => 'Do you provide delivery reports and analytics?',
					'answer'   => "Yes. Every message comes with a live delivery report showing whether it was delivered, pending, or failed, and the dashboard rolls it all up into campaign analytics you can review anytime.",
				),
				array(
					'question' => 'Is Growtele SMS built for enterprise-scale volumes?',
					'answer'   => "Yes. You can send millions of SMS a day with intelligent routing across operators, DLT-ready templates, and reliable delivery to phones in India and 190+ countries.",
				),
				array(
					'question' => 'Can I run  SMS campaigns?',
					'answer'   => "Yes. Upload your contact list, pick a DLT-approved template, personalize it with names or offers, and schedule it for the right time. Then track deliveries for the whole campaign from your dashboard.",
				),
			),
		),
		'funnel'  => $funnel_sms,
		'cta'     => $shared_cta,
	),
	'whatsapp'          => array(
		'hero'    => array(
			'title'    => '<span class="hero__title-dl">Sell, Support, <br>and</span> <span class="hero__title-dl">Grow on WhatsApp</span><br><span class="hero__title-dl">Business Platform</span>',
			'subtitle' => 'Send order updates, share product catalogs, collect payments, and answer support questions on WhatsApp, the messaging app your customers already check constantly.',
			'cta_text' => "Book a Demo",
			'cta_url'  => '',
		),
		'pills'   => array(
			"Product Catalogs<br>&amp; Carts",
			"Secure<br>Payments",
			"Shared<br>Team Inbox",
		),
		'journey' => array(
			'title' => 'Everything You Need to Power<br>WhatsApp Conversations',
			'lead'  => 'Send utility alerts, marketing offers, and service replies, with rich media, product catalogs, quick-reply buttons, and chatbots that answer customers at any hour.',
		),
		'scale'   => array(
			'title' => 'Built for Scale. Designed<br>for Two-way Customer Chats.</span>',
			'lead'  => 'Share photographs, explainer videos, product catalogs, and reply buttons customers tap to buy.',
		),
		'benefits' => array(
			'title' => 'Why Brands Use WhatsApp Business API',
			'lead'  => 'Reach customers inside the messaging app they open daily, with rich media, instant answers, live support.',
		),
		'why'     => array(
			'title' => 'Before, During, and<br>After Every Online Order',
			'lead'  => 'Greet new shoppers, suggest products, confirm orders, and recover abandoned carts on WhatsApp.',
		),
		'funnel_heading' => array(
			'title' => 'Power Every Stage of<br>WhatsApp Customer Journey',
			'lead'  => 'Win buyers with Click-to-WhatsApp ads, sell through product catalogs, and keep them coming back with rewards.',
		),
		'faq'     => array(
			'title' => 'Everything You Need to Know<br>About WhatsApp Business',
			'lead'  => 'Answers about the WhatsApp Business Platform, chatbots, product catalogs, green tick verification, customer support, encryption, and CRM integration.',
			'items' => array(
				array( 'question' => 'What is the WhatsApp Business Platform?' ),
				array( 'question' => 'Can Growtele automate WhatsApp conversations?' ),
				array( 'question' => 'Can I share my product catalog on WhatsApp?' ),
				array( 'question' => 'Does WhatsApp work for customer support?' ),
				array( 'question' => 'Can I integrate WhatsApp with my CRM?' ),
			),
		),
		'funnel'  => $funnel_whatsapp,
		'cta'     => $shared_cta,
	),
	'email'             => array(
		'hero'    => array(
			'title'    => ' <span class="hero__title-dl">Email &amp; <br>SMTP</span> <span class="hero__title-dl">Delivery <br>Straight</span> <span class="hero__title-dl">to the Inbox.</span>',
			'subtitle' => 'Deliver transactional notifications, OTPs, invoices, and promotional newsletters through our Email API or SMTP relay, authenticated for inbox placement.',
			'cta_text' => "Book a Demo",
			'cta_url'  => '',
		),
		'pills'   => array(
			'Strong Inbox Rates',
			'Email API, SMTP',
			'Live Email Reports',
		),
		'journey' => array(
			'title' => '<span class="journey__title-dl">Transactional, OTP</span> <span class="journey__title-dl">and <br>Marketing Email</span>',
			'lead'  => 'Send OTPs, order confirmations, and promotional newsletters from one account, then track deliveries, opens, and clicks.',
		),
		'scale'   => array(
			'title' => 'Built for Scale. <span>Designed for Deliverability.</span>',
			'lead'  => 'Send high volumes on infrastructure tuned for inbox placement, with SPF, DKIM, and DMARC authentication configured for you.',
		),
		'benefits' => array(
			'title' => 'Why Brands Choose<br>Growtele Email.',
			'lead'  => 'Land in the inbox, automate follow-ups and reminders, and measure which campaigns drive opens and purchases.',
		),
		'why'     => array(
			'title' => 'Why Email Remains the Most<br>Powerful Business Channel',
			'lead'  => 'Customers check their inbox daily, so transactional emails get noticed.',
		),
		'funnel_heading' => array(
			'title' => 'From First Sign-Up<br>to the Repeat Purchase',
			'lead'  => 'Welcome new subscribers, recover abandoned carts, and reward your loyal customers with automated emails.',
		),
		'faq'     => array(
			'title' => 'Everything You Need to Know<br>About Growtele Email',
			'lead'  => 'Answers on deliverability, SMTP setup, automation, personalization, analytics, security, templates, and campaign reporting.',
			'items' => array(),
		),
		'funnel'  => $funnel_email,
		'cta'     => $shared_cta,
	),
	'rcs'               => array(
		'hero'    => array(
			'title'    => 'Engage Customers<br>With RCS Business<br>Messaging',
			'subtitle' => 'Send branded messages featuring your logo, verified sender ID, rich media, product carousels, and smart replies, directly inside the handset\'s default messaging app.',
			'cta_text' => "Book a Demo",
			'cta_url'  => '',
		),
		'pills'   => array(
			'Verified Sender ID',
			'Fallback <br class="hero__pill-br">to SMS',
			'Live Read Receipts',
		),
		'journey' => array(
			'title' => 'Branded RCS for Every<br>Customer Journey',
			'lead'  => 'Display your verified logo, send images and product carousels, and let customers book appointments, pay invoices, or reply instantly.',
		),
		'scale'   => array(
			'title' => 'Built for Scale. <span>Designed for Engagement.</span>',
			'lead'  => 'Rich cards and one-tap buttons turn simple messages into bookings, purchases, and UPI payments.',
		),
		'benefits' => array(
			'title' => 'What Brands Achieve<br>With RCS Business',
			'lead'  => 'Turn plain texts into tappable conversations featuring buttons, images, product carousels, and suggested replies.',
		),
		'why'     => array(
			'title' => 'Why Brands Upgrade<br>From Plain SMS to RCS',
			'lead'  => 'RCS puts your branding, multimedia, and buttons inside the phone\'s built-in messaging app, so customers need no download.',
		),
		'funnel_heading' => array(
			'title' => 'RCS for Every Stage of<br>the Customer Journey',
			'lead'  => 'Attract, engage, and retain customers through branded, interactive RCS messaging.',
		),
		'faq'     => array(
			'title' => 'Everything You Need to Know<br>About Growtele RCS',
			'lead'  => 'Answers about RCS Business Messaging, rich media, product carousels, verified sender ID, smart replies, and campaign analytics.',
			'items' => array(),
		),
		'funnel'  => $funnel_rcs,
		'cta'     => $shared_cta,
	),
	'cloud-telephony'   => array(
		'hero'    => array(
			'title'    => '<span class="hero__title-dl">Answer Faster <br>via</span> <span class="hero__title-dl">Cloud Telephony</span><br><span class="hero__title-dl">&amp; Voice</span>',
			'subtitle' => 'Run IVR, outbound calls, missed call campaigns, voice OTP, and number masking from one cloud platform, without installing any PBX hardware.',
			'cta_text' => "Book a Demo",
			'cta_url'  => '',
		),
		'pills'   => array(
			'Smart Call Routing',
			"Multi-<br>Level IVR",
			'Live Call Analytics',
		),
		'journey' => array(
			'title' => 'One Voice Platform for<br>Inbound &amp; Outbound Calls',
			'lead'  => 'Answer inbound calls with IVR, run outbound campaigns, and capture leads automatically from every missed call you receive.',
		),
		'scale'   => array(
			'title' => 'Complete Voice Services<br>All From a Single Provider.</span>',
			'lead'  => 'Get virtual numbers, call management, and cloud calling in one account, without purchasing or maintaining PBX hardware.',
		),
		'benefits' => array(
			'title' => 'Benefits That Help Agents<br>Resolve Calls Faster',
			'lead'  => 'Route callers to the right agent, automate frequent questions through IVR, and track conversations.',
		),
		'why'     => array(
			'title' => 'Why Cloud Telephony Powers<br>Modern Customer Support',
			'lead'  => 'Some problems need a real conversation. Voice connects customers to the right person without frustrating queues.',
		),
		'funnel_heading' => array(
			'title' => 'Use Voice at Every Stage<br>of the Buyer Journey',
			'lead'  => 'Capture leads with missed calls, follow up through outbound campaigns, and retain buyers with feedback calls.',
		),
		'faq'     => array(
			'title' => 'Everything You Need to Know<br>About Growtele Cloud Telephony',
			'lead'  => 'Answers on IVR, call routing, virtual numbers, call recording, CRM integration, and enterprise-scale deployments.',
			'items' => array(),
		),
		'funnel'  => $funnel_cloud,
		'cta'     => $shared_cta,
	),
);
