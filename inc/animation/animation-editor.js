/**
 * Rezon8 2025 Material — animation-editor.js
 * Adds a "Rezon8 Animation" panel to the block editor sidebar
 * for every block that supports the InspectorControls API.
 */

( function ( wp ) {
	'use strict';

	const { addFilter }        = wp.hooks;
	const { createHigherOrderComponent } = wp.compose;
	const { Fragment }         = wp.element;
	const { InspectorControls }= wp.blockEditor;
	const { PanelBody, SelectControl, RangeControl, ToggleControl } = wp.components;
	const { __  }              = wp.i18n;

	// ── Attribute Definitions ────────────────────────────────────────────────
	const ANIMATION_ATTRIBUTES = {
		r8Animation:    { type: 'string',  default: 'none'    },
		r8AnimDuration: { type: 'integer', default: 600       },
		r8AnimDelay:    { type: 'integer', default: 0         },
		r8AnimEasing:   { type: 'string',  default: 'ease'    },
		r8AnimOnce:     { type: 'boolean', default: true      },
	};

	const PRESETS = [
		{ label: __( 'None', 'rezon8-25-material' ),                value: 'none'       },
		{ label: __( 'Fade Up', 'rezon8-25-material' ),             value: 'fade-up'    },
		{ label: __( 'Fade Down', 'rezon8-25-material' ),           value: 'fade-down'  },
		{ label: __( 'Fade Left (from right)', 'rezon8-25-material' ), value: 'fade-left'  },
		{ label: __( 'Fade Right (from left)', 'rezon8-25-material' ), value: 'fade-right' },
		{ label: __( 'Zoom In', 'rezon8-25-material' ),             value: 'zoom-in'    },
		{ label: __( 'Zoom Out', 'rezon8-25-material' ),            value: 'zoom-out'   },
		{ label: __( 'Flip Left', 'rezon8-25-material' ),           value: 'flip-left'  },
		{ label: __( 'Flip Right', 'rezon8-25-material' ),          value: 'flip-right' },
	];

	const EASINGS = [
		{ label: 'Ease',        value: 'ease'        },
		{ label: 'Ease In',     value: 'ease-in'     },
		{ label: 'Ease Out',    value: 'ease-out'    },
		{ label: 'Ease In-Out', value: 'ease-in-out' },
		{ label: 'Linear',      value: 'linear'      },
	];

	// Blocks to exclude from animation panel
	const EXCLUDED_BLOCKS = new Set( [
		'core/html',
		'core/shortcode',
		'core/freeform',
		'core/template-part',
	] );

	// ── Add Attributes ───────────────────────────────────────────────────────
	addFilter(
		'blocks.registerBlockType',
		'rezon8-material/add-animation-attributes',
		( settings, name ) => {
			if ( EXCLUDED_BLOCKS.has( name ) ) return settings;
			return {
				...settings,
				attributes: {
					...( settings.attributes || {} ),
					...ANIMATION_ATTRIBUTES,
				},
			};
		}
	);

	// ── Inspector Panel ──────────────────────────────────────────────────────
	const withAnimationControls = createHigherOrderComponent( ( BlockEdit ) => {
		return ( props ) => {
			if ( EXCLUDED_BLOCKS.has( props.name ) ) {
				return wp.element.createElement( BlockEdit, props );
			}

			const { attributes, setAttributes } = props;
			const {
				r8Animation, r8AnimDuration, r8AnimDelay,
				r8AnimEasing, r8AnimOnce,
			} = attributes;

			return wp.element.createElement(
				Fragment,
				null,
				wp.element.createElement( BlockEdit, props ),
				wp.element.createElement(
					InspectorControls,
					{ key: 'r8-animation-controls' },
					wp.element.createElement(
						PanelBody,
						{
							title: __( 'Rezon8 Animation', 'rezon8-25-material' ),
							initialOpen: false,
						},
						wp.element.createElement( SelectControl, {
							label:    __( 'Animation', 'rezon8-25-material' ),
							value:    r8Animation,
							options:  PRESETS,
							onChange: ( val ) => setAttributes( { r8Animation: val } ),
						} ),
						'none' !== r8Animation && wp.element.createElement(
							Fragment,
							null,
							wp.element.createElement( RangeControl, {
								label:    __( 'Duration (ms)', 'rezon8-25-material' ),
								value:    r8AnimDuration,
								min:      100,
								max:      2000,
								step:     50,
								onChange: ( val ) => setAttributes( { r8AnimDuration: val } ),
							} ),
							wp.element.createElement( RangeControl, {
								label:    __( 'Delay (ms)', 'rezon8-25-material' ),
								value:    r8AnimDelay,
								min:      0,
								max:      1500,
								step:     50,
								onChange: ( val ) => setAttributes( { r8AnimDelay: val } ),
							} ),
							wp.element.createElement( SelectControl, {
								label:    __( 'Easing', 'rezon8-25-material' ),
								value:    r8AnimEasing,
								options:  EASINGS,
								onChange: ( val ) => setAttributes( { r8AnimEasing: val } ),
							} ),
							wp.element.createElement( ToggleControl, {
								label:    __( 'Animate only once', 'rezon8-25-material' ),
								checked:  r8AnimOnce,
								onChange: ( val ) => setAttributes( { r8AnimOnce: val } ),
							} )
						)
					)
				)
			);
		};
	}, 'withAnimationControls' );

	addFilter(
		'editor.BlockEdit',
		'rezon8-material/animation-controls',
		withAnimationControls
	);

} )( window.wp );
