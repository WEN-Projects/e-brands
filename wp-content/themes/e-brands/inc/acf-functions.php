<?php
add_filter( 'acf/fields/google_map/api', function ( $api ) { // set the google map api key for the acf
	$api['key'] = get_option( 'google_map_api_key' );

	return $api;
} );

if ( function_exists( 'acf_add_options_page' ) ) { // setup the site's global option page
	acf_add_options_page( [
		'page_title' => __( 'E-Brands Options', 'e-brands' ),
		'menu_title' => __( 'E-Brands Options', 'e-brands' ),
		'menu_slug'  => 'e-brands-options',
		'capability' => 'edit_posts',
		'redirect'   => FALSE,
	] );
}

add_filter( 'block_categories', function ( $categories, $post ) { //register the block categories for ACF
	return array_merge(
		$categories,
		[
			[
				'slug'  => 'e-brands-blocks',
				'title' => 'E-Brands',
			],
		]
	);
}, 10, 2 );

// register all the custom gutenberg blocks
add_action( 'init', function () {
	/**
	 * We register our block's with WordPress's handy
	 * register_block_type();
	 *
	 * @link https://developer.wordpress.org/reference/functions/register_block_type/
	 */
	register_block_type( get_template_directory() . '/blocks/courses-showcase' );
	register_block_type( get_template_directory() . '/blocks/client-testimonials' );
	register_block_type( get_template_directory() . '/blocks/contact-info-block' );
	register_block_type( get_template_directory() . '/blocks/faqs-list' );
	register_block_type( get_template_directory() . '/blocks/image-content-block' );
	register_block_type( get_template_directory() . '/blocks/info-content-with-image' );
	register_block_type( get_template_directory() . '/blocks/multi-column-text-content' );
	register_block_type( get_template_directory() . '/blocks/newsletter-subscription' );
	register_block_type( get_template_directory() . '/blocks/partners-block' );
	register_block_type( get_template_directory() . '/blocks/product-showcase-block' );
	register_block_type( get_template_directory() . '/blocks/test-product-image-content' );
	register_block_type( get_template_directory() . '/blocks/contact-form' );
	register_block_type( get_template_directory() . '/blocks/title-content' );
	register_block_type( get_template_directory() . '/blocks/team-members' );
} );
