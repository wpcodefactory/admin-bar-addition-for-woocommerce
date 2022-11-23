<?php
/**
 * Admin Bar Addition for WooCommerce - Main Class
 *
 * @version 1.2.0
 * @since   1.0.0
 *
 * @author  Algoritmika Ltd.
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_Admin_Bar_Addition' ) ) :

final class Alg_WC_Admin_Bar_Addition {

	/**
	 * Plugin version.
	 *
	 * @var   string
	 * @since 1.0.0
	 */
	public $version = ALG_WC_ADMIN_BAR_ADDITION_VERSION;

	/**
	 * @var   Alg_WC_Admin_Bar_Addition The single instance of the class
	 * @since 1.0.0
	 */
	protected static $_instance = null;

	/**
	 * Main Alg_WC_Admin_Bar_Addition Instance
	 *
	 * Ensures only one instance of Alg_WC_Admin_Bar_Addition is loaded or can be loaded.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @static
	 * @return  Alg_WC_Admin_Bar_Addition - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Alg_WC_Admin_Bar_Addition Constructor.
	 *
	 * @version 1.2.0
	 * @since   1.0.0
	 *
	 * @access  public
	 */
	function __construct() {

		// Check for the active WooCommerce plugin
		if ( ! function_exists( 'WC' ) ) {
			return;
		}

		// Set up localisation
		add_action( 'init', array( $this, 'localize' ) );

		// Include required files
		$this->includes();

	}

	/**
	 * localize.
	 *
	 * @version 1.2.0
	 * @since   1.2.0
	 */
	function localize() {
		load_plugin_textdomain( 'admin-bar-addition-for-woocommerce', false, dirname( plugin_basename( ALG_WC_ADMIN_BAR_ADDITION_FILE ) ) . '/langs/' );
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 *
	 * @version 1.2.0
	 * @since   1.0.0
	 */
	function includes() {
		// Core
		$this->core = require_once( 'class-alg-wc-admin-bar-addition-core.php' );
	}

	/**
	 * Get the plugin url.
	 *
	 * @version 1.2.0
	 * @since   1.0.0
	 *
	 * @return  string
	 */
	function plugin_url() {
		return untrailingslashit( plugin_dir_url( ALG_WC_ADMIN_BAR_ADDITION_FILE ) );
	}

	/**
	 * Get the plugin path.
	 *
	 * @version 1.2.0
	 * @since   1.0.0
	 *
	 * @return  string
	 */
	function plugin_path() {
		return untrailingslashit( plugin_dir_path( ALG_WC_ADMIN_BAR_ADDITION_FILE ) );
	}

}

endif;
