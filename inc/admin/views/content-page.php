<?php
/**
 * Growtele Content admin view.
 *
 * @package Growtele
 * @var array  $content Merged content.
 * @var string $tab     Active tab.
 * @var string $notice  Notice key.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tabs = array(
	'global'   => __( 'Global', 'growtele' ),
	'footer'   => __( 'Footer', 'growtele' ),
	'shared'   => __( 'Shared CTA', 'growtele' ),
	'home'     => __( 'Home', 'growtele' ),
	'products'   => __( 'Products', 'growtele' ),
	'industries' => __( 'Industries', 'growtele' ),
	'company'    => __( 'Company', 'growtele' ),
	'media'      => __( 'Media', 'growtele' ),
);

$base_url = admin_url( 'themes.php?page=' . Growtele_Content_Admin::PAGE_SLUG );
?>
<div class="wrap growtele-content-admin">
	<h1><?php esc_html_e( 'Growtele Content', 'growtele' ); ?></h1>

	<?php if ( 'saved' === $notice ) : ?>
		<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Content saved.', 'growtele' ); ?></p></div>
	<?php elseif ( 'reset' === $notice ) : ?>
		<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Content reset to theme defaults.', 'growtele' ); ?></p></div>
	<?php endif; ?>

	<nav class="nav-tab-wrapper">
		<?php foreach ( $tabs as $tab_key => $tab_label ) : ?>
			<a
				href="<?php echo esc_url( add_query_arg( 'tab', $tab_key, $base_url ) ); ?>"
				class="nav-tab <?php echo $tab === $tab_key ? 'nav-tab-active' : ''; ?>"
			><?php echo esc_html( $tab_label ); ?></a>
		<?php endforeach; ?>
	</nav>

	<form method="post" action="">
		<?php wp_nonce_field( 'growtele_content_save' ); ?>

		<?php if ( 'global' === $tab ) : ?>
			<h2><?php esc_html_e( 'Header', 'growtele' ); ?></h2>
			<table class="form-table" role="presentation">
				<?php
				Growtele_Content_Admin::field_text(
					'growtele_content[global][header][cta_text]',
					__( 'Header CTA text', 'growtele' ),
					$content['global']['header']['cta_text'] ?? ''
				);
				Growtele_Content_Admin::field_text(
					'growtele_content[global][header][cta_url]',
					__( 'Header CTA URL (empty = Contact page)', 'growtele' ),
					$content['global']['header']['cta_url'] ?? '',
					'url'
				);
				?>
			</table>

			<h2><?php esc_html_e( 'Products mega-menu copy', 'growtele' ); ?></h2>
			<table class="form-table" role="presentation">
				<?php
				$mega = $content['global']['nav']['mega'] ?? array();
				$mega_labels = array(
					'sms'             => __( 'SMS', 'growtele' ),
					'email'           => __( 'E-Mail', 'growtele' ),
					'cloud-telephony' => __( 'Cloud Telephony', 'growtele' ),
					'whatsapp'        => __( 'WhatsApp', 'growtele' ),
					'rcs'             => __( 'RCS', 'growtele' ),
				);
				foreach ( $mega_labels as $mega_key => $mega_label ) :
					$item = $mega[ $mega_key ] ?? array();
					Growtele_Content_Admin::field_text(
						'growtele_content[global][nav][mega][' . $mega_key . '][title]',
						sprintf( __( '%s title', 'growtele' ), $mega_label ),
						$item['title'] ?? ''
					);
					Growtele_Content_Admin::field_textarea(
						'growtele_content[global][nav][mega][' . $mega_key . '][desc]',
						sprintf( __( '%s description', 'growtele' ), $mega_label ),
						$item['desc'] ?? ''
					);
				endforeach;
				$feature = $content['global']['nav']['feature'] ?? array();
				Growtele_Content_Admin::field_text(
					'growtele_content[global][nav][feature][title]',
					__( 'Feature panel title', 'growtele' ),
					$feature['title'] ?? ''
				);
				Growtele_Content_Admin::field_textarea(
					'growtele_content[global][nav][feature][desc]',
					__( 'Feature panel description', 'growtele' ),
					$feature['desc'] ?? ''
				);
				?>
			</table>

			<h2><?php esc_html_e( 'Site-wide', 'growtele' ); ?></h2>
			<table class="form-table" role="presentation">
				<?php
				Growtele_Content_Admin::field_text(
					'growtele_content[global][contact_email]',
					__( 'Contact email', 'growtele' ),
					$content['global']['contact_email'] ?? '',
					'email'
				);
				Growtele_Content_Admin::field_text(
					'growtele_content[global][container_width]',
					__( 'Container width (px)', 'growtele' ),
					$content['global']['container_width'] ?? 1480,
					'number'
				);
				?>
			</table>
		<?php elseif ( 'footer' === $tab ) : ?>
			<table class="form-table" role="presentation">
				<?php
				Growtele_Content_Admin::field_text(
					'growtele_content[footer][brand_description]',
					__( 'Brand description', 'growtele' ),
					$content['footer']['brand_description'] ?? ''
				);
				Growtele_Content_Admin::field_text(
					'growtele_content[footer][follow_heading]',
					__( 'Follow Us heading', 'growtele' ),
					$content['footer']['follow_heading'] ?? ''
				);
				Growtele_Content_Admin::field_text(
					'growtele_content[footer][contact_heading]',
					__( 'Contact Us heading', 'growtele' ),
					$content['footer']['contact_heading'] ?? ''
				);
				Growtele_Content_Admin::field_media(
					'growtele_content[footer][get_in_touch_image]',
					__( 'Get in touch image', 'growtele' ),
					$content['footer']['get_in_touch_image'] ?? array()
				);
				?>
			</table>

			<h2><?php esc_html_e( 'Social links', 'growtele' ); ?></h2>
			<table class="form-table" role="presentation">
				<?php
				$social = $content['footer']['social'] ?? array();
				foreach ( $social as $i => $item ) :
					Growtele_Content_Admin::field_text(
						'growtele_content[footer][social][' . $i . '][label]',
						sprintf(
							/* translators: %s: network name */
							__( '%s label', 'growtele' ),
							$item['label'] ?? ''
						),
						$item['label'] ?? ''
					);
					Growtele_Content_Admin::field_text(
						'growtele_content[footer][social][' . $i . '][url]',
						sprintf(
							/* translators: %s: network name */
							__( '%s URL', 'growtele' ),
							$item['label'] ?? ''
						),
						$item['url'] ?? '',
						'url'
					);
				endforeach;
				?>
			</table>

			<h2><?php esc_html_e( 'Footer columns', 'growtele' ); ?></h2>
			<?php
			$columns = $content['footer']['columns'] ?? array();
			$col_labels = array(
				'products'  => __( 'Products column', 'growtele' ),
				'company'   => __( 'Company column', 'growtele' ),
				'resources' => __( 'Resources column', 'growtele' ),
			);
			foreach ( $col_labels as $col_key => $col_label ) :
				$col = $columns[ $col_key ] ?? array();
				?>
				<h3><?php echo esc_html( $col_label ); ?></h3>
				<table class="form-table" role="presentation">
					<?php
					Growtele_Content_Admin::field_text(
						'growtele_content[footer][columns][' . $col_key . '][title]',
						__( 'Column title', 'growtele' ),
						$col['title'] ?? ''
					);
					foreach ( $col['links'] ?? array() as $i => $item ) :
						?>
						<input type="hidden" name="<?php echo esc_attr( 'growtele_content[footer][columns][' . $col_key . '][links][' . $i . '][slug]' ); ?>" value="<?php echo esc_attr( $item['slug'] ?? '' ); ?>" />
						<?php
						Growtele_Content_Admin::field_text(
							'growtele_content[footer][columns][' . $col_key . '][links][' . $i . '][label]',
							sprintf( __( 'Link %d label', 'growtele' ), $i + 1 ),
							$item['label'] ?? ''
						);
						Growtele_Content_Admin::field_text(
							'growtele_content[footer][columns][' . $col_key . '][links][' . $i . '][url]',
							sprintf( __( 'Link %d URL (empty = page slug)', 'growtele' ), $i + 1 ),
							$item['url'] ?? '',
							'url'
						);
					endforeach;
					?>
				</table>
				<?php
			endforeach;
			?>

			<h2><?php esc_html_e( 'Footer bottom', 'growtele' ); ?></h2>
			<table class="form-table" role="presentation">
				<?php
				Growtele_Content_Admin::field_text(
					'growtele_content[footer][copyright]',
					__( 'Copyright line', 'growtele' ),
					$content['footer']['copyright'] ?? ''
				);
				$legal = $content['footer']['legal'] ?? array();
				foreach ( $legal as $i => $item ) :
					Growtele_Content_Admin::field_text(
						'growtele_content[footer][legal][' . $i . '][label]',
						sprintf( __( 'Legal link %d label', 'growtele' ), $i + 1 ),
						$item['label'] ?? ''
					);
					Growtele_Content_Admin::field_text(
						'growtele_content[footer][legal][' . $i . '][url]',
						sprintf( __( 'Legal link %d URL', 'growtele' ), $i + 1 ),
						$item['url'] ?? '',
						'url'
					);
				endforeach;
				?>
			</table>
			<p class="description"><?php esc_html_e( 'Homepage footer columns update immediately. Static HTML pages apply unique longer labels when overridden.', 'growtele' ); ?></p>
		<?php elseif ( 'shared' === $tab ) : ?>
			<table class="form-table" role="presentation">
				<?php
				$cta = $content['shared']['cta'] ?? array();
				Growtele_Content_Admin::field_text(
					'growtele_content[shared][cta][heading_line_1]',
					__( 'Heading line 1', 'growtele' ),
					$cta['heading_line_1'] ?? ''
				);
				Growtele_Content_Admin::field_text(
					'growtele_content[shared][cta][heading_line_2]',
					__( 'Heading line 2', 'growtele' ),
					$cta['heading_line_2'] ?? ''
				);
				Growtele_Content_Admin::field_text(
					'growtele_content[shared][cta][description]',
					__( 'Description', 'growtele' ),
					$cta['description'] ?? ''
				);
				Growtele_Content_Admin::field_text(
					'growtele_content[shared][cta][button_text]',
					__( 'Button text', 'growtele' ),
					$cta['button_text'] ?? ''
				);
				Growtele_Content_Admin::field_text(
					'growtele_content[shared][cta][button_url]',
					__( 'Button URL (empty = Contact page)', 'growtele' ),
					$cta['button_url'] ?? '',
					'url'
				);
				Growtele_Content_Admin::field_media(
					'growtele_content[shared][cta][image]',
					__( 'CTA image', 'growtele' ),
					$cta['image'] ?? array()
				);
				Growtele_Content_Admin::field_text(
					'growtele_content[shared][cta][image][alt]',
					__( 'CTA image alt text', 'growtele' ),
					$cta['image']['alt'] ?? ''
				);
				?>
			</table>
		<?php elseif ( 'home' === $tab ) : ?>
			<?php require GROWTELE_DIR . '/inc/admin/views/home-tab.php'; ?>
		<?php elseif ( 'products' === $tab ) : ?>
			<?php require GROWTELE_DIR . '/inc/admin/views/products-tab.php'; ?>
		<?php elseif ( 'industries' === $tab ) : ?>
			<?php require GROWTELE_DIR . '/inc/admin/views/industries-tab.php'; ?>
		<?php elseif ( 'company' === $tab ) : ?>
			<?php require GROWTELE_DIR . '/inc/admin/views/company-tab.php'; ?>
		<?php elseif ( 'media' === $tab ) : ?>
			<h2><?php esc_html_e( 'Background media', 'growtele' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Optional replacements for content-facing CSS backgrounds. Leave unset to keep the original images and the existing responsive CSS.', 'growtele' ); ?></p>
			<table class="form-table" role="presentation">
				<?php
				$media = $content['media'] ?? array();
				Growtele_Content_Admin::field_media( 'growtele_content[media][product_hero_bg]', __( 'Product page hero background', 'growtele' ), $media['product_hero_bg'] ?? array() );
				Growtele_Content_Admin::field_media( 'growtele_content[media][product_journey_card_bg]', __( 'Product journey card background', 'growtele' ), $media['product_journey_card_bg'] ?? array() );
				Growtele_Content_Admin::field_media( 'growtele_content[media][product_benefits_bg]', __( 'Product benefits section background', 'growtele' ), $media['product_benefits_bg'] ?? array() );
				Growtele_Content_Admin::field_media( 'growtele_content[media][product_benefits_visual]', __( 'Product benefits visual (default card)', 'growtele' ), $media['product_benefits_visual'] ?? array() );
				Growtele_Content_Admin::field_media( 'growtele_content[media][footer_bg]', __( 'Footer background', 'growtele' ), $media['footer_bg'] ?? array() );
				Growtele_Content_Admin::field_media( 'growtele_content[media][industry_dark_bg]', __( 'Industry dark section background', 'growtele' ), $media['industry_dark_bg'] ?? array() );
				Growtele_Content_Admin::field_media( 'growtele_content[media][industry_box_bg]', __( 'Industry channel box background', 'growtele' ), $media['industry_box_bg'] ?? array() );
				Growtele_Content_Admin::field_media( 'growtele_content[media][about_hero_bg]', __( 'About Us hero background', 'growtele' ), $media['about_hero_bg'] ?? array() );
				?>
			</table>
			<h2><?php esc_html_e( 'Email benefits visuals', 'growtele' ); ?></h2>
			<table class="form-table" role="presentation">
				<?php
				Growtele_Content_Admin::field_media( 'growtele_content[media][email_benefit_tab1]', __( 'Email benefits tab 1', 'growtele' ), $media['email_benefit_tab1'] ?? array() );
				Growtele_Content_Admin::field_media( 'growtele_content[media][email_benefit_tab2]', __( 'Email benefits tab 2', 'growtele' ), $media['email_benefit_tab2'] ?? array() );
				Growtele_Content_Admin::field_media( 'growtele_content[media][email_benefit_tab3]', __( 'Email benefits tab 3', 'growtele' ), $media['email_benefit_tab3'] ?? array() );
				Growtele_Content_Admin::field_media( 'growtele_content[media][email_benefit_tab4]', __( 'Email benefits tab 4', 'growtele' ), $media['email_benefit_tab4'] ?? array() );
				?>
			</table>
			<h2><?php esc_html_e( 'Growtele IO backgrounds', 'growtele' ); ?></h2>
			<table class="form-table" role="presentation">
				<?php
				Growtele_Content_Admin::field_media( 'growtele_content[media][io_value_prop_bg]', __( 'Value proposition background', 'growtele' ), $media['io_value_prop_bg'] ?? array() );
				Growtele_Content_Admin::field_media( 'growtele_content[media][io_value_prop_card]', __( 'Value proposition card', 'growtele' ), $media['io_value_prop_card'] ?? array() );
				Growtele_Content_Admin::field_media( 'growtele_content[media][io_apis_visual]', __( 'APIs visual card', 'growtele' ), $media['io_apis_visual'] ?? array() );
				Growtele_Content_Admin::field_media( 'growtele_content[media][io_navy_card]', __( 'Navy card background', 'growtele' ), $media['io_navy_card'] ?? array() );
				Growtele_Content_Admin::field_media( 'growtele_content[media][io_cta_mid_bg]', __( 'Mid-page CTA background', 'growtele' ), $media['io_cta_mid_bg'] ?? array() );
				Growtele_Content_Admin::field_media( 'growtele_content[media][io_chart_card]', __( 'Performance chart card', 'growtele' ), $media['io_chart_card'] ?? array() );
				Growtele_Content_Admin::field_media( 'growtele_content[media][io_reporting_bg]', __( 'Reporting section background', 'growtele' ), $media['io_reporting_bg'] ?? array() );
				?>
			</table>
		<?php endif; ?>

		<p class="submit">
			<button type="submit" name="growtele_content_save" class="button button-primary"><?php esc_html_e( 'Save Changes', 'growtele' ); ?></button>
			<button type="submit" name="growtele_content_reset" class="button button-secondary" onclick="return confirm('<?php echo esc_js( __( 'Reset all Growtele content overrides to theme defaults?', 'growtele' ) ); ?>');"><?php esc_html_e( 'Reset to defaults', 'growtele' ); ?></button>
		</p>
	</form>
</div>
