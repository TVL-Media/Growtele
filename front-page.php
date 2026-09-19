<?php
/**
 * Front page template
 *
 * @package Growtele
 */

get_header();

if ( function_exists( 'growtele_is_elementor_page' ) && growtele_is_elementor_page() ) {
	while ( have_posts() ) :
		the_post();
		the_content();
	endwhile;
} else {
	get_template_part( 'template-parts/sections/hero' );
	get_template_part( 'template-parts/sections/outcomes' );
	get_template_part( 'template-parts/sections/industries' );
	get_template_part( 'template-parts/sections/channels' );
	get_template_part( 'template-parts/sections/case-studies' );
	get_template_part( 'template-parts/sections/enterprise' );
	get_template_part( 'template-parts/sections/integrations' );
	get_template_part( 'template-parts/sections/cta' );
}

get_footer();
