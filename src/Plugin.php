<?php
/**
 * Pronamic Order Referrer for WooCommerce
 *
 * @package   PronamicWooCommercePaymentGatewaysCountriesCondition
 * @author    Pronamic
 * @copyright 2023 Pronamic
 */

namespace Pronamic\WooCommerceOrderReferrer;

use WC_Order;
use WP_Post;

/**
 * Pronamic Order Referrer for WooCommerce class
 */
class Plugin {
	/**
	 * Instance of this class.
	 *
	 * @since 4.7.1
	 * @var self
	 */
	protected static $instance = null;

	/**
	 * Return an instance of this class.
	 *
	 * @return self A single instance of this class.
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Setup.
	 * 
	 * @return void
	 */
	public function setup() {
		if ( \has_action( 'plugins_loaded', [ $this, 'plugins_loaded' ] ) ) {
			return;
		}

		\add_action( 'plugins_loaded', [ $this, 'plugins_loaded' ] );
	}

	/**
	 * Plugins loaded.
	 * 
	 * @return void
	 */
	public function plugins_loaded() {
		if ( ! \function_exists( '\WC' ) ) {
			return;
		}

		\add_action( 'init', [ $this, 'init' ] );

		\add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

		\add_action( 'woocommerce_checkout_create_order', [ $this, 'woocommerce_checkout_create_order' ] );
	}

	/**
	 * Init.
	 *
	 * @return void
	 */
	public function init() {
		$file = '../js/dist/script.min.js';

		\wp_register_script(
			'pronamic-order-referrer-for-woocommerce',
			\plugins_url( $file, __FILE__ ),
			[],
			\hash_file( 'crc32b', __DIR__ . '/' . $file ),
			true
		);

		if ( \is_admin() ) {
			\add_action( 'add_meta_boxes', [ $this, 'maybe_add_meta_box_to_wc_order' ], 10, 2 );
		}
	}

	/**
	 * Enqueue scripts.
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		\wp_enqueue_script( 'pronamic-order-referrer-for-woocommerce' );
	}

	/**
	 * WooCommerce checkout update order meta.
	 *
	 * @link https://github.com/woocommerce/woocommerce/blob/8.2.1/plugins/woocommerce/includes/class-wc-checkout.php#L451-L456
	 * @param WC_Order $order Order.
	 * @return void
	 */
	public function woocommerce_checkout_create_order( $order ) {
		// phpcs:ignore WordPress.Security.NonceVerification.Missing -- Nonce handling is done upstream by WooCommerce.
		if ( ! \array_key_exists( 'pronamic_referrers_json', $_POST ) ) {
			return;
		}

		// phpcs:ignore WordPress.Security.NonceVerification.Missing -- Nonce handling is done upstream by WooCommerce.
		$referrers_json = \sanitize_text_field( \wp_unslash( $_POST['pronamic_referrers_json'] ) );

		$order->update_meta_data( '_pronamic_referrers_json', $referrers_json );
	}

	/**
	 * Maybe add a meta box the WooCommerce order.
	 * 
	 * @link https://github.com/pronamic/wp-pronamic-pay-woocommerce/issues/41
	 * @link https://developer.wordpress.org/reference/hooks/add_meta_boxes/
	 * @param string           $post_type_or_screen_id Post type or screen ID.
	 * @param WC_Order|WP_Post $post_or_order_object   Post or order object.
	 * @return void
	 */
	public function maybe_add_meta_box_to_wc_order( $post_type_or_screen_id, $post_or_order_object ) {
		if ( ! \in_array( $post_type_or_screen_id, [ 'shop_order', 'woocommerce_page_wc-orders' ], true ) ) {
			return;
		}

		$order = $post_or_order_object instanceof WC_Order ? $post_or_order_object : \wc_get_order( $post_or_order_object->ID );

		if ( ! $order instanceof WC_Order ) {
			return;
		}

		\add_meta_box(
			'pronamic-woocommerce-order-referrer',
			\__( 'Referrers', 'pronamic-order-referrer-for-woocommerce' ),
			function () use ( $order ) {
				include __DIR__ . '/../views/admin-meta-box-woocommerce-order.php';
			},
			$post_type_or_screen_id,
			'normal'
		);
	}
}
