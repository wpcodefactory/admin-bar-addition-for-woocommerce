<?php
/**
 * Plugin Name: Admin Bar Addition for WooCommerce
 * Plugin URI: https://wpfactory.com
 * Description: Admin bar addition for WooCommerce.
 * Version: 1.5.0
 * Author: WPFactory
 * Author URI: https://wpfactory.com
 * Requires PHP: 7.4
 * Text Domain: admin-bar-addition-for-woocommerce
 * Domain Path: /langs
 * WC tested up to: 11.2
 * Requires Plugins: woocommerce
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package WPFactory\WC_Admin_Bar_Addition
 */

defined( 'ABSPATH' ) || exit;

/**
 * Plugin version.
 */
defined( 'ALG_WC_ADMIN_BAR_ADDITION_VERSION' ) || define( 'ALG_WC_ADMIN_BAR_ADDITION_VERSION', '1.5.0' );

/**
 * Plugin file.
 */
defined( 'ALG_WC_ADMIN_BAR_ADDITION_FILE' ) || define( 'ALG_WC_ADMIN_BAR_ADDITION_FILE', __FILE__ );

/**
 * Include main class.
 *
 * @version 1.5.0
 * @since   1.0.0
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-alg-wc-admin-bar-addition.php';

if ( ! function_exists( 'alg_wc_admin_bar_addition' ) ) {
	/**
	 * Returns the main instance of Alg_WC_Admin_Bar_Addition to prevent the need to use globals.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @return Alg_WC_Admin_Bar_Addition
	 */
	function alg_wc_admin_bar_addition() {
		return Alg_WC_Admin_Bar_Addition::instance();
	}
}

/**
 * Initialize the plugin.
 */
add_action( 'plugins_loaded', 'alg_wc_admin_bar_addition' );
