<?php
/**
 * Rezon8 2025 Material — inc/widgets.php
 * Custom widget areas and widget registrations.
 *
 * @package rezon8-25-material
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register widget areas.
 */
add_action( 'widgets_init', 'r8_register_sidebars' );
function r8_register_sidebars(): void {

	$sidebars = [
		[
			'name'          => __( 'Blog Sidebar', 'rezon8-25-material' ),
			'id'            => 'r8-sidebar-blog',
			'description'   => __( 'Widgets in the blog/post sidebar.', 'rezon8-25-material' ),
		],
		[
			'name'          => __( 'Page Right Sidebar', 'rezon8-25-material' ),
			'id'            => 'r8-sidebar-page-right',
			'description'   => __( 'Widgets for the right sidebar on pages.', 'rezon8-25-material' ),
		],
		[
			'name'          => __( 'Page Left Sidebar', 'rezon8-25-material' ),
			'id'            => 'r8-sidebar-page-left',
			'description'   => __( 'Widgets for the left sidebar on pages.', 'rezon8-25-material' ),
		],
		[
			'name'          => __( 'Footer Column 1', 'rezon8-25-material' ),
			'id'            => 'r8-footer-1',
			'description'   => __( 'First footer widget column.', 'rezon8-25-material' ),
		],
		[
			'name'          => __( 'Footer Column 2', 'rezon8-25-material' ),
			'id'            => 'r8-footer-2',
			'description'   => __( 'Second footer widget column.', 'rezon8-25-material' ),
		],
		[
			'name'          => __( 'Footer Column 3', 'rezon8-25-material' ),
			'id'            => 'r8-footer-3',
			'description'   => __( 'Third footer widget column.', 'rezon8-25-material' ),
		],
		[
			'name'          => __( 'WooCommerce Sidebar', 'rezon8-25-material' ),
			'id'            => 'r8-sidebar-woo',
			'description'   => __( 'Widgets for WooCommerce shop pages.', 'rezon8-25-material' ),
		],
	];

	$defaults = [
		'before_widget' => '<div id="%1$s" class="widget r8-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title r8-widget-title">',
		'after_title'   => '</h4>',
	];

	foreach ( $sidebars as $sidebar ) {
		register_sidebar( array_merge( $defaults, $sidebar ) );
	}
}
