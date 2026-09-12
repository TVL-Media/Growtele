<?php
/**
 * Main template
 *
 * @package Growtele
 */

get_header();
?>

<div class="gt-container gt-page-content">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'gt-entry' ); ?>>
				<header class="gt-entry__header">
					<?php the_title( '<h1 class="gt-entry__title">', '</h1>' ); ?>
				</header>
				<div class="gt-entry__content">
					<?php the_content(); ?>
				</div>
			</article>
		<?php endwhile; ?>
	<?php else : ?>
		<p><?php esc_html_e( 'No content found.', 'growtele' ); ?></p>
	<?php endif; ?>
</div>

<?php
get_footer();
