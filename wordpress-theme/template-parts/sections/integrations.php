<?php
/**
 * Integrations section
 *
 * @package Growtele
 */
?>
<section class="gt-integrations gt-section" id="integrations">
	<div class="gt-integrations__bg" aria-hidden="true">
		<img src="<?php echo esc_url( growtele_get_image( 'integrations/integrations-bg.png' ) ); ?>" alt="" loading="lazy" />
	</div>

	<div class="gt-container gt-integrations__inner">
		<div class="gt-integrations__content" data-animate="fade-up">
			<h2 class="gt-integrations__title"><?php esc_html_e( 'Building Strong Relationships That Drive Business Growth', 'growtele' ); ?></h2>
			<p class="gt-integrations__desc"><?php esc_html_e( 'Trusted by leading brands and enterprises to deliver reliable, scalable, and impactful customer communication experiences.', 'growtele' ); ?></p>
			<a href="#" class="gt-btn gt-btn--gradient gt-btn--learn">
				<span><?php esc_html_e( 'Learn More', 'growtele' ); ?></span>
				<img src="<?php echo esc_url( growtele_get_image( 'icons/learn-more-arrow.png' ) ); ?>" alt="" width="26" height="26" loading="lazy" />
			</a>
		</div>

		<div class="gt-integrations__diagram gt-orbit-diagram" data-animate="fade-left" aria-label="<?php esc_attr_e( 'Growtele integrations with Salesforce, Shopify, Zoho CRM, and more', 'growtele' ); ?>">
			<img src="<?php echo esc_url( growtele_get_image( 'integrations/integrations-orbit-3.svg' ) ); ?>" alt="" class="gt-orbit-diagram__bg" aria-hidden="true" />
			<img src="<?php echo esc_url( growtele_get_image( 'integrations/integrations-orbit-2.svg' ) ); ?>" alt="" class="gt-orbit-diagram__ring gt-orbit-diagram__ring--mid" aria-hidden="true" />
			<img src="<?php echo esc_url( growtele_get_image( 'integrations/integrations-orbit-1.svg' ) ); ?>" alt="" class="gt-orbit-diagram__ring gt-orbit-diagram__ring--inner" aria-hidden="true" />

			<div class="gt-orbit-diagram__center" aria-hidden="true">
				<img src="<?php echo esc_url( growtele_get_asset( 'growtele-logo-2-png-icon.png' ) ); ?>" alt="" loading="lazy" />
			</div>

			<div class="gt-orbit-diagram__track gt-orbit-diagram__track--outer">
				<div class="gt-orbit-diagram__item" style="--angle: 0deg;"><span class="gt-orbit-diagram__icon-slot"><span class="gt-orbit-diagram__icon-upright"><span class="gt-orbit-diagram__icon-counter"><img src="<?php echo esc_url( growtele_get_asset( 'webengage.png' ) ); ?>" alt="WebEngage" loading="lazy" /></span></span></span></div>
				<div class="gt-orbit-diagram__item" style="--angle: 58deg;"><span class="gt-orbit-diagram__icon-slot"><span class="gt-orbit-diagram__icon-upright"><span class="gt-orbit-diagram__icon-counter"><img src="<?php echo esc_url( growtele_get_asset( 'shopyfy.png' ) ); ?>" alt="Shopify" loading="lazy" /></span></span></span></div>
				<div class="gt-orbit-diagram__item" style="--angle: 142deg;"><span class="gt-orbit-diagram__icon-slot"><span class="gt-orbit-diagram__icon-upright"><span class="gt-orbit-diagram__icon-counter"><img src="<?php echo esc_url( growtele_get_asset( 'sale-force.png' ) ); ?>" alt="Salesforce" loading="lazy" /></span></span></span></div>
				<div class="gt-orbit-diagram__item" style="--angle: 238deg;"><span class="gt-orbit-diagram__icon-slot"><span class="gt-orbit-diagram__icon-upright"><span class="gt-orbit-diagram__icon-counter"><img src="<?php echo esc_url( growtele_get_asset( 'moenageg.png' ) ); ?>" alt="MoEngage" loading="lazy" /></span></span></span></div>
			</div>

			<div class="gt-orbit-diagram__track gt-orbit-diagram__track--middle">
				<div class="gt-orbit-diagram__item" style="--angle: -90deg;"><span class="gt-orbit-diagram__icon-slot"><span class="gt-orbit-diagram__icon-upright"><span class="gt-orbit-diagram__icon-counter"><img src="<?php echo esc_url( growtele_get_asset( 'clevertap.png' ) ); ?>" alt="CleverTap" loading="lazy" /></span></span></span></div>
				<div class="gt-orbit-diagram__item" style="--angle: 30deg;"><span class="gt-orbit-diagram__icon-slot"><span class="gt-orbit-diagram__icon-upright"><span class="gt-orbit-diagram__icon-counter"><img src="<?php echo esc_url( growtele_get_asset( 'lead-squared.png' ) ); ?>" alt="LeadSquared" loading="lazy" /></span></span></span></div>
				<div class="gt-orbit-diagram__item" style="--angle: 150deg;"><span class="gt-orbit-diagram__icon-slot"><span class="gt-orbit-diagram__icon-upright"><span class="gt-orbit-diagram__icon-counter"><img src="<?php echo esc_url( growtele_get_asset( 'zoho.png' ) ); ?>" alt="Zoho CRM" loading="lazy" /></span></span></span></div>
			</div>
		</div>
	</div>
</section>
