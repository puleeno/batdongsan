<?php
use WordLand\PostTypes;

class Batdongsan {
	protected static $instance;

	public static function getInstance() {
		if ( is_null( static::$instance ) ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	private function __construct() {
		// This plugin working with WordLand plugin
		if ( ! class_exists( WordLand::class ) ) {
			return;
		}
		$this->includes();
		$this->init_hooks();
	}

	public function includes() {
		require_once dirname( __FILE__ ) . '/class-batdongsan-legal-status.php';
		require_once dirname( __FILE__ ) . '/class-batdongsan-front-and-road-acreages.php';
		require_once dirname( __FILE__ ) . '/class-batdongsan-options.php';
		require_once dirname( __FILE__ ) . '/class-batdongsan-install.php';

		// Integrations
		require_once dirname( __FILE__ ) . '/integrations/class-batdongsan-integration-spreadsheet-importer.php';
	}

	public function init_hooks() {
		register_activation_hook( BATDONGSAN_PLUGIN_FILE, array( Batdongsan_Install::class, 'active' ) );
		add_action( 'init', array( $this, 'init' ) );
	}

	public function init() {
		add_action( 'save_post', array( $this, 'save_default_legal' ), 30, 3 );
	}

	public function save_default_legal( $post_ID, $post, $update ) {
		if ( ! in_array( $post->post_type, (array) PostTypes::get() ) ) {
			return;
		}

		$terms = wp_get_post_terms( $post_ID, Datdongsan_Legal_Status::LEGAL_NAME );
		if ( $update && empty( $terms ) && ( $default_legal = get_option( 'default_property_legal' ) ) ) {
			wp_set_post_terms( $post_ID, array( intval( $default_legal ) ), Datdongsan_Legal_Status::LEGAL_NAME );
		}
	}
}
