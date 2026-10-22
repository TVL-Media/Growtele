<?php
/**
 * Fallback primary menu matching static index.html navigation.
 *
 * @package Growtele
 */

$gt_nav = function_exists( 'growtele_get_content' ) ? growtele_get_content( 'global.nav', array() ) : array();
$gt_mega = is_array( $gt_nav['mega'] ?? null ) ? $gt_nav['mega'] : array();
$gt_feature = is_array( $gt_nav['feature'] ?? null ) ? $gt_nav['feature'] : array();
?>
<ul id="primary-menu" class="gt-header__menu" data-nav-menu>
	<li class="menu-item current-menu-item" data-nav-item>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'growtele' ); ?></a>
	</li>
	<li class="menu-item menu-item-has-children gt-mega-parent" data-nav-item data-mega-parent>
		<a
			href="#"
			class="gt-mega-trigger"
			data-mega-trigger
			aria-expanded="false"
			aria-controls="gt-mega-products"
			aria-haspopup="true"
		>
			<?php esc_html_e( 'Products', 'growtele' ); ?>
			<img src="<?php echo esc_url( growtele_get_image( 'icons/down-arrow.png' ) ); ?>" alt="" class="gt-menu-arrow" width="12" height="12" loading="lazy" />
		</a>
		<div class="gt-mega-menu" id="gt-mega-products" data-mega-menu hidden>
			<div class="gt-mega-menu__panel">
				<div class="gt-mega-menu__links"><a class="gt-mega-menu__item gt-mega-menu__item--sms" href="<?php echo esc_url( growtele_get_page_url( 'sms' ) ); ?>" data-mega-link>
						<span class="gt-mega-menu__icon gt-mega-menu__icon--sms">
							<img class="gt-mega-menu__img gt-mega-menu__img--sms" src="<?php echo esc_url( 'https://listings.selectvia.com/wp-content/uploads/2026/09/e068a65617596a51a8ee49b72d17f47dfb5bb193.png' ); ?>" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="gt-mega-menu__copy">
							<span class="gt-mega-menu__title"><?php echo esc_html( $gt_mega['sms']['title'] ?? 'SMS' ); ?></span>
							<span class="gt-mega-menu__desc"><?php echo esc_html( $gt_mega['sms']['desc'] ?? ' SMS for OTPs, alerts, and promotions, all DLT-compliant' ); ?></span>
						</span>
					</a>
<a class="gt-mega-menu__item gt-mega-menu__item--email" href="<?php echo esc_url( growtele_get_page_url( 'email' ) ); ?>" data-mega-link>
						<span class="gt-mega-menu__icon gt-mega-menu__icon--email">
							<img class="gt-mega-menu__img gt-mega-menu__img--email" src="<?php echo esc_url( 'https://listings.selectvia.com/wp-content/uploads/2026/09/19f867b5eea254b7493a13b05f4957415e10aade.png' ); ?>" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="gt-mega-menu__copy">
							<span class="gt-mega-menu__title"><?php echo esc_html( $gt_mega['email']['title'] ?? 'Email' ); ?></span>
							<span class="gt-mega-menu__desc"><?php echo esc_html( $gt_mega['email']['desc'] ?? 'Transactional and promotional emails delivered through Email API and SMTP' ); ?></span>
						</span>
					</a>
<a class="gt-mega-menu__item gt-mega-menu__item--cloud" href="<?php echo esc_url( growtele_get_page_url( 'cloud-telephony' ) ); ?>" data-mega-link>
						<span class="gt-mega-menu__icon gt-mega-menu__icon--cloud">
							<img class="gt-mega-menu__img gt-mega-menu__img--cloud" src="<?php echo esc_url( 'https://listings.selectvia.com/wp-content/uploads/2026/09/3d9f60c411ff5c025d1a45119a83b8f70b3e1753.png' ); ?>" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="gt-mega-menu__copy">
							<span class="gt-mega-menu__title"><?php echo esc_html( $gt_mega['cloud-telephony']['title'] ?? 'Voice' ); ?></span>
							<span class="gt-mega-menu__desc"><?php echo esc_html( $gt_mega['cloud-telephony']['desc'] ?? 'IVR, number masking, missed call services, and outbound calling (OBD)' ); ?></span>
						</span>
					</a>
<a class="gt-mega-menu__item gt-mega-menu__item--whatsapp" href="<?php echo esc_url( growtele_get_page_url( 'whatsapp' ) ); ?>" data-mega-link>
						<span class="gt-mega-menu__icon gt-mega-menu__icon--whatsapp">
							<img class="gt-mega-menu__img gt-mega-menu__img--whatsapp" src="<?php echo esc_url( 'https://listings.selectvia.com/wp-content/uploads/2026/09/40cce6a65a1f4441217c085b9ec9bfd18066ad17.png' ); ?>" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="gt-mega-menu__copy">
							<span class="gt-mega-menu__title"><?php echo esc_html( $gt_mega['whatsapp']['title'] ?? 'WhatsApp' ); ?></span>
							<span class="gt-mega-menu__desc"><?php echo esc_html( $gt_mega['whatsapp']['desc'] ?? 'WhatsApp Business Platform for alerts, sales, and live support' ); ?></span>
						</span>
					</a>
<a class="gt-mega-menu__item gt-mega-menu__item--rcs" href="<?php echo esc_url( growtele_get_page_url( 'rcs' ) ); ?>" data-mega-link>
						<span class="gt-mega-menu__icon gt-mega-menu__icon--rcs">
							<img class="gt-mega-menu__img gt-mega-menu__img--rcs" src="<?php echo esc_url( 'https://listings.selectvia.com/wp-content/uploads/2026/09/84847c7f8e4ed44d8a8e83fef3de936683103f8f.png' ); ?>" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="gt-mega-menu__copy">
							<span class="gt-mega-menu__title"><?php echo esc_html( $gt_mega['rcs']['title'] ?? 'RCS' ); ?></span>
							<span class="gt-mega-menu__desc"><?php echo esc_html( $gt_mega['rcs']['desc'] ?? 'RCS Business Messaging with verified sender IDs and rich media' ); ?></span>
						</span>
					</a>
</div>
				<aside class="gt-mega-menu__feature">
					<img
						class="gt-mega-menu__feature-img"
						src="<?php echo esc_url( growtele_get_asset( 'navpr.png' ) ); ?>"
						alt="<?php esc_attr_e( 'Team collaborating on customer communications', 'growtele' ); ?>"
						width="320"
						height="180"
						loading="lazy"
					/>
					<h3 class="gt-mega-menu__feature-title"><?php echo esc_html( $gt_feature['title'] ?? 'Every Channel. One Platform.' ); ?></h3>
					<p class="gt-mega-menu__feature-desc"><?php echo esc_html( $gt_feature['desc'] ?? 'Reach every customer on SMS, WhatsApp, RCS, Email, and Voice from one CPaaS platform built for enterprise traffic.' ); ?></p>
				</aside>
			</div>
		</div>
	</li>
	<li class="menu-item menu-item-has-children industry-solutions-parent" data-nav-item data-industry-solutions-parent>
		<a
			href="#"
			class="industry-solutions-trigger"
			data-industry-solutions-trigger
			aria-expanded="false"
			aria-controls="industry-solutions-dropdown"
			aria-haspopup="true"
		>
			<?php esc_html_e( 'Solutions', 'growtele' ); ?>
			<img src="<?php echo esc_url( growtele_get_image( 'icons/down-arrow.png' ) ); ?>" alt="" class="gt-menu-arrow" width="12" height="12" loading="lazy" />
		</a>
		<div class="industry-solutions-dropdown" id="industry-solutions-dropdown" data-industry-solutions-dropdown hidden>
			<div class="industry-solutions-dropdown-panel">
				<div class="industry-solutions-dropdown-links"><a class="industry-solutions-dropdown-item industry-solutions-dropdown-item--email" href="<?php echo esc_url( growtele_get_page_url( 'banking' ) ); ?>" data-industry-solutions-link>
						<span class="industry-solutions-dropdown-icon industry-solutions-dropdown-icon--email">
							<img class="industry-solutions-dropdown-img industry-solutions-dropdown-img--email" src="<?php echo esc_url( 'https://listings.selectvia.com/wp-content/uploads/2026/09/fca6aeb5a1f4ad4d6a486de6348bfceb090ae651.png' ); ?>" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="industry-solutions-dropdown-content">
							<span class="industry-solutions-dropdown-title"><?php esc_html_e( 'Banking & Finance', 'growtele' ); ?></span>
							<span class="industry-solutions-dropdown-desc"><?php esc_html_e( 'Send OTPs, transaction alerts, and EMI reminders your customers can trust.', 'growtele' ); ?></span>
						</span>
					</a>
<a class="industry-solutions-dropdown-item industry-solutions-dropdown-item--sms" href="<?php echo esc_url( growtele_get_page_url( 'retail' ) ); ?>" data-industry-solutions-link>
						<span class="industry-solutions-dropdown-icon industry-solutions-dropdown-icon--sms">
							<img class="industry-solutions-dropdown-img industry-solutions-dropdown-img--sms" src="<?php echo esc_url( 'https://listings.selectvia.com/wp-content/uploads/2026/09/30a6ce0b9e920774cfc9ff9516864e8d199f72c3.png' ); ?>" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="industry-solutions-dropdown-content">
							<span class="industry-solutions-dropdown-title"><?php esc_html_e( 'Retail', 'growtele' ); ?></span>
							<span class="industry-solutions-dropdown-desc"><?php esc_html_e( 'Bring shoppers back with personal offers, loyalty updates, and order alerts.', 'growtele' ); ?></span>
						</span>
					</a>
<a class="industry-solutions-dropdown-item industry-solutions-dropdown-item--cloud" href="<?php echo esc_url( growtele_get_page_url( 'health' ) ); ?>" data-industry-solutions-link>
						<span class="industry-solutions-dropdown-icon industry-solutions-dropdown-icon--cloud">
							<img class="industry-solutions-dropdown-img industry-solutions-dropdown-img--cloud" src="<?php echo esc_url( 'https://listings.selectvia.com/wp-content/uploads/2026/09/8c2fe6d9628384a9b995be508019127388c31950.png' ); ?>" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="industry-solutions-dropdown-content">
							<span class="industry-solutions-dropdown-title"><?php esc_html_e( 'Healthcare', 'growtele' ); ?></span>
							<span class="industry-solutions-dropdown-desc"><?php esc_html_e( 'Cut no-shows with appointment reminders and share lab reports with patients.', 'growtele' ); ?></span>
						</span>
					</a>
<a class="industry-solutions-dropdown-item industry-solutions-dropdown-item--whatsapp" href="<?php echo esc_url( growtele_get_page_url( 'travelling' ) ); ?>" data-industry-solutions-link>
						<span class="industry-solutions-dropdown-icon industry-solutions-dropdown-icon--whatsapp">
							<img class="industry-solutions-dropdown-img industry-solutions-dropdown-img--whatsapp" src="<?php echo esc_url( 'https://listings.selectvia.com/wp-content/uploads/2026/09/db0df5a95b9035484d416f8dd729b875846b2d5c.png' ); ?>" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="industry-solutions-dropdown-content">
							<span class="industry-solutions-dropdown-title"><?php esc_html_e( 'Travel', 'growtele' ); ?></span>
							<span class="industry-solutions-dropdown-desc"><?php esc_html_e( 'Send booking confirmations, e-tickets, and real-time travel alerts.', 'growtele' ); ?></span>
						</span>
					</a>
<a class="industry-solutions-dropdown-item industry-solutions-dropdown-item--rcs" href="<?php echo esc_url( growtele_get_page_url( 'ecommerce' ) ); ?>" data-industry-solutions-link>
						<span class="industry-solutions-dropdown-icon industry-solutions-dropdown-icon--rcs">
							<img class="industry-solutions-dropdown-img industry-solutions-dropdown-img--rcs" src="<?php echo esc_url( 'https://listings.selectvia.com/wp-content/uploads/2026/09/0798517b041c9bfdd67466394137f05f32c07f3c.png' ); ?>" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="industry-solutions-dropdown-content">
							<span class="industry-solutions-dropdown-title"><?php esc_html_e( 'E-commerce', 'growtele' ); ?></span>
							<span class="industry-solutions-dropdown-desc"><?php esc_html_e( 'Recover carts, confirm COD orders, and send shipping updates.', 'growtele' ); ?></span>
						</span>
					</a>
<a class="industry-solutions-dropdown-item industry-solutions-dropdown-item--rcs" href="<?php echo esc_url( growtele_get_page_url( 'education' ) ); ?>" data-industry-solutions-link>
						<span class="industry-solutions-dropdown-icon industry-solutions-dropdown-icon--rcs">
							<img class="industry-solutions-dropdown-img industry-solutions-dropdown-img--edu" src="<?php echo esc_url( 'https://listings.selectvia.com/wp-content/uploads/2026/09/25d436489db293236087a243a94e2b1e22374d7b.png' ); ?>" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="industry-solutions-dropdown-content">
							<span class="industry-solutions-dropdown-title"><?php esc_html_e( 'Education', 'growtele' ); ?></span>
							<span class="industry-solutions-dropdown-desc"><?php esc_html_e( 'Update students and parents on admissions, fees, and exam results.', 'growtele' ); ?></span>
						</span>
					</a>
<a class="industry-solutions-dropdown-item industry-solutions-dropdown-item--rcs" href="<?php echo esc_url( growtele_get_page_url( 'logistic' ) ); ?>" data-industry-solutions-link>
						<span class="industry-solutions-dropdown-icon industry-solutions-dropdown-icon--rcs">
							<img class="industry-solutions-dropdown-img industry-solutions-dropdown-img--logi" src="<?php echo esc_url( 'https://listings.selectvia.com/wp-content/uploads/2026/09/7b22f8b5be11c74fd73875774de61c8554298dc4.png' ); ?>" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="industry-solutions-dropdown-content">
							<span class="industry-solutions-dropdown-title"><?php esc_html_e( 'Logistics', 'growtele' ); ?></span>
							<span class="industry-solutions-dropdown-desc"><?php esc_html_e( 'Share live tracking, delivery OTPs, and real-time updates to riders.', 'growtele' ); ?></span>
						</span>
					</a>
</div>
				<aside class="industry-solutions-dropdown-feature">
					<img
						class="industry-solutions-dropdown-feature-img"
						src="<?php echo esc_url( growtele_get_asset( 'navpr.png' ) ); ?>"
						alt="<?php esc_attr_e( 'Team collaborating on customer communications', 'growtele' ); ?>"
						width="320"
						height="180"
						loading="lazy"
					/>
					<h3 class="industry-solutions-dropdown-feature-title"><?php esc_html_e( 'Every Channel. One Platform.', 'growtele' ); ?></h3>
					<p class="industry-solutions-dropdown-feature-desc"><?php esc_html_e( 'Reach every customer on SMS, WhatsApp, RCS, Email, and Voice from one CPaaS platform built for enterprise traffic.', 'growtele' ); ?></p>
				</aside>
			</div>
		</div>
	</li>
	<li class="menu-item menu-item-has-children company-parent" data-nav-item data-company-parent>
		<a
			href="#"
			class="company-trigger"
			data-company-trigger
			aria-expanded="false"
			aria-controls="company-dropdown"
			aria-haspopup="true"
		>
			<?php esc_html_e( 'Company', 'growtele' ); ?>
			<img src="<?php echo esc_url( growtele_get_image( 'icons/down-arrow.png' ) ); ?>" alt="" class="gt-menu-arrow" width="12" height="12" loading="lazy" />
		</a>
		<div class="company-dropdown" id="company-dropdown" data-company-dropdown hidden>
			<div class="company-dropdown-panel">
				<div class="company-dropdown-links">
					<a class="company-dropdown-item company-dropdown-item--sms" href="<?php echo esc_url( growtele_get_page_url( 'about-us' ) ); ?>" data-company-link>
						<span class="company-dropdown-icon company-dropdown-icon--sms">
							<img class="company-dropdown-img company-dropdown-img--sms" src="<?php echo esc_url( 'https://listings.selectvia.com/wp-content/uploads/2026/09/8e95972f576c388134492170722239c34d123c85.png' ); ?>" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="company-dropdown-content">
							<span class="company-dropdown-title"><?php esc_html_e( 'About Us', 'growtele' ); ?></span>
							<span class="company-dropdown-desc"><?php esc_html_e( 'Learn who we are, what we build, and how we help businesses communicate with their customers everywhere.', 'growtele' ); ?></span>
						</span>
					</a>
					<a class="company-dropdown-item company-dropdown-item--email" href="<?php echo esc_url( growtele_get_page_url( 'blogs' ) ); ?>" data-company-link>
						<span class="company-dropdown-icon company-dropdown-icon--email">
							<img class="company-dropdown-img company-dropdown-img--email" src="<?php echo esc_url( 'https://listings.selectvia.com/wp-content/uploads/2026/09/20b0f4ccc44e3574587b87f3ccaf10c1543761d0.png' ); ?>" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="company-dropdown-content">
							<span class="company-dropdown-title"><?php esc_html_e( 'Blog & Insights', 'growtele' ); ?></span>
							<span class="company-dropdown-desc"><?php esc_html_e( 'Guides, product updates, and practical tips for SMS, WhatsApp, RCS, Email, and Voice messaging teams.', 'growtele' ); ?></span>
						</span>
					</a>
					<a class="company-dropdown-item company-dropdown-item--cloud" href="<?php echo esc_url( growtele_get_page_url( 'career' ) ); ?>" data-company-link>
						<span class="company-dropdown-icon company-dropdown-icon--cloud">
							<img class="company-dropdown-img company-dropdown-img--cloud" src="<?php echo esc_url( 'https://listings.selectvia.com/wp-content/uploads/2026/09/65accadeae4e092a889b5c63cbbd07ccf48fc3f8.png' ); ?>" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="company-dropdown-content">
							<span class="company-dropdown-title"><?php esc_html_e( 'Careers', 'growtele' ); ?></span>
							<span class="company-dropdown-desc"><?php esc_html_e( 'Join the team building the messaging and voice platform that leading brands use to reach their customers.', 'growtele' ); ?></span>
						</span>
					</a>
					<a class="company-dropdown-item company-dropdown-item--whatsapp" href="<?php echo esc_url( growtele_get_page_url( 'contact' ) ); ?>" data-company-link>
						<span class="company-dropdown-icon company-dropdown-icon--whatsapp">
							<img class="company-dropdown-img company-dropdown-img--whatsapp" src="<?php echo esc_url( 'https://listings.selectvia.com/wp-content/uploads/2026/09/20d6f18d87fa40d524205fb9fdaa2f5dbcfa4026.png' ); ?>" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="company-dropdown-content">
							<span class="company-dropdown-title"><?php esc_html_e( 'Contact Us', 'growtele' ); ?></span>
							<span class="company-dropdown-desc"><?php esc_html_e( "Talk to our specialists about your requirements, channels, monthly volumes, and pricing.", 'growtele' ); ?></span>
						</span>
					</a>
					<a class="company-dropdown-item company-dropdown-item--rcs" href="<?php echo esc_url( growtele_get_page_url( 'growinfinity-io' ) ); ?>" data-company-link>
						<span class="company-dropdown-icon company-dropdown-icon--rcs">
							<img class="company-dropdown-img company-dropdown-img--rcs" src="https://listings.selectvia.com/wp-content/uploads/2026/09/82757cbe2674c5b6b53a8141fab6efabe2faf537.png" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="company-dropdown-content">
							<span class="company-dropdown-title"><?php esc_html_e( 'Growinfinity.io', 'growtele' ); ?></span>
							<span class="company-dropdown-desc"><?php esc_html_e( 'Run campaigns, chatbots, and a shared team inbox across every channel from one easy-to-use platform.', 'growtele' ); ?></span>
						</span>
					</a>
				</div>
				<aside class="company-dropdown-feature">
					<img
						class="company-dropdown-feature-img"
						src="<?php echo esc_url( growtele_get_asset( 'navpr.png' ) ); ?>"
						alt="<?php esc_attr_e( 'Team collaborating on customer communications', 'growtele' ); ?>"
						width="320"
						height="180"
						loading="lazy"
					/>
					<h3 class="company-dropdown-feature-title"><?php esc_html_e( 'Every Channel. One Platform.', 'growtele' ); ?></h3>
					<p class="company-dropdown-feature-desc"><?php esc_html_e( 'Reach every customer on SMS, WhatsApp, RCS, Email, and Voice from one CPaaS platform built for enterprise traffic.', 'growtele' ); ?></p>
				</aside>
			</div>
		</div>
	</li>
</ul>
