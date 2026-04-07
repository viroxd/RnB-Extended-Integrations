<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class RNBEI_Locations {
	/** @var RNBEI_Settings */
	private $settings;

	public function __construct( $settings ) {
		$this->settings = $settings;

		add_action( 'woocommerce_before_add_to_cart_button', array( $this, 'render_location_fields' ), 35 );
		add_filter( 'woocommerce_add_to_cart_validation', array( $this, 'validate_location_fields' ), 10, 3 );
		add_filter( 'woocommerce_add_cart_item_data', array( $this, 'add_cart_item_data' ), 10, 3 );
		add_filter( 'woocommerce_get_item_data', array( $this, 'display_cart_item_data' ), 10, 2 );
		add_action( 'woocommerce_checkout_create_order_line_item', array( $this, 'add_order_item_meta' ), 10, 4 );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
	}

	private function is_rental_product( $product_id = 0 ) {
		$product = $product_id ? wc_get_product( $product_id ) : wc_get_product( get_the_ID() );
		if ( ! $product ) {
			return false;
		}

		return 'redq_rental' === $product->get_type();
	}

	public function render_location_fields() {
		global $product;

		if ( ! $product || ! $this->is_rental_product( $product->get_id() ) ) {
			return;
		}

		echo '<div class="rnbei-location-fields" data-rnbei-location-root="1">';
		echo '<p class="form-row form-row-wide">';
		echo '<label for="rnbei_start_location_address">' . esc_html__( 'Start Location', 'rnb-extended-integrations' ) . ' <span class="required">*</span></label>';
		echo '<input type="text" class="input-text rnbei-place-input" name="rnbei_start_location_address" id="rnbei_start_location_address" autocomplete="off" />';
		echo '<input type="hidden" name="rnbei_start_place_id" id="rnbei_start_place_id" />';
		echo '<input type="hidden" name="rnbei_start_lat" id="rnbei_start_lat" />';
		echo '<input type="hidden" name="rnbei_start_lng" id="rnbei_start_lng" />';
		echo '</p>';

		echo '<p class="form-row form-row-wide">';
		echo '<label><input type="checkbox" name="rnbei_end_different" id="rnbei_end_different" value="1" /> ' . esc_html__( 'End at a different location', 'rnb-extended-integrations' ) . '</label>';
		echo '</p>';

		echo '<div class="rnbei-end-location-wrap" hidden>';
		echo '<p class="form-row form-row-wide">';
		echo '<label for="rnbei_end_location_address">' . esc_html__( 'End Location', 'rnb-extended-integrations' ) . '</label>';
		echo '<input type="text" class="input-text rnbei-place-input" name="rnbei_end_location_address" id="rnbei_end_location_address" autocomplete="off" />';
		echo '<input type="hidden" name="rnbei_end_place_id" id="rnbei_end_place_id" />';
		echo '<input type="hidden" name="rnbei_end_lat" id="rnbei_end_lat" />';
		echo '<input type="hidden" name="rnbei_end_lng" id="rnbei_end_lng" />';
		echo '</p>';
		echo '</div>';

		echo '<p class="form-row form-row-wide">';
		echo '<label for="rnbei_delivery_notes">' . esc_html__( 'Delivery Notes (optional)', 'rnb-extended-integrations' ) . '</label>';
		echo '<textarea class="input-text" name="rnbei_delivery_notes" id="rnbei_delivery_notes" rows="2"></textarea>';
		echo '</p>';
		echo '</div>';
	}

	public function validate_location_fields( $passed, $product_id, $qty ) {
		unset( $qty );
		if ( ! $this->is_rental_product( $product_id ) ) {
			return $passed;
		}

		$start_address = RNBEI_Helpers::normalize_text( wp_unslash( $_POST['rnbei_start_location_address'] ?? '' ) );
		if ( '' === $start_address ) {
			wc_add_notice( __( 'Please enter a Start Location.', 'rnb-extended-integrations' ), 'error' );
			return false;
		}

		$end_different = ! empty( $_POST['rnbei_end_different'] );
		$end_address   = RNBEI_Helpers::normalize_text( wp_unslash( $_POST['rnbei_end_location_address'] ?? '' ) );
		if ( $end_different && '' === $end_address ) {
			wc_add_notice( __( 'Please enter an End Location or uncheck “End at a different location”.', 'rnb-extended-integrations' ), 'error' );
			return false;
		}

		return $passed;
	}

	public function add_cart_item_data( $cart_item_data, $product_id, $variation_id ) {
		unset( $variation_id );
		if ( ! $this->is_rental_product( $product_id ) ) {
			return $cart_item_data;
		}

		$location_data = array(
			'start_address' => RNBEI_Helpers::normalize_text( wp_unslash( $_POST['rnbei_start_location_address'] ?? '' ) ),
			'start_place_id'=> RNBEI_Helpers::normalize_text( wp_unslash( $_POST['rnbei_start_place_id'] ?? '' ) ),
			'start_lat'     => RNBEI_Helpers::normalize_lat_lng( wp_unslash( $_POST['rnbei_start_lat'] ?? '' ), wp_unslash( $_POST['rnbei_start_lng'] ?? '' ) )['lat'],
			'start_lng'     => RNBEI_Helpers::normalize_lat_lng( wp_unslash( $_POST['rnbei_start_lat'] ?? '' ), wp_unslash( $_POST['rnbei_start_lng'] ?? '' ) )['lng'],
			'end_different' => ! empty( $_POST['rnbei_end_different'] ) ? 'yes' : 'no',
			'end_address'   => RNBEI_Helpers::normalize_text( wp_unslash( $_POST['rnbei_end_location_address'] ?? '' ) ),
			'end_place_id'  => RNBEI_Helpers::normalize_text( wp_unslash( $_POST['rnbei_end_place_id'] ?? '' ) ),
			'end_lat'       => RNBEI_Helpers::normalize_lat_lng( wp_unslash( $_POST['rnbei_end_lat'] ?? '' ), wp_unslash( $_POST['rnbei_end_lng'] ?? '' ) )['lat'],
			'end_lng'       => RNBEI_Helpers::normalize_lat_lng( wp_unslash( $_POST['rnbei_end_lat'] ?? '' ), wp_unslash( $_POST['rnbei_end_lng'] ?? '' ) )['lng'],
			'delivery_notes'=> RNBEI_Helpers::normalize_text( wp_unslash( $_POST['rnbei_delivery_notes'] ?? '' ) ),
		);

		$cart_item_data['rnbei_location_data'] = $location_data;
		$cart_item_data['rnbei_unique_key']    = md5( wp_json_encode( $location_data ) . microtime() );

		return $cart_item_data;
	}

	public function display_cart_item_data( $item_data, $cart_item ) {
		if ( empty( $cart_item['rnbei_location_data'] ) || ! is_array( $cart_item['rnbei_location_data'] ) ) {
			return $item_data;
		}

		$data = $cart_item['rnbei_location_data'];

		if ( ! empty( $data['start_address'] ) ) {
			$item_data[] = array(
				'name'  => __( 'Start Location', 'rnb-extended-integrations' ),
				'value' => wc_clean( $data['start_address'] ),
			);
		}

		if ( RNBEI_Helpers::has_different_end_location( $data ) && ! empty( $data['end_address'] ) ) {
			$item_data[] = array(
				'name'  => __( 'End Location', 'rnb-extended-integrations' ),
				'value' => wc_clean( $data['end_address'] ),
			);
		}

		if ( ! empty( $data['delivery_notes'] ) ) {
			$item_data[] = array(
				'name'  => __( 'Delivery Notes', 'rnb-extended-integrations' ),
				'value' => wc_clean( $data['delivery_notes'] ),
			);
		}

		return $item_data;
	}

	public function add_order_item_meta( $item, $cart_item_key, $values, $order ) {
		unset( $cart_item_key, $order );
		if ( empty( $values['rnbei_location_data'] ) || ! is_array( $values['rnbei_location_data'] ) ) {
			return;
		}

		$data = $values['rnbei_location_data'];

		if ( ! empty( $data['start_address'] ) ) {
			$item->add_meta_data( __( 'Start Location', 'rnb-extended-integrations' ), $data['start_address'], true );
		}
		if ( ! empty( $data['start_place_id'] ) ) {
			$item->add_meta_data( '_rnbei_start_place_id', $data['start_place_id'], true );
		}
		if ( ! empty( $data['start_lat'] ) || ! empty( $data['start_lng'] ) ) {
			$item->add_meta_data( '_rnbei_start_lat', $data['start_lat'], true );
			$item->add_meta_data( '_rnbei_start_lng', $data['start_lng'], true );
		}

		if ( RNBEI_Helpers::has_different_end_location( $data ) && ! empty( $data['end_address'] ) ) {
			$item->add_meta_data( __( 'End Location', 'rnb-extended-integrations' ), $data['end_address'], true );
		}

		$item->add_meta_data( '_rnbei_end_different', ! empty( $data['end_different'] ) ? $data['end_different'] : 'no', true );

		if ( ! empty( $data['end_place_id'] ) ) {
			$item->add_meta_data( '_rnbei_end_place_id', $data['end_place_id'], true );
		}
		if ( ! empty( $data['end_lat'] ) || ! empty( $data['end_lng'] ) ) {
			$item->add_meta_data( '_rnbei_end_lat', $data['end_lat'], true );
			$item->add_meta_data( '_rnbei_end_lng', $data['end_lng'], true );
		}

		if ( ! empty( $data['delivery_notes'] ) ) {
			$item->add_meta_data( __( 'Delivery Notes', 'rnb-extended-integrations' ), $data['delivery_notes'], true );
		}
	}

	public function enqueue_assets() {
		if ( ! function_exists( 'is_product' ) || ! is_product() || ! $this->is_rental_product() ) {
			return;
		}

		wp_enqueue_style(
			'rnbei-locations',
			RNBEI_PLUGIN_URL . 'assets/css/frontend-locations.css',
			array(),
			RNBEI_VERSION
		);

		wp_enqueue_script(
			'rnbei-locations',
			RNBEI_PLUGIN_URL . 'assets/js/frontend-locations.js',
			array( 'jquery' ),
			RNBEI_VERSION,
			true
		);

		$maps_key = get_option( 'rnbei_google_maps_api_key', '' );
		$maps_key = is_string( $maps_key ) ? trim( $maps_key ) : '';
		if ( '' !== $maps_key ) {
			$src = add_query_arg(
				array(
					'key'       => $maps_key,
					'libraries' => 'places',
					'callback'  => 'rnbeiInitPlaces',
				),
				'https://maps.googleapis.com/maps/api/js'
			);
			wp_enqueue_script( 'rnbei-google-maps-places', $src, array(), RNBEI_VERSION, true );
		}
	}
}
