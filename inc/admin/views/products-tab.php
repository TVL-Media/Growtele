<?php
/**
 * Product pages CMS admin (SMS, WhatsApp, Email, RCS, Cloud Telephony).
 *
 * @package Growtele
 * @var array $content Merged CMS content.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$products = $content['products'] ?? array();
$slug     = isset( $_GET['product'] ) ? sanitize_key( wp_unslash( $_GET['product'] ) ) : 'sms'; // phpcs:ignore WordPress.Security.NonceVerification
$slugs    = array(
	'sms'             => __( 'SMS', 'growtele' ),
	'whatsapp'        => __( 'WhatsApp', 'growtele' ),
	'email'           => __( 'Email', 'growtele' ),
	'rcs'             => __( 'RCS', 'growtele' ),
	'cloud-telephony' => __( 'Cloud Telephony', 'growtele' ),
);
if ( ! isset( $slugs[ $slug ] ) ) {
	$slug = 'sms';
}
$base   = admin_url( 'themes.php?page=' . Growtele_Content_Admin::PAGE_SLUG . '&tab=products' );
$page   = $products[ $slug ] ?? array();
$hero   = $page['hero'] ?? array();
$journey = $page['journey'] ?? array();
$faq    = $page['faq'] ?? array();
$cta    = $page['cta'] ?? array();
$pills  = $page['pills'] ?? array();
?>
<nav class="nav-tab-wrapper growtele-content-admin__subnav">
	<?php foreach ( $slugs as $key => $label ) : ?>
		<a href="<?php echo esc_url( add_query_arg( 'product', $key, $base ) ); ?>" class="nav-tab <?php echo $slug === $key ? 'nav-tab-active' : ''; ?>"><?php echo esc_html( $label ); ?></a>
	<?php endforeach; ?>
</nav>

<h2><?php esc_html_e( 'Hero', 'growtele' ); ?></h2>
<table class="form-table" role="presentation">
	<?php
	Growtele_Content_Admin::field_textarea( 'growtele_content[products][' . $slug . '][hero][title]', __( 'Hero title (HTML)', 'growtele' ), $hero['title'] ?? '' );
	Growtele_Content_Admin::field_textarea( 'growtele_content[products][' . $slug . '][hero][subtitle]', __( 'Hero subtitle', 'growtele' ), $hero['subtitle'] ?? '' );
	Growtele_Content_Admin::field_text( 'growtele_content[products][' . $slug . '][hero][cta_text]', __( 'Primary CTA text', 'growtele' ), $hero['cta_text'] ?? '' );
	Growtele_Content_Admin::field_text( 'growtele_content[products][' . $slug . '][hero][cta_url]', __( 'Primary CTA URL (empty = Contact)', 'growtele' ), $hero['cta_url'] ?? '', 'url' );
	foreach ( $pills as $i => $pill ) :
		Growtele_Content_Admin::field_textarea(
			'growtele_content[products][' . $slug . '][pills][' . $i . ']',
			sprintf( __( 'Hero pill %d', 'growtele' ), $i + 1 ),
			$pill
		);
	endforeach;
	?>
</table>

<h2><?php esc_html_e( 'Journey section', 'growtele' ); ?></h2>
<table class="form-table" role="presentation">
	<?php
	Growtele_Content_Admin::field_textarea( 'growtele_content[products][' . $slug . '][journey][title]', __( 'Title (HTML)', 'growtele' ), $journey['title'] ?? '' );
	Growtele_Content_Admin::field_textarea( 'growtele_content[products][' . $slug . '][journey][lead]', __( 'Lead paragraph', 'growtele' ), $journey['lead'] ?? '' );
	?>
</table>

<h2><?php esc_html_e( 'Scale section', 'growtele' ); ?></h2>
<table class="form-table" role="presentation">
	<?php
	$scale = $page['scale'] ?? array();
	Growtele_Content_Admin::field_textarea( 'growtele_content[products][' . $slug . '][scale][title]', __( 'Title (HTML)', 'growtele' ), $scale['title'] ?? '' );
	Growtele_Content_Admin::field_textarea( 'growtele_content[products][' . $slug . '][scale][lead]', __( 'Lead paragraph', 'growtele' ), $scale['lead'] ?? '' );
	?>
</table>

<h2><?php esc_html_e( 'Benefits section', 'growtele' ); ?></h2>
<table class="form-table" role="presentation">
	<?php
	$benefits = $page['benefits'] ?? array();
	Growtele_Content_Admin::field_textarea( 'growtele_content[products][' . $slug . '][benefits][title]', __( 'Title (HTML)', 'growtele' ), $benefits['title'] ?? '' );
	Growtele_Content_Admin::field_textarea( 'growtele_content[products][' . $slug . '][benefits][lead]', __( 'Lead paragraph', 'growtele' ), $benefits['lead'] ?? '' );
	?>
</table>

<h2><?php esc_html_e( 'Why section', 'growtele' ); ?></h2>
<table class="form-table" role="presentation">
	<?php
	$why = $page['why'] ?? array();
	Growtele_Content_Admin::field_textarea( 'growtele_content[products][' . $slug . '][why][title]', __( 'Title (HTML)', 'growtele' ), $why['title'] ?? '' );
	Growtele_Content_Admin::field_textarea( 'growtele_content[products][' . $slug . '][why][lead]', __( 'Lead paragraph', 'growtele' ), $why['lead'] ?? '' );
	?>
</table>

<h2><?php esc_html_e( 'Funnel section', 'growtele' ); ?></h2>
<table class="form-table" role="presentation">
	<?php
	$funnel_heading = $page['funnel_heading'] ?? array();
	Growtele_Content_Admin::field_textarea( 'growtele_content[products][' . $slug . '][funnel_heading][title]', __( 'Title (HTML)', 'growtele' ), $funnel_heading['title'] ?? '' );
	Growtele_Content_Admin::field_textarea( 'growtele_content[products][' . $slug . '][funnel_heading][lead]', __( 'Lead paragraph', 'growtele' ), $funnel_heading['lead'] ?? '' );
	?>
</table>

<h2><?php esc_html_e( 'FAQ section', 'growtele' ); ?></h2>
<table class="form-table" role="presentation">
	<?php
	Growtele_Content_Admin::field_textarea( 'growtele_content[products][' . $slug . '][faq][title]', __( 'FAQ title (HTML)', 'growtele' ), $faq['title'] ?? '' );
	Growtele_Content_Admin::field_textarea( 'growtele_content[products][' . $slug . '][faq][lead]', __( 'FAQ lead', 'growtele' ), $faq['lead'] ?? '' );
	foreach ( $faq['items'] ?? array() as $i => $item ) :
		?>
		<tr><th colspan="2"><h3><?php echo esc_html( sprintf( __( 'FAQ item %d', 'growtele' ), $i + 1 ) ); ?></h3></th></tr>
		<?php
		Growtele_Content_Admin::field_text(
			'growtele_content[products][' . $slug . '][faq][items][' . $i . '][question]',
			__( 'Question', 'growtele' ),
			$item['question'] ?? ''
		);
		if ( isset( $item['answer'] ) ) {
			Growtele_Content_Admin::field_textarea(
				'growtele_content[products][' . $slug . '][faq][items][' . $i . '][answer]',
				__( 'Answer (HTML)', 'growtele' ),
				$item['answer'] ?? ''
			);
		}
	endforeach;
	?>
</table>

<h2><?php esc_html_e( 'Pre-footer CTA', 'growtele' ); ?></h2>
<table class="form-table" role="presentation">
	<?php
	Growtele_Content_Admin::field_textarea( 'growtele_content[products][' . $slug . '][cta][heading]', __( 'CTA heading (HTML)', 'growtele' ), $cta['heading'] ?? '' );
	Growtele_Content_Admin::field_textarea( 'growtele_content[products][' . $slug . '][cta][description]', __( 'CTA description', 'growtele' ), $cta['description'] ?? '' );
	Growtele_Content_Admin::field_text( 'growtele_content[products][' . $slug . '][cta][button_text]', __( 'Button text', 'growtele' ), $cta['button_text'] ?? '' );
	Growtele_Content_Admin::field_text( 'growtele_content[products][' . $slug . '][cta][button_url]', __( 'Button URL (empty = Contact)', 'growtele' ), $cta['button_url'] ?? '', 'url' );
	?>
</table>

<h2><?php esc_html_e( 'Funnel images (JavaScript)', 'growtele' ); ?></h2>
<table class="form-table" role="presentation">
	<?php
	$funnel = $page['funnel'] ?? array();
	foreach ( array( 'acquisition', 'engagement', 'retention' ) as $funnel_key ) :
		$item = $funnel[ $funnel_key ] ?? array();
		Growtele_Content_Admin::field_text(
			'growtele_content[products][' . $slug . '][funnel][' . $funnel_key . '][src]',
			sprintf( __( '%s image URL', 'growtele' ), ucfirst( $funnel_key ) ),
			$item['src'] ?? ''
		);
		Growtele_Content_Admin::field_text(
			'growtele_content[products][' . $slug . '][funnel][' . $funnel_key . '][alt]',
			sprintf( __( '%s alt text', 'growtele' ), ucfirst( $funnel_key ) ),
			$item['alt'] ?? ''
		);
	endforeach;
	?>
</table>
<p class="description"><?php esc_html_e( 'Leave image URLs unchanged to keep the original page assets. Relative paths such as assets/file.png continue to resolve as they do today.', 'growtele' ); ?></p>
