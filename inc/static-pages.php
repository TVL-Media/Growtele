<?php
/**
 * Static HTML page loader for channel/industry pages.
 *
 * @package Growtele
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Channel pages that share the scaled layout + gt-footer.
 *
 * @return string[]
 */
function growtele_channel_page_slugs() {
	return array( 'sms', 'whatsapp', 'email', 'rcs', 'cloud-telephony' );
}

/**
 * Registered static pages: slug => source folder name under /pages/.
 *
 * @return array<string, string>
 */
function growtele_static_page_map() {
	return array(
		'sms'               => 'sms',
		'whatsapp'          => 'whatsapp',
		'email'             => 'email',
		'rcs'               => 'rcs',
		'cloud-telephony'   => 'cloud-telephony',
		'retail'            => 'retail',
		'health'            => 'health',
		'banking'           => 'banking',
		'travelling'        => 'travelling',
	);
}

/**
 * Get permalink for a Growtele static page by slug.
 *
 * @param string $slug Page slug.
 * @return string
 */
function growtele_get_page_url( $slug ) {
	$page = get_page_by_path( $slug );

	if ( $page instanceof WP_Post ) {
		return get_permalink( $page );
	}

	return home_url( '/' . $slug . '/' );
}

/**
 * Replace legacy relative paths from static HTML exports.
 *
 * @param string $html HTML content.
 * @return string
 */
function growtele_filter_static_html( $html ) {
	$map = array(
		'../index.html'                               => home_url( '/' ),
		'../../assets/'                               => trailingslashit( GROWTELE_URI ) . 'assets/',
		'../assets/'                                  => trailingslashit( GROWTELE_URI ) . 'assets/',
		'../sms/index.html'                           => growtele_get_page_url( 'sms' ),
		'../whatsapp/index.html'                      => growtele_get_page_url( 'whatsapp' ),
		'../email/index.html'                         => growtele_get_page_url( 'email' ),
		'../rcs/index.html'                           => growtele_get_page_url( 'rcs' ),
		'../cloud-telephony/index.html'               => growtele_get_page_url( 'cloud-telephony' ),
		'../retail/index.html'                        => growtele_get_page_url( 'retail' ),
		'../health/index.html'                        => growtele_get_page_url( 'health' ),
		'../banking/index.html'                       => growtele_get_page_url( 'banking' ),
		'../travelling/index.html'                    => growtele_get_page_url( 'travelling' ),
		'../sms/css/sms-nav.css'                      => trailingslashit( GROWTELE_URI ) . 'pages/sms/css/sms-nav.css',
		'../SMS Grwtl/index.html'                     => growtele_get_page_url( 'sms' ),
		'../SMS Grwtl/css/sms-nav.css'                => trailingslashit( GROWTELE_URI ) . 'pages/sms/css/sms-nav.css',
		'../pages/sms/css/sms-nav.css'                => trailingslashit( GROWTELE_URI ) . 'pages/sms/css/sms-nav.css',
		'SMS Grwtl/index.html'                        => growtele_get_page_url( 'sms' ),
		'SMS Grwtl/css/sms-nav.css'                   => trailingslashit( GROWTELE_URI ) . 'pages/sms/css/sms-nav.css',
		'../whatsapp grwtl/index.html'                => growtele_get_page_url( 'whatsapp' ),
		'whatsapp grwtl/index.html'                   => growtele_get_page_url( 'whatsapp' ),
		'../email grwtl/index.html'                   => growtele_get_page_url( 'email' ),
		'email grwtl/index.html'                      => growtele_get_page_url( 'email' ),
		'../rcs grwtl/index.html'                     => growtele_get_page_url( 'rcs' ),
		'rcs grwtl/index.html'                        => growtele_get_page_url( 'rcs' ),
		'../cloud telephony grwtl/index.html'         => growtele_get_page_url( 'cloud-telephony' ),
		'cloud telephony grwtl/index.html'            => growtele_get_page_url( 'cloud-telephony' ),
		'../Retail grwtl/index.html'                  => growtele_get_page_url( 'retail' ),
		'Retail grwtl/index.html'                     => growtele_get_page_url( 'retail' ),
		'../Health grwtl/index.html'                  => growtele_get_page_url( 'health' ),
		'Health grwtl/index.html'                     => growtele_get_page_url( 'health' ),
		'../banking grwtl/index.html'                 => growtele_get_page_url( 'banking' ),
		'banking grwtl/index.html'                    => growtele_get_page_url( 'banking' ),
		'../Banking grwtl/index.html'                 => growtele_get_page_url( 'banking' ),
		'Banking grwtl/index.html'                    => growtele_get_page_url( 'banking' ),
		'../travelling grwtl/index.html'              => growtele_get_page_url( 'travelling' ),
		'travelling grwtl/index.html'                 => growtele_get_page_url( 'travelling' ),
		'../Travelling grwtl/index.html'              => growtele_get_page_url( 'travelling' ),
		'Travelling grwtl/index.html'                 => growtele_get_page_url( 'travelling' ),
	);

	return str_replace( array_keys( $map ), array_values( $map ), $html );
}

/**
 * Percent-encode spaces and special chars in relative asset URLs.
 *
 * @param string $html HTML content.
 * @return string
 */
function growtele_encode_static_asset_urls( $html ) {
	return preg_replace_callback(
		'/\b((?:src|href|data-[a-z0-9-]+)=["\'])([^"\']+)(["\'])/i',
		static function ( $matches ) {
			$url = $matches[2];

			if ( preg_match( '/\bdata-counter/i', $matches[1] ) ) {
				return $matches[0];
			}

			if ( preg_match( '#^(?:https?:)?//#', $url ) || 0 === strpos( $url, 'data:' ) || 0 === strpos( $url, '#' ) ) {
				return $matches[0];
			}

			$path     = $url;
			$suffix   = '';
			$hash_pos = strpos( $path, '#' );
			if ( false !== $hash_pos ) {
				$suffix = substr( $path, $hash_pos );
				$path   = substr( $path, 0, $hash_pos );
			}
			$query_pos = strpos( $path, '?' );
			if ( false !== $query_pos ) {
				$suffix = substr( $path, $query_pos ) . $suffix;
				$path   = substr( $path, 0, $query_pos );
			}

			$parts = explode( '/', $path );
			$parts = array_map(
				static function ( $part ) {
					return rawurlencode( rawurldecode( $part ) );
				},
				$parts
			);

			return $matches[1] . implode( '/', $parts ) . $suffix . $matches[3];
		},
		$html
	);
}

/**
 * Inject shared theme CSS + footer layout fix for scaled channel pages.
 *
 * @param string $html HTML content.
 * @return string
 */
/**
 * Convert page-local relative asset URLs to absolute theme URLs for WordPress.
 *
 * @param string $html HTML content.
 * @param string $slug Page slug.
 * @return string
 */
function growtele_absolutize_static_assets( $html, $slug ) {
	$pages = growtele_static_page_map();

	if ( ! isset( $pages[ $slug ] ) ) {
		return $html;
	}

	$base    = trailingslashit( GROWTELE_URI ) . 'pages/' . $pages[ $slug ] . '/';
	$version = GROWTELE_VERSION;

	return preg_replace_callback(
		'/\b(href|src)=(["\'])([^"\']+)\2/i',
		static function ( $matches ) use ( $base, $version ) {
			$url = $matches[3];

			if ( preg_match( '#^(?:https?:)?//#', $url ) || 0 === strpos( $url, 'data:' ) || 0 === strpos( $url, 'mailto:' ) || 0 === strpos( $url, '#' ) ) {
				return $matches[0];
			}

			if ( 0 === strpos( $url, '/' ) || 0 === strpos( $url, GROWTELE_URI ) ) {
				return $matches[0];
			}

			if ( 0 === strpos( $url, '../' ) ) {
				return $matches[0];
			}

			$absolute = $base . ltrim( $url, './' );

			if ( preg_match( '/\.(css|js)(?:\?|$)/i', $url ) && false === stripos( $url, 'v=' ) ) {
				$absolute .= ( false === strpos( $absolute, '?' ) ? '?' : '&' ) . 'v=' . rawurlencode( $version );
			}

			return $matches[1] . '=' . $matches[2] . esc_url( $absolute ) . $matches[2];
		},
		$html
	);
}

/**
 * Ensure Lenis smooth scroll assets + body class exist on static pages.
 *
 * @param string $html HTML content.
 * @return string
 */
function growtele_prepare_static_page_smooth_scroll( $html ) {
	$version     = GROWTELE_VERSION;
	$uri         = GROWTELE_URI;
	$inject_head = '';
	$inject_body = '';

	if ( false === stripos( $html, 'lenis.css' ) ) {
		$inject_head .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lenis@1.1.18/dist/lenis.css">';
	}

	if ( false === stripos( $html, 'lenis.min.js' ) ) {
		$inject_body .= '<script src="https://cdn.jsdelivr.net/npm/lenis@1.1.18/dist/lenis.min.js"></script>';
	}

	if ( false === stripos( $html, 'smooth-scroll.js' ) ) {
		$inject_body .= '<script src="' . esc_url( $uri . '/assets/js/smooth-scroll.js?v=' . $version ) . '"></script>';
	}

	if ( $inject_head ) {
		$html = preg_replace( '/<\/head>/i', $inject_head . '</head>', $html, 1 );
	}

	if ( $inject_body ) {
		if ( preg_match( '/<script[^>]+sms-nav-dropdowns\.js[^>]*><\/script>/i', $html ) ) {
			$html = preg_replace( '/(<script[^>]+sms-nav-dropdowns\.js[^>]*><\/script>)/i', $inject_body . '$1', $html, 1 );
		} else {
			$html = preg_replace( '/<\/body>/i', $inject_body . '</body>', $html, 1 );
		}
	}

	if ( false === stripos( $html, 'gt-smooth-scroll' ) ) {
		if ( preg_match( '/<body\s+class=(["\'])([^"\']*)\1/i', $html ) ) {
			$html = preg_replace( '/<body\s+class=(["\'])([^"\']*)\1/i', '<body class=$1$2 gt-smooth-scroll$1', $html, 1 );
		} else {
			$html = preg_replace( '/<body(\s|>)/i', '<body class="gt-smooth-scroll"$1', $html, 1 );
		}
	}

	return $html;
}

/**
 * Inject landing-page scroll text animations on static product/industry pages.
 *
 * @param string $html HTML content.
 * @return string
 */
function growtele_prepare_static_page_animations( $html ) {
	$version = GROWTELE_VERSION;

	if ( false === stripos( $html, 'snap-scroll.css' ) ) {
		$css = '<link rel="stylesheet" href="' . esc_url( GROWTELE_URI . '/assets/css/snap-scroll.css?v=' . $version ) . '">';
		$html = preg_replace( '/<\/head>/i', $css . '</head>', $html, 1 );
	}

	if ( false === stripos( $html, 'animations.js' ) ) {
		$js = '<script src="' . esc_url( GROWTELE_URI . '/assets/js/animations.js?v=' . $version ) . '"></script>';
		$html = preg_replace( '/<\/body>/i', $js . '</body>', $html, 1 );
	}

	return $html;
}

/**
 * Append theme version to bundled CSS/JS URLs for cache busting on WordPress.
 *
 * @param string $html HTML content.
 * @return string
 */
function growtele_version_theme_assets( $html ) {
	$version = GROWTELE_VERSION;
	$uri     = preg_quote( GROWTELE_URI, '/' );

	return preg_replace_callback(
		'/\b(href|src)=(["\'])(' . $uri . '[^"\']+\.(?:css|js))(?:\?[^"\']*)?\2/i',
		static function ( $matches ) use ( $version ) {
			$url  = preg_replace( '/\?.*$/', '', $matches[3] );
			$attr = $matches[1] . '=' . $matches[2];

			return $attr . esc_url( $url . '?v=' . rawurlencode( $version ) ) . $matches[2];
		},
		$html
	);
}

function growtele_prepare_channel_page_html( $html, $slug = '' ) {
	$global_css = '<link rel="stylesheet" href="' . esc_url( GROWTELE_URI . '/assets/css/global.css' ) . '">';

	if ( 'sms' === $slug ) {
		$footer_fix = '<style>.page>.gt-footer{position:relative;left:auto;top:auto;width:100%;max-width:100%;z-index:5;border-radius:30px 30px 0 0;}</style>';
	} else {
		$footer_fix = '<style>.page>.gt-footer{position:absolute;left:-2px;top:5293px;width:1430px;z-index:5;border-radius:30px 30px 0 0;}</style>';
	}

	$inject = $global_css . $footer_fix;

	if ( false === stripos( $html, 'global.css' ) ) {
		return preg_replace( '/<\/head>/i', $inject . '</head>', $html, 1 );
	}

	return preg_replace( '/<\/head>/i', $footer_fix . '</head>', $html, 1 );
}

/**
 * Render a bundled static HTML page from /pages/{slug}/index.html.
 *
 * @param string $slug Page slug key from growtele_static_page_map().
 */
function growtele_render_static_page( $slug ) {
	$pages = growtele_static_page_map();

	if ( ! isset( $pages[ $slug ] ) ) {
		status_header( 404 );
		echo esc_html__( 'Page not found.', 'growtele' );
		return;
	}

	$html_file = GROWTELE_DIR . '/pages/' . $pages[ $slug ] . '/index.html';

	if ( ! is_readable( $html_file ) ) {
		status_header( 404 );
		echo esc_html__( 'Page assets missing. Re-run build-theme.ps1.', 'growtele' );
		return;
	}

	$html     = file_get_contents( $html_file ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
	$base_uri = trailingslashit( GROWTELE_URI ) . 'pages/' . $pages[ $slug ] . '/';
	$base_tag = '<base href="' . esc_url( $base_uri ) . '">';

	if ( false === stripos( $html, '<base ' ) ) {
		$html = preg_replace( '/<head>/i', '<head>' . $base_tag, $html, 1 );
	}

	$html = growtele_filter_static_html( $html );
	$html = growtele_encode_static_asset_urls( $html );
	$html = growtele_absolutize_static_assets( $html, $slug );

	if ( in_array( $slug, growtele_channel_page_slugs(), true ) ) {
		$html = growtele_prepare_channel_page_html( $html, $slug );
	}

	$html = growtele_prepare_static_page_smooth_scroll( $html );
	$html = growtele_prepare_static_page_animations( $html );
	$html = growtele_version_theme_assets( $html );

	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- trusted theme HTML bundle.
	echo $html;
	exit;
}

/**
 * Force bundled static templates for channel/industry pages.
 *
 * @param string $template Current template path.
 * @return string
 */
function growtele_template_include_static_pages( $template ) {
	if ( ! is_page() ) {
		return $template;
	}

	$slug  = get_post_field( 'post_name', get_queried_object_id() );
	$pages = growtele_static_page_map();

	if ( ! isset( $pages[ $slug ] ) ) {
		return $template;
	}

	$static_template = GROWTELE_DIR . '/page-templates/page-' . $slug . '.php';

	if ( is_readable( $static_template ) ) {
		return $static_template;
	}

	return $template;
}
add_filter( 'template_include', 'growtele_template_include_static_pages', 99 );
