<?php
class Batdongsan {
	protected static $instance;

	public function getInstance() {
		if ( is_null( static::$instance ) ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	private function __construct() {
	}
}
