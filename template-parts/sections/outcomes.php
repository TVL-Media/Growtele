<?php
/**
 * Business Outcomes section
 *
 * @package Growtele
 */

$outcomes = growtele_home_get_section( 'outcomes' );
$stat_1   = $outcomes['stat_1'] ?? array();
$stat_2   = $outcomes['stat_2'] ?? array();
?>
<section class="gt-outcomes gt-section" id="outcomes">
	<div class="gt-container">
		<div class="gt-section-heading">
			<h2 class="gt-section-heading__title" data-animate="fade-up">
				<?php
				echo wp_kses(
					$outcomes['heading_title'] ?? '',
					array(
						'br' => array(),
					)
				);
				?>
			</h2>
			<p class="gt-section-heading__desc" data-animate="fade-up" data-animate-delay="100">
				<?php
				echo wp_kses(
					$outcomes['heading_desc'] ?? '',
					array(
						'br' => array(),
					)
				);
				?>
			</p>
		</div>

		<div class="gt-outcomes__grid">
			<article class="gt-outcomes__card gt-outcomes__card--dark" data-animate="fade-up">
				<div class="gt-outcomes__card-bg">
					<img src="<?php echo esc_url( growtele_get_content_media_url( 'home.outcomes.card_bg', 'sections/outcomes-mask.svg' ) ); ?>" alt="" loading="lazy" />
				</div>
				<div class="gt-outcomes__card-content">
					<h3 class="gt-outcomes__card-title"><?php echo esc_html( $outcomes['card_title'] ?? '' ); ?></h3>
					<p class="gt-outcomes__card-desc">
						<?php
						echo wp_kses(
							$outcomes['card_desc'] ?? '',
							array(
								'br' => array(),
							)
						);
						?>
					</p>
					<div class="gt-outcomes__stats">
						<div class="gt-outcomes__stat">
							<span class="gt-outcomes__stat-value" data-counter="<?php echo esc_attr( $stat_1['counter'] ?? '0' ); ?>" data-counter-suffix="<?php echo esc_attr( $stat_1['suffix'] ?? '' ); ?>">0</span>
							<span class="gt-outcomes__stat-label"><?php echo esc_html( $stat_1['label'] ?? '' ); ?></span>
						</div>
						<div class="gt-outcomes__stat">
							<span class="gt-outcomes__stat-value" data-counter="<?php echo esc_attr( $stat_2['counter'] ?? '0' ); ?>" data-counter-suffix="<?php echo esc_attr( $stat_2['suffix'] ?? '' ); ?>">0</span>
							<span class="gt-outcomes__stat-label"><?php echo esc_html( $stat_2['label'] ?? '' ); ?></span>
						</div>
					</div>
				</div>
			</article>

			<article class="gt-outcomes__card gt-outcomes__card--reach" data-animate="fade-up" data-animate-delay="150">
				<video class="gt-outcomes__reach-video" autoplay muted loop playsinline preload="metadata">
					<source src="<?php echo esc_url( growtele_get_content_video_url( 'home.outcomes.video', 'outcomes' ) ); ?>" type="video/mp4" />
				</video>
				<script>
				(function () {
					var video = document.currentScript && document.currentScript.previousElementSibling;
					if (!video || !video.classList.contains('gt-outcomes__reach-video')) {
						video = document.querySelector('.gt-outcomes__reach-video');
					}
					if (!video) return;

					function revealOutcomesVideo() {
						video.classList.add('is-loaded');
						video.dataset.videoReady = 'true';
					}

					function startOutcomesVideo() {
						var playAttempt = video.play();
						if (playAttempt && typeof playAttempt.catch === 'function') {
							playAttempt.catch(function () {});
						}
						revealOutcomesVideo();
					}

					if (video.readyState >= 2) {
						startOutcomesVideo();
						return;
					}

					video.addEventListener('loadeddata', startOutcomesVideo, { once: true });
				})();
				</script>
			</article>
		</div>
	</div>
</section>
