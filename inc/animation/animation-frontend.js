/**
 * Rezon8 2025 Material — animation-frontend.js
 * Scroll-reveal animation engine using IntersectionObserver.
 * Reads data-r8-anim attributes set by class-animation-fields.php.
 */

( function () {
	'use strict';

	const ATTR = 'data-r8-anim';

	/**
	 * Build the initial CSS transform + opacity for a given preset.
	 */
	function getInitialStyle( preset ) {
		const distance = '30px';
		const map = {
			'fade-up':    { opacity: 0, transform: `translateY(${ distance })` },
			'fade-down':  { opacity: 0, transform: `translateY(-${ distance })` },
			'fade-left':  { opacity: 0, transform: `translateX(${ distance })` },
			'fade-right': { opacity: 0, transform: `translateX(-${ distance })` },
			'zoom-in':    { opacity: 0, transform: 'scale(0.85)' },
			'zoom-out':   { opacity: 0, transform: 'scale(1.15)' },
			'flip-left':  { opacity: 0, transform: 'perspective(600px) rotateY(-30deg)' },
			'flip-right': { opacity: 0, transform: 'perspective(600px) rotateY(30deg)' },
		};
		return map[ preset ] || { opacity: 0 };
	}

	/**
	 * Apply initial hidden state to an element.
	 */
	function hideElement( el ) {
		const preset   = el.getAttribute( ATTR );
		const initial  = getInitialStyle( preset );
		const duration = parseInt( el.getAttribute( 'data-r8-duration' ) || '600', 10 );
		const delay    = parseInt( el.getAttribute( 'data-r8-delay' )    || '0',   10 );
		const easing   = el.getAttribute( 'data-r8-easing' ) || 'ease';

		Object.assign( el.style, {
			...initial,
			transition: `opacity ${ duration }ms ${ easing } ${ delay }ms, transform ${ duration }ms ${ easing } ${ delay }ms`,
			willChange: 'opacity, transform',
		} );

		el.setAttribute( 'data-r8-anim-ready', 'true' );
	}

	/**
	 * Reveal an element (animate to final state).
	 */
	function revealElement( el ) {
		el.style.opacity   = '1';
		el.style.transform = 'none';
		el.setAttribute( 'data-r8-anim-done', 'true' );
	}

	/**
	 * Reset element (for repeat animations).
	 */
	function resetElement( el ) {
		if ( el.getAttribute( 'data-r8-anim-ready' ) === 'true' ) {
			hideElement( el );
			el.removeAttribute( 'data-r8-anim-done' );
		}
	}

	/**
	 * Initialise all animated elements on the page.
	 */
	function init() {
		const elements = document.querySelectorAll( `[${ ATTR }]:not([${ ATTR }="none"])` );

		if ( ! elements.length ) return;

		// Respect prefers-reduced-motion
		const reducedMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
		if ( reducedMotion ) return;

		// Set initial hidden state
		elements.forEach( hideElement );

		// Set up IntersectionObserver
		const observer = new IntersectionObserver( ( entries ) => {
			entries.forEach( ( entry ) => {
				const el   = entry.target;
				const once = el.getAttribute( 'data-r8-once' ) !== 'false';

				if ( entry.isIntersecting ) {
					revealElement( el );
					if ( once ) observer.unobserve( el );
				} else if ( ! once && el.getAttribute( 'data-r8-anim-done' ) ) {
					resetElement( el );
				}
			} );
		}, {
			threshold: 0.12,
			rootMargin: '0px 0px -40px 0px',
		} );

		elements.forEach( ( el ) => observer.observe( el ) );
	}

	// Run after DOM is ready
	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}

} )();
