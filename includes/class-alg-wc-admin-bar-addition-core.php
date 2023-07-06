<?php
/**
 * Admin Bar Addition for WooCommerce - Core Class
 *
 * @version 1.3.0
 * @since   1.0.0
 *
 * @author  Algoritmika Ltd.
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_Admin_Bar_Addition_Core' ) ) :

class Alg_WC_Admin_Bar_Addition_Core {

	/**
	 * Constructor.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function __construct() {
		add_action( 'admin_bar_menu', array( $this, 'add_woocommerce_admin_bar' ), PHP_INT_MAX );
		add_action( 'wp_head',        array( $this, 'add_woocommerce_admin_bar_icon_style' ) );
		add_action( 'admin_head',     array( $this, 'add_woocommerce_admin_bar_icon_style' ) );
	}

	/**
	 * add_woocommerce_admin_bar_icon_style.
	 *
	 * @version 1.1.0
	 * @since   1.0.0
	 */
	function add_woocommerce_admin_bar_icon_style() {
		echo '<style type="text/css">#wpadminbar #wp-admin-bar-alg-wc .ab-icon:before { content: "\f174"; top: 3px; }</style>' . PHP_EOL;
	}

	/**
	 * add_woocommerce_admin_bar_nodes.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function add_woocommerce_admin_bar_nodes( $wp_admin_bar, $nodes, $parent_id ) {
		foreach ( $nodes as $node_id => $node ) {
			$id = ( false !== $parent_id ? $parent_id . '-' . $node_id : $node_id );
			$args = array(
				'parent' => $parent_id,
				'id'     => $id,
				'title'  => $node['title'],
				'href'   => $node['href'],
				'meta'   => array( 'title' => $node['title'] ),
			);
			if ( isset( $node['meta'] ) ) {
				$args['meta'] = array_merge( $args['meta'], $node['meta'] );
			}
			$wp_admin_bar->add_node( $args );
			if ( isset( $node['nodes'] ) ) {
				// Recursion
				$this->add_woocommerce_admin_bar_nodes( $wp_admin_bar, $node['nodes'], $id );
			}
		}
	}
	/**
	 * get_nodes_orders_reports.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function get_nodes_orders_reports() {
		$nodes = array();
		$reports = array(
			'sales_by_date'     => __( 'Sales by date', 'woocommerce' ),
			'sales_by_product'  => __( 'Sales by product', 'woocommerce' ),
			'sales_by_category' => __( 'Sales by category', 'woocommerce' ),
			'coupon_usage'      => __( 'Coupons by date', 'woocommerce' ),
		);
		foreach ( $reports as $report_id => $report_title ) {
			$nodes[ $report_id ] = array(
				'title'  => $report_title,
				'href'   => admin_url( 'admin.php?page=wc-reports&tab=orders&report=' . $report_id ),
				'nodes'  => array(
					'7day' => array(
						'title'  => __( 'Last 7 days', 'woocommerce' ),
						'href'   => admin_url( 'admin.php?page=wc-reports&tab=orders&report=' . $report_id . '&range=7day' ),
					),
					'month' => array(
						'title'  => __( 'This month', 'woocommerce' ),
						'href'   => admin_url( 'admin.php?page=wc-reports&tab=orders&report=' . $report_id . '&range=month' ),
					),
					'last-month' => array(
						'title'  => __( 'Last month', 'woocommerce' ),
						'href'   => admin_url( 'admin.php?page=wc-reports&tab=orders&report=' . $report_id . '&range=last_month' ),
					),
					'year' => array(
						'title'  => __( 'Year', 'woocommerce' ),
						'href'   => admin_url( 'admin.php?page=wc-reports&tab=orders&report=' . $report_id . '&range=year' ),
					),
				),
			);
		}
		return $nodes;
	}

	/**
	 * add_woocommerce_admin_bar.
	 *
	 * @version 1.3.0
	 * @since   1.0.0
	 *
	 * @todo    [next] (dev) analytics
	 * @todo    [maybe] (dev) reports > customers > customers > add dates
	 * @todo    [maybe] (dev) reports > taxes > taxes_by_code > add dates
	 * @todo    [maybe] (dev) reports > taxes > taxes_by_date > add dates
	 * @todo    [maybe] (dev) settings > add custom sections
	 * @todo    [maybe] (dev) extensions > add sections
	 */
	function add_woocommerce_admin_bar( $wp_admin_bar ) {

		$is_hpos = (
			class_exists( 'Automattic\WooCommerce\Utilities\OrderUtil' ) &&
			Automattic\WooCommerce\Utilities\OrderUtil::custom_orders_table_usage_is_enabled()
		);

		$nodes = array(
			'alg-wc' => array(
				'title'  => '<span class="ab-icon"></span>' . __( 'WooCommerce', 'woocommerce' ),
				'href'   => admin_url( 'admin.php?page=wc-settings' ),
				'meta'   => array(
					'title'  => __( 'WooCommerce settings', 'woocommerce' ),
				),
				'nodes'  => array(
					'orders' => array(
						'title'  => __( 'Orders', 'woocommerce' ),
						'href'   => admin_url( ( $is_hpos ? 'admin.php?page=wc-orders' : 'edit.php?post_type=shop_order' ) ),
						'nodes'  => array(
							'orders' => array(
								'title'  => __( 'Orders', 'woocommerce' ),
								'href'   => admin_url( ( $is_hpos ? 'admin.php?page=wc-orders' : 'edit.php?post_type=shop_order' ) ),
							),
							'add-order' => array(
								'title'  => __( 'Add order', 'woocommerce' ),
								'href'   => admin_url( ( $is_hpos ? 'admin.php?page=wc-orders&action=new' : 'post-new.php?post_type=shop_order' ) ),
							),
							'customers' => array(
								'title'  => __( 'Customers', 'woocommerce' ),
								'href'   => admin_url( 'users.php?role=customer' ),
							),
						),
					),
					'reports' => array(
						'title'  => __( 'Reports', 'woocommerce' ),
						'href'   => admin_url( 'admin.php?page=wc-reports' ),
						'nodes'  => array(
							'orders' => array(
								'title'  => __( 'Orders', 'woocommerce' ),
								'href'   => admin_url( 'admin.php?page=wc-reports&tab=orders' ),
								'nodes'  => $this->get_nodes_orders_reports(),
							),
							'customers' => array(
								'title'  => __( 'Customers', 'woocommerce' ),
								'href'   => admin_url( 'admin.php?page=wc-reports&tab=customers' ),
								'nodes'  => array(
									'customers' => array(
										'title'  => __( 'Customers vs. guests', 'woocommerce' ),
										'href'   => admin_url( 'admin.php?page=wc-reports&tab=customers&report=customers' ),
									),
									'customer-list' => array(
										'title'  => __( 'Customer list', 'woocommerce' ),
										'href'   => admin_url( 'admin.php?page=wc-reports&tab=customers&report=customer_list' ),
									),
								),
							),
							'stock' => array(
								'title'  => __( 'Stock', 'woocommerce' ),
								'href'   => admin_url( 'admin.php?page=wc-reports&tab=stock' ),
								'nodes'  => array(
									'low-in-stock' => array(
										'title'  => __( 'Low in stock', 'woocommerce' ),
										'href'   => admin_url( 'admin.php?page=wc-reports&tab=stock&report=low_in_stock' ),
									),
									'out-of-stock' => array(
										'title'  => __( 'Out of stock', 'woocommerce' ),
										'href'   => admin_url( 'admin.php?page=wc-reports&tab=stock&report=out_of_stock' ),
									),
									'most-stocked' => array(
										'title'  => __( 'Most Stocked', 'woocommerce' ),
										'href'   => admin_url( 'admin.php?page=wc-reports&tab=stock&report=most_stocked' ),
									),
								),
							),
							'taxes' => array(
								'title'  => __( 'Taxes', 'woocommerce' ),
								'href'   => admin_url( 'admin.php?page=wc-reports&tab=taxes' ),
								'nodes'  => array(
									'taxes-by-code' => array(
										'title'  => __( 'Taxes by code', 'woocommerce' ),
										'href'   => admin_url( 'admin.php?page=wc-reports&tab=taxes&report=taxes_by_code' ),
									),
									'taxes-by-date' => array(
										'title'  => __( 'Taxes by date', 'woocommerce' ),
										'href'   => admin_url( 'admin.php?page=wc-reports&tab=taxes&report=taxes_by_date' ),
									),
								),
							),
						),
					),
					'products' => array(
						'title'  => __( 'Products', 'woocommerce' ),
						'href'   => admin_url( 'edit.php?post_type=product' ),
						'nodes'  => array(
							'products' => array(
								'title'  => __( 'Products', 'woocommerce' ),
								'href'   => admin_url( 'edit.php?post_type=product' ),
							),
							'add-product' => array(
								'title'  => __( 'Add product', 'woocommerce' ),
								'href'   => admin_url( 'post-new.php?post_type=product' ),
							),
							'categories' => array(
								'title'  => __( 'Categories', 'woocommerce' ),
								'href'   => admin_url( 'edit-tags.php?taxonomy=product_cat&post_type=product' ),
							),
							'tags' => array(
								'title'  => __( 'Tags', 'woocommerce' ),
								'href'   => admin_url( 'edit-tags.php?taxonomy=product_tag&post_type=product' ),
							),
							'attributes' => array(
								'title'  => __( 'Attributes', 'woocommerce' ),
								'href'   => admin_url( 'edit.php?post_type=product&page=product_attributes' ),
							),
						),
					),
					'coupons' => array(
						'title'  => __( 'Coupons', 'woocommerce' ),
						'href'   => admin_url( 'edit.php?post_type=shop_coupon' ),
						'nodes'  => array(
							'coupons' => array(
								'title'  => __( 'Coupons', 'woocommerce' ),
								'href'   => admin_url( 'edit.php?post_type=shop_coupon' ),
							),
							'add-coupon' => array(
								'title'  => __( 'Add coupon', 'woocommerce' ),
								'href'   => admin_url( 'post-new.php?post_type=shop_coupon' ),
							),
						),
					),
					'settings' => array(
						'title'  => __( 'Settings', 'woocommerce' ),
						'href'   => admin_url( 'admin.php?page=wc-settings' ),
						'nodes'  => array(
							'general' => array(
								'title'  => __( 'General', 'woocommerce' ),
								'href'   => admin_url( 'admin.php?page=wc-settings&tab=general' ),
							),
							'products' => array(
								'title'  => __( 'Products', 'woocommerce' ),
								'href'   => admin_url( 'admin.php?page=wc-settings&tab=products' ),
								'nodes'  => array(
									'general' => array(
										'title'  => __( 'General', 'woocommerce' ),
										'href'   => admin_url( 'admin.php?page=wc-settings&tab=products&section' ),
									),
									'inventory' => array(
										'title'  => __( 'Inventory', 'woocommerce' ),
										'href'   => admin_url( 'admin.php?page=wc-settings&tab=products&section=inventory' ),
									),
									'downloadable' => array(
										'title'  => __( 'Downloadable products', 'woocommerce' ),
										'href'   => admin_url( 'admin.php?page=wc-settings&tab=products&section=downloadable' ),
									),
								),
							),
							'tax' => array(
								'title'  => __( 'Tax', 'woocommerce' ),
								'href'   => admin_url( 'admin.php?page=wc-settings&tab=tax' ),
								'nodes'  => array(
									'tax-options' => array(
										'title'  => __( 'Tax options', 'woocommerce' ),
										'href'   => admin_url( 'admin.php?page=wc-settings&tab=tax&section' ),
									),
									'standard-rates' => array(
										'title'  => __( 'Standard rates', 'woocommerce' ),
										'href'   => admin_url( 'admin.php?page=wc-settings&tab=tax&section=standard' ),
									),
								),
							),
							'shipping' => array(
								'title'  => __( 'Shipping', 'woocommerce' ),
								'href'   => admin_url( 'admin.php?page=wc-settings&tab=shipping' ),
								'nodes'  => array(
									'shipping-zones' => array(
										'title'  => __( 'Shipping zones', 'woocommerce' ),
										'href'   => admin_url( 'admin.php?page=wc-settings&tab=shipping&section' ),
									),
									'shipping-options' => array(
										'title'  => __( 'Shipping options', 'woocommerce' ),
										'href'   => admin_url( 'admin.php?page=wc-settings&tab=shipping&section=options' ),
									),
									'shipping-classes' => array(
										'title'  => __( 'Shipping classes', 'woocommerce' ),
										'href'   => admin_url( 'admin.php?page=wc-settings&tab=shipping&section=classes' ),
									),
								),
							),
							'checkout' => array(
								'title'  => __( 'Payments', 'woocommerce' ),
								'href'   => admin_url( 'admin.php?page=wc-settings&tab=checkout' ),
								'nodes'  => array(
									'checkout-options' => array(
										'title'  => __( 'Checkout options', 'woocommerce' ),
										'href'   => admin_url( 'admin.php?page=wc-settings&tab=checkout&section' ),
									),
									'bacs' => array(
										'title'  => __( 'BACS', 'woocommerce' ),
										'href'   => admin_url( 'admin.php?page=wc-settings&tab=checkout&section=bacs' ),
									),
									'cheque' => array(
										'title'  => __( 'Check payments', 'woocommerce' ),
										'href'   => admin_url( 'admin.php?page=wc-settings&tab=checkout&section=cheque' ),
									),
									'cod' => array(
										'title'  => __( 'Cash on delivery', 'woocommerce' ),
										'href'   => admin_url( 'admin.php?page=wc-settings&tab=checkout&section=cod' ),
									),
									'paypal' => array(
										'title'  => __( 'PayPal', 'woocommerce' ),
										'href'   => admin_url( 'admin.php?page=wc-settings&tab=checkout&section=paypal' ),
									),
								),
							),
							'account' => array(
								'title'  => __( 'Account', 'woocommerce' ),
								'href'   => admin_url( 'admin.php?page=wc-settings&tab=account' ),
							),
							'email' => array(
								'title'  => __( 'Emails', 'woocommerce' ),
								'href'   => admin_url( 'admin.php?page=wc-settings&tab=email' ),
							),
							'advanced' => array(
								'title'  => __( 'Advanced', 'woocommerce' ),
								'href'   => admin_url( 'admin.php?page=wc-settings&tab=advanced' ),
								'nodes'  => array(
									'page-setup' => array(
										'title'  => __( 'Page setup', 'woocommerce' ),
										'href'   => admin_url( 'admin.php?page=wc-settings&tab=advanced&section' ),
									),
									'keys' => array(
										'title'  => __( 'REST API', 'woocommerce' ),
										'href'   => admin_url( 'admin.php?page=wc-settings&tab=advanced&section=keys' ),
									),
									'webhooks' => array(
										'title'  => __( 'Webhooks', 'woocommerce' ),
										'href'   => admin_url( 'admin.php?page=wc-settings&tab=advanced&section=webhooks' ),
									),
								),
							),
						),
					),
					'system-status' => array(
						'title'  => __( 'System status', 'woocommerce' ),
						'href'   => admin_url( 'admin.php?page=wc-status' ),
						'nodes'  => array(
							'system-status' => array(
								'title'  => __( 'System status', 'woocommerce' ),
								'href'   => admin_url( 'admin.php?page=wc-status&tab=status' ),
							),
							'tools' => array(
								'title'  => __( 'Tools', 'woocommerce' ),
								'href'   => admin_url( 'admin.php?page=wc-status&tab=tools' ),
							),
							'logs' => array(
								'title'  => __( 'Logs', 'woocommerce' ),
								'href'   => admin_url( 'admin.php?page=wc-status&tab=logs' ),
							),
						),
					),
					'extensions' => array(
						'title'  => __( 'Extensions', 'woocommerce' ),
						'href'   => admin_url( 'admin.php?page=wc-addons' ),
					),
				),
			),
		);

		$this->add_woocommerce_admin_bar_nodes( $wp_admin_bar, $nodes, false );

	}

}

endif;

return new Alg_WC_Admin_Bar_Addition_Core();
