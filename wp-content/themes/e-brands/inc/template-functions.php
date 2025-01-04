<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package e-brands
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function e_brands_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}

add_filter( 'body_class', 'e_brands_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or
 * attachments.
 */
function e_brands_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}

add_action( 'wp_head', 'e_brands_pingback_header' );

/*
 * Filter for svg support
 * */

// Allow SVG
add_filter( 'wp_check_filetype_and_ext', function ( $data, $file, $filename, $mimes ) {

	global $wp_version;
	if ( $wp_version !== '4.7.1' ) {
		return $data;
	}

	$filetype = wp_check_filetype( $filename, $mimes );

	return [
		'ext'             => $filetype['ext'],
		'type'            => $filetype['type'],
		'proper_filename' => $data['proper_filename'],
	];

}, 10, 4 );

function cc_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';

	return $mimes;
}

add_filter( 'upload_mimes', 'cc_mime_types' );


add_action( 'admin_init', function () {
	// Register a new setting for General settings page
	register_setting( 'general', 'google_map_api_key', 'ebrands_sanitize_callback' );

	// Add a new field to the General Settings page
	add_settings_field(
		'google_map_api_key',
		'Google Map API key',
		'eshop_google_map_api_key_callback',
		'general'
	);
} );

function eshop_google_map_api_key_callback() {
	$value = get_option( 'google_map_api_key' );
	?>
	<textarea rows="2" cols="80"
			  name="google_map_api_key"><?php echo $value; ?></textarea>
	<?php
}

function ebrands_sanitize_callback( $value ) {
	return sanitize_textarea_field( $value );
}

add_filter( 'get_avatar_data', 'ebrands_get_avatar_data_callback', 100, 2 ); // adding the custom image as gavatar default.
function ebrands_get_avatar_data_callback( $args, $id_or_email ) {
	if ( 'e-brands-default-ph' === $args['default'] ) {
		$args['url'] = home_url() . "/wp-content/uploads/2024/02/placeholder.png";
	}

	return $args;
}

function ebrands_avatar_defaults_callback( $avatar_defaults ) { // adding the custom image as gavatar default.
	$avatar_defaults['e-brands-default-ph'] = 'Default Gravatar I chose';

	return $avatar_defaults;
}

add_filter( 'avatar_defaults', 'ebrands_avatar_defaults_callback' );

add_action( 'init', 'disable_post_type_archives' );
function disable_post_type_archives() {
	// Check if the post type is already registered
	if ( post_type_exists( 'tribe_events' ) ) {
		// Get the existing arguments of the post type
		$args = get_post_type_object( 'tribe_events' );

		// Set 'has_archive' to false to disable archives
		$args->has_archive = FALSE;

		// Re-register the post type with updated arguments
		register_post_type( 'tribe_events', $args );
	}
}

//function ebrands_tempalte_redirect_config() {
//	// Check if it's the front-end of the site
//	if ( ! is_admin() ) {
//		// Check if the current URL contains the specific slug
//		if ( strpos( $_SERVER['REQUEST_URI'], 'tribe-event-list' ) !== false ) {
//			// Redirect to a specific URL
//			$shop_page = get_field( 'ebrands_sites_pages', 'option' );
//			if ( isset( $shop_page['event_listing_page'] ) && ! empty( $shop_page['event_listing_page'] ) ) {
//				wp_redirect( get_the_permalink($shop_page['event_listing_page']), 301 );
//				exit();
//			}
//		}
//	}
//}
//
//// Hook the function to the template_redirect action hook
//add_action( 'template_redirect', 'ebrands_tempalte_redirect_config' );


/**
 * Change the Get Tickets on List View and Single Events
 *
 * @param string $translation The translated text.
 * @param string $text The text to translate.
 * @param string $context The option context string.
 * @param string $domain The domain slug of the translated text.
 *
 * @return string The translated text or the custom text.
 */

add_filter( 'gettext_with_context', 'tribe_change_get_tickets', 20, 4 );
function tribe_change_get_tickets( string $translation, string $text, string $context, string $domain ): string {

	if (
		$domain != 'default'
		&& ! str_starts_with( $domain, 'event-' )
	) {
		return $translation;
	}

	$ticket_text = [
		// Get Tickets on List View
		'Get %s'      => 'Ticket sichern',
		// Get Tickets Form - Single View
		'Get Tickets' => 'Ticket sichern',
	];

	// If we don't have replacement text, bail.
	if ( empty( $ticket_text[ $text ] ) ) {
		return $translation;
	}

	return $ticket_text[ $text ];
}

// Add custom validation for name field in Contact Form 7
function custom_name_validation( $result, $tag ) {
	// Get the submitted value of the field
	$name = isset( $_POST[ $tag->name ] ) ? sanitize_text_field( $_POST[ $tag->name ] ) : '';

	// Check if the validation is for the name field
	if ( 'your-name' === $tag->name ) {
		// Check if the name contains only letters and whitespace
		if ( ! preg_match( '/^[a-zA-Z\s]+$/', $name ) ) {
			// If validation fails, invalidate the field and set an error message
			$result->invalidate( $tag, "Please enter a valid name without numbers or special characters." );
		}
	}

	return $result;
}

add_filter( 'wpcf7_validate_text', 'custom_name_validation', 10, 2 );
add_filter( 'wpcf7_validate_text*', 'custom_name_validation', 10, 2 );


add_filter( 'wp_mail_content_type', function ( $content_type ) { //change the content type for wp mail
	return 'text/html';
} );
add_filter( 'wp_mail_from_name', function ( $name ) { //set the header (from name)
	return "E-Brands";
} ); // Filter to change the from name in mail.
add_filter( 'wp_mail_from', function ( $name ) { //set the header (from name)
	return "ebrands@gmail.com";
}, 11111 ); // Filter to change the from name in mail.


