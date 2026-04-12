<?php
/**
 * Rezon8 2025 Material — inc/meta-boxes.php
 * Custom meta boxes for page/post settings.
 * Uses CMB2 if available, otherwise native WordPress meta boxes.
 *
 * @package rezon8-25-material
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register meta boxes via CMB2 (preferred) or native.
 */
add_action( 'cmb2_admin_init', 'r8_register_cmb2_meta_boxes' );
function r8_register_cmb2_meta_boxes(): void {

	// ── Page Settings ─────────────────────────────────────────────────────────
	$page_settings = new_cmb2_box( [
		'id'           => 'r8_page_settings',
		'title'        => __( 'Rezon8 Page Settings', 'rezon8-25-material' ),
		'object_types' => [ 'page', 'post' ],
		'context'      => 'normal',
		'priority'     => 'high',
		'show_names'   => true,
	] );

	$page_settings->add_field( [
		'name'    => __( 'Page Layout', 'rezon8-25-material' ),
		'id'      => '_r8_page_layout',
		'type'    => 'select',
		'default' => 'default',
		'options' => [
			'default'          => __( 'Default', 'rezon8-25-material' ),
			'full-width'       => __( 'Full Width', 'rezon8-25-material' ),
			'full-width-bare'  => __( 'Full Width (No Header/Footer)', 'rezon8-25-material' ),
			'right-sidebar'    => __( 'Right Sidebar', 'rezon8-25-material' ),
			'left-sidebar'     => __( 'Left Sidebar', 'rezon8-25-material' ),
		],
	] );

	$page_settings->add_field( [
		'name'        => __( 'Hero Image Override', 'rezon8-25-material' ),
		'id'          => '_r8_hero_image',
		'type'        => 'file',
		'options'     => [ 'url' => false ],
		'text'        => [ 'add_upload_file_text' => __( 'Upload Hero Image', 'rezon8-25-material' ) ],
	] );

	$page_settings->add_field( [
		'name'    => __( 'Hide Page Title', 'rezon8-25-material' ),
		'id'      => '_r8_hide_title',
		'type'    => 'checkbox',
		'default' => '',
	] );

	$page_settings->add_field( [
		'name'    => __( 'Custom Hero Background Color', 'rezon8-25-material' ),
		'id'      => '_r8_hero_bg_color',
		'type'    => 'colorpicker',
		'default' => '#0d0d0d',
	] );

	// ── SEO Override (lightweight, not a replacement for Yoast) ──────────────
	$seo = new_cmb2_box( [
		'id'           => 'r8_seo_override',
		'title'        => __( 'Rezon8 SEO Override', 'rezon8-25-material' ),
		'object_types' => [ 'page', 'post', 'service' ],
		'context'      => 'normal',
		'priority'     => 'low',
	] );

	$seo->add_field( [
		'name'       => __( 'Custom Meta Description', 'rezon8-25-material' ),
		'id'         => '_r8_meta_desc',
		'type'       => 'textarea_small',
		'attributes' => [ 'maxlength' => 160 ],
	] );

	$seo->add_field( [
		'name' => __( 'OG Image Override', 'rezon8-25-material' ),
		'id'   => '_r8_og_image',
		'type' => 'file',
	] );
}

/**
 * Fall back to native meta boxes if CMB2 not active.
 */
add_action( 'add_meta_boxes', 'r8_native_meta_boxes' );
function r8_native_meta_boxes(): void {
	if ( function_exists( 'cmb2_bootstrap' ) ) {
		return; // CMB2 is handling it
	}

	add_meta_box(
		'r8_page_layout',
		__( 'Page Layout', 'rezon8-25-material' ),
		'r8_page_layout_meta_box_html',
		[ 'page', 'post' ],
		'side',
		'default'
	);
}

function r8_page_layout_meta_box_html( WP_Post $post ): void {
	wp_nonce_field( 'r8_page_layout_nonce', 'r8_page_layout_nonce' );
	$layout = get_post_meta( $post->ID, '_r8_page_layout', true ) ?: 'default';
	$options = [
		'default'         => __( 'Default', 'rezon8-25-material' ),
		'full-width'      => __( 'Full Width', 'rezon8-25-material' ),
		'full-width-bare' => __( 'Full Width (No Header/Footer)', 'rezon8-25-material' ),
		'right-sidebar'   => __( 'Right Sidebar', 'rezon8-25-material' ),
		'left-sidebar'    => __( 'Left Sidebar', 'rezon8-25-material' ),
	];
	echo '<label for="r8_page_layout">' . esc_html__( 'Select Layout:', 'rezon8-25-material' ) . '</label>';
	echo '<select name="r8_page_layout" id="r8_page_layout" style="width:100%;margin-top:4px">';
	foreach ( $options as $val => $label ) {
		printf( '<option value="%s"%s>%s</option>', esc_attr( $val ), selected( $layout, $val, false ), esc_html( $label ) );
	}
	echo '</select>';
}

add_action( 'save_post', 'r8_save_page_layout_meta' );
function r8_save_page_layout_meta( int $post_id ): void {
	if ( ! isset( $_POST['r8_page_layout_nonce'] ) ) return;
	if ( ! wp_verify_nonce( $_POST['r8_page_layout_nonce'], 'r8_page_layout_nonce' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;
	if ( isset( $_POST['r8_page_layout'] ) ) {
		update_post_meta( $post_id, '_r8_page_layout', sanitize_text_field( $_POST['r8_page_layout'] ) );
	}
}
