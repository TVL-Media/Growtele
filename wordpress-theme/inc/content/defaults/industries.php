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
	'heading'     => "              Reach Every Customer<br>\n              on the Right Channel",
	'description' => 'Send OTPs, alerts, promotions, and support messages on SMS, WhatsApp, RCS, Email, and Voice from one dependable platform built for enterprise volumes',
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
	'description' => 'Got questions? Book a 15-min call and we\'ll walk you through the right setup.',
	'button_text' => 'Book a Free Call',
);

return array(
	'retail'     => array(
		'hero'     => array_merge(
			$shared_hero_cta,
			array(
				'title' => 'Transform Every Shopping Experience into Customer Loyalty',
				'desc'  => 'Send festive offers, order updates, loyalty points, and back-in-stock alerts on SMS, WhatsApp, RCS, Email, and Voice, all from a single dashboard.',
			)
		),
		'channels' => array(
			'title'    => 'Retail Conversations Across Each Channel',
			'subtitle' => 'Deliver promotions and order updates where shoppers read: WhatsApp, SMS, RCS, Email, and Voice.',
		),
		'growth'    => array(
			'title'    => 'Driving Measurable Growth for Modern Retail Brands',
			'subtitle' => 'Run targeted campaigns, answer shopper questions instantly, and keep customers returning with loyalty points, member-only offers, and festive deals.',
		),
		'use_cases' => array(
			'title' => 'Retail Use Cases That Bring Shoppers Back to Buy',
		),
		'faq'      => array(
			'title' => 'Everything You Need to Know<br>About Retail Communication',
			'intro' => 'Get answers on cart recovery, COD confirmation, order updates, loyalty offers, store integrations, and the channels we support.',
			'book'  => $shared_faq_book,
			'items' => array(
				array(
					'question' => 'How does Growtele help retail brands win more repeat sales?',
					'answer'   => 'Retailers send targeted promotions, pickup notifications, cart reminders, and loyalty messages across WhatsApp, SMS, RCS, Email, and Voice with Growtele, and answer shopper questions from one inbox.',
				),
				array( 'question' => 'Which communication channels does Growtele support?' ),
				array( 'question' => 'Can Growtele automate order and delivery updates?' ),
				array( 'question' => 'Does Growtele help recover abandoned carts?' ),
				array( 'question' => 'Does Growtele work for online stores and in-store retail?' ),
			),
		),
		'cta'      => $shared_industry_cta,
	),
	'health'     => array(
		'hero'     => array_merge(
			$shared_hero_cta,
			array(
				'title' => 'Transform Every Patient Interaction into Better Care Experiences',
				'desc'  => 'Send appointment reminders, lab reports, prescription refill alerts, vaccination due dates, and teleconsultation links to patients on WhatsApp, SMS, RCS, Email, and Voice.',
			)
		),
		'channels' => array(
			'title'    => '<span class="section-title__line">Healthcare Communication</span><span class="section-title__line">Across Every Channel</span>',
			'subtitle' => 'Share reminders and lab reports securely via<br>WhatsApp, SMS, RCS, Email, and IVR Voice calls.',
		),
		'growth'    => array(
			'title'    => 'Driving Better Patient Engagement',
			'subtitle' => 'Empower healthcare providers with secure communication, appointment reminders, automated updates, and personalized patient engagement.',
		),
		'use_cases' => array(
			'title' => 'Use Cases Across Every Step of Patient Care',
		),
		'faq'       => array(
			'title' => 'Everything You Need to Know<br>About Patient Communication',
			'intro' => 'Find answers on appointment reminders, lab report delivery, prescription refills, patient data security, and supported channels.',
			'book'  => $shared_faq_book,
			'items' => array(
				array( 'question' => 'How can Growtele improve patient communication?' ),
				array( 'question' => 'Does Growtele support appointment reminders?' ),
				array( 'question' => 'Can healthcare providers send lab reports securely?' ),
				array( 'question' => 'Is patient data secure with Growtele?' ),
				array( 'question' => 'Which communication channels does Growtele support?' ),
			),
		),
		'cta'      => $shared_industry_cta,
	),
	'banking'    => array(
		'hero'     => array_merge(
			$shared_hero_cta,
			array(
				'title' => 'Send OTPs, Transaction Alerts, and EMI Reminders Your Customers Trust',
				'desc'  => 'Send OTPs, transaction alerts, EMI reminders, KYC updates, and fraud alerts on SMS, WhatsApp, RCS, Email, and Voice, with automatic fallback to SMS.',
			)
		),
		'channels' => array(
			'title'    => 'Banking Communication Across Every Channel',
			'subtitle' => 'Reach account holders on WhatsApp, SMS, RCS, Email, and Voice, with dependable SMS fallback.',
		),
		'growth'    => array(
			'title'    => 'Bank Messages Your Account Holders Open and Trust',
			'subtitle' => 'Banks, NBFCs, insurers, and fintechs rely on Growtele for OTPs, fraud alerts, EMI reminders, and account notifications customers trust.',
		),
		'use_cases' => array(
			'title' => 'Everyday Use Cases for<br>Banks and Lenders',
		),
		'faq'      => array(
			'title' => 'Everything You Need to Know<br>About Banking Communication',
			'intro' => 'Find answers about OTP delivery, transaction alerts, DLT compliance, fraud notifications, data security, and supported channels.',
			'book'  => $shared_faq_book,
			'items' => array(
				array( 'question' => 'How does Growtele help banks and lenders reach customers?' ),
				array( 'question' => 'Can Growtele send OTPs for logins and payments?' ),
				array( 'question' => 'Can banks automate debit and credit alerts?' ),
				array( 'question' => 'Does Growtele meet DLT rules and banking security needs?' ),
				array( 'question' => 'Which messaging channels can banks use with Growtele?' ),
			),
		),
		'cta'      => $shared_industry_cta,
	),
	'travelling' => array(
		'hero'     => array_merge(
			$shared_hero_cta,
			array(
				'title' => 'Transform Every Journey into Exceptional Travel Experiences',
				'desc'  => 'Send booking confirmations, PNR and flight status, check-in reminders, e-tickets, and refund status updates to travelers on WhatsApp, SMS, RCS, Email, and Voice.',
			)
		),
		'channels' => array(
			'title'    => 'Travel Updates on Every Channel They Use',
			'subtitle' => 'Reach travelers on whichever channel they check first: WhatsApp, SMS, RCS, Email, or automated Voice updates.',
		),
		'growth'    => array(
			'title'    => 'Driving Seamless Travel Experiences',
			'subtitle' => 'Automatic updates at each stage of the journey, from payment confirmation and web check-in to post-trip feedback surveys.',
		),
		'use_cases' => array(
			'title' => 'Communication Use Cases<br>for Every Trip You Sell',
		),
		'faq'       => array(
			'title' => 'Everything You Need to Know<br>About Travel Communication',
			'intro' => 'Answers to common questions about booking confirmations, flight alerts, check-in reminders, channels, and getting started.',
			'book'  => $shared_faq_book,
			'items' => array(
				array( 'question' => 'How does Growtele help travel brands and OTAs?' ),
				array( 'question' => 'Can I send booking confirmations with PNR?' ),
				array( 'question' => 'Can travelers get live flight status updates?' ),
				array( 'question' => 'Which channels can Growtele send travel updates on?' ),
			),
		),
		'cta'      => $shared_industry_cta,
	),
	'ecommerce'  => array(
		'hero'     => array_merge(
			$shared_hero_cta,
			array(
				'title' => 'Recover Abandoned Carts, Confirm COD Orders, and Bring Shoppers Back',
				'desc'  => 'Send abandoned cart reminders, COD confirmations, order tracking updates, and return alerts on WhatsApp, SMS, RCS, Email, and Voice. Reach shoppers from product discovery to post-purchase support.',
			)
		),
		'channels' => array(
			'title'    => 'Channels Built for<br>E-commerce Brands',
			'subtitle' => 'Recover abandoned carts, confirm COD orders, resolve support queries, and drive repeat purchases across WhatsApp, SMS, RCS, Email, and Voice automatically.',
		),
		'growth'    => array(
			'title'    => 'Repeat Sales and Bigger Carts<br>for Online Retail Brands',
			'subtitle' => 'Turn first-time visitors into repeat buyers with cart reminders, product suggestions, order updates, and loyalty offers.',
		),
		'use_cases' => array(
			'title' => 'Communication Use Cases for<br>Every Step of the Order',
		),
		'faq'       => array(
			'title' => 'Everything You Need to Know About<br>E-commerce Communication',
			'intro' => 'Find answers on cart recovery, COD confirmation, order tracking, loyalty offers, store integrations, and the channels we support.',
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
				'title' => 'Keep Students and Parents Informed, From Admission to Exam Results',
				'desc'  => 'Answer admission enquiries, send fee reminders with payment links, share examination results, and alert parents about absences on WhatsApp, SMS, RCS, Email, and Voice, all from one dashboard built for schools, universities, and EdTech.',
			)
		),
		'channels' => array(
			'title'    => 'For Schools, Colleges, Coaching, and EdTech',
			'subtitle' => 'Schools, colleges, universities, coaching centres, and EdTech platforms use Growtele to answer admission enquiries faster and keep students and parents updated.',
		),
		'growth'    => array(
			'title'    => 'From Admission<br>to Alumni Engagement',
			'subtitle' => 'From the first admission enquiry to alumni newsletters, Growtele helps schools, colleges, and EdTech platforms automate messages students and parents rely on.',
		),
		'use_cases' => array(
			'title' => 'Communication Use Cases for Every Student Journey',
		),
		'faq'       => array(
			'title' => 'Everything You Need to Know<br>About Education Communication',
			'intro' => 'Find answers to common questions about admissions, fee reminders, exam results, attendance alerts, SIS integration, and supported channels',
			'book'  => $shared_faq_book,
			'items' => array(
				array( 'question' => 'How does Growtele help schools and universities?' ),
				array( 'question' => 'Can parents get attendance and exam result updates?' ),
				array( 'question' => 'Can I automate admission enquiry replies?' ),
				array( 'question' => 'Can Growtele integrate with Student Information Systems (SIS)?' ),
				array( 'question' => 'Which messaging channels can schools use?' ),
			),
		),
		'cta'      => $shared_industry_cta,
	),
	'logistic'   => array(
		'hero'     => array_merge(
			$shared_hero_cta,
			array(
				'title' => 'Live Shipment Updates That Keep Every Customer Informed Till Delivery',
				'desc'  => 'Send shipment updates, delivery OTPs, and NDR alerts, and connect riders with customers on masked calls across WhatsApp, SMS, RCS, Email, and Voice, cutting failed deliveries and RTO.',
			)
		),
		'channels' => array(
			'title'    => 'Alerts on Every Channel for<br>Couriers and Fleet Teams',
			'subtitle' => 'Courier companies, fleet operators, and last-mile delivery businesses use Growtele to cut failed deliveries, reduce RTO, and receive fewer where-is-my-order calls to support.',
		),
		'growth'    => array(
			'title'    => 'Keep Customers Informed About Delivery at Every Step',
			'subtitle' => 'Track every shipment, coordinate riders, and confirm each handover with an OTP, without making manual follow-up calls.',
		),
		'use_cases' => array(
			'title' => 'Communication Use Cases for<br>Every Logistics Journey',
		),
		'faq'       => array(
			'title' => 'Everything You Need to Know<br>About Logistics Communication',
			'intro' => 'Find answers to common questions about delivery OTPs, live tracking updates, NDR handling, number masking, TMS integration, and supported channels.',
			'book'  => $shared_faq_book,
			'items' => array(
				array( 'question' => 'How does Growtele help couriers and logistics companies?' ),
				array( 'question' => 'Can I send delivery OTPs to confirm every handover?' ),
				array( 'question' => 'Does Growtele integrate with our TMS and WMS platforms?' ),
				array( 'question' => 'Which messaging channels can couriers use?' ),
				array( 'question' => 'Can customers receive delivery updates on WhatsApp?' ),
			),
		),
		'cta'      => $shared_industry_cta,
	),
);
