<?php
/**
 * Single post template
 *
 * @package Growtele
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<div class="gt-container gt-page-content">
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'gt-entry gt-entry--single' ); ?>>
			<header class="gt-entry__header">
				<?php the_title( '<h1 class="gt-entry__title">', '</h1>' ); ?>
				<div class="gt-entry__meta"><?php growtele_posted_on(); ?></div>
			</header>
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="gt-entry__featured"><?php the_post_thumbnail( 'growtele-hero' ); ?></div>
			<?php endif; ?>
			<div class="gt-entry__content">
				<?php the_content(); ?>
			</div>
		</article>
	</div>
	<?php
endwhile;

get_footer();
