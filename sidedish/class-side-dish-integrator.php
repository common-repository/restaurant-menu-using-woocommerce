<?php

class pisol_restaturant_side_dish_integrate{
    function __construct(){
        $this->post_type = 'product';
        add_action( 'add_meta_boxes_'.$this->post_type, array($this,'register_metabox') ); 
        add_action( 'add_meta_boxes_pisol_side_dishes', array($this,'register_metabox') ); 
    }

    function register_metabox(){  
        add_meta_box(
            'pisol-sidedish-template',
            __( 'Side Dishes Template', 'pisol-restautant-menu' ),
            array($this,'metabox_callback'),
            null,
            'side',
            'low',
            null
        );
    }

    function metabox_callback($post){
        $posts = $this->getTemplatesPosts();
        $this->createButton($posts);
    }

    function createButton($posts){
        echo '<div class="show_if_simple">';
        foreach((array)$posts as $id => $post){
            echo '<a href="javascript:void(0);" class="button add-side-dish-template" data-template="'.esc_attr(wp_json_encode($post['template'], ENT_QUOTES)).'">'.$post['title'].'</a>';
        }
        echo '</div>';
    }

    function getTemplatesPosts(){
        $args = array( 
            'numberposts'		=> -1, 
            'post_type'		=> 'pisol_side_dishes', 
            'orderby' 		=> 'title', 
            'order' 		=> 'ASC', 
          );
        $posts = get_posts($args);
        $data = array();
        foreach($posts as $post){
            $template = get_post_meta($post->ID, 'pisol_sidedishes', true);
            if(!empty($template)){
            $data[$post->ID] = array(
                'title' => $post->post_title,
                'template' => $template
            );
            }
        }
        return $data;
    }
}

new pisol_restaturant_side_dish_integrate();