<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package ebrands-theme
 */
/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */

// (<--start-->) add all the WooCommerce supports and customization of general options
add_action( 'after_setup_theme', function () {
	add_theme_support(
		'woocommerce',
		[
			'thumbnail_image_width' => 150,
			'single_image_width'    => 600,
			'product_grid'          => [
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 4,
				'min_columns'     => 1,
				'max_columns'     => 6,
			],
		]
	);
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
} );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param array $classes CSS classes applied to the body tag.
 *
 * @return array $classes modified to include 'woocommerce-active' class.
 */
add_filter( 'body_class', function ( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
} );
add_filter( 'single_product_archive_thumbnail_size', function ( $size = '' ) {
	return "medium";
}, 1111 ); //set the image thumbnails size in product listing.

add_action( 'init', function () { //setup custom taxonomy brands
	$labels = [
		'name'                       => __( 'Brand', 'e-brands' ),
		'singular_name'              => __( 'Brand', 'e-brands' ),
		'search_items'               => __( 'Search Brands', 'e-brands' ),
		'popular_items'              => __( 'Popular Brands', 'e-brands' ),
		'all_items'                  => __( 'All Brands', 'e-brands' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Brand', 'e-brands' ),
		'update_item'                => __( 'Update Brand', 'e-brands' ),
		'add_new_item'               => __( 'Add New Brand', 'e-brands' ),
		'new_item_name'              => __( 'New Brand Name', 'e-brands' ),
		'separate_items_with_commas' => __( 'Separate product brands with commas', 'e-brands' ),
		'add_or_remove_items'        => __( 'Add or remove product brands', 'e-brands' ),
		'choose_from_most_used'      => __( 'Choose from the most used product brands', 'e-brands' ),
		'not_found'                  => __( 'No product brand found.', 'e-brands' ),
		'menu_name'                  => __( 'Brands', 'e-brands' ),
	];

	$args = [
		'hierarchical'      => false,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => [ 'slug' => 'product-brands' ],
	];

	register_taxonomy( 'product-brands', 'product', $args );
} );

function ebrands_get_product_brand( $product_id = 0 ) { //function that return all the selected brands for the provided product_id
	$brand_html = "";
	$terms      = get_the_terms( $product_id, 'product-brands' );
	if ( ! empty( $terms ) ) {
		$brands_arr = [];
		$brand_html = "<p class=\"product-card__variant\">";
		foreach ( $terms as $term ) {
			if ( isset( $term->name ) ) {
				$brands_arr[] = $term->name;
			}
		}
		$brand_html .= implode( ', ', $brands_arr );
		$brand_html .= "</p>";
	}

	return $brand_html;
}

add_action( 'add_meta_boxes', function ( $post ) { // adding the additional fields to the WooCommerce Products
	add_meta_box( 'ebrands_products_additional_info', __( 'Additional info', 'e-brands' ), 'ebrands_products_additional_info_callback', 'product', 'normal', 'low' );
} );
function ebrands_products_additional_info_callback( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'ebrands_nonce' );
	$is_test_product = get_post_meta( $post->ID, 'is_test_product', true ); // field to determine whether the product is test product or non-test product
	?>
	<label for="is_test_product">
		<?php
		// Generate checkbox using WordPress function
		echo '<input type="checkbox" id="is_test_product" name="is_test_product" ';
		checked( $is_test_product, 'on' );
		echo '/>';
		?>
		<?php esc_html_e( 'Is Test Product?', 'e-brands' ); ?>
	</label>

	<?php
}

add_action( 'save_post', function ( $post_id ) {
	// check for nonce to top xss
	if ( ! isset( $_POST['ebrands_nonce'] ) || ! wp_verify_nonce( $_POST['ebrands_nonce'], basename( __FILE__ ) ) ) {
		return;
	}

	// check for correct user capabilities - stop internal xss from customers
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	// Check if this is an autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	$is_test_product = isset( $_REQUEST['is_test_product'] ) ? 'on' : 'off';
	update_post_meta( $post_id, 'is_test_product', $is_test_product );
}, 10, 2 );
add_filter( 'woocommerce_get_price_html', function ( $price ) {
	if ( is_user_logged_in() ) {
		return $price;
	} else {
		return '<small>' . __( 'Um Preise zu sehen, loggen Sie sich bitte ein', 'e-brands' ) . '</small>';
	}
} );

if ( ! is_user_logged_in() ) { // disable add to cart functionality for non-logged users
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
	remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
	remove_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
	remove_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
	remove_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
	remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 );
	remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
}
// (<--end-->) add all the WooCommerce supports and customization of general options

// (<--start-->) shop-page/archive page customization
//customize the query for the products to be listed in shop page
add_action( 'pre_get_posts', function ( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_post_type_archive( 'product' ) ) { // only applicable to the product archive page
		return;
	}
	$taxquery  = [];
	$metaquery = [
		"relation" => "OR",
		[
			'key'     => 'is_test_product',
			'value'   => 'on',
			'compare' => '!=',
		],
		[
			'key'     => 'is_test_product',
			'compare' => 'NOT EXISTS',
		],
	]; // add the meta query
	if ( ! empty( $metaquery ) ) {
		$query->set( 'meta_query', $metaquery );
		if ( isset( $_GET['category'] ) && ! empty( $_GET['category'] ) ) {
			$taxquery[] = [
				'taxonomy' => 'product_cat',
				'field'    => 'slug',
				'terms'    => [ sanitize_text_field( $_GET['category'] ) ],
				'operator' => 'IN',
			];
		}
		if ( isset( $_GET['brand'] ) && ! empty( $_GET['brand'] ) ) {
			$taxquery[] = [
				'taxonomy' => 'product-brands',
				'field'    => 'slug',
				'terms'    => [ sanitize_text_field( $_GET['brand'] ) ],
				'operator' => 'IN',
			];
		}
		if ( ! empty( $taxquery ) ) {
			$query->set( 'tax_query', [ "relation" => "AND", $taxquery ] );
		}
		$query->set( 'posts_per_page', 8 ); //set the total number of products to be shown on single page
		if ( isset( $_GET["page"] ) && ! empty( $_GET["page"] ) ) {
			$query->set( 'paged', $_GET["page"] );
		}

		if ( isset( $_GET['search_key'] ) && ! empty( $_GET['search_key'] ) ) {
			$query->set( 's', sanitize_text_field( $_GET['search_key'] ) );
		}
	}
} );

//add_action( 'ebrands_wc_add_to_cart', 'woocommerce_template_loop_add_to_cart', 10 ); //add custom hook to render add to cart button on listed-product
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' ); // remove the add to cart button for all the woocommerce products in loop

add_action( 'woocommerce_after_shop_loop_item_title', function () {
	global $product;
	echo ebrands_get_product_brand( $product->get_id() );
}, 1 ); //showing the brand name in product archive loop

// (<--end-->) shop-page/archive page customization


// (<start>) product detail(single) page customization
/**
 * Change the breadcrumb separator
 */
add_filter( 'woocommerce_breadcrumb_defaults', function ( $defaults ) { // Change the breadcrumb delimeter from '/' to '>'
	$defaults['delimiter'] = ' > ';

	return $defaults;
} );
//remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 ); //remove the product data tabs from the single page
add_filter( 'woocommerce_product_tabs', function ( $tabs ) { // remove the description tab from the tabs section, since it is displayed under the Details of Accordion
	if ( isset( $tabs['description'] ) ) {
		unset( $tabs['description'] );
	}

	return $tabs;
}, 99 );
add_filter( 'woocommerce_product_additional_information_heading', function () { //do not show the title under the tab content of additional information
	return false;
} );


//Move price above the rating
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 ); //remove the rating from the product single page
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 11 ); // show the rating on the top of product details/summary

//Move add to cart below product meta
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 41 );

//remove rating from shop loop
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
//Add label for the quantity field.
add_action( 'woocommerce_before_add_to_cart_button', function () {
	echo '<span class="label">' . __( 'Quantity', 'e-brands' ) . '</span>';
}, 20 );

//Adding buy now button below the add to cart button
add_action( 'woocommerce_single_product_summary', function () {
	if ( ! is_user_logged_in() ) {
		return;
	}
	global $product;

	// Check if the product is purchasable
	if ( $product->is_purchasable() && $product->is_type( 'simple' ) && $product->is_in_stock() ) {
		// Output the Buy Now button
		echo '<a href="' . esc_url( wc_get_checkout_url() ) . '?add-to-cart=' . $product->get_id() . '" class="btn is-secondary full">' . __( 'Buy Now', 'e-brands' ) . '</a>';
	}
	echo '<p class="info-disc text-center">' . __( 'Free shipping over $50', 'e-brands' ) . '</p>';
}, 42 );

add_action( 'template_redirect', function () { // for buy now option, when click on add to cart with get parameter add-to-cart, redirect to checkout page
	if ( isset( $_GET['add-to-cart'] ) ) {
		wp_redirect( wc_get_checkout_url() );
		exit;
	}
} );

//Adding descriptions accordion under the product summery
add_action( 'woocommerce_single_product_summary', function () {
	?>
	<div class="content__description-list">
		<div class="content__accordion">
			<?php
			$productContent = get_the_content();
			if ( $productContent ) {
				?>
				<div class="content__accordion_item">
					<div class="content__accordion_head" tabindex="0">
						<h3 class="content__accordion_title"><?php _e( 'Details', 'e-brands' ); ?></h3>
						<span class="content__accordion_icon"></span>
					</div>
					<div class="content__accordion_body">
						<div class="content__accordion_body_inner">
							<?php
							the_content();
							?>
						</div>
					</div>
				</div>
				<?php
			}
			if ( get_field( 'ebrands_shipping_details', 'option' ) ) {
				?>
				<div class="content__accordion_item">
					<div class="content__accordion_head" tabindex="0">
						<h3 class="content__accordion_title"><?php _e( 'Shipping', 'e-brands' ); ?></h3>
						<span class="content__accordion_icon"></span>
					</div>
					<div class="content__accordion_body">
						<div class="content__accordion_body_inner">
							<?php the_field( 'ebrands_shipping_details', 'option' ); ?>
						</div>
					</div>
				</div>
				<?php
			}
			if ( get_field( 'ebrands_return_details', 'option' ) ) {
				?>
				<div class="content__accordion_item">
					<div class="content__accordion_head" tabindex="0">
						<h3 class="content__accordion_title"><?php _e( 'Returns', 'e-brands' ); ?></h3>
						<span class="content__accordion_icon"></span>
					</div>
					<div class="content__accordion_body">
						<div class="content__accordion_body_inner">
							<?php the_field( 'ebrands_return_details', 'option' ); ?>
						</div>
					</div>
				</div>
				<?php
			}
			?>
		</div>
	</div>
	<?php
}, 61 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 20 ); // remove product title in single product page

/* Customization of Related Products to be displayed on product detail page */
add_filter( 'woocommerce_output_related_products_args', function ( $args ) {
	$args['posts_per_page'] = 8;
	global $product;
	// Get the product categories
	$categories = get_the_terms( $product->get_id(), 'product_cat' );

	// Check if there is a category assigned to the product
	if ( ! empty( $categories ) && is_array( $categories ) ) {
		// Get the first category assigned to the product
		$category = array_shift( $categories );

		// Modify the arguments to fetch related products from the selected category only
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'term_id',
				'terms'    => $category->term_id,
			),
		);
	}
	$args['meta_query'] = [
		"relation" => "OR",
		[
			'key'     => 'is_test_product',
			'value'   => 'on',
			'compare' => '!=',
		],
		[
			'key'     => 'is_test_product',
			'compare' => 'NOT EXISTS',
		],
	]; // add the meta query

	return $args;
} ); // set related products to be displayed as 8
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 ); // hide the sku product detail page

add_action( 'wp_ajax_ebrands_product_search_autosuggest', 'ebrands_product_search_autosuggest_callback' ); // ajax response for auto-suggestion for product search
add_action( 'wp_ajax_nopriv_ebrands_product_search_autosuggest', 'ebrands_product_search_autosuggest_callback' ); // ajax response for auto-suggestion for product search

function ebrands_product_search_autosuggest_callback() {
	check_ajax_referer( 'ebrands-ajax-nonce', 'ajax_nonce' );
	if ( ! isset( $_POST['search_text'] ) ) {
		wp_die( 'Invalid Request' );
	}
	$search_text = $_POST['search_text'];
	$args        = [
		'post_type'      => 'product',
		'posts_per_page' => - 1,
		's'              => $search_text,
		'orderby'        => 'title', // Sort by title
		'order'          => 'ASC', // in ascending order
		'meta_query'     => [
			"relation" => "OR",
			[
				'key'     => 'is_test_product',
				'value'   => 'on',
				'compare' => '!=',
			],
			[
				'key'     => 'is_test_product',
				'compare' => 'NOT EXISTS',
			],
		],
	];
	$products    = new WP_Query( $args );

	ob_start();
	if ( $products->have_posts() ) {
		while ( $products->have_posts() ) {
			$products->the_post();
			$productTitle       = get_the_title();
			$productFilterTitle = str_ireplace( $search_text, '<strong>' . ( $search_text ) . '</strong>', $productTitle );
			echo '<li><a href="' . esc_url( get_permalink() ) . '">' . $productFilterTitle . '</a></li>';
		}
	} else {
		echo '<li class="results-not-found">' . esc_html__( 'No products found', 'your-text-domain' ) . '</li>';
	}
	wp_reset_postdata();
	$response = ob_get_clean();

	wp_die( $response );
}

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 ); // remove the sales tag from the hook in single product page
add_action( 'ebramds_thumbnail_product_sale_flash', 'woocommerce_show_product_sale_flash', 10 ); // add the sales tag to the new hook in single product page

// (<end>) product detail(single) page customization

//remove product description on cart page
add_filter( 'woocommerce_cart_item_name', function ( $product_name, $cart_item, $cart_item_key ) {
	// Remove the short description
	$product      = $cart_item['data'];
	$product_name = $product->get_name(); // Get only the product name without short description

	return $product_name;
}, 10, 3 );


function restrict_the_woocommerce_pages_for_non_logged_users() { //redirect the user to home page if non-logged user tries to access woocommerce cart,checkout pages.
	if ( ! is_user_logged_in() && ( is_cart() || is_checkout() ) ) {
		// feel free to customize the following line to suit your needs
		wp_redirect( home_url() );
		exit;
	}
}

add_action( 'template_redirect', 'restrict_the_woocommerce_pages_for_non_logged_users' );

add_filter( 'term_link', 'ebrands_custom_product_category_link', 10, 3 );

function ebrands_custom_product_category_link( $term_link, $term, $taxonomy ) { // customize the default urls for the product categories so to redirect to shop page.
	$shop_page_url = wc_get_page_permalink( 'shop' );
	// Check if it's a product category
	if ( $taxonomy == 'product_cat' ) {
		$term_link = add_query_arg( 'category', $term->slug, $shop_page_url );
	}

	return $term_link;
}


// Add custom user status 'pending-approval'
//add_action( 'init', 'ebrands_add_pending_approval_user_status' );

function ebrands_add_pending_approval_user_status() {
	remove_role( 'pending-customerr' );
	add_role(
		'pending-customer',
		__( 'Customer (Pending)', 'e-brands' ),
		[
			'read'       => false,
			// Allow pending users to read their own profile
			'edit_posts' => false,
			// Prevent pending users from editing posts
			// Add more capabilities if needed
		]
	);
}

// Hook into user registration completion
add_action( 'woocommerce_created_customer', 'ebrands_set_user_status_to_pending', 10, 3 );

function ebrands_set_user_status_to_pending( $customer_id, $new_customer_data, $password_generated ) {
	update_user_meta( $customer_id, 'user_status', 'pending' );
}

add_filter( 'woocommerce_registration_auth_new_customer', function () {
	wc_clear_notices();
	wc_add_notice( __( 'Thank you for registering. Your account is pending approval.', 'woocommerce' ) );

	return false;
} );

/**
 * Add custom column for user status in the backend user table.
 */
function custom_add_user_status_column( $columns ) {
	// Add 'Status' column after 'Role' column
	$columns['user_status'] = __( 'Status', 'e-brands' );

	return $columns;
}

add_filter( 'manage_users_columns', 'custom_add_user_status_column' );

/**
 * Populate custom column with dropdown for selecting user status.
 */
function custom_render_user_status_column( $value, $column_name, $user_id ) {
	// Check if it's the 'Status' column
	if ( 'user_status' === $column_name ) {
		$user_meta  = get_userdata( $user_id );
		$user_roles = $user_meta->roles;
		if ( in_array( 'customer', $user_roles ) ) {
			// Get current status
			$current_status = get_user_meta( $user_id, 'user_status', true );
			$value          = $current_status;
		}

	}

	return $value;
}

/**
 * Prevent certain users from logging in and display a custom message.
 */
function ebrands_custom_prevent_login_for_certain_users( $user ) {
	if ( $user instanceof WP_User ) {
		$user_meta  = get_userdata( $user->ID );
		$user_roles = $user_meta->roles;
		if ( is_array( $user_roles ) && in_array( 'customer', $user_roles ) ) {
			// Get the user's ID
			$current_status = get_user_meta( $user->ID, 'user_status', true );
			// Check if the user should not be allowed to login (based on some condition)
			if ( 'approved' != $current_status ) {
				// Display a custom message
				$error_message = __( 'Sorry, Your account is still pending for approval', 'e-brands' );

				return new WP_Error( 'authentication_failed', $error_message );
			}
		}
	}

	return $user;
}

add_filter( 'authenticate', 'ebrands_custom_prevent_login_for_certain_users', 1111 );

add_filter( 'manage_users_custom_column', 'custom_render_user_status_column', 10, 3 );

add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );

function extra_user_profile_fields( $user ) {
	$current_status = get_user_meta( $user->ID, 'user_status', true );
	$user_meta      = get_userdata( $user->ID );
	$user_roles     = $user_meta->roles;
	if ( in_array( 'customer', $user_roles ) ) {
		?>
		<table class="form-table">
			<tr>
				<th>
					<label
						for="user_status"><?php _e( "User Status", 'e-brands' ); ?></label>
				</th>
				<td>
					<select name="user_status" id="user_status">
						<option
							value="pending" <?php selected( $current_status, 'pending' ); ?>><?php _e( 'Pending', 'e-brands' ); ?></option>
						<option
							value="approved" <?php selected( $current_status, 'approved' ); ?>><?php _e( 'Approved', 'e-brands' ); ?></option>
					</select>
					<?php
					if ( $current_status == 'pending' ) {
						?>
						<link rel="stylesheet"
							  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
						<button id="approve-customer-confirm-btn"
								customer-id="<?php echo $user->ID; ?>"
								type="button"
								class="button"><?php _e( 'Approve', 'e-brands' ); ?>
							<i
								style="display: none"
								class="fa fa-spinner fa-spin"></i></button>
						<span id="approval-response-message"></span>
						<?php
					}
					?>
				</td>
			</tr>
		</table>
		<?php
	}
}

/**
 * Enqueue a script in the WordPress admin
 */
function ebrands_wc_enqueue_admin_script( $hook ) {
	wp_enqueue_script( 'ebrands-admin-wc-js', get_template_directory_uri() . '/inc/admin/assets/woocommerce.js' );
	wp_localize_script(
		'ebrands-admin-wc-js',
		'ebrands_obj',
		[
			'ajax_url'   => admin_url( 'admin-ajax.php' ),
			// ajax url
			'nonce_ajax' => wp_create_nonce( 'ebrands-ajax-nonce' )
			// nonce for valid ajax request,

		]
	); // localizing script with php values to js
}

add_action( 'admin_enqueue_scripts', 'ebrands_wc_enqueue_admin_script' );

add_action( 'wp_ajax_ebrands_admin_approve_customer', 'ebrands_admin_approve_customer_callback' ); // handler functionality when admin approves the customer from the backend.
function ebrands_admin_approve_customer_callback() {
	check_ajax_referer( 'ebrands-ajax-nonce', 'ajax_nonce' );
	if ( ! isset( $_POST['customer_id'] ) ) {
		wp_die( 'Invalid Request' );
	}
	$user_obj = get_user_by( 'id', $_POST['customer_id'] );
	update_user_meta( $_POST['customer_id'], 'user_status', 'approved' );
	$ebrands_customer_approval_email_template = get_field( 'ebrands_customer_approval_email_template', 'option' );
	$subject                                  = '';
	$message                                  = '';
	if ( isset( $ebrands_customer_approval_email_template['subject'] ) && ! empty( $ebrands_customer_approval_email_template['subject'] ) ) {
		$subject = esc_html( $ebrands_customer_approval_email_template['subject'] );
	}
	if ( isset( $ebrands_customer_approval_email_template['message'] ) && ! empty( $ebrands_customer_approval_email_template['message'] ) ) {
		$message = esc_html( $ebrands_customer_approval_email_template['message'] );
		$message = str_replace( [ '{$username}' ], [ $user_obj->user_login ], $message );
	}
	wp_mail( $user_obj->user_email, $subject, $message );

	wp_send_json( [ // die if invalid nonce ajax request
		'status'  => 1,
		'message' => __( 'The user has been approved', 'e-brands' ),
	] );
}

add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );

function save_extra_user_profile_fields( $user_id ) {
	if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'update-user_' . $user_id ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}
	update_user_meta( $user_id, 'user_status', sanitize_text_field( $_POST['user_status'] ) );
}


