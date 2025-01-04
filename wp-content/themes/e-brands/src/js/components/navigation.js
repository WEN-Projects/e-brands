class Navigation {
	constructor( args = {} ) {
		this.options = {
			mainNavigation: '.main-navigation',
			menuToggler: '.menu-toggle',
			menuWrapper: '.menu-menu-1-container',
			menu: '.menu',
			disableBackgroundScroll: true,
			breakpoint: 991,
			submenuTransitionDuration: 0.4,
			...args,
		};

		this.initNavigation();
	}

	isMobile() {
		let isMobile = window.matchMedia(
			`(max-width: ${ this.options.breakpoint }px)`
		).matches;

		window.addEventListener( 'resize', () => {
			isMobile = window.matchMedia(
				`(max-width: ${ this.options.breakpoint }px)`
			).matches;
		} );

		return isMobile;
	}

	initNavigation() {
		const { mainNavigation, menuToggler, menu } = this.options;

		// Get main navigation wrapper
		this.mainNavigation = document.querySelector( mainNavigation );

		// Return Early if navigation not found
		if ( ! this.mainNavigation ) return;

		// Get Menu Toggler and Menu
		this.menuToggler = this.mainNavigation.querySelector( menuToggler );
		this.menu = this.mainNavigation.querySelector( menu );

		// Return Early if menu Toggler or menu not found
		if ( ! this.menuToggler || ! this.menu ) return;

		// Add click event to menu toggler to toggle menu
		this.menuToggler.addEventListener(
			'click',
			this.toggleMenu.bind( this )
		);

		// Close menu when clicked outside menu
		document.addEventListener( 'click', ( e ) => {
			if (
				e.target === this.mainNavigation ||
				this.mainNavigation.contains( e.target )
			)
				return;
			this.closeMenu();
		} );
	}

	toggleMenu() {
		const isToggled = this.mainNavigation.classList.toggle( 'toggled' );

		// Toggle aria-expanded attribute of menu toggler
		this.menuToggler.setAttribute( 'aria-expanded', isToggled );

		// Disable/Enable background Scroll
		this.disableBackgroundScroll( isToggled );
	}

	closeMenu() {
		this.mainNavigation.classList.remove( 'toggled' );
		this.menuToggler.setAttribute( 'aria-expanded', 'false' );
		document.body.style.overflow = null;
		document.body.classList.remove( 'menu-opened' );
	}

	disableBackgroundScroll( isToggled ) {
		if ( ! this.options.disableBackgroundScroll ) return;
		document.body.style.overflow = isToggled ? 'hidden' : null;
		document.body.classList.toggle( 'menu-opened', isToggled );
	}
}

class NavigationWithDropdown extends Navigation {
	constructor() {
		super();
		this.initDropdownMenu();
	}

	initDropdownMenu() {
		// Get menu items containing sub menus
		this.menuItems = Array.from(
			this.menu.querySelectorAll( '.menu-item-has-children' )
		);

		if ( ! this.menuItems.length ) return;

		this.menuItems.forEach( ( menuItem ) => {
			// Get submenu
			const submenu = menuItem.querySelector( '.sub-menu' );

			// Append arrow before each submenu
			this.appendDropdownArrow( submenu );

			// Set default styles
			this.toggleSubmenuStyle( submenu, menuItem );

			// Handle window resize
			window.addEventListener( 'resize', () =>
				this.toggleSubmenuStyle( submenu, menuItem )
			);

			// Add Click event ot menu item to toggle submenu
			menuItem.addEventListener( 'click', ( e ) => {
				if ( ! this.isMobile() ) return;

				e.stopPropagation();
				// Check if the clicked element is an anchor tag
				if ( e.target.tagName === 'A' ) {
					e.preventDefault();

					// Get the href attribute of the anchor tag
					const href = e.target.getAttribute( 'href' );

					// Check if the href attribute is equal to '#'
					if (
						menuItem.classList.contains( 'open' ) &&
						! href.startsWith( '#' )
					) {
						window.location.href = href;
						this.closeDropdownMenu();
					} else {
						this.toggleDropdownMenu( menuItem, submenu );
					}
				} else {
					this.toggleDropdownMenu( menuItem, submenu );
				}
			} );
		} );

		this.menuToggler.addEventListener(
			'click',
			this.closeDropdownMenu.bind( this )
		);

		// Close menu when clicked outside menu
		document.addEventListener( 'click', ( e ) => {
			if (
				e.target === this.mainNavigation ||
				this.mainNavigation.contains( e.target )
			)
				return;
			this.closeDropdownMenu();
		} );
	}

	/**
	 * Toggles the submenu style based on the current window width.
	 * @param {HTMLElement} submenu - The submenu element to toggle.
	 * @param {HTMLElement} menuItem - The menu item element to toggle.
	 */
	toggleSubmenuStyle( submenu, menuItem ) {
		// Set the submenu display style based on mobile view
		submenu.style.display = this.isMobile() ? 'block' : '';

		// Set the submenu height style based on mobile view
		submenu.style.height = this.isMobile() ? '0' : '';

		// Remove 'open' class from all menu Item
		menuItem.classList.remove( 'open' );

		if ( ! this.isMobile() && menuItem.parentElement === this.menu ) {
			const allSubmenus = Array.from( menuItem.querySelectorAll( 'ul' ) );
			allSubmenus.forEach( ( item ) => {
				const { x, width } = item.getBoundingClientRect();
				const menuPosX = x + width;
				menuPosX > window.innerWidth
					? item.classList.add( 'pos-left' )
					: null;
			} );
		}
	}

	appendDropdownArrow( submenu ) {
		const arrow = document.createElement( 'span' );
		arrow.className = 'dropdown-arrow';
		submenu.before( arrow );
	}

	calcSubmenuHeight( submenu ) {
		const submenuChildren = Array.from( submenu.children );
		const height = submenuChildren.reduce(
			( acc, child ) => acc + child.offsetHeight,
			0
		);
		return height;
	}

	toggleDropdownMenu( menuItem, submenu ) {
		const isOpen = menuItem.classList.toggle( 'open' );

		// Get all siblings of the current menu item that are also 'opened'
		let siblings = Array.from( menuItem.parentElement.children ).filter(
			( item ) => item !== menuItem && item.classList.contains( 'open' )
		);

		// If there are siblings, remove the 'open' class from the first sibling
		// and toggle the submenu for the current menu item and sibling
		if ( siblings.length ) {
			siblings[ 0 ].classList.remove( 'open' );
			this.toggleSubmenu( isOpen, submenu, siblings[ 0 ] );
		} else {
			// Otherwise, just toggle the submenu for the current menu item
			this.toggleSubmenu( isOpen, submenu );
		}
	}

	/**
	 * Toggles the submenu open or closed with animation.
	 *
	 * @param {boolean} isOpen - Whether the submenu should be open or closed.
	 * @param {HTMLElement} submenu - The submenu element.
	 * @param {HTMLElement} siblingMenuItem - The sibling menu item element, if any.
	 */
	toggleSubmenu( isOpen, submenu, siblingMenuItem ) {
		// Store a reference to the current context
		const self = this;

		// Set the animation duration
		const duration = self.options.submenuTransitionDuration * 1000;

		// Calculate the height of the submenu
		let submenuHeight = self.calcSubmenuHeight( submenu );

		// Initialize variables for sibling submenu and its height
		let siblingsSubmenu = null,
			siblingsSubmenuHeight = null;

		// If there is a sibling menu item, calculate its height
		if ( siblingMenuItem ) {
			siblingsSubmenu = siblingMenuItem.querySelector( 'ul' );
			siblingsSubmenuHeight = self.calcSubmenuHeight( siblingsSubmenu );
		}

		// Initialize the start time for the animation
		let startTime = null;

		/**
		 * Animates the height of the submenu and sibling submenu.
		 *
		 * @param {number} timestamp - The current timestamp.
		 */
		function animateHeight( timestamp ) {
			// If start time is not set, set it to the current timestamp
			if ( ! startTime ) startTime = timestamp;

			// Calculate the runtime and progress of the animation
			const runtime = timestamp - startTime;
			const progress = Math.min( runtime / duration, 1 );

			// Calculate the height progress of the submenu
			const heightProgress = submenuHeight * progress;
			submenu.style.height = isOpen
				? `${ heightProgress }px`
				: `${ submenuHeight - heightProgress }px`;

			// If there is a sibling submenu, calculate the height progress and set its height
			if ( siblingMenuItem ) {
				const siblingHeightProgress = siblingsSubmenuHeight * progress;
				siblingsSubmenu.style.height = `${
					siblingsSubmenuHeight - siblingHeightProgress
				}px`;
			}

			// If the animation is not completed, request the next animation frame
			if ( runtime < duration ) {
				requestAnimationFrame( animateHeight );
			} else {
				// Set the final height of the submenu based on the open/close state
				submenu.style.height = isOpen ? 'auto' : 0;

				// If there is a sibling submenu, set its height to 0 and close its deep level submenus
				if ( siblingMenuItem ) {
					siblingsSubmenu.style.height = 0;
					self.closeDeepLevelSubmenus( siblingsSubmenu );
				}

				// If the submenu is closed, close its deep level submenus
				if ( ! isOpen ) {
					self.closeDeepLevelSubmenus( submenu );
				}
			}
		}

		// Start the animation
		requestAnimationFrame( animateHeight );
	}

	closeDropdownMenu() {
		this.menuItems.forEach( ( menuItem ) => {
			menuItem.classList.remove( 'open' );
			menuItem.querySelector( '.sub-menu' ).style.height = '0';
		} );
	}

	/**
	 * Closes all deep level submenus in the given submenu element.
	 * @param {HTMLElement} submenu - The submenu element.
	 */
	closeDeepLevelSubmenus( submenu ) {
		// Get all deep level submenus
		const deepLevelSubmenus = Array.from(
			submenu.querySelectorAll( 'ul' )
		);

		// Close each deep level submenu
		deepLevelSubmenus.forEach( ( deepSubmenu ) => {
			// Set height to 0 to hide the submenu
			deepSubmenu.style.height = 0;

			// Remove the 'opened' class from the parent element to indicate it's closed
			deepSubmenu.parentElement.classList.remove( 'open' );
		} );
	}
}

export { Navigation, NavigationWithDropdown };
