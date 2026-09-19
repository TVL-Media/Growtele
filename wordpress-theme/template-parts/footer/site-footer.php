<?php
/**
 * Site footer
 *
 * @package Growtele
 */

$email        = function_exists( 'growtele_get_contact_email' ) ? growtele_get_contact_email() : 'enquiry@growtele.com';
$social_cms   = function_exists( 'growtele_get_content' ) ? growtele_get_content( 'footer.social', array() ) : array();
$icon_map     = function_exists( 'growtele_footer_social_icons' ) ? growtele_footer_social_icons() : array();
$social_links = array();

if ( is_array( $social_cms ) ) {
	foreach ( $social_cms as $item ) {
		$label = $item['label'] ?? '';
		if ( '' === $label ) {
			continue;
		}
		$social_links[] = array(
			'label' => $label,
			'url'   => $item['url'] ?? '',
			'icon'  => $icon_map[ $label ] ?? '',
		);
	}
}

if ( empty( $social_links ) ) {
	$social_links = array(
		array(
			'label' => 'Facebook',
			'url'   => 'https://www.facebook.com/Growtele',
			'icon'  => $icon_map['Facebook'],
		),
		array(
			'label' => 'X',
			'url'   => 'https://x.com/growtele',
			'icon'  => $icon_map['X'],
		),
		array(
			'label' => 'Instagram',
			'url'   => 'https://www.instagram.com/growtele/',
			'icon'  => $icon_map['Instagram'],
		),
		array(
			'label' => 'YouTube',
			'url'   => 'https://www.youtube.com/@growtele4803',
			'icon'  => $icon_map['YouTube'],
		),
		array(
			'label' => 'LinkedIn',
			'url'   => 'https://www.linkedin.com/company/growtele/?viewAsMember=true',
			'icon'  => $icon_map['LinkedIn'],
		),
	);
}

$footer_columns = function_exists( 'growtele_get_content' ) ? growtele_get_content( 'footer.columns', array() ) : array();
$legal_links    = function_exists( 'growtele_get_content' ) ? growtele_get_content( 'footer.legal', array() ) : array();
$touch_img_url  = function_exists( 'growtele_get_content_media_url' ) ? growtele_get_content_media_url( 'footer.get_in_touch_image', 'icons/get-in-touch.png' ) : ( function_exists( 'growtele_get_image' ) ? growtele_get_image( 'icons/get-in-touch.png' ) : '' );
?>
<footer id="colophon" class="gt-footer">
	<div class="gt-footer__glow"></div>
	<div class="gt-container gt-footer__inner">
		<div class="gt-footer__brand">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="gt-footer__logo">
				<?php growtele_image( 'icons/logo.png', get_bloginfo( 'name' ), '', 163, 42 ); ?>
			</a>
			<p><?php echo esc_html( function_exists( 'growtele_get_content' ) ? growtele_get_content( 'footer.brand_description', "Growtele's global network solutions enable every business sector to optimize their business across the globe." ) : "Growtele's global network solutions enable every business sector to optimize their business across the globe." ); ?></p>
			<a href="mailto:<?php echo esc_attr( $email ); ?>" class="gt-footer__cta">
				<img src="<?php echo esc_url( $touch_img_url ); ?>" alt="<?php esc_attr_e( 'Get In Touch', 'growtele' ); ?>" width="165" height="35" loading="lazy" />
			</a>
		</div>

		<div class="gt-footer__nav">
			<?php
			$col_keys = array( 'products', 'company', 'resources' );
			foreach ( $col_keys as $col_key ) :
				$col = is_array( $footer_columns[ $col_key ] ?? null ) ? $footer_columns[ $col_key ] : array();
				$col_title = $col['title'] ?? '';
				$col_links = $col['links'] ?? array();
				if ( '' === $col_title ) {
					continue;
				}
				?>
			<div class="gt-footer__col">
				<h4><?php echo esc_html( $col_title ); ?></h4>
				<ul>
					<?php foreach ( $col_links as $link ) : ?>
						<?php if ( empty( $link['label'] ) ) : ?>
							<?php continue; ?>
						<?php endif; ?>
					<li><a href="<?php echo esc_url( function_exists( 'growtele_content_resolve_page_url' ) ? growtele_content_resolve_page_url( $link ) : ( $link['url'] ?? '#' ) ); ?>"><?php echo esc_html( $link['label'] ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php endforeach; ?>
			<div class="gt-footer__col gt-footer__col--social">
				<h4><?php echo esc_html( function_exists( 'growtele_get_content' ) ? growtele_get_content( 'footer.follow_heading', 'Follow Us' ) : 'Follow Us' ); ?></h4>
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
				<h4 class="gt-footer__contact-heading"><?php echo esc_html( function_exists( 'growtele_get_content' ) ? growtele_get_content( 'footer.contact_heading', 'Contact Us' ) : 'Contact Us' ); ?></h4>
				<a href="mailto:<?php echo esc_attr( $email ); ?>" class="gt-footer__email"><?php echo esc_html( $email ); ?></a>
			</div>
		</div>

		<div class="gt-footer__bottom">
			<p class="gt-footer__legal">
				<?php
				if ( is_array( $legal_links ) && ! empty( $legal_links ) ) :
					$legal_count = count( $legal_links );
					foreach ( $legal_links as $i => $legal ) :
						if ( empty( $legal['label'] ) ) {
							continue;
						}
						?>
					<a href="<?php echo esc_url( function_exists( 'growtele_content_resolve_page_url' ) ? growtele_content_resolve_page_url( $legal ) : ( $legal['url'] ?? '#' ) ); ?>"><?php echo esc_html( $legal['label'] ); ?></a>
						<?php if ( $i < $legal_count - 1 ) : ?>
					<span>|</span>
						<?php endif; ?>
						<?php
					endforeach;
				else :
					?>
					<a href="#"><?php esc_html_e( 'Privacy Policy', 'growtele' ); ?></a>
					<span>|</span>
					<a href="#"><?php esc_html_e( 'Terms & Condition', 'growtele' ); ?></a>
					<span>|</span>
					<a href="#"><?php esc_html_e( 'Security', 'growtele' ); ?></a>
					<span>|</span>
					<a href="#"><?php esc_html_e( 'Partners Term of Use', 'growtele' ); ?></a>
				<?php endif; ?>
			</p>
			<p class="gt-footer__copy"><?php echo esc_html( function_exists( 'growtele_get_content' ) ? growtele_get_content( 'footer.copyright', 'Growtele © 2026. All rights reserved.' ) : 'Growtele © 2026. All rights reserved.' ); ?></p>
		</div>
	</div>
</footer>
