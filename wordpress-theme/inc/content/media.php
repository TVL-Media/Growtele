<?php
/**
 * Growtele media helpers (attachment ID + theme asset fallback).
 *
 * @package Growtele
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Resolve a media field array to a public URL.
 *
 * @param array|string|null $field        Media field or path string.
 * @param string            $fallback_path Theme assets/images path when no attachment.
 * @return string
 */
function growtele_cms_fallback_url( $fallback ) {
	if ( ! $fallback ) {
		return '';
	}
	if ( preg_match( '#^https?://#i', $fallback ) || 0 === strpos( $fallback, '//' ) ) {
		return $fallback;
	}
	if ( function_exists( 'growtele_get_image' ) ) {
		return growtele_get_image( $fallback );
	}
	return $fallback;
}

function growtele_get_media_url( $field, $fallback_path = '' ) {
	if ( is_string( $field ) && '' !== $field ) {
		if ( preg_match( '#^https?://#i', $field ) ) {
			return esc_url_raw( $field );
		}
		return $field;
	}

	if ( ! is_array( $field ) ) {
		return growtele_cms_fallback_url( $fallback_path );
	}

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

	$fallback = ! empty( $field['fallback'] ) ? $field['fallback'] : $fallback_path;
	return growtele_cms_fallback_url( $fallback );
}

/**
 * Get media field from CMS path.
 *
 * @param string $path           Dot path to media array in defaults/overrides.
 * @param string $fallback_path  Theme image path.
 * @return string URL.
 */
function growtele_get_content_media_url( $path, $fallback_path = '' ) {
	$default_field = growtele_array_get( growtele_content_get_defaults(), $path, array() );
	$field         = growtele_get_content( $path, $default_field );
	if ( ! is_array( $field ) ) {
		$field = array(
			'attachment_id' => 0,
			'url'           => '',
			'fallback'      => $fallback_path,
		);
	} elseif ( is_array( $default_field ) ) {
		$field = array_replace_recursive( $default_field, $field );
	}
	return growtele_get_media_url( $field, $fallback_path );
}
