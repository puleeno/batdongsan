<?php

class Batdongsan_Options {
	public function __construct() {
		if ( is_admin() ) {
			add_action( 'admin_init', array( $this, 'registerDefaultLegalTermOptions' ) );
		}
	}

	public function registerDefaultLegalTermOptions() {
		register_setting( 'writing', 'default_property_legal' );
		add_settings_field(
			'default_property_legal',
			'Pháp lý mặc định',
			array( $this, 'callback_display_dropdown' ),
			'writing',
			'default',
			[
				'label_for' => 'default_property_legal',
			]
		);

	}

	function callback_display_dropdown() {
		wp_dropdown_categories(
			array(
				'hide_empty'   => 0,
				'name'         => 'default_property_legal',
				'orderby'      => 'name',
				'selected'     => get_option( 'default_property_legal' ),
				'hierarchical' => true,
				'taxonomy'     => Datdongsan_Legal_Status::LEGAL_NAME,
			)
		);
	}
}

new Batdongsan_Options();
