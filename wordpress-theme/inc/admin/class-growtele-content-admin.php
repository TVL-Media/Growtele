<?php
/**
 * Appearance → Growtele Content admin page.
 *
 * @package Growtele
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin UI for Growtele CMS.
 */
class Growtele_Content_Admin {

	const PAGE_SLUG = 'growtele-content';

	/**
	 * Hook admin.
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'register_menu' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ) );
	}

	/**
	 * Register under Appearance.
	 */
	public static function register_menu() {
		add_theme_page(
			__( 'Growtele Content', 'growtele' ),
			__( 'Growtele Content', 'growtele' ),
			'edit_theme_options',
			self::PAGE_SLUG,
			array( __CLASS__, 'render_page' )
		);
	}

	/**
	 * Enqueue admin assets on our page only.
	 *
	 * @param string $hook Hook suffix.
	 */
	public static function enqueue_assets( $hook ) {
		if ( 'appearance_page_' . self::PAGE_SLUG !== $hook ) {
			return;
		}

		wp_enqueue_media();
		wp_enqueue_style(
			'growtele-content-admin',
			GROWTELE_URI . '/assets/admin/growtele-content-admin.css',
			array(),
			GROWTELE_VERSION
		);
		wp_enqueue_script(
			'growtele-content-admin',
			GROWTELE_URI . '/assets/admin/growtele-content-admin.js',
			array( 'jquery' ),
			GROWTELE_VERSION,
			true
		);
	}

	/**
	 * Handle save / reset and render.
	 */
	public static function render_page() {
		if ( ! current_user_can( 'edit_theme_options' ) ) {
			wp_die( esc_html__( 'You do not have permission to access this page.', 'growtele' ) );
		}

		$notice = '';

		if ( isset( $_POST['growtele_content_reset'] ) ) {
			check_admin_referer( 'growtele_content_save' );
			growtele_content_reset_to_defaults();
			$notice = 'reset';
		} elseif ( isset( $_POST['growtele_content_save'] ) ) {
			check_admin_referer( 'growtele_content_save' );
			$raw = isset( $_POST['growtele_content'] ) ? wp_unslash( $_POST['growtele_content'] ) : array(); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
			growtele_content_save_from_post( $raw );
			$notice = 'saved';
		}

		$content = growtele_content_get_merged();
		$tab     = isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : 'global'; // phpcs:ignore WordPress.Security.NonceVerification

		require GROWTELE_DIR . '/inc/admin/views/content-page.php';
	}

	/**
	 * Render a text input bound to nested name.
	 *
	 * @param string $name  Field name prefix e.g. global[header][cta_text].
	 * @param string $label Label.
	 * @param mixed  $value Value.
	 * @param string $type  Input type.
	 */
	/**
	 * Render a textarea field.
	 *
	 * @param string $name  Field name.
	 * @param string $label Label.
	 * @param mixed  $value Value.
	 */
	public static function field_textarea( $name, $label, $value ) {
		?>
		<tr>
			<th scope="row"><label for="<?php echo esc_attr( $name ); ?>"><?php echo esc_html( $label ); ?></label></th>
			<td>
				<textarea class="large-text" rows="4" id="<?php echo esc_attr( $name ); ?>" name="<?php echo esc_attr( $name ); ?>"><?php echo esc_textarea( is_scalar( $value ) ? $value : '' ); ?></textarea>
			</td>
		</tr>
		<?php
	}

	public static function field_text( $name, $label, $value, $type = 'text' ) {
		?>
		<tr>
			<th scope="row"><label for="<?php echo esc_attr( $name ); ?>"><?php echo esc_html( $label ); ?></label></th>
			<td>
				<input
					class="regular-text"
					type="<?php echo esc_attr( $type ); ?>"
					id="<?php echo esc_attr( $name ); ?>"
					name="<?php echo esc_attr( $name ); ?>"
					value="<?php echo esc_attr( is_scalar( $value ) ? $value : '' ); ?>"
				/>
			</td>
		</tr>
		<?php
	}

	/**
	 * Render media picker field.
	 *
	 * @param string $name_prefix Name prefix without attachment_id suffix.
	 * @param string $label       Label.
	 * @param array  $field       Media field array.
	 */
	public static function field_media( $name_prefix, $label, $field ) {
		$attachment_id = absint( $field['attachment_id'] ?? 0 );
		$url           = $attachment_id ? wp_get_attachment_url( $attachment_id ) : '';
		if ( ! $url && ! empty( $field['url'] ) ) {
			$url = $field['url'];
		}
		if ( ! $url && ! empty( $field['fallback'] ) ) {
			$url = function_exists( 'growtele_cms_fallback_url' ) ? growtele_cms_fallback_url( $field['fallback'] ) : $field['fallback'];
		}
		$id_attr = str_replace( array( '[', ']' ), array( '-', '' ), $name_prefix );
		?>
		<tr>
			<th scope="row"><?php echo esc_html( $label ); ?></th>
			<td>
				<div class="growtele-media-field" data-growtele-media>
					<input type="hidden" name="<?php echo esc_attr( $name_prefix ); ?>[attachment_id]" value="<?php echo esc_attr( $attachment_id ); ?>" data-attachment-id />
					<div class="growtele-media-field__preview">
						<?php if ( $url ) : ?>
							<img src="<?php echo esc_url( $url ); ?>" alt="" style="max-width:120px;height:auto;" />
						<?php endif; ?>
					</div>
					<p>
						<button type="button" class="button" data-growtele-media-select><?php esc_html_e( 'Select from Media Library', 'growtele' ); ?></button>
						<button type="button" class="button-link-delete" data-growtele-media-clear><?php esc_html_e( 'Use theme default', 'growtele' ); ?></button>
					</p>
					<p class="description"><?php esc_html_e( 'Leave unset to use the original theme asset.', 'growtele' ); ?></p>
				</div>
			</td>
		</tr>
		<?php
	}
}
