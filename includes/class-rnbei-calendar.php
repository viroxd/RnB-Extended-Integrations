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

		// Phase 1 scaffold only: disable common/likely native hooks via filters when custom sync is enabled.
		add_filter( 'redq_rental_google_calendar_sync_enabled', array( $this, 'force_disable_native_sync_filter' ) );
		add_filter( 'rnb_google_calendar_sync_enabled', array( $this, 'force_disable_native_sync_filter' ) );
	}

	public function is_custom_calendar_enabled() {
		return 'yes' === get_option( 'rnbei_calendar_enabled', 'no' );
	}

	public function force_disable_native_sync_filter( $enabled ) {
		if ( $this->is_custom_calendar_enabled() ) {
			return false;
		}

		return $enabled;
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
