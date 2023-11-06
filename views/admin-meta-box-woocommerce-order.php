<?php
/**
 * WordPress admin meta box WooCommercer
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$referrers_json = $order->get_meta( '_pronamic_referrers_json' );

$referrers_data = json_decode( $referrers_json );

if ( ! is_array( $referrers_data ) ) {
	esc_html_e( 'There is no referrer data available for this order.', 'pronamic-order-referrer-for-woocommerce' );

	return;
}

?>
<table>
	<thead>
		<tr>
			<th scope="col"><?php esc_html_e( 'Date', 'pronamic-order-referrer-for-woocommerce' ); ?></th>
			<th scope="col"><?php esc_html_e( 'Referrer', 'pronamic-order-referrer-for-woocommerce' ); ?></th>
		</tr>
	</thead>

	<tbody>
		
		<?php foreach ( $referrers_data as $item ) : ?>

			<tr>
				<td>
					<?php echo \esc_html( $item->date ); ?>
				</td>
				<td>
					<?php echo \esc_html( $item->referrer ); ?>
				</td>
			</tr>

		<?php endforeach; ?>

	</tbody>
</table>
