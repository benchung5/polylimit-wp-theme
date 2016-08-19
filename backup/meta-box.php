<?php

// Add the Meta Box
function onepix_add_custom_meta_box() {
    add_meta_box(
		'onepix_meta_box', // $id
		'1 Pixel Page Options', // $title 
		'onepix_show_custom_meta_box', // $callback
		'page', // $page
		'normal', // $context
		'high'); // $priority
}
add_action('add_meta_boxes', 'onepix_add_custom_meta_box');


// Field Array
$prefix = 'onepix_';
$onepix_meta_fields = array(
        array(
		'label'=> 'Use Page Intro',
		'desc'	=> 'togle use of page intro block.',
		'id'	=> $prefix.'has_page_intro',
		'type'	=> 'checkbox'
	),
        array(
		'label'=> 'Primary Page Intro Text',
		'desc'	=> 'The text for the page heading.',
		'id'	=> $prefix.'primary_intro',
		'type'	=> 'text'
	),
        array(
		'label'=> 'Secondary Page Intro Text',
		'desc'	=> 'The secondary page heading text.',
		'id'	=> $prefix.'secondary_intro',
		'type'	=> 'text'
	),
        array(
		'label'=> 'Page Featured Image URL',
		'desc'	=> 'URL for the featured image (if "page specific" is selected in theme settings) .',
		'id'	=> $prefix.'custom_img_url_input',
		'type'	=> 'text'
	)
//	array(
//		'label'=> 'Text Input',
//		'desc'	=> 'A description for the field.',
//		'id'	=> $prefix.'text',
//		'type'	=> 'text'
//	),
//	array(
//		'label'=> 'Textarea',
//		'desc'	=> 'A description for the field.',
//		'id'	=> $prefix.'textarea',
//		'type'	=> 'textarea'
//	),
//	array(
//		'label'=> 'Checkbox Input',
//		'desc'	=> 'A description for the field.',
//		'id'	=> $prefix.'checkbox',
//		'type'	=> 'checkbox'
//	),
//	array(
//		'label'=> 'Select Box',
//		'desc'	=> 'A description for the field.',
//		'id'	=> $prefix.'select',
//		'type'	=> 'select',
//		'options' => array (
//			'one' => array (
//				'label' => 'Option One',
//				'value'	=> 'one'
//			),
//			'two' => array (
//				'label' => 'Option Two',
//				'value'	=> 'two'
//			),
//			'three' => array (
//				'label' => 'Option Three',
//				'value'	=> 'three'
//			)
//		)
//	)
);

// The Callback
function onepix_show_custom_meta_box() {
global $onepix_meta_fields, $post;
// Use nonce for verification
echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
	
	// Begin the field table and loop
	echo '<table class="form-table">';
	foreach ($onepix_meta_fields as $field) {
		// get value of this field if it exists for this post
		$meta = get_post_meta($post->ID, $field['id'], true);
		// begin a table row with
		echo '<tr>
				<th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
				<td>';
				switch($field['type']) {
                                    
                                    // text
                                    case 'text':
                                            echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" style="width:100%" />
                                                    <br /><span class="description">'.$field['desc'].'</span>';
                                    break;
                                
                                    // checkbox
                                    case 'checkbox':
                                            echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
                                                    <label for="'.$field['id'].'">'.$field['desc'].'</label>';
                                    break;
                                
                                    // select
                                    case 'select':
                                            echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
                                            foreach ($field['options'] as $option) {
                                                    echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
                                            }
                                            echo '</select><br /><span class="description">'.$field['desc'].'</span>';
                                    break;
                                    
                                    
                                    

				} //end switch
		echo '</td></tr>';
	} // end foreach
	echo '</table>'; // end table
}



// Save the Data
function onepix_save_custom_meta($post_id) {
    global $onepix_meta_fields;
	
	// verify nonce
	if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__))) 
		return $post_id;
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;
	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id))
			return $post_id;
		} elseif (!current_user_can('edit_post', $post_id)) {
			return $post_id;
	}
	
	// loop through fields and save the data
	foreach ($onepix_meta_fields as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	} // end foreach
}
add_action('save_post', 'onepix_save_custom_meta');  
  




?>
