<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.3.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
$format  = isset( $format ) ? $format : '';

if ( $total <= 1 ) {
	return;
}

if ( paginate_links() ) {
	global $wp_query;
	$big = 999999999; // need an unlikely integer
	echo "<div class='e-brands-pagination'>" . paginate_links( array(
			'base'      => '%_%',
			'format'    => '?page=%#%',
			'prev_text' => __( '« Zurück' ),
			'next_text' => __( 'Nächste »' ),
//	'current' => max( 1, get_query_var('paged') ),
			'total'     => $wp_query->max_num_pages
		) ) . "</div>";
}

?>
