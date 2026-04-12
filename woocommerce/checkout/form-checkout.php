<?php
/**
 * Rezon8 2025 Material — WooCommerce checkout/form-checkout.php
 *
 * @package rezon8-25-material
 */

defined( 'ABSPATH' ) || exit;

if ( ! is_checkout() ) {
	return;
}

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $order = ( isset( $order ) ? $order : false ) ) {
	if ( WC()->cart->is_empty() && ! is_customize_preview() && apply_filters( 'woocommerce_checkout_redirect_empty_cart', true ) ) {
		return;
	}
}
?>
<div class="woocommerce r8-woo-checkout" style="max-width:1100px;margin:0 auto;padding:var(--wp--preset--spacing--70) var(--wp--preset--spacing--40)">
	<?php woocommerce_output_all_notices(); ?>
	<?php do_action( 'woocommerce_before_checkout_form', WC()->checkout() ); ?>

	<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
		<?php if ( $checkout->get_checkout_fields() ) : ?>
			<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
			<div class="col2-set" id="customer_details">
				<div class="col-1"><?php do_action( 'woocommerce_checkout_billing' ); ?></div>
				<div class="col-2"><?php do_action( 'woocommerce_checkout_shipping' ); ?></div>
			</div>
			<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
		<?php endif; ?>
		<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
		<h3 id="order_review_heading"><?php esc_html_e( 'Your order', 'rezon8-25-material' ); ?></h3>
		<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
		<div id="order_review" class="woocommerce-checkout-review-order">
			<?php do_action( 'woocommerce_checkout_order_review' ); ?>
		</div>
		<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
	</form>
	<?php do_action( 'woocommerce_after_checkout_form', WC()->checkout() ); ?>
</div>
