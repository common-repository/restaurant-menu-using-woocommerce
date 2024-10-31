<?php

class pisol_restaurant_menu_speed{

    private $setting = array();

    private $active_tab;

    private $this_tab = 'speed';

    private $tab_name = "Speed setting";

    private $setting_key = 'pisol_restaurant_speed_setting';

    function __construct(){


        $this->active_tab = (isset($_GET['tab'])) ? sanitize_text_field($_GET['tab']) : 'default';
        
        $this->settings = array(
           

            array('field'=>'pisol_rm_enable_caching', 'label'=>__('Enable server caching','pisol-restautant-menu'),'type'=>'switch', 'default'=>'0','desc'=>__('this will cache category page on server to speed up the browsing','pisol-restautant-menu')),

            array('field'=>'pisol_rm_cache_expiry', 'label'=>__('Server Cache expiry in minutes','pisol-restautant-menu'),'type'=>'number', 'default'=>30,'desc'=>__('How long the server cached will be used, ','pisol-restautant-menu'), 'min'=>10, 'step'=>1),

            array('field'=>'pisol_rm_browser_caching', 'label'=>__('Enable browser caching','pisol-restautant-menu'),'type'=>'switch', 'default'=>'0','desc'=>__('this will cache the category product on user browser ','pisol-restautant-menu')),
            

        );
        

        if($this->this_tab == $this->active_tab){
            add_action('pisol_restaurant_menu_tab_content', array($this,'tab_content'),10);
        }

        add_action('pisol_restaurant_menu_tab', array($this,'tab'),3);
        
        if(isset($_GET['delete_cache']) && isset($_GET['page']) && $_GET['page'] == 'pisol-restaurant-menu'){
            $this->clearCache();
        }

        $this->register_settings();

        //$this->delete_settings();
        
    }

    function clearCache(){
        global $wpdb;
        $sql = 'DELETE FROM '.$wpdb->prefix.'options WHERE option_name LIKE ("%_transient_pisol_rm_cache_%");';
        $wpdb->query($sql);
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
        $caching_enabled = get_option('pisol_rm_enable_caching', 0);
        ?>
        <a class="fon-weight-bold px-3 text-light d-flex align-items-center border-left border-right <?php echo $this->active_tab == $this->this_tab || '' ? 'bg-primary' : 'bg-secondary'; ?>" href="<?php echo admin_url( 'admin.php?page='.$_GET['page'].'&tab='.$this->this_tab ); ?>">
            <?php _e( $this->tab_name, 'pisol-dtt' ); ?> 
        </a>
        
        <a class="fon-weight-bold px-3 text-light d-flex align-items-center border-left border-right bg-primary" href="<?php echo admin_url( 'admin.php?page='.$_GET['page'].'&tab='.$this->this_tab.'&delete_cache=true' ); ?>">
            <?php _e( 'Delete cache', 'pisol-dtt' ); ?> 
        </a>
        
        <?php
    }

    function tab_content(){
        ?>
        <div class="alert alert-warning my-3">
       Disable the Server and Browser cache to see your changes on the front end, If this options are not disabled then it will not show your changes on the front end immediately
        </div>
        <div class="alert alert-info my-3">
       <strong>Make sure to Delete cache after making changes in the <u>Product</u>, <u>Categories</u>, or in this <u>Plugin settings</u></strong>
        </div>
        <form method="post" action="options.php"  class="pisol-setting-form">
        <?php settings_fields( $this->setting_key ); ?>
        <?php
           $count = count($this->settings);
            for($i = 0; $i < $count; $i++){
                new pisol_class_form($this->settings[$i], $this->setting_key);
            }
            
        ?>
        <input type="submit" name="submit" id="submit" class="btn btn-primary btn-md my-3" value="<?php echo __('Save Changes','pisol-dtt'); ?>">
        </form>
        <?php
    }

}

new pisol_restaurant_menu_speed();

