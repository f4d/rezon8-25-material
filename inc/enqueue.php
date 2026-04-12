<?php
/**
 * Rezon8 2025 Material — inc/enqueue.php
 * Centralised asset enqueuing: styles, fonts, scripts.
 *
 * @package rezon8-25-material
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue front-end styles and scripts.
 */
add_action( 'wp_enqueue_scripts', 'r8_enqueue_frontend_assets' );
function r8_enqueue_frontend_assets(): void {

	$ver = wp_get_theme()->get( 'Version' );

	// ── Parent theme ──────────────────────────────────────────────────────────
	wp_enqueue_style(
		'twentytwentyfive-style',
		get_template_directory_uri() . '/style.css',
		[],
		wp_get_theme( 'twentytwentyfive' )->get( 'Version' )
	);

	// ── Child stylesheet ──────────────────────────────────────────────────────
	wp_enqueue_style(
		'rezon8-material-style',
		get_stylesheet_uri(),
		[ 'twentytwentyfive-style' ],
		$ver
	);

	// ── Google Fonts — Roboto ─────────────────────────────────────────────────
	wp_enqueue_style(
		'r8-google-fonts',
		'https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400&display=swap',
		[],
		null
	);

	// ── Theme JS ──────────────────────────────────────────────────────────────
	wp_enqueue_script(
		'rezon8-material-js',
		get_stylesheet_directory_uri() . '/assets/js/theme.js',
		[],
		$ver,
		true
	);

	// ── Animation system ─────────────────────────────────────────────────────
	if ( r8_animation_enabled() ) {
		wp_enqueue_style(
			'r8-animation',
			get_stylesheet_directory_uri() . '/inc/animation/animation-frontend.css',
			[],
			$ver
		);
		wp_enqueue_script(
			'r8-animation-js',
			get_stylesheet_directory_uri() . '/inc/animation/animation-frontend.js',
			[],
			$ver,
			true
		);
	}

	// ── Pass data to JS ──────────────────────────────────────────────────────
	wp_localize_script( 'rezon8-material-js', 'r8Config', [
		'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
		'nonce'     => wp_create_nonce( 'r8_nonce' ),
		'themeUrl'  => get_stylesheet_directory_uri(),
		'isLoggedIn' => is_user_logged_in(),
	] );
}

/**
 * Enqueue block editor assets.
 */
add_action( 'enqueue_block_editor_assets', 'r8_enqueue_editor_assets' );
function r8_enqueue_editor_assets(): void {
	$ver = wp_get_theme()->get( 'Version' );

	wp_enqueue_style(
		'r8-editor-google-fonts',
		'https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300&display=swap',
		[],
		null
	);

	wp_enqueue_style(
		'r8-editor-style',
		get_stylesheet_directory_uri() . '/assets/css/editor.css',
		[],
		$ver
	);

	// Animation fields editor script
	if ( r8_animation_enabled() ) {
		wp_enqueue_script(
			'r8-animation-editor',
			get_stylesheet_directory_uri() . '/inc/animation/animation-editor.js',
			[ 'wp-blocks', 'wp-element', 'wp-components', 'wp-block-editor' ],
			$ver,
			true
		);
	}
}

/**
 * Check if animation system is enabled via theme option.
 */
function r8_animation_enabled(): bool {
	return (bool) get_theme_mod( 'r8_enable_animations', true );
}
