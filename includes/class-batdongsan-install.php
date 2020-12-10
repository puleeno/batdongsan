<?php

class Batdongsan_Install {
	public static function active() {
		add_action( 'init', array( __CLASS__, 'addUnknownTerm' ), 20 );
	}

	public static function addUnknownTerm() {
		$args = array(
			'taxonomy'   => Datdongsan_Legal_Status::LEGAL_NAME,
			'hide_empty' => false,
		);
		global $wp_version;
		$terms = compare_version( '4.5.0', $wp_version, '<' ) ? get_terms( $args ) : get_terms( $args['taxonomy'], $args );
		if ( empty( $terms ) ) {
			$result = wp_insert_term(
				'Không xác định',
				Datdongsan_Legal_Status::LEGAL_NAME,
				array(
					'description' => 'Loại hình pháp lý mặc định được gán cho tin bất động sản',
				)
			);

			if ( is_wp_error( $result ) ) {
				return;
			}
			return update_option( 'default_property_legal', $result['term_id'] );
		}
	}
}
