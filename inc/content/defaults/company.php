<?php
/**
 * Company page CMS defaults (About, Blogs, Career, Contact, Growtele IO).
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

$shared_address = 'Unit No 303-3rd Floor, Majestic Signia, Plot No. A-27, Block A, Industrial Area, Sector 62, Noida, Uttar Pradesh 201309';
$shared_phone   = '+91 9999-564-564';
$shared_email1  = 'info@growtele.com';
$shared_email2  = 'enquiry@growtele.com';

return array(
	'about-us'    => array(
		'hero'        => array(
			'badge' => 'About Growtele',
			'title' => 'One Platform. Billions of Customer Messages.',
			'desc'  => 'Banks, retailers, and logistics companies send OTPs, transaction alerts, and promotions on SMS, WhatsApp, RCS, Email, and Voice with Growtele.',
		),
		'connecting'  => array(
			'title'        => 'Simple Customer Messaging for Growing Businesses',
			'description'  => 'Growtele is a CPaaS platform for customer messaging. Send and automate OTPs, alerts, offers, and support replies on SMS, WhatsApp, RCS, Email, and Voice, with delivery reports and DLT compliance built in.',
			'stat_1'       => '36B+',
			'stat_1_label' => 'Messages Delivered Globally',
			'stat_2'       => '500+',
			'stat_2_label' => 'Enterprise Clients Served',
		),
		'core_values' => array(
			'title' => 'Our Core Values<br>That Shape Every Message We Deliver',
			'desc'  => 'Our values shape how we build our product and treat every customer. We build infrastructure you can rely on, so your OTPs, transaction alerts, and promotional campaigns reach customers on time. We put customers first, respond promptly when something breaks, improve the product continuously, and stay focused on the commercial outcomes that matter to you.',
		),
		'driven'      => array(
			'title'    => 'Driven by People.<br>Powered by Purpose.',
			'subtitle' => 'Every idea at Growtele starts with people who care about getting your OTPs, payment alerts, and campaigns right.',
		),
		'locations'   => array(
			'title'    => "Find Our Offices or Talk to Our Team",
			'subtitle' => 'Questions about pricing, DLT setup, or a use case? Write or call us, or visit our offices in Delhi NCR, Kolkata, Bengaluru, or Mumbai.',
		),
		'offices'     => array(
			'kolkata'   => array(
				'city'    => 'Kolkata',
				'address' => $shared_address,
				'phone'   => $shared_phone,
				'email1'  => $shared_email1,
				'email2'  => $shared_email2,
				'icon'    => 'https://listings.selectvia.com/wp-content/uploads/2026/09/526d7a71d22dd2b2008ce00a1bd539b77309d3e1.png',
				'image'   => 'https://listings.selectvia.com/wp-content/uploads/2026/09/Mask-group.png',
			),
			'delhi'     => array(
				'city'    => 'Delhi NCR',
				'address' => $shared_address,
				'phone'   => $shared_phone,
				'email1'  => $shared_email1,
				'email2'  => $shared_email2,
				'icon'    => 'https://listings.selectvia.com/wp-content/uploads/2026/09/d3821cf9de4106d1d740854567464a4bf8a43b16-1.png',
				'image'   => 'https://listings.selectvia.com/wp-content/uploads/2026/09/Group-462.png',
			),
			'bengaluru' => array(
				'city'    => 'Bengaluru',
				'address' => $shared_address,
				'phone'   => $shared_phone,
				'email1'  => $shared_email1,
				'email2'  => $shared_email2,
				'icon'    => 'https://listings.selectvia.com/wp-content/uploads/2026/09/bb8667e3c10c1ec42abfb1e27f4c0a753d6d38c4.png',
				'image'   => 'https://listings.selectvia.com/wp-content/uploads/2026/09/Mask-group-1.png',
			),
			'mumbai'    => array(
				'city'    => 'Mumbai',
				'address' => '903, Platinum Techno Park, Sector 30, Vashi, Navi Mumbai, Maharashtra - 400703',
				'phone'   => $shared_phone,
				'email1'  => $shared_email1,
				'email2'  => $shared_email2,
				'icon'    => 'https://listings.selectvia.com/wp-content/uploads/2026/09/954a1aa36af01ba5f2647ec2b95abd204c1942d5.png',
				'image'   => 'https://listings.selectvia.com/wp-content/uploads/2026/09/Mask-group-2.png',
			),
		),
		'cta'         => $shared_cta,
	),
	'blogs'       => array(
		'hero' => array(
			'title'              => 'Blog &amp; Insights',
			'subtitle'           => 'Practical guides, product updates, and channel trends for marketing and product teams using SMS, WhatsApp, RCS, Email, and Voice to reach customers and grow revenue.',
			'search_placeholder' => 'Search articles and guides...',
			'search_button'      => 'Search',
		),
		'cta'  => $shared_cta,
	),
	'career'      => array(
		'hero'    => array(
			'title'    => "Join Us and Build the Future of<br>Customer Conversations",
			'subtitle' => "Build the platform banks, retailers, and logistics businesses depend upon for OTPs, transaction alerts, and promotions across SMS, WhatsApp, RCS, Email, and Voice.",
		),
		'culture' => array(
			'title' => 'Where Great Work Meets Good Fun',
			'desc'  => "Teammates try bold ideas, ship features quickly, help each other,<br>and celebrate product launches and customer wins, big or small.",
		),
		'values'  => array(
			'title' => 'Build the Future With People Who Inspire You',
			'desc'  => "Take ownership of your work from day one, solve real customer problems, and grow alongside teammates who have your back.",
		),
		'perks'   => array(
			'title' => 'Perks and Benefits That<br>Help You Learn, Grow',
		),
		'jobs'    => array(
			'title' => "Explore Open Roles<br>That Fit Your Skills",
			'desc'  => 'Your ideas count here, your growth gets full support from your manager,<br>and every role helps banks, retailers, and schools reach their customers.',
		),
		'cta'     => $shared_cta,
	),
	'contact'     => array(
		'hero'      => array(
			'title'    => 'Talk to an Expert',
			'subtitle' => 'Tell us what you\'re building. Share your use case, the channels you need, and expected monthly volumes, and our team will help you pick the right setup, templates, and pricing plan.',
		),
		'form'      => array(
			'first_name' => 'First Name*',
			'last_name'  => 'Last Name*',
			'company'    => 'Company Name',
			'email'      => 'Your Work Email*',
			'phone'      => 'Phone Number*',
			'query'      => 'Your Requirement',
			'submit'     => 'Contact Sales',
			'submitted'  => 'Submitted!',
			'errors'     => array(
				'first_name'    => 'First name is required',
				'last_name'     => 'Last name is required',
				'email'         => 'Email is required',
				'email_invalid' => 'Please enter a valid email',
				'phone'         => 'Phone number is required',
				'phone_invalid' => 'Please enter a valid 10-digit phone number',
				'terms'         => 'You must agree to the terms',
			),
		),
		'locations' => array(
			'title'   => "Find Our Offices or Talk to Our Team",
			'desc'    => 'Questions about pricing, DLT setup, or a use case? Write or call us, or visit our offices in Delhi NCR, Kolkata, Bengaluru, or Mumbai.',
			'support' => 'Write to our support team',
		),
		'offices'   => array(
			'kolkata'   => array(
				'city'    => 'Kolkata',
				'address' => $shared_address,
				'phone'   => $shared_phone,
				'email1'  => $shared_email1,
				'email2'  => $shared_email2,
				'icon'    => 'https://listings.selectvia.com/wp-content/uploads/2026/09/526d7a71d22dd2b2008ce00a1bd539b77309d3e1.png',
				'iconAlt' => 'Kolkata office',
				'map'     => 'https://listings.selectvia.com/wp-content/uploads/2026/09/Mask-group.png',
				'mapAlt'  => 'Kolkata office location',
			),
			'delhi'     => array(
				'city'    => 'Delhi NCR',
				'address' => $shared_address,
				'phone'   => $shared_phone,
				'email1'  => $shared_email1,
				'email2'  => $shared_email2,
				'icon'    => 'https://listings.selectvia.com/wp-content/uploads/2026/09/d3821cf9de4106d1d740854567464a4bf8a43b16-1.png',
				'iconAlt' => 'India Gate, Delhi NCR',
				'map'     => 'assets/Group 462 (1).webp',
				'mapAlt'  => 'India Gate, Delhi NCR',
			),
			'bengaluru' => array(
				'city'    => 'Bengaluru',
				'address' => $shared_address,
				'phone'   => $shared_phone,
				'email1'  => $shared_email1,
				'email2'  => $shared_email2,
				'icon'    => 'https://listings.selectvia.com/wp-content/uploads/2026/09/bb8667e3c10c1ec42abfb1e27f4c0a753d6d38c4.png',
				'iconAlt' => 'Bengaluru office',
				'map'     => 'https://listings.selectvia.com/wp-content/uploads/2026/09/Mask-group-1.png',
				'mapAlt'  => 'Bengaluru office location',
			),
			'mumbai'    => array(
				'city'    => 'Mumbai',
				'address' => '903, Platinum Techno Park, Sector 30, Vashi, Navi Mumbai, Maharashtra - 400703',
				'phone'   => $shared_phone,
				'email1'  => $shared_email1,
				'email2'  => $shared_email2,
				'icon'    => 'https://listings.selectvia.com/wp-content/uploads/2026/09/954a1aa36af01ba5f2647ec2b95abd204c1942d5.png',
				'iconAlt' => 'Mumbai office',
				'map'     => 'https://listings.selectvia.com/wp-content/uploads/2026/09/Mask-group-2.png',
				'mapAlt'  => 'Mumbai office location',
			),
		),
		'cta'       => $shared_cta,
	),
	'growtele-io' => array(
		'hero' => array(
			'title' => 'One Engagement Platform<span class="hero__title-rest"> for Every Conversation.</span>',
			'desc'  => 'Run campaigns, chatbots and a shared team inbox,<br>from one login and reach your customers on<br>WhatsApp, SMS, Email, RCS and Voice.',
		),
		'faq'  => array(
			'title' => 'Everything You Need to Know<br>About Growinfinity.io',
			'intro' => 'Quick answers about Growinfinity.io, from supported channels and CRM integrations to data security, enterprise scale, and how to get your team started.',
			'items' => array(
				array( 'question' => 'What is Growinfinity.io?' ),
				array( 'question' => 'Which messaging channels can I use with Growinfinity?' ),
				array( 'question' => 'Can Growinfinity integrate with our existing systems?' ),
				array( 'question' => 'Is Growinfinity suitable for enterprise-scale businesses?' ),
				array( 'question' => 'How secure is the Growinfinity platform?' ),
			),
		),
		'cta'  => $shared_cta,
	),
);
