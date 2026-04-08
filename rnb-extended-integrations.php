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

if ( ! defined( 'RNBEI_VERSION' ) ) {
	define( 'RNBEI_VERSION', '0.1.0' );
}
if ( ! defined( 'RNBEI_PLUGIN_FILE' ) ) {
	define( 'RNBEI_PLUGIN_FILE', __FILE__ );
}
if ( ! defined( 'RNBEI_PLUGIN_PATH' ) ) {
	define( 'RNBEI_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'RNBEI_PLUGIN_URL' ) ) {
	define( 'RNBEI_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

/**
 * Safe include helper for plugin class files.
 *
 * @param string $relative_path Relative path from plugin root.
 * @return bool
 */
function rnbei_require_file( $relative_path ) {
	$file = RNBEI_PLUGIN_PATH . ltrim( $relative_path, '/\\' );
	if ( ! file_exists( $file ) ) {
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			error_log( sprintf( 'RNBEI missing required file: %s', $file ) ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
		}
		return false;
	}

	require_once $file;
	return true;
}

if ( ! rnbei_require_file( 'includes/class-rnbei-helpers.php' ) ) {
	return;
}
if ( ! rnbei_require_file( 'includes/class-rnbei-settings.php' ) ) {
	return;
}
if ( ! rnbei_require_file( 'includes/class-rnbei-locations.php' ) ) {
	return;
}
if ( ! rnbei_require_file( 'includes/class-rnbei-calendar.php' ) ) {
	return;
}

final class RNBEI_Plugin {
	/** @var RNBEI_Plugin|null */
	private static $instance = null;

	/** @var RNBEI_Settings */
	private $settings;

	/** @var RNBEI_Locations */
	private $locations;

	/** @var RNBEI_Calendar */
	private $calendar;

	/** @var string|null */
	private $bootstrap_error = null;

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		add_action( 'plugins_loaded', array( $this, 'boot' ), 30 );
		add_action( 'admin_notices', array( $this, 'maybe_render_dependency_notice' ) );
	}

	public function boot() {
		if ( ! self::is_woocommerce_available() ) {
			$this->bootstrap_error = __( 'RnB Extended Integrations requires WooCommerce to be active.', 'rnb-extended-integrations' );
			return;
		}

		$this->settings  = new RNBEI_Settings();
		$module_enabled  = get_option( 'rnbei_module_enabled', 'yes' );
		if ( 'yes' !== $module_enabled ) {
			return;
		}

		if ( ! self::is_rnb_available() ) {
			$this->bootstrap_error = __( 'RnB Extended Integrations requires WooCommerce Rental and Booking (RnB) to be active.', 'rnb-extended-integrations' );
			return;
		}

		$this->locations = new RNBEI_Locations( $this->settings );
		$this->calendar  = new RNBEI_Calendar( $this->settings );
	}

	/**
	 * Show dependency notice when bootstrap failed.
	 *
	 * @return void
	 */
	public function maybe_render_dependency_notice() {
		if ( ! is_admin() || ! current_user_can( 'activate_plugins' ) || empty( $this->bootstrap_error ) ) {
			return;
		}

		echo '<div class="notice notice-error"><p>' . esc_html( $this->bootstrap_error ) . '</p></div>';
	}

	/**
	 * Activation safety guard to prevent partial activation on missing dependencies.
	 *
	 * @return void
	 */
	public static function on_activation() {
		if ( self::is_woocommerce_available() && self::is_rnb_available() ) {
			return;
		}

		if ( ! function_exists( 'deactivate_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		deactivate_plugins( plugin_basename( RNBEI_PLUGIN_FILE ) );

		wp_die(
			esc_html__( 'RnB Extended Integrations requires both WooCommerce and WooCommerce Rental and Booking (RnB). Please activate those plugins first.', 'rnb-extended-integrations' ),
			esc_html__( 'Plugin dependency check failed', 'rnb-extended-integrations' ),
			array( 'back_link' => true )
		);
	}

	/**
	 * Check WooCommerce availability.
	 *
	 * @return bool
	 */
	private static function is_woocommerce_available() {
		return class_exists( 'WooCommerce' );
	}

	/**
	 * Check RnB availability.
	 *
	 * @return bool
	 */
	private static function is_rnb_available() {
		return class_exists( 'WC_Product_Redq_Rental' ) || function_exists( 'redq_rental_get_settings' );
	}
}

register_activation_hook( RNBEI_PLUGIN_FILE, array( 'RNBEI_Plugin', 'on_activation' ) );
RNBEI_Plugin::instance();
