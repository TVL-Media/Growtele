<?php
/**
 * Archive template
 *
 * @package Growtele
 */

get_header();
?>

<div class="gt-container gt-page-content">
	<header class="gt-archive-header">
		<?php the_archive_title( '<h1 class="gt-entry__title">', '</h1>' ); ?>
		<?php the_archive_description( '<div class="gt-archive-desc">', '</div>' ); ?>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="gt-blog__grid">
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'gt-blog-card' ); ?>>
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" class="gt-blog-card__thumb">
							<?php the_post_thumbnail( 'growtele-card' ); ?>
						</a>
					<?php endif; ?>
					<div class="gt-blog-card__body">
						<h2 class="gt-blog-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<div class="gt-blog-card__excerpt"><?php the_excerpt(); ?></div>
					</div>
				</article>
			<?php endwhile; ?>
		</div>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'Nothing found.', 'growtele' ); ?></p>
	<?php endif; ?>
</div>

<?php
get_footer();
