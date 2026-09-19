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
		'ecommerce'         => 'ecommerce',
		'education'         => 'education',
		'logistic'          => 'logistic',
		'about-us'          => 'about-us',
		'blogs'             => 'blogs',
		'career'            => 'career',
		'contact'           => 'contact',
		'growtele-io'       => 'growtele-io',
		'pricing'           => 'pricing',
		'api-documentation' => 'api-documentation',
		'privacy-policy'    => 'privacy-policy',
		'terms-and-condition' => 'terms-and-condition',
		'security'          => 'security',
		'partners-term-of-use' => 'partners-term-of-use',
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
 * Root-relative path for a Growtele page (safe with HTML base tags).
 *
 * @param string $slug Page slug.
 * @return string
 */
function growtele_get_page_path( $slug ) {
	$relative = wp_make_link_relative( growtele_get_page_url( $slug ) );

	if ( is_string( $relative ) && '' !== $relative && 0 === strpos( $relative, '/' ) ) {
		return $relative;
	}

	return '/' . trim( $slug, '/' ) . '/';
}

/**
 * Whether a URL should not be rewritten as a page-local asset.
 *
 * @param string $url URL or path.
 * @return bool
 */
function growtele_is_absolute_url( $url ) {
	if ( '' === $url ) {
		return false;
	}

	if ( 0 === strpos( $url, '/' ) || 0 === strpos( $url, '#' ) || 0 === strpos( $url, '//' ) ) {
		return true;
	}

	if ( preg_match( '#^https?://#i', $url ) || preg_match( '#^https?%3A//#i', $url ) ) {
		return true;
	}

	return (bool) preg_match( '#^[a-z][a-z0-9+\-.]*:#i', $url );
}

/**
 * Detect static HTML page links and return their slug (or "home").
 *
 * @param string $url Relative href from HTML.
 * @return string|false
 */
function growtele_match_static_page_href( $url ) {
	if ( preg_match( '#^(?:\.\./|\./)?index\.html$#i', $url ) ) {
		return 'home';
	}

	if ( preg_match( '#^(?:\.\./|\./)?([a-z0-9-]+)(?:/index\.html)?/?$#i', $url, $matches ) ) {
		$slug = growtele_resolve_static_page_slug( $matches[1] );

		if ( '' !== $slug ) {
			return $slug;
		}
	}

	return false;
}

/**
 * Convert a static HTML page href to a WordPress URL.
 *
 * @param string $url Relative href from HTML.
 * @return string|false
 */
function growtele_convert_static_page_href( $url ) {
	$slug = growtele_match_static_page_href( $url );

	if ( false === $slug ) {
		return false;
	}

	if ( 'home' === $slug ) {
		return growtele_get_home_path();
	}

	return growtele_get_page_url( $slug );
}

/**
 * Folder name aliases used in static HTML links.
 *
 * @return array<string, string>
 */
function growtele_static_page_folder_aliases() {
	return array(
		'healthcare'   => 'health',
		'growinfinity' => 'growtele-io',
		'growtele.io'  => 'growtele-io',
	);
}

/**
 * Resolve a static HTML folder name to a registered page slug.
 *
 * @param string $folder Folder segment from a relative href.
 * @return string
 */
function growtele_resolve_static_page_slug( $folder ) {
	$folder  = strtolower( $folder );
	$aliases = growtele_static_page_folder_aliases();

	if ( isset( $aliases[ $folder ] ) ) {
		$folder = $aliases[ $folder ];
	}

	$pages = growtele_static_page_map();

	return isset( $pages[ $folder ] ) ? $folder : '';
}

/**
 * Root-relative home path.
 *
 * @return string
 */
function growtele_get_home_path() {
	$home_path = wp_make_link_relative( home_url( '/' ) );

	if ( is_string( $home_path ) && '' !== $home_path ) {
		return $home_path;
	}

	return '/';
}

/**
 * Rewrite static HTML page links to root-relative WordPress paths.
 *
 * @param string $html HTML content.
 * @return string
 */
function growtele_rewrite_static_page_hrefs( $html ) {
	return preg_replace_callback(
		'/\bhref=(["\'])([^"\']+)\1/i',
		function ( $matches ) {
			$converted = growtele_convert_static_page_href( $matches[2] );

			if ( false === $converted ) {
				return $matches[0];
			}

			return 'href=' . $matches[1] . esc_url( $converted ) . $matches[1];
		},
		$html
	);
}

/**
 * Resolve a relative asset URL to an absolute theme URL.
 *
 * @param string $url  Relative URL from HTML.
 * @param string $slug Current static page slug.
 * @return string
 */
function growtele_resolve_static_asset_url( $url, $slug ) {
	$pages = growtele_static_page_map();

	if ( ! isset( $pages[ $slug ] ) ) {
		return $url;
	}

	$page_href = growtele_convert_static_page_href( $url );
	if ( false !== $page_href ) {
		return $page_href;
	}

	$page_dir    = trailingslashit( GROWTELE_URI ) . 'pages/' . $pages[ $slug ] . '/';
	$pages_root  = trailingslashit( GROWTELE_URI ) . 'pages/';
	$assets_root = trailingslashit( GROWTELE_URI ) . 'assets/';

	if ( 0 === strpos( $url, '../../assets/' ) ) {
		return $assets_root . substr( $url, 13 );
	}

	if ( 0 === strpos( $url, '../assets/' ) ) {
		return $assets_root . substr( $url, 11 );
	}

	if ( 0 === strpos( $url, '../shared/' ) ) {
		return $pages_root . 'shared/' . substr( $url, 10 );
	}

	if ( preg_match( '#^\.\./([^/]+)/(.+)$#', $url, $matches ) ) {
		return $pages_root . $matches[1] . '/' . $matches[2];
	}

	return $page_dir . ltrim( $url, './' );
}

/**
 * Replace legacy relative paths from static HTML exports.
 *
 * @param string $html HTML content.
 * @return string
 */
function growtele_filter_static_html( $html ) {
	$map = array(
		'../../assets/'                               => trailingslashit( GROWTELE_URI ) . 'assets/',
		'../assets/'                                  => trailingslashit( GROWTELE_URI ) . 'assets/',
		'../sms/css/sms-nav.css'                      => trailingslashit( GROWTELE_URI ) . 'pages/sms/css/sms-nav.css',
		'../SMS Grwtl/css/sms-nav.css'                => trailingslashit( GROWTELE_URI ) . 'pages/sms/css/sms-nav.css',
		'../pages/sms/css/sms-nav.css'                => trailingslashit( GROWTELE_URI ) . 'pages/sms/css/sms-nav.css',
		'SMS Grwtl/css/sms-nav.css'                   => trailingslashit( GROWTELE_URI ) . 'pages/sms/css/sms-nav.css',
	);

	$keys = array_keys( $map );
	usort(
		$keys,
		function ( $a, $b ) {
			return strlen( $b ) - strlen( $a );
		}
	);

	$values = array();
	foreach ( $keys as $key ) {
		$values[] = $map[ $key ];
	}

	$html = str_replace( $keys, $values, $html );

	$html = preg_replace(
		'/window\.GROWTELE_PAGE_ASSETS\s*=\s*new URL\(\s*[\'"]assets\/[\'"]\s*,\s*window\.location\.href\s*\)\.href\s*;/',
		'window.GROWTELE_PAGE_ASSETS=window.GROWTELE_PAGE_ASSETS||new URL(\'assets/\',window.location.href).href;',
		$html
	);

	return $html;
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
		function ( $matches ) {
			$url = $matches[2];

			if ( preg_match( '/\bdata-counter/i', $matches[1] ) ) {
				return $matches[0];
			}

			if ( false !== growtele_convert_static_page_href( $url ) ) {
				return $matches[0];
			}

			if ( preg_match( '#^(?:https?:)?//#i', $url ) || growtele_is_absolute_url( $url ) || 0 === strpos( $url, 'data:' ) ) {
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
				function ( $part ) {
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

	$version = GROWTELE_VERSION;

	return preg_replace_callback(
		'/\b(href|src)=(["\'])([^"\']+)\2/i',
		function ( $matches ) use ( $slug, $version ) {
			$url = $matches[3];

			if ( growtele_is_absolute_url( $url ) || 0 === strpos( $url, 'data:' ) || 0 === strpos( $url, GROWTELE_URI ) ) {
				return $matches[0];
			}

			$page_href = growtele_convert_static_page_href( $url );
			if ( false !== $page_href ) {
				return $matches[1] . '=' . $matches[2] . esc_url( $page_href ) . $matches[2];
			}

			$absolute = growtele_resolve_static_asset_url( $url, $slug );

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
function growtele_prepare_static_page_nav_current( $html ) {
	if ( false !== stripos( $html, 'nav-current.js' ) ) {
		return $html;
	}

	$version = GROWTELE_VERSION;
	$script  = '<script src="' . esc_url( GROWTELE_URI . '/assets/js/nav-current.js?v=' . $version ) . '"></script>';

	if ( preg_match( '/<script[^>]+sms-nav-dropdowns\.js[^>]*><\/script>/i', $html ) ) {
		return preg_replace( '/(<script[^>]+sms-nav-dropdowns\.js[^>]*><\/script>)/i', $script . '$1', $html, 1 );
	}

	if ( preg_match( '/<script[^>]+assets\/js\/main\.js[^>]*><\/script>/i', $html ) ) {
		return preg_replace( '/(<script[^>]+assets\/js\/main\.js[^>]*><\/script>)/i', $script . '$1', $html, 1 );
	}

	return preg_replace( '/<\/body>/i', $script . '</body>', $html, 1 );
}

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
		function ( $matches ) use ( $version ) {
			$url  = preg_replace( '/\?.*$/', '', $matches[3] );
			$attr = $matches[1] . '=' . $matches[2];

			return $attr . esc_url( $url . '?v=' . rawurlencode( $version ) ) . $matches[2];
		},
		$html
	);
}

function growtele_prepare_channel_page_html( $html, $slug = '' ) {
	$global_css = '<link rel="stylesheet" href="' . esc_url( GROWTELE_URI . '/assets/css/global.css' ) . '">';

	$footer_fix = '<style>.page>.gt-footer{position:relative;left:auto;top:auto;width:100%;max-width:100%;z-index:5;border-radius:30px 30px 0 0;}</style>';

	$inject = $global_css . $footer_fix;

	if ( false === stripos( $html, 'global.css' ) ) {
		return preg_replace( '/<\/head>/i', $inject . '</head>', $html, 1 );
	}

	return preg_replace( '/<\/head>/i', $footer_fix . '</head>', $html, 1 );
}

function growtele_inject_page_assets( $html, $slug ) {
	$pages = growtele_static_page_map();

	if ( ! isset( $pages[ $slug ] ) ) {
		return $html;
	}

	$version    = GROWTELE_VERSION;
	$asset_base = trailingslashit( GROWTELE_URI ) . 'pages/' . $pages[ $slug ] . '/assets/';
	$inject     = '<script>window.GROWTELE_PAGE_ASSETS=' . wp_json_encode( $asset_base ) . ';</script>';
	$inject    .= '<script src="' . esc_url( GROWTELE_URI . '/assets/js/resolve-asset-url.js?v=' . $version ) . '"></script>';

	return preg_replace( '/<head>/i', '<head>' . $inject, $html, 1 );
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

	$html = growtele_filter_static_html( $html );
	$html = growtele_inject_page_assets( $html, $slug );
	$html = growtele_rewrite_static_page_hrefs( $html );
	$html = growtele_encode_static_asset_urls( $html );
	$html = growtele_absolutize_static_assets( $html, $slug );

	if ( in_array( $slug, growtele_channel_page_slugs(), true ) ) {
		$html = growtele_prepare_channel_page_html( $html, $slug );
	}

	$html = growtele_prepare_static_page_smooth_scroll( $html );
	$html = growtele_prepare_static_page_nav_current( $html );
	$html = growtele_prepare_static_page_animations( $html );
	$html = growtele_version_theme_assets( $html );

	if ( function_exists( 'growtele_apply_static_page_cms' ) ) {
		$html = growtele_apply_static_page_cms( $html, $slug );
	}

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
