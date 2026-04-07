<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class RNBEI_Settings {
	const SECTION_ID = 'rnbei';

	public function __construct() {
		add_filter( 'woocommerce_get_sections_integration', array( $this, 'add_integration_section' ) );
		add_filter( 'woocommerce_get_settings_integration', array( $this, 'add_settings' ), 10, 2 );
		add_action( 'woocommerce_admin_field_rnbei_import_button', array( $this, 'render_import_button' ) );

		add_action( 'admin_init', array( $this, 'maybe_import_rnb_settings' ) );
		add_action( 'admin_notices', array( $this, 'maybe_show_import_notice' ) );
	}

	public function get_option( $key, $default = '' ) {
		return get_option( $key, $default );
	}

	public function add_integration_section( $sections ) {
		$sections[ self::SECTION_ID ] = __( 'RnB Extended Integrations', 'rnb-extended-integrations' );
		return $sections;
	}

	public function add_settings( $settings, $current_section ) {
		if ( self::SECTION_ID !== $current_section ) {
			return $settings;
		}

		$settings = array(
			array(
				'name' => __( 'RnB Extended Integrations', 'rnb-extended-integrations' ),
				'type' => 'title',
				'desc' => __( 'Settings for location capture and optional calendar replacement scaffolding.', 'rnb-extended-integrations' ),
				'id'   => 'rnbei_settings_title',
			),
			array(
				'title'   => __( 'Google Maps API Key', 'rnb-extended-integrations' ),
				'desc'    => __( 'Used for Google Places autocomplete on rental products.', 'rnb-extended-integrations' ),
				'id'      => 'rnbei_google_maps_api_key',
				'type'    => 'text',
				'default' => '',
			),
			array(
				'title'   => __( 'Enable Custom Calendar Sync', 'rnb-extended-integrations' ),
				'desc'    => __( 'Phase 1 scaffold only: full custom sync is not yet implemented.', 'rnb-extended-integrations' ),
				'id'      => 'rnbei_calendar_enabled',
				'type'    => 'checkbox',
				'default' => 'no',
			),
			array(
				'title'   => __( 'Google Calendar Client ID', 'rnb-extended-integrations' ),
				'id'      => 'rnbei_calendar_client_id',
				'type'    => 'text',
				'default' => '',
			),
			array(
				'title'   => __( 'Google Calendar Client Secret', 'rnb-extended-integrations' ),
				'id'      => 'rnbei_calendar_client_secret',
				'type'    => 'password',
				'default' => '',
			),
			array(
				'title'   => __( 'Google Calendar ID', 'rnb-extended-integrations' ),
				'id'      => 'rnbei_calendar_id',
				'type'    => 'text',
				'default' => '',
			),
			array(
				'title'   => __( 'Debug Logging', 'rnb-extended-integrations' ),
				'id'      => 'rnbei_debug_logging',
				'type'    => 'checkbox',
				'default' => 'no',
			),
			array(
				'title' => __( 'Import Existing RnB Calendar Settings', 'rnb-extended-integrations' ),
				'id'    => 'rnbei_import_button',
				'type'  => 'rnbei_import_button',
			),
			array(
				'type' => 'sectionend',
				'id'   => 'rnbei_settings_title',
			),
		);

		return apply_filters( 'rnbei_integration_settings', $settings );
	}

	public function render_import_button() {
		$import_url = wp_nonce_url(
			add_query_arg(
				array(
					'page'             => 'wc-settings',
					'tab'              => 'integration',
					'section'          => self::SECTION_ID,
					'rnbei_import_rnb' => '1',
				),
				admin_url( 'admin.php' )
			),
			'rnbei_import_rnb_settings'
		);
		?>
		<tr valign="top">
			<th scope="row" class="titledesc"><label><?php esc_html_e( 'Import from native RnB', 'rnb-extended-integrations' ); ?></label></th>
			<td class="forminp">
				<a class="button" href="<?php echo esc_url( $import_url ); ?>"><?php esc_html_e( 'Import RnB Calendar Settings', 'rnb-extended-integrations' ); ?></a>
				<p class="description"><?php esc_html_e( 'Copies known native RnB Google settings into this plugin when available.', 'rnb-extended-integrations' ); ?></p>
			</td>
		</tr>
		<?php
	}

	public function maybe_import_rnb_settings() {
		if ( ! is_admin() || ! current_user_can( 'manage_woocommerce' ) ) {
			return;
		}
		if ( empty( $_GET['rnbei_import_rnb'] ) || '1' !== $_GET['rnbei_import_rnb'] ) {
			return;
		}
		check_admin_referer( 'rnbei_import_rnb_settings' );

		$map = array(
			'rnbei_calendar_client_id'     => array( 'redq_rental_google_calendar_client_id' ),
			'rnbei_calendar_client_secret' => array( 'redq_rental_google_calendar_client_secret' ),
			'rnbei_calendar_id'            => array( 'redq_rental_google_calendar_calendar_id' ),
			'rnbei_calendar_enabled'       => array( 'redq_rental_google_calendar_enable_auto_sync' ),
		);

		$imported = 0;
		foreach ( $map as $target => $candidates ) {
			foreach ( $candidates as $candidate ) {
				$value = get_option( $candidate, null );
				if ( null !== $value && '' !== $value ) {
					update_option( $target, $value );
					$imported++;
					break;
				}
			}
		}

		$redirect = add_query_arg(
			array(
				'page'     => 'wc-settings',
				'tab'      => 'integration',
				'section'  => self::SECTION_ID,
				'rnbei_im' => (string) $imported,
			),
			admin_url( 'admin.php' )
		);
		wp_safe_redirect( $redirect );
		exit;
	}

	public function maybe_show_import_notice() {
		if ( ! is_admin() || ! current_user_can( 'manage_woocommerce' ) || ! isset( $_GET['rnbei_im'] ) ) {
			return;
		}
		$imported = absint( wp_unslash( $_GET['rnbei_im'] ) );
		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html( sprintf( __( 'RnB import completed. %d setting(s) copied.', 'rnb-extended-integrations' ), $imported ) ) . '</p></div>';
	}
}
