<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { 
    exit;
}
$onepix_option = onepix_get_global_options();
//extend te walker class to make our custom sub-menu list (Walker_Nav_Menu class copied from: /wp-includes/nav-menu-template.php)
class Onepix_Walker extends Walker_Nav_Menu
{
    // ben added
    private static $giant_menu_type = "";
    private static $is_giant_menu = false;
    /**
     * What the class handles.
     *
     * @see Walker::$tree_type
     * @since 3.0.0
     * @var string
     */
    var $tree_type = array('post_type', 'taxonomy', 'custom');
    /**
     * Database fields to use.
     *
     * @see Walker::$db_fields
     * @since 3.0.0
     * @todo Decouple this.
     * @var array
     */
    var $db_fields = array('parent' => 'menu_item_parent', 'id' => 'db_id');
    /**
     * Starts the list before the elements are added.
     *
     * @see Walker::start_lvl()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    function start_lvl(&$output, $depth = 0, $args = array())
    {
        global $is_giant_menu;
        $indent = str_repeat("\t", $depth);
        //ben wrapper for submenu
        //to be able to access this here..
        global $onepix_option;
        //ben alteration for giant submenu
        if ($onepix_option['onepix_menu_type'] == 'Giant') {
            $is_giant_menu = true;
            if ($depth == 0) {
                $output .= "\n$indent<div id=\"giant-submenu-wrapper\" class=\"" . "depth-" . $depth . "\">\n";
                $output .= "\n$indent<ul id=\"giant-sub-menu\" class=\"row padding-columns \">\n";
            } else {
                $output .= "\n$indent<ul id=\"giant-sub-menu\">\n";
            }
        } else {
            $output .= "\n$indent<ul class=\"sub-menu\">\n";
        }
    }
    /**
     * Ends the list of after the elements are added.
     * @see Walker::end_lvl()
     * @since 3.0.0
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    function end_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
        //to be able to access this here..
        global $onepix_option;
        //ben end wrapper for giant submenu
        if ($onepix_option['onepix_menu_type'] == 'Giant') {
            if ($depth == 0) {
                $output .= "$indent</div>\n";
            }
        }
    }
    /**
     * Start the element output.
     * @see Walker::start_el()
     * @since 3.0.0
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Menu item data object.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     * @param int    $id     Current item ID.
     */
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        global $is_giant_menu;
        $indent      = ($depth) ? str_repeat("\t", $depth) : '';
        $class_names = $value = '';
        $classes     = empty($item->classes) ? array() : (array) $item->classes;
        global $giant_menu_type;
        if ($depth == 1) {
            //use custom HTML if the parent menu item has just the word "custom" in it...)
            if ($item->html !== "" && $is_giant_menu == true) {
                $giant_menu_type = "custom";
            } else {
                $giant_menu_type = "columns";
            }
        }
        if ($giant_menu_type == "columns") {
            if ($depth == 1) {
                $classes[] = 'menu-item-' . $item->ID . " columns ";
            }
        } elseif ($giant_menu_type == "custom") {
            if ($depth == 1) {
                $classes[] = 'menu-item-' . $item->ID . ' custom-html';
            }
        } else {
            $classes[] = 'menu-item-' . $item->ID;
        }
        /**
         * Filter the CSS class(es) applied to a menu item's <li>.
         * @since 3.0.0
         * @param array  $classes The CSS classes that are applied to the menu item's <li>.
         * @param object $item    The current menu item.
         * @param array  $args    An array of arguments. @see wp_nav_menu()
         */
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        //               ben
        //page settings sections & fields
        if ($depth == 1 && $giant_menu_type == "custom") {
            /**
             * Filter the ID applied to a menu item's <li>.
             * @since 3.0.1
             * @param string The ID that is applied to the menu item's <li>.
             * @param object $item The current menu item.
             * @param array $args An array of arguments. @see wp_nav_menu()
             */
            $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
            $id = $id ? ' id="' . esc_attr($id) . '"' : '';
            $output .= $indent . '<li' . $id . $value . $class_names . '>';
            //add custom html to manu item to make the custom giant submenu
            //$output .= $item->description;
            $output .= ' ' . do_shortcode($item->html) . '';
        } else {
            /**
             * Filter the ID applied to a menu item's <li>.
             * @since 3.0.1
             * @param string The ID that is applied to the menu item's <li>.
             * @param object $item The current menu item.
             * @param array $args An array of arguments. @see wp_nav_menu()
             */
            $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
            $id = $id ? ' id="' . esc_attr($id) . '"' : '';
            $output .= $indent . '<li' . $id . $value . $class_names . '>';
            $atts           = array();
            $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
            $atts['target'] = !empty($item->target) ? $item->target : '';
            $atts['rel']    = !empty($item->xfn) ? $item->xfn : '';
            $atts['href']   = !empty($item->url) ? $item->url : '';
            /**
             * Filter the HTML attributes applied to a menu item's <a>.
             * @since 3.6.0
             * @param array $atts {
             *     The HTML attributes applied to the menu item's <a>, empty strings are ignored.
             *     @type string $title  The title attribute.
             *     @type string $target The target attribute.
             *     @type string $rel    The rel attribute.
             *     @type string $href   The href attribute.
             * }
             * @param object $item The current menu item.
             * @param array  $args An array of arguments. @see wp_nav_menu()
             */
            $atts           = apply_filters('nav_menu_link_attributes', $atts, $item, $args);
            $attributes     = '';
            foreach ($atts as $attr => $value) {
                if (!empty($value)) {
                    $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }
            $item_output = $args->before;
            $item_output .= '<a' . $attributes . '>';
            /** This filter is documented in wp-includes/post-template.php */
            $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;
            /**
             * Filter a menu item's starting output.*
             * The menu item's starting output only includes $args->before, the opening <a>,
             * the menu item's title, the closing </a>, and $args->after. Currently, there is
             * no filter for modifying the opening and closing <li> for a menu item.
             * @since 3.0.0
             * @param string $item_output The menu item's starting HTML output.
             * @param object $item        Menu item data object.
             * @param int    $depth       Depth of menu item. Used for padding.
             * @param array  $args        An array of arguments. @see wp_nav_menu()
             */
            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }
    }
    /**
     * Ends the element output, if needed.
     * @see Walker::end_el()
     * @since 3.0.0
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Page data object. Not used.
     * @param int    $depth  Depth of page. Not Used.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    function end_el(&$output, $item, $depth = 0, $args = array())
    {
        $output .= "</li>\n";
    }
} // Walker_Nav_Menu