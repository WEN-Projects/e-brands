import { ScrollToTop, SmoothScroll/*, StickyHeader*/ } from './components/scroll';
import { Navigation, NavigationWithDropdown } from './components/navigation';
// import SupportSVG from './components/supportSVG';
import { Megamenu } from './components/navigation-toggle';
import { Slider } from './components/sliders';
import contentImageTab from './components/content-image-tab';
import Accordion from './components/accordion';
import autoComplete from './components/autocomplete';
import popupModal from './components/popup-modal';

const Init = {
	commonJS() {
		// new SupportSVG( '.svg' );

		/**
		 * Init scroll-to-top
		 *
		 * @param {string} [selector='.to-top'] - The CSS selector for the scroll-to-top button.
		 * @param {number} [duration=1500] - The duration of the scroll animation in milliseconds.
		 * @param {number} [showOnSCroll=200] - The Scroll value from top to show the button.
		 */
		ScrollToTop('.to-top', 1500, 72);

		/**
		 * Init Smooth Scroll
		 *
		 * @param {number} [duration=1500] - The duration of the scroll animation in milliseconds. Default is 1500.
		 * @param {string|number} [offset='.site-header'] - The offset of the scroll position. Can be a CSS selector or a number. Default is 0.
		 */
		SmoothScroll();

		/**
		 * Init Sticky Header
		 *
		 * @param {string} [headerElement='.site-header'] - The CSS selector for the header element.
		 * @param {number} [scrollOffset=150] - The number of pixels from the top of the page where the header should become sticky. Default is 0.
		 */

		/*Menu toggle for mega menu section*/
        Megamenu();

		// If menu have no dropdown, use only Navigation else use NavigationWithDropdown
		// const nav = new Navigation();
		const navWithDropdown = new NavigationWithDropdown();
		// Override default setting using below options
		// {
		// 	mainNavigation: '.main-navigation',
		// 	menuToggler: '.menu-toggle',
		// 	menuWrapper: '.menu-primary-menu-container',
		// 	menu: '.menu',
		// 	disableBackgroundScroll: true,
		// 	breakpoint: 991,
		// 	submenuTransitionDuration: 0.4
		// }

        contentImageTab();

		Slider.init({
			selector: '.product-showcase__slider',
			settings: {
                // observer: true,
                // observeParents: true,
                spaceBetween: 30,
                // freeMode: true,
                // grabCursor: true,
                // autoHeight: true,
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                navigation: {
                    nextEl: ".product-showcase__slider .swiper-button-next",
                    prevEl: ".product-showcase__slider .swiper-button-prev",
                },
                breakpoints: {
                    567: {
                        slidesPerView: 2,
                    },
                    992: {
                        slidesPerView: 3,
                    },
                    1400: {
                        slidesPerView: 4,
                    },
                },
                slidesPerView: 1,
			},
            // handler: (e) => {
            //     e.on("slideChange", () =>
            //         console.log("slide Changed")
            //     );
            // },
        });
		Slider.init({
            selector: '.testimonial-slider',
            settings: {
                slidesPerView: 1,
                grabCursor: true,
                autoHeight: true,
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                navigation: {
                    nextEl: ".testimonial-slider .swiper-button-next",
                    prevEl: ".testimonial-slider .swiper-button-prev",
                },
            },
        });

        new Accordion({
            wrapper: ".content__accordion",
            item: ".content__accordion_item",
            head: ".content__accordion_head",
            body: ".content__accordion_body",
            closeOtherItems: true,
        });

        popupModal();


	},
	banner() {},
	slider() {},
    accordions() {
        // new Accordion({
        //     wrapper: ".content__accordion",
        //     item: ".content__accordion_item",
        //     head: ".content__accordion_head",
        //     body: ".content__accordion_body",
        //     closeOtherItems: true,
        // });
    },
    //To reset fields on the shop page filter
    // resetFilter(){
    //     formRestOnClear();
    // }

    //To reset fields on the shop page filter
    autoComplete(){
        autoComplete();
    }

};



export default Init;
