<?php
/**
 * Home page CMS merge helpers.
 *
 * @package Growtele
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Merged home section (defaults + sparse overrides).
 *
 * @param string $section Section key under home.*
 * @return array
 */
function growtele_home_get_section( $section ) {
	$defaults = growtele_content_get_defaults();
	$base     = is_array( $defaults['home'][ $section ] ?? null ) ? $defaults['home'][ $section ] : array();
	$override = growtele_array_get( growtele_content_get_overrides(), 'home.' . $section, array() );

	if ( ! is_array( $override ) ) {
		$override = array();
	}

	return array_replace_recursive( $base, $override );
}

/**
 * Resolve video URL from CMS field or CDN/theme fallback key.
 *
 * @param string $path             Dot path to video field array.
 * @param string $fallback_cdn_key Key for growtele_get_cdn_video().
 * @return string
 */
function growtele_get_content_video_url( $path, $fallback_cdn_key = '' ) {
	$default_field = growtele_array_get( growtele_content_get_defaults(), $path, array() );
	$field         = growtele_get_content( $path, $default_field );
	if ( ! is_array( $field ) ) {
		$field = array();
	} elseif ( is_array( $default_field ) ) {
		$field = array_replace_recursive( $default_field, $field );
	}

	$cdn_key = ! empty( $field['fallback_key'] ) ? $field['fallback_key'] : $fallback_cdn_key;

	$attachment_id = absint( $field['attachment_id'] ?? 0 );
	if ( $attachment_id ) {
		$url = wp_get_attachment_url( $attachment_id );
		if ( $url ) {
			return $url;
		}
	}

	if ( ! empty( $field['url'] ) ) {
		return esc_url_raw( $field['url'] );
	}

	if ( $cdn_key && function_exists( 'growtele_get_cdn_video' ) ) {
		return growtele_get_cdn_video( $cdn_key );
	}

	return '';
}

/**
 * Output section heading markup (same as growtele_section_heading).
 *
 * @param string $title Title (may contain br).
 * @param string $desc  Description.
 * @param string $class Modifier class.
 */
function growtele_home_section_heading( $title, $desc = '', $class = '' ) {
	if ( function_exists( 'growtele_section_heading' ) ) {
		growtele_section_heading( $title, $desc, $class );
		return;
	}
	?>
	<div class="gt-section-heading<?php echo $class ? ' ' . esc_attr( $class ) : ''; ?>">
		<h2 class="gt-section-heading__title"><?php echo wp_kses( $title, array( 'br' => array() ) ); ?></h2>
		<?php if ( $desc ) : ?>
			<p class="gt-section-heading__desc"><?php echo wp_kses( $desc, array( 'br' => array() ) ); ?></p>
		<?php endif; ?>
	</div>
	<?php
}
