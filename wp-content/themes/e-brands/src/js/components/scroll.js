// Check if scroll behavior smooth is supported
const smoothScrollSupported =
	'scrollBehavior' in document.documentElement.style;

/**
 * Creates a scroll-to-top button and adds event listeners to scroll smoothly to the top of the page when clicked.
 *
 * @param {string} [selector='.to-top'] - The CSS selector for the scroll-to-top button.
 * @param {number} [duration=1500] - The duration of the scroll animation in milliseconds.
 * @param {number} [showOnSCroll=200] - The Scroll value from top to show the button.
 *
 * @todo Check smooth scroll on Safari
 */
function ScrollToTop(selector = '.to-top', duration = 1500, showOnScroll = 200) {
	// Get the scroll-to-top button element
	const toTopButton = document.querySelector( selector );

	// If the scroll-to-top button element does not exist, return
	if ( ! toTopButton ) return;

	// Show/Hide To top button on scroll
	const scrollOffset = typeof showOnScroll === 'number' ? showOnScroll : 200;
	window.addEventListener( 'scroll', function () {
		toTopButton.classList.toggle( 'show', window.scrollY >= scrollOffset );
	} );

	// Add a click event listener to the scroll-to-top button
	toTopButton.addEventListener( 'click', ( e ) => {
		e.preventDefault();
		// Check if scroll behavior smooth is supported
		if ( smoothScrollSupported ) {
			window.scrollTo( {
				top: 0,
				behavior: 'smooth',
			} );
		} else {
			// Scroll animation for browsers that do not support scroll behavior smooth

			// Get the current scroll position
			const scrollYPos = window.scrollY;

			// Animation start time
			let startTime = null;

			/**
			 * Slide the page to the top with animation.
			 *
			 * @param {number} timestamp - The current timestamp.
			 */
			function slideTop( timestamp ) {
				// Set StartTime if null
				if ( ! startTime ) startTime = timestamp;

				// Calculate runtime of the animation
				const runtime = timestamp - startTime;

				// Calculate progress Time of animation relative to duration
				const relativeProgress = runtime / duration;

				// Calculate scroll progress of animation relative to duration
				const scrollProgress =
					scrollYPos - scrollYPos * Math.min( relativeProgress, 1 );

				// update scroll Y position
				window.scroll( 0, scrollProgress );

				// call RAF until runtime is less than duration
				if ( runtime < duration )
					window.requestAnimationFrame( slideTop );
			}

			// initialize slideTop using RAF
			window.requestAnimationFrame( slideTop );
		}
	} );
}

/**
 * Creates a smooth scroll effect when clicking on anchor links on the page.
 *
 * @param {number} duration - The duration of the scroll animation in milliseconds. Default is 1500.
 * @param {string|number} offset - The offset of the scroll position. Can be a CSS selector or a number. Default is 0.
 */
function SmoothScroll( duration = 1500, offset = '.site-header' ) {
	const anchorSelector = 'a[href*="#"]:not([href="#"]):not([role="dialog"])';
	const anchorList = document.querySelectorAll( anchorSelector );
	const scrollDuration = duration;
	let scrollOffset = 0;

	if ( typeof offset === 'string' ) {
		const header = document.querySelector( offset );
		scrollOffset = header ? header.offsetHeight : 0;
		window.addEventListener( 'resize', () => {
			scrollOffset = header ? header.offsetHeight : 0;
		} );
	}
	if ( typeof offset === 'number' ) {
		scrollOffset = offset;
	}

	// set scroll position  to 0 if url has hash and then scroll to hash element
	if ( window.location.hash ) {
		const target = document.querySelector( window.location.hash );
		window.scroll( 0, 0 );
		setTimeout( function () {
			window.scroll( 0, 0 );
			scrollToElement( target, scrollDuration, scrollOffset );
			window.history.replaceState( null, null, window.location.pathname );
		}, 1 );
	}

	if ( anchorList.length ) {
		anchorList.forEach( ( anchor ) => {
			anchor.addEventListener( 'click', ( e ) => {
				e.preventDefault();
				const anchorTarget = document.querySelector( anchor.hash );
				scrollToElement( anchorTarget, scrollDuration, scrollOffset );
				window.history.replaceState(
					null,
					null,
					window.location.pathname
				);
			} );
		} );
	}
}

/**
 * Scrolls to a specified element on the page.
 *
 * @param {Element} destination - The element to scroll to.
 * @param {number} scrollDuration - The duration of the scroll animation.
 * @param {number} offset - The offset from the top of the element to scroll to.
 */
function scrollToElement( destination, scrollDuration, offset ) {
	const duration = scrollDuration;
	const destTop = destination.getBoundingClientRect().top;
	const scrollYPos = window.scrollY;
	const destOffsetTop = destTop + scrollYPos - offset;
	let startTime = null;
	if ( smoothScrollSupported ) {
		window.scrollTo( {
			top: destOffsetTop,
			behavior: 'smooth',
		} );
	} else {
		function animateScroll( timestamp ) {
			// Set StartTime if null
			if ( ! startTime ) startTime = timestamp;

			// Calculate runtime of the animation
			const runtime = timestamp - startTime;

			// Calculate progress Time of animation relative to duration
			const relativeProgress = runtime / duration;

			// Calculate scroll progress of animation relative to duration
			const toScroll =
				destOffsetTop > scrollYPos
					? destOffsetTop - scrollYPos
					: scrollYPos - destOffsetTop;
			const scrollProgress =
				destOffsetTop > scrollYPos
					? scrollYPos + toScroll * Math.min( relativeProgress, 1 )
					: scrollYPos - toScroll * Math.min( relativeProgress, 1 );

			// update scroll Y position
			window.scroll( 0, scrollProgress );

			// call RAF until runtime is less than duration
			if ( runtime < duration )
				window.requestAnimationFrame( animateScroll );
		}

		// initialize slideTop using RAF
		window.requestAnimationFrame( animateScroll );
	}
}

/**
 * Creates a sticky header that fixes to the top of the page when the user scrolls.
 *
 * @param {string} headerElement - The CSS selector for the header element.
 * @param {number} scrollOffset - The number of pixels from the top of the page where the header should become sticky. Default is 0.
 */
function StickyHeader( headerElement = '.site-header', scrollOffset = 150 ) {
	const header = document.querySelector( headerElement );
	const topOffset = typeof scrollOffset === 'number' ? scrollOffset : 0;
	if ( ! header ) return;
	window.addEventListener( 'scroll', function () {
		header.classList.toggle( 'header--fixed', window.scrollY >= topOffset );
	} );
}

export { ScrollToTop, SmoothScroll/*, StickyHeader*/ };
