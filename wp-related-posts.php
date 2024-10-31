<?php
/**
 * Plugin Name:     WP Related Posts
 * Plugin URI:      https://shapedplugin.com/plugin/wp-related-posts
 * Description:     WP Related Posts help you display simply related posts in a single post. It's easy to use and lightweight.
 * Version:         0.1
 * Author:          ShapedPlugin
 * Author URI:      https://shapedplugin.com/
 * License:         GPLv3
 * License URI:     https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:     wp-related-posts
 * Domain Path:     /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles core plugin hooks and action setup.
 *
 * @package wp-related-posts
 *
 * @since 0.1
 */
if ( ! class_exists( 'SP_WP_Related_Posts' ) ) {
	class SP_WP_Related_Posts {
		/**
		 * Plugin version
		 *
		 * @var string
		 */
		public $version = '0.1';

		/**
		 * @var SP_WPRP_Router $router
		 */
		public $router;

		/**
		 * @var null
		 * @since 0.1
		 */
		protected static $_instance = null;

		/**
		 * @return SP_WP_Related_Posts
		 * @since 0.1
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Constructor.
		 */
		function __construct() {
			// Define constants.
			$this->define_constants();

			// Initialize the action hooks.
			$this->init_actions();

			// Required class file include.
			spl_autoload_register( array( $this, 'autoload' ) );

			// Include required files.
			$this->includes();

		}

		/**
		 * Define constants
		 *
		 * @since 0.1
		 */
		public function define_constants() {
			$this->define( 'SP_WPRP_VERSION', $this->version );
			$this->define( 'SP_WPRP_PATH', plugin_dir_path( __FILE__ ) );
			$this->define( 'SP_WPRP_URL', plugin_dir_url( __FILE__ ) );
			$this->define( 'SP_WPRP_BASENAME', plugin_basename( __FILE__ ) );
		}

		/**
		 * Define constant if not already set
		 *
		 * @param string $name
		 * @param string|bool $value
		 */
		public function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 * Initialize WordPress action hooks
		 *
		 * @return void
		 */
		public function init_actions() {
			add_action( 'plugins_loaded', array( $this, 'load_text_domain' ) );
		}

		/**
		 * Load TextDomain for plugin.
		 *
		 */
		public function load_text_domain() {
			load_textdomain( 'wp-related-posts', WP_LANG_DIR . '/related-post-for-wp/languages/wp-related-post-' . apply_filters( 'plugin_locale', get_locale(), 'wp-related-posts' ) . '.mo' );
			load_plugin_textdomain( 'wp-related-posts', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}

		/**
		 * Autoload class files on demand
		 *
		 * @param string $class requested class name
		 */
		public function autoload( $class ) {
			$name = explode( '_', $class );
			if ( isset( $name[2] ) ) {
				$class_name = strtolower( $name[2] );
				$filename   = SP_WPRP_PATH . '/class/' . $class_name . '.php';

				if ( file_exists( $filename ) ) {
					require_once $filename;
				}
			}
		}

		/**
		 * Page router instantiate
		 *
		 * @since 0.1
		 */
		public function page() {
			$this->router = SP_WPRP_Router::instance();

			return $this->router;
		}

		/**
		 * Include the required files
		 *
		 * @return void
		 */
		public function includes() {
			$this->page()->sp_wprp_function();
			$this->router->includes();
		}

	}
}

/**
 * Returns the main instance.
 *
 * @since 0.1
 *
 * @return SP_WP_Related_Posts
 */
function sp_wp_related_posts() {
	return SP_WP_Related_Posts::instance();
}

/**
 * Sp_wp_related_posts instance.
 */
sp_wp_related_posts();
