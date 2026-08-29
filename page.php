<?php
/**
 * Page template
 *
 * @package Growtele
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<div class="gt-container gt-page-content">
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'gt-entry' ); ?>>
			<header class="gt-entry__header">
				<?php the_title( '<h1 class="gt-entry__title">', '</h1>' ); ?>
			</header>
			<div class="gt-entry__content">
				<?php the_content(); ?>
			</div>
		</article>
	</div>
	<?php
endwhile;

get_footer();
