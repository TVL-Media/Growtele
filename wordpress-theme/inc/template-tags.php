<?php
/**
 * Template tags and helpers
 *
 * @package Growtele
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get theme asset URL.
 *
 * @param string $path Relative path inside assets/.
 * @return string
 */
function growtele_get_asset( $path ) {
	$parts = explode( '/', str_replace( '\\', '/', ltrim( $path, '/' ) ) );
	$parts = array_map(
		static function ( $part ) {
			return rawurlencode( rawurldecode( $part ) );
		},
		$parts
	);

	return GROWTELE_URI . '/assets/' . implode( '/', $parts ) . '?ver=' . GROWTELE_VERSION;
}

/**
 * Get theme image URL.
 *
 * @param string $path Relative path inside assets/images.
 * @return string
 */
function growtele_get_image( $path ) {
	return growtele_get_asset( 'images/' . ltrim( $path, '/' ) );
}

/**
 * Get theme video URL.
 *
 * @param string $path Relative path inside assets/videos.
 * @return string
 */
function growtele_get_video( $path ) {
	return growtele_get_asset( 'videos/' . ltrim( $path, '/' ) );
}

/**
 * Get CDN video URL for production assets.
 *
 * @param string $key Video key (hero, outcomes).
 * @return string
 */
function growtele_get_cdn_video( $key ) {
	if ( 'outcomes' === $key ) {
		return growtele_get_asset( '2-page-video-rectangle-1.mp4' );
	}

	$videos = array(
		'hero' => 'https://listings.selectvia.com/wp-content/uploads/2026/08/Landing-Page-Video-1_compressed-2.mp4',
	);

	return isset( $videos[ $key ] ) ? $videos[ $key ] : '';
}

/**
 * Output lazy-loaded image.
 *
 * @param string $path  Image path.
 * @param string $alt   Alt text.
 * @param string $class CSS class.
 * @param int    $width Width.
 * @param int    $height Height.
 */
function growtele_image( $path, $alt = '', $class = '', $width = '', $height = '' ) {
	$attrs = array(
		'src'   => growtele_get_image( $path ),
		'alt'   => esc_attr( $alt ),
		'class' => esc_attr( $class ),
		'loading' => 'lazy',
		'decoding' => 'async',
	);

	if ( $width ) {
		$attrs['width'] = absint( $width );
	}
	if ( $height ) {
		$attrs['height'] = absint( $height );
	}

	echo '<img';
	foreach ( $attrs as $key => $value ) {
		if ( '' !== $value ) {
			printf( ' %s="%s"', esc_attr( $key ), esc_attr( $value ) );
		}
	}
	echo ' />';
}

/**
 * Render gradient CTA button.
 *
 * @param string $text Button text.
 * @param string $url  Button URL.
 * @param string $class Extra class.
 */
function growtele_cta_button( $text, $url = '#', $class = 'gt-btn gt-btn--gradient' ) {
	?>
	<a href="<?php echo esc_url( $url ); ?>" class="<?php echo esc_attr( $class ); ?>">
		<span class="gt-btn__text"><?php echo esc_html( $text ); ?></span>
		<span class="gt-btn__icon">
			<img src="<?php echo esc_url( growtele_get_image( 'icons/arrow-up-right-dark.png' ) ); ?>" alt="" width="19" height="19" loading="lazy" />
		</span>
	</a>
	<?php
}

/**
 * Get section heading markup.
 *
 * @param string $title Section title.
 * @param string $desc  Section description.
 * @param string $class Modifier class.
 */
function growtele_section_heading( $title, $desc = '', $class = '' ) {
	?>
	<div class="gt-section-heading <?php echo esc_attr( $class ); ?>">
		<h2 class="gt-section-heading__title" data-animate="fade-up"><?php echo esc_html( $title ); ?></h2>
		<?php if ( $desc ) : ?>
			<p class="gt-section-heading__desc" data-animate="fade-up" data-animate-delay="100"><?php echo esc_html( $desc ); ?></p>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Fallback menu callback.
 */
function growtele_fallback_menu() {
	get_template_part( 'template-parts/header/fallback-menu' );
}

/**
 * Display posted-on date.
 */
function growtele_posted_on() {
	echo '<time class="entry-date published" datetime="' . esc_attr( get_the_date( DATE_W3C ) ) . '">' . esc_html( get_the_date() ) . '</time>';
}
