<?php
/**
 * Enterprise Scale section
 *
 * @package Growtele
 */
?>
<section class="gt-enterprise gt-section" id="enterprise">
	<div class="gt-enterprise__bg" aria-hidden="true">
		<img class="gt-enterprise__bg-image" src="<?php echo esc_url( growtele_get_image( 'sections/enterprise-bg.jpeg' ) ); ?>" alt="" loading="lazy" />
	</div>

	<div class="gt-container">
		<?php
		growtele_section_heading(
			__( 'Delivering Communication at Enterprise Scale', 'growtele' ),
			__( 'Trusted by hundreds of businesses to power billions of customer interactions through secure, scalable, and reliable communication all over worldwide solutions.', 'growtele' ),
			'gt-section-heading--light'
		);
		?>

		<div class="gt-enterprise__grid">
			<div class="gt-enterprise__column">
				<article class="gt-enterprise__card gt-enterprise__card--compact" data-animate="fade-up">
					<span class="gt-enterprise__value" data-counter="300" data-counter-suffix="+">0</span>
					<h3><?php esc_html_e( 'Enterprise Clients', 'growtele' ); ?></h3>
					<p><?php esc_html_e( 'Trusted by 300+ leading brands and enterprises across industries.', 'growtele' ); ?></p>
				</article>

				<article class="gt-enterprise__card gt-enterprise__card--image gt-enterprise__card--tall" data-animate="fade-up" data-animate-delay="100">
					<img src="<?php echo esc_url( growtele_get_image( 'sections/enterprise-card-2.png' ) ); ?>" alt="<?php esc_attr_e( 'Enterprise meeting', 'growtele' ); ?>" loading="lazy" />
				</article>
			</div>

			<div class="gt-enterprise__column gt-enterprise__column--balanced">
				<article class="gt-enterprise__card gt-enterprise__card--equal" data-animate="fade-up" data-animate-delay="150">
					<span class="gt-enterprise__value" data-counter="12" data-counter-suffix="B+">0</span>
					<h3><?php esc_html_e( 'Message Delivered', 'growtele' ); ?></h3>
					<p><?php esc_html_e( 'Billions of messages delivered every month with speed and reliability.', 'growtele' ); ?></p>
				</article>

				<article class="gt-enterprise__card gt-enterprise__card--equal" data-animate="fade-up" data-animate-delay="200">
					<span class="gt-enterprise__value" data-counter="99.9" data-counter-suffix="%" data-counter-decimals="1">0</span>
					<h3><?php esc_html_e( 'Platform Uptime', 'growtele' ); ?></h3>
					<p><?php esc_html_e( 'Enterprise-grade infrastructure ensuring reliability you can count on.', 'growtele' ); ?></p>
				</article>
			</div>

			<div class="gt-enterprise__column">
				<article class="gt-enterprise__card gt-enterprise__card--image gt-enterprise__card--tall" data-animate="fade-up" data-animate-delay="250">
					<img src="<?php echo esc_url( growtele_get_image( 'sections/enterprise-card-1.png' ) ); ?>" alt="<?php esc_attr_e( 'Customer support', 'growtele' ); ?>" loading="lazy" />
				</article>

				<article class="gt-enterprise__card gt-enterprise__card--compact" data-animate="fade-up" data-animate-delay="300">
					<span class="gt-enterprise__value"><span data-counter="24">0</span>/<span data-counter="7">0</span></span>
					<h3><?php esc_html_e( 'Expert Support', 'growtele' ); ?></h3>
					<p><?php esc_html_e( 'Our support team is always available to help you succeed.', 'growtele' ); ?></p>
				</article>
			</div>
		</div>
	</div>
</section>
