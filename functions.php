<?php
/**
 * Rezon8 Child Theme — functions.php
 *
 * Bootstraps the Twenty Twenty-Five child theme with:
 *  - Parent theme stylesheet
 *  - Google Fonts (Roboto family)
 *  - Material Design CSS layer
 *  - Child theme overrides
 *
 * @package RezonEight_Child
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

// ── Theme Setup ───────────────────────────────────────────────────────────────

add_action( 'after_setup_theme', 'rezon8_child_setup' );
function rezon8_child_setup() {
	load_child_theme_textdomain( 'rezon8-child', get_stylesheet_directory() . '/languages' );
}

// ── Enqueue Styles & Scripts ──────────────────────────────────────────────────

add_action( 'wp_enqueue_scripts', 'rezon8_child_enqueue' );
function rezon8_child_enqueue() {

	/* 1. Parent theme stylesheet */
	wp_enqueue_style(
		'twentytwentyfive-style',
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme( 'twentytwentyfive' )->get( 'Version' )
	);

	/* 2. Google Fonts — Roboto (300, 400, 500, 700) + Roboto Mono */
	wp_enqueue_style(
		'rezon8-google-fonts',
		'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Roboto+Mono:wght@400;500&display=swap',
		array(),
		null
	);

	/* 3. Material Icons (outlined) */
	wp_enqueue_style(
		'rezon8-material-icons',
		'https://fonts.googleapis.com/icon?family=Material+Icons+Outlined',
		array(),
		null
	);

	/* 4. Child theme base (style.css — variables + reset) */
	wp_enqueue_style(
		'rezon8-child-style',
		get_stylesheet_uri(),
		array( 'twentytwentyfive-style' ),
		wp_get_theme()->get( 'Version' )
	);

	/* 5. Material component overrides */
	wp_enqueue_style(
		'rezon8-material',
		get_stylesheet_directory_uri() . '/assets/css/material.css',
		array( 'rezon8-child-style' ),
		wp_get_theme()->get( 'Version' )
	);

	/* 6. Child theme JS (deferred) */
	wp_enqueue_script(
		'rezon8-child-js',
		get_stylesheet_directory_uri() . '/assets/js/main.js',
		array(),
		wp_get_theme()->get( 'Version' ),
		array( 'strategy' => 'defer', 'in_footer' => true )
	);
}

// ── Block Editor Styles ───────────────────────────────────────────────────────

add_action( 'enqueue_block_editor_assets', 'rezon8_child_editor_styles' );
function rezon8_child_editor_styles() {
	wp_enqueue_style(
		'rezon8-editor-style',
		get_stylesheet_directory_uri() . '/assets/css/editor.css',
		array(),
		wp_get_theme()->get( 'Version' )
	);
}

// ── Utility: allow SVG uploads ────────────────────────────────────────────────

add_filter( 'upload_mimes', 'rezon8_child_allow_svg' );
function rezon8_child_allow_svg( $mimes ) {
	$mimes['svg']  = 'image/svg+xml';
	$mimes['svgz'] = 'image/svg+xml';
	return $mimes;
}

add_filter( 'safe_svg_optimizer_enabled', '__return_true' );

// ── URLParam shortcode (migrated from legacy functions.php) ───────────────────

add_shortcode( 'URLParam', 'rezon8_urlparam_shortcode' );
function rezon8_urlparam_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'param'   => '',
			'default' => 'Not Supplied',
		),
		$atts
	);
	if ( ! empty( $atts['param'] ) && isset( $_GET[ $atts['param'] ] ) ) {
		return esc_html( $_GET[ $atts['param'] ] );
	}
	return esc_html( $atts['default'] );
}

// ── Performance: preconnect Google Fonts ─────────────────────────────────────

add_action( 'wp_head', 'rezon8_child_preconnect', 1 );
function rezon8_child_preconnect() {
	echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}
