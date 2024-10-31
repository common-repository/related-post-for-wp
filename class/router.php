<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * WP Related Posts - route class
 * 
 * @since 0.1
 */
class SP_WPRP_Router {

	/**
	 * @var SP_WPRP_Router single instance of the class
	 *
	 * @since 0.1
	 */
	protected static $_instance = null;


	/**
	 * @since 0.1
	 * 
	 * @static
	 * 
	 * @return SP_WPRP_Router
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Include the required files
	 *
	 * @since 0.1
	 * 
	 * @return void
	 */
	function includes() {
		include_once SP_WPRP_PATH . 'includes/loader.php';
	}

	/**
	 * Function
	 *
	 * @since 0.1
	 * 
	 * @return void
	 */
	function sp_wprp_function() {
		include_once SP_WPRP_PATH . 'includes/functions.php';
	}

}
