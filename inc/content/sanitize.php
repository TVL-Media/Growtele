<?php
/**
 * Sanitize Growtele CMS submissions.
 *
 * @package Growtele
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Recursively sanitize content tree before save.
 *
 * @param mixed $value Raw value.
 * @return mixed
 */
function growtele_content_sanitize_value( $value ) {
	if ( is_array( $value ) ) {
		if ( growtele_content_is_list_array( $value ) ) {
			return array_map( 'growtele_content_sanitize_value', $value );
		}

		$sanitized = array();
		foreach ( $value as $key => $child ) {
			$safe_key = is_string( $key ) ? preg_replace( '/[^a-z0-9_\-]/i', '', $key ) : $key;
			if ( 'attachment_id' === $safe_key ) {
				$sanitized[ $safe_key ] = absint( $child );
				continue;
			}
			$sanitized[ $safe_key ] = growtele_content_sanitize_value( $child );
		}
		return $sanitized;
	}

	if ( is_numeric( $value ) ) {
		return $value;
	}

	if ( is_string( $value ) ) {
		if ( filter_var( $value, FILTER_VALIDATE_EMAIL ) ) {
			return sanitize_email( $value );
		}
		if ( preg_match( '#^https?://#i', $value ) || 0 === strpos( $value, '#' ) || 0 === strpos( $value, '/' ) ) {
			return esc_url_raw( $value );
		}
		if ( false !== strpos( $value, '<' ) ) {
			return wp_kses( $value, array( 'br' => array() ) );
		}
		return sanitize_text_field( wp_unslash( $value ) );
	}

	return $value;
}

/**
 * Sanitize full submitted content and return sparse overrides.
 *
 * @param array $input Raw POST tree.
 * @return array
 */
function growtele_content_sanitize_and_diff( $input ) {
	if ( ! is_array( $input ) ) {
		return array();
	}

	unset( $input['schema_version'] );

	$defaults  = growtele_content_get_defaults();
	$sanitized = growtele_content_sanitize_value( $input );

	$overrides = array();
	foreach ( array( 'global', 'footer', 'shared', 'home', 'products', 'industries', 'company', 'media' ) as $root ) {
		if ( ! isset( $sanitized[ $root ] ) || ! isset( $defaults[ $root ] ) ) {
			continue;
		}
		$diff = growtele_content_diff_overrides( $sanitized[ $root ], $defaults[ $root ] );
		if ( ! empty( $diff ) ) {
			$overrides[ $root ] = $diff;
		}
	}

	if ( ! empty( $overrides ) ) {
		$overrides['schema_version'] = GROWTELE_CONTENT_SCHEMA_VERSION;
	}

	return $overrides;
}

/**
 * Persist CMS content from admin POST (merges by root section so tabs do not wipe each other).
 *
 * @param array $input Raw POST `growtele_content` tree.
 * @return void
 */
function growtele_content_save_from_post( $input ) {
	if ( ! is_array( $input ) ) {
		return;
	}

	unset( $input['schema_version'] );

	$defaults = growtele_content_get_defaults();
	$existing = growtele_content_get_overrides();
	unset( $existing['schema_version'] );

	$sanitized = growtele_content_sanitize_value( $input );

	foreach ( array( 'global', 'footer', 'shared', 'home', 'products', 'industries', 'company', 'media' ) as $root ) {
		if ( ! array_key_exists( $root, $sanitized ) || ! isset( $defaults[ $root ] ) ) {
			continue;
		}

		$incoming_root = $sanitized[ $root ];
		if ( in_array( $root, array( 'home', 'products', 'industries', 'company', 'media' ), true ) && is_array( $incoming_root ) ) {
			$existing_branch = isset( $existing[ $root ] ) && is_array( $existing[ $root ] ) ? $existing[ $root ] : array();
			$incoming_root   = array_replace_recursive( $defaults[ $root ], $existing_branch, $incoming_root );
		}

		$diff = growtele_content_diff_overrides( $incoming_root, $defaults[ $root ] );
		if ( empty( $diff ) ) {
			unset( $existing[ $root ] );
		} else {
			$existing[ $root ] = $diff;
		}
	}

	if ( empty( $existing ) ) {
		delete_option( GROWTELE_CONTENT_OPTION );
	} else {
		$existing['schema_version'] = GROWTELE_CONTENT_SCHEMA_VERSION;
		update_option( GROWTELE_CONTENT_OPTION, $existing, false );
	}

	if ( function_exists( 'growtele_content_flush_cache' ) ) {
		growtele_content_flush_cache();
	}
}
