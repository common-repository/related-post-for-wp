<?php
/**
 * The Loader Class
 *
 * @package wp-related-posts
 *
 * @since 0.1
 */
class SP_WPRP_Loader {

	function __construct() {
		require_once( SP_WPRP_PATH . 'public/views/shortcoderender.php' );
		require_once( SP_WPRP_PATH . 'public/views/scripts.php' );
	}

}

new SP_WPRP_Loader();
