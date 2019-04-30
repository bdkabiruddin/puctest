<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

if ( empty( $product ) || ! $product->exists() ) {
	return;
}

if ( sizeof( $related_products ) == 0 ) return;


if( isset($_GET['releated_columns']) ) { 
	$woocommerce_loop['columns'] = $_GET['releated_columns'];
} else {
	$woocommerce_loop['columns'] = puca_tbay_get_config('releated_product_columns', 4);
}

$columns_desktopsmall = 3;
$columns_tablet = 2;
$columns_mobile = 2;

$rows = apply_filters( 'puca_supermaket_woo_row_single_full', false,2 ); 
if($rows) {
	$rows = 4;
	$woocommerce_loop['columns'] = 1;
	$columns_desktopsmall = 1;
	$columns_tablet = 1;
	$columns_mobile = 1;
} else {
	$rows = 1;
}

$active_theme = puca_tbay_get_part_theme();

$show_product_releated = puca_tbay_get_config('show_product_releated', true);
 
if ( $related_products && $show_product_releated ) : ?> 

	<div class="related products widget" id="product-related">
		<h3 class="widget-title"><span><?php esc_html_e( 'Related Products', 'puca' ); ?></span></h3>
		<?php  wc_get_template( 'layout-products/'.$active_theme.'/carousel-related.php' , array( 'loops'=>$related_products,'rows' => $rows, 'pagi_type' => 'no', 'nav_type' => 'yes','columns'=>$woocommerce_loop['columns'],'screen_desktop'=>$woocommerce_loop['columns'],'screen_desktopsmall'=>$columns_desktopsmall,'screen_tablet'=>$columns_tablet,'screen_mobile'=>$columns_mobile ) ); ?>

	</div>

<?php endif;

wp_reset_postdata();