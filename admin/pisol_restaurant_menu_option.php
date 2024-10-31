<?php

class pisol_restaurant_menu_option{

    private $setting = array();

    private $active_tab;

    private $this_tab = 'options';

    private $tab_name = "Advance setting";

    private $setting_key = 'pisol_display';

    private $cat_array = array('Buy Pro Version');

    private $animation = array("bounceIn",
    "bounceInDown",
    "bounceInLeft",
    "bounceInRight",
    "bounceInUp",
    "fade-in",
    "fadeInDown",
    "fadeInDownBig",
    "fadeInLeft",
    "fadeInLeftBig",
    "fadeInRight",
    "fadeInRightBig",
    "fadeInUp",
    "fadeInUpBig",
    "flipInX",
    "flipInY",
    "lightSpeedIn",
    "rotateIn",
    "rotateInDownLeft",
    "rotateInDownRight",
    "rotateInUpLeft",
    "rotateInUpRight",
    "slideInUp",
    "slideInDown",
    "slideInLeft",
    "slideInRight",
    "zoomIn",
    "zoomInDown",
    "zoomInLeft",
    "zoomInRight",
    "zoomInUp",
    "rollIn");

    

    function __construct(){

        $this->animation = $this->creatingArray($this->animation);

        $this->active_tab = (isset($_GET['tab'])) ? sanitize_text_field($_GET['tab']) : 'default';
        
        $this->settings = array(
            array('field'=>'pisol_rest_layout','pro'=>true, 'label'=>__('Layout of menu page','pisol-restautant-menu'),'type'=>'select',  'value'=>array('left-cart-right-product'=>__('Cart left, product right','pisol-restautant-menu'),'left-product-right-cart'=>__('Cart right, product left','pisol-restautant-menu'),'product-top-cart-bottom'=>__('product top, cart bottom','pisol-restautant-menu'),'product-bottom-cart-top'=>__('product bottom, cart top','pisol-restautant-menu')),'default'=> 'left-cart-right-product',  'desc'=>__('Set layout of the menu page','pisol-restautant-menu')),

            array('field'=>'pisol_restaurant_hides_cart', 'label'=>__('Enable Option to show / hide cart','pisol-restaurant-menu'), 'type'=>'select', 'value'=>array('disable'=>__('Disabled','pisol-restautant-menu'), 'enable_cart_open'=>__('Enable hide cart option and keep the cart open on page load','pisol-restautant-menu'), 'enable_cart_close'=>__('Enable hide cart option and hide the cart on page load','pisol-restautant-menu') ),'default'=> 'enable_cart_open','pro'=>true),

            array('field'=>'pisol_hide_empty_cat', 'pro'=>true, 'label'=>__('Hide Empty Categories','pisol-restautant-menu'), 'type'=>'switch', 'value'=>array(false =>__('No','pisol-restautant-menu'), true =>__('Yes','pisol-restautant-menu')), 'default'=> false), 
           
            array('field'=>'pisol_hide_cat','pro'=>true,'desc'=>__('Press CTR and click on category to select multiple category, Select the categoris that you will like to hide on front end, Not to select the category that you have selected above as default category','pisol-restautant-menu','pisol-restautant-menu'), 'label'=>__('Hide this Categories','pisol-restautant-menu'), 'type'=>'multiselect', 'value'=>$this->cat_array),
           
            array('field'=>'pisol_default_cat','pro'=>true, 'label'=>__('Default Category','pisol-restautant-menu'), 'type'=>'select', 'value'=>$this->cat_array),

            array('field'=>'pisol_product_redirect','pro'=>true, 'label'=>__('Redirect Simple product to menu page','pisol-restautant-menu'), 'type'=>'switch', 'value'=>array(false =>__('No','pisol-restautant-menu'), true =>__('Yes','pisol-restautant-menu')), 'default'=> true),

            array('field'=>'pisol_category_redirect','pro'=>true, 'label'=>__('Redirect Category page to menu page','pisol-restautant-menu'), 'type'=>'switch', 'value'=>array(false =>__('No','pisol-restautant-menu'), true =>__('Yes','pisol-restautant-menu')), 'default'=> true),

            array('field'=>'pisol_shop_redirect','pro'=>true, 'label'=>__('Redirect Shop page to menu page','pisol-restautant-menu'), 'type'=>'switch', 'value'=>array(false =>__('No','pisol-restautant-menu'), true =>__('Yes','pisol-restautant-menu')), 'default'=> true),
            
            array('field'=>'pisol_show_image','pro'=>true, 'label'=>__('Show Image','pisol-restautant-menu'), 'type'=>'switch', 'value'=>array(false =>__('No','pisol-restautant-menu'), true =>__('Yes','pisol-restautant-menu')), 'default'=> false),
            
            array('field'=>'pisol_herarchy_image','pro'=>true, 'label'=>__('Show Image from parent category, if product dont have image','pisol-restautant-menu'), 'type'=>'switch', 'value'=>array(false =>__('No','pisol-restautant-menu'), true =>__('Yes','pisol-restautant-menu')), 'default'=> false),
            
            array('field'=>'pisol_short_desc','pro'=>true, 'label'=>__('Show short description below product','pisol-restautant-menu'), 'type'=>'switch', 'value'=>array(false =>__('No','pisol-restautant-menu'), true =>__('Yes','pisol-restautant-menu')), 'default'=> false, 'desc'=>__('You can show short description below the product name, try to keep this short','pisol-restautant-menu')),

            array('field'=>'pisol_product_popup','pro'=>true, 'label'=>__('Show product description in popup','pisol-restautant-menu'), 'type'=>'switch', 'value'=>array(false =>__('No','pisol-restautant-menu'), true =>__('Yes','pisol-restautant-menu')), 'default'=> false),

            array('field'=>'pisol_rest_animation','pro'=>true, 'label'=>__('Message opening animation','pisol-restautant-menu'),'type'=>'select', 'default'=>'fadeIn', 'value'=>$this->animation,  'desc'=>__('This animation is used when sales notification message opens','pisol-restautant-menu')),

            array('field'=>'pisol_hide_out_of_stock', 'label'=>__('Hide out of stock item','pisol-restautant-menu'),'type'=>'switch', 'default'=>0, 'desc'=>__('Once this is enabled it will hide the product that are out of stock','pisol-restautant-menu'), 'pro'=>true),

            array('field'=>'pisol_load_variable', 'pro'=>true, 'label'=>__('Load variable product in menu','pisol-restautant-menu'), 'desc'=>__('It will show the variable product in the menu, and user can add that product to cart by going to its single product page','pisol-restautant-menu'), 'type'=>'switch', 'value'=>array(0=>__('No','pisol-restautant-menu'), 1=>__('Yes','pisol-restautant-menu')), 'default'=>0), 
           
           
    );
        

        if($this->this_tab == $this->active_tab){
            add_action('pisol_restaurant_menu_tab_content', array($this,'tab_content'),10);
           
            
        }

        add_action('pisol_restaurant_menu_tab', array($this,'tab'),3);
        
    }

    function creatingArray($arrays){
        $return = array();
        foreach($arrays as $array){
            $return[$array] = $array;
        }
        return $return;
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
       <div>
        <?php
            foreach($this->settings as $setting){
                new pisol_class_form($setting);
            }
        ?>
        </div>
            <div>
            <div>
                    <a class="btn btn-primary btn-lg my-3" href="<?php echo PISOL_RESTAURANT_MENU_BUY_URL; ?>" target="_blank">Click to Buy Now</a>
            </div>
            </div>
       <?php
    }

    
}



