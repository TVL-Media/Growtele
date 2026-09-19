<?php
/**
 * Enterprise Scale section
 *
 * @package Growtele
 */

$section = growtele_home_get_section( 'enterprise' );
$cards   = $section['cards'] ?? array();
$clients = $cards['clients'] ?? array();
$messages = $cards['messages'] ?? array();
$uptime  = $cards['uptime'] ?? array();
$support = $cards['support'] ?? array();
?>
<section class="gt-enterprise gt-section" id="enterprise">
	<div class="gt-enterprise__bg" aria-hidden="true">
		<img class="gt-enterprise__bg-image" src="<?php echo esc_url( growtele_get_content_media_url( 'home.enterprise.bg_image', 'sections/enterprise-bg.jpeg' ) ); ?>" alt="" loading="lazy" />
	</div>

	<div class="gt-container">
		<?php
		growtele_home_section_heading(
			$section['heading_title'] ?? '',
			$section['heading_desc'] ?? '',
			'gt-section-heading--light'
		);
		?>

		<div class="gt-enterprise__grid">
			<div class="gt-enterprise__column">
				<article class="gt-enterprise__card gt-enterprise__card--compact" data-animate="fade-up">
					<span class="gt-enterprise__value" data-counter="<?php echo esc_attr( $clients['counter'] ?? '0' ); ?>" data-counter-suffix="<?php echo esc_attr( $clients['suffix'] ?? '' ); ?>">0</span>
					<h3><?php echo esc_html( $clients['title'] ?? '' ); ?></h3>
					<p><?php echo esc_html( $clients['desc'] ?? '' ); ?></p>
				</article>

				<article class="gt-enterprise__card gt-enterprise__card--image gt-enterprise__card--tall" data-animate="fade-up" data-animate-delay="100">
					<img src="<?php echo esc_url( growtele_get_content_media_url( 'home.enterprise.image_tall_1', 'sections/enterprise-card-2.png' ) ); ?>" alt="<?php echo esc_attr( growtele_get_content( 'home.enterprise.image_tall_1.alt', 'Enterprise meeting' ) ); ?>" loading="lazy" />
				</article>
			</div>

			<div class="gt-enterprise__column gt-enterprise__column--balanced">
				<article class="gt-enterprise__card gt-enterprise__card--equal" data-animate="fade-up" data-animate-delay="150">
					<span class="gt-enterprise__value" data-counter="<?php echo esc_attr( $messages['counter'] ?? '0' ); ?>" data-counter-suffix="<?php echo esc_attr( $messages['suffix'] ?? '' ); ?>">0</span>
					<h3><?php echo esc_html( $messages['title'] ?? '' ); ?></h3>
					<p><?php echo esc_html( $messages['desc'] ?? '' ); ?></p>
				</article>

				<article class="gt-enterprise__card gt-enterprise__card--equal" data-animate="fade-up" data-animate-delay="200">
					<span class="gt-enterprise__value" data-counter="<?php echo esc_attr( $uptime['counter'] ?? '0' ); ?>" data-counter-suffix="<?php echo esc_attr( $uptime['suffix'] ?? '' ); ?>"<?php echo ! empty( $uptime['decimals'] ) ? ' data-counter-decimals="' . esc_attr( $uptime['decimals'] ) . '"' : ''; ?>>0</span>
					<h3><?php echo esc_html( $uptime['title'] ?? '' ); ?></h3>
					<p><?php echo esc_html( $uptime['desc'] ?? '' ); ?></p>
				</article>
			</div>

			<div class="gt-enterprise__column">
				<article class="gt-enterprise__card gt-enterprise__card--image gt-enterprise__card--tall" data-animate="fade-up" data-animate-delay="250">
					<img src="<?php echo esc_url( growtele_get_content_media_url( 'home.enterprise.image_tall_2', 'sections/enterprise-card-1.png' ) ); ?>" alt="<?php echo esc_attr( growtele_get_content( 'home.enterprise.image_tall_2.alt', 'Customer support' ) ); ?>" loading="lazy" />
				</article>

				<article class="gt-enterprise__card gt-enterprise__card--compact" data-animate="fade-up" data-animate-delay="300">
					<span class="gt-enterprise__value"><span data-counter="<?php echo esc_attr( $support['counter'] ?? '24' ); ?>">0</span>/<span data-counter="<?php echo esc_attr( $support['counter_secondary'] ?? '7' ); ?>">0</span></span>
					<h3><?php echo esc_html( $support['title'] ?? '' ); ?></h3>
					<p><?php echo esc_html( $support['desc'] ?? '' ); ?></p>
				</article>
			</div>
		</div>
	</div>
</section>
