<?php
/**
 * Hero section
 *
 * @package Growtele
 */

$hero = growtele_home_get_section( 'hero' );
$hero_features = $hero['features'] ?? array();
$hero_brands   = $hero['trust_brands'] ?? array();
?>
<section class="gt-hero" id="hero" aria-label="<?php esc_attr_e( 'Hero', 'growtele' ); ?>">
	<div class="gt-hero__bg">
		<video
			class="gt-hero__bg-video"
			autoplay
			muted
			loop
			playsinline
			preload="none"
			fetchpriority="low"
		>
			<source src="<?php echo esc_url( growtele_get_content_video_url( 'home.hero.video', 'hero' ) ); ?>" type="video/mp4" />
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

			function scheduleHeroVideo() {
				if (video.readyState >= 2) {
					startHeroVideo();
					return;
				}

				video.addEventListener('loadeddata', startHeroVideo, { once: true });
				video.load();
			}

			if (document.readyState === 'complete') {
				scheduleHeroVideo();
			} else {
				window.addEventListener('load', scheduleHeroVideo, { once: true });
			}
		})();
		</script>
		<div class="gt-hero__overlay"></div>
	</div>

	<div class="gt-container gt-hero__content">
		<div class="gt-hero__badge" data-animate="fade-up">
			<img src="<?php echo esc_url( growtele_get_content_media_url( 'home.hero.badge_icon', 'icons/sparkle.png' ) ); ?>" alt="" width="18" height="18" loading="eager" />
			<span><?php echo esc_html( $hero['badge_text'] ?? '' ); ?> <strong><?php echo esc_html( $hero['badge_strong'] ?? '' ); ?></strong></span>
		</div>

		<h1 class="gt-hero__title" data-animate="fade-up" data-animate-delay="100">
			<span class="gt-hero__title-line"><?php echo esc_html( $hero['title_line_1'] ?? '' ); ?></span>
			<span class="gt-hero__title-line gt-hero__title-line--bold"><?php echo esc_html( $hero['title_line_2'] ?? '' ); ?></span>
		</h1>

		<div class="gt-hero__divider" data-animate="fade-up" data-animate-delay="150"></div>

		<p class="gt-hero__subtitle" data-animate="fade-up" data-animate-delay="200">
			<span class="gt-hero__subtitle-line gt-hero__subtitle-line--primary"><?php echo esc_html( $hero['subtitle_line_1'] ?? '' ); ?></span><br />
			<span class="gt-hero__subtitle-line"><?php echo esc_html( $hero['subtitle_line_2'] ?? '' ); ?></span>
		</p>

		<div class="gt-hero__features" data-animate="fade-up" data-animate-delay="300">
			<?php foreach ( $hero_features as $feature ) : ?>
				<?php
				$icon_field = is_array( $feature['icon'] ?? null ) ? $feature['icon'] : array();
				$icon_url   = growtele_get_media_url( $icon_field, $icon_field['fallback'] ?? '' );
				?>
			<div class="gt-hero__feature">
				<div class="gt-hero__feature-icon">
					<img src="<?php echo esc_url( $icon_url ); ?>" alt="" width="32" height="32" loading="lazy" />
				</div>
				<span><?php echo esc_html( $feature['label'] ?? '' ); ?></span>
			</div>
			<?php endforeach; ?>
		</div>
	</div>

	<div class="gt-hero__trust">
		<div class="gt-container gt-hero__trust-inner">
			<div class="gt-hero__trust-label">
				<img src="<?php echo esc_url( growtele_get_content_media_url( 'home.hero.trust_icon', 'icons/shield.png' ) ); ?>" alt="" width="45" height="46" loading="lazy" />
				<span><?php echo esc_html( $hero['trust_label'] ?? '' ); ?></span>
			</div>
			<div class="gt-marquee" data-marquee>
				<div class="gt-marquee__track">
					<?php
					for ( $i = 0; $i < 2; $i++ ) :
						foreach ( $hero_brands as $brand ) :
							$url      = $brand['url'] ?? '';
							$file     = $brand['file'] ?? '';
							$modifier = $brand['modifier'] ?? '';
							
							// Support both URL and file-based brands
							if ( $url ) {
								$brand_src = $url;
							} elseif ( $file ) {
								$brand_src = growtele_get_image( 'brands/' . $file );
							} else {
								continue;
							}
							
							$item_class = 'gt-marquee__item' . ( $modifier ? ' ' . $modifier : '' );
							?>
							<div class="<?php echo esc_attr( $item_class ); ?>">
								<img src="<?php echo esc_url( $brand_src ); ?>" alt="" loading="lazy" />
							</div>
							<?php
						endforeach;
					endfor;
					?>
				</div>
			</div>
		</div>
	</div>
	<script>
	(function () {
		document.querySelectorAll('.gt-hero [data-animate]').forEach(function (el) {
			if (el.classList.contains('is-visible')) {
				return;
			}

			var delay = parseInt(el.getAttribute('data-animate-delay') || '0', 10);
			var reveal = function () {
				el.classList.add('is-visible');
			};

			if (delay > 0) {
				setTimeout(reveal, delay);
			} else {
				reveal();
			}
		});
	})();
	</script>
</section>
