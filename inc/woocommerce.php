<?php
/**
 * Rezon8 2025 Material — inc/woocommerce.php
 * WooCommerce compatibility and customizations.
 *
 * @package rezon8-25-material
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

/**
 * Declare WooCommerce theme support.
 */
add_action( 'after_setup_theme', 'r8_woocommerce_setup' );
function r8_woocommerce_setup(): void {
	add_theme_support( 'woocommerce', [
		'thumbnail_image_width' => 400,
		'single_image_width'    => 800,
		'product_grid'          => [
			'default_rows'    => 3,
			'min_rows'        => 2,
			'max_rows'        => 6,
			'default_columns' => 3,
			'min_columns'     => 2,
			'max_columns'     => 4,
		],
	] );

	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}

/**
 * Enqueue WooCommerce compatibility styles.
 */
add_action( 'wp_enqueue_scripts', 'r8_woocommerce_scripts' );
function r8_woocommerce_scripts(): void {
	if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() && ! is_account_page() ) {
		return;
	}
	wp_enqueue_style(
		'r8-woocommerce',
		get_stylesheet_directory_uri() . '/assets/css/woocommerce.css',
		[ 'woocommerce-general' ],
		wp_get_theme()->get( 'Version' )
	);
}

/**
 * Remove WooCommerce default styles selectively.
 */
add_filter( 'woocommerce_enqueue_styles', 'r8_woocommerce_dequeue_styles' );
function r8_woocommerce_dequeue_styles( array $styles ): array {
	// Keep layout and small-screen; remove blockui and prettyPhoto
	unset( $styles['woocommerce-blockui'] );
	unset( $styles['woocommerce-prettyPhoto-css'] );
	return $styles;
}

/**
 * Customise product loop columns.
 */
add_filter( 'loop_shop_columns', 'r8_loop_columns' );
function r8_loop_columns(): int {
	return 3;
}

/**
 * Show 12 products per page.
 */
add_filter( 'loop_shop_per_page', 'r8_products_per_page' );
function r8_products_per_page(): int {
	return 12;
}

/**
 * Wrap product loop in Material card.
 */
add_action( 'woocommerce_before_shop_loop_item', 'r8_product_card_open', 5 );
function r8_product_card_open(): void {
	echo '<div class="r8-card r8-product-card">';
}

add_action( 'woocommerce_after_shop_loop_item', 'r8_product_card_close', 999 );
function r8_product_card_close(): void {
	echo '</div>';
}

/**
 * Remove sidebar from WooCommerce pages.
 */
add_filter( 'woocommerce_output_sidebar', '__return_false' );

/**
 * Change "Add to cart" button text.
 */
add_filter( 'woocommerce_product_add_to_cart_text', 'r8_add_to_cart_text', 10, 1 );
function r8_add_to_cart_text( string $text ): string {
	return esc_html__( 'Add to Cart', 'rezon8-25-material' );
}

/**
 * WooCommerce breadcrumb defaults.
 */
add_filter( 'woocommerce_breadcrumb_defaults', 'r8_woocommerce_breadcrumbs' );
function r8_woocommerce_breadcrumbs( array $defaults ): array {
	$defaults['delimiter']   = ' <span class="r8-breadcrumb-sep" aria-hidden="true">/</span> ';
	$defaults['wrap_before'] = '<nav class="r8-breadcrumb woocommerce-breadcrumb" aria-label="breadcrumb">';
	$defaults['wrap_after']  = '</nav>';
	return $defaults;
}
