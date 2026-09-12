<?php
/**
 * Fallback primary menu matching static index.html navigation.
 *
 * @package Growtele
 */
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
				<div class="gt-mega-menu__links">
					<a class="gt-mega-menu__item gt-mega-menu__item--sms" href="<?php echo esc_url( growtele_get_page_url( 'sms' ) ); ?>" data-mega-link>
						<span class="gt-mega-menu__icon gt-mega-menu__icon--sms">
							<img class="gt-mega-menu__img gt-mega-menu__img--sms" src="<?php echo esc_url( growtele_get_asset( 'smsnic.png' ) ); ?>" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="gt-mega-menu__copy">
							<span class="gt-mega-menu__title"><?php esc_html_e( 'SMS', 'growtele' ); ?></span>
							<span class="gt-mega-menu__desc"><?php esc_html_e( 'Powerful SMS solutions that connect businesses with customers', 'growtele' ); ?></span>
						</span>
					</a>
					<a class="gt-mega-menu__item gt-mega-menu__item--email" href="<?php echo esc_url( growtele_get_page_url( 'email' ) ); ?>" data-mega-link>
						<span class="gt-mega-menu__icon gt-mega-menu__icon--email">
							<img class="gt-mega-menu__img gt-mega-menu__img--email" src="<?php echo esc_url( growtele_get_asset( 'emailnic.png' ) ); ?>" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="gt-mega-menu__copy">
							<span class="gt-mega-menu__title"><?php esc_html_e( 'E-Mail', 'growtele' ); ?></span>
							<span class="gt-mega-menu__desc"><?php esc_html_e( 'Engage customers with personalized, reliable emails that drive conversations', 'growtele' ); ?></span>
						</span>
					</a>
					<a class="gt-mega-menu__item gt-mega-menu__item--cloud" href="<?php echo esc_url( growtele_get_page_url( 'cloud-telephony' ) ); ?>" data-mega-link>
						<span class="gt-mega-menu__icon gt-mega-menu__icon--cloud">
							<img class="gt-mega-menu__img gt-mega-menu__img--cloud" src="<?php echo esc_url( growtele_get_asset( 'cloudnic.png' ) ); ?>" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="gt-mega-menu__copy">
							<span class="gt-mega-menu__title"><?php esc_html_e( 'Cloud Telephony', 'growtele' ); ?></span>
							<span class="gt-mega-menu__desc"><?php esc_html_e( 'Connect, engage, and support customers with powerful cloud-based calling', 'growtele' ); ?></span>
						</span>
					</a>
					<a class="gt-mega-menu__item gt-mega-menu__item--whatsapp" href="<?php echo esc_url( growtele_get_page_url( 'whatsapp' ) ); ?>" data-mega-link>
						<span class="gt-mega-menu__icon gt-mega-menu__icon--whatsapp">
							<img class="gt-mega-menu__img gt-mega-menu__img--whatsapp" src="<?php echo esc_url( growtele_get_asset( 'whatsappnic.png' ) ); ?>" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="gt-mega-menu__copy">
							<span class="gt-mega-menu__title"><?php esc_html_e( 'WhatsApp', 'growtele' ); ?></span>
							<span class="gt-mega-menu__desc"><?php esc_html_e( 'Connect with customers on WhatsApp through engaging conversations', 'growtele' ); ?></span>
						</span>
					</a>
					<a class="gt-mega-menu__item gt-mega-menu__item--rcs" href="<?php echo esc_url( growtele_get_page_url( 'rcs' ) ); ?>" data-mega-link>
						<span class="gt-mega-menu__icon gt-mega-menu__icon--rcs">
							<img class="gt-mega-menu__img gt-mega-menu__img--rcs" src="<?php echo esc_url( growtele_get_asset( 'rcsnic.png' ) ); ?>" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="gt-mega-menu__copy">
							<span class="gt-mega-menu__title"><?php esc_html_e( 'RCS', 'growtele' ); ?></span>
							<span class="gt-mega-menu__desc"><?php esc_html_e( 'RCS is the next generation of business messaging that transforms.', 'growtele' ); ?></span>
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
					<h3 class="gt-mega-menu__feature-title"><?php esc_html_e( 'True Market Leaders for CPass', 'growtele' ); ?></h3>
					<p class="gt-mega-menu__feature-desc"><?php esc_html_e( 'True Market Leaders in CPaaS — empowering businesses with seamless, scalable, and intelligent customer communications.', 'growtele' ); ?></p>
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
			<?php esc_html_e( 'Industry Solution', 'growtele' ); ?>
			<img src="<?php echo esc_url( growtele_get_image( 'icons/down-arrow.png' ) ); ?>" alt="" class="gt-menu-arrow" width="12" height="12" loading="lazy" />
		</a>
		<div class="industry-solutions-dropdown" id="industry-solutions-dropdown" data-industry-solutions-dropdown hidden>
			<div class="industry-solutions-dropdown-panel">
				<div class="industry-solutions-dropdown-links">
					<a class="industry-solutions-dropdown-item industry-solutions-dropdown-item--sms" href="<?php echo esc_url( growtele_get_page_url( 'retail' ) ); ?>" data-industry-solutions-link>
						<span class="industry-solutions-dropdown-icon industry-solutions-dropdown-icon--sms">
							<img class="industry-solutions-dropdown-img industry-solutions-dropdown-img--sms" src="<?php echo esc_url( growtele_get_asset( 'retailnic.png' ) ); ?>" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="industry-solutions-dropdown-content">
							<span class="industry-solutions-dropdown-title"><?php esc_html_e( 'Retail', 'growtele' ); ?></span>
							<span class="industry-solutions-dropdown-desc"><?php esc_html_e( 'Build stronger customer connections, drive engagement, and grow your business.', 'growtele' ); ?></span>
						</span>
					</a>
					<a class="industry-solutions-dropdown-item industry-solutions-dropdown-item--email" href="<?php echo esc_url( growtele_get_page_url( 'banking' ) ); ?>" data-industry-solutions-link>
						<span class="industry-solutions-dropdown-icon industry-solutions-dropdown-icon--email">
							<img class="industry-solutions-dropdown-img industry-solutions-dropdown-img--email" src="<?php echo esc_url( growtele_get_asset( 'banknic.png' ) ); ?>" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="industry-solutions-dropdown-content">
							<span class="industry-solutions-dropdown-title"><?php esc_html_e( 'Banking', 'growtele' ); ?></span>
							<span class="industry-solutions-dropdown-desc"><?php esc_html_e( 'Build secure customer connections, streamline engagement, and drive growth.', 'growtele' ); ?></span>
						</span>
					</a>
					<a class="industry-solutions-dropdown-item industry-solutions-dropdown-item--cloud" href="<?php echo esc_url( growtele_get_page_url( 'health' ) ); ?>" data-industry-solutions-link>
						<span class="industry-solutions-dropdown-icon industry-solutions-dropdown-icon--cloud">
							<img class="industry-solutions-dropdown-img industry-solutions-dropdown-img--cloud" src="<?php echo esc_url( growtele_get_asset( 'healthnic.png' ) ); ?>" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="industry-solutions-dropdown-content">
							<span class="industry-solutions-dropdown-title"><?php esc_html_e( 'Healthcare', 'growtele' ); ?></span>
							<span class="industry-solutions-dropdown-desc"><?php esc_html_e( 'Connect patients, simplify communication, and deliver better care experiences.', 'growtele' ); ?></span>
						</span>
					</a>
					<a class="industry-solutions-dropdown-item industry-solutions-dropdown-item--whatsapp" href="<?php echo esc_url( growtele_get_page_url( 'travelling' ) ); ?>" data-industry-solutions-link>
						<span class="industry-solutions-dropdown-icon industry-solutions-dropdown-icon--whatsapp">
							<img class="industry-solutions-dropdown-img industry-solutions-dropdown-img--whatsapp" src="<?php echo esc_url( growtele_get_asset( 'travelnic.png' ) ); ?>" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="industry-solutions-dropdown-content">
							<span class="industry-solutions-dropdown-title"><?php esc_html_e( 'Travelling', 'growtele' ); ?></span>
							<span class="industry-solutions-dropdown-desc"><?php esc_html_e( 'Connect travelers, simplify journeys, and deliver seamless experiences.', 'growtele' ); ?></span>
						</span>
					</a>
					<a class="industry-solutions-dropdown-item industry-solutions-dropdown-item--rcs" href="<?php echo esc_url( growtele_get_page_url( 'ecommerce' ) ); ?>" data-industry-solutions-link>
						<span class="industry-solutions-dropdown-icon industry-solutions-dropdown-icon--rcs">
							<img class="industry-solutions-dropdown-img industry-solutions-dropdown-img--rcs" src="<?php echo esc_url( growtele_get_asset( 'ecomnic.png' ) ); ?>" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="industry-solutions-dropdown-content">
							<span class="industry-solutions-dropdown-title"><?php esc_html_e( 'E-Commerce', 'growtele' ); ?></span>
							<span class="industry-solutions-dropdown-desc"><?php esc_html_e( 'Connect shoppers, boost engagement, and drive seamless sales.', 'growtele' ); ?></span>
						</span>
					</a>
					<a class="industry-solutions-dropdown-item industry-solutions-dropdown-item--rcs" href="<?php echo esc_url( growtele_get_page_url( 'education' ) ); ?>" data-industry-solutions-link>
						<span class="industry-solutions-dropdown-icon industry-solutions-dropdown-icon--rcs">
							<img class="industry-solutions-dropdown-img industry-solutions-dropdown-img--edu" src="<?php echo esc_url( growtele_get_asset( 'edunic.png' ) ); ?>" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="industry-solutions-dropdown-content">
							<span class="industry-solutions-dropdown-title"><?php esc_html_e( 'Education', 'growtele' ); ?></span>
							<span class="industry-solutions-dropdown-desc"><?php esc_html_e( 'Connect learners, simplify communication, and empower better outcomes.', 'growtele' ); ?></span>
						</span>
					</a>
					<a class="industry-solutions-dropdown-item industry-solutions-dropdown-item--rcs" href="<?php echo esc_url( growtele_get_page_url( 'logistic' ) ); ?>" data-industry-solutions-link>
						<span class="industry-solutions-dropdown-icon industry-solutions-dropdown-icon--rcs">
							<img class="industry-solutions-dropdown-img industry-solutions-dropdown-img--logi" src="<?php echo esc_url( growtele_get_asset( 'loginic.png' ) ); ?>" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="industry-solutions-dropdown-content">
							<span class="industry-solutions-dropdown-title"><?php esc_html_e( 'Logistic & Transport', 'growtele' ); ?></span>
							<span class="industry-solutions-dropdown-desc"><?php esc_html_e( 'Connect operations, streamline journeys, and keep deliveries moving.', 'growtele' ); ?></span>
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
					<h3 class="industry-solutions-dropdown-feature-title"><?php esc_html_e( 'True Market Leaders for CPass', 'growtele' ); ?></h3>
					<p class="industry-solutions-dropdown-feature-desc"><?php esc_html_e( 'True Market Leaders in CPaaS — empowering businesses with seamless, scalable, and intelligent customer communications.', 'growtele' ); ?></p>
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
							<img class="company-dropdown-img company-dropdown-img--sms" src="<?php echo esc_url( growtele_get_asset( 'aboutnic.png' ) ); ?>" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="company-dropdown-content">
							<span class="company-dropdown-title"><?php esc_html_e( 'About us', 'growtele' ); ?></span>
							<span class="company-dropdown-desc"><?php esc_html_e( 'Where innovation, technology, and communication come together to help businesses connect, engage, and grow.', 'growtele' ); ?></span>
						</span>
					</a>
					<a class="company-dropdown-item company-dropdown-item--email" href="<?php echo esc_url( growtele_get_page_url( 'blogs' ) ); ?>" data-company-link>
						<span class="company-dropdown-icon company-dropdown-icon--email">
							<img class="company-dropdown-img company-dropdown-img--email" src="<?php echo esc_url( growtele_get_asset( 'blognic.png' ) ); ?>" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="company-dropdown-content">
							<span class="company-dropdown-title"><?php esc_html_e( 'Blogs & Insights', 'growtele' ); ?></span>
							<span class="company-dropdown-desc"><?php esc_html_e( 'Explore fresh ideas, industry trends, and expert perspectives shaping the future of digital communication.', 'growtele' ); ?></span>
						</span>
					</a>
					<a class="company-dropdown-item company-dropdown-item--cloud" href="<?php echo esc_url( growtele_get_page_url( 'career' ) ); ?>" data-company-link>
						<span class="company-dropdown-icon company-dropdown-icon--cloud">
							<img class="company-dropdown-img company-dropdown-img--cloud" src="<?php echo esc_url( growtele_get_asset( 'careersnic.png' ) ); ?>" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="company-dropdown-content">
							<span class="company-dropdown-title"><?php esc_html_e( 'Careers', 'growtele' ); ?></span>
							<span class="company-dropdown-desc"><?php esc_html_e( 'Join a forward-thinking team where your ideas, skills, and ambition help shape the future of communication.', 'growtele' ); ?></span>
						</span>
					</a>
					<a class="company-dropdown-item company-dropdown-item--whatsapp" href="<?php echo esc_url( growtele_get_page_url( 'contact' ) ); ?>" data-company-link>
						<span class="company-dropdown-icon company-dropdown-icon--whatsapp">
							<img class="company-dropdown-img company-dropdown-img--whatsapp" src="<?php echo esc_url( growtele_get_asset( 'contactnic.png' ) ); ?>" alt="" width="40" height="40" loading="lazy" />
						</span>
						<span class="company-dropdown-content">
							<span class="company-dropdown-title"><?php esc_html_e( 'Contact us', 'growtele' ); ?></span>
							<span class="company-dropdown-desc"><?php esc_html_e( "Let's connect, explore opportunities, and build smarter communication solutions together.", 'growtele' ); ?></span>
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
					<h3 class="company-dropdown-feature-title"><?php esc_html_e( 'True Market Leaders for CPass', 'growtele' ); ?></h3>
					<p class="company-dropdown-feature-desc"><?php esc_html_e( 'True Market Leaders in CPaaS — empowering businesses with seamless, scalable, and intelligent customer communications.', 'growtele' ); ?></p>
				</aside>
			</div>
		</div>
	</li>
</ul>
