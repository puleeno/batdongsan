<?php
/**
 * Plugin Name: Bất Động Sản
 * Plugin URI: https://github.com/puleeno/batdongsan
 * Author: Puleeno Nguyen
 * Author URI: https://puleeno.com
 * Description: Tạo Bất Động Sản theo đặc trưng Việt Nam cho WordLand plugin (WordPress)
 * Version: 1.0.0
 * Tag: real estate, realty, bất động sản, nhà đất
 */

define( 'BATDONGSAN_PLUGIN_FILE', __FILE__ );

if ( ! class_exists( 'Batdongsan' ) ) {
	require_once dirname( __FILE__ ) . '/includes/class-batdongsan.php';
}

if ( ! function_exists( 'batdongsan' ) ) {
	function batdongsan() {
		return Batdongsan::getInstance();
	}
}

$GLOBALS['batdongsan'] = batdongsan();
