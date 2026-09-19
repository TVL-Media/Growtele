<?php
/**
 * Industry page CMS defaults (must match pages/{slug}/index.html).
 *
 * @package Growtele
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$shared_industry_cta = array(
	'heading'     => "              Power Smarter Customer<br>\n              Conversations at Scale",
	'description' => 'Engage customers across SMS, WhatsApp, RCS, Email, and Voice through one unified communication platform built for reliability, performance, and growth',
	'button_text' => 'Get Started',
	'button_url'  => '',
);

$shared_hero_cta = array(
	'cta_primary'   => 'Talk to an Expert',
	'cta_secondary' => 'Explore Solutions',
	'cta_primary_url' => '',
);

$shared_faq_book = array(
	'title'       => 'Book a 15 Min Call',
	'description' => 'If you have any questions, just book a 15-min call with us before subscribing',
	'button_text' => 'Book a Free Call',
);

return array(
	'retail'     => array(
		'hero'     => array_merge(
			$shared_hero_cta,
			array(
				'title' => 'Transform Every Shopping Experience into Customer Loyalty',
				'desc'  => 'Deliver personalized promotions, real-time order updates, loyalty campaigns, and post-purchase engagement across SMS, WhatsApp, RCS, Email, and Voice.',
			)
		),
		'channels' => array(
			'title'    => 'Retail Communication Across Every Channel',
			'subtitle' => 'Deliver personalized shopping experiences through WhatsApp, SMS, RCS, Email, and Cloud Telephony.',
		),
		'growth'    => array(
			'title'    => 'Driving Measurable Growth for Modern Retail Brands',
			'subtitle' => 'Empower every customer interaction with personalized communication, real-time engagement, and intelligent automation that drives higher conversions.',
		),
		'use_cases' => array(
			'title' => 'Communication Use Cases for Every Retail Scenario',
		),
		'faq'      => array(
			'title' => 'Everything You Need to Know<br>About Retail Communication',
			'intro' => 'Find answers to common questions about retail messaging, personalized campaigns, customer engagement, order updates, loyalty programs.',
			'book'  => $shared_faq_book,
			'items' => array(
				array(
					'question' => 'How can Growtele improve customer engagement for retailers?',
					'answer'   => 'Growtele enables retailers to engage customers with personalized campaigns, product recommendations, real-time notifications, and interactive conversations across WhatsApp, SMS, RCS, Email, and Voice.',
				),
				array( 'question' => 'Which communication channels does Growtele support?' ),
				array( 'question' => 'Can Growtele automate order and delivery updates?' ),
				array( 'question' => 'Does Growtele help recover abandoned carts?' ),
				array( 'question' => 'Is Growtele suitable for both online and offline retailers?' ),
			),
		),
		'cta'      => $shared_industry_cta,
	),
	'health'     => array(
		'hero'     => array_merge(
			$shared_hero_cta,
			array(
				'title' => 'Transform Every Patient Interaction into Better Care Experiences',
				'desc'  => 'Deliver appointment reminders, OTP verification, prescription updates, lab reports, vaccination alerts, and patient engagement across WhatsApp, SMS, RCS, Email, and Voice.',
			)
		),
		'channels' => array(
			'title'    => '<span class="section-title__line">Healthcare Communication</span><span class="section-title__line">Across Every Channel</span>',
			'subtitle' => 'Deliver secure patient communication through<br>WhatsApp, SMS, RCS, Email, and Cloud Telephony.',
		),
		'growth'    => array(
			'title'    => 'Driving Better Patient Engagement',
			'subtitle' => 'Empower healthcare providers with secure communication, appointment reminders, automated updates, and personalized patient engagement.',
		),
		'use_cases' => array(
			'title' => 'Communication Use Cases for Modern Healthcare',
		),
		'faq'       => array(
			'title' => 'Everything You Need to Know<br>About Banking Communication',
			'intro' => 'Find answers about secure messaging, OTP authentication, transaction alerts, compliance, fraud prevention, and omnichannel banking.',
			'book'  => $shared_faq_book,
			'items' => array(
				array( 'question' => 'How can Growtele improve patient communication?' ),
				array( 'question' => 'Does Growtele support appointment reminders?' ),
				array( 'question' => 'Can healthcare providers send lab reports securely?' ),
				array( 'question' => 'Is patient data communication secure?' ),
				array( 'question' => 'Which communication channels does Growtele support?' ),
			),
		),
		'cta'      => $shared_industry_cta,
	),
	'banking'    => array(
		'hero'     => array_merge(
			$shared_hero_cta,
			array(
				'title' => 'Secure Every Banking Interaction with Intelligent Customer Communication',
				'desc'  => 'Deliver secure OTPs, transaction alerts, loan updates, payment reminders, and personalized banking experiences through SMS, WhatsApp, RCS, Email, and Voice.',
			)
		),
		'channels' => array(
			'title'    => 'Banking Communication Across Every Channel',
			'subtitle' => 'Deliver personalized shopping experiences through WhatsApp, SMS, RCS, Email, and Cloud Telephony.',
		),
		'growth'    => array(
			'title'    => 'Driving Trust Through Smarter Banking Communication',
			'subtitle' => 'Empower banks and financial institutions with secure customer communication, instant notifications, fraud alerts, and personalized engagement.',
		),
		'use_cases' => array(
			'title' => 'Communication Use Cases<br>for Modern Banking',
		),
		'faq'      => array(
			'title' => 'Everything You Need to Know<br>About Banking Communication',
			'intro' => 'Find answers about secure messaging, OTP authentication, transaction alerts, compliance, fraud prevention, and omnichannel banking.',
			'book'  => $shared_faq_book,
			'items' => array(
				array( 'question' => 'How does Growtele improve customer communication for banks?' ),
				array( 'question' => 'Does Growtele support secure OTP authentication?' ),
				array( 'question' => 'Can Banks automate transaction notifications?' ),
				array( 'question' => 'Does Growtele support regulatory and security requirements?' ),
				array( 'question' => 'Which communication channels are available for banks?' ),
			),
		),
		'cta'      => $shared_industry_cta,
	),
	'travelling' => array(
		'hero'     => array_merge(
			$shared_hero_cta,
			array(
				'title' => 'Transform Every Journey into Exceptional Travel Experiences',
				'desc'  => 'Deliver booking confirmations, itinerary updates, check-in reminders, flight alerts, and personalized travel communication across WhatsApp, SMS, RCS, Email, and Voice.',
			)
		),
		'channels' => array(
			'title'    => 'Travel Communication Across Every Channel',
			'subtitle' => 'Deliver timely travel updates and personalized experiences through WhatsApp, SMS, RCS, Email, and Cloud Telephony.',
		),
		'growth'    => array(
			'title'    => 'Driving Seamless Travel Experiences',
			'subtitle' => 'Keep travelers informed at every step with automated notifications, real-time updates, and personalized travel communication.',
		),
		'use_cases' => array(
			'title' => 'Communication Use Cases<br>for Every Travel Journey',
		),
		'faq'       => array(
			'title' => 'Everything You Need to Know<br>About Travel Communication',
			'intro' => 'Find answers about booking confirmations, travel alerts, itinerary updates, customer engagement, and omnichannel communication.',
			'book'  => $shared_faq_book,
			'items' => array(
				array( 'question' => 'How can Growtele improve travel communication?' ),
				array( 'question' => 'Does Growtele support booking confirmations?' ),
				array( 'question' => 'Can travelers receive real-time flight updates?' ),
				array( 'question' => 'Which communication channels does Growtele support?' ),
			),
		),
		'cta'      => $shared_industry_cta,
	),
	'ecommerce'  => array(
		'hero'     => array_merge(
			$shared_hero_cta,
			array(
				'title' => 'Transform Every Shopping Journey Into Meaningful Customer Conversations',
				'desc'  => 'Deliver personalized shopping experiences across WhatsApp, SMS, RCS, Email, and Cloud Telephony. Engage customers from product discovery to post-purchase support with intelligent, omnichannel communication.',
			)
		),
		'channels' => array(
			'title'    => 'Trusted by Growing<br>E-Commerce Brands',
			'subtitle' => 'Helping online businesses increase engagement, recover abandoned carts, automate customer support, and boost repeat purchases through intelligent communication.',
		),
		'growth'    => array(
			'title'    => 'Driving Measurable Growth for<br>Modern E-Commerce Brands',
			'subtitle' => 'Turn every visitor into a loyal customer with personalized messaging, automated customer journeys, and real-time engagement.',
		),
		'use_cases' => array(
			'title' => 'Communication Use Cases for<br>Every E-Commerce Journey',
		),
		'faq'       => array(
			'title' => 'Everything You Need to Know About<br>E-Commerce Communication',
			'intro' => 'Find answers to common questions about retail messaging, personalized campaigns, customer engagement, order updates, loyalty programs.',
			'book'  => $shared_faq_book,
			'items' => array(
				array( 'question' => 'How does Growtele recover abandoned carts?' ),
				array( 'question' => 'Which channels are supported?' ),
				array( 'question' => 'Can Growtele send order updates automatically?' ),
				array( 'question' => 'Can I integrate with Shopify or WooCommerce?' ),
				array( 'question' => 'Does Growtele support personalized campaigns?' ),
			),
		),
		'cta'      => $shared_industry_cta,
	),
	'education'  => array(
		'hero'     => array_merge(
			$shared_hero_cta,
			array(
				'title' => 'Transform Every Learning Journey Into Meaningful Student Experiences',
				'desc'  => 'Empower educational institutions with intelligent communication across WhatsApp, SMS, RCS, Email, and Cloud Telephony. Simplify admissions, engage students, automate notifications, and strengthen parent communication through one unified platform.',
			)
		),
		'channels' => array(
			'title'    => 'Trusted by Leading Educational Institutions',
			'subtitle' => 'Helping schools, colleges, universities, and EdTech platforms improve student engagement, streamline academic communication, and deliver seamless learning experiences.',
		),
		'growth'    => array(
			'title'    => 'Deliver Smarter<br>Education Experiences',
			'subtitle' => 'From student enrollment to alumni engagement, Growtele helps educational institutions automate communication, improve collaboration, and enhance learning outcomes.',
		),
		'use_cases' => array(
			'title' => 'Communication Use Cases for Every Student Journey',
		),
		'faq'       => array(
			'title' => 'Everything You Need to Know<br>About Education Communication',
			'intro' => 'Find answers to common questions about admissions, student engagement, academic notifications, parent communication, and education automation',
			'book'  => $shared_faq_book,
			'items' => array(
				array( 'question' => 'How does Growtele improve student communication?' ),
				array( 'question' => 'Can parents receive attendance and academic updates?' ),
				array( 'question' => 'Does Growtele support admission automation?' ),
				array( 'question' => 'Can Growtele integrate with Student Information Systems (SIS)?' ),
				array( 'question' => 'Which communication channels are supported?' ),
			),
		),
		'cta'      => $shared_industry_cta,
	),
	'logistic'   => array(
		'hero'     => array_merge(
			$shared_hero_cta,
			array(
				'title' => 'Transform Every Delivery Journey Into Exceptional Customer Experiences',
				'desc'  => 'Deliver real-time shipment updates, pickup notifications, delivery alerts, OTP verification, driver communication, and customer support across WhatsApp, SMS, RCS, Email, and Cloud Telephony.',
			)
		),
		'channels' => array(
			'title'    => 'Trusted by Leading Logistics<br>& Transportation Companies',
			'subtitle' => 'Helping logistics providers streamline operations, improve delivery visibility, reduce support calls, and deliver exceptional customer experiences through intelligent communication.',
		),
		'growth'    => array(
			'title'    => 'Deliver Reliable Logistics Communication at Every Step',
			'subtitle' => 'Turn every visitor into a loyal customer with personalized messaging, automated customer journeys, and real-time engagement.',
		),
		'use_cases' => array(
			'title' => 'Communication Use Cases for<br>Every Logistics Journey',
		),
		'faq'       => array(
			'title' => 'Everything You Need to Know<br>About Logistics Communication',
			'intro' => 'Find answers to common questions about shipment notifications, delivery tracking, driver communication, customer engagement, and logistics automation.',
			'book'  => $shared_faq_book,
			'items' => array(
				array( 'question' => 'How does Growtele improve shipment tracking communication?' ),
				array( 'question' => 'Does Growtele support OTP verification for deliveries?' ),
				array( 'question' => 'Can Growtele integrate with logistics management systems?' ),
				array( 'question' => 'Which communication channels are supported?' ),
				array( 'question' => 'Can customers receive delivery updates on WhatsApp?' ),
			),
		),
		'cta'      => $shared_industry_cta,
	),
);
