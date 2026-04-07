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
	 * Return normalized coordinate pair if valid.
	 *
	 * @param mixed $lat Latitude.
	 * @param mixed $lng Longitude.
	 * @return array{lat:string,lng:string}
	 */
	public static function normalize_lat_lng( $lat, $lng ) {
		$lat = is_scalar( $lat ) ? trim( (string) $lat ) : '';
		$lng = is_scalar( $lng ) ? trim( (string) $lng ) : '';

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
		$toggle = ! empty( $location_data['end_different'] );
		if ( ! $toggle ) {
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
			return strtolower(  ) !== strtolower(  );
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
