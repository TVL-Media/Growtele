<?php
/**
 * Pre-footer CTA section
 *
 * @package Growtele
 */
?>
<section class="gt-cta gt-section" id="cta">
	<div class="gt-container gt-cta__inner">
		<div class="gt-cta__visual" data-animate="fade-right">
			<div class="gt-cta__visual-media">
				<img src="<?php echo esc_url( growtele_get_image( 'sections/group-525.png' ) ); ?>" alt="<?php esc_attr_e( 'WhatsApp interface', 'growtele' ); ?>" class="gt-cta__visual-img" loading="eager" decoding="async" width="438" height="351" />
			</div>
		</div>
		<div class="gt-cta__content" data-animate="fade-up">
			<h2>
				<?php esc_html_e( 'Power Smarter Customer', 'growtele' ); ?><br>
				<?php esc_html_e( 'Conversations at Scale', 'growtele' ); ?>
			</h2>
			<p><?php esc_html_e( 'Engage customers across SMS, WhatsApp, RCS, Email, and Voice through one unified communication platform built for reliability, performance, and growth', 'growtele' ); ?></p>
			<a href="<?php echo esc_url( get_theme_mod( 'growtele_cta_url', '#' ) ); ?>" class="gt-btn gt-btn--navy">
				<?php esc_html_e( 'Get Started', 'growtele' ); ?>
			</a>
		</div>
	</div>
</section>
