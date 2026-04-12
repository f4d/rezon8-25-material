<?php
/**
 * Rezon8 2025 Material — WooCommerce cart/cart.php
 * Minimal override — defers to WooCommerce hooks with Material styling applied via CSS.
 *
 * @package rezon8-25-material
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="primary" class="site-main r8-woo-cart">
	<div class="r8-container" style="padding:var(--wp--preset--spacing--70) var(--wp--preset--spacing--40);max-width:1100px;margin:0 auto">
		<h1 class="r8-page-title" style="font-weight:300;margin-bottom:var(--wp--preset--spacing--50)"><?php echo esc_html__( 'Shopping Cart', 'rezon8-25-material' ); ?></h1>
		<?php woocommerce_output_all_notices(); ?>
		<?php do_action( 'woocommerce_cart_page_content' ); ?>
	</div>
</main>
<?php get_footer(); ?>
