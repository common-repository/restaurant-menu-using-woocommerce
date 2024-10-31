<?php

class pisol_restaurant_menu_food_type{

    private $setting = array();

    private $active_tab;

    private $this_tab = 'food_type';

    private $tab_name = "Food type";

    private $setting_key = 'pisol_restaurant_food_type';

    function __construct(){

        $this->active_tab = (isset($_GET['tab'])) ? sanitize_text_field($_GET['tab']) : 'default';
        
        $this->settings = array(
            array('field'=>'pisol_rm_show_food_type', 'label'=>__('Food type','pisol-restautant-menu'),'type'=>'select', 'default'=>'hide','value'=>array('hide'=>__('Hide','pisol-restautant-menu'), 'show'=>__('Show in column','pisol-restautant-menu'), 'below_product_name' => __('Show below product name','pisol-restautant-menu')), 'desc'=>__('Using this option you can show or hide food type in front end','pisol-restautant-menu')),

            array('field'=>'color-setting', 'class'=> 'bg-primary text-light', 'class_title'=>'text-light font-weight-light h4', 'label'=>__('Dish type icon','pisol-restautant-menu'), 'type'=>'setting_category'),

            array('field'=>'pisol_rm_veg_icon', 'label'=>__('Veg Icon','pisol-restautant-menu'),'type'=>'image', 'default'=>""),
            
            array('field'=>'pisol_rm_nonveg_icon', 'label'=>__('Non-Veg Icon','pisol-restautant-menu'),'type'=>'image', 'default'=>""),

            array('field'=>'pisol_rm_gluten_free_icon', 'label'=>__('Gluten Free Icon','pisol-restautant-menu'),'type'=>'image', 'default'=>""),

            array('field'=>'pisol_rm_contain_nuts_icon', 'label'=>__('Contain nuts Icon','pisol-restautant-menu'),'type'=>'image', 'default'=>""),

            array('field'=>'pisol_rm_hot_icon', 'label'=>__('Hot Icon','pisol-restautant-menu'),'type'=>'image', 'default'=>""),

            array('field'=>'pisol_rm_vegan_icon', 'label'=>__('Vegan Icon','pisol-restautant-menu'),'type'=>'image', 'default'=>""),
 
        );
        

        if($this->this_tab == $this->active_tab){
            add_action('pisol_restaurant_menu_tab_content', array($this,'tab_content'),10);
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
        <form method="post" action="options.php"  class="pisol-setting-form">
        <?php settings_fields( $this->setting_key ); ?>
        <?php
            echo "<div id='pisol-rm-color-options'>";
            for($i = 0; $i < count($this->settings); $i++){
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

    
}

new pisol_restaurant_menu_food_type();

