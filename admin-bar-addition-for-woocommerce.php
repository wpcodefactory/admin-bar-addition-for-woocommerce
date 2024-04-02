<?php
/*
Plugin Name: Admin Bar Addition for WooCommerce
Plugin URI: https://wpfactory.com
Description: Admin bar addition for WooCommerce.
Version: 1.4.0
Author: WPFactory
Author URI: https://wpfactory.com
Text Domain: admin-bar-addition-for-woocommerce
Domain Path: /langs
WC tested up to: 8.7
*/

defined( 'ABSPATH' ) || exit;

defined( 'ALG_WC_ADMIN_BAR_ADDITION_VERSION' ) || define( 'ALG_WC_ADMIN_BAR_ADDITION_VERSION', '1.4.0' );

defined( 'ALG_WC_ADMIN_BAR_ADDITION_FILE' ) || define( 'ALG_WC_ADMIN_BAR_ADDITION_FILE', __FILE__ );

require_once( 'includes/class-alg-wc-admin-bar-addition.php' );

if ( ! function_exists( 'alg_wc_admin_bar_addition' ) ) {
	/**
	 * Returns the main instance of Alg_WC_Admin_Bar_Addition to prevent the need to use globals.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function alg_wc_admin_bar_addition() {
		return Alg_WC_Admin_Bar_Addition::instance();
	}
}

add_action( 'plugins_loaded', 'alg_wc_admin_bar_addition' );
