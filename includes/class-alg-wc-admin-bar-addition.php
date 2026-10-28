<?php
/**
 * Admin Bar Addition for WooCommerce - Main Class
 *
 * @version 1.5.0
 * @since   1.0.0
 *
 * @author WPFactory
 *
 * @package WPFactory\WC_Admin_Bar_Addition
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_Admin_Bar_Addition' ) ) :

	/**
	 * Alg_WC_Admin_Bar_Addition class.
	 *
	 * @version 1.5.0
	 * @since   1.0.0
	 */
	final class Alg_WC_Admin_Bar_Addition {

		/**
		 * Plugin version.
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		public $version = ALG_WC_ADMIN_BAR_ADDITION_VERSION;

		/**
		 * Core.
		 *
		 * @version 1.4.0
		 * @since   1.4.0
		 *
		 * @var Alg_WC_Admin_Bar_Addition_Core
		 */
		public $core;

		/**
		 * The single instance of the class.
		 *
		 * @version 1.5.0
		 * @since   1.0.0
		 *
		 * @var Alg_WC_Admin_Bar_Addition
		 */
		protected static $instance = null;

		/**
		 * Main Alg_WC_Admin_Bar_Addition Instance.
		 *
		 * Ensures only one instance of Alg_WC_Admin_Bar_Addition is loaded or can be loaded.
		 *
		 * @version 1.5.0
		 * @since   1.0.0
		 *
		 * @static
		 *
		 * @return Alg_WC_Admin_Bar_Addition
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Alg_WC_Admin_Bar_Addition Constructor.
		 *
		 * @version 1.5.0
		 * @since   1.0.0
		 *
		 * @access public
		 */
		public function __construct() {
			// Check for the active WooCommerce plugin.
			if ( ! function_exists( 'WC' ) ) {
				return;
			}

			// Declare compatibility with custom order tables for WooCommerce.
			add_action( 'before_woocommerce_init', array( $this, 'wc_declare_compatibility' ) );

			// Include required files.
			$this->includes();
		}

		/**
		 * WC declare compatibility.
		 *
		 * @version 1.3.0
		 * @since   1.3.0
		 *
		 * @return void
		 *
		 * @see https://developer.woocommerce.com/docs/features/orders/high-performance-order-storage/recipe-book/
		 */
		public function wc_declare_compatibility() {
			if ( class_exists( '\Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
				\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility(
					'custom_order_tables',
					ALG_WC_ADMIN_BAR_ADDITION_FILE,
					true
				);
			}
		}

		/**
		 * Include required core files used in admin and on the frontend.
		 *
		 * @version 1.5.0
		 * @since   1.0.0
		 *
		 * @return void
		 */
		public function includes() {
			// Core.
			$this->core = require_once plugin_dir_path( __FILE__ ) . 'class-alg-wc-admin-bar-addition-core.php';
		}

		/**
		 * Get the plugin URL.
		 *
		 * @version 1.2.0
		 * @since   1.0.0
		 *
		 * @return string
		 */
		public function plugin_url() {
			return untrailingslashit( plugin_dir_url( ALG_WC_ADMIN_BAR_ADDITION_FILE ) );
		}

		/**
		 * Get the plugin path.
		 *
		 * @version 1.2.0
		 * @since   1.0.0
		 *
		 * @return string
		 */
		public function plugin_path() {
			return untrailingslashit( plugin_dir_path( ALG_WC_ADMIN_BAR_ADDITION_FILE ) );
		}
	}

endif;
