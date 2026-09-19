<?php
/**
 * Home tab fields for Growtele Content admin.
 *
 * @package Growtele
 * @var array $content Merged CMS content.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$home     = $content['home'] ?? array();
$home_sec = isset( $_GET['home_sec'] ) ? sanitize_key( wp_unslash( $_GET['home_sec'] ) ) : 'hero'; // phpcs:ignore WordPress.Security.NonceVerification
$sections = array(
	'hero'         => __( 'Hero', 'growtele' ),
	'outcomes'     => __( 'Outcomes', 'growtele' ),
	'industries'   => __( 'Industries', 'growtele' ),
	'channels'     => __( 'Channels', 'growtele' ),
	'case_studies' => __( 'Case studies', 'growtele' ),
	'enterprise'   => __( 'Enterprise', 'growtele' ),
	'integrations' => __( 'Integrations', 'growtele' ),
);
if ( ! isset( $sections[ $home_sec ] ) ) {
	$home_sec = 'hero';
}
$home_base = admin_url( 'themes.php?page=' . Growtele_Content_Admin::PAGE_SLUG . '&tab=home' );
?>
<nav class="nav-tab-wrapper growtele-content-admin__subnav">
	<?php foreach ( $sections as $key => $label ) : ?>
		<a href="<?php echo esc_url( add_query_arg( 'home_sec', $key, $home_base ) ); ?>" class="nav-tab <?php echo $home_sec === $key ? 'nav-tab-active' : ''; ?>"><?php echo esc_html( $label ); ?></a>
	<?php endforeach; ?>
</nav>

<?php if ( 'hero' === $home_sec ) : ?>
	<?php $hero = $home['hero'] ?? array(); ?>
	<table class="form-table" role="presentation">
		<?php
		Growtele_Content_Admin::field_media( 'growtele_content[home][hero][video]', __( 'Background video', 'growtele' ), $hero['video'] ?? array() );
		Growtele_Content_Admin::field_text( 'growtele_content[home][hero][badge_text]', __( 'Badge text', 'growtele' ), $hero['badge_text'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[home][hero][badge_strong]', __( 'Badge emphasis', 'growtele' ), $hero['badge_strong'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[home][hero][title_line_1]', __( 'Title line 1', 'growtele' ), $hero['title_line_1'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[home][hero][title_line_2]', __( 'Title line 2', 'growtele' ), $hero['title_line_2'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[home][hero][subtitle_line_1]', __( 'Subtitle line 1', 'growtele' ), $hero['subtitle_line_1'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[home][hero][subtitle_line_2]', __( 'Subtitle line 2', 'growtele' ), $hero['subtitle_line_2'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[home][hero][trust_label]', __( 'Trust strip label', 'growtele' ), $hero['trust_label'] ?? '' );
		$features = $hero['features'] ?? array();
		foreach ( $features as $i => $feature ) :
			Growtele_Content_Admin::field_text(
				'growtele_content[home][hero][features][' . $i . '][label]',
				sprintf( __( 'Feature %d label', 'growtele' ), $i + 1 ),
				$feature['label'] ?? ''
			);
		endforeach;
		?>
	</table>
<?php elseif ( 'outcomes' === $home_sec ) : ?>
	<?php $out = $home['outcomes'] ?? array(); ?>
	<table class="form-table" role="presentation">
		<?php
		Growtele_Content_Admin::field_textarea( 'growtele_content[home][outcomes][heading_title]', __( 'Section title (HTML: &lt;br&gt; allowed)', 'growtele' ), $out['heading_title'] ?? '' );
		Growtele_Content_Admin::field_textarea( 'growtele_content[home][outcomes][heading_desc]', __( 'Section description', 'growtele' ), $out['heading_desc'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[home][outcomes][card_title]', __( 'Card title', 'growtele' ), $out['card_title'] ?? '' );
		Growtele_Content_Admin::field_textarea( 'growtele_content[home][outcomes][card_desc]', __( 'Card description', 'growtele' ), $out['card_desc'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[home][outcomes][stat_1][counter]', __( 'Stat 1 counter', 'growtele' ), $out['stat_1']['counter'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[home][outcomes][stat_1][suffix]', __( 'Stat 1 suffix', 'growtele' ), $out['stat_1']['suffix'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[home][outcomes][stat_1][label]', __( 'Stat 1 label', 'growtele' ), $out['stat_1']['label'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[home][outcomes][stat_2][counter]', __( 'Stat 2 counter', 'growtele' ), $out['stat_2']['counter'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[home][outcomes][stat_2][suffix]', __( 'Stat 2 suffix', 'growtele' ), $out['stat_2']['suffix'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[home][outcomes][stat_2][label]', __( 'Stat 2 label', 'growtele' ), $out['stat_2']['label'] ?? '' );
		Growtele_Content_Admin::field_media( 'growtele_content[home][outcomes][video]', __( 'Side video', 'growtele' ), $out['video'] ?? array() );
		?>
	</table>
<?php elseif ( 'industries' === $home_sec ) : ?>
	<?php $ind = $home['industries'] ?? array(); ?>
	<table class="form-table" role="presentation">
		<?php
		Growtele_Content_Admin::field_text( 'growtele_content[home][industries][heading_title]', __( 'Section title', 'growtele' ), $ind['heading_title'] ?? '' );
		Growtele_Content_Admin::field_textarea( 'growtele_content[home][industries][heading_desc]', __( 'Section description', 'growtele' ), $ind['heading_desc'] ?? '' );
		$items = $ind['items'] ?? array();
		foreach ( $items as $key => $item ) :
			?>
			<tr><th colspan="2"><h3><?php echo esc_html( $key ); ?></h3></th></tr>
			<?php
			Growtele_Content_Admin::field_text(
				'growtele_content[home][industries][items][' . $key . '][label]',
				__( 'Tab label', 'growtele' ),
				$item['label'] ?? ''
			);
			Growtele_Content_Admin::field_textarea(
				'growtele_content[home][industries][items][' . $key . '][desc]',
				__( 'Panel description', 'growtele' ),
				$item['desc'] ?? ''
			);
		endforeach;
		?>
	</table>
<?php elseif ( 'channels' === $home_sec ) : ?>
	<?php $ch = $home['channels'] ?? array(); ?>
	<table class="form-table" role="presentation">
		<?php
		Growtele_Content_Admin::field_text( 'growtele_content[home][channels][heading_title]', __( 'Section title', 'growtele' ), $ch['heading_title'] ?? '' );
		Growtele_Content_Admin::field_textarea( 'growtele_content[home][channels][heading_desc]', __( 'Section description', 'growtele' ), $ch['heading_desc'] ?? '' );
		foreach ( $ch['items'] ?? array() as $i => $item ) :
			?>
			<tr><th colspan="2"><h3><?php echo esc_html( $item['label'] ?? ( 'Card ' . ( $i + 1 ) ) ); ?></h3></th></tr>
			<?php
			Growtele_Content_Admin::field_text( 'growtele_content[home][channels][items][' . $i . '][label]', __( 'Card title', 'growtele' ), $item['label'] ?? '' );
			Growtele_Content_Admin::field_textarea( 'growtele_content[home][channels][items][' . $i . '][desc]', __( 'Card description', 'growtele' ), $item['desc'] ?? '' );
		endforeach;
		?>
	</table>
<?php elseif ( 'case_studies' === $home_sec ) : ?>
	<?php $cs = $home['case_studies'] ?? array(); ?>
	<table class="form-table" role="presentation">
		<?php
		Growtele_Content_Admin::field_text( 'growtele_content[home][case_studies][heading_title]', __( 'Section title', 'growtele' ), $cs['heading_title'] ?? '' );
		Growtele_Content_Admin::field_textarea( 'growtele_content[home][case_studies][heading_desc]', __( 'Section description', 'growtele' ), $cs['heading_desc'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[home][case_studies][read_button_text]', __( 'Read case study button text', 'growtele' ), $cs['read_button_text'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[home][case_studies][read_button_url]', __( 'Read case study button URL', 'growtele' ), $cs['read_button_url'] ?? '', 'url' );
		foreach ( $cs['items'] ?? array() as $i => $study ) :
			?>
			<tr><th colspan="2"><h3><?php echo esc_html( $study['name'] ?? ( 'Case ' . ( $i + 1 ) ) ); ?></h3></th></tr>
			<?php
			Growtele_Content_Admin::field_text( 'growtele_content[home][case_studies][items][' . $i . '][name]', __( 'Name', 'growtele' ), $study['name'] ?? '' );
			Growtele_Content_Admin::field_text( 'growtele_content[home][case_studies][items][' . $i . '][category]', __( 'Category', 'growtele' ), $study['category'] ?? '' );
			Growtele_Content_Admin::field_textarea( 'growtele_content[home][case_studies][items][' . $i . '][desc]', __( 'Description', 'growtele' ), $study['desc'] ?? '' );
			Growtele_Content_Admin::field_textarea( 'growtele_content[home][case_studies][items][' . $i . '][quote]', __( 'Quote', 'growtele' ), $study['quote'] ?? '' );
			Growtele_Content_Admin::field_text( 'growtele_content[home][case_studies][items][' . $i . '][author]', __( 'Author', 'growtele' ), $study['author'] ?? '' );
			Growtele_Content_Admin::field_text( 'growtele_content[home][case_studies][items][' . $i . '][role]', __( 'Role', 'growtele' ), $study['role'] ?? '' );
		endforeach;
		?>
	</table>
<?php elseif ( 'enterprise' === $home_sec ) : ?>
	<?php $ent = $home['enterprise'] ?? array(); $cards = $ent['cards'] ?? array(); ?>
	<table class="form-table" role="presentation">
		<?php
		Growtele_Content_Admin::field_text( 'growtele_content[home][enterprise][heading_title]', __( 'Section title', 'growtele' ), $ent['heading_title'] ?? '' );
		Growtele_Content_Admin::field_textarea( 'growtele_content[home][enterprise][heading_desc]', __( 'Section description', 'growtele' ), $ent['heading_desc'] ?? '' );
		foreach ( array( 'clients', 'messages', 'uptime', 'support' ) as $card_key ) :
			$card = $cards[ $card_key ] ?? array();
			?>
			<tr><th colspan="2"><h3><?php echo esc_html( ucfirst( $card_key ) ); ?></h3></th></tr>
			<?php
			Growtele_Content_Admin::field_text( 'growtele_content[home][enterprise][cards][' . $card_key . '][counter]', __( 'Counter value', 'growtele' ), $card['counter'] ?? '' );
			if ( 'support' === $card_key ) {
				Growtele_Content_Admin::field_text( 'growtele_content[home][enterprise][cards][support][counter_secondary]', __( 'Secondary counter (e.g. 7 in 24/7)', 'growtele' ), $card['counter_secondary'] ?? '' );
			}
			Growtele_Content_Admin::field_text( 'growtele_content[home][enterprise][cards][' . $card_key . '][suffix]', __( 'Suffix', 'growtele' ), $card['suffix'] ?? '' );
			if ( 'uptime' === $card_key ) {
				Growtele_Content_Admin::field_text( 'growtele_content[home][enterprise][cards][uptime][decimals]', __( 'Decimal places', 'growtele' ), $card['decimals'] ?? '' );
			}
			Growtele_Content_Admin::field_text( 'growtele_content[home][enterprise][cards][' . $card_key . '][title]', __( 'Card title', 'growtele' ), $card['title'] ?? '' );
			Growtele_Content_Admin::field_textarea( 'growtele_content[home][enterprise][cards][' . $card_key . '][desc]', __( 'Card description', 'growtele' ), $card['desc'] ?? '' );
		endforeach;
		Growtele_Content_Admin::field_media( 'growtele_content[home][enterprise][bg_image]', __( 'Background image', 'growtele' ), $ent['bg_image'] ?? array() );
		?>
	</table>
<?php else : ?>
	<?php $int = $home['integrations'] ?? array(); ?>
	<table class="form-table" role="presentation">
		<?php
		Growtele_Content_Admin::field_text( 'growtele_content[home][integrations][title]', __( 'Title', 'growtele' ), $int['title'] ?? '' );
		Growtele_Content_Admin::field_textarea( 'growtele_content[home][integrations][description]', __( 'Description', 'growtele' ), $int['description'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[home][integrations][button_text]', __( 'Button text', 'growtele' ), $int['button_text'] ?? '' );
		Growtele_Content_Admin::field_text( 'growtele_content[home][integrations][button_url]', __( 'Button URL', 'growtele' ), $int['button_url'] ?? '', 'url' );
		Growtele_Content_Admin::field_media( 'growtele_content[home][integrations][bg_image]', __( 'Background image', 'growtele' ), $int['bg_image'] ?? array() );
		?>
	</table>
	<p class="description"><?php esc_html_e( 'Integration orbit logos remain theme assets until Phase 7.', 'growtele' ); ?></p>
<?php endif; ?>
