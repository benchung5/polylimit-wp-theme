<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }
$onepix_option = get_option('onepix_options');

//initialize and register showcase post type
function onepix_init_showcase(){
    
    global $onepix_option;

    register_post_type('onepix_' . SHOWCASE_NAME, array(
        'labels' => array(
            'name' => __(SHOWCASE_NAME),
            'singular_name' => __(SHOWCASE_NAME)
        ),
        'public' => true,
        'publicly_queryable' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => SHOWCASE_NAME, 'with_front' => FALSE),
        'show_ui' => true,
        'query_var' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array(
            'title',
            'editor',
            'thumbnail'
        )
        )
    );
    
    //must do this to get permalinks working
    flush_rewrite_rules();
}

// Add showcase taxonomy
function onepix_add_showcase_taxonomy() {
    
    global $onepix_option;
    
    register_taxonomy(TAXONOMY_NAME . 's', 'onepix_' . SHOWCASE_NAME, array(
        // Hierarchical taxonomy (like categories)
        'hierarchical' => true,
        // This array of options controls the labels displayed in the WordPress Admin UI
        'labels' => array(
            'name' => _x(TAXONOMY_NAME . 's', 'taxonomy general name'),
            'singular_name' => _x(TAXONOMY_NAME, 'taxonomy singular name'),
            'search_items' => __('Search' . TAXONOMY_NAME . 's'),
            'all_items' => __('All' . TAXONOMY_NAME .'s'),
            'parent_item' => __('Parent ' . TAXONOMY_NAME),
            'parent_item_colon' => __('Parent ' . TAXONOMY_NAME . ':'),
            'edit_item' => __('Edit ' . TAXONOMY_NAME),
            'update_item' => __('Update ' . TAXONOMY_NAME),
            'add_new_item' => __('Add New ' . TAXONOMY_NAME),
            'new_item_name' => __('New ' . TAXONOMY_NAME . ' Name'),
            'menu_name' => __(TAXONOMY_NAME . 's'),
        ),
        'query_var' => true,
        //must not use pretty permalinks or 404 pages would happen for tax pages.
        'rewrite' => false
    ));
}

// Add taxonomy meta to term page
function onepix_taxonomy_add_meta_field() {
    
        global $onepix_option;
        // this will add the custom meta field to the add new term page
	?>
	<div class="form-field">
        <label for="term_meta_imgurl"><?php _e( TAXONOMY_NAME . ' Image URL', '1pixel' ); ?></label>
        <input type="text" name="term_meta[imgurl_term_meta]" id="term_meta_imgurl" value="">
        <input type='button' data-input-id='term_meta_imgurl' id='imgurl_term_meta_button' value='Upload Image' class='button upload-media-btn' >
        <p class="description"><?php _e( 'Enter the url for the image for this category','1pixel' ); ?></p>
	</div>
        <div class="form-field">
            <label for="term_meta[order_term_meta]"><?php _e(TAXONOMY_NAME . ' Display Order', '1pixel'); ?></label>
            <input type="text" name="term_meta[order_term_meta]" id="term_meta[order_term_meta]" value="">
            <p class="description"><?php _e('Enter a number for the display order for this category', '1pixel'); ?></p>
        </div>
    <?php
}
// when the taxonomy: "" gets added to the name of this action it automatically binds to that taxonomy page
add_action( 'skills_add_form_fields', 'onepix_taxonomy_add_meta_field', 10, 2 );
// Add taxonomy meta to edit term page
function onepix_taxonomy_edit_meta_field($term) {
 
	// put the term ID into a variable
	$t_id = $term->term_id;
 
	// retrieve the existing value(s) for this meta field. This returns an array
	$term_meta = get_option( "taxonomy_$t_id" ); ?>
	<tr class="form-field">
            <th scope="row" valign="top"><label for="term_meta[imgurl_term_meta]"><?php _e('Skill Image URL', '1pixel'); ?></label></th>
            <td>
                <input class="widefat media-upload-input custom_media_url" type="text" name="term_meta[imgurl_term_meta]" id="term_meta_imgurl" value="<?php echo esc_attr($term_meta['imgurl_term_meta']) ? esc_attr($term_meta['imgurl_term_meta']) : ''; ?>">
                <input class='button upload-media-btn' type='button' data-input-id='term_meta_imgurl' id='imgurl_term_meta_button' value='Upload Image' class='button upload-media-btn' >
                <p class="description"><?php _e('Enter the url for the image (545x545) for this category', '1pixel'); ?></p>
            </td>
       </tr>
       <tr class="form-field">
            <th scope="row" valign="top"><label for="term_meta[order_term_meta]"><?php _e('Skill Display Order', '1pixel'); ?></label></th>
            <td>
                <input maxlength="4" size="4" type="text" name="term_meta[order_term_meta]" id="term_meta[order_term_meta]" value="<?php echo esc_attr($term_meta['order_term_meta']) ? esc_attr($term_meta['order_term_meta']) : ''; ?>" style="width:auto;">
                <p class="description"><?php _e('Enter a number for the display order for this category (ex: 1 would be displayed first)', '1pixel'); ?></p>
            </td>
       </tr>
<?php
}
add_action( 'skills_edit_form_fields', 'onepix_taxonomy_edit_meta_field', 10, 2 );

// Save extra taxonomy fields callback function. (for storing custom meta for the taxonomy in the admin area)
function onepix_save_taxonomy_custom_meta( $term_id ) {
    global $wpdb;	
    if ( isset( $_POST['term_meta'] ) ) {
		$t_id = $term_id;
		$term_meta = get_option( "taxonomy_$t_id" );
		$cat_keys = array_keys( $_POST['term_meta'] );
		foreach ( $cat_keys as $key ) {
			if ( isset ( $_POST['term_meta'][$key] ) ) {
				$term_meta[$key] = $_POST['term_meta'][$key];
			}
		}
		// Save the option array.
		update_option( "taxonomy_$t_id", $term_meta );
                //save this to term_group (extra field in wp_term table) so you can store custom order meta
                $wpdb->update($wpdb->terms, array('term_group' => $term_meta['order_term_meta']), array('term_id' => $t_id));
	}
} 
// when the taxonomy: "" gets added to the end of the name of this action it automatically binds to that taxonomy
add_action( 'edited_skills', 'onepix_save_taxonomy_custom_meta', 10, 2 );  
add_action( 'create_skills', 'onepix_save_taxonomy_custom_meta', 10, 2 );
//arrange taxonomy according to our set display order in the admin area (just for admin display)
function onepix_change_term_order( $orderby, $args, $taxonomies ) {
    if ( is_admin() && TAXONOMY_NAME . 's' !== $taxonomies )
    {
        return $orderby;
    } else {
        $orderby = 'term_group';
        $args['order'] = 'ASC';
        return $orderby;
        
    }
}
add_filter( 'get_terms_orderby', 'onepix_change_term_order', 10, 3 );
?>
