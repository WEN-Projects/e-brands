const sections = [];

const flexibleContents = {
	banner: '.banner',
	slider: '.slider',
	accordions: '.faq-wrap',
	// resetFilter: '.product-list',
	autoComplete: '.product-list',
};

for ( const key in flexibleContents ) {
	if ( flexibleContents.hasOwnProperty( key ) ) {
		const body = document.body;
		const section = document.querySelector( flexibleContents[ key ] );
		if ( body.contains( section ) ) {
			sections.push( key );
		}
	}
}

export default sections;
