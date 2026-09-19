<?php
/**
 * Industry Solutions section with tabs
 *
 * @package Growtele
 */

$section    = growtele_home_get_section( 'industries' );
$industries = $section['items'] ?? array();
?>
<section class="gt-industries gt-section" id="industries">
	<div class="gt-container">
		<div class="gt-industries__stage" data-industry-stage>
			<div class="gt-section-heading">
				<h2 class="gt-section-heading__title"><?php echo esc_html( $section['heading_title'] ?? '' ); ?></h2>
				<p class="gt-section-heading__desc"><?php echo esc_html( $section['heading_desc'] ?? '' ); ?></p>
			</div>

			<div class="gt-industries__tabs" role="tablist" aria-label="<?php esc_attr_e( 'Industry Solutions', 'growtele' ); ?>" data-tabs>
				<?php $first = true; foreach ( $industries as $key => $industry ) : ?>
					<button
						class="gt-industries__tab<?php echo $first ? ' is-active' : ''; ?>"
						role="tab"
						id="tab-<?php echo esc_attr( $key ); ?>"
						aria-selected="<?php echo $first ? 'true' : 'false'; ?>"
						aria-controls="panel-<?php echo esc_attr( $key ); ?>"
						data-tab="<?php echo esc_attr( $key ); ?>"
					>
						<span class="gt-industries__tab-icon" aria-hidden="true">
							<img
								src="<?php echo esc_url( growtele_get_asset( $industry['icon'] ) ); ?>"
								alt=""
								width="36"
								height="36"
								loading="lazy"
							/>
						</span>
						<span class="gt-industries__tab-label"><?php echo esc_html( $industry['label'] ); ?></span>
					</button>
				<?php $first = false; endforeach; ?>
			</div>

			<div class="gt-industries__stack" data-industry-stack>
				<?php $first = true; foreach ( $industries as $key => $industry ) : ?>
					<div
						class="gt-industries__panel<?php echo $first ? ' is-active' : ''; ?>"
						role="tabpanel"
						id="panel-<?php echo esc_attr( $key ); ?>"
						aria-labelledby="tab-<?php echo esc_attr( $key ); ?>"
						data-tab-panel="<?php echo esc_attr( $key ); ?>"
						aria-hidden="<?php echo $first ? 'false' : 'true'; ?>"
					>
						<div class="gt-industries__panel-inner gt-industries__panel-inner<?php echo esc_attr( $industry['panel_style'] ); ?>">
							<div class="gt-industries__panel-left">
								<div class="gt-industries__panel-icon">
									<img
										src="<?php echo esc_url( growtele_get_image( 'industries/' . $industry['panel_icon'] ) ); ?>"
										alt=""
										width="34"
										height="34"
										loading="lazy"
									/>
								</div>
								<div class="gt-industries__panel-content">
									<h3 class="gt-industries__panel-title"><?php echo esc_html( $industry['label'] ); ?></h3>
									<p class="gt-industries__panel-desc"><?php echo esc_html( $industry['desc'] ); ?></p>
								</div>
							</div>
							<div class="gt-industries__panel-visual">
								<?php
								$panel_visual = $industry['panel_visual'] ?? '';
								if ( is_string( $panel_visual ) && preg_match( '#^https?://#i', $panel_visual ) ) {
									$panel_visual_url = $panel_visual;
								} else {
									$panel_visual_url = growtele_get_image( 'industries/' . ltrim( (string) $panel_visual, '/' ) );
								}
								?>
								<img
									class="gt-industries__visual-img gt-industries__visual-img--<?php echo esc_attr( $key ); ?>"
									src="<?php echo esc_url( $panel_visual_url ); ?>"
									alt="<?php echo esc_attr( $industry['label'] ); ?>"
									loading="lazy"
								/>
							</div>
						</div>
					</div>
				<?php $first = false; endforeach; ?>
			</div>
		</div>
	</div>
</section>
