<?php
/**
 * 404 template
 *
 * @package Growtele
 */

get_header();
?>

<div class="gt-container gt-page-content gt-404">
	<h1 class="gt-404__title">404</h1>
	<h2 class="gt-404__subtitle"><?php esc_html_e( 'Page Not Found', 'growtele' ); ?></h2>
	<p><?php esc_html_e( 'The page you are looking for might have been removed or is temporarily unavailable.', 'growtele' ); ?></p>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="gt-btn gt-btn--gradient">
		<?php esc_html_e( 'Back to Home', 'growtele' ); ?>
	</a>
</div>

<?php
get_footer();
