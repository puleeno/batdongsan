<?php
use WordLand\PostTypes;

class Datdongsan_Legal_Status {

	const LEGAL_NAME = 'property_status';

	public function __construct() {
		add_action( 'init', array( $this, 'registerTaxonomies' ) );
		add_filter( 'wordland_builder_get_property', array( $this, 'parseLegalData' ) );
		add_filter( 'wordland_setup_same_location_property', array( $this, 'parseLegalData' ) );
	}

	public function registerTaxonomies() {
		$labels = array(
			'name' => __( 'Pháp lý', 'batdongsan' ),
		);
		$args   = array(
			'labels'       => $labels,
			'hierarchical' => true,
			'public'       => true,
		);
		register_taxonomy(
			static::LEGAL_NAME,
			PostTypes::get(),
			apply_filters(
				'batdongsan_legal_args',
				$args
			)
		);
	}

	public function parseLegalData( $property ) {
		if ( ! $property->ID || is_admin() ) {
			return $property;
		}

		$legals = wp_get_post_terms( $property->ID, static::LEGAL_NAME );
		foreach ( $legals as $index => $legal ) {
			$parsedLegal                = array(
				'id'       => $legal->term_id,
				'display'  => $legal->name,
				'url'      => get_term_link( $legal, static::LEGAL_NAME ),
				'show_url' => false,
			);
			$property->legals[ $index ] = apply_filters(
				'batdongsan_parsed_legal',
				$parsedLegal,
				$legal
			);
		}
		if ( isset( $property->legals ) ) {
			$property->legal = $property->legals[0];
		}
		return $property;
	}
}

new Datdongsan_Legal_Status();
