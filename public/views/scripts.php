<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}  // if direct access

/**
 * Scripts and styles
 */
class SP_WPRP_Front_Scripts {

	/**
	 * @var null
	 * @since 0.1
	 */
	protected static $_instance = null;

	/**
	 * @return SP_WPRP_Front_Scripts
	 * @since 0.1
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Initialize the class
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'front_scripts' ) );
	}

	/**
	 * Plugin Scripts and Styles
	 */
	function front_scripts() {
		// CSS Files.
		wp_enqueue_style( 'sp-wprp-style', SP_WPRP_URL . 'public/assets/css/style.css', array(), SP_WPRP_VERSION );
	}

}

new SP_WPRP_Front_Scripts();
