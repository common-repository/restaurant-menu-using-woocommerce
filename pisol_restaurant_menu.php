<?php
/*
Plugin Name: Restaurant Menu using WooCommerce
Plugin URI: https://woo-restaurant.com/
Description: Online Food ordering made easy, just install and your online food business is ready
Version: 6.2.61
Author: PI Websolution
Author URI: piwebsolution.com
Text Domain: pisol-restautant-menu
Domain Path: /languages
WC tested up to: 9.3.3
Requires plugins: woocommerce
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

define('PISOL_RESTAURANT_MENU_URL', plugin_dir_url(__FILE__));
define('PISOL_RESTAURANT_MENU_PATH', plugin_dir_path( __FILE__ ));
define('PISOL_RESTAURANT_MENU_BASE', plugin_basename(__FILE__));
define('PISOL_RESTAURANT_MENU_PRICE', '$25');
define('PISOL_RESTAURANT_MENU_BUY_URL', 'https://www.piwebsolution.com/cart/?add-to-cart=574&variation_id=675');
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/* 
    Making sure woocommerce is there 
*/
if(!is_plugin_active( 'woocommerce/woocommerce.php')){
    function pisol_rm_my_error_notice() {
        ?>
        <div class="error notice">
            <p><?php esc_html_e( 'Please Install and Activate WooCommerce plugin, without that this plugin cant work','Warning message when woocommerce is not installed', 'pisol-restautant-menu' ); ?></p>
        </div>
        <?php
       
    }
    add_action( 'admin_notices', 'pisol_rm_my_error_notice' );
    //deactivate_plugins(plugin_basename(__FILE__));
    return;
}

if (!class_exists('pisol_restaurant_menu_pro_option')) {
    define('PISOL_RM_FREE_VERSION',true);
}else{
    define('PISOL_RM_FREE_VERSION',false);
}

require_once( PISOL_RESTAURANT_MENU_PATH . 'include/pisol_products.php');
require_once( PISOL_RESTAURANT_MENU_PATH . 'include/pisol_categories.php');
require_once( PISOL_RESTAURANT_MENU_PATH . 'include/pisol.class.form.php');
require_once( PISOL_RESTAURANT_MENU_PATH . 'include/pisol.class.promotion.php');
require_once( PISOL_RESTAURANT_MENU_PATH . 'include/review.php');

require_once( PISOL_RESTAURANT_MENU_PATH . 'admin/meta/pisol_admin_meta.php');
require_once( PISOL_RESTAURANT_MENU_PATH . 'quickview/class.frontend.php');
require_once( PISOL_RESTAURANT_MENU_PATH . 'sidedish/class-side-dish.php');
require_once( PISOL_RESTAURANT_MENU_PATH . 'sidedish/class-side-dish-integrator.php');
require_once( PISOL_RESTAURANT_MENU_PATH . 'admin/pisol_restaurant_menu_design.php');
require_once( PISOL_RESTAURANT_MENU_PATH . 'admin/pisol_restaurant_menu_food_type.php');
require_once( PISOL_RESTAURANT_MENU_PATH . 'admin/pisol_restaurant_menu_speed.php');
require_once( PISOL_RESTAURANT_MENU_PATH . 'single-product/single-product-page.php');

add_action( 'plugins_loaded', 'pisol_load_language' );
function pisol_load_language(){
    load_plugin_textdomain( 'pisol-restautant-menu', false, basename( dirname( __FILE__ ) ) . '/languages'  );
}

/**
 * Declare compatible with HPOS new order table 
 */
add_action( 'before_woocommerce_init', function() {
	if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	}
} );

if(is_admin() ){
    require_once( PISOL_RESTAURANT_MENU_PATH . 'admin/pisol_admin.php');
}else{
    require_once( PISOL_RESTAURANT_MENU_PATH . 'front/pisol_front.php');
    require_once( PISOL_RESTAURANT_MENU_PATH . 'front/pisol-design.php');
}

function pisol_prm_plugin_link( $links ) {
	$links = array_merge( array(
        '<a href="' . esc_url( admin_url( '/admin.php?page=pisol-restaurant-menu' ) ) . '">' . _x( 'Settings','present in plugin list page','pisol-restautant-menu' ) . '</a>',
        '<a style="color:#0a9a3e; font-weight:bold;" target="_blank" href="' . esc_url(PISOL_RESTAURANT_MENU_BUY_URL) . '">' . _x( 'Buy PRO Version','present in plugin list page','pisol-restautant-menu' ) . '</a>'
	), $links );
	return $links;
}
add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'pisol_prm_plugin_link' );

if (!class_exists('pisol_restaurant_menu_pro_option')) {
    require_once( PISOL_RESTAURANT_MENU_PATH . 'admin/pisol_restaurant_menu_option.php');
    add_action('admin_init', 'pi_resturant_menu_free_option');
    function pi_resturant_menu_free_option(){
        update_option('woocommerce_enable_ajax_add_to_cart','yes' );
        new pisol_restaurant_menu_option();
    }
}

function pisol_rm_get_transient($key){
    $caching_enabled = get_option('pisol_rm_enable_caching', 0);

    if(empty($caching_enabled)) return false;

    $slug = 'pisol_rm_cache_'.$key;
    $val = get_transient($slug);
    return $val;
}

function pisol_rm_set_transient($key, $value){
    $caching_enabled = get_option('pisol_rm_enable_caching', 0);
    if(empty($caching_enabled)) return false;
    
    $expiry = (int)get_option('pisol_rm_cache_expiry', 30);
    
    $expiry_seconds = 60 *  $expiry;
    $slug = 'pisol_rm_cache_'.$key;
    return  set_transient($slug, $value, $expiry_seconds);
}

function pisol_cartPageNotSetWarning() {
    $cart = get_option('woocommerce_cart_page_id',"");
    if(empty($cart)){
    ?>
    <div class="notice notice-error">
        <p><?php printf(__( 'You have not configured "Cart page"  in WooCommerce setting <a href="%s">Click here to configure</a>, without this configured plugin will not work properly<br>This will cause the cart page to go blank as some one adds the product in the cart', 'pisol-restautant-menu' ),admin_url('admin.php?page=wc-settings&tab=advanced')); ?></p>
    </div>
    <?php
    }
}
add_action( 'admin_notices', 'pisol_cartPageNotSetWarning' );