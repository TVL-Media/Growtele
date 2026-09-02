<?php
/**
 * Site header
 *
 * @package Growtele
 */

$cta_text = get_theme_mod( 'growtele_cta_text', __( "Let's Get Started", 'growtele' ) );
$cta_url  = get_theme_mod( 'growtele_cta_url', '#' );
?>
<header id="masthead" class="gt-header" data-header>
	<div class="gt-container">
		<div class="gt-header__inner">
			<div class="gt-header__logo">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" data-home-logo rel="home" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
					<?php
					if ( has_custom_logo() ) {
						the_custom_logo();
					} else {
						growtele_image( 'icons/logo.png', get_bloginfo( 'name' ), 'gt-header__logo-img', 196, 50 );
					}
					?>
				</a>
			</div>

			<nav id="site-navigation" class="gt-header__nav" aria-label="<?php esc_attr_e( 'Primary Navigation', 'growtele' ); ?>">
				<button class="gt-header__toggle" type="button" aria-expanded="false" aria-controls="primary-menu" data-nav-toggle>
					<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'growtele' ); ?></span>
					<span class="gt-header__toggle-bar"></span>
					<span class="gt-header__toggle-bar"></span>
					<span class="gt-header__toggle-bar"></span>
				</button>

				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'menu_class'     => 'gt-header__menu',
						'container'      => false,
						'fallback_cb'    => 'growtele_fallback_menu',
					)
				);
				?>
			</nav>

			<div class="gt-header__cta">
				<?php growtele_cta_button( $cta_text, $cta_url ); ?>
			</div>
		</div>
	</div>
</header>
