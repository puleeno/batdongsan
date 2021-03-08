<?php
use WordLand\PostTypes;

class Batdongsan_Front_Door_Direction {
    const DOOR_DIRECTION_TAX = 'door_direction';

	public function __construct() {
		add_action( 'init', array( $this, 'registerTaxonomies' ) );
		add_filter( 'wordland_builder_get_property', array( $this, 'parseDirectionsData' ) );
		add_filter( 'wordland_setup_same_location_property', array( $this, 'parseDirectionsData' ) );
	}

	public function registerTaxonomies() {
		$labels = array(
			'name' => __( 'Hướng nhà', 'batdongsan' ),
		);
		$args   = array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'public'            => true,
			'show_admin_column' => true,
		);

		register_taxonomy(
			static::DOOR_DIRECTION_TAX,
			PostTypes::get(),
			apply_filters(
				'batdongsan_direction_args',
				$args
			)
		);
	}

	public function parseDirectionsData( $property ) {
		if ( ! $property->ID || is_admin() ) {
			return $property;
		}

		$directions = wp_get_post_terms( $property->ID, static::DOOR_DIRECTION_TAX );
		if (!isset($property->directions)) {
			$property->directions = array();
		}
		foreach ( $directions as $index => $direction ) {
			$parsedDirections                = array(
				'id'       => $direction->term_id,
				'display'  => $direction->name,
				'url'      => get_term_link( $direction, static::DOOR_DIRECTION_TAX ),
				'show_url' => false,
			);
			$property->directions[ $index ] = apply_filters(
				'batdongsan_parsed_direction',
				$parsedDirections,
				$direction
			);
		}
		if ( isset( $property->directions ) ) {
			$property->direction = $property->directions[0];
		}
		return $property;
	}
}


new Batdongsan_Front_Door_Direction();
