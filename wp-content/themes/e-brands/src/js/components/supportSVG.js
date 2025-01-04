/**
 * Converts an image to an SVG element and replaces the image with the SVG.
 *
 * @example
 * new SupportSVG('.selector');  // default value of selector is .svg
 */
export default class SupportSVG {
	constructor( selector ) {
		const imageSelector = selector || '.svg';
		const svgImages = Array.from(
			document.querySelectorAll( imageSelector )
		);
		svgImages.forEach( ( svgImg ) => this.convertImgToSvg( svgImg ) );
	}

	/**
	 * Converts an image to an SVG element and replaces the image with the SVG.
	 * @param {HTMLImageElement} svgImg - The image to convert.
	 */
	async convertImgToSvg( svgImg ) {
		try {
			// Fetch the SVG data from the image source
			const response = await fetch( svgImg.src );
			const svgData = await response.text();

			// Parse the SVG data into an SVG element
			const parser = new DOMParser();
			const svgElement = parser
				.parseFromString( svgData, 'image/svg+xml' )
				.querySelector( 'svg' );

			// Set the id and class of the SVG element
			svgElement.id = svgImg.id || '';
			svgElement.classList = svgImg.classList || '';

			// Replace the image with the SVG element
			svgImg.replaceWith( svgElement );
		} catch ( error ) {
			throw new Error( error );
		}
	}
}
