<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

wc_print_notices();

$show_image = apply_filters("pisol_rm_pro_pisol_show_image",false);
if( $show_image ){
	$columns = 5;
}else{
	$columns = 4;
}
?>
<div class="pisol_grid">
<div class="pisol_cat">
	<?php do_action('pisol_product_category'); ?>
</div>
<div class="pisol_products">
	<?php do_action('pisol_product_table_title');	?>
	<?php do_action('pisol_product_table'); ?>
	<?php do_action('pisol_after_product_table'); ?>
</div>
<!-- This below line prevents the page refresh when cart is not there on the page -->
<span style="display:none;" class="woocommerce-cart-form"></span>
</div>
