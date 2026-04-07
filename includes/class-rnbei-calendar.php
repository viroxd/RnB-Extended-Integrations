<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class RNBEI_Calendar {
	/** @var RNBEI_Settings */
	private $settings;

	public function __construct( $settings ) {
		$this->settings = $settings;

		add_action( 'admin_notices', array( $this, 'maybe_show_native_sync_notice' ) );
		add_action( 'admin_init', array( $this, 'maybe_disable_native_auto_sync' ) );
	}

	public function is_custom_calendar_enabled() {
		return 'yes' === get_option( 'rnbei_calendar_enabled', 'no' );
	}

	/**
	 * Suppress native RnB Google Calendar auto sync when custom mode is enabled.
	 *
	 * Uses real upstream setting key:
	 * redq_rental_google_calendar_enable_auto_sync
	 *
	 * @return void
	 */
	public function maybe_disable_native_auto_sync() {
		if ( ! is_admin() || ! current_user_can( 'manage_woocommerce' ) ) {
			return;
		}

		if ( ! $this->is_custom_calendar_enabled() ) {
			return;
		}

		if ( 'no' !== get_option( 'redq_rental_google_calendar_enable_auto_sync', 'no' ) ) {
			update_option( 'redq_rental_google_calendar_enable_auto_sync', 'no' );
		}
	}

	public function maybe_show_native_sync_notice() {
		if ( ! current_user_can( 'manage_woocommerce' ) || ! $this->is_custom_calendar_enabled() ) {
			return;
		}

		echo '<div class="notice notice-warning is-dismissible"><p>';
		echo esc_html__( 'RnB Extended Integrations custom calendar mode is enabled. Native RnB Google Calendar sync is expected to remain inactive.', 'rnb-extended-integrations' );
		echo '</p></div>';
	}
}
