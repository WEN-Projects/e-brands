import Init from './js/main';
import sections from './js/components/flexibleContents';
import InitJquery from './js/custom-jquery';
import './scss/main.scss';

// Execute common JS
Init.commonJS();

// Loop through each Function in Init
for ( const section in Init ) {
	// Check if the section function is direct property of the Init object
	if ( Init.hasOwnProperty( section ) ) {
		// Execute section function only if the section is on the page
		if ( sections.includes( section ) ) {
			Init[ section ]();
		}
	}
}

InitJquery();
