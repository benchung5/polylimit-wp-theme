<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { 
    exit;
}
include_once( 'custom_walker.php' );
// add custom menu fields to menu
add_filter( 'wp_setup_nav_menu_item', 'onepix_custom_menu_fields' );
function onepix_custom_menu_fields( $menu_item ) {
    $menu_item->html = get_post_meta( $menu_item->ID, '_menu_item_html', true );
    return $menu_item;
}
// save menu custom fields
add_action('wp_update_nav_menu_item', 'onepix_update_custom_menu_fields', 10, 3);
function onepix_update_custom_menu_fields($menu_id, $menu_item_db_id, $args) {
    // Check if element is properly sent
    if(isset($_REQUEST['menu-item-html']) && $_REQUEST['menu-item-html']!="") {
        if (isset($_REQUEST['menu-item-html'][$menu_item_db_id])) {
            $html_value = $_REQUEST['menu-item-html'][$menu_item_db_id];
            update_post_meta($menu_item_db_id, '_menu_item_html', $html_value);
        }
    }
}
//Define new Walker edit
add_filter('wp_edit_nav_menu_walker', 'onepix_edit_walker', 10, 2);
function onepix_edit_walker($walker, $menu_id) {
    return 'Onepix_Walker_Nav_Menu_Edit';
}
include_once( 'custom_walker_edit.php' );