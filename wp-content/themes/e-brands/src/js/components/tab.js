/**
 * Tab With Accordion
 *
 * @todo 1. Add keyboard-arrow controls
 *
 * @see '../../../demo/tab.html'
 */

import '../../scss/components/_tab.scss';

const TabAccordion = {
	init( selector = '.tab', options ) {
		this.selector = selector;
		this.tabOptions = {
			tabMenu: '[role="tablist"]',
			tabLink: '[role="tab"]',
			tabContent: '.tab__content',
			tabPanel: '[role="tabpanel"]',
			activeLinkClass: 'tab__link--active',
			activePanelClass: 'tab__block--active',
			breakpoint: '767',
			...options,
		};

		this.tabs = Array.from( document.querySelectorAll( this.selector ) );
		this.tabs.forEach( ( tab ) => {
			this.initTab( tab );
		} );
	},

	initTab( tab ) {
		const { tabMenu, tabLink, tabContent, tabPanel, breakpoint } =
			this.tabOptions;

		// Find the tab content element based on the provided options
		const contentWrapper = tab.querySelector( tabContent );

		// If the tab content element doesn't exist, return
		if ( ! contentWrapper ) return;

		// Find all tab panels within the tab content
		this.tabPanels = contentWrapper.querySelectorAll( tabPanel );

		// If there are no tab panels, return
		if ( ! this.tabPanels.length ) return;

		// Find the tab menu element based on the provided options
		const menu = tab.querySelector( tabMenu );

		// If the tab menu element exists, find its links
		if ( menu ) {
			this.tabLinks = menu.querySelectorAll( tabLink );
		}

		// Find all accordion links within the tab content
		this.accordionLinks = contentWrapper.querySelectorAll( tabLink );

		// Check if device is Mobile on load and resize
		this.isMobile = window.matchMedia(
			`(max-width: ${ breakpoint }px)`
		).matches;

		window.addEventListener( 'resize', () => {
			this.isMobile = window.matchMedia(
				`(max-width: ${ breakpoint }px)`
			).matches;
		} );

		// Trigger the tab menu links and accordion links
		this.triggerTabMenuLinks();
		this.triggerAccordionLinks();

		// Add event listeners for window load and resize to recalculate panel height
		const events = [ 'load', 'resize' ];

		events.forEach( ( evt ) => {
			window.addEventListener(
				evt,
				this.reCalcPanelHeightOnResize.bind( this )
			);
		} );
	},
	triggerTabMenuLinks() {
		// If there are no tab menu links, return
		if ( ! this.tabLinks.length ) return;

		// Add click event to the tab menu links
		this.tabLinks.forEach( ( tabMenuLink ) => {
			tabMenuLink.addEventListener(
				'click',
				this.changeTabs.bind( this, tabMenuLink )
			);
		} );
	},

	triggerAccordionLinks() {
		// If there are no tab accordion links, return
		if ( ! this.accordionLinks.length ) return;

		// Add click event to the tab accordion links
		this.accordionLinks.forEach( ( tabAccordionLink ) => {
			tabAccordionLink.addEventListener(
				'click',
				this.changeTabs.bind( this, tabAccordionLink )
			);
		} );
	},

	changeTabs( tabLink ) {
		// Get the target ID from the clicked tab link's dataset
		let targetId = tabLink.dataset.target;

		// Toggle the active link class for tab menu links and accordion links
		for ( let tabMenuLink of this.tabLinks ) {
			if ( ! this.isMobile ) {
				tabMenuLink.classList.toggle(
					this.tabOptions.activeLinkClass,
					tabMenuLink.dataset.target === targetId
				);
			}
			if ( this.isMobile ) {
				tabMenuLink.classList.toggle(
					this.tabOptions.activeLinkClass,
					tabMenuLink.dataset.target === targetId &&
						! tabMenuLink.classList.contains(
							this.tabOptions.activeLinkClass
						)
				);
			}
		}

		//Toggle the active link class for tab accordion links
		for ( let tabAccordionLink of this.accordionLinks ) {
			if ( ! this.isMobile ) {
				tabAccordionLink.classList.toggle(
					this.tabOptions.activeLinkClass,
					tabAccordionLink.dataset.target === targetId
				);
			}
			if ( this.isMobile ) {
				tabAccordionLink.classList.toggle(
					this.tabOptions.activeLinkClass,
					tabAccordionLink === tabLink &&
						! tabAccordionLink.classList.contains(
							this.tabOptions.activeLinkClass
						)
				);
			}
		}

		for ( let tabPanel of this.tabPanels ) {
			// Reset the max height to null for all tab panels
			tabPanel.style.maxHeight = null;

			if ( ! this.isMobile ) {
				// Toggle the active panel class for tab panels
				tabPanel.parentElement.classList.toggle(
					this.tabOptions.activePanelClass,
					tabPanel.id === targetId
				);
			}
			if ( this.isMobile ) {
				if (
					tabPanel.id === targetId &&
					! tabPanel.parentElement.classList.contains(
						this.tabOptions.activePanelClass
					)
				) {
					// add the active panel class for tab panels
					tabPanel.parentElement.classList.add(
						this.tabOptions.activePanelClass
					);

					// Calculate and set the max height for the target tab panel when on a small screen
					if ( tabPanel.id === targetId ) {
						const panelHeight = Array.from(
							tabPanel.children
						).reduce(
							( height, child ) => height + child.offsetHeight,
							0
						);
						tabPanel.style.maxHeight = panelHeight + 'px';
					}
				} else {
					// remove the active panel class for tab panels
					tabPanel.parentElement.classList.remove(
						this.tabOptions.activePanelClass
					);
				}
			}
		}
	},
	reCalcPanelHeightOnResize() {
		if ( ! this.isMobile ) {
			let hasActiveTab = false;
			for ( let tabMenuLink of this.tabLinks ) {
				if (
					tabMenuLink.classList.contains(
						this.tabOptions.activeLinkClass
					)
				) {
					hasActiveTab = true;
				}
			}

			if ( ! hasActiveTab ) {
				this.tabLinks[ 0 ].classList.add(
					this.tabOptions.activeLinkClass
				);
				this.accordionLinks[ 0 ].classList.add(
					this.tabOptions.activeLinkClass
				);
				this.tabPanels[ 0 ].parentElement.classList.add(
					this.tabOptions.activePanelClass
				);
			}
		}
		if ( this.isMobile ) {
			for ( let tabPanel of this.tabPanels ) {
				// Check if the tab panel is active and the screen width matches the breakpoint
				if (
					tabPanel.parentElement.classList.contains(
						this.tabOptions.activePanelClass
					)
				) {
					const panelHeight = Array.from( tabPanel.children ).reduce(
						( height, child ) => height + child.offsetHeight,
						0
					);
					tabPanel.style.maxHeight = panelHeight + 'px';
				}
			}
		}
	},
};

export default TabAccordion;
