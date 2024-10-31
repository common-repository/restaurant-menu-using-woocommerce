<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class pisol_admin{

    private $active_tab = 'display'; 

    private $settings = array();

    private $cat_array = array();

    function __construct() {
        
        
        add_filter( 'plugin_row_meta', array($this,'register_plugins_links'), 10, 2);
        add_action( 'admin_menu', array($this,'plugin_menu') );
        
        if(!is_plugin_active( 'pisol-restaurant-menu-pro/pisol_restaurant_menu_pro.php')){
        add_action('pisol_restaurant_menu_tab_msg', array($this,'promotion_msg'),10);
        }
        
    }

   

   
    /* 
        Add a important link to product description, like setting page,
        Pro version buy link, Documentation link 
    */
    function register_plugins_links ($links, $file) {

        if ($file == PISOL_RESTAURANT_MENU_BASE) {
                $links[] = '<a href="https://woo-restaurant.com/">' . __('Documentation','pisol-restautant-menu') . '</a>';
                $links[] = '<a href="http://www.piwebsolution.com/product/restaurant-menu-using-woocommerce/">' . __('Buy Pro','pisol-restautant-menu') . '</a>';
        }

        return $links;
    }



    /* 
        Reguister admin menu 
    */
    function plugin_menu(){
        
        $menu = add_submenu_page('woocommerce', __('Restaurant Menu Setting','pisol-restautant-menu'), __('Restaurant Menu','pisol-restautant-menu'), 'manage_options', 'pisol-restaurant-menu',  array($this, 'restaurant_menu_option_page')  );

        add_action( 'load-' . $menu, array($this,'enqueue_style') );
    }

    /* 
        Restaurant menu setting page 
    */
    function restaurant_menu_option_page(){
        if(function_exists('settings_errors')){
            settings_errors();
        }
        ?>
        <div class="bootstrap-wrapper">
        <div class="container mt-2">
            <div class="row">
                    <div class="col-12">
                        <div class='bg-dark'>
                        <div class="row">
                            <div class="col-12 col-sm-2 py-2">
                            <a href="https://www.piwebsolution.com/" target="_blank"><img class="img-fluid ml-2" src="<?php echo PISOL_RESTAURANT_MENU_URL; ?>admin/view/img/pi-web-solution.svg"></a>
                            </div>
                            <div class="col-12 col-sm-10 d-flex text-center small">
                                <?php do_action('pisol_restaurant_menu_tab'); ?>
                                <a class=" mr-0 ml-auto fon-weight-bold px-3 text-light d-flex align-items-center bg-primary border-left border-right" target="_blank" href="https://woo-restaurant.com/category/restaurant-menu-documentation/">
            Documentation 
        </a>
                            </div>
                        </div>
                        </div>
                    </div>
            </div>
            <div class="row">
                <div class="col-12">
                <div class="bg-light border p-3">
                    <div class="row">
                        <div class="col">
                        <?php do_action('pisol_restaurant_menu_tab_content'); ?>
                        </div>
                        <?php do_action('pisol_restaurant_menu_tab_msg'); ?>
                    </div>
                </div>
                </div>
            </div>
        </div>
        </div>
        <?php
    }


    /*
        Link style sheet to admin part
    */
    function enqueue_style(){
        wp_enqueue_style( 'pisol_admin_bootstrap', PISOL_RESTAURANT_MENU_URL.'admin/view/css/bootstrap.css',array(),'4.6.7');
        //wp_enqueue_style( 'pisol_admin_style', PISOL_RESTAURANT_MENU_URL.'admin/view/css/style.css');
    }

    function promotion_msg(){
        ?>
        <div class="col-12 col-sm-4">
            <div class="bg-dark text-light text-center mb-3">
                    <a href="<?php echo PISOL_RESTAURANT_MENU_BUY_URL; ?>" target="_blank">
                        <?php  new pisol_promotion("pi_restaurant_menu_installation_date"); ?>
                    </a>
            </div>
           <div class="bg-primary p-3 text-light text-center mb-3 promotion-bg">
                <h2 class="text-light font-weight-light "><span>Get Pro for <h2 class="h2 font-weight-bold my-2 text-light"><?php echo PISOL_RESTAURANT_MENU_PRICE; ?></h2></span></h2>
                <a class="btn btn-danger btn-md mb-2 text-uppercase" href="<?php echo  PISOL_RESTAURANT_MENU_BUY_URL; ?>" target="_blank">Buy Now !!</a>
                <div class="inside">
                    PRO version unlocks all customization options<br><br>
                    <ul class="text-left  h6 font-weight-light">
                    <li class="border-top py-2 h6 font-weight-light"><strong class="text-primary">Set Min item limit</strong> for each side dish group, User wont be able to add product to cart until he select minimum items</li>
                    <li class="border-top py-2 h6 font-weight-light"><strong class="text-primary">Set Min item limit</strong> for each side dish group</li>
                    <li class="border-top py-2 h6 font-weight-light"><strong class="text-primary">Set extra charges</strong> for each side dish item, that will be added to the cost of main product</li>
                    <li class="border-top py-2 h6 font-weight-light"><strong class="text-primary">Hide empty category</strong> from menu</li>
                    <li class="border-top py-2 h6 font-weight-light"><strong class="text-primary">Hide particular category</strong> from appearing in menu </li>
                    <li class="border-top py-2 h6 font-weight-light">Set a <strong class="text-primary">Default category</strong>, that will be the landing category on menu</li>
                    <li class="border-top border-top py-2 h6 font-weight-light"><strong class="text-primary">Hide or Show</strong> product image</li>
                    <li class="border-top border-top py-2 h6 font-weight-light">Show dish <strong class="text-primary">description in popup</strong></li>
                    <li class="border-top border-top py-2 h6 font-weight-light">Hide cart so user will have more space to see the products</li>
                    <li class="border-top border-top py-2 h6 font-weight-light text-center"><strong class="text-primary">..... More</strong></li>
                    </ul>
                    <a class="btn btn-light" href="<?php echo  PISOL_RESTAURANT_MENU_BUY_URL; ?>" target="_blank">Click to Buy Now</a>
                </div>
            </div>
        </div>
        
        <?php
    }

}

new pisol_admin();


