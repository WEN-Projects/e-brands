<?php
//register post type e-brands course
add_action( 'init', function () {
	register_post_type( 'ebrands-team',
		[
			'labels'      => [
				'name'               => __( 'Team', 'e-brands' ),
				'singular_name'      => __( 'Team', 'e-brands' ),
				'menu_name'          => _x( 'Team', 'Admin Menu text', 'e-brands' ),
				'name_admin_bar'     => _x( 'Team', 'Add New on Toolbar', 'e-brands' ),
				'add_new'            => __( 'Add New Member', 'e-brands' ),
				'add_new_item'       => __( 'Add New Member', 'e-brands' ),
				'new_item'           => __( 'New Member', 'e-brands' ),
				'edit_item'          => __( 'Edit Member', 'e-brands' ),
				'view_item'          => __( 'View Member', 'e-brands' ),
				'all_items'          => __( 'All Members', 'e-brands' ),
				'search_items'       => __( 'Search Member', 'e-brands' ),
				'parent_item_colon'  => __( 'Parent Member:', 'e-brands' ),
				'not_found'          => __( 'No team Member found.', 'e-brands' ),
				'not_found_in_trash' => __( 'No team Member found in Trash.', 'e-brands' ),
			],
			'public'      => TRUE,
			'has_archive' => FALSE,
			'rewrite'     => [ 'slug' => 'ebrands-team' ],
			//									'show_in_rest' => true,
			'supports'    => [ 'title', 'custom-fields', 'author' ],
			//									'publicly_queryable'  => true // completely disable the single and the archive for this custom post type

		]
	);
} );

