<?php
/**
 * Hero section
 *
 * @package Growtele
 */
?>
<section class="gt-hero" id="hero" aria-label="<?php esc_attr_e( 'Hero', 'growtele' ); ?>">
	<div class="gt-hero__bg">
		<video
			class="gt-hero__bg-video"
			autoplay
			muted
			loop
			playsinline
			preload="auto"
		>
			<source src="<?php echo esc_url( growtele_get_cdn_video( 'hero' ) ); ?>" type="video/mp4" />
		</video>
		<script>
		(function () {
			var video = document.currentScript && document.currentScript.previousElementSibling;
			if (!video || !video.classList.contains('gt-hero__bg-video')) {
				video = document.querySelector('.gt-hero__bg-video');
			}
			if (!video) return;

			function revealHeroVideo() {
				video.classList.add('is-loaded');
				video.dataset.videoReady = 'true';
			}

			function startHeroVideo() {
				var playAttempt = video.play();
				if (playAttempt && typeof playAttempt.catch === 'function') {
					playAttempt.catch(function () {});
				}
				revealHeroVideo();
			}

			if (video.readyState >= 2) {
				startHeroVideo();
				return;
			}

			video.addEventListener('loadeddata', startHeroVideo, { once: true });
		})();
		</script>
		<div class="gt-hero__overlay"></div>
	</div>

	<div class="gt-container gt-hero__content">
		<div class="gt-hero__badge" data-animate="fade-up">
			<img src="<?php echo esc_url( growtele_get_image( 'icons/sparkle.png' ) ); ?>" alt="" width="18" height="18" loading="eager" />
			<span><?php esc_html_e( 'Smarter Communication.', 'growtele' ); ?> <strong><?php esc_html_e( 'Stronger Connection', 'growtele' ); ?></strong></span>
		</div>

		<h1 class="gt-hero__title" data-animate="fade-up" data-animate-delay="100">
			<span class="gt-hero__title-line"><?php esc_html_e( 'Powering Smarter', 'growtele' ); ?></span>
			<span class="gt-hero__title-line gt-hero__title-line--bold"><?php esc_html_e( 'Customer Conversations', 'growtele' ); ?></span>
		</h1>

		<div class="gt-hero__divider" data-animate="fade-up" data-animate-delay="150"></div>

		<p class="gt-hero__subtitle" data-animate="fade-up" data-animate-delay="200">
			<?php esc_html_e( 'Deliver secure, real-time communication experiences', 'growtele' ); ?><br />
			<?php esc_html_e( 'across SMS, WhatsApp, RCS, Email, and Voice', 'growtele' ); ?>
		</p>

		<div class="gt-hero__features" data-animate="fade-up" data-animate-delay="300">
			<div class="gt-hero__feature">
				<div class="gt-hero__feature-icon">
					<img src="<?php echo esc_url( growtele_get_image( 'icons/chat-1.png' ) ); ?>" alt="" width="32" height="32" loading="lazy" />
				</div>
				<span><?php esc_html_e( 'Omnichannel Communication', 'growtele' ); ?></span>
			</div>
			<div class="gt-hero__feature">
				<div class="gt-hero__feature-icon">
					<img src="<?php echo esc_url( growtele_get_image( 'icons/chat-2.png' ) ); ?>" alt="" width="32" height="32" loading="lazy" />
				</div>
				<span><?php esc_html_e( 'Secure & Reliable', 'growtele' ); ?></span>
			</div>
			<div class="gt-hero__feature">
				<div class="gt-hero__feature-icon">
					<img src="<?php echo esc_url( growtele_get_image( 'icons/chat-3.png' ) ); ?>" alt="" width="32" height="32" loading="lazy" />
				</div>
				<span><?php esc_html_e( 'Seamless Experience', 'growtele' ); ?></span>
			</div>
		</div>
	</div>

	<div class="gt-hero__trust">
		<div class="gt-container gt-hero__trust-inner">
			<div class="gt-hero__trust-label">
				<img src="<?php echo esc_url( growtele_get_image( 'icons/shield.png' ) ); ?>" alt="" width="45" height="46" loading="lazy" />
				<span><?php esc_html_e( 'Trusted By Leading Brands', 'growtele' ); ?></span>
			</div>
			<div class="gt-marquee" data-marquee>
				<div class="gt-marquee__track">
					<?php
					$brands = array(
						'brand-1' => '',
						'brand-2' => 'gt-marquee__item--tanishq',
						'brand-3' => '',
						'brand-4' => 'gt-marquee__item--tanishq',
						'brand-5' => '',
					);
					for ( $i = 0; $i < 2; $i++ ) :
						foreach ( $brands as $brand => $modifier ) :
							$item_class = 'gt-marquee__item' . ( $modifier ? ' ' . $modifier : '' );
							?>
							<div class="<?php echo esc_attr( $item_class ); ?>">
								<img src="<?php echo esc_url( growtele_get_image( 'brands/' . $brand . '.png' ) ); ?>" alt="" loading="lazy" />
							</div>
							<?php
						endforeach;
					endfor;
					?>
				</div>
			</div>
		</div>
	</div>
</section>
