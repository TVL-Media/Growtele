<?php
/**
 * Channel Overview section — GSAP fan/stack cards
 *
 * @package Growtele
 */

$section  = growtele_home_get_section( 'channels' );
$channels = $section['items'] ?? array();
?>
<section class="gt-channels gt-section" id="channels">
	<div class="gt-container">
		<?php
		growtele_home_section_heading(
			$section['heading_title'] ?? '',
			$section['heading_desc'] ?? ''
		);
		?>

		<div class="cards-wrapper">
			<?php foreach ( $channels as $channel ) : ?>
				<article class="card <?php echo esc_attr( $channel['class'] ); ?>">
					<div class="img img-<?php echo esc_attr( $channel['slug'] ); ?>">
						<img
							class="img-<?php echo esc_attr( $channel['slug'] ); ?>-pic"
							src="<?php echo esc_url( growtele_get_image( 'channels/' . $channel['image'] ) ); ?>"
							alt="<?php echo esc_attr( $channel['label'] ); ?>"
							loading="lazy"
						/>
					</div>
					<div class="content">
						<h3 class="bluebg"><?php echo esc_html( $channel['label'] ); ?></h3>
						<p class="blueft"><?php echo esc_html( $channel['desc'] ); ?></p>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
