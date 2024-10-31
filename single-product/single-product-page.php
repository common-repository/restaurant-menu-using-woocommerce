<?php

class pisol_restaurent_single_product_page{

    function __construct(){
        add_filter('wc_get_template',array(__CLASS__,'changePrice'),PHP_INT_MAX,2);

        add_action('woocommerce_before_add_to_cart_form', array(__CLASS__,'sideDishesGroup'));

        add_action( 'wp_enqueue_scripts', array(__CLASS__,'enqueue_style') );

        add_action( 'woocommerce_after_add_to_cart_button', array(__CLASS__,'formDivForHiddenElement') ); 

        add_action('woocommerce_product_meta_end', array(__CLASS__, 'productType'), 10);

        add_filter('woocommerce_loop_add_to_cart_link', array(__CLASS__, 'changeAddToCartUrl'),PHP_INT_MAX,2);
    }

    static function productType($template_name){
        global $product;
        $show_type = get_option('pisol_rm_show_food_type','hide');
        if(is_object($product) && $product->is_type('simple') && $show_type != 'hide'){
            echo pisol_products::get_food_type($product->get_id());
        }
    }

    static function changeAddToCartUrl($html, $product){
        $product_id = $product->get_id();

        $sidedish_present = $product->is_type('simple') && pisol_restaurent_single_product_page::isSideDishPresent($product_id) ? true : false;

        if($sidedish_present){
            $url = get_permalink($product_id);
            $dom = new DOMDocument;
            $dom->loadHTML($html);
            $xpath = new DOMXPath($dom);
            $nodes = $dom->getElementsByTagName('a');
            foreach($nodes as $node) {
                $node->setAttribute('href', $url);
                $class = $node->getAttribute('class');
                $final_class = str_replace('ajax_add_to_cart', '', $class);
                $node->setAttribute('class', $final_class);
            }
            return $dom->saveHTML();
        }

        return $html;

    }

    static function changePrice($template, $template_name){

            if($template_name == 'single-product/price.php' && function_exists('is_product') && is_product()){

                return plugin_dir_path(__FILE__).'/price.php';
            
            }

            /*
            if($template_name == 'loop/add-to-cart.php'){
                global $product;

                if(!is_object($product)) return $template;

                $product_id = $product->get_id();

                $sidedish_present = $product->is_type('simple') && pisol_restaurent_single_product_page::isSideDishPresent($product_id) ? true : false;

                if($sidedish_present){
                    return plugin_dir_path(__FILE__).'/add-to-cart.php';
                }else{
                    return $template;
                }

            }
            */

        
		return $template;
    }
    
    static function isSideDishPresent($product_id){
        $sidedishes = json_decode( get_post_meta($product_id, 'pisol_sidedishes',true) );
        if(isset($sidedishes) && count($sidedishes) > 0) return true;

        return false;
    }

    static function sideDishesGroup(){
        global $product;
        if(!$product->is_type('simple')) return;
        $product_id = $product->get_id();
        $categories = get_the_terms( $product_id, 'product_cat' );

        $cat = $categories[0];
        echo '<div id="sp-selected-side-dishes"></div>';

        pisol_restaurent_single_product_page::get_sidedishes($product_id, $cat->term_id);
    }

    static function formDivForHiddenElement(){
        echo '<div id="pisol-sp-form-attributes"></div>';
    }

    static function get_sidedishes($product_id, $cat){
        //print_r( get_post_meta($product_id, 'pisol_sidedishes',true));
        $sidedishes = json_decode( get_post_meta($product_id, 'pisol_sidedishes',true) );
        $group_count = 0;
        if(isset($sidedishes)):
            echo '<div id="sp-side-dish-container" data-cat="'.esc_attr($cat).'" data-product="'.esc_attr($product_id).'">';
            
                foreach($sidedishes as $side_dish){
                    include PISOL_RESTAURANT_MENU_PATH.'single-product/product-sidedish-group.php';
                    $group_count++;
                }
            echo '</div>';
         endif;
    }

    static function enqueue_style(){

        if(is_product()){
            wp_enqueue_style( 'pisol_single_product_style', PISOL_RESTAURANT_MENU_URL.'single-product/single-product.css','','4.6.1');
            wp_enqueue_script( 'pisol_single_product_script',PISOL_RESTAURANT_MENU_URL.'single-product/single-product.js',array('jquery'));
        }
    }
}

new pisol_restaurent_single_product_page();