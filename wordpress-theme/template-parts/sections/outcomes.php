<?php
/**
 * Business Outcomes section
 *
 * @package Growtele
 */
?>
<section class="gt-outcomes gt-section" id="outcomes">
	<div class="gt-container">
		<div class="gt-section-heading">
			<h2 class="gt-section-heading__title" data-animate="fade-up">
				<?php
				echo wp_kses(
					__( 'Communication That<br>Drives Business Outcomes', 'growtele' ),
					array(
						'br' => array(),
					)
				);
				?>
			</h2>
			<p class="gt-section-heading__desc" data-animate="fade-up" data-animate-delay="100">
				<?php
				echo wp_kses(
					__( 'Reliable, secure, and scalable communication solutions<br>built to help businesses connect, engage, and grow.', 'growtele' ),
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
					<img src="<?php echo esc_url( growtele_get_image( 'sections/outcomes-mask.svg' ) ); ?>" alt="" loading="lazy" />
				</div>
				<div class="gt-outcomes__card-content">
					<h3 class="gt-outcomes__card-title"><?php esc_html_e( 'Smarter Customer Engagement', 'growtele' ); ?></h3>
					<p class="gt-outcomes__card-desc">
						<?php
						echo wp_kses(
							__( 'Deliver meaningful, personalized conversations across SMS, WhatsApp, RCS, Email, and Voice with intelligent communication solutions designed to help businesses connect with customers at every stage of their journey.', 'growtele' ),
							array(
								'br' => array(),
							)
						);
						?>
					</p>
					<div class="gt-outcomes__stats">
						<div class="gt-outcomes__stat">
							<span class="gt-outcomes__stat-value" data-counter="12" data-counter-suffix="B+">0</span>
							<span class="gt-outcomes__stat-label"><?php esc_html_e( 'Messages Delivered Globally', 'growtele' ); ?></span>
						</div>
						<div class="gt-outcomes__stat">
							<span class="gt-outcomes__stat-value" data-counter="300" data-counter-suffix="+">0</span>
							<span class="gt-outcomes__stat-label"><?php esc_html_e( 'Enterprise Clients Served', 'growtele' ); ?></span>
						</div>
					</div>
				</div>
			</article>

			<article class="gt-outcomes__card gt-outcomes__card--reach" data-animate="fade-up" data-animate-delay="150">
				<video class="gt-outcomes__reach-video" autoplay muted loop playsinline preload="auto">
					<source src="<?php echo esc_url( growtele_get_cdn_video( 'outcomes' ) ); ?>" type="video/mp4" />
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
