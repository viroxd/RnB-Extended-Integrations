<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class RNBEI_Helpers {
	/**
	 * Normalize scalar text for comparison and safe display.
	 *
	 * @param string $value Raw value.
	 * @return string
	 */
	public static function normalize_text( $value ) {
		$value = is_scalar( $value ) ? (string) $value : '';
		$value = wp_strip_all_tags( $value );
		$value = trim( preg_replace( '/\s+/', ' ', $value ) );

		return $value;
	}

	/**
	 * Normalize checkbox-like values into "yes"/"no".
	 *
	 * @param mixed $value Raw toggle value.
	 * @return string
	 */
	public static function normalize_yes_no( $value ) {
		if ( is_bool( $value ) ) {
			return $value ? 'yes' : 'no';
		}

		$value = self::normalize_text( $value );
		$value = strtolower( $value );

		return in_array( $value, array( '1', 'true', 'yes', 'on' ), true ) ? 'yes' : 'no';
	}

	/**
	 * Return normalized coordinate pair if valid.
	 *
	 * @param mixed $lat Latitude.
	 * @param mixed $lng Longitude.
	 * @return array{lat:string,lng:string}
	 */
	public static function normalize_lat_lng( $lat, $lng ) {
		$lat = is_scalar( $lat ) ? trim( (string) $lat ) : '';
		$lng = is_scalar( $lng ) ? trim( (string) $lng ) : '';

		$lat = preg_match( '/^-?\d{1,3}(?:\.\d+)?$/', $lat ) ? $lat : '';
		$lng = preg_match( '/^-?\d{1,3}(?:\.\d+)?$/', $lng ) ? $lng : '';

		return array(
			'lat' => $lat,
			'lng' => $lng,
		);
	}

	/**
	 * Checks whether end location should be treated as different.
	 *
	 * @param array<string,mixed> $location_data Structured location payload.
	 * @return bool
	 */
	public static function has_different_end_location( array $location_data ) {
		$toggle = self::normalize_yes_no( $location_data['end_different'] ?? 'no' );
		if ( 'yes' !== $toggle ) {
			return false;
		}

		$start_address = self::normalize_text( $location_data['start_address'] ?? '' );
		$end_address   = self::normalize_text( $location_data['end_address'] ?? '' );

		$start_place_id = self::normalize_text( $location_data['start_place_id'] ?? '' );
		$end_place_id   = self::normalize_text( $location_data['end_place_id'] ?? '' );

		if ( '' !== $start_place_id && '' !== $end_place_id ) {
			return $start_place_id !== $end_place_id;
		}

		if ( '' !== $start_address && '' !== $end_address ) {
			return strtolower( $start_address ) !== strtolower( $end_address );
		}

		return '' !== $end_address;
	}

	/**
	 * Build Google Maps link for an address string.
	 *
	 * @param string $address Address text.
	 * @return string
	 */
	public static function maps_link( $address ) {
		$address = self::normalize_text( $address );
		if ( '' === $address ) {
			return '';
		}

		return 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $address );
	}
}
