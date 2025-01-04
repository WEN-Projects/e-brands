<section class="product-showcase v-padded">
	<div class="container">
		<div class="product-showcase__title-row">
			<div class="product-showcase__title-col">
				<?php
				$section_tag = get_field( 'section_tag' );
				if ( $section_tag ) {
					echo "<h4 class=\"title-mini\">" . esc_html( $section_tag ) . "</h4>";
				}
				if ( get_field( 'text_content' ) ) {
					the_field( 'text_content' );
				}
				?>
			</div>
			<?php
			$more_products_link = get_field( 'more_products_link' );
			if ( isset( $more_products_link['url'] ) && $more_products_link['title'] ) {
				?>
				<div class="product-showcase__btn-col">
					<a href="<?php echo esc_url( $more_products_link['url'] ); ?>"
					   class="btn is-secondary"><?php echo esc_html( $more_products_link['title'] ); ?></a>
				</div>
				<?php
			}
			?>
		</div>
		<?php
		$products_to_show = get_field( 'products_to_show' );
		if ( 'featured' == $products_to_show ) { //all the featured products to be displayed
			$args     = array(
				'featured' => true,
				'return'   => 'ids'
			);
			$products = wc_get_products( $args );
		} elseif ( 'test-products' == $products_to_show ) { //3 of the test products to be displayed
			$args = array(
				'status'         => 'publish',
				'post_type'      => 'product',
				'fields'         => 'ids',
				'posts_per_page' => 3,
				'meta_query'     => array(
					array(
						'key'     => 'is_test_product',
						'value'   => 'on',
						'compare' => '=',
					),
				),
			);

			$query    = new WP_Query( $args );
			$products = $query->get_posts();
			wp_reset_postdata();
		} else {
			$products = get_field( 'selected_products' );
		}
		if ( ! empty( $products ) ) {
			$layout_option = get_field( 'layout_option' );
			if ( 1 == $layout_option ) { ?>
				<div class="product-list-wrap">
					<?php
					foreach ( $products as $product ) {
						get_template_part( 'block-components/product/loop/content-product', null, array( 'product_id' => $product ) );
					} ?>
				</div>
				<?php
			} else {
				?>
				<div class="product-showcase__slider-wrap">
					<div class="swiper product-showcase__slider">
						<div class="swiper-wrapper">
							<?php
							foreach ( $products as $product ) {
								get_template_part( 'block-components/product/loop/slider-content-product', null, array( 'product_id' => $product ) );
							}
							?>
						</div>
						<?php
						get_template_part( 'block-components/slider-navigation' );
						?>
					</div>
				</div>
				<?php
			}
		}
		wp_reset_postdata();
		?>
	</div>
</section><!-- .product-showcase -->
