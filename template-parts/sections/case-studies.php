<?php
/**
 * Case Studies section
 *
 * @package Growtele
 */

$section       = growtele_home_get_section( 'case_studies' );
$case_studies  = $section['items'] ?? array();
$cycle_ms      = $section['cycle_ms'] ?? '5000';
?>
<section class="gt-case-studies gt-section" id="case-studies" data-case-cycle="<?php echo esc_attr( $cycle_ms ); ?>" style="--gt-case-cycle: 3s;">
	<div class="gt-container">
		<?php
		growtele_home_section_heading(
			$section['heading_title'] ?? '',
			$section['heading_desc'] ?? ''
		);
		?>

		<div class="gt-case-studies__nav">
			<div class="gt-case-studies__tabs" data-case-tabs>
				<?php foreach ( $case_studies as $i => $study ) : ?>
					<?php
					$tab_icon = $study['icon'] ?? '';
					$tab_icon_src = ( 0 === strpos( $tab_icon, 'http' ) ) ? $tab_icon : growtele_get_image( 'brands/' . $tab_icon );
					?>
					<button class="gt-case-studies__tab<?php echo 0 === $i ? ' is-active' : ''; ?>" data-case-tab="<?php echo esc_attr( $i ); ?>">
						<img src="<?php echo esc_url( $tab_icon_src ); ?>" alt="<?php echo esc_attr( $study['name'] ); ?>" class="gt-case-studies__tab-logo<?php echo ! empty( $study['icon_class'] ) ? ' gt-case-studies__tab-logo--' . esc_attr( $study['icon_class'] ) : ''; ?>" width="41" height="41" loading="lazy" />
						<div>
							<strong><?php echo esc_html( $study['name'] ); ?></strong>
							<span><?php echo esc_html( $study['category'] ); ?></span>
						</div>
					</button>
				<?php endforeach; ?>
			</div>

			<div class="gt-case-studies__progress">
				<div class="gt-case-studies__progress-bar" data-case-progress></div>
			</div>
		</div>

		<div class="gt-case-studies__stack" data-case-stack>
		<?php foreach ( $case_studies as $i => $study ) : ?>
			<div class="gt-case-studies__panel<?php echo 0 === $i ? ' is-active' : ''; ?>" data-case-panel="<?php echo esc_attr( $i ); ?>" aria-hidden="<?php echo 0 === $i ? 'false' : 'true'; ?>">
				<div class="gt-case-studies__card gt-case-studies__card--<?php echo esc_attr( $study['modifier'] ); ?>">
					<div class="gt-case-studies__card-main gt-case-studies__card-main--<?php echo esc_attr( $study['modifier'] ); ?>">
						<div class="gt-case-studies__card-header">
							<h3><?php echo esc_html( $study['name'] ); ?></h3>
							<span><?php echo esc_html( $study['category'] ); ?></span>
						</div>
						<p class="gt-case-studies__card-desc"><?php echo esc_html( $study['desc'] ); ?></p>
						<div class="gt-case-studies__card-stats">
							<?php foreach ( $study['stats'] as $stat ) : ?>
								<div class="gt-case-studies__stat">
									<span class="gt-case-studies__stat-value"><?php echo esc_html( $stat['value'] ); ?></span>
									<span class="gt-case-studies__stat-label"><?php echo esc_html( $stat['label'] ); ?></span>
								</div>
							<?php endforeach; ?>
						</div>
						<div class="gt-case-studies__card-visual-col">
							<div class="gt-case-studies__card-visual">
								<span class="gt-case-studies__card-visual-bg" aria-hidden="true"></span>
								<?php
								$card_image = ! empty( $study['image'] ) ? $study['image'] : 'sections/case-study-person.png';
								$card_image_src = ( 0 === strpos( $card_image, 'http' ) ) ? $card_image : growtele_get_image( $card_image );
								?>
								<img src="<?php echo esc_url( $card_image_src ); ?>" alt="<?php echo esc_attr( $study['name'] ); ?>" loading="lazy" />
							</div>
						</div>
					</div>
					<div class="gt-case-studies__card-quote">
						<div class="gt-case-studies__quote-body">
							<span class="gt-case-studies__quote-mark gt-case-studies__quote-mark--open">&ldquo;</span>
							<blockquote><?php echo esc_html( $study['quote'] ); ?></blockquote>
							<span class="gt-case-studies__quote-mark gt-case-studies__quote-mark--close">&rdquo;</span>
						</div>
						<cite>
							<strong><?php echo esc_html( $study['author'] ); ?></strong>
							<span><?php echo esc_html( $study['role'] ); ?></span>
						</cite>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
		</div>
	</div>
</section>
