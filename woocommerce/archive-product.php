<?php
/**
 * Rezon8 2025 Material — WooCommerce archive-product.php
 * Shop/archive page template with Material Design styling.
 *
 * @package rezon8-25-material
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main id="primary" class="site-main r8-woo-archive">

	<?php
	/**
	 * Hook: woocommerce_before_main_content.
	 * - woocommerce_output_content_wrapper     - 10
	 * - woocommerce_breadcrumb                 - 20
	 * - WC_Structured_Data::generate_website_data - 30
	 */
	do_action( 'woocommerce_before_main_content' );
	?>

	<div class="r8-shop-header">
		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
			<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
		<?php endif; ?>

		<?php
		/**
		 * Hook: woocommerce_archive_description.
		 * - woocommerce_taxonomy_archive_description  - 10
		 * - woocommerce_product_archive_description   - 10
		 */
		do_action( 'woocommerce_archive_description' );
		?>
	</div>

	<?php if ( woocommerce_product_loop() ) : ?>

		<?php
		/**
		 * Hook: woocommerce_before_shop_loop.
		 * - woocommerce_output_all_notices        - 10
		 * - woocommerce_result_count              - 20
		 * - woocommerce_catalog_ordering          - 30
		 */
		do_action( 'woocommerce_before_shop_loop' );
		?>

		<?php woocommerce_product_loop_start(); ?>

		<?php if ( wc_get_loop_prop( 'total' ) ) : ?>
			<?php while ( have_posts() ) : ?>
				<?php the_post(); ?>
				<?php wc_get_template_part( 'content', 'product' ); ?>
			<?php endwhile; ?>
		<?php endif; ?>

		<?php woocommerce_product_loop_end(); ?>

		<?php
		/**
		 * Hook: woocommerce_after_shop_loop.
		 * - woocommerce_pagination               - 10
		 */
		do_action( 'woocommerce_after_shop_loop' );
		?>

	<?php else : ?>
		<?php
		/**
		 * Hook: woocommerce_no_products_found.
		 * - wc_no_products_found                 - 10
		 */
		do_action( 'woocommerce_no_products_found' );
		?>
	<?php endif; ?>

	<?php
	/**
	 * Hook: woocommerce_after_main_content.
	 * - woocommerce_output_content_wrapper_end  - 10
	 */
	do_action( 'woocommerce_after_main_content' );
	?>

</main>

<?php get_footer(); ?>
