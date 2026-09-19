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
				<?php
				$channel_image = $channel['image'] ?? '';
				if ( is_string( $channel_image ) && preg_match( '#^https?://#i', $channel_image ) ) {
					$channel_image_url = $channel_image;
				} else {
					$channel_image_url = growtele_get_image( 'channels/' . ltrim( (string) $channel_image, '/' ) );
				}
				?>
				<article class="card <?php echo esc_attr( $channel['class'] ); ?>">
					<div class="img img-<?php echo esc_attr( $channel['slug'] ); ?>">
						<img
							class="img-<?php echo esc_attr( $channel['slug'] ); ?>-pic"
							src="<?php echo esc_url( $channel_image_url ); ?>"
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
