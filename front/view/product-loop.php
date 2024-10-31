<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
?>

<?php
    if(isset($cat)){
        $search_result = false;
    }else{
        $search_result = true;
    }

    $colspan = get_option('pisol_rm_show_food_type','hide') == 'show' ? 2 : 1;
?>
<table class="pisol_table">
    <thead>
            <?php if($show_image): ?>
            <th class="pisol_img"></th>
            <?php endif; ?>
            <th class="pisol_name" colspan="<?php echo esc_attr($colspan); ?>"><?php esc_html_e( 'Product', 'pisol-restautant-menu' );  ?><?php do_action('pisol_product_filter'); ?></th>
            <th class="pisol_price"><?php _e('Price/Unit', 'pisol-restautant-menu'); ?></th>
            <th class="pisol_action"></th>
    </thead>
    <tbody>
    <?php
        if ($loop->have_posts()){
            $currency_position = get_option("woocommerce_currency_pos","left");
            while ($loop->have_posts()) : $loop->the_post();
            
                $product = wc_get_product( $loop->get_the_ID() );

                if(!apply_filters('woocommerce_product_is_visible', true, $loop->get_the_ID())) continue;

                if(apply_filters('pisol_hide_out_of_stock',false)){
                    if(!$product->is_in_stock()) continue;

                    $manage_stock =  $product->managing_stock();

                    if($manage_stock){
                        $stock = $product->get_stock_quantity();

                        if(!($stock > 0)) continue;
                    }
                }

                if($search_result){
                    $categories = $product->get_category_ids();
                    $cat = $categories[0];
                }

                $customize_btn = $this->customizeButton($product);

                $hide_product_link = apply_filters('pisol_rm_pro_pisol_product_redirect', true );
                $show_product_popup = apply_filters('pisol_rm_pro_pisol_product_popup',false);
                if($hide_product_link || $show_product_popup){
                    $link = 'href="javascript:void(0);"';
                }else{
                    $link = 'href="'.$product->get_permalink().'"';
                }

                echo '<tr id="product_'.$product->get_id().'_'.$cat.'" class="product_row '.$this->food_type_class($product->get_id(), true).' child_category_selector_'.$cat.'" data-cat="'.$cat.'"  data-product="'.$product->get_id().'">';
                
                $this->pisol_product_image($product, $cat);

                    echo '<td>';
                    echo '<div class="product_name"><a '.$link.'  data-id="'.$product->get_id().'">'.$product->get_name().'</a>';
                    if(get_option('pisol_rm_show_food_type','hide') == 'below_product_name'):
                        echo pisol_products::get_food_type($product->get_id());
                    endif;
                    echo '</div>'.$customize_btn;
                    if($product->get_short_description() != "" && apply_filters('pisol_rm_pro_pisol_short_desc',false)):
                    echo '<small class="pisol-short-desc">'.$product->get_short_description().'</small>'; 
                    endif;                  
                    echo '<ul class="added_sidedishes"></ul>';
                    echo '</td>';
                    if(get_option('pisol_rm_show_food_type','hide') == 'show'):
                    echo '<td  class="pi-food-type">';
                    echo pisol_products::get_food_type($product->get_id());
                    echo '</td>';
                    endif;
                    echo '<td>';
                    self::price($product);
                    if($product->is_type('simple')){
                        
                        echo '<div class="quantity"><input type="number" id="quantity_5b3b76e828c6d" class="input-text qty text" step="1" min="1" max="" name="quantity" value="1" title="Qty" size="4" pattern="[0-9]*" inputmode="numeric" aria-labelledby=""></div>';
                    }
                    echo '</td>';
                    echo '<td>';
                    echo pisol_products::addToCartLink($product, $cat);
                    echo '</td>';
               echo '</tr>';
               if($product->is_type('simple')){
               echo '<tr data-cat="'.$cat.'" data-product="'.$product->get_id().'" class="pisol_sidedish_row '.$this->food_type_class($product->get_id(), true).' child_category_selector_'.$cat.'" id="pisol_sidedish_row_'.$product->get_id().'_'.$cat.'">';
               echo '<td colspan="'.$columns.'">';
                  $this->get_sidedishes($product->get_id(), $cat);
               echo '</td>';
               echo '</tr>';
               }
            endwhile; 
            $this->pisol_get_child_cat_products($cat);
        }else{
            /* 
            This make sure if the parent category dont have product 
            even then child category can be shown
            */
            $this->pisol_get_child_cat_products($cat);
        }
    ?>
    </tbody>
</table>