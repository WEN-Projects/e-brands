<?php
if ( ! isset( $args['product_id'] ) ) {
	return;
}
global $product;
$product = wc_get_product( $args['product_id'] );

?>

<div class="product-card">
	<div class="product-card__image-holder">
		<a href="<?php echo get_permalink( $args['product_id'] ); ?>" class="stretched-link"></a>
		<?php
		do_action( 'woocommerce_before_shop_loop_item_title', $args['product_id'], $product );
		?>
	</div>
	<div class="product-card__detail">
		<div class="two-col-wrap">
			<div class="name-wrap">
				<h4 class="product-card__name"><?php echo esc_html( $product->get_name() ); ?></h4>
				<?php echo ebrands_get_product_brand( $args['product_id'] ); ?>
			</div>
			<h5 class="product-card__price"><?php echo $product->get_price_html(); ?>
			</h5>
		</div>
		<?php
//			do_action('ebrands_wc_add_to_cart');
		?>
	</div>
</div>
