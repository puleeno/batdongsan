<?php
use WordLand\PostTypes;

class Datdongsan_Legal_Status {

	const LEGAL_NAME = 'legal_status';

	public function __construct() {
		add_action( 'init', array( $this, 'registerTaxonomies' ) );
		add_filter( 'wordland_builder_get_property', array( $this, 'parseLegalData' ) );
		add_filter( 'wordland_setup_same_location_property', array( $this, 'parseLegalData' ) );
		add_filter( 'wordland_reactjs_global_data', array( $this, 'append_legal_status_to_global' ) );
		add_filter( 'wordland_ajax_build_query_args', array( $this, 'filterPropertyByLegalStatus' ), 10, 2 );
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
		if ( ! isset( $property->legals ) ) {
			$property->legals = array();
		}
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
		if ( ! empty( $property->legals ) ) {
			$property->legal = $property->legals[0];
		}
		return $property;
	}

	public function append_legal_status_to_global( $global_data ) {
		$args = array(
			'taxonomy' => static::LEGAL_NAME,
			'fields'   => 'id=>name',
		);

		$legal_status          = get_terms( $args );
		$global_data['legals'] = $legal_status;

		return $global_data;
	}

	public function filterPropertyByLegalStatus( $args, $request ) {
		if ( isset( $request['legal_status'] ) && $request['legal_status'] > 0 ) {
			if ( ! isset( $args['tax_query'] ) ) {
				$args['tax_query'] = array();
			}
			$args['tax_query'][] = array(
				'taxonomy' => static::LEGAL_NAME,
				'terms'    => intval( $request['legal_status'] ),
				'field'    => 'term_id',
			);
		}

		return $args;
	}
}

new Datdongsan_Legal_Status();
