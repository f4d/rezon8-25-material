<?php
/**
 * Rezon8 2025 Material — inc/animation/class-animation-fields.php
 * Registers scroll-reveal and entrance animation settings for blocks.
 *
 * @package rezon8-25-material
 */

defined( 'ABSPATH' ) || exit;

class R8_Animation_Fields {

	/** @var self|null */
	private static ?self $instance = null;

	/** Animation presets available to editors. */
	public const PRESETS = [
		'none'       => 'None',
		'fade-up'    => 'Fade Up',
		'fade-down'  => 'Fade Down',
		'fade-left'  => 'Fade Left (slide from right)',
		'fade-right' => 'Fade Right (slide from left)',
		'zoom-in'    => 'Zoom In',
		'zoom-out'   => 'Zoom Out',
		'flip-left'  => 'Flip Left',
		'flip-right' => 'Flip Right',
	];

	/** Easing options. */
	public const EASINGS = [
		'ease'         => 'Ease',
		'ease-in'      => 'Ease In',
		'ease-out'     => 'Ease Out',
		'ease-in-out'  => 'Ease In-Out',
		'linear'       => 'Linear',
	];

	public static function instance(): self {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		add_action( 'init', [ $this, 'register_block_attributes' ] );
		add_filter( 'render_block', [ $this, 'apply_animation_attributes' ], 10, 2 );
	}

	/**
	 * Register custom attributes on all block types via server-side filter.
	 * (Editor panel registration is handled by animation-editor.js)
	 */
	public function register_block_attributes(): void {
		// Attributes are added client-side via JS; server handles rendering.
	}

	/**
	 * Add data-r8-animation attributes to block HTML for front-end JS to pick up.
	 */
	public function apply_animation_attributes( string $block_content, array $block ): string {
		if ( empty( $block_content ) ) {
			return $block_content;
		}

		$attrs     = $block['attrs'] ?? [];
		$animation = $attrs['r8Animation']  ?? 'none';
		$duration  = $attrs['r8AnimDuration'] ?? 600;
		$delay     = $attrs['r8AnimDelay']  ?? 0;
		$easing    = $attrs['r8AnimEasing'] ?? 'ease';
		$once      = $attrs['r8AnimOnce']   ?? true;

		if ( 'none' === $animation || empty( $animation ) ) {
			return $block_content;
		}

		$data_attrs = sprintf(
			' data-r8-anim="%s" data-r8-duration="%d" data-r8-delay="%d" data-r8-easing="%s" data-r8-once="%s"',
			esc_attr( $animation ),
			absint( $duration ),
			absint( $delay ),
			esc_attr( $easing ),
			$once ? 'true' : 'false'
		);

		// Inject into the first tag of the block HTML.
		return preg_replace( '/^(<\w[^>]*)>/', '$1' . $data_attrs . '>', $block_content, 1 )
			?? $block_content;
	}

	/**
	 * Get animation presets as JSON for editor script.
	 */
	public static function get_presets_json(): string {
		return wp_json_encode( self::PRESETS );
	}

	/**
	 * Get easing options as JSON for editor script.
	 */
	public static function get_easings_json(): string {
		return wp_json_encode( self::EASINGS );
	}
}

// Boot singleton.
R8_Animation_Fields::instance();
