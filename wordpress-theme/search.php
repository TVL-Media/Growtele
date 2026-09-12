<?php
/**
 * Search results template
 *
 * @package Growtele
 */

get_header();
?>

<div class="gt-container gt-page-content">
	<header class="gt-archive-header">
		<h1 class="gt-entry__title">
			<?php
			printf(
				/* translators: %s: search query */
				esc_html__( 'Search Results for: %s', 'growtele' ),
				esc_html( get_search_query() )
			);
			?>
		</h1>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="gt-blog__grid">
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'gt-blog-card' ); ?>>
					<div class="gt-blog-card__body">
						<h2 class="gt-blog-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<div class="gt-blog-card__excerpt"><?php the_excerpt(); ?></div>
					</div>
				</article>
			<?php endwhile; ?>
		</div>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'No results found. Please try a different search.', 'growtele' ); ?></p>
		<?php get_search_form(); ?>
	<?php endif; ?>
</div>

<?php
get_footer();
