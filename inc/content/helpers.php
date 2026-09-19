<?php
/**
 * Growtele content helpers.
 *
 * @package Growtele
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get a value from a nested array by dot path.
 *
 * @param array       $array   Source array.
 * @param string      $path    Dot-separated path.
 * @param mixed|null  $default Default if missing.
 * @return mixed
 */
function growtele_array_get( $array, $path, $default = null ) {
	if ( ! is_array( $array ) || '' === $path ) {
		return $default;
	}

	$keys  = explode( '.', $path );
	$value = $array;

	foreach ( $keys as $key ) {
		if ( ! is_array( $value ) || ! array_key_exists( $key, $value ) ) {
			return $default;
		}
		$value = $value[ $key ];
	}

	return $value;
}

/**
 * Set a value in a nested array by dot path (by reference).
 *
 * @param array  $array Reference to array.
 * @param string $path  Dot path.
 * @param mixed  $value Value to set.
 */
function growtele_array_set( &$array, $path, $value ) {
	$keys = explode( '.', $path );
	$ref  = &$array;

	foreach ( $keys as $i => $key ) {
		if ( $i === count( $keys ) - 1 ) {
			$ref[ $key ] = $value;
			return;
		}
		if ( ! isset( $ref[ $key ] ) || ! is_array( $ref[ $key ] ) ) {
			$ref[ $key ] = array();
		}
		$ref = &$ref[ $key ];
	}
}

/**
 * Clear in-request caches after save/reset.
 */
function growtele_content_flush_cache() {
	// Static vars live in get_overrides/get_merged/get_defaults — reset via reflection-free re-entry.
	global $growtele_content_cache_generation;
	$growtele_content_cache_generation = isset( $growtele_content_cache_generation ) ? $growtele_content_cache_generation + 1 : 1;
}

/**
 * Saved overrides only (sparse), from wp_options.
 *
 * @return array
 */
function growtele_content_get_overrides() {
	static $overrides = null;
	static $cache_gen  = -1;

	global $growtele_content_cache_generation;
	$gen = $growtele_content_cache_generation ?? 0;

	if ( null !== $overrides && $cache_gen === $gen ) {
		return $overrides;
	}

	$stored = get_option( GROWTELE_CONTENT_OPTION, array() );
	if ( ! is_array( $stored ) ) {
		$stored = array();
	}

	unset( $stored['schema_version'] );

	$overrides = $stored;
	$cache_gen   = $gen;

	return $overrides;
}

/**
 * Merged defaults + overrides for admin display.
 *
 * @return array
 */
function growtele_content_get_merged() {
	static $merged = null;
	static $cache_gen = -1;

	global $growtele_content_cache_generation;
	$gen = $growtele_content_cache_generation ?? 0;

	if ( null !== $merged && $cache_gen === $gen ) {
		return $merged;
	}

	$merged = array_replace_recursive(
		growtele_content_get_defaults(),
		growtele_content_get_overrides()
	);
	$cache_gen = $gen;

	return $merged;
}

/**
 * Whether a dot path exists in saved overrides.
 *
 * @param string $path Dot path.
 * @return bool
 */
function growtele_content_is_overridden( $path ) {
	$overrides = growtele_content_get_overrides();
	return null !== growtele_array_get( $overrides, $path, null );
}

/**
 * Get CMS content with fallback to defaults and optional literal fallback.
 *
 * Empty strings in overrides are treated as “use default”.
 *
 * @param string     $path     Dot path (e.g. global.header.cta_text).
 * @param mixed|null $fallback Optional final fallback.
 * @return mixed
 */
function growtele_get_content( $path, $fallback = null ) {
	$defaults  = growtele_content_get_defaults();
	$overrides = growtele_content_get_overrides();

	if ( growtele_content_is_overridden( $path ) ) {
		$value = growtele_array_get( $overrides, $path, null );
		if ( null !== $value && '' !== $value ) {
			return $value;
		}
	}

	$value = growtele_array_get( $defaults, $path, null );
	if ( null !== $value && '' !== $value ) {
		return $value;
	}

	return $fallback;
}

/**
 * Legacy Customizer value when CMS has no override for this path.
 *
 * @param string $path           CMS path.
 * @param string $theme_mod_key  Theme mod key.
 * @param mixed  $sanitize       Callable sanitize callback name or null.
 * @return mixed
 */
function growtele_get_content_with_theme_mod( $path, $theme_mod_key, $default = '' ) {
	if ( growtele_content_is_overridden( $path ) ) {
		return growtele_get_content( $path, $default );
	}

	$mod = get_theme_mod( $theme_mod_key, null );
	if ( null !== $mod && '' !== $mod ) {
		return $mod;
	}

	return growtele_get_content( $path, $default );
}

/**
 * Map common footer/nav labels to Growtele page slugs when CMS drops the slug field.
 *
 * @return array<string, string>
 */
function growtele_content_link_label_slugs() {
	return array(
		'Privacy Policy'        => 'privacy-policy',
		'Terms & Condition'     => 'terms-and-condition',
		'Terms and Condition'   => 'terms-and-condition',
		'Security'              => 'security',
		'Partners Term of Use'  => 'partners-term-of-use',
		'API Documentation'     => 'api-documentation',
		'Pricing'               => 'pricing',
	);
}

/**
 * Resolve footer / nav link URL from slug or explicit URL.
 *
 * @param array $link Link item with url and/or slug keys.
 * @return string
 */
function growtele_content_resolve_page_url( $link ) {
	if ( ! is_array( $link ) ) {
		return '#';
	}

	$slug  = ! empty( $link['slug'] ) ? (string) $link['slug'] : '';
	$label = ! empty( $link['label'] ) ? trim( (string) $link['label'] ) : '';

	if ( '' === $slug && '' !== $label ) {
		$label_slugs = growtele_content_link_label_slugs();
		if ( isset( $label_slugs[ $label ] ) ) {
			$slug = $label_slugs[ $label ];
		}
	}

	$stored = ! empty( $link['url'] ) ? trim( (string) $link['url'] ) : '';

	if ( preg_match( '#page_id=\d+#i', $stored ) && $slug && function_exists( 'growtele_get_page_url' ) ) {
		return growtele_get_page_url( $slug );
	}

	if ( $slug && function_exists( 'growtele_get_page_url' ) ) {
		$slug_url = growtele_get_page_url( $slug );

		if ( '' !== $stored ) {
			if ( preg_match( '#page_id=(\d+)#i', $stored, $matches ) ) {
				$post  = get_post( (int) $matches[1] );
				$valid = $post instanceof WP_Post
					&& 'page' === $post->post_type
					&& 'publish' === $post->post_status
					&& $post->post_name === $slug;

				if ( ! $valid ) {
					return $slug_url;
				}
			}

			if ( preg_match( '#^[?&]page_id=\d+#i', ltrim( $stored, '/' ) ) ) {
				return $slug_url;
			}

			return $stored;
		}

		return $slug_url;
	}

	if ( '' !== $stored ) {
		return $stored;
	}

	return '#';
}

/**
 * Resolve header CTA URL.
 *
 * @return string
 */
function growtele_get_header_cta_url() {
	$url = growtele_get_content_with_theme_mod( 'global.header.cta_url', 'growtele_cta_url', '' );
	if ( '' === $url && function_exists( 'growtele_get_page_url' ) ) {
		return growtele_get_page_url( 'contact' );
	}
	return $url ? $url : ( function_exists( 'growtele_get_page_url' ) ? growtele_get_page_url( 'contact' ) : home_url( '/' ) );
}

/**
 * Resolve shared CTA button URL.
 *
 * @return string
 */
function growtele_get_shared_cta_url() {
	$url = growtele_get_content_with_theme_mod( 'shared.cta.button_url', 'growtele_cta_url', '' );
	if ( '' === $url && function_exists( 'growtele_get_page_url' ) ) {
		return growtele_get_page_url( 'contact' );
	}
	return $url ? $url : ( function_exists( 'growtele_get_page_url' ) ? growtele_get_page_url( 'contact' ) : home_url( '/' ) );
}

/**
 * Contact email: CMS → Customizer → default.
 *
 * @return string
 */
function growtele_get_contact_email() {
	return growtele_get_content_with_theme_mod( 'global.contact_email', 'growtele_contact_email', 'enquiry@growtele.com' );
}

/**
 * Container width: CMS → Customizer → default.
 *
 * @return int
 */
function growtele_get_container_width() {
	if ( growtele_content_is_overridden( 'global.container_width' ) ) {
		return absint( growtele_get_content( 'global.container_width', 1480 ) );
	}
	return absint( get_theme_mod( 'growtele_container_width', growtele_get_content( 'global.container_width', 1480 ) ) );
}

/**
 * Compute sparse overrides to store (diff from defaults).
 *
 * @param array $input    Submitted tree.
 * @param array $defaults Defaults tree.
 * @return array
 */
function growtele_content_diff_overrides( $input, $defaults ) {
	$overrides = array();

	foreach ( $defaults as $key => $default_value ) {
		if ( ! array_key_exists( $key, $input ) ) {
			continue;
		}

		$input_value = $input[ $key ];

		if ( is_array( $default_value ) && growtele_content_is_list_array( $default_value ) ) {
			if ( wp_json_encode( $input_value ) !== wp_json_encode( $default_value ) ) {
				$overrides[ $key ] = $input_value;
			}
			continue;
		}

		if ( is_array( $default_value ) && is_array( $input_value ) ) {
			$child = growtele_content_diff_overrides( $input_value, $default_value );
			if ( ! empty( $child ) ) {
				$overrides[ $key ] = $child;
			}
			continue;
		}

		if ( (string) $input_value !== (string) $default_value ) {
			$overrides[ $key ] = $input_value;
		}
	}

	return $overrides;
}

/**
 * Whether array is a list (sequential numeric keys).
 *
 * @param array $array Array.
 * @return bool
 */
function growtele_content_is_list_array( $array ) {
	if ( ! is_array( $array ) || array() === $array ) {
		return false;
	}
	return array_keys( $array ) === range( 0, count( $array ) - 1 );
}

/**
 * Reset all CMS overrides.
 *
 * @return bool
 */
function growtele_content_reset_to_defaults() {
	$deleted = delete_option( GROWTELE_CONTENT_OPTION );
	growtele_content_flush_cache();
	return $deleted;
}

/**
 * Footer social SVG icons (not editable; URLs are CMS fields).
 *
 * @return array<string, string>
 */
function growtele_footer_social_icons() {
	$base = 'https://listings.selectvia.com/wp-content/uploads/2026/09/';
	$img  = static function ( $file ) use ( $base ) {
		return sprintf(
			'<img src="%s" alt="" width="20" height="20" loading="lazy" decoding="async">',
			esc_url( $base . $file )
		);
	};

	return array(
		'Facebook'  => $img( 'fb.png' ),
		'X'         => $img( 'x.png' ),
		'Instagram' => $img( 'ins.png' ),
		'YouTube'   => $img( 'yt.png' ),
		'LinkedIn'  => $img( 'ld.png' ),
	);
}
