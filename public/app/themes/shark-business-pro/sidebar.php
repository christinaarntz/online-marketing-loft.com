<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package shark_business_pro
 */
$sidebar_layout = shark_business_pro_sidebar_layout();
if ( 'no-sidebar' == $sidebar_layout ) {
	return;
}

$sidebar = 'sidebar-1';
if ( is_singular() ) {
	$sidebar = get_post_meta( get_the_ID(), 'shark-business-pro-selected-sidebar', true );
	$sidebar = ! empty( $sidebar ) ? $sidebar : 'sidebar-1';
} elseif ( class_exists( 'WooCommerce' ) && is_shop() ) {
	$sidebar = get_post_meta( get_option( 'woocommerce_shop_page_id' ), 'shark-business-pro-selected-sidebar', true );
	$sidebar = ! empty( $sidebar ) ? $sidebar : 'sidebar-1';
}
?>

<aside id="secondary" class="widget-area">
	<?php dynamic_sidebar( $sidebar ); ?>
</aside><!-- #secondary -->
