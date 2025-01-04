<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woo.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) : ?>

	<section class="related products">
		<?php
		global $product;
		$product_id    = $product->get_id();
		$tproduct_cats = get_the_terms( $product_id, 'product_cat' );
		?>
		<div class="product-showcase__title-row related-product-title-row no-space-bottom">
			<div class="product-showcase__title-col">
				<h4 class="title-mini"><?php _e( 'Revolutionary', 'e-brands' ); ?></h4>
				<h2><span
						class="text-alternative"><?php _e( 'Ähnliche', 'e-brands' ); ?> </span> <?php _e( 'Produkte', 'e-brands' ); ?>
				</h2>
				<p><?php _e( 'Discover our innovative hair products for professional use.', 'e-brands' ); ?></p>
			</div>
			<?php
			if ( isset( $tproduct_cats[0]->slug ) ) {
				?>
				<div class="product-showcase__btn-col">
					<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>?category=<?php echo $tproduct_cats[0]->slug; ?>"
					   class="btn is-secondary"><?php _e( 'View all', 'e-brands' ); ?></a>
				</div>
				<?php
			}
			?>
		</div>

		<?php woocommerce_product_loop_start(); ?>

		<?php foreach ( $related_products as $related_product ) : ?>

			<?php
			$post_object = get_post( $related_product->get_id() );

			setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

			wc_get_template_part( 'content', 'product' );
			?>

		<?php endforeach; ?>

		<?php woocommerce_product_loop_end(); ?>

	</section>
<?php
endif;

wp_reset_postdata();
