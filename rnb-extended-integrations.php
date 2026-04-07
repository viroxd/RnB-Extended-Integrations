<?php
/**
 * Plugin Name: RnB Extended Integrations
 * Description: General-purpose extension framework for WooCommerce Rental and Booking (RnB), including per-item Google Places locations and optional custom calendar integration scaffolding.
 * Version: 0.1.0
 * Author: RnB Extended Integrations
 * Requires Plugins: woocommerce
 * Text Domain: rnb-extended-integrations
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'RNBEI_VERSION', '0.1.0' );
define( 'RNBEI_PLUGIN_FILE', __FILE__ );
define( 'RNBEI_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'RNBEI_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once RNBEI_PLUGIN_PATH . 'includes/class-rnbei-helpers.php';
require_once RNBEI_PLUGIN_PATH . 'includes/class-rnbei-settings.php';
require_once RNBEI_PLUGIN_PATH . 'includes/class-rnbei-locations.php';
require_once RNBEI_PLUGIN_PATH . 'includes/class-rnbei-calendar.php';

final class RNBEI_Plugin {
	/** @var RNBEI_Plugin|null */
	private static $instance = null;

	/** @var RNBEI_Settings */
	private $settings;

	/** @var RNBEI_Locations */
	private $locations;

	/** @var RNBEI_Calendar */
	private $calendar;

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		add_action( 'plugins_loaded', array( $this, 'boot' ), 20 );
	}

	public function boot() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		$this->settings  = new RNBEI_Settings();
		$this->locations = new RNBEI_Locations( $this->settings );
		$this->calendar  = new RNBEI_Calendar( $this->settings );
	}
}

RNBEI_Plugin::instance();
