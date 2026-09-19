<?php
/**
 * Theme Customizer settings
 *
 * @package Growtele
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
if ( ! function_exists( 'growtele_customize_register' ) ) {
function growtele_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'growtele_theme_options',
		array(
			'title'    => esc_html__( 'Growtele Options', 'growtele' ),
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'growtele_cta_text',
		array(
			'default'           => esc_html__( "Let's Get Started", 'growtele' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'growtele_cta_text',
		array(
			'label'   => esc_html__( 'Header CTA Text', 'growtele' ),
			'section' => 'growtele_theme_options',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'growtele_cta_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		'growtele_cta_url',
		array(
			'label'   => esc_html__( 'Header CTA URL', 'growtele' ),
			'section' => 'growtele_theme_options',
			'type'    => 'url',
		)
	);

	$wp_customize->add_setting(
		'growtele_contact_email',
		array(
			'default'           => 'enquiry@growtele.com',
			'sanitize_callback' => 'sanitize_email',
		)
	);

	$wp_customize->add_control(
		'growtele_contact_email',
		array(
			'label'   => esc_html__( 'Contact Email', 'growtele' ),
			'section' => 'growtele_theme_options',
			'type'    => 'email',
		)
	);

	$wp_customize->add_setting(
		'growtele_container_width',
		array(
			'default'           => 1480,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'growtele_container_width',
		array(
			'label'       => esc_html__( 'Container Width (px)', 'growtele' ),
			'section'     => 'growtele_theme_options',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 960,
				'max'  => 1600,
				'step' => 10,
			),
		)
	);
}
add_action( 'customize_register', 'growtele_customize_register' );
}

/**
 * Output customizer CSS variables.
 */
function growtele_customizer_css() {
	$container = function_exists( 'growtele_get_container_width' ) ? growtele_get_container_width() : absint( get_theme_mod( 'growtele_container_width', 1480 ) );
	$footer_bg = '';
	if ( function_exists( 'growtele_content_is_overridden' ) && growtele_content_is_overridden( 'media.footer_bg' ) ) {
		$footer_bg = growtele_get_content_media_url( 'media.footer_bg', 'https://listings.selectvia.com/wp-content/uploads/2026/09/Group-593-1-1.png' );
	}
	?>
	<style id="growtele-customizer-css">
		:root {
			--gt-container-max: <?php echo esc_attr( $container ); ?>px;
			<?php if ( $footer_bg ) : ?>
			--gt-cms-footer-bg: url("<?php echo esc_url( $footer_bg ); ?>");
			<?php endif; ?>
		}
	</style>
	<?php
}
add_action( 'wp_head', 'growtele_customizer_css', 100 );
