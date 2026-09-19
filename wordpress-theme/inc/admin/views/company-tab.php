<?php
/**
 * Company pages CMS admin (About, Blogs, Career, Contact, Growtele IO).
 *
 * @package Growtele
 * @var array $content Merged CMS content.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$company = $content['company'] ?? array();
$slug    = isset( $_GET['company'] ) ? sanitize_key( wp_unslash( $_GET['company'] ) ) : 'about-us'; // phpcs:ignore WordPress.Security.NonceVerification
$slugs   = array(
	'about-us'    => __( 'About Us', 'growtele' ),
	'blogs'       => __( 'Blogs', 'growtele' ),
	'career'      => __( 'Career', 'growtele' ),
	'contact'     => __( 'Contact', 'growtele' ),
	'growtele-io' => __( 'Growtele IO', 'growtele' ),
);
if ( ! isset( $slugs[ $slug ] ) ) {
	$slug = 'about-us';
}
$base = admin_url( 'themes.php?page=' . Growtele_Content_Admin::PAGE_SLUG . '&tab=company' );
$page = $company[ $slug ] ?? array();
?>
<nav class="nav-tab-wrapper growtele-content-admin__subnav">
	<?php foreach ( $slugs as $key => $label ) : ?>
		<a href="<?php echo esc_url( add_query_arg( 'company', $key, $base ) ); ?>" class="nav-tab <?php echo $slug === $key ? 'nav-tab-active' : ''; ?>"><?php echo esc_html( $label ); ?></a>
	<?php endforeach; ?>
</nav>

<?php if ( 'about-us' === $slug ) : ?>
	<?php $hero = $page['hero'] ?? array(); $connecting = $page['connecting'] ?? array(); $core = $page['core_values'] ?? array(); $driven = $page['driven'] ?? array(); $locations = $page['locations'] ?? array(); ?>
	<h2><?php esc_html_e( 'Hero', 'growtele' ); ?></h2>
	<table class="form-table" role="presentation">
		<?php
		Growtele_Content_Admin::field_text( 'growtele_content[company][about-us][hero][badge]', __( 'Badge', 'growtele' ), $hero['badge'] ?? '' );
		Growtele_Content_Admin::field_textarea( 'growtele_content[company][about-us][hero][title]', __( 'Title', 'growtele' ), $hero['title'] ?? '' );
		Growtele_Content_Admin::field_textarea( 'growtele_content[company][about-us][hero][desc]', __( 'Description', 'growtele' ), $hero['desc'] ?? '' );
		?>
	</table>
	<h2><?php esc_html_e( 'Connecting businesses', 'growtele' ); ?></h2>
	<table class="form-table" role="presentation">
		<?php
		Growtele_Content_Admin::field_textarea( 'growtele_content[company][about-us][connecting][title]', __( 'Title', 'growtele' ), $connecting['title'] ?? '' );
		Growtele_Content_Admin::field_textarea( 'growtele_content[company][about-us][connecting][description]', __( 'Description', 'growtele' ), $connecting['description'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[company][about-us][connecting][stat_1]', __( 'Stat 1 value', 'growtele' ), $connecting['stat_1'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[company][about-us][connecting][stat_1_label]', __( 'Stat 1 label', 'growtele' ), $connecting['stat_1_label'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[company][about-us][connecting][stat_2]', __( 'Stat 2 value', 'growtele' ), $connecting['stat_2'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[company][about-us][connecting][stat_2_label]', __( 'Stat 2 label', 'growtele' ), $connecting['stat_2_label'] ?? '' );
		?>
	</table>
	<h2><?php esc_html_e( 'Core values', 'growtele' ); ?></h2>
	<table class="form-table" role="presentation">
		<?php
		Growtele_Content_Admin::field_textarea( 'growtele_content[company][about-us][core_values][title]', __( 'Title (HTML)', 'growtele' ), $core['title'] ?? '' );
		Growtele_Content_Admin::field_textarea( 'growtele_content[company][about-us][core_values][desc]', __( 'Description', 'growtele' ), $core['desc'] ?? '' );
		?>
	</table>
	<h2><?php esc_html_e( 'Driven by people', 'growtele' ); ?></h2>
	<table class="form-table" role="presentation">
		<?php
		Growtele_Content_Admin::field_textarea( 'growtele_content[company][about-us][driven][title]', __( 'Title (HTML)', 'growtele' ), $driven['title'] ?? '' );
		Growtele_Content_Admin::field_textarea( 'growtele_content[company][about-us][driven][subtitle]', __( 'Subtitle', 'growtele' ), $driven['subtitle'] ?? '' );
		?>
	</table>
	<h2><?php esc_html_e( 'Locations', 'growtele' ); ?></h2>
	<table class="form-table" role="presentation">
		<?php
		Growtele_Content_Admin::field_textarea( 'growtele_content[company][about-us][locations][title]', __( 'Title', 'growtele' ), $locations['title'] ?? '' );
		Growtele_Content_Admin::field_textarea( 'growtele_content[company][about-us][locations][subtitle]', __( 'Subtitle', 'growtele' ), $locations['subtitle'] ?? '' );
		?>
	</table>
	<h2><?php esc_html_e( 'Office locations (JavaScript)', 'growtele' ); ?></h2>
	<table class="form-table" role="presentation">
		<?php
		$offices = $page['offices'] ?? array();
		foreach ( $offices as $city_key => $office ) :
			?>
			<tr><th colspan="2"><h3><?php echo esc_html( $office['city'] ?? $city_key ); ?></h3></th></tr>
			<?php
			Growtele_Content_Admin::field_text( 'growtele_content[company][about-us][offices][' . $city_key . '][city]', __( 'City label', 'growtele' ), $office['city'] ?? '' );
			Growtele_Content_Admin::field_textarea( 'growtele_content[company][about-us][offices][' . $city_key . '][address]', __( 'Address', 'growtele' ), $office['address'] ?? '' );
			Growtele_Content_Admin::field_text( 'growtele_content[company][about-us][offices][' . $city_key . '][phone]', __( 'Phone', 'growtele' ), $office['phone'] ?? '' );
			Growtele_Content_Admin::field_text( 'growtele_content[company][about-us][offices][' . $city_key . '][email1]', __( 'Email 1', 'growtele' ), $office['email1'] ?? '', 'email' );
			Growtele_Content_Admin::field_text( 'growtele_content[company][about-us][offices][' . $city_key . '][email2]', __( 'Email 2', 'growtele' ), $office['email2'] ?? '', 'email' );
			Growtele_Content_Admin::field_text( 'growtele_content[company][about-us][offices][' . $city_key . '][icon]', __( 'Icon URL', 'growtele' ), $office['icon'] ?? '' );
			Growtele_Content_Admin::field_text( 'growtele_content[company][about-us][offices][' . $city_key . '][image]', __( 'Photo URL', 'growtele' ), $office['image'] ?? '' );
		endforeach;
		?>
	</table>
<?php elseif ( 'blogs' === $slug ) : ?>
	<?php $hero = $page['hero'] ?? array(); ?>
	<h2><?php esc_html_e( 'Hero', 'growtele' ); ?></h2>
	<table class="form-table" role="presentation">
		<?php
		Growtele_Content_Admin::field_text( 'growtele_content[company][blogs][hero][title]', __( 'Title (HTML entities allowed)', 'growtele' ), $hero['title'] ?? '' );
		Growtele_Content_Admin::field_textarea( 'growtele_content[company][blogs][hero][subtitle]', __( 'Subtitle', 'growtele' ), $hero['subtitle'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[company][blogs][hero][search_placeholder]', __( 'Search placeholder', 'growtele' ), $hero['search_placeholder'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[company][blogs][hero][search_button]', __( 'Search button', 'growtele' ), $hero['search_button'] ?? '' );
		?>
	</table>
<?php elseif ( 'career' === $slug ) : ?>
	<?php $hero = $page['hero'] ?? array(); $culture = $page['culture'] ?? array(); $values = $page['values'] ?? array(); $perks = $page['perks'] ?? array(); $jobs = $page['jobs'] ?? array(); ?>
	<h2><?php esc_html_e( 'Hero', 'growtele' ); ?></h2>
	<table class="form-table" role="presentation">
		<?php
		Growtele_Content_Admin::field_textarea( 'growtele_content[company][career][hero][title]', __( 'Title (HTML)', 'growtele' ), $hero['title'] ?? '' );
		Growtele_Content_Admin::field_textarea( 'growtele_content[company][career][hero][subtitle]', __( 'Subtitle', 'growtele' ), $hero['subtitle'] ?? '' );
		?>
	</table>
	<h2><?php esc_html_e( 'Culture', 'growtele' ); ?></h2>
	<table class="form-table" role="presentation">
		<?php
		Growtele_Content_Admin::field_textarea( 'growtele_content[company][career][culture][title]', __( 'Title', 'growtele' ), $culture['title'] ?? '' );
		Growtele_Content_Admin::field_textarea( 'growtele_content[company][career][culture][desc]', __( 'Description (HTML)', 'growtele' ), $culture['desc'] ?? '' );
		?>
	</table>
	<h2><?php esc_html_e( 'Values', 'growtele' ); ?></h2>
	<table class="form-table" role="presentation">
		<?php
		Growtele_Content_Admin::field_textarea( 'growtele_content[company][career][values][title]', __( 'Title', 'growtele' ), $values['title'] ?? '' );
		Growtele_Content_Admin::field_textarea( 'growtele_content[company][career][values][desc]', __( 'Description', 'growtele' ), $values['desc'] ?? '' );
		?>
	</table>
	<h2><?php esc_html_e( 'Perks & jobs', 'growtele' ); ?></h2>
	<table class="form-table" role="presentation">
		<?php
		Growtele_Content_Admin::field_textarea( 'growtele_content[company][career][perks][title]', __( 'Perks title', 'growtele' ), $perks['title'] ?? '' );
		Growtele_Content_Admin::field_textarea( 'growtele_content[company][career][jobs][title]', __( 'Jobs title (HTML)', 'growtele' ), $jobs['title'] ?? '' );
		Growtele_Content_Admin::field_textarea( 'growtele_content[company][career][jobs][desc]', __( 'Jobs description (HTML)', 'growtele' ), $jobs['desc'] ?? '' );
		?>
	</table>
<?php elseif ( 'contact' === $slug ) : ?>
	<?php $hero = $page['hero'] ?? array(); $form = $page['form'] ?? array(); $locations = $page['locations'] ?? array(); ?>
	<h2><?php esc_html_e( 'Hero', 'growtele' ); ?></h2>
	<table class="form-table" role="presentation">
		<?php
		Growtele_Content_Admin::field_text( 'growtele_content[company][contact][hero][title]', __( 'Title', 'growtele' ), $hero['title'] ?? '' );
		Growtele_Content_Admin::field_textarea( 'growtele_content[company][contact][hero][subtitle]', __( 'Subtitle', 'growtele' ), $hero['subtitle'] ?? '' );
		?>
	</table>
	<h2><?php esc_html_e( 'Form labels', 'growtele' ); ?></h2>
	<table class="form-table" role="presentation">
		<?php
		Growtele_Content_Admin::field_text( 'growtele_content[company][contact][form][first_name]', __( 'First name label', 'growtele' ), $form['first_name'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[company][contact][form][last_name]', __( 'Last name label', 'growtele' ), $form['last_name'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[company][contact][form][company]', __( 'Company label', 'growtele' ), $form['company'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[company][contact][form][email]', __( 'Email label', 'growtele' ), $form['email'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[company][contact][form][phone]', __( 'Phone label', 'growtele' ), $form['phone'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[company][contact][form][query]', __( 'Query label', 'growtele' ), $form['query'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[company][contact][form][submit]', __( 'Submit button', 'growtele' ), $form['submit'] ?? '' );
		?>
	</table>
	<h2><?php esc_html_e( 'Locations', 'growtele' ); ?></h2>
	<table class="form-table" role="presentation">
		<?php
		Growtele_Content_Admin::field_textarea( 'growtele_content[company][contact][locations][title]', __( 'Title', 'growtele' ), $locations['title'] ?? '' );
		Growtele_Content_Admin::field_textarea( 'growtele_content[company][contact][locations][desc]', __( 'Description', 'growtele' ), $locations['desc'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[company][contact][locations][support]', __( 'Support heading', 'growtele' ), $locations['support'] ?? '' );
		?>
	</table>
	<h2><?php esc_html_e( 'Office locations (JavaScript)', 'growtele' ); ?></h2>
	<table class="form-table" role="presentation">
		<?php
		$offices = $page['offices'] ?? array();
		foreach ( $offices as $city_key => $office ) :
			?>
			<tr><th colspan="2"><h3><?php echo esc_html( $office['city'] ?? $city_key ); ?></h3></th></tr>
			<?php
			Growtele_Content_Admin::field_text( 'growtele_content[company][contact][offices][' . $city_key . '][city]', __( 'City label', 'growtele' ), $office['city'] ?? '' );
			Growtele_Content_Admin::field_textarea( 'growtele_content[company][contact][offices][' . $city_key . '][address]', __( 'Address', 'growtele' ), $office['address'] ?? '' );
			Growtele_Content_Admin::field_text( 'growtele_content[company][contact][offices][' . $city_key . '][phone]', __( 'Phone', 'growtele' ), $office['phone'] ?? '' );
			Growtele_Content_Admin::field_text( 'growtele_content[company][contact][offices][' . $city_key . '][email1]', __( 'Email 1', 'growtele' ), $office['email1'] ?? '', 'email' );
			Growtele_Content_Admin::field_text( 'growtele_content[company][contact][offices][' . $city_key . '][email2]', __( 'Email 2', 'growtele' ), $office['email2'] ?? '', 'email' );
			Growtele_Content_Admin::field_text( 'growtele_content[company][contact][offices][' . $city_key . '][icon]', __( 'Icon URL or relative path', 'growtele' ), $office['icon'] ?? '' );
			Growtele_Content_Admin::field_text( 'growtele_content[company][contact][offices][' . $city_key . '][map]', __( 'Map image URL or relative path', 'growtele' ), $office['map'] ?? '' );
		endforeach;
		?>
	</table>
	<h2><?php esc_html_e( 'Form validation messages', 'growtele' ); ?></h2>
	<table class="form-table" role="presentation">
		<?php
		$errors = $form['errors'] ?? array();
		Growtele_Content_Admin::field_text( 'growtele_content[company][contact][form][errors][first_name]', __( 'First name required', 'growtele' ), $errors['first_name'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[company][contact][form][errors][last_name]', __( 'Last name required', 'growtele' ), $errors['last_name'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[company][contact][form][errors][email]', __( 'Email required', 'growtele' ), $errors['email'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[company][contact][form][errors][email_invalid]', __( 'Email invalid', 'growtele' ), $errors['email_invalid'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[company][contact][form][errors][phone]', __( 'Phone required', 'growtele' ), $errors['phone'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[company][contact][form][errors][phone_invalid]', __( 'Phone invalid', 'growtele' ), $errors['phone_invalid'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[company][contact][form][errors][terms]', __( 'Terms required', 'growtele' ), $errors['terms'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[company][contact][form][submitted]', __( 'Submit success text', 'growtele' ), $form['submitted'] ?? '' );
		?>
	</table>
<?php else : ?>
	<?php $hero = $page['hero'] ?? array(); $faq = $page['faq'] ?? array(); ?>
	<h2><?php esc_html_e( 'Hero', 'growtele' ); ?></h2>
	<table class="form-table" role="presentation">
		<?php
		Growtele_Content_Admin::field_textarea( 'growtele_content[company][growtele-io][hero][title]', __( 'Title (HTML)', 'growtele' ), $hero['title'] ?? '' );
		Growtele_Content_Admin::field_textarea( 'growtele_content[company][growtele-io][hero][desc]', __( 'Description (HTML)', 'growtele' ), $hero['desc'] ?? '' );
		?>
	</table>
	<h2><?php esc_html_e( 'FAQ', 'growtele' ); ?></h2>
	<table class="form-table" role="presentation">
		<?php
		Growtele_Content_Admin::field_textarea( 'growtele_content[company][growtele-io][faq][title]', __( 'FAQ title (HTML)', 'growtele' ), $faq['title'] ?? '' );
		Growtele_Content_Admin::field_textarea( 'growtele_content[company][growtele-io][faq][intro]', __( 'FAQ intro', 'growtele' ), $faq['intro'] ?? '' );
		foreach ( $faq['items'] ?? array() as $i => $item ) :
			Growtele_Content_Admin::field_text(
				'growtele_content[company][growtele-io][faq][items][' . $i . '][question]',
				sprintf( __( 'FAQ question %d', 'growtele' ), $i + 1 ),
				$item['question'] ?? ''
			);
		endforeach;
		?>
	</table>
<?php endif; ?>

<?php $cta = $page['cta'] ?? array(); ?>
<h2><?php esc_html_e( 'Pre-footer CTA', 'growtele' ); ?></h2>
<table class="form-table" role="presentation">
	<?php
	Growtele_Content_Admin::field_textarea( 'growtele_content[company][' . $slug . '][cta][heading]', __( 'CTA heading (HTML)', 'growtele' ), $cta['heading'] ?? '' );
	Growtele_Content_Admin::field_textarea( 'growtele_content[company][' . $slug . '][cta][description]', __( 'CTA description', 'growtele' ), $cta['description'] ?? '' );
	Growtele_Content_Admin::field_text( 'growtele_content[company][' . $slug . '][cta][button_text]', __( 'Button text', 'growtele' ), $cta['button_text'] ?? '' );
	Growtele_Content_Admin::field_text( 'growtele_content[company][' . $slug . '][cta][button_url]', __( 'Button URL (empty = Contact)', 'growtele' ), $cta['button_url'] ?? '', 'url' );
	?>
</table>
<p class="description"><?php esc_html_e( 'Changes apply on WordPress company pages only; static HTML files remain the fallback source.', 'growtele' ); ?></p>
