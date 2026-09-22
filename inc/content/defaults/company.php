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
	'heading'     => "              Power Smarter Customer<br>\n              Conversations at Scale",
	'description' => 'Engage customers across SMS, WhatsApp, RCS, Email, and Voice through one unified communication platform built for reliability, performance, and growth',
	'button_text' => 'Get Started',
	'button_url'  => '',
);

$shared_address = 'Unit No 303-3rd Floor, Majestic Signia, Plot No. A-27, Block A, Industrial Area, Sector 62, Noida, Uttar Pradesh 201309';
$shared_phone   = '+91 9999-564-564';
$shared_email1  = 'info@growtele.com';
$shared_email2  = 'support@growtele.com';

return array(
	'about-us'    => array(
		'hero'        => array(
			'badge' => 'About Growtele',
			'title' => 'Building the Future of Business Communication',
			'desc'  => 'Empowering businesses with intelligent, secure, and scalable communication solutions that connect brands with customers across every touchpoint.',
		),
		'connecting'  => array(
			'title'        => 'Connecting Businesses Through Smarter Communication',
			'description'  => 'Growtele is a cloud communication platform built to simplify customer engagement. We help businesses deliver meaningful conversations through messaging, voice, email, and automation?all from one powerful platform.',
			'stat_1'       => '36B+',
			'stat_1_label' => 'Messages Delivered Globally',
			'stat_2'       => '500+',
			'stat_2_label' => 'Enterprise Clients Served',
		),
		'core_values' => array(
			'title' => 'The Core Values<br>That Power Every Customer Interaction',
			'desc'  => 'At Growtele, our values shape every product, every innovation, and every customer interaction. We are committed to building secure, scalable, and intelligent communication solutions that empower businesses to connect with customers more effectively. By combining reliability, innovation, and a customer-first approach, we help organizations create meaningful conversations',
		),
		'driven'      => array(
			'title'    => 'Driven by People.<br>Powered by Purpose.',
			'subtitle' => 'Every innovation at Growtele begins with people who are passionate about building better communication experiences.',
		),
		'locations'   => array(
			'title'    => "We're Here to Help Your Business Grow",
			'subtitle' => 'Have questions or need expert guidance? Reach out to Growtele and discover how our communication solutions can help your business grow.',
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
				'address' => $shared_address,
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
			'title'              => 'Blogs &amp; Articles',
			'subtitle'           => 'Stay updated with the latest trends, industry insights, product updates, and communication strategies that help businesses engage customers and drive meaningful growth',
			'search_placeholder' => 'Search your featured blogs....',
			'search_button'      => 'Search',
		),
		'cta'  => $shared_cta,
	),
	'career'      => array(
		'hero'    => array(
			'title'    => "Join the Team That's Redefining<br>Business Communication",
			'subtitle' => "Join a passionate team that's redefining business communication through innovative messaging, cloud telephony, AI-powered engagement, and enterprise communication solution",
		),
		'culture' => array(
			'title' => 'A Workplace Where Fun Meet Growth',
			'desc'  => "it's a dynamic and engaging environment where creativity thrives,<br>collaboration is encouraged, and every achievement is celebrated.",
		),
		'values'  => array(
			'title' => 'Build the Future With People Who Inspire You',
			'desc'  => "Build meaningful solutions, take ownership, and grow alongside a team that's shaping the future of customer communication.",
		),
		'perks'   => array(
			'title' => 'Perks and Benefits That Help You<br>Learn, Grow',
		),
		'jobs'    => array(
			'title' => "Find the Opportunity<br>That's Right for You",
			'desc'  => 'Join a passionate team where your ideas matter, your growth is supported,<br>and every role contributes to shaping the future of customer communication',
		),
		'cta'     => $shared_cta,
	),
	'contact'     => array(
		'hero'      => array(
			'title'    => 'Talk to Our Experts',
			'subtitle' => 'Have questions or planning your next communication strategy? Our specialists are ready to help you choose the right solution and build a communication experience tailored to your business.',
		),
		'form'      => array(
			'first_name' => 'First Name*',
			'last_name'  => 'Last Name*',
			'company'    => 'Company Name',
			'email'      => 'Business E-Mail*',
			'phone'      => 'Phone Number*',
			'query'      => 'About Your Query',
			'submit'     => 'Submit Request',
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
			'title'   => "We're Here to Help Your Business Grow",
			'desc'    => 'Have questions or need expert guidance? Reach out to Growtele and discover how our communication solutions can help your business grow.',
			'support' => 'Get support from our team',
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
				'map'     => 'assets/Group 462 (1).png',
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
				'address' => $shared_address,
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
			'title' => 'One Intelligent Platform.<span class="hero__title-rest"> Unlimited Possibilities.</span>',
			'desc'  => 'The all-in-one communication platform to connect,<br>engage and grow with your customers across<br>WhatsApp. SMS, Email, RCS and Voice.',
		),
		'faq'  => array(
			'title' => 'Everything You Need to Know<br>About Growinfinity.io',
			'intro' => 'Find answers to the most common questions about Growinfinity.io — from platform capabilities and integrations to security, scalability, and implementation.',
			'items' => array(
				array( 'question' => 'What is Growinfinity.io?' ),
				array( 'question' => 'Which communication channels does Growinfinity support?' ),
				array( 'question' => 'Can Growinfinity integrate with our existing systems?' ),
				array( 'question' => 'Is Growinfinity suitable for enterprise-scale businesses?' ),
				array( 'question' => 'How secure is the Growinfinity platform?' ),
			),
		),
		'cta'  => $shared_cta,
	),
);
