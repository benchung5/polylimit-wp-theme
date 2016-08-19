<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
// Add the Page Meta Box
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

// Add the Post Meta Box
function onepix_add_custom_post_meta_box() {
    add_meta_box(
            'onepix_meta_box', // $id
            '1 Pixel Page Options', // $title 
            'onepix_show_custom_post_meta_box', // $callback
            'post', // $post
            'normal', // $context
            'high'); // $priority
}

add_action('add_meta_boxes', 'onepix_add_custom_post_meta_box');

$prefix = 'onepix_';

// Field Array (Pages Meta)
$onepix_meta_fields = array(
    array(
        'label' => 'Page Header Type',
        'desc' => 'Select the desired fullwidth page header type.',
        'id' => $prefix . 'page_header_type',
        'type' => 'select',
        'options' => array(
            'Plain' => array(
                'label' => 'Plain',
                'value' => 'plain'
            ),
            'Parallax' => array(
                'label' => 'Parallax',
                'value' => 'parallax'
            ),
            'Custom HTML' => array(
                'label' => 'Custom',
                'value' => 'custom'
            ),
        )
    ),
    array(
        'label' => 'Page Featured Image URL',
        'desc' => 'URL for the featured image (if "page specific" is selected in theme settings) .',
        'id' => $prefix . 'custom_img_url_input',
        'type' => 'img'
    ),
    array(
        'label' => 'Custom HTML (for Custom HTML header type)',
        'desc' => 'custom html/shortcodes inserted into page header',
        'id' => $prefix . 'custom_html',
        'type' => 'textarea'
    ),
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

// Field Array (Posts Meta)
$onepix_post_meta_fields = array(
    array(
        'label' => 'Featured Video Embed Code',
        'desc' => 'Paste your video code here to show a video instead of a featured image.',
        'id' => $prefix . 'video_embed',
        'type' => 'textarea'
    )
);

// The Callback for page meta box
function onepix_show_custom_meta_box() {
    global $onepix_meta_fields;
    onepix_show_page_meta_box($onepix_meta_fields);
}

// The Callback for post meta box
function onepix_show_custom_post_meta_box() {
    global $onepix_post_meta_fields;
    onepix_show_page_meta_box($onepix_post_meta_fields);
}

// The Callback
function onepix_show_page_meta_box($meta_fields) {

    global $post;
// Use nonce for verification
    echo '<input type="hidden" name="custom_meta_box_nonce" value="' . wp_create_nonce(basename(__FILE__)) . '" />';

    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($meta_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['id'], true);
        // begin a table row with
        echo '<tr>
                <th><label for="' . $field['id'] . '">' . $field['label'] . '</label></th>
                <td>';
        switch ($field['type']) {

            // text
            case 'text':
                echo '<input type="text" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . $meta . '" style="width:100%" />
                      <br /><span class="description">' . $field['desc'] . '</span>';
                break;

            // img url
            case 'img':
                echo '<input class="media-upload-input url-upload-input custom_media_url" type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : '', '" />';
                echo "<input type='button' data-input-id='", $field['id'], "' id='", $field['id'], "_button' value='Upload Image' class='button upload-media-btn' ><br/>", "", stripslashes($field['desc']);
                break;

            // textarea
            case 'textarea':
                echo '<textarea style="width:100%" rows="2" id="' . $field['id'] . '" name="' . $field['id'] . '">' . $meta . '</textarea>
                      <br /><span class="description">' . $field['desc'] . '</span>';
                break;

            // checkbox
            case 'checkbox':
                echo '<input type="checkbox" name="' . $field['id'] . '" id="' . $field['id'] . '" ', $meta ? ' checked="checked"' : '', ' value="1" />
                     <label for="' . $field['id'] . '">' . $field['desc'] . '</label>';
                break;

            // select
            case 'select':
                echo '<select name="' . $field['id'] . '" id="' . $field['id'] . '">';
                foreach ($field['options'] as $option) {
                    echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="' . $option['value'] . '">' . $option['label'] . '</option>';
                }
                echo '</select><br /><span class="description">' . $field['desc'] . '</span>';
                break;
        } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}

// Save the Data
function onepix_save_custom_meta($post_id) {
    global $onepix_meta_fields;
    global $onepix_post_meta_fields;

    // verify nonce
    if (isset($_POST['custom_meta_box_nonce'])) {
        $nonce = $_POST['custom_meta_box_nonce'];
    } else {
        $nonce = null;
    }
    if (!wp_verify_nonce($nonce, basename(__FILE__)))
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

    //either post or page fields we'll be working with
    $fields;

    // Check permissions (pages or posts)
    if ('page' == $_POST['post_type']) {
        $fields = $onepix_meta_fields;
    } else if ('post' == $_POST['post_type']) {
        $fields = $onepix_post_meta_fields;
    }
    
    // loop through fields and save the data
    foreach ($fields as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        if (isset($_POST[$field['id']])) {
            $new = $_POST[$field['id']];
        } else {
            $new = null;
        }
        
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    } // end foreach
}

add_action('save_post', 'onepix_save_custom_meta');
?>