<?php
/**
 * Proceed to checkout button
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 *
 * only change here is moving the echo line up to avoid the generated <br> in the button output
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<a href="<?php echo esc_url( wc_get_checkout_url() ) ;?>" class="checkout-button button alt wc-forward"><?php echo __( 'Proceed to Checkout', 'woocommerce' ); ?></a>