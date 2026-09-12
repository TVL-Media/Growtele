<?php
/**
 * Site footer
 *
 * @package Growtele
 */

$email = get_theme_mod( 'growtele_contact_email', 'hello@growtele.com' );

$social_links = array(
	array(
		'label' => 'Facebook',
		'url'   => 'https://www.facebook.com/Growtele',
		'icon'  => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M11.0781 10.5469H13.0469L13.9062 7.73438H11.0781V6.17188C11.0781 5.50781 11.0781 4.88281 12.2656 4.88281H13.8672V2.38281C13.6328 2.35156 12.7344 2.26562 11.7812 2.26562C9.78125 2.26562 8.35938 3.51562 8.35938 5.89844V7.73438H5.85938V10.5469H8.35938V17.7344H11.0781V10.5469Z" fill="currentColor"/></svg>',
	),
	array(
		'label'   => 'X',
		'url'     => '',
		'pending' => true,
		'icon'    => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M11.9033 8.46875L15.8096 4H14.875L11.4668 7.88281L8.76367 4H4.5L8.66016 10.5156L4.5 16H5.43457L9.09668 12.1016L12.002 16H16.2656L11.9033 8.46875ZM10.5488 11.2969L10.1445 10.7266L6.24023 4.70312H7.89062L11.0039 9.51562L11.4082 10.0859L15.502 15.3516H13.8516L10.5488 11.2969Z" fill="currentColor"/></svg>',
	),
	array(
		'label' => 'Instagram',
		'url'   => 'https://www.instagram.com/growtele/',
		'icon'  => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M10 4.10156C11.8555 4.10156 12.0781 4.10938 12.8047 4.14062C13.5234 4.17188 13.9453 4.28906 14.2656 4.41406C14.6719 4.57031 14.9688 4.75781 15.2812 5.07031C15.6016 5.39062 15.7812 5.67969 15.9375 6.08594C16.0625 6.40625 16.1797 6.83594 16.2109 7.54688C16.2422 8.28125 16.25 8.50391 16.25 10.3516C16.25 12.207 16.2422 12.4297 16.2109 13.1562C16.1797 13.875 16.0625 14.2969 15.9375 14.6172C15.7812 15.0234 15.5938 15.3203 15.2812 15.6328C14.9609 15.9531 14.6719 16.1328 14.2656 16.2891C13.9453 16.4141 13.5156 16.5312 12.8047 16.5625C12.0781 16.5938 11.8555 16.6016 10 16.6016C8.14453 16.6016 7.92188 16.5938 7.19531 16.5625C6.47656 16.5312 6.05469 16.4141 5.73438 16.2891C5.32812 16.1328 5.03125 15.9531 4.71875 15.6328C4.39844 15.3203 4.21875 15.0234 4.0625 14.6172C3.9375 14.2969 3.82031 13.875 3.78906 13.1562C3.75781 12.4297 3.75 12.207 3.75 10.3516C3.75 8.50391 3.75781 8.28125 3.78906 7.54688C3.82031 6.83594 3.9375 6.40625 4.0625 6.08594C4.21875 5.67969 4.40625 5.39062 4.71875 5.07031C5.03906 4.75781 5.32812 4.57031 5.73438 4.41406C6.05469 4.28906 6.48438 4.17188 7.19531 4.14062C7.92188 4.10938 8.14453 4.10156 10 4.10156ZM10 2.85156C8.11719 2.85156 7.87891 2.85938 7.14062 2.89062C6.41016 2.92188 5.89844 3.04688 5.45312 3.21875C4.99219 3.39844 4.60156 3.63281 4.21094 4.02344C3.82031 4.41406 3.58594 4.80469 3.40625 5.26562C3.23438 5.71094 3.10938 6.22266 3.07812 6.95312C3.04688 7.69922 3.03906 7.9375 3.03906 9.82031V10.8828C3.03906 12.7656 3.04688 13.0039 3.07812 13.7422C3.10938 14.4727 3.23438 14.9844 3.40625 15.4297C3.58594 15.8906 3.82031 16.2812 4.21094 16.6719C4.60156 17.0625 4.99219 17.2969 5.45312 17.4766C5.89844 17.6484 6.41016 17.7734 7.14062 17.8047C7.87891 17.8359 8.11719 17.8438 10 17.8438C11.8828 17.8438 12.1211 17.8359 12.8594 17.8047C13.5898 17.7734 14.1016 17.6484 14.5469 17.4766C15.0078 17.2969 15.3984 17.0625 15.7891 16.6719C16.1797 16.2812 16.4141 15.8906 16.5938 15.4297C16.7656 14.9844 16.8906 14.4727 16.9219 13.7422C16.9531 13.0039 16.9609 12.7656 16.9609 10.8828V9.82031C16.9609 7.9375 16.9531 7.69922 16.9219 6.95312C16.8906 6.22266 16.7656 5.71094 16.5938 5.26562C16.4141 4.80469 16.1797 4.41406 15.7891 4.02344C15.3984 3.63281 15.0078 3.39844 14.5469 3.21875C14.1016 3.04688 13.5898 2.92188 12.8594 2.89062C12.1211 2.85938 11.8828 2.85156 10 2.85156ZM10 6.47656C7.82812 6.47656 6.0625 8.24219 6.0625 10.4141C6.0625 12.5859 7.82812 14.3516 10 14.3516C12.1719 14.3516 13.9375 12.5859 13.9375 10.4141C13.9375 8.24219 12.1719 6.47656 10 6.47656ZM10 13.1016C8.58594 13.1016 7.4375 11.9531 7.4375 10.5391C7.4375 9.125 8.58594 7.97656 10 7.97656C11.4141 7.97656 12.5625 9.125 12.5625 10.5391C12.5625 11.9531 11.4141 13.1016 10 13.1016ZM14.6875 6.32031C14.6875 5.82031 14.2812 5.41406 13.7812 5.41406C13.2812 5.41406 12.875 5.82031 12.875 6.32031C12.875 6.82031 13.2812 7.22656 13.7812 7.22656C14.2812 7.22656 14.6875 6.82031 14.6875 6.32031Z" fill="currentColor"/></svg>',
	),
	array(
		'label' => 'YouTube',
		'url'   => 'https://youtube.com/@growtele4803?si=Vr9f6acJRg7sklSa',
		'icon'  => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M17.3828 5.75C17.2109 5.11719 16.7109 4.61719 16.0781 4.44531C14.8828 4.125 10 4.125 10 4.125C10 4.125 5.11719 4.125 3.92188 4.44531C3.28906 4.61719 2.78906 5.11719 2.61719 5.75C2.29688 6.94531 2.29688 9.5 2.29688 9.5C2.29688 9.5 2.29688 12.0547 2.61719 13.25C2.78906 13.8828 3.28906 14.3828 3.92188 14.5547C5.11719 14.875 10 14.875 10 14.875C10 14.875 14.8828 14.875 16.0781 14.5547C16.7109 14.3828 17.2109 13.8828 17.3828 13.25C17.7031 12.0547 17.7031 9.5 17.7031 9.5C17.7031 9.5 17.7031 6.94531 17.3828 5.75ZM8.75 11.875V7.125L12.875 9.5L8.75 11.875Z" fill="currentColor"/></svg>',
	),
	array(
		'label' => 'LinkedIn',
		'url'   => 'https://www.linkedin.com/company/growtele/',
		'icon'  => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M4.375 6.25H2.1875V17.1875H4.375V6.25ZM3.28125 2.8125C2.57812 2.8125 2 3.39844 2 4.10938C2 4.82031 2.57812 5.40625 3.28125 5.40625C3.98438 5.40625 4.5625 4.82031 4.5625 4.10938C4.5625 3.39844 3.98438 2.8125 3.28125 2.8125ZM7.1875 6.25H9.29688V7.42188H9.32812C9.64844 6.82812 10.3984 6.20312 11.5312 6.20312C13.9062 6.20312 14.375 7.73438 14.375 9.80469V17.1875H12.1875V10.3281C12.1875 8.85938 12.1562 6.97656 10.1562 6.97656C8.125 6.97656 7.8125 8.61719 7.8125 10.2344V17.1875H5.625V6.25H7.1875Z" fill="currentColor"/></svg>',
	),
);
?>
<footer id="colophon" class="gt-footer">
	<div class="gt-footer__glow"></div>
	<div class="gt-container gt-footer__inner">
		<div class="gt-footer__brand">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="gt-footer__logo">
				<?php growtele_image( 'icons/logo.png', get_bloginfo( 'name' ), '', 163, 42 ); ?>
			</a>
			<p><?php esc_html_e( "Growtele's global network solutions enable every business sector to optimize their business across the globe.", 'growtele' ); ?></p>
			<a href="mailto:<?php echo esc_attr( $email ); ?>" class="gt-footer__cta">
				<img src="<?php echo esc_url( growtele_get_image( 'icons/get-in-touch.png' ) ); ?>" alt="<?php esc_attr_e( 'Get In Touch', 'growtele' ); ?>" width="165" height="35" loading="lazy" />
			</a>
		</div>

		<div class="gt-footer__nav">
			<div class="gt-footer__col">
				<h4><?php esc_html_e( 'Products', 'growtele' ); ?></h4>
				<ul>
					<li><a href="<?php echo esc_url( growtele_get_page_url( 'whatsapp' ) ); ?>"><?php esc_html_e( 'Whatsapp API', 'growtele' ); ?></a></li>
					<li><a href="<?php echo esc_url( growtele_get_page_url( 'sms' ) ); ?>"><?php esc_html_e( 'SMS API', 'growtele' ); ?></a></li>
					<li><a href="<?php echo esc_url( growtele_get_page_url( 'rcs' ) ); ?>"><?php esc_html_e( 'RCS API', 'growtele' ); ?></a></li>
					<li><a href="<?php echo esc_url( growtele_get_page_url( 'email' ) ); ?>"><?php esc_html_e( 'E-Mail API', 'growtele' ); ?></a></li>
					<li><a href="<?php echo esc_url( growtele_get_page_url( 'cloud-telephony' ) ); ?>"><?php esc_html_e( 'Cloud Telephony', 'growtele' ); ?></a></li>
				</ul>
			</div>
			<div class="gt-footer__col">
				<h4><?php esc_html_e( 'Company', 'growtele' ); ?></h4>
				<ul>
					<li><a href="<?php echo esc_url( growtele_get_page_url( 'about-us' ) ); ?>"><?php esc_html_e( 'About Us', 'growtele' ); ?></a></li>
					<li><a href="<?php echo esc_url( growtele_get_page_url( 'career' ) ); ?>"><?php esc_html_e( 'Careers', 'growtele' ); ?></a></li>
					<li><a href="<?php echo esc_url( growtele_get_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'Contact Us', 'growtele' ); ?></a></li>
					<li><a href="<?php echo esc_url( growtele_get_page_url( 'growtele-io' ) ); ?>"><?php esc_html_e( 'Growinfinity.io', 'growtele' ); ?></a></li>
				</ul>
			</div>
			<div class="gt-footer__col">
				<h4><?php esc_html_e( 'Resources', 'growtele' ); ?></h4>
				<ul>
					<li><a href="<?php echo esc_url( growtele_get_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'Pricing', 'growtele' ); ?></a></li>
					<li><a href="<?php echo esc_url( growtele_get_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'API Documentation', 'growtele' ); ?></a></li>
					<li><a href="<?php echo esc_url( growtele_get_page_url( 'blogs' ) ); ?>"><?php esc_html_e( 'Blog', 'growtele' ); ?></a></li>
				</ul>
			</div>
			<div class="gt-footer__col gt-footer__col--social">
				<h4><?php esc_html_e( 'Follow Us', 'growtele' ); ?></h4>
				<div class="gt-footer__socials">
					<?php foreach ( $social_links as $social ) : ?>
						<?php if ( ! empty( $social['pending'] ) ) : ?>
							<span class="gt-footer__social-link gt-footer__social-link--pending" aria-label="<?php echo esc_attr( $social['label'] ); ?>">
								<?php echo $social['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- inline SVG markup. ?>
							</span>
						<?php else : ?>
							<a
								class="gt-footer__social-link"
								href="<?php echo esc_url( $social['url'] ); ?>"
								target="_blank"
								rel="noopener noreferrer"
								aria-label="<?php echo esc_attr( $social['label'] ); ?>"
							>
								<?php echo $social['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- inline SVG markup. ?>
							</a>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
				<h4 class="gt-footer__contact-heading"><?php esc_html_e( 'Contact Us', 'growtele' ); ?></h4>
				<a href="mailto:<?php echo esc_attr( $email ); ?>" class="gt-footer__email"><?php echo esc_html( $email ); ?></a>
			</div>
		</div>

		<div class="gt-footer__bottom">
			<p class="gt-footer__legal">
				<a href="#"><?php esc_html_e( 'Privacy Policy', 'growtele' ); ?></a>
				<span>|</span>
				<a href="#"><?php esc_html_e( 'Terms & Condition', 'growtele' ); ?></a>
				<span>|</span>
				<a href="#"><?php esc_html_e( 'Security', 'growtele' ); ?></a>
				<span>|</span>
				<a href="#"><?php esc_html_e( 'Partners Term of Use', 'growtele' ); ?></a>
			</p>
			<p class="gt-footer__copy"><?php esc_html_e( 'Growtele © 2026. All rights reserved.', 'growtele' ); ?></p>
		</div>
	</div>
</footer>
