<?php

class pisol_restaurant_menu_design{

    private $setting = array();

    private $active_tab;

    private $this_tab = 'default';

    private $tab_name = "Design setting";

    private $setting_key = 'pisol_restaurant_design_setting';

    function __construct(){

        if(PISOL_RM_FREE_VERSION){
            $this->this_tab = 'default';
        }else{
            $this->this_tab = 'design';
        }

        $this->active_tab = (isset($_GET['tab'])) ? sanitize_text_field($_GET['tab']) : 'default';
        
        $this->settings = array(

            array('field'=>'pisol_rm_enable_search', 'label'=>__('Enable product search option','pisol-restautant-menu'),'type'=>'switch', 'default'=>'1','desc'=>__('Product search option','pisol-restautant-menu') ),

            array('field'=>'pisol_rm_enable_image_popup', 'label'=>__('Enable lightbox popup for product image','pisol-restautant-menu'),'type'=>'switch', 'default'=>'1','desc'=>__('Product image will open in a popup','pisol-restautant-menu'),'pro'=> PISOL_RM_FREE_VERSION ),

            array('field'=>'pisol_rm_customize_button', 'label'=>__('Show customize button','pisol-restautant-menu'),'type'=>'select', 'default'=>'0','desc'=>__('When enabled side-dish group will be hidden till user click the customize button','pisol-restautant-menu'),'value'=> array('0' => __('Don\'t hide any side dish group','pisol-restautant-menu'), '1'=>__('Hide non essential side dish group (pro)','pisol-restautant-menu'), 'hide-all' => __('Hide all side dish group','pisol-restautant-menu'))),

            array('field'=>'pisol_rm_customize_button_label', 'label'=>__('Customize button label','pisol-restautant-menu'),'type'=>'text', 'default'=>'Add side dishes','desc'=>__('Text shown inside button that will show or hide the side dish group','pisol-restautant-menu')),

            array('field'=>'pisol_rm_clear_selection', 'label'=>__('Clear side dish selection once product added to cart','pisol-restautant-menu'),'type'=>'switch', 'default'=>'0','desc'=>__('when enabled the selected side dish of the product get cleared on add to cart','pisol-restautant-menu')),
            
            array('field'=>'pisol_rm_show_product_image_on_mobile', 'label'=>__('Show product image on mobile','pisol-restautant-menu'),'type'=>'switch', 'default'=>0, 'desc'=>__('You can show product image on mobile devices as well with this option','pisol-restautant-menu')),

            array('field'=>'pisol_rm_add_custom_color', 'label'=>__('Add custom color to Menu element','pisol-restautant-menu'),'type'=>'switch', 'default'=>0, 'desc'=>__('Select this option so you can change the menu page color using this plugin setting','pisol-restautant-menu')),

            array('field'=>'color-setting', 'class'=> 'bg-primary text-light', 'class_title'=>'text-light font-weight-light h4', 'label'=>__('Category button colors','pisol-restautant-menu'), 'type'=>'setting_category'),

            array('field'=>'pisol_rm_category_button_bg_color', 'label'=>__('Category button Background color','pisol-restautant-menu'),'type'=>'color', 'default'=>"#ff9f1c"),

            array('field'=>'pisol_rm_category_button_text_color', 'label'=>__('Category button text color','pisol-restautant-menu'),'type'=>'color', 'default'=>"#ffffff"),

            array('field'=>'pisol_rm_active_category_button_bg_color', 'label'=>__('Active Category button Background color','pisol-restautant-menu'),'type'=>'color', 'default'=>"#eb4511"),
            array('field'=>'pisol_rm_active_category_button_text_color', 'label'=>__('Active Category button text color','pisol-restautant-menu'),'type'=>'color', 'default'=>"#ffffff"),

            array('field'=>'color-setting', 'class'=> 'bg-primary text-light', 'class_title'=>'text-light font-weight-light h4', 'label'=>__('Sub category bar inside the menu','pisol-restautant-menu'), 'type'=>'setting_category'),

            array('field'=>'pisol_rm_sub_category_button_bg_color', 'label'=>__('Subcategory bar Background color','pisol-restautant-menu'),'type'=>'color', 'default'=>"#cccccc"),

            array('field'=>'pisol_rm_sub_category_button_text_color', 'label'=>__('Subcategory bar text color','pisol-restautant-menu'),'type'=>'color', 'default'=>"#ffffff"),

            array('field'=>'color-setting', 'class'=> 'bg-primary text-light', 'class_title'=>'text-light font-weight-light h4', 'label'=>__('Other Buttons colors','pisol-restautant-menu'), 'type'=>'setting_category'),

            array('field'=>'pisol_rm_add_to_cart_button_bg_color', 'label'=>__('Add to cart button Background color','pisol-restautant-menu'),'type'=>'color', 'default'=>"#EB4511"),

            array('field'=>'pisol_rm_hide_cart_show_cart_bg_color', 'label'=>__('Hide cart / Show cart button background color','pisol-restautant-menu'),'type'=>'color', 'default'=>"#EB4511"),

            array('field'=>'pisol_rm_hide_cart_show_cart_text_color', 'label'=>__('Hide cart / Show cart button text color','pisol-restautant-menu'),'type'=>'color', 'default'=>"#ffffff"),

            array('field'=>'pisol_rm_checkout_bg_color', 'label'=>__('Proceed to checkout button background color','pisol-restautant-menu'),'type'=>'color', 'default'=>"#EB4511"),
            array('field'=>'pisol_rm_checkout_text_color', 'label'=>__('Proceed to checkout button text color','pisol-restautant-menu'),'type'=>'color', 'default'=>"#ffffff"),

            array('field'=>'pisol_rm_search_button_bg_color', 'label'=>__('Search button background color','pisol-restautant-menu'),'type'=>'color', 'default'=>"#EB4511"),

            array('field'=>'pisol_rm_search_button_text_color', 'label'=>__('Search button text color','pisol-restautant-menu'),'type'=>'color', 'default'=>"#ffffff"),

            array('field'=>'color-setting', 'class'=> 'bg-primary text-light', 'class_title'=>'text-light font-weight-light h4', 'label'=>__('Side Dish group colors','pisol-restautant-menu'), 'type'=>'setting_category'),
            
            array('field'=>'pisol_rm_side_dish_group_bg_color', 'label'=>__('Side Dish group background color','pisol-restautant-menu'),'type'=>'color', 'default'=>"#f2d1b3"),

            array('field'=>'pisol_rm_side_dish_group_text_color', 'label'=>__('Side Dish group text color','pisol-restautant-menu'),'type'=>'color', 'default'=>"#000000"),

            array('field'=>'pisol_rm_restricted_side_dish_group_bg_color', 'label'=>__('Background color of Side Dish group with restriction of minimum side dish selection','pisol-restautant-menu'),'type'=>'color', 'default'=>"#ff0000"),
            array('field'=>'pisol_rm_restricted_side_dish_group_text_color', 'label'=>__('Background color of Side Dish group with restriction of minimum side dish selection','pisol-restautant-menu'),'type'=>'color', 'default'=>"#ffffff"),

            array('field'=>'color-setting', 'class'=> 'bg-primary text-light', 'class_title'=>'text-light font-weight-light h4', 'label'=>__('Side Dish color options (this are the side dish inside side dish groups)','pisol-restautant-menu'), 'type'=>'setting_category'),

            array('field'=>'pisol_rm_selected_side_dish_bg_color', 'label'=>__('Selected side dish button background color','pisol-restautant-menu'),'type'=>'color', 'default'=>"#EB4511"),

            array('field'=>'pisol_rm_selected_side_dish_text_color', 'label'=>__('Selected side dish button text color','pisol-restautant-menu'),'type'=>'color', 'default'=>"#ffffff"),

            array('field'=>'pisol_rm_non_selected_side_dish_bg_color', 'label'=>__('Non Selected side dish button background color','pisol-restautant-menu'),'type'=>'color', 'default'=>"#CCCCCC"),

            array('field'=>'pisol_rm_non_selected_side_dish_text_color', 'label'=>__('Non Selected side dish button text color','pisol-restautant-menu'),'type'=>'color', 'default'=>"#ffffff"),

            
        );
        

        if($this->this_tab == $this->active_tab){
            add_action('pisol_restaurant_menu_tab_content', array($this,'tab_content'),10);
            add_action('admin_enqueue_scripts', array($this, 'inlineScript'));
        }

        add_action('pisol_restaurant_menu_tab', array($this,'tab'),1);
        


        $this->register_settings();

        //$this->delete_settings();
        
    }

    function delete_settings(){
        foreach($this->settings as $setting){
            delete_option( $setting['field'] );
        }
    }

    function register_settings(){   

        foreach($this->settings as $setting){
                register_setting( $this->setting_key, $setting['field']);
        }
    
    }
   

    function tab(){
        ?>
        <a class="fon-weight-bold px-3 text-light d-flex align-items-center border-left border-right <?php echo $this->active_tab == $this->this_tab || '' ? 'bg-primary' : 'bg-secondary'; ?>" href="<?php echo admin_url( 'admin.php?page='.$_GET['page'].'&tab='.$this->this_tab ); ?>">
            <?php _e( $this->tab_name, 'pisol-dtt' ); ?> 
        </a>
        <?php
    }

    function tab_content(){
        ?>
        <div class="alert alert-info my-3">
        Some times this setting may not work, as Some Themes overwrites the color set by this setting, in such case you can change color by adding your custom CSS 
        </div>
        <form method="post" action="options.php"  class="pisol-setting-form">
        <?php settings_fields( $this->setting_key ); ?>
        <?php
            new pisol_class_form($this->settings[0], $this->setting_key);
            new pisol_class_form($this->settings[1], $this->setting_key);
            new pisol_class_form($this->settings[2], $this->setting_key);
            new pisol_class_form($this->settings[3], $this->setting_key);
            new pisol_class_form($this->settings[4], $this->setting_key);
            new pisol_class_form($this->settings[5], $this->setting_key);
            new pisol_class_form($this->settings[6], $this->setting_key);
            
            echo "<div id='pisol-rm-color-options'>";
            for($i = 7; $i < count($this->settings); $i++){
                if(isset($this->settings[$i])){
                    new pisol_class_form($this->settings[$i], $this->setting_key);
                }
            }
            echo "</div>";
        ?>
        <input type="submit" name="submit" id="submit" class="btn btn-primary btn-md my-3" value="<?php echo __('Save Changes','pisol-dtt'); ?>">
        </form>
        <?php
    }

    function inlineScript(){
        $js = '
        jQuery(function($){
        function pisolRMDesignHideShowField(parent, child, show_hide) {
            var $ = jQuery;
            $(parent).on(\'change\', function () {
                if (show_hide == \'show\') {
                    if ($(parent).is(":checked")) {
                        $(child).fadeIn();
                    } else {
                        $(child).fadeOut();
                    }
                } else {
                    if ($(parent).is(":checked")) {
                        $(child).fadeOut();
                    } else {
                        $(child).fadeIn();
                    }
                }
            });
            jQuery(parent).trigger("change");
        }
        pisolRMDesignHideShowField("#pisol_rm_add_custom_color", "#pisol-rm-color-options", "show");

        $("#pisol_rm_customize_button").on(\'change\', function () {
            var val = $(this).val();
            if(val == "0"){
                $("#row_pisol_rm_customize_button_label").fadeOut();
            }else{
                $("#row_pisol_rm_customize_button_label").fadeIn();
            }
        });
        jQuery("#pisol_rm_customize_button").trigger("change");
    });
        
        ';

        wp_add_inline_script('jquery', $js, 'after');
    }
}

new pisol_restaurant_menu_design();

