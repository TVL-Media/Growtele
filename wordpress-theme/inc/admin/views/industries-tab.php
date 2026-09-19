<?php
/**
 * Industry pages CMS admin.
 *
 * @package Growtele
 * @var array $content Merged CMS content.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$industries = $content['industries'] ?? array();
$slug       = isset( $_GET['industry'] ) ? sanitize_key( wp_unslash( $_GET['industry'] ) ) : 'retail'; // phpcs:ignore WordPress.Security.NonceVerification
$slugs      = array(
	'retail'     => __( 'Retail', 'growtele' ),
	'health'     => __( 'Health', 'growtele' ),
	'banking'    => __( 'Banking', 'growtele' ),
	'travelling' => __( 'Travelling', 'growtele' ),
	'ecommerce'  => __( 'E-commerce', 'growtele' ),
	'education'  => __( 'Education', 'growtele' ),
	'logistic'   => __( 'Logistic', 'growtele' ),
);
if ( ! isset( $slugs[ $slug ] ) ) {
	$slug = 'retail';
}
$base      = admin_url( 'themes.php?page=' . Growtele_Content_Admin::PAGE_SLUG . '&tab=industries' );
$page      = $industries[ $slug ] ?? array();
$hero      = $page['hero'] ?? array();
$channels  = $page['channels'] ?? array();
$growth    = $page['growth'] ?? array();
$use_cases = $page['use_cases'] ?? array();
$faq       = $page['faq'] ?? array();
$cta       = $page['cta'] ?? array();
?>
<nav class="nav-tab-wrapper growtele-content-admin__subnav">
	<?php foreach ( $slugs as $key => $label ) : ?>
		<a href="<?php echo esc_url( add_query_arg( 'industry', $key, $base ) ); ?>" class="nav-tab <?php echo $slug === $key ? 'nav-tab-active' : ''; ?>"><?php echo esc_html( $label ); ?></a>
	<?php endforeach; ?>
</nav>

<h2><?php esc_html_e( 'Hero', 'growtele' ); ?></h2>
<table class="form-table" role="presentation">
	<?php
	Growtele_Content_Admin::field_textarea( 'growtele_content[industries][' . $slug . '][hero][title]', __( 'Hero title', 'growtele' ), $hero['title'] ?? '' );
	Growtele_Content_Admin::field_textarea( 'growtele_content[industries][' . $slug . '][hero][desc]', __( 'Hero description', 'growtele' ), $hero['desc'] ?? '' );
	Growtele_Content_Admin::field_text( 'growtele_content[industries][' . $slug . '][hero][cta_primary]', __( 'Primary button text', 'growtele' ), $hero['cta_primary'] ?? '' );
	Growtele_Content_Admin::field_text( 'growtele_content[industries][' . $slug . '][hero][cta_primary_url]', __( 'Primary button URL (empty = Contact)', 'growtele' ), $hero['cta_primary_url'] ?? '', 'url' );
	Growtele_Content_Admin::field_text( 'growtele_content[industries][' . $slug . '][hero][cta_secondary]', __( 'Secondary button text', 'growtele' ), $hero['cta_secondary'] ?? '' );
	?>
</table>

<h2><?php esc_html_e( 'Channels section', 'growtele' ); ?></h2>
<table class="form-table" role="presentation">
	<?php
	Growtele_Content_Admin::field_textarea( 'growtele_content[industries][' . $slug . '][channels][title]', __( 'Title (HTML)', 'growtele' ), $channels['title'] ?? '' );
	Growtele_Content_Admin::field_textarea( 'growtele_content[industries][' . $slug . '][channels][subtitle]', __( 'Subtitle', 'growtele' ), $channels['subtitle'] ?? '' );
	?>
</table>

<h2><?php esc_html_e( 'Growth section', 'growtele' ); ?></h2>
<table class="form-table" role="presentation">
	<?php
	Growtele_Content_Admin::field_textarea( 'growtele_content[industries][' . $slug . '][growth][title]', __( 'Title (HTML)', 'growtele' ), $growth['title'] ?? '' );
	Growtele_Content_Admin::field_textarea( 'growtele_content[industries][' . $slug . '][growth][subtitle]', __( 'Subtitle', 'growtele' ), $growth['subtitle'] ?? '' );
	?>
</table>

<h2><?php esc_html_e( 'Use cases', 'growtele' ); ?></h2>
<table class="form-table" role="presentation">
	<?php
	Growtele_Content_Admin::field_textarea( 'growtele_content[industries][' . $slug . '][use_cases][title]', __( 'Title (HTML)', 'growtele' ), $use_cases['title'] ?? '' );
	?>
</table>

<h2><?php esc_html_e( 'FAQ', 'growtele' ); ?></h2>
<table class="form-table" role="presentation">
	<?php
	Growtele_Content_Admin::field_textarea( 'growtele_content[industries][' . $slug . '][faq][title]', __( 'FAQ title (HTML)', 'growtele' ), $faq['title'] ?? '' );
	Growtele_Content_Admin::field_textarea( 'growtele_content[industries][' . $slug . '][faq][intro]', __( 'FAQ intro', 'growtele' ), $faq['intro'] ?? '' );
	Growtele_Content_Admin::field_text( 'growtele_content[industries][' . $slug . '][faq][book][title]', __( 'Book-a-call title', 'growtele' ), $faq['book']['title'] ?? '' );
	Growtele_Content_Admin::field_textarea( 'growtele_content[industries][' . $slug . '][faq][book][description]', __( 'Book-a-call description', 'growtele' ), $faq['book']['description'] ?? '' );
	Growtele_Content_Admin::field_text( 'growtele_content[industries][' . $slug . '][faq][book][button_text]', __( 'Book-a-call button', 'growtele' ), $faq['book']['button_text'] ?? '' );
	foreach ( $faq['items'] ?? array() as $i => $item ) :
		?>
		<tr><th colspan="2"><h3><?php echo esc_html( sprintf( __( 'FAQ item %d', 'growtele' ), $i + 1 ) ); ?></h3></th></tr>
		<?php
		Growtele_Content_Admin::field_text(
			'growtele_content[industries][' . $slug . '][faq][items][' . $i . '][question]',
			__( 'Question', 'growtele' ),
			$item['question'] ?? ''
		);
		if ( isset( $item['answer'] ) ) {
			Growtele_Content_Admin::field_textarea(
				'growtele_content[industries][' . $slug . '][faq][items][' . $i . '][answer]',
				__( 'Answer', 'growtele' ),
				$item['answer'] ?? ''
			);
		}
	endforeach;
	?>
</table>

<h2><?php esc_html_e( 'Pre-footer CTA', 'growtele' ); ?></h2>
<table class="form-table" role="presentation">
	<?php
	Growtele_Content_Admin::field_textarea( 'growtele_content[industries][' . $slug . '][cta][heading]', __( 'CTA heading (HTML)', 'growtele' ), $cta['heading'] ?? '' );
	Growtele_Content_Admin::field_textarea( 'growtele_content[industries][' . $slug . '][cta][description]', __( 'CTA description', 'growtele' ), $cta['description'] ?? '' );
	Growtele_Content_Admin::field_text( 'growtele_content[industries][' . $slug . '][cta][button_text]', __( 'Button text', 'growtele' ), $cta['button_text'] ?? '' );
	Growtele_Content_Admin::field_text( 'growtele_content[industries][' . $slug . '][cta][button_url]', __( 'Button URL (empty = Contact)', 'growtele' ), $cta['button_url'] ?? '', 'url' );
	?>
</table>
<p class="description"><?php esc_html_e( 'Changes apply on WordPress industry pages only; static HTML files remain the fallback source.', 'growtele' ); ?></p>
