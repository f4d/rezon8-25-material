<?php
/**
 * Rezon8 2025 Material — WooCommerce myaccount/my-account.php
 *
 * @package rezon8-25-material
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="primary" class="site-main r8-woo-account">
	<div class="r8-container" style="padding:var(--wp--preset--spacing--70) var(--wp--preset--spacing--40);max-width:1100px;margin:0 auto">
		<h1 style="font-weight:300;margin-bottom:var(--wp--preset--spacing--50)"><?php esc_html_e( 'My Account', 'rezon8-25-material' ); ?></h1>
		<?php woocommerce_output_all_notices(); ?>
		<div class="woocommerce">
			<?php do_action( 'woocommerce_account_navigation' ); ?>
			<div class="woocommerce-MyAccount-content">
				<?php do_action( 'woocommerce_account_content' ); ?>
			</div>
		</div>
	</div>
</main>
<?php get_footer(); ?>
