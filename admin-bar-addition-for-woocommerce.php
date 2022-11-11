<?php
/*
Plugin Name: Admin Bar Addition for WooCommerce
Plugin URI: https://algoritmika.com
Description: Admin bar addition for WooCommerce.
Version: 1.1.0
Author: Algoritmika Ltd
Author URI: https://algoritmika.com
Text Domain: admin-bar-addition-for-woocommerce
Domain Path: /langs
Copyright: © 2020 Algoritmika Ltd.
WC tested up to: 3.8
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_Admin_Bar_Addition' ) ) :

/**
 * Main Alg_WC_Admin_Bar_Addition Class
 *
 * @class   Alg_WC_Admin_Bar_Addition
 * @version 1.1.0
 * @since   1.0.0
 */
final class Alg_WC_Admin_Bar_Addition {

	/**
	 * Plugin version.
	 *
	 * @var   string
	 * @since 1.0.0
	 */
	public $version = '1.1.0';

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
	 * @version 1.1.0
	 * @since   1.0.0
	 * @access  public
	 */
	function __construct() {

		// Check for active plugins
		if ( ! $this->is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			return;
		}

		// Set up localisation
		load_plugin_textdomain( 'admin-bar-addition-for-woocommerce', false, dirname( plugin_basename( __FILE__ ) ) . '/langs/' );

		// Include required files
		$this->includes();

	}

	/**
	 * is_plugin_active.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 */
	function is_plugin_active( $plugin ) {
		return ( function_exists( 'is_plugin_active' ) ? is_plugin_active( $plugin ) :
			(
				in_array( $plugin, apply_filters( 'active_plugins', ( array ) get_option( 'active_plugins', array() ) ) ) ||
				( is_multisite() && array_key_exists( $plugin, ( array ) get_site_option( 'active_sitewide_plugins', array() ) ) )
			)
		);
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 *
	 * @version 1.1.0
	 * @since   1.0.0
	 */
	function includes() {
		// Core
		$this->core = require_once( 'includes/class-alg-wc-admin-bar-addition-core.php' );
	}

	/**
	 * Get the plugin url.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @return  string
	 */
	function plugin_url() {
		return untrailingslashit( plugin_dir_url( __FILE__ ) );
	}

	/**
	 * Get the plugin path.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @return  string
	 */
	function plugin_path() {
		return untrailingslashit( plugin_dir_path( __FILE__ ) );
	}

}

endif;

if ( ! function_exists( 'alg_wc_admin_bar_addition' ) ) {
	/**
	 * Returns the main instance of Alg_WC_Admin_Bar_Addition to prevent the need to use globals.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @return  Alg_WC_Admin_Bar_Addition
	 */
	function alg_wc_admin_bar_addition() {
		return Alg_WC_Admin_Bar_Addition::instance();
	}
}

alg_wc_admin_bar_addition();
