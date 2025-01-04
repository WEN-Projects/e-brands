import Swiper from 'swiper/bundle';
import 'swiper/css';

const Slider = {
	init( options = {} ) {
		const { selector, settings, handler } = options;
		this.selector = selector ?? '.swiper';
		this.settings = {
			speed: 400,
			spaceBetween: 100,
			slidesPerView: 1,
			...settings,
		};
		this.handler = typeof handler === 'function' ? handler : () => {};

		this.initSliders();
	},

	initSliders() {
		// Declare an Empty array to store all Swiper instances
		this.sliderInstances = [];

		// Get all slider elements
		const sliders = Array.from(
			document.querySelectorAll( this.selector )
		);

		// Initialize swiper for all sliders
		sliders.forEach( ( slider ) => this.sliderSettings( slider ) );

		// handler for slider instances
		this.sliderHandler();
	},

	sliderSettings( selector ) {
		// create new Swiper instance
		const slider = new Swiper( selector, this.settings );

		// Push instance to array
		this.sliderInstances.push( slider );
	},

	sliderHandler() {
		this.sliderInstances.forEach( ( slider ) => {
			this.handler( slider );
		} );
	},
};

export { Slider };
