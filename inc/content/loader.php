<?php
/**
 * Load Growtele CMS modules.
 *
 * @package Growtele
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require GROWTELE_DIR . '/inc/content/constants.php';
require GROWTELE_DIR . '/inc/content/defaults/index.php';
require GROWTELE_DIR . '/inc/content/helpers.php';
require GROWTELE_DIR . '/inc/content/media.php';
require GROWTELE_DIR . '/inc/content/home-helpers.php';
require GROWTELE_DIR . '/inc/content/sanitize.php';
require GROWTELE_DIR . '/inc/content/static-cms.php';

if ( is_admin() ) {
	require GROWTELE_DIR . '/inc/admin/class-growtele-content-admin.php';
	Growtele_Content_Admin::init();
}
