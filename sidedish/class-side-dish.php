<?php

class pisol_restaurant_side_dish_template{
    function __construct(){
        $this->post_type = 'pisol_side_dishes';

        add_action( 'init', array($this, 'createType') );
        add_action( 'add_meta_boxes_'.$this->post_type, array($this,'register_metabox') ); 
        add_action( 'save_post_'.$this->post_type,  array($this,'save' ),10,2);
    }

    function register_metabox(){  
        add_meta_box(
            'pisol-sidedish',
            __( 'Side Dishes', 'pisol-restautant-menu' ),
            array($this,'metabox_callback'),
            null,
            'advanced',
            'high',
            null
        );
    }

    function metabox_callback($post){
        $values = get_post_meta( $post->ID, 'pisol_sidedishes',true );
        $min_limit = apply_filters('pisol_enable_min_limit',false);
        wp_enqueue_script( 'sidedish', PISOL_RESTAURANT_MENU_URL.'admin/view/js/sidedish.js', array('jquery'));
        wp_enqueue_style( 'sidedish', PISOL_RESTAURANT_MENU_URL.'admin/view/css/sidedish.css');
        wp_localize_script( 'sidedish', 'pi_restaurant', array('is_pro'=>$min_limit) );
        ?>
        <div class="show_if_simple">
        <button class="button show_if_simple" id="pisol_add_side_dish_group">Add Side Dish Group</button>
        
            <?php 
            if(isset($values) && $values != "null"){
                
                $this->meta_values = json_decode($values);
                //print_r($this->meta_values);
                $this->side_dish_groups(); 
                
            }else{
                echo '<div id="pisol_sidedish_group_container" data-group-counter="0" ></div>';
            }
            ?>
        </div>
        <?php
    }

    function side_dish_groups(){

        $group_counter = 0;
        echo '<div id="pisol_sidedish_group_container" data-group-counter="'.(isset($this->meta_values) ? count((array)$this->meta_values) : 0).'">';
        if($this->meta_values != ""):
        foreach($this->meta_values as $side_dish_group){
            $side_dishes = isset($side_dish_group->sidedish) ? sizeof($side_dish_group->sidedish) : 0 ;
            echo '<div class="sidedish_group" data-groupid="'.$group_counter.'" data-sidedishes="'.$side_dishes.'">';
                    $this->side_dish_group_inner($group_counter, $side_dish_group);
            echo '</div>';
            $group_counter++;
        }
        endif;
        echo '</div>';
    }

    function side_dish_group_inner($group_counter, $side_dish_group){
        $min_limit = apply_filters('pisol_enable_min_limit',false);
        echo '<table class="sidedish-table">
        <tr>
            <td style="vertical-align:bottom;">
                <p class="form-field" style="margin-bottom:0px;">Side Dish Group Name:<input required type="text" name="sidedish['.$group_counter.'][group_name]" placeholder="Side Dish Group Name *" value="'.$side_dish_group->group_name.'"></p>
            </td>
            <td style="vertical-align:bottom;"> 
                <button class="button pisol_add_side_dish">Add Side Dish</button> <button class="button remove_sidedish_group">Remove Side Dish Group</button>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="side_dish_container">';

                $this->side_dishes($group_counter, $side_dish_group);

        echo '  </div>
            </td>
        <tr>
            <td>
            Max Selectable: <input type="number" min="1" required value="'.$side_dish_group->max.'" name="sidedish['.$group_counter.'][max]" placeholder="Maximum number of dish that can be selected">
            </td>
            <td>
            Min Selectable: '.(!$min_limit ? '(Buy PRO version for this)' : '').' <input type="number" min="0" required value="'.(isset($side_dish_group->min) ? $side_dish_group->min : 0).'" name="sidedish['.$group_counter.'][min]" 
            '.($min_limit ? 
            'placeholder="Minimum number of dish that has to be selected"' :
            'placeholder="(BUY PRO VERSION FOR THIS)" disabled').'
            >
            </td>
        </tr>
        </table>';

    }

    function side_dishes($group_counter, $side_dish_group){
        $counter = 0;
        if(isset($side_dish_group->sidedish)):
            foreach($side_dish_group->sidedish as $side_dishes){
                echo '<div class="sidedish_row">
                <input type="text" required value="'.$side_dishes->name.'" name="sidedish['.$group_counter.'][sidedish]['.$counter.'][name]" placeholder="Side Dish Name*">
                <input type="number" step="0.01"  value="'.$side_dishes->price.'"  name="sidedish['.$group_counter.'][sidedish]['.$counter.'][price]" placeholder="Side Dish Price">
                <button class="button button-primary remove_sidedish">Remove</button>
                </div>';
                $counter++;
            }
        endif;
    }

    function save($post_id){
        // Bail if we're doing an auto save
         if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
         
         if(isset($_POST['woocommerce_quick_edit_nonce'])){
 
             if (wp_verify_nonce($_POST['woocommerce_quick_edit_nonce'], 'woocommerce_quick_edit_nonce')){
                 return;
             }
         }
 
         if(!isset($_POST['sidedish'])){
             delete_post_meta( $post_id,'pisol_sidedishes');
             return ;
         } 
 
         
         
 
         $one_step = wp_unslash(array_values($_POST['sidedish']));
         $sd_input = $this->recursive_sanitize_text_field($one_step);
         $before_final = $this->remove_empty($sd_input);
         $final = json_encode($before_final, JSON_UNESCAPED_UNICODE);
         update_post_meta( $post_id,'pisol_sidedishes', $final);
         
     }

     function recursive_sanitize_text_field($array) {

        foreach ( $array as $key => &$value ) {
            if ( is_array( $value ) ) {
                $value = $this->recursive_sanitize_text_field($value);
            }
            else {
                $value = filter_var( $value ,  FILTER_SANITIZE_STRING  );
            }
        }

        return $array;
    }

    function remove_empty($sidedishes_groups){
        $count = 0;
        
        foreach($sidedishes_groups as $key => $sd_group){

            

            /* If maximum is not set , set it to one */
            if($sd_group['max'] <= 0 || $sd_group['max'] == ""){
                $sidedishes_groups[$key]['max'] = 1 ;
            }
            
            /* This remove a side dish group if there is no group name in it */
            if($sd_group['group_name'] == ""){
               unset($sidedishes_groups[$key]);
            }
            $count2 = 0;
            /* This remove sidedish if there is not name in it */
            if(isset($sd_group['sidedish'])){
            foreach($sd_group['sidedish'] as $sidedish_key => $sidedish){
                $sidedishes_groups[$key]['sidedish'][$sidedish_key]['hash'] = md5($sidedish['name'].$count.$count2);
                if($sidedish['name'] == ""){
                    unset($sidedishes_groups[$key]['sidedish'][$sidedish_key]);
                }

                $count2++;
            }
            }

            /* This removes the group if it does not have any side dish in it */
            if(!isset($sd_group['sidedish']) || sizeof($sidedishes_groups[$key]['sidedish']) <= 0){
                unset($sidedishes_groups[$key]);
            }

            $count++;

        }
        

        return $sidedishes_groups;
    }

    function createType(){
        register_post_type( $this->post_type,
          array(
            'labels' => array(
              'name' => __( 'Side dish template' ),
              'singular_name' => __( 'Side dish template' ),
              'add_new_item' =>__('Side dish  template')
            ),
            'public' => false,
            'exclude_from_search' => false,
            'publicaly_queryable' => true,
            'show_ui'=>true,
            'rewrite'=>false,
            'show_in_nav_menus' => false,
            'query_var' => false,
            'has_archive' => false,
            'supports'=>array('title'),
            'menu_icon'=>plugin_dir_url(__FILE__).'img/pi.svg',
            /** this hides add post option */
            'capability_type' => 'post',
          )
        );
    }

    
}
new pisol_restaurant_side_dish_template();