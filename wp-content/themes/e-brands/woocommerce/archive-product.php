<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

?>
	<section class="product-list v-padded">
		<div class="container">
			<?php
			if ( get_field( 'shop_page_title_text', 'option' ) ) {
				?>
				<div class="product-list__title-row">
					<?php
					the_field( 'shop_page_title_text', 'option' );
					?>
				</div>
				<?php
			}
			?>
			<div class="product-list__filter-row">
				<form action="" class="product-filter">

					<div class="search-col col">
						<label for="search"><?php _e( 'Suchen', 'e-brands' ); ?>
							<span class="clear cl-product-search-key"><?php _e( 'Clear', 'e-brands' ); ?></span></label>
						<div class="autocomplete">
							<input type="search" id="filter-by-search_key" autocomplete="off" name="search_key"
								   value="<?php if ( isset( $_GET['search_key'] ) && ! empty( $_GET['search_key'] ) ) {
									   echo sanitize_text_field( $_GET['search_key'] );
								   } ?>"
								   placeholder="<?php _e( 'Keyword', 'e-brands' ); ?>">
							<ul id="search-results" style="display: none"></ul>
						</div>
					</div>
					<?php
					$categories = get_terms( array(
						'taxonomy'   => 'product_cat',
						'hide_empty' => false,
					) );
					if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
						?>
						<div class="cat-col col">
							<label for="by-cat"><?php _e( 'Nach Produktkategorie', 'e-brands' ); ?>
								<span
									class="clear cl-product-filters"><?php _e( 'Clear', 'e-brands' ); ?></span></label>
							<select id="filter-by-category" name="category">
								<option value="">Select</option>
								<?php
								foreach ( $categories as $term ) {
									?>
									<option <?php if ( isset( $_GET['category'] ) && $term->slug == $_GET['category'] ) {
										echo "selected";
									} ?>
										value="<?php echo esc_html( $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></option>
									<?php
								}
								?>
							</select>
						</div>
						<?php
					}
					?>
					<?php
					$brands = get_terms( array(
						'taxonomy'   => 'product-brands',
						'hide_empty' => false,
					) );
					if ( ! empty( $brands ) && ! is_wp_error( $brands ) ) {
						?>
						<div class="brand-col col">
							<label for="by-brand"><?php _e( 'Nach Markenname', 'e-brands' ); ?> <span
									class="clear cl-product-filters"><?php _e( 'Clear', 'e-brands' ); ?></span></label>
							<select id="filter-by-brand" name="brand">
								<option value="">Select</option>
								<?php
								foreach ( $brands as $term ) {
									?>
									<option <?php if ( isset( $_GET['brand'] ) && $term->slug == $_GET['brand'] ) {
										echo "selected";
									} ?>
										value="<?php echo esc_html( $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></option>
									<?php
								}
								?>
							</select>
						</div>
						<?php
					}
					?>
				</form>
			</div>

			<?php
			$shop_page_listing_title = get_field( 'shop_page_listing_title', 'option' );
			if ( ! empty( $shop_page_listing_title ) ) {
				?>
				<div class="product-list__title-row__secondary">
					<?php
					if ( isset( $shop_page_listing_title['tag'] ) && ! empty( $shop_page_listing_title['tag'] ) ) {
						echo "<h4 class=\"title-mini\">" . esc_html( $shop_page_listing_title['tag'] ) . "</h4>";
					}
					if ( isset( $_GET['category'] ) && ! empty( $_GET['category'] ) || isset( $_GET['brand'] ) && ! empty( $_GET['category'] ) || isset( $_GET['search_key'] ) && ! empty( $_GET['category'] ) ) {
						$applied_filters = [];
						if ( isset( $_GET['search_key'] ) && ! empty( $_GET['search_key'] ) ) {
							$applied_filters[] = sanitize_text_field( $_GET['search_key'] );
						}
						if ( isset( $_GET['brand'] ) && ! empty( $_GET['brand'] ) ) {
							$brand = get_term_by( 'slug', sanitize_text_field( $_GET['brand'] ), 'product-brands' );
							if ( isset( $brand->name ) ) {
								$applied_filters[] = $brand->name;
							}
						}
						if ( isset( $_GET['category'] ) && ! empty( $_GET['category'] ) ) {
							$category = get_term_by( 'slug', sanitize_text_field( $_GET['category'] ), 'product_cat' );
							if ( isset( $category->name ) ) {
								$applied_filters[] = $category->name;
							}
						}
						echo "<h2 id=\"product-listing-title\">" . esc_html( implode( ' / ', $applied_filters ) ) . "</h2>";
					} else {
						if ( isset( $shop_page_listing_title['title'] ) && ! empty( $shop_page_listing_title['title'] ) ) {
							echo "<h2 id=\"product-listing-title\">" . esc_html( $shop_page_listing_title['title'] ) . "</h2>";
						}
					}
					if ( isset( $shop_page_listing_title['subtitle'] ) && ! empty( $shop_page_listing_title['subtitle'] ) ) {
						echo "<p>" . esc_html( $shop_page_listing_title['subtitle'] ) . "</p>";
					}
					?>
				</div>
				<?php
			}
			?>
			<div id="ebrands-shop-product-list">
				<?php
				//do_action( 'woocommerce_before_main_content' );
				// Output the product loop
				if ( woocommerce_product_loop() ) {
					//do_action( 'woocommerce_before_shop_loop' );
					?>

					<?php
					woocommerce_product_loop_start();
					if ( wc_get_loop_prop( 'total' ) ) {
						while ( have_posts() ) {
							the_post();
							/**
							 * Hook: woocommerce_shop_loop.
							 */
							do_action( 'woocommerce_shop_loop' );
							wc_get_template_part( 'content', 'product' );
						}
					}
					woocommerce_product_loop_end();
					do_action( 'woocommerce_after_shop_loop' );
					?>
					<?php
				} else {
					do_action( 'woocommerce_no_products_found' );
				}
				//do_action( 'woocommerce_after_main_content' );
				?>
			</div>
		</div>
	</section>
<?php

// Output the shop page content
$shop_page = get_post( wc_get_page_id( 'shop' ) );
if ( $shop_page ) :
	setup_postdata( $shop_page );
	?>
	<?php the_content(); ?>
	<?php
	wp_reset_postdata();
endif;


get_footer( 'shop' );
