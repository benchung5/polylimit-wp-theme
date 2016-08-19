<?php

// Create Custom Slider Post Type --------------------------------------------------/
     
    function register_slides_posttype() {
        $labels = array(
            'name'              => _x( 'Slides', 'post type general name' ),
            'singular_name'     => _x( 'Slide', 'post type singular name' ),
            'add_new'           => __( 'Add New Slide' ),
            'add_new_item'      => __( 'Add New Slide' ),
            'edit_item'         => __( 'Edit Slide' ),
            'new_item'          => __( 'New Slide' ),
            'view_item'         => __( 'View Slide' ),
            'search_items'      => __( 'Search Slides' ),
            'not_found'         => __( 'Slide' ),
            'not_found_in_trash'=> __( 'Slide' ),
            'parent_item_colon' => __( 'Slide' ),
            'menu_name'         => __( 'Slides' )
        );
 
        $taxonomies = array();
 
        $supports = array('title','thumbnail');
 
        $post_type_args = array(
            'labels'            => $labels,
            'singular_label'    => __('Slide'),
            'public'            => true,
            'show_ui'           => true,
            'publicly_queryable'=> true,
            'query_var'         => true,
            'capability_type'   => 'post',
            'has_archive'       => false,
            'hierarchical'      => false,
            'rewrite'           => array( 'slug' => 'slides', 'with_front' => false ),
            'supports'          => $supports,
            'menu_position'     => 6, // Where it is in the menu. Change to 6 and it's below posts. 11 and it's below media, etc.
            'menu_icon'         => get_template_directory_uri() . '/inc/slider/images/icon.png',
            'taxonomies'        => $taxonomies
        );
        register_post_type('slides',$post_type_args);
    }
    add_action('init', 'register_slides_posttype');
    
    
    
    
// Meta Box for Slider URL --------------------------------------------------/


$fields  = onepix_slider_fields();  
    

function onepix_slider_fields() { 
//    $slidelink_2_metabox =
    $options[] =  array(
        'id' => 'slidelink',
        'title' => 'Slide Link',
        'page' => array('slides'),
        'context' => 'normal',
        'priority' => 'default',
        'fields' => array(
                        array(
                            'name'          => 'Link URL',
                            'desc'          => '',
                            'id'                => 'onepix_slideurl',
                            'class'             => 'onepix_slideurl',
                            'type'          => 'text',
                            'rich_editor'   => 0,           
                            'max'           => 0            
                        ),
                    )
    );
    
    return $options;
    
    }
    

                 
    add_action('admin_menu', 'onepix_add_slidelink_2_meta_box');
    function onepix_add_slidelink_2_meta_box() {
     
        global $fields;
        
            if (!empty($fields)) {
 
                foreach ($fields as $field) {
                        foreach ($field['page'] as $page) {
                        add_meta_box($slidelink_2_metabox['id'], $field['title'], 'onepix_show_slidelink_2_box', $page, 'normal', 'default', $field);
                    }
                }
            }

    }
    
    
//             if (!empty($fields)) {
// 
//                foreach ($fields as $field) {
//
//                    }
//                }

     
    // function to show meta boxes
    function onepix_show_slidelink_2_box()  {
        global $post;
        global $fields;
        global $onepix_prefix;
        global $wp_version;
         
        // Use nonce for verification
        echo '<input type="hidden" name="onepix_slidelink_2_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
         
        echo '<table class="form-table">';
     
        if (!empty($fields)) {

        foreach ($fields as $field) {
            
                    foreach ($field['fields'] as $field) {
                    // get current post meta data

                    $meta = get_post_meta($post->ID, $field['id'], true);

                    echo '<tr>',
                    '<th style="width:20%"><label for="', $field['id'], '">', stripslashes($field['name']), '</label></th>',
                    '<td class="onepix_field_type_' . str_replace(' ', '_', $field['type']) . '">';
                    switch ($field['type']) {
                        case 'text':
                            echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" /><br/>', '', stripslashes($field['desc']);
                            break;
                    }
                    echo '<td>',
                    '</tr>';
                }
            
            }
        }
        

         
        echo '</table>';
    }  
     
    // Save data from meta box
    add_action('save_post', 'onepix_slidelink_2_save');
    function onepix_slidelink_2_save($post_id) {
        global $post;
        global $slidelink_2_metabox;
         
        // verify nonce
        if (!wp_verify_nonce($_POST['onepix_slidelink_2_meta_box_nonce'], basename(__FILE__))) {
            return $post_id;
        }
     
        // check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }
     
        // check permissions
        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }
         
        foreach ($slidelink_2_metabox['fields'] as $field) {
         
            $old = get_post_meta($post_id, $field['id'], true);
            $new = $_POST[$field['id']];
             
            if ($new && $new != $old) {
                if($field['type'] == 'date') {
                    $new = onepix_format_date($new);
                    update_post_meta($post_id, $field['id'], $new);
                } else {
                    if(is_string($new)) {
                        $new = $new;
                    }
                    update_post_meta($post_id, $field['id'], $new);
                     
                     
                }
            } elseif ('' == $new && $old) {
                delete_post_meta($post_id, $field['id'], $old);
            }
        }
    }
    
    

?>
