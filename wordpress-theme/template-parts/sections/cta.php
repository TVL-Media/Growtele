<?php
/**
 * Pre-footer CTA section
 *
 * @package Growtele
 */
?>
<?php
$gt_cta       = growtele_get_content( 'shared.cta', array() );
$gt_cta_image = is_array( $gt_cta['image'] ?? null ) ? $gt_cta['image'] : array();
$gt_cta_w     = absint( $gt_cta_image['width'] ?? 438 );
$gt_cta_h     = absint( $gt_cta_image['height'] ?? 351 );
?>
<section class="gt-cta gt-section" id="cta">
	<div class="gt-container gt-cta__inner">
		<div class="gt-cta__visual" data-animate="fade-right">
			<div class="gt-cta__visual-media">
				<img src="<?php echo esc_url( growtele_get_content_media_url( 'shared.cta.image', 'sections/group-525.png' ) ); ?>" alt="<?php echo esc_attr( growtele_get_content( 'shared.cta.image.alt', __( 'WhatsApp interface', 'growtele' ) ) ); ?>" class="gt-cta__visual-img" loading="eager" decoding="async" width="<?php echo esc_attr( $gt_cta_w ); ?>" height="<?php echo esc_attr( $gt_cta_h ); ?>" />
			</div>
		</div>
		<div class="gt-cta__content" data-animate="fade-up">
			<h2>
				<?php echo esc_html( growtele_get_content( 'shared.cta.heading_line_1', 'Reach Every Customer' ) ); ?><br>
				<?php echo esc_html( growtele_get_content( 'shared.cta.heading_line_2', 'on the Right Channel' ) ); ?>
			</h2>
			<p><?php echo esc_html( growtele_get_content( 'shared.cta.description', 'Send OTPs, alerts, promotions, and support messages on SMS, WhatsApp, RCS, Email, and Voice from one dependable platform built for enterprise volumes' ) ); ?></p>
			<a href="<?php echo esc_url( growtele_get_shared_cta_url() ); ?>" class="gt-btn gt-btn--navy">
				<?php echo esc_html( growtele_get_content( 'shared.cta.button_text', 'Get Started' ) ); ?>
			</a>
		</div>
	</div>
</section>
