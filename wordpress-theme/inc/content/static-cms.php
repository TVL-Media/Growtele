<?php
/**
 * Apply Growtele CMS content to bundled static HTML pages.
 *
 * @package Growtele
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Product page slugs managed under products.* CMS keys.
 *
 * @return string[]
 */
function growtele_cms_product_slugs() {
	return growtele_channel_page_slugs();
}

/**
 * Industry page slugs under industries.* CMS keys.
 *
 * @return string[]
 */
function growtele_cms_industry_slugs() {
	return array(
		'retail',
		'health',
		'banking',
		'travelling',
		'ecommerce',
		'education',
		'logistic',
	);
}

/**
 * Company page slugs under company.* CMS keys.
 *
 * @return string[]
 */
function growtele_cms_company_slugs() {
	return array(
		'about-us',
		'blogs',
		'career',
		'contact',
		'growinfinity-io',
	);
}

/**
 * Map public page slug to company.* CMS key.
 *
 * @param string $slug Page slug.
 * @return string
 */
function growtele_cms_company_page_key( $slug ) {
	if ( 'growinfinity-io' === $slug ) {
		return 'growtele-io';
	}

	return $slug;
}

/**
 * Allowed HTML inside static page CMS fields.
 *
 * @return array
 */
function growtele_static_cms_kses() {
	return array(
		'br'     => array(),
		'span'   => array(
			'class' => true,
		),
		'strong' => array(),
	);
}

/**
 * Format CMS value for injection into static HTML.
 *
 * @param string $value  Raw value.
 * @param string $format html|text|url.
 * @return string
 */
function growtele_static_cms_format_value( $value, $format ) {
	if ( 'url' === $format ) {
		return esc_url( $value );
	}
	if ( 'html' === $format ) {
		return wp_kses( $value, growtele_static_cms_kses() );
	}
	return esc_html( $value );
}

/**
 * Replace <!-- gt-cms key="..." -->...<!-- /gt-cms --> regions.
 *
 * @param string $html HTML.
 * @return string
 */
function growtele_apply_cms_markers( $html ) {
	return preg_replace_callback(
		'/<!--\s*gt-cms\s+key="([a-z0-9._\-]+)"\s*-->(.*?)<!--\s*\/gt-cms\s*-->/is',
		function ( $matches ) {
			$key      = $matches[1];
			$fallback = $matches[2];
			$format   = ( false !== strpos( $key, '_url' ) || false !== strpos( $key, '.url' ) || false !== strpos( $key, '_href' ) ) ? 'url' : 'html';
			if ( false !== strpos( $key, '.plain.' ) ) {
				$format = 'text';
			}
			$value = growtele_get_content( $key, $fallback );
			if ( 'url' === $format && '' === $value ) {
				return $fallback;
			}
			return growtele_static_cms_format_value( (string) $value, $format );
		},
		$html
	);
}

/**
 * Resolve field format from CMS path.
 *
 * @param string $path Dot path.
 * @return string
 */
function growtele_product_cms_field_format( $path ) {
	if ( preg_match( '/\.(cta_url|button_url|hero_cta_url)$/', $path ) ) {
		return 'url';
	}
	if ( preg_match( '/\.(cta_text|button_text|pill_\d+)$/', $path ) ) {
		return 'text';
	}
	return 'html';
}

/**
 * Build needle list from product defaults tree.
 *
 * @param string $slug Product slug.
 * @return array<int, array{path:string, needle:string, format:string}>
 */
function growtele_product_cms_needles( $slug ) {
	$product = growtele_array_get( growtele_content_get_defaults(), 'products.' . $slug, array() );
	if ( ! is_array( $product ) || empty( $product ) ) {
		return array();
	}

	$needles   = array();
	$add_field = function ( $relative_path, $format ) use ( $slug, $product, &$needles ) {
		$value = growtele_array_get( $product, $relative_path, null );
		if ( ! is_string( $value ) || '' === $value ) {
			return;
		}
		$needles[] = array(
			'path'   => 'products.' . $slug . '.' . $relative_path,
			'needle' => $value,
			'format' => $format,
		);
	};

	$add_field( 'hero.title', 'html' );
	$add_field( 'hero.subtitle', 'html' );
	$add_field( 'hero.cta_text', 'text' );
	$add_field( 'journey.title', 'html' );
	$add_field( 'journey.lead', 'html' );
	$add_field( 'scale.title', 'html' );
	$add_field( 'scale.lead', 'html' );
	$add_field( 'benefits.title', 'html' );
	$add_field( 'benefits.lead', 'html' );
	$add_field( 'why.title', 'html' );
	$add_field( 'why.lead', 'html' );
	$add_field( 'funnel_heading.title', 'html' );
	$add_field( 'funnel_heading.lead', 'html' );
	$add_field( 'faq.title', 'html' );
	$add_field( 'faq.lead', 'html' );
	$add_field( 'cta.heading', 'html' );
	$add_field( 'cta.description', 'html' );
	$add_field( 'cta.button_text', 'text' );

	foreach ( $product['pills'] ?? array() as $i => $pill ) {
		if ( is_string( $pill ) && '' !== $pill ) {
			$needles[] = array(
				'path'   => 'products.' . $slug . '.pills.' . $i,
				'needle' => $pill,
				'format' => 'html',
			);
		}
	}

	foreach ( $product['faq']['items'] ?? array() as $i => $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}
		if ( ! empty( $item['question'] ) ) {
			$needles[] = array(
				'path'   => 'products.' . $slug . '.faq.items.' . $i . '.question',
				'needle' => $item['question'],
				'format' => 'html',
			);
		}
		// FAQ answers use gt-cms markers when duplicate text appears in HTML.
	}

	usort(
		$needles,
		function ( $a, $b ) {
			return strlen( $b['needle'] ) - strlen( $a['needle'] );
		}
	);

	return $needles;
}

/**
 * Build needle list for an industry static page.
 *
 * @param string $slug Industry slug.
 * @return array<int, array{path:string, needle:string, format:string}>
 */
function growtele_industry_cms_needles( $slug ) {
	$product = growtele_array_get( growtele_content_get_defaults(), 'industries.' . $slug, array() );
	if ( ! is_array( $product ) || empty( $product ) ) {
		return array();
	}

	$needles   = array();
	$add_field = function ( $relative_path, $format ) use ( $slug, $product, &$needles ) {
		$value = growtele_array_get( $product, $relative_path, null );
		if ( ! is_string( $value ) || '' === $value ) {
			return;
		}
		$needles[] = array(
			'path'   => 'industries.' . $slug . '.' . $relative_path,
			'needle' => $value,
			'format' => $format,
		);
	};

	$add_field( 'hero.title', 'html' );
	$add_field( 'hero.desc', 'html' );
	$add_field( 'hero.cta_primary', 'text' );
	$add_field( 'hero.cta_secondary', 'text' );
	$add_field( 'channels.title', 'html' );
	$add_field( 'channels.subtitle', 'html' );
	$add_field( 'growth.title', 'html' );
	$add_field( 'growth.subtitle', 'html' );
	$add_field( 'use_cases.title', 'html' );
	$add_field( 'faq.title', 'html' );
	$add_field( 'faq.intro', 'html' );
	$add_field( 'faq.book.title', 'text' );
	$add_field( 'faq.book.description', 'text' );
	$add_field( 'faq.book.button_text', 'text' );
	$add_field( 'cta.heading', 'html' );
	$add_field( 'cta.description', 'html' );
	$add_field( 'cta.button_text', 'text' );

	foreach ( $product['faq']['items'] ?? array() as $i => $item ) {
		if ( ! empty( $item['question'] ) ) {
			$needles[] = array(
				'path'   => 'industries.' . $slug . '.faq.items.' . $i . '.question',
				'needle' => $item['question'],
				'format' => 'text',
			);
		}
		if ( ! empty( $item['answer'] ) ) {
			$needles[] = array(
				'path'   => 'industries.' . $slug . '.faq.items.' . $i . '.answer',
				'needle' => $item['answer'],
				'format' => 'html',
			);
		}
	}

	usort(
		$needles,
		function ( $a, $b ) {
			return strlen( $b['needle'] ) - strlen( $a['needle'] );
		}
	);

	return $needles;
}

/**
 * Apply string needle replacements for an industry page.
 *
 * @param string $html HTML.
 * @param string $slug Industry slug.
 * @return string
 */
function growtele_apply_industry_needles( $html, $slug ) {
	foreach ( growtele_industry_cms_needles( $slug ) as $pair ) {
		$value = growtele_get_content( $pair['path'], $pair['needle'] );
		if ( (string) $value === (string) $pair['needle'] ) {
			continue;
		}
		$formatted = growtele_static_cms_format_value( (string) $value, $pair['format'] );
		$html      = str_replace( $pair['needle'], $formatted, $html );
	}
	return $html;
}

/**
 * Override industry hero primary CTA href when configured.
 *
 * @param string $html HTML.
 * @param string $slug Industry slug.
 * @return string
 */
function growtele_apply_industry_hero_cta_url( $html, $slug ) {
	$path = 'industries.' . $slug . '.hero.cta_primary_url';
	if ( ! growtele_content_is_overridden( $path ) ) {
		return $html;
	}
	$url = growtele_get_content( $path, '' );
	if ( '' === $url ) {
		$url = function_exists( 'growtele_get_page_url' ) ? growtele_get_page_url( 'contact' ) : home_url( '/' );
	}
	return preg_replace(
		'/(<div class="hero__actions">\s*<a\s+href=")[^"]+(" class="btn btn--primary">)/is',
		'$1' . esc_url( $url ) . '$2',
		$html,
		1
	);
}

/**
 * Apply bottom CTA button URL for industry pages.
 *
 * @param string $html HTML.
 * @param string $slug Industry slug.
 * @return string
 */
function growtele_apply_industry_footer_cta_url( $html, $slug ) {
	$path = 'industries.' . $slug . '.cta.button_url';
	if ( ! growtele_content_is_overridden( $path ) ) {
		return $html;
	}
	$url = growtele_get_content( $path, '' );
	if ( '' === $url ) {
		$url = function_exists( 'growtele_get_page_url' ) ? growtele_get_page_url( 'contact' ) : home_url( '/' );
	}
	return preg_replace(
		'/(<section class="gt-cta gt-section" id="cta">.*?<a\s+href=")[^"]+(" class="gt-btn gt-btn--navy">)/is',
		'$1' . esc_url( $url ) . '$2',
		$html,
		1
	);
}

/**
 * Apply string needle replacements for a product page.
 *
 * @param string $html HTML.
 * @param string $slug Product slug.
 * @return string
 */
function growtele_apply_product_needles( $html, $slug ) {
	foreach ( growtele_product_cms_needles( $slug ) as $pair ) {
		$value = growtele_get_content( $pair['path'], $pair['needle'] );
		if ( (string) $value === (string) $pair['needle'] ) {
			continue;
		}
		$formatted = growtele_static_cms_format_value( (string) $value, $pair['format'] );
		$html      = str_replace( $pair['needle'], $formatted, $html );
	}
	return $html;
}

/**
 * Override hero primary CTA href when configured in CMS.
 *
 * @param string $html HTML.
 * @param string $slug Product slug.
 * @return string
 */
function growtele_apply_product_hero_cta_url( $html, $slug ) {
	$path = 'products.' . $slug . '.hero.cta_url';
	if ( ! growtele_content_is_overridden( $path ) ) {
		return $html;
	}
	$url = growtele_get_content( $path, '' );
	if ( '' === $url ) {
		$url = function_exists( 'growtele_get_page_url' ) ? growtele_get_page_url( 'contact' ) : home_url( '/' );
	}
	return preg_replace(
		'/(<a\s+class="btn-cta btn-cta--hero"\s+href=")[^"]+(")/i',
		'$1' . esc_url( $url ) . '$2',
		$html,
		1
	);
}

/**
 * Apply bottom CTA button URL when configured per product.
 *
 * @param string $html HTML.
 * @param string $slug Product slug.
 * @return string
 */
function growtele_apply_product_footer_cta_url( $html, $slug ) {
	$path = 'products.' . $slug . '.cta.button_url';
	if ( ! growtele_content_is_overridden( $path ) ) {
		return $html;
	}
	$url = growtele_get_content( $path, '' );
	if ( '' === $url ) {
		$url = function_exists( 'growtele_get_page_url' ) ? growtele_get_page_url( 'contact' ) : home_url( '/' );
	}
	return preg_replace(
		'/(<section class="gt-cta gt-section" id="cta">.*?<a\s+href=")[^"]+(" class="gt-btn gt-btn--navy">)/is',
		'$1' . esc_url( $url ) . '$2',
		$html,
		1
	);
}

/**
 * Build needle list for a company static page.
 *
 * @param string $slug Company slug.
 * @return array<int, array{path:string, needle:string, format:string}>
 */
function growtele_company_cms_needles( $slug ) {
	$slug    = growtele_cms_company_page_key( $slug );
	$company = growtele_array_get( growtele_content_get_defaults(), 'company.' . $slug, array() );
	if ( ! is_array( $company ) || empty( $company ) ) {
		return array();
	}

	$needles   = array();
	$add_field = function ( $relative_path, $format ) use ( $slug, $company, &$needles ) {
		$value = growtele_array_get( $company, $relative_path, null );
		if ( ! is_string( $value ) || '' === $value ) {
			return;
		}
		$needles[] = array(
			'path'   => 'company.' . $slug . '.' . $relative_path,
			'needle' => $value,
			'format' => $format,
		);
	};

	$add_field( 'hero.badge', 'text' );
	$add_field( 'hero.title', 'html' );
	$add_field( 'hero.desc', 'html' );
	$add_field( 'hero.subtitle', 'html' );
	$add_field( 'hero.search_placeholder', 'text' );
	$add_field( 'hero.search_button', 'text' );
	$add_field( 'connecting.title', 'html' );
	$add_field( 'connecting.description', 'html' );
	$add_field( 'connecting.stat_1', 'text' );
	$add_field( 'connecting.stat_1_label', 'text' );
	$add_field( 'connecting.stat_2', 'text' );
	$add_field( 'connecting.stat_2_label', 'text' );
	$add_field( 'core_values.title', 'html' );
	$add_field( 'core_values.desc', 'html' );
	$add_field( 'driven.title', 'html' );
	$add_field( 'driven.subtitle', 'html' );
	$add_field( 'locations.title', 'html' );
	$add_field( 'locations.subtitle', 'html' );
	$add_field( 'locations.desc', 'html' );
	$add_field( 'locations.support', 'text' );
	$add_field( 'culture.title', 'html' );
	$add_field( 'culture.desc', 'html' );
	$add_field( 'values.title', 'html' );
	$add_field( 'values.desc', 'html' );
	$add_field( 'perks.title', 'html' );
	$add_field( 'jobs.title', 'html' );
	$add_field( 'jobs.desc', 'html' );
	$add_field( 'form.first_name', 'text' );
	$add_field( 'form.last_name', 'text' );
	$add_field( 'form.company', 'text' );
	$add_field( 'form.email', 'text' );
	$add_field( 'form.phone', 'text' );
	$add_field( 'form.query', 'text' );
	$add_field( 'form.submit', 'text' );
	$add_field( 'faq.title', 'html' );
	$add_field( 'faq.intro', 'html' );
	$add_field( 'cta.heading', 'html' );
	$add_field( 'cta.description', 'html' );
	$add_field( 'cta.button_text', 'text' );

	foreach ( $company['faq']['items'] ?? array() as $i => $item ) {
		if ( ! empty( $item['question'] ) ) {
			$needles[] = array(
				'path'   => 'company.' . $slug . '.faq.items.' . $i . '.question',
				'needle' => $item['question'],
				'format' => 'text',
			);
		}
		if ( ! empty( $item['answer'] ) ) {
			$needles[] = array(
				'path'   => 'company.' . $slug . '.faq.items.' . $i . '.answer',
				'needle' => $item['answer'],
				'format' => 'html',
			);
		}
	}

	usort(
		$needles,
		function ( $a, $b ) {
			return strlen( $b['needle'] ) - strlen( $a['needle'] );
		}
	);

	return $needles;
}

/**
 * Apply string needle replacements for a company page.
 *
 * @param string $html HTML.
 * @param string $slug Company slug.
 * @return string
 */
function growtele_apply_company_needles( $html, $slug ) {
	foreach ( growtele_company_cms_needles( $slug ) as $pair ) {
		$value = growtele_get_content( $pair['path'], $pair['needle'] );
		if ( (string) $value === (string) $pair['needle'] ) {
			continue;
		}
		$formatted = growtele_static_cms_format_value( (string) $value, $pair['format'] );
		$html      = str_replace( $pair['needle'], $formatted, $html );
	}
	return $html;
}

/**
 * Apply bottom CTA button URL for company pages.
 *
 * @param string $html HTML.
 * @param string $slug Company slug.
 * @return string
 */
function growtele_apply_company_footer_cta_url( $html, $slug ) {
	$path = 'company.' . growtele_cms_company_page_key( $slug ) . '.cta.button_url';
	if ( ! growtele_content_is_overridden( $path ) ) {
		return $html;
	}
	$url = growtele_get_content( $path, '' );
	if ( '' === $url ) {
		$url = function_exists( 'growtele_get_page_url' ) ? growtele_get_page_url( 'contact' ) : home_url( '/' );
	}
	return preg_replace(
		'/(<section class="gt-cta gt-section" id="cta">.*?<a\s+href=")[^"]+(" class="gt-btn gt-btn--navy">)/is',
		'$1' . esc_url( $url ) . '$2',
		$html,
		1
	);
}

/**
 * Resolve a JS media field to a URL string (attachment, explicit URL, or original fallback).
 *
 * @param mixed  $value    CMS value.
 * @param string $fallback Fallback URL or relative path.
 * @return string
 */
function growtele_cms_js_src( $value, $fallback ) {
	if ( is_array( $value ) ) {
		$id = absint( $value['attachment_id'] ?? 0 );
		if ( $id ) {
			$url = wp_get_attachment_url( $id );
			if ( $url ) {
				return $url;
			}
		}
		if ( ! empty( $value['url'] ) ) {
			return $value['url'];
		}
		if ( ! empty( $value['src'] ) ) {
			return $value['src'];
		}
	}
	if ( is_string( $value ) && '' !== $value ) {
		return $value;
	}
	return $fallback;
}

/**
 * Sparse office overrides for JS merge.
 *
 * @param string $page_key about-us|contact.
 * @return array
 */
function growtele_cms_office_overrides( $page_key ) {
	$defaults = growtele_array_get( growtele_content_get_defaults(), 'company.' . $page_key . '.offices', array() );
	if ( ! is_array( $defaults ) ) {
		return array();
	}

	$payload = array();
	foreach ( $defaults as $city => $office ) {
		$prefix = 'company.' . $page_key . '.offices.' . $city;
		$item   = array();
		foreach ( array( 'city', 'address', 'phone', 'email1', 'email2', 'iconAlt', 'mapAlt' ) as $field ) {
			if ( growtele_content_is_overridden( $prefix . '.' . $field ) ) {
				$item[ $field ] = growtele_get_content( $prefix . '.' . $field, $office[ $field ] ?? '' );
			}
		}
		foreach ( array( 'icon', 'map', 'image' ) as $media_key ) {
			if ( ! array_key_exists( $media_key, $office ) ) {
				continue;
			}
			if ( growtele_content_is_overridden( $prefix . '.' . $media_key ) ) {
				$item[ $media_key ] = growtele_cms_js_src(
					growtele_get_content( $prefix . '.' . $media_key, $office[ $media_key ] ),
					$office[ $media_key ]
				);
			}
		}
		if ( ! empty( $item ) ) {
			$payload[ $city ] = $item;
		}
	}

	return $payload;
}

/**
 * Sparse funnel image overrides.
 *
 * @param string $slug Product slug.
 * @return array
 */
function growtele_cms_funnel_overrides( $slug ) {
	$defaults = growtele_array_get( growtele_content_get_defaults(), 'products.' . $slug . '.funnel', array() );
	if ( ! is_array( $defaults ) ) {
		return array();
	}

	$payload = array();
	foreach ( $defaults as $key => $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}
		$prefix = 'products.' . $slug . '.funnel.' . $key;
		$row    = array();
		if ( growtele_content_is_overridden( $prefix . '.src' ) ) {
			$row['src'] = growtele_cms_js_src( growtele_get_content( $prefix . '.src', $item['src'] ?? '' ), $item['src'] ?? '' );
		}
		if ( growtele_content_is_overridden( $prefix . '.alt' ) ) {
			$row['alt'] = growtele_get_content( $prefix . '.alt', $item['alt'] ?? '' );
		}
		if ( ! empty( $row ) ) {
			$payload[ $key ] = $row;
		}
	}

	return $payload;
}

/**
 * Append a CSS custom property when a media path is overridden.
 *
 * @param string[] $css      CSS declarations.
 * @param string   $path     CMS media path.
 * @param string   $var      Custom property name.
 * @param string   $fallback Fallback URL.
 * @return void
 */
function growtele_cms_append_css_url( &$css, $path, $var, $fallback = '' ) {
	if ( ! growtele_content_is_overridden( $path ) ) {
		return;
	}
	$url = growtele_get_content_media_url( $path, $fallback );
	if ( $url ) {
		$css[] = $var . ': url("' . esc_url( $url ) . '")';
	}
}

/**
 * Apply shared header/footer CMS strings to static HTML (only when overridden).
 *
 * @param string $html HTML.
 * @return string
 */
function growtele_apply_shared_static_cms( $html ) {
	if ( growtele_content_is_overridden( 'global.header.cta_text' ) ) {
		$text = growtele_static_cms_format_value( (string) growtele_get_content( 'global.header.cta_text', "Let's Get Started" ), 'text' );
		$html = preg_replace(
			'/(<a\s[^>]*class="[^"]*(?:btn-cta--header|header__cta)[^"]*"[^>]*>\s*<span>)(.*?)(<\/span>)/is',
			'$1' . $text . '$3',
			$html,
			1
		);
	}

	if ( growtele_content_is_overridden( 'global.header.cta_url' ) && function_exists( 'growtele_get_header_cta_url' ) ) {
		$url = growtele_get_header_cta_url();
		$html = preg_replace(
			'/(<a\s[^>]*class="[^"]*(?:btn-cta--header|header__cta)[^"]*"\s+href=")[^"]+(")/is',
			'$1' . esc_url( $url ) . '$2',
			$html,
			1
		);
		$html = preg_replace(
			'/(<a\s+href=")[^"]+("\s+class="[^"]*(?:btn-cta--header|header__cta)[^"]*")/is',
			'$1' . esc_url( $url ) . '$2',
			$html,
			1
		);
	}

	$needles = array();
	$pairs   = array(
		'footer.brand_description' => array(
			'needle' => "Growtele's global network solutions enable every business sector to optimize their business across the globe.",
			'format' => 'text',
		),
		'footer.copyright'         => array(
			'needle' => 'Growtele © 2026. All rights reserved.',
			'format' => 'text',
		),
		'global.contact_email'     => array(
			'needle' => 'enquiry@growtele.com',
			'format' => 'text',
		),
	);

	foreach ( $pairs as $path => $meta ) {
		if ( ! growtele_content_is_overridden( $path ) ) {
			continue;
		}
		$value = growtele_get_content( $path, $meta['needle'] );
		if ( (string) $value === (string) $meta['needle'] ) {
			continue;
		}
		$needles[] = array(
			'needle' => $meta['needle'],
			'value'  => growtele_static_cms_format_value( (string) $value, $meta['format'] ),
		);
	}

	$legal = growtele_array_get( growtele_content_get_defaults(), 'footer.legal', array() );
	if ( is_array( $legal ) ) {
		foreach ( $legal as $i => $item ) {
			$path = 'footer.legal.' . $i . '.label';
			if ( ! growtele_content_is_overridden( $path ) || empty( $item['label'] ) || strlen( $item['label'] ) < 12 ) {
				continue;
			}
			$value = growtele_get_content( $path, $item['label'] );
			if ( (string) $value === (string) $item['label'] ) {
				continue;
			}
			$needles[] = array(
				'needle' => $item['label'],
				'value'  => growtele_static_cms_format_value( (string) $value, 'text' ),
			);
		}
	}

	$columns = growtele_array_get( growtele_content_get_defaults(), 'footer.columns', array() );
	if ( is_array( $columns ) ) {
		foreach ( $columns as $col_key => $col ) {
			$title_path = 'footer.columns.' . $col_key . '.title';
			if ( growtele_content_is_overridden( $title_path ) && ! empty( $col['title'] ) && strlen( $col['title'] ) >= 12 ) {
				$value = growtele_get_content( $title_path, $col['title'] );
				if ( (string) $value !== (string) $col['title'] ) {
					$needles[] = array(
						'needle' => $col['title'],
						'value'  => growtele_static_cms_format_value( (string) $value, 'text' ),
					);
				}
			}
			foreach ( $col['links'] ?? array() as $i => $link ) {
				$label_path = 'footer.columns.' . $col_key . '.links.' . $i . '.label';
				if ( ! growtele_content_is_overridden( $label_path ) || empty( $link['label'] ) || strlen( $link['label'] ) < 8 ) {
					continue;
				}
				$value = growtele_get_content( $label_path, $link['label'] );
				if ( (string) $value === (string) $link['label'] ) {
					continue;
				}
				$needles[] = array(
					'needle' => $link['label'],
					'value'  => growtele_static_cms_format_value( (string) $value, 'text' ),
				);
			}
		}
	}

	usort(
		$needles,
		function ( $a, $b ) {
			return strlen( $b['needle'] ) - strlen( $a['needle'] );
		}
	);

	foreach ( $needles as $pair ) {
		$html = str_replace( $pair['needle'], $pair['value'], $html );
	}

	$nav_mega = growtele_array_get( growtele_content_get_defaults(), 'global.nav.mega', array() );
	if ( is_array( $nav_mega ) ) {
		foreach ( $nav_mega as $mega_key => $item ) {
			foreach ( array( 'title', 'desc' ) as $field ) {
				$path = 'global.nav.mega.' . $mega_key . '.' . $field;
				if ( ! growtele_content_is_overridden( $path ) || empty( $item[ $field ] ) || strlen( $item[ $field ] ) < 12 ) {
					continue;
				}
				$value = growtele_get_content( $path, $item[ $field ] );
				if ( (string) $value !== (string) $item[ $field ] ) {
					$html = str_replace( $item[ $field ], growtele_static_cms_format_value( (string) $value, 'text' ), $html );
				}
			}
		}
	}
	foreach ( array( 'title', 'desc' ) as $field ) {
		$path = 'global.nav.feature.' . $field;
		$default = growtele_array_get( growtele_content_get_defaults(), $path, '' );
		if ( growtele_content_is_overridden( $path ) && $default ) {
			$value = growtele_get_content( $path, $default );
			if ( (string) $value !== (string) $default ) {
				$html = str_replace( $default, growtele_static_cms_format_value( (string) $value, 'text' ), $html );
			}
		}
	}

	if ( growtele_content_is_overridden( 'footer.copyright' ) ) {
		$copy = growtele_get_content( 'footer.copyright', 'Growtele © 2026. All rights reserved.' );
		$html = str_replace( 'Growtele &copy; 2026. All rights reserved.', esc_html( $copy ), $html );
	}

	$social = growtele_array_get( growtele_content_get_defaults(), 'footer.social', array() );
	if ( is_array( $social ) ) {
		foreach ( $social as $i => $item ) {
			$path = 'footer.social.' . $i . '.url';
			if ( ! growtele_content_is_overridden( $path ) || empty( $item['url'] ) ) {
				continue;
			}
			$new = growtele_get_content( $path, $item['url'] );
			if ( $new && $new !== $item['url'] ) {
				$html = str_replace( 'href="' . $item['url'] . '"', 'href="' . esc_url( $new ) . '"', $html );
			}
		}
	}

	return $html;
}

/**
 * Inject CMS runtime data + CSS variable overrides into static HTML.
 *
 * @param string $html HTML.
 * @param string $slug Page slug.
 * @return string
 */
function growtele_inject_cms_runtime( $html, $slug ) {
	$js  = array();
	$css = array();

	if ( 'contact' === $slug ) {
		$offices = growtele_cms_office_overrides( 'contact' );
		if ( ! empty( $offices ) ) {
			$js['GROWTELE_CMS_LOCATIONS'] = $offices;
		}
		$errors = array();
		foreach ( array( 'first_name', 'last_name', 'email', 'email_invalid', 'phone', 'phone_invalid', 'terms' ) as $key ) {
			$path = 'company.contact.form.errors.' . $key;
			if ( growtele_content_is_overridden( $path ) ) {
				$errors[ $key ] = growtele_get_content( $path, '' );
			}
		}
		if ( growtele_content_is_overridden( 'company.contact.form.submitted' ) ) {
			$js['GROWTELE_CMS_CONTACT_SUBMITTED'] = growtele_get_content( 'company.contact.form.submitted', 'Submitted!' );
		}
		if ( ! empty( $errors ) ) {
			$js['GROWTELE_CMS_CONTACT_ERRORS'] = $errors;
		}
	}

	if ( 'about-us' === $slug ) {
		$offices = growtele_cms_office_overrides( 'about-us' );
		if ( ! empty( $offices ) ) {
			$js['GROWTELE_CMS_LOCATIONS'] = $offices;
		}
	}

	if ( in_array( $slug, growtele_cms_product_slugs(), true ) ) {
		$funnel = growtele_cms_funnel_overrides( $slug );
		if ( ! empty( $funnel ) ) {
			$js['GROWTELE_CMS_FUNNEL'] = $funnel;
		}
		growtele_cms_append_css_url( $css, 'media.product_hero_bg', '--gt-cms-product-hero-bg', 'https://listings.selectvia.com/wp-content/uploads/2026/09/Group-593-1-3.png' );
		growtele_cms_append_css_url( $css, 'media.product_journey_card_bg', '--gt-cms-product-journey-card-bg' );
		growtele_cms_append_css_url( $css, 'media.product_benefits_bg', '--gt-cms-product-benefits-bg' );
		growtele_cms_append_css_url( $css, 'media.product_benefits_visual', '--gt-cms-product-benefits-visual' );
	}

	if ( 'email' === $slug ) {
		growtele_cms_append_css_url( $css, 'media.email_benefit_tab1', '--gt-cms-email-benefit-tab1', 'https://listings.selectvia.com/wp-content/uploads/2026/09/0f3cfb246890f57945e18c91cd2549bed1c668a8.png' );
		growtele_cms_append_css_url( $css, 'media.email_benefit_tab2', '--gt-cms-email-benefit-tab2', 'https://listings.selectvia.com/wp-content/uploads/2026/09/51163c4b0aa4a8c87cd9694b6d53a0bf882d1542.png' );
		growtele_cms_append_css_url( $css, 'media.email_benefit_tab3', '--gt-cms-email-benefit-tab3', 'https://listings.selectvia.com/wp-content/uploads/2026/09/6966a362d6c33885f37e97de1017648ffcd4d5a0.png' );
		growtele_cms_append_css_url( $css, 'media.email_benefit_tab4', '--gt-cms-email-benefit-tab4', 'https://listings.selectvia.com/wp-content/uploads/2026/09/46c9808fbb57c8a3c26c7e5b83f1e975a189c26d.png' );
	}

	if ( in_array( $slug, growtele_cms_industry_slugs(), true ) ) {
		growtele_cms_append_css_url( $css, 'media.industry_dark_bg', '--gt-cms-industry-dark-bg', 'https://listings.selectvia.com/wp-content/uploads/2026/09/bgo-1.png' );
		growtele_cms_append_css_url( $css, 'media.industry_box_bg', '--gt-cms-industry-box-bg' );
	}

	if ( 'about-us' === $slug ) {
		growtele_cms_append_css_url( $css, 'media.about_hero_bg', '--gt-cms-about-hero-bg', 'https://listings.selectvia.com/wp-content/uploads/2026/09/About-Us-BG.png' );
	}

	if ( in_array( $slug, array( 'growtele-io', 'growinfinity-io' ), true ) ) {
		growtele_cms_append_css_url( $css, 'media.io_value_prop_bg', '--gt-cms-io-value-prop-bg', 'https://listings.selectvia.com/wp-content/uploads/2026/09/bgo.png' );
		growtele_cms_append_css_url( $css, 'media.io_value_prop_card', '--gt-cms-io-value-prop-card', 'https://listings.selectvia.com/wp-content/uploads/2026/09/dsvd.png' );
		growtele_cms_append_css_url( $css, 'media.io_apis_visual', '--gt-cms-io-apis-visual', 'https://listings.selectvia.com/wp-content/uploads/2026/09/bqb.png' );
		growtele_cms_append_css_url( $css, 'media.io_navy_card', '--gt-cms-io-navy-card', 'https://listings.selectvia.com/wp-content/uploads/2026/09/Group-603.png' );
		growtele_cms_append_css_url( $css, 'media.io_cta_mid_bg', '--gt-cms-io-cta-mid-bg', 'https://listings.selectvia.com/wp-content/uploads/2026/09/bgo-1.png' );
		growtele_cms_append_css_url( $css, 'media.io_chart_card', '--gt-cms-io-chart-card', 'https://listings.selectvia.com/wp-content/uploads/2026/09/bqb-1.png' );
		growtele_cms_append_css_url( $css, 'media.io_reporting_bg', '--gt-cms-io-reporting-bg', 'https://listings.selectvia.com/wp-content/uploads/2026/09/DARKKK.png' );
	}

	growtele_cms_append_css_url( $css, 'media.footer_bg', '--gt-cms-footer-bg', 'https://listings.selectvia.com/wp-content/uploads/2026/09/Group-593-1-1.png' );

	$inject = '';
	if ( ! empty( $css ) ) {
		$inject .= '<style id="growtele-cms-media">:root{' . implode( ';', $css ) . ';}</style>';
	}
	if ( ! empty( $js ) ) {
		$inject .= '<script>';
		foreach ( $js as $name => $value ) {
			$inject .= 'window.' . $name . '=' . wp_json_encode( $value ) . ';';
		}
		$inject .= '</script>';
	}

	if ( '' === $inject ) {
		return $html;
	}

	if ( preg_match( '/<\/head>/i', $html ) ) {
		return preg_replace( '/<\/head>/i', $inject . '</head>', $html, 1 );
	}

	return $inject . $html;
}

/**
 * Apply CMS to a static HTML document.
 *
 * @param string $html Page HTML.
 * @param string $slug Page slug.
 * @return string
 */
function growtele_apply_static_page_cms( $html, $slug ) {
	$html = growtele_apply_cms_markers( $html );
	$html = growtele_apply_shared_static_cms( $html );

	if ( in_array( $slug, growtele_cms_product_slugs(), true ) ) {
		$html = growtele_apply_product_needles( $html, $slug );
		$html = growtele_apply_product_hero_cta_url( $html, $slug );
		$html = growtele_apply_product_footer_cta_url( $html, $slug );
	}

	if ( in_array( $slug, growtele_cms_industry_slugs(), true ) ) {
		$html = growtele_apply_industry_needles( $html, $slug );
		$html = growtele_apply_industry_hero_cta_url( $html, $slug );
		$html = growtele_apply_industry_footer_cta_url( $html, $slug );
	}

	if ( in_array( $slug, growtele_cms_company_slugs(), true ) ) {
		$html = growtele_apply_company_needles( $html, $slug );
		$html = growtele_apply_company_footer_cta_url( $html, $slug );
	}

	$html = growtele_inject_cms_runtime( $html, $slug );

	return $html;
}
