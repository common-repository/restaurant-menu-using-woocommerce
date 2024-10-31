<?php

class pisol_restaurant_design{
    function  __construct(){
        add_action('wp_enqueue_scripts', array($this, 'inlineScript'));
    }

    function inlineScript(){
        $pisol_rm_category_button_bg_color = get_option('pisol_rm_category_button_bg_color', '#ff9f1c');
        $pisol_rm_category_button_text_color = get_option('pisol_rm_category_button_text_color', '#ffffff');
        $pisol_rm_active_category_button_bg_color = get_option('pisol_rm_active_category_button_bg_color', '#eb4511');
        $pisol_rm_active_category_button_text_color = get_option('pisol_rm_active_category_button_text_color', '#ffffff');

        $pisol_rm_sub_category_button_bg_color = get_option('pisol_rm_sub_category_button_bg_color', '#cccccc');
        $pisol_rm_sub_category_button_text_color = get_option('pisol_rm_sub_category_button_text_color', '#ffffff');

        $pisol_rm_add_to_cart_button_bg_color = get_option('pisol_rm_add_to_cart_button_bg_color', '#EB4511');

        $pisol_rm_hide_cart_show_cart_bg_color = get_option('pisol_rm_hide_cart_show_cart_bg_color', '#EB4511');
        $pisol_rm_hide_cart_show_cart_text_color = get_option('pisol_rm_hide_cart_show_cart_text_color', '#ffffff');

        $pisol_rm_checkout_bg_color = get_option('pisol_rm_checkout_bg_color', '#EB4511');
        $pisol_rm_checkout_text_color = get_option('pisol_rm_checkout_text_color', '#ffffff');

        $pisol_rm_search_button_bg_color = get_option('pisol_rm_search_button_bg_color', '#EB4511');
        $pisol_rm_search_button_text_color = get_option('pisol_rm_search_button_text_color', '#ffffff');

        $pisol_rm_side_dish_group_bg_color = get_option('pisol_rm_side_dish_group_bg_color', '#f2d1b3');
        $pisol_rm_side_dish_group_text_color = get_option('pisol_rm_side_dish_group_text_color', '#000000');

        $pisol_rm_restricted_side_dish_group_bg_color = get_option('pisol_rm_restricted_side_dish_group_bg_color', '#ff0000');
        $pisol_rm_restricted_side_dish_group_text_color = get_option('pisol_rm_restricted_side_dish_group_text_color', '#ffffff');

        $pisol_rm_selected_side_dish_bg_color = get_option('pisol_rm_selected_side_dish_bg_color', '#EB4511');
        $pisol_rm_selected_side_dish_text_color = get_option('pisol_rm_selected_side_dish_text_color', '#ffffff');

        $pisol_rm_non_selected_side_dish_bg_color = get_option('pisol_rm_non_selected_side_dish_bg_color', '#cccccc');
        $pisol_rm_non_selected_side_dish_text_color = get_option('pisol_rm_non_selected_side_dish_text_color', '#ffffff');

        $css = "
            .pisol_cat .pisol_cat_button{
                background-color: {$pisol_rm_category_button_bg_color} !important;
                color: {$pisol_rm_category_button_text_color} !important;
            }

            .pisol_cat .pisol_cat_button.active{
                background-color: {$pisol_rm_active_category_button_bg_color} !important;
                color: {$pisol_rm_active_category_button_text_color} !important;
            }

            .extras h2, .product_child_cat_row{
                background-color: {$pisol_rm_sub_category_button_bg_color} !important;
                color: {$pisol_rm_sub_category_button_text_color} !important;
            }

            .pisol_child_cat_toggle, .pisol_child_cat_toggle span{
                color: {$pisol_rm_sub_category_button_text_color} !important;
            }

            #pisol_product_table .add_to_cart_button:before{
                background-color: {$pisol_rm_add_to_cart_button_bg_color} !important;
            }

            #pisol-hide-cart, #pisol-cart-open{
                background-color: {$pisol_rm_hide_cart_show_cart_bg_color} !important;
                color: {$pisol_rm_hide_cart_show_cart_text_color} !important;
            }

            .checkout-button.button{
                background-color: {$pisol_rm_checkout_bg_color} !important;
                color: {$pisol_rm_checkout_text_color} !important;
            }

            #pisol_search_all_product{
                background-color: {$pisol_rm_search_button_bg_color} !important;
                color: {$pisol_rm_search_button_text_color} !important;
            }

            #pisol_product_table .sidedish-group, #sp-side-dish-container .sp-sidedish-group{
                background-color: {$pisol_rm_side_dish_group_bg_color} !important;
                color: {$pisol_rm_side_dish_group_text_color} !important;
            }

            #pisol_product_table .sidedish-group.pi-restricted, #sp-side-dish-container .sp-sidedish-group.pi-restricted{
                background-color: {$pisol_rm_restricted_side_dish_group_bg_color} !important;
                color: {$pisol_rm_restricted_side_dish_group_text_color} !important;
            }

            #pisol_product_table .dishes-group div label{
                background-color: {$pisol_rm_non_selected_side_dish_bg_color} !important;
                color: {$pisol_rm_non_selected_side_dish_text_color} !important;
            }

            #pisol_product_table input[type=checkbox]:checked+label, #sp-side-dish-container input[type=checkbox]:checked+label{
                background-color: {$pisol_rm_selected_side_dish_bg_color} !important;
                color: {$pisol_rm_selected_side_dish_text_color} !important;
            }
        ";

        wp_register_style( 'pisol-restaurant-menu-dummy-handle', false );
        wp_enqueue_style( 'pisol-restaurant-menu-dummy-handle' );
        wp_add_inline_style( 'pisol-restaurant-menu-dummy-handle', $css);
    }
}

$design_overwrite = get_option('pisol_rm_add_custom_color',0);
if(!empty($design_overwrite)){
    new pisol_restaurant_design();
}