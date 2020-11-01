<?php
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
		if (!class_exists(WordLand::class)) {
			return;
		}
		$this->includes();
	}

	public function includes() {
		require_once dirname(__FILE__) . '/class-batdongsan-legal-status.php';
	}
}
