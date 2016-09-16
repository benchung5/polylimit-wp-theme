<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
/* ------------------------------------------------------------------------ *
 * //Settings api for themeing controlled by admin area ----------------------
 * --------------------------------------------------------------------------- 
 * ------------------------------------------------------------------------ */


/* ------------------------------------------------------------------------ *
 * //Collects our theme options
 * ------------------------------------------------------------------------ */
function onepix_get_global_options(){
	$onepix_option = array();
	$onepix_option 	= get_option('onepix_options');
    return $onepix_option;
}

 /**
 * Call the function and collect in variable
 *
 * Should be used in template files like this:
 * <?php echo $onepix_option['onepix_txt_input']; ?>
 *
 * Note: Should you notice that the variable ($onepix_option) is empty when used in certain templates such as header.php, sidebar.php and footer.php
 * you will need to call the function (copy the line below and paste it) at the top of those documents (within php tags)!
 */ 
$onepix_option = onepix_get_global_options();

/* ------------------------------------------------------------------------ *
 * globals
 * ------------------------------------------------------------------------ */ 


//    defince globals for post type and taxonomy
define( 'SHOWCASE_NAME', $onepix_option['onepix_showcase_name'] );
define( 'TAXONOMY_NAME', $onepix_option['onepix_taxonomy_name'] );

//header type
$header_type = "standard";

//default images
define( 'DEFAULT_IMG_545', get_bloginfo('template_directory') . "/images/default-image-545x545.jpg" );
    
/* ------------------------------------------------------------------------ *
 * add actions
 * ------------------------------------------------------------------------ */ 

add_action( 'admin_menu', 'onepix_add_menu' );  
add_action( 'admin_init', 'onepix_register_settings' ); 
add_action( 'init', 'onepix_init_testimonials' );
add_action( 'init', 'onepix_init_showcase' );
add_action( 'init', 'onepix_add_showcase_taxonomy' );


/* ------------------------------------------------------------------------ *
 * includes
 * ------------------------------------------------------------------------ */ 

//page settings sections & fields  
//require_once('lib/helper-functions.php'); 
locate_template( 'lib/helper-functions.php', TRUE, TRUE );

//page settings sections & fields  
//include( get_template_directory() . '/gwf-options.php');
locate_template( 'lib/head-styles.php', TRUE, TRUE );

//page settings sections & fields  
//include( get_template_directory() . '/gwf-options.php');
locate_template( 'lib/google-fonts.php', TRUE, TRUE );


//page settings sections & fields  
//require_once('lib/theme-options.php'); 
locate_template( 'lib/theme-options.php', TRUE, TRUE );

//require only in admin! Globals
if(is_admin()){   
//    require_once('lib/theme-settings.php');
    locate_template( 'lib/theme-settings.php', TRUE, TRUE );
}
//page custom meta box
//must use include instead of: locate_template( 'lib/meta-box.php', TRUE, TRUE ); or it throws an error. This happens for meta box implimentations
include("lib/meta-box.php");

//shortcodes for theme elements
//require_once('lib/shortcodes.php');
locate_template( 'lib/shortcodes.php', TRUE, TRUE );

//page custom widgets
//require_once('lib/widgets.php');
locate_template( 'lib/widgets.php', TRUE, TRUE );


/* ------------------------------------------------------------------------ *
 * Settings scripts (js & css)
 * ------------------------------------------------------------------------ */

//load admin scripts (for all admin pages)
if (is_admin()){
    add_action( 'admin_enqueue_scripts', 'onepix_load_admin_scripts' );
}

function onepix_load_admin_scripts() {
    
    // wp_deregister_script('jquery');
    // wp_enqueue_script("jquery", get_template_directory_uri() . '/lib/js/jquery.min.js', array('json2'), '1.8.3');
    
    
    //styles applied to regular admin pages
    wp_enqueue_style('admin_settings_css', get_template_directory_uri() . '/lib/css/admin-styles.css');
    
    //need this for onepix_uploader to work
    wp_enqueue_media();
    
    // Include our custom jQuery file with WordPress Color Picker dependency
    //wp_enqueue_script( 'custom-script-handle', plugins_url( '<span class="skimlinks-unlinked">custom-script.js</span>', __FILE__ ), array( 'wp-color-picker' ), false, true );
    wp_enqueue_script('onepix_uploader', get_template_directory_uri() . '/lib/js/onepix-uploader.js', array('jquery'));

}

function onepix_settings_scripts(){
    
        //to use theme settings for localize scripts
        global $onepix_option;

        //  for theme settings
	wp_enqueue_style('theme_settings_css', get_template_directory_uri() . '/lib/css/theme-settings.css');
        //loading animation script
        wp_enqueue_script('canvasloader', get_template_directory_uri() . '/js/heartcode-canvasloader-min.js', array('jquery'));
        //enque jquery ui for setttings tabs

        //wp_enqueue_script('theme_js', get_template_directory_uri().'/js/theme.js', array('jquery', 'jquery-ui-tabs'));
        // wp_enqueue_script( 'jquery' );
        // wp_enqueue_script( 'jquery-ui-core' );
        wp_enqueue_script('jquery-ui-tabs');
        wp_enqueue_script('theme_settings_js', get_template_directory_uri() . '/lib/js/theme-settings.js', array('jquery'));
        
        //localize script
        //test access by: alert(themeSettings_data.current_tab_input); (in your .js file)
        $themeSettings_data = array(
            'current_tab_input' => __($onepix_option['onepix_current_tab'])
//                        'current_tab_input' => 'foo'
        );
        wp_localize_script('theme_settings_js', 'themeSettings_data', $themeSettings_data);
        

//  for uploading images in theme settings
        wp_enqueue_media();
//        wp_enqueue_script('media-uploader', get_template_directory_uri() . '/lib/js/media-uploader.js', array('jquery'));
        
        // collect our contextual help text (defined in theme-options.php  * Contextual Help) 
        $settings_output = onepix_get_settings();  
        $onepix_help_settings = $settings_output['onepix_contextual_help'];  
        $screen = get_current_screen();
        // Add my_help_tab if current screen is My Admin Page
        $screen->add_help_tab( $onepix_help_settings );
        
        // Add the wordpress color picker css and script file      
        wp_enqueue_style( 'wp-color-picker' );
        //wp_enqueue_script( 'wp-color-picker-script', plugins_url('script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
        wp_enqueue_script(
                'iris',
                admin_url( 'js/iris.min.js' ),
                array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ),
                false,
                1
            );
        
}

    
/* ------------------------------------------------------------------------ *
 * The Admin menu page 
 * ------------------------------------------------------------------------ */ 

    
function onepix_add_menu(){  
    
    // Display Settings Page link under the "Appearance" Admin Menu  
    // add_theme_page( $page_title, $menu_title, $capability, $menu_slug, $function);  
    $onepix_settings_page = add_theme_page(__('1 Pixel Options'), __('1 Pixel Options','onepix_textdomain'), 'manage_options', ONEPIX_PAGE_BASENAME, 'onepix_settings_page_fn');            

    // contextual help  
//    if ($onepix_settings_page) {  
//        add_contextual_help( $onepix_settings_page, $onepix_contextual_help );  
//    }  
    
    // css & js, also contixtual help in the same function
    //this will ensures the scripts and help tab just gets loaded if on the settings page
    add_action( 'load-'. $onepix_settings_page, 'onepix_settings_scripts' );	

}

/* ------------------------------------------------------------------------ *
 * //Register sidebars
 * ------------------------------------------------------------------------ */    

// enables wigitized sidebars
if ( function_exists('register_sidebar') ) {
    
    // Sidebar Widget
    // Location: the sidebar
    register_sidebar(array('name'=>'Sidebar',
            'id' => 'sidebar',
            'before_widget' => '<div id="%1$s" class="widget widget-%2$s">',
            'after_widget' => '</div>',
            'before_title' => '<div class="lineafter-header-container "><h4>',
            'after_title' => '</h4></div>',
    ));
    // Header Right Widget
    // Location: right area of header
    register_sidebar(array('name'=>'Header Right',
            'id' => 'header-right',
            'before_widget' => '<div id="%1$s" class="widget widget-%2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4>',
            'after_title' => '</h4>',
    ));
    // Sidebar Secondary Widget
    // Location: the sidebar
    register_sidebar(array('name'=>'Sidebar Secondary',
            'id' => 'sidebar-secondary',
            'before_widget' => '<div id="%1$s" class="widget widget-%2$s">',
            'after_widget' => '</div>',
            'before_title' => '<div class="lineafter-header-container "><h4>',
            'after_title' => '</h4></div>',
    ));
    // Footer Top Widget
    // Location: footer top
    register_sidebar(array('name'=>'Footer Top 1',
            'id' => 'footer-top-1',
            'before_widget' => '<div id="%1$s" class="widget widget-%2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
    ));
    // Footer Top Widget
    // Location: footer top
    register_sidebar(array('name'=>'Footer Top 2',
            'id' => 'footer-top-2',
            'before_widget' => '<div id="%1$s" class="widget widget-%2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
    ));
    // Footer Top Widget
    // Location: footer top
    register_sidebar(array('name'=>'Footer Top 3',
            'id' => 'footer-top-3',
            'before_widget' => '<div id="%1$s" class="widget widget-%2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
    ));
    // Home Below Featured Widget
    // Location: home below featured area
    register_sidebar(array('name'=>'Home Below Featured',
            'id' => 'home-below-featured',
            'before_widget' => '<div id="%1$s" class="widget widget-%2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
    ));
    // Home Above Content Widget
    // Location: above the homepage content area (just below the "below featured" area)
    register_sidebar(array('name' => 'Home Above Content',
        'id' => 'home-above-content',
        'before_widget' => '<div id="%1$s" class="widget widget-%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
    // Home Below Content Widget
    // Location: below the homepage content area (just above the "above footer" area)
    register_sidebar(array('name'=>'Home Below Content',
            'id' => 'home-below-content',
            'before_widget' => '<div id="%1$s" class="widget widget-%2$s"><div class="row"><div class="medium-12 columns">',
            'after_widget' => '</div></div></div>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
    ));
    // Home Above Footer Widget
    // Location: home above footer area
    register_sidebar(array('name'=>'Home Above Footer',
            'id' => 'home-above-footer',
            'before_widget' => '<div id="%1$s" class="widget widget-%2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
    ));
    
    // WooCommerce--------------------//
    
    // custom shop sidebar
    // Location: sidebar for "shop" page
    register_sidebar(array('name'=>'Shop Sidebar',
            'id' => 'sidebar-shop',
            'before_widget' => '<div id="%1$s" class="widget widget-%2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4>',
            'after_title' => '</h4>',
    ));
}

/* ------------------------------------------------------------------------ *
 * //Load scripts/CSS - A safe way of adding JavaScripts to a WordPress generated page.
 * ------------------------------------------------------------------------ */    

// woocommerce js override - doesn't work if used in get_header or immediately executed.
function woocommerce_scripts() {
    
        //replace the add to cart script with custom one
        wp_dequeue_script('wc-add-to-cart');
        wp_enqueue_script('wc-add-to-cart', get_template_directory_uri() . '/js/woocommerce/add-to-cart.js', array('jquery'), false, true);
        
        
        wp_enqueue_script('onep_onePixWoocommerce', get_template_directory_uri() . '/js/woocommerce/onePixWoocommerce.js', array('jquery'), false, true);
        

        //Get the WooCommerce Shop URL (this is the root category page):
        $shop_page_url = get_permalink(woocommerce_get_page_id('shop'));
        
        //is this the shop page or a single product page?
        $is_shop_page = false;
        if(is_product() || is_shop() || is_product_category()){
            $is_shop_page = true;
        }

        //localize script
        //test access by: alert(onep_onePixWoocommerce.shop_page_url); (in your .js file)
        $onePixel_woo_data = array(
            'shop_url' => __($shop_page_url),
            'is_shop_page' => __($is_shop_page),
        );
        wp_localize_script('onep_onePixWoocommerce', 'onePixel_woo_data', $onePixel_woo_data);

}

//    check if in not in admin area and woocommerce is activated and it's a woocommerce page
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) && !is_admin() && class_exists('Woocommerce')) {
    
    add_action('get_header', 'woocommerce_scripts');
    
}
//dequeue styles
add_action( 'wp_print_styles', 'onepix_deregister_styles', 100 );

function onepix_deregister_styles() {
    //   wp pagenavi override (in style.css)
	wp_deregister_style( 'wp-pagenavi' );
}


//load scripts
if (!is_admin()){
    add_action('wp_enqueue_scripts', 'onepix_load_scripts');
}

if (!function_exists('onepix_load_scripts')) {

    function onepix_load_scripts() {
        
        //to use theme settings for localize scripts
        global $onepix_option;
        

        // enque jquery ui for tabs, accordion (these are auto loaded into the footerhomesliderhomeslider
        // enque jquery ui for tabs, accordion
        wp_enqueue_script('jquery-ui-tabs');
        wp_enqueue_script('jquery-ui-accordion');
        
        // footer scripts
        wp_enqueue_script( 'onep_footer-scripts', get_template_directory_uri() . '/js/footerscripts.js', array('jquery'), '1.0.0', true );
        //localize script
        //test access by: alert(footer_data.googlemap_address); (in your .js file)
        $footer_data = array(
            'googlemap_address' => __($onepix_option['onepix_googlemap_address']),
            'googlemap_lat' => __($onepix_option['onepix_googlemap_latitude']),
            'googlemap_long' => __($onepix_option['onepix_googlemap_longitude'])
        );
        wp_localize_script('onep_footer-scripts', 'footer_data', $footer_data);
        
        // for variouse elements (woocommerce and showcase)
        wp_register_script('easing', get_template_directory_uri() . '/js/jquery.easing.1.3.min.js', array('jquery'), null, true);
        wp_enqueue_script('easing');
       // flexslider 
       wp_register_script('onepix_flexslider', get_template_directory_uri() . '/js/flexslider/jquery.flexslider.min.js', array('jquery'), null, true);
        wp_enqueue_script('onepix_flexslider');

        //showcase scripts
        if ((('onepix_' . SHOWCASE_NAME == get_post_type()) || is_page_template( 'template-showcase.php' )) && !is_single()) {
            wp_register_script('quicksand', get_template_directory_uri() . '/js/jquery.quicksand.min.js', array('jquery'), null, true);
            wp_enqueue_script('quicksand');
            //jquery quicksand requires this plugin to be included in order for "useScaling: true" to allowed
            // wp_register_script('animatescale', get_template_directory_uri() . '/js/jquery-animate-css-rotate-scale.min.js', array('jquery'));
            // wp_enqueue_script('animatescale');
            wp_register_style('prettyPhoto', get_template_directory_uri() . '/css/prettyPhoto.css');
            wp_enqueue_style('prettyPhoto');
            wp_enqueue_script('prettyPhotoScript', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array('jquery'), null, true);
           
            wp_enqueue_script('onep_onePixShowcase', get_template_directory_uri() . '/js/onePixShowcase.js', array('jquery'), null, true);
            //localize script
            //test access by: alert(showcase_data.showcase_count); (in your .js file)
            $showcase_data = array(
                'showcase_count' => __($onepix_option['onepix_showcase_count'])
            );
            wp_localize_script('onep_onePixShowcase', 'showcase_data', $showcase_data);

        }
        
        //this activates masonry to use it instead of css columns
        //later impliment this as brower feature detection or backend option
        $useMasonry = false;
        
        //masonry scripts
        if ($onepix_option['onepix_blog_layout'] == 'Masonry' && (is_page_template('template-blog.php') || is_category())) {
            
            wp_enqueue_script('imagesLoaded', get_template_directory_uri() . '/js/imagesloaded.pkgd.min.js', false, null, true);
            
            if ($useMasonry == true) {
                
                // This overrites the default masonry (used to make masonry blog work)
                wp_deregister_script('jquery-masonry');
                wp_register_script('jquery-masonry', ("http://masonry.desandro.com/masonry.pkgd.js"), array('jquery'), '3.1.4', null, true);
                wp_enqueue_script('jquery-masonry');
                
                //css
                wp_enqueue_style('masonry', get_template_directory_uri() . '/css/masonry.css');
            
            } else {
                wp_enqueue_style('masonry', get_template_directory_uri() . '/css/masonry-css-columns.css');
            }
            //this applies to both css and js version
            wp_enqueue_script('onep_onePixMasonry', get_template_directory_uri() . '/js/onePixMasonry.js', array('jquery'), null, true);
            //localize script
            //test access by: alert(onep_onePixMasonry.has_sidebar); (in your .js file)
            $masonry_data = array(
                'has_sidebar' => __($onepix_option['onepix_blog_sidebar']),
                'use_masonry' => $useMasonry,
                'site_url' => __(site_url()),
            );
            wp_localize_script('onep_onePixMasonry', 'masonry_data', $masonry_data);
        }




        //landing page scrollnav scripts
        if (is_page_template( 'template-scrollnav.php' ) ) {
            wp_enqueue_script('stickymenu-scrollto', get_template_directory_uri() . '/js/nav-scroll/jquery.scrollTo.min.js', array('jquery'), null, true);
//            wp_enqueue_script('stickymenu-waypoints', get_template_directory_uri() . '/js/nav-scroll/waypoints.min.js', array('jquery'));
            //load this in the footer
            wp_enqueue_script('stickymenu-navbar', get_template_directory_uri() . '/js/nav-scroll/onePixnavbarScroll.js', array('jquery'), '2.0.5', true);
        }
        
//      loading animation script
        wp_enqueue_script('canvasloader', get_template_directory_uri() . '/js/heartcode-canvasloader-min.js', array('jquery'), null, true);

//      sticky menu
        wp_enqueue_script('jquery_sticky', get_template_directory_uri() . '/js/jquery.sticky.min.js', array('jquery'), null, true);
        
        wp_enqueue_script('onep_jqmobile', get_template_directory_uri() . '/js/jquery.mobilemenu.js', array('jquery'), null, true);
        //localize script
        //test access by: alert(mobilemenu_data.menutype); (in your .js file)
        $mobilemenu_data = array(
            'menutype' => __($onepix_option['onepix_menu_type'])
        );
        wp_localize_script('onep_jqmobile', 'mobilemenu_data', $mobilemenu_data);

        wp_enqueue_script('modernizr', get_template_directory_uri() . '/js/modernizr.js', array('jquery'), null, true);
        //for more options load from the same directory these scripts:
        //jquery.fitvids (for iframe videos)
        //jquery.mousewheel
        //froogaloop.js (for vimeo I beleive)
        //the actual flexslider script is loaded in the footer so it can use the "defer" attribute
        //stellar (for parallax)
        wp_enqueue_script('stellar', get_template_directory_uri() . '/js/jquery.stellar.min.js', array('jquery'), null, true);
 
//      google maps api
        if (is_page_template('template-contact.php')) {
            wp_enqueue_script('google-maps', 'http://maps.googleapis.com/maps/api/js?sensor=true');
        }
        
        wp_enqueue_script('onep_onePixel', get_template_directory_uri() . '/js/onePixel.js', array('jquery'), null, true);
        //localize script
        //test access by: alert(php_data.site_url); (in your .js file)
        
        $is_ring_builder = false;
        if (is_page_template( 'template-scrollnav.php' )) {
            $is_ring_builder = true;
        }

        $onePixel_data = array(
            'site_url' => __(site_url()),
            'menutype' => __($onepix_option['onepix_menu_type']),
            'slideshow_direction' => __($onepix_option['onepix_slideshow_direction']),
            'slideshow_speed' => __($onepix_option['onepix_slideshow_speed']),
            'slideshow_animation_speed' => __($onepix_option['onepix_animation_speed']),
            'slideshow_animation_type' => __($onepix_option['onepix_animation_type']),
            'slideshow_animation_loop' => __($onepix_option['onepix_animation_loop'])
            );
        wp_localize_script('onep_onePixel', 'onePixel_data', $onePixel_data);
        
        
        
        //load styles

        //load the default stylesheet
        //wp_enqueue_style( 'default-style', get_template_directory_uri(). '/css/default.min.css' );
        wp_enqueue_style( 'default-style', get_template_directory_uri(). '/css/default.css' );
        
        wp_enqueue_style( 'foundation-style', get_template_directory_uri(). '/css/foundation.min.css' );
        wp_enqueue_style( 'font-icon-style', get_template_directory_uri(). '/css/font-awesome.min.css' );
        //flex slider
        wp_enqueue_style( 'flexslider-css', get_template_directory_uri(). '/css/flexslider.css' );

        
        
        //be sure to put thess last in the list
        wp_enqueue_style( 'default-style', get_stylesheet_uri() ); 
        wp_enqueue_style( 'media-queries-style', get_template_directory_uri(). '/css/media-queries.css' );
        
//      product magnify
//        wp_enqueue_style( 'jquery-zoom-style', get_template_directory_uri(). '/css/jquery.jqzoom.css' );
//        wp_enqueue_script('jquery-zoom', get_template_directory_uri().'/js/jquery.jqzoom-core-pack.js', false, null, true);

    }

}

/* ------------------------------------------------------------------------ *
 * //Thumbnails
 * ------------------------------------------------------------------------ */    

if ( function_exists( 'add_theme_support' ) ) {
    // post thumbnail support
    add_theme_support( 'post-thumbnails' ); 
}

if ( function_exists( 'set_post_thumbnail_size' ) ) {  
    // default Post Thumbnail dimensions - also 1,2,3 col, homepage skills thumbs,  and showcase thumb size.
    set_post_thumbnail_size( 545, 545, true );
}

if ( function_exists( 'add_image_size' ) ) { 
    //home slider image size
    add_image_size( 'home-slider', 1500, 1200, true );
    //masonry blog style thumb size
    // add_image_size( 'masonry-thumb', 670, 900, true );
    //single post image size - unlimited height
    // add_image_size( 'single-post', 688, 999, false );
    //single post image size
    add_image_size( 'square-thumb', 545, 545, true );
    //post widget thumb image size
    add_image_size( 'widget-thumb', 50, 50, true );
}

//make image sizes selectable in media uploader
function custom_choose_sizes( $img_sizes ) {
    
    $new_sizes = array
    (
        'home-slider' => 'Home Slider',
        'masonry-thumb' => 'Masonry Thumb',
        'single-post' => 'Single Post',
        'square-thumb' => 'Square Thumb'
    ); 
    
    return array_merge( $img_sizes, $new_sizes );
}

add_filter('image_size_names_choose', 'custom_choose_sizes');
//todo... get the above working 

// adds the post thumbnail to the RSS feed
function onepix_rss_post_thumbnail($content) {
    global $post;
    if(has_post_thumbnail($post->ID)) {
        $content = '<p>' . get_the_post_thumbnail($post->ID) .
        '</p>' . get_the_content();
    }
    return $content;
}
add_filter('the_excerpt_rss', 'onepix_rss_post_thumbnail');
add_filter('the_content_feed', 'onepix_rss_post_thumbnail');


/* ------------------------------------------------------------------------ *
 * //Custom menus
 * ------------------------------------------------------------------------ */   

// custom menu support
add_theme_support( 'menus' );
if ( function_exists( 'register_nav_menus' ) ) {
        register_nav_menus(
                array(
                    'header-menu' => 'Header Menu'
                )
        );
}

/* ------------------------------------------------------------------------ *
 * //Cleanup/enhance Wordpress funtions
 * ------------------------------------------------------------------------ */ 

// adds Post Format support
// learn more: http://codex.wordpress.org/Post_Formats
// add_theme_support( 'post-formats', array( 'aside', 'gallery','link','image','quote','status','video','audio','chat' ) );

// removes detailed login error information for security
add_filter('login_errors',create_function('$a', "return null;"));

// removes the WordPress version from your header for security
function onepix_remove_version() {
        return '<!--1 Pixel theme-->';
}
add_filter('the_generator', 'onepix_remove_version');


// Removes Trackbacks from the comment count
add_filter('get_comments_number', 'comment_count', 0);

function comment_count( $count ) {
    if ( ! is_admin() ) {
        global $id;
        $get_comments = get_comments('status=approve&post_id=' . $id);

        $comments_by_type = separate_comments($get_comments);

    return count($comments_by_type['comment']);
    } else {

        return $count;

    }

}

// invite rss subscribers to comment
function rss_comment_footer($content) {
        if (is_feed()) {
                if (comments_open()) {
                        $content .= 'Comments are open! <a href="'.get_permalink().'">Add yours!</a>';
                }
        }
        return $content;
}

// custom excerpt read more
function onepix_excerpt_more( $more ) {
//	return '... <br/><a class="read-more" href="'. get_permalink( get_the_ID() ) . '">Read More &raquo;</a>';
        return '...';
}
add_filter( 'excerpt_more', 'onepix_excerpt_more' );


//By default, clicking the .more-link anchor opens the web document and scrolls the page to section of the document containing the named anchor (#more-000). 
//This section is where writers choose to place the <!--more--> tag within a post type.
//Users can prevent the scroll by filtering the content more link with a simple regular expression. 
function onepix_remove_more_link_scroll( $link ) {
	$link = preg_replace( '|#more-[0-9]+|', '', $link );
	return $link;
}
add_filter( 'the_content_more_link', 'onepix_remove_more_link_scroll' );


// adds a class to the post if there is a thumbnail
function onepix_has_thumb_class($classes) {
        global $post;
        if( has_post_thumbnail($post->ID) ) { $classes[] = 'has_thumb'; }
                return $classes;
}
add_filter('post_class', 'onepix_has_thumb_class');

//shorter excerpt length
if (! function_exists('onepix_custom_excerpt_length') ) :
function onepix_custom_excerpt_length( $length ) {
    //set the shorter length once
    $short = 10;
    //set long length once
    $long = 35;
    //if we can only set short excerpt for phones, else short for all mobile devices
    if (function_exists( 'is_phone')) {
        if ( is_phone() ) {
            return $short;
        }
        else {
            return $long;
        }        
    }
    else {
        if ( wp_is_mobile() ) {
            return $short;
        }
        else {
            return $long;
        }
    }
}
add_filter( 'excerpt_length', 'onepix_custom_excerpt_length', 999 );
endif; // ! onepix_custom_excerpt_length exists

// Enable shortcodes in widgets!
add_filter('widget_text', 'do_shortcode');

// Enable PHP in widgets !
add_filter('widget_text','execute_php',100);
function execute_php($html){
     if(strpos($html,"<"."?php")!==false){
          ob_start();
          eval("?".">".$html);
          $html=ob_get_contents();
          ob_end_clean();
     }
     return $html;
}

// Add/declare woocommerce support
add_action('after_setup_theme', 'woocommerce_support');

function woocommerce_support() {
    add_theme_support('woocommerce');
}


// Change the comment reply link to use 'reply to comment'
function add_comment_author_to_reply_link($link, $args, $comment) {

    // Replace Reply Link with "Reply to &lt;Author First Name>"
    $reply_link_text = $args['reply_text'];
    $link = str_replace($reply_link_text, 'reply to comment &rarr;', $link);

    return $link;

}

add_filter('comment_reply_link', 'add_comment_author_to_reply_link', 10, 3);

//change tag cloud font size
add_filter('widget_tag_cloud_args', 'set_tag_cloud_sizes');

function set_tag_cloud_sizes($args) {
    $args['smallest'] = 10;
    $args['largest'] = 13;
    return $args;
}

//function to add defer to all scripts(replace with async="async" to use the async attribute instead)
function js_deffer_attr($tag){

//Add async to all remaining scripts 
return str_replace( ' src', ' defer="defer" src', $tag );
}
add_filter( 'script_loader_tag', 'js_deffer_attr', 10 );

/* ------------------------------------------------------------------------ *
 * //post socials
 * ------------------------------------------------------------------------ */ 

function filter_shorten_linktext($linkstring,$link) {
	$characters = 33;
        $displayedTitle = '';
        if (preg_match('/<a.*?>(.*?)<\/a>/is',$linkstring,$matches)) {
            $displayedTitle = $matches[1];
            } 
	$newTitle = shorten_with_ellipsis($displayedTitle,$characters);
	return str_replace('><','>'.$newTitle.'<',$linkstring);
}

function shorten_with_ellipsis($inputstring,$characters) {
  return (strlen($inputstring) >= $characters) ? substr($inputstring,0,($characters-3)) . '...' : $inputstring;
}

// This adds filters to the next and previous links, using the above functions
// to shorten the text displayed in the post-navigation bar. The last 2 arguments
// are necessary; the last one is the crucial one. Saying "2" means the function
// "filter_shorten_linktext()" takes 2 arguments. If you don't say so here, the
// hook won't pass them when it's called and you'll get a PHP error.
add_filter('previous_post_link','filter_shorten_linktext',10,2);
add_filter('next_post_link','filter_shorten_linktext',10,2);

/* ------------------------------------------------------------------------ *
 * //post socials
 * ------------------------------------------------------------------------ */ 

function display_socials() {
    //don't display this if on the testimonials pages
    if (!is_post_type_archive('onepix_testimonial') && !is_singular( 'onepix_testimonial' )) {
        get_template_part('temp', 'post-socials');
    }
}
// add_action('display_socials_hook','display_socials');

/* ------------------------------------------------------------------------ *
 * //Add Breadcrumbs
 * ------------------------------------------------------------------------ */ 

//call this with:  the_breadcrumb();
function the_breadcrumb() {
    global $post;
    echo '<nav id="breadcrumbs">';
    if (!is_home()) {
        echo '<a href="';
        echo get_option('home');
        echo '">';
        echo 'Home';
        echo '</a> / ';
        if (is_category() || is_single()) {
            echo '';
            //if showcase item
            if ('onepix_' . SHOWCASE_NAME == get_post_type()) {
                $terms = get_the_terms($post->ID, TAXONOMY_NAME . 's');
                // Loop over each item since it's an array
                 if ( $terms != null ){
                    foreach ($terms as $term) {
                        echo $term->name;
                    }
                }
            }
            the_category(' / ');
            if (is_single()) {
                echo ' / ';
                the_title();
                echo '';

                }
                
        } elseif (is_archive()) {
              wp_title('');
        } elseif (is_page()) {
            if($post->post_parent){
                $anc = get_post_ancestors( $post->ID );
                $title = get_the_title();
                foreach ( $anc as $ancestor ) {
                    $output = '<a href="'.get_permalink($ancestor).'" title="'.get_the_title($ancestor).'">'.get_the_title($ancestor).'</a> / ';
                }
                echo $output;
                echo '<span title="'.$title.'"> '.$title.'</span>';
            } else {
                echo ' '.get_the_title();
            }
        }
    }
    elseif (is_tag()) {single_tag_title();}
    elseif (is_day()) {echo"Archive for "; the_time('F jS, Y'); echo'';}
    elseif (is_month()) {echo"Archive for "; the_time('F, Y'); echo'';}
    elseif (is_year()) {echo"Archive for "; the_time('Y'); echo'';}
    elseif (is_author()) {echo"Author Archive"; echo'';}
    elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "Blog Archives"; echo'';}
    elseif (is_search()) {echo"Search Results"; echo'';}
    echo '</nav>';
}

/* ------------------------------------------------------------------------ *
 * //Contact form 7
 * ------------------------------------------------------------------------ */ 

// placeholder text for dropdown select
function my_wpcf7_form_elements($html) {
    $text = 'Area of Practice...';
    $html = str_replace('<option value="">---</option>', '<option value="">' . $text . '</option>', $html);
    return $html;
}
add_filter('wpcf7_form_elements', 'my_wpcf7_form_elements');


/* ------------------------------------------------------------------------ *
 * //Alter main loop - pre get posts filter (better alternative to using query_posts())
 * ------------------------------------------------------------------------ */ 

//function onepix_pre_get_posts( $query ) {
//
//    if ( ! $query->is_main_query() || is_admin() ) {
//        return;
//    } elseif ( $query->is_home()) {
//        $query->set( 'cat', '-32' );
//        $query->set( 'post_type', array( 'post', 'book' ));
//        $query->set( 'posts_per_page', '20' );
//        $query->set( 'order', 'order=ASC' );
//    } else {
//        return;
//    }
//
//}
//add_action( 'pre_get_posts', 'onepix_pre_get_posts' );

/* ------------------------------------------------------------------------ *
 * //Featured posts function - use sticky_posts to avoid duplicate content
 * ------------------------------------------------------------------------ */ 

function onepix_get_featured_posts() {
    $sticky = get_option( 'sticky_posts' );

    if ( empty( $sticky ) )
        return new WP_Query();

    $args = array(
        'posts_per_page' => 5,
        'post__in' => $sticky,
    );

    return new WP_Query( $args );
}

//implement the above for featured posts (to avoid duplication)
//$featured_posts = onepix_get_featured_posts();
//while ( $featured_posts->have_posts() ) {
//    $featured_posts->the_post();
//
//    the_title();
//    the_excerpt();
//}
//wp_reset_postdata();


/* ------------------------------------------------------------------------ *
 * Testimonials
 * ------------------------------------------------------------------------ */ 

function onepix_init_testimonials(){  

    register_post_type('onepix_testimonial', array(
        'labels' => array(
            'name' => __('Testimonials'),
            'singular_name' => __('Testimonial')
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'testimonial', 'with_front' => FALSE),
            )
    );
    //must do this to get permalinks working
    flush_rewrite_rules();
}

/* ------------------------------------------------------------------------ *
 * showcase
 * ------------------------------------------------------------------------ */ 
locate_template( 'lib/showcase/showcase-post-type.php', TRUE, TRUE );
//include("lib/showcase/showcase-post-type.php");

/* ------------------------------------------------------------------------ *
 * slider
 * ------------------------------------------------------------------------ */ 
//must use include instead of: locate_template( 'lib/slider/slider-post-type.php', TRUE, TRUE ); or it throws an error. This happens for meta box implimentations
include("lib/slider/slider-post-type.php");

locate_template( 'lib/slider/slider.php', TRUE, TRUE );
//include("lib/slider/slider.php");

/* ------------------------------------------------------------------------ *
 * Giant Menu
 * ------------------------------------------------------------------------ */ 

locate_template( 'lib/menu/giant-menu.php', TRUE, TRUE );
//include("lib/giant-menu.php");

/* ------------------------------------------------------------------------ *
 * Add bitly support for better Twitter social share url support
 * ------------------------------------------------------------------------ */

function onepix_getBitly($url) {
$bitly = file_get_contents("http://api.bit.ly/v3/shorten?login=o_4fu3rm39su&apiKey=R_88cfbef3cfee44b79ecc13e4d4248f91&longUrl=$url%2F&format=txt");
return $bitly;
}

/* ------------------------------------------------------------------------ *
 * Custom gravatar
 * ------------------------------------------------------------------------ */ 

//note that this gravatar can only be used once, if you change it it must be renamed
add_filter( 'avatar_defaults', 'onepix_custom_gravatar' );  
function onepix_custom_gravatar ($avatar_defaults) {
    global $onepix_option;
    if($onepix_option['onepix_gravatar']) {
        $myavatar = $onepix_option['onepix_gravatar'];
    } else {
        $myavatar = get_template_directory_uri() . '/images/custom-gravatar.jpg';
    }
     
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

/*-----------------------------------------------------------------------------------*/
// Sticky top nav menu
/*-----------------------------------------------------------------------------------*/
function onepix_stickytop() {
	if (has_nav_menu('stickynav')) { ?>
		<div id="topnav">
                        <ul class="topnav">
                                <?php wp_nav_menu(array(
                                    'container'=>false,
                                    'theme_location'=>'stickynav',
                                    'fallback_cb'=>'',
                                    'items_wrap'=>'%3$s',
                                    'depth'=> 1 //display the menu only allowing a depth of 1
                                    )); ?>
                        </ul>
		</div>
	<?php } 

}

add_action('onepix_very_top', 'onepix_stickytop', 10);


/*-----------------------------------------------------------------------------------*/
// Masonry Ajax load more
/*-----------------------------------------------------------------------------------*/

function onepix_masonry_ajaxload(){
  //get the data from ajax() call

    //this method will return the condents of the require once;
    ob_start();
    require_once('temp-content-masonry-ajax.php');
    // Return the String
//    return ob_get_clean();
    die(ob_get_clean());

  }
  // creating Ajax call for WordPress
   add_action( 'wp_ajax_nopriv_onepix_masonry_ajaxload', 'onepix_masonry_ajaxload' );
   add_action( 'wp_ajax_onepix_masonry_ajaxload', 'onepix_masonry_ajaxload' );

/*-----------------------------------------------------------------------------------*/
// Add to body class for layout rules
/*-----------------------------------------------------------------------------------*/
   
// Add specific CSS class by filter
add_filter('body_class','onepix_addto_bodyclass');

function onepix_addto_bodyclass($classes) {
    
        global $onepix_option;
        global $header_type;
        
//      header/menu style options classes
        $belowheader_menu_class = '';
        
        if ($onepix_option['onepix_menu_type'] == 'Standard') {
            $belowheader_menu_class = 'inheader-menu';
        } else {
            $belowheader_menu_class = 'inheader-menu';
        }
        
        if ($onepix_option['onepix_has_fixed_caption'] == 1) { $belowheader_menu_class .= ' fixed-caption'; }
        
//      check for boxed layout
        $boxed_layout = '';
        if ($onepix_option['onepix_unboxed_layout'] == 0) { $boxed_layout .= ' boxed-layout'; }
        
        
////    control page header class
        $pageheader_class = '';
//        if (is_product() || is_shop() || is_product_category() || is_checkout() || is_cart()) {
          if (1 == 2) {
            $header_type = "standard";
            $pageheader_class = 'standard-pageheader';
        } elseif ((get_post_meta(get_the_ID(), 'onepix_page_header_type', true) == 'custom')) {
            $header_type = "custom";
            $pageheader_class = 'custom-pageheader';
        } elseif (is_page_template( 'template-contact.php' ) && $onepix_option['onepix_has_googlemap']) {
            $header_type = "contact_page";
            $pageheader_class = 'contact-pageheader';
        } elseif (is_front_page() || is_home()) {
            $header_type = "plain";
            $pageheader_class = 'home-pageheader';
        } else {
            $header_type = "plain";
            $pageheader_class = 'no-pageheader';
        }
        
////    if internal page
        $is_internal_class = '';
        if (!(is_front_page() || is_home())) {
        $is_internal_class = 'internal-page';
        }

        //post-type-archive-onepix_portfolio already has class

	// add 'class-name' to the $classes array
        $classes[] = $belowheader_menu_class;
        $classes[] = $pageheader_class;
        $classes[] = $is_internal_class;
        $classes[] = $boxed_layout;
        
	// return the $classes array
	return $classes;
}
   
   
/*-----------------------------------------------------------------------------------*/
// WooCommerce
/*-----------------------------------------------------------------------------------*/


//woocommerce contitionals to use in theme templates (must to it this way to ensure woocommerce is activated before using the woocommerce conditionals)

//check if plugin is activated
$onepix_is_woo_active = in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')));

function onepix_woo_active() {
    global $onepix_is_woo_active;
    //Check if WooCommerce is active
    if ($onepix_is_woo_active) {
        return true;
    } else {
        return false;
    } 
}

function onepix_is_shop() {
    global $onepix_is_woo_active;
    //Check if WooCommerce is active
    if ($onepix_is_woo_active) {
        return is_shop();
    } else {
        return false;
    }
}

function onepix_is_cart() {
    global $onepix_is_woo_active;
    //Check if WooCommerce is active
    if ($onepix_is_woo_active) {
        return is_cart();
    } else {
        return false;
    } 
}

function onepix_is_checkout() {
    global $onepix_is_woo_active;
    //Check if WooCommerce is active
    if ($onepix_is_woo_active) {
        return is_checkout();
    } else {
        return false;
    }
}

function onepix_is_account() {
    global $onepix_is_woo_active;
    //Check if WooCommerce is active
    if ($onepix_is_woo_active) {
        return is_account_page();
    } else {
        return false;
    }
}

function onepix_is_archive() {
    global $onepix_is_woo_active;
    //Check if WooCommerce is active
    if ($onepix_is_woo_active) {
        return is_archive();
    } else {
        return false;
    }
}


//    check if woocommerce is activated and not in admin area and it's a woocommerce page
if ($onepix_is_woo_active && !is_admin() && class_exists('Woocommerce')) {

// Remove the main WooCommerce stylesheets one by one to start from scratch
    add_filter('woocommerce_enqueue_styles', 'onepix_dequeue_styles');

    function onepix_dequeue_styles($enqueue_styles) {
// Remove certain woocommerce css
        unset($enqueue_styles['woocommerce-general']);
        unset($enqueue_styles['woocommerce-layout']);
        unset($enqueue_styles['woocommerce-smallscreen']); // Remove the smallscreen optimisation
        unset($enqueue_styles['chosen']); // Remove special dropdown select boxes
        return $enqueue_styles;
    }

    add_action('wp_enqueue_scripts', 'onepix_manage_woocommerce_styles', 99);

    /**
     * Remove WooCommerce Generator tag, styles.
     * Tested and works with WooCommerce 2.0+
     *
     * @author Greg Rickaby
     * @since 2.0.0
     */
    function onepix_manage_woocommerce_styles() {
        remove_action('wp_head', array($GLOBALS['woocommerce'], 'generator'));

//wp_dequeue_style( 'woocommerce_frontend_styles' );
//wp_dequeue_style( 'woocommerce_fancybox_styles' );
//wp_dequeue_style( 'woocommerce_chosen_styles' );
//wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
//wp_dequeue_script( 'wc_price_slider' );
//wp_dequeue_script( 'wc-single-product' );
//wp_dequeue_script( 'wc-add-to-cart' );
//wp_dequeue_script( 'wc-cart-fragments' );
//wp_dequeue_script( 'wc-checkout' );
//wp_dequeue_script( 'wc-add-to-cart-variation' );
//wp_dequeue_script( 'wc-single-product' );
//wp_dequeue_script( 'wc-cart' );
        wp_dequeue_script('wc-chosen');
//wp_dequeue_script( 'woocommerce' );
//wp_dequeue_script( 'prettyPhoto' );
//wp_dequeue_script( 'prettyPhoto-init' );
//wp_dequeue_script( 'jquery-blockui' );
//wp_dequeue_script( 'jquery-placeholder' );
//wp_dequeue_script( 'fancybox' );
//wp_dequeue_script( 'jqueryui' );
        
        //enqueue custom woocommerce style
        //wp_enqueue_style( 'woocommerce-style', get_template_directory_uri(). '/css/woocommerce.min.css' );
        wp_enqueue_style( 'woocommerce-style', get_template_directory_uri(). '/css/woocommerce.css' );    
        
    }

// override woocommerce checkout fields
    add_filter('woocommerce_checkout_fields', 'onepix_override_checkout_fields');

// Our hooked in function - $fields is passed via the filter!
    function onepix_override_checkout_fields($fields) {
        //first name
        $fields['billing']['billing_first_name']['placeholder'] = 'First name';
        $fields['billing']['billing_first_name']['label'] = '';
        //last name
        $fields['billing']['billing_last_name']['placeholder'] = 'Last name';
        $fields['billing']['billing_last_name']['label'] = '';
        //company name
        $fields['billing']['billing_company']['placeholder'] = 'Company name';
        $fields['billing']['billing_company']['label'] = '';
        //address
        $fields['billing']['billing_address_1']['label'] = '';
        //town/city
        $fields['billing']['billing_city']['label'] = '';
        //country
        $fields['billing']['billing_state']['label'] = '';
        //postal code
        $fields['billing']['billing_postcode']['label'] = '';
        //email address
        $fields['billing']['billing_email']['label'] = '';
        //phone
        $fields['billing']['billing_phone']['label'] = '';


        return $fields;
    }

// override woocommerce billing fields
    add_filter('woocommerce_billing_fields', 'onepix_woocommerce_billing_fields');

    function onepix_woocommerce_billing_fields($fields) {


        //first name
        $fields['billing_first_name']['placeholder'] = 'First name';
        $fields['billing_first_name']['label'] = '';
        //last name
        $fields['billing_last_name']['placeholder'] = 'Last name';
        $fields['billing_last_name']['label'] = '';
        //company name
        $fields['billing_company']['placeholder'] = 'Company name';
        $fields['billing_company']['label'] = '';
        //address
        $fields['billing_address_1']['label'] = '';
        //town/city
        $fields['billing_city']['label'] = '';
        //country
        $fields['billing_state']['label'] = '';
        //postal code
        $fields['billing_postcode']['label'] = '';
        //email address
        $fields['billing_email']['label'] = '';
        //phone
        $fields['billing_phone']['placeholder'] = 'Billing phone';
        $fields['billing_phone']['label'] = '';

        return $fields;
    }

// override woocommerce shipping fields
    add_filter('woocommerce_shipping_fields', 'onepix_woocommerce_shipping_fields');

    function onepix_woocommerce_shipping_fields($fields) {


        //first name
        $fields['shipping_first_name']['placeholder'] = 'First name';
        $fields['shipping_first_name']['label'] = '';
        //last name
        $fields['shipping_last_name']['placeholder'] = 'Last name';
        $fields['shipping_last_name']['label'] = '';
        //company name
        $fields['shipping_company']['placeholder'] = 'Company name';
        $fields['shipping_company']['label'] = '';
        //address
        $fields['shipping_address_1']['label'] = '';
        //town/city
        $fields['shipping_city']['label'] = '';
        //country
        $fields['shipping_state']['label'] = '';
        //postal code
        $fields['shipping_postcode']['label'] = '';


        return $fields;
    }

//change woocommerce product thumb size

    add_action('init', 'onepix_woocommerce_image_dimensions', 1);

    function onepix_woocommerce_image_dimensions() {
        $catalog = array(
            'width' => '545', // px
            'height' => '545', // px
            'crop' => 1   // true
        );

        $single = array(
            'width' => '688', // px
            'height' => '688', // px
            'crop' => 1   // true
        );

        $thumbnail = array(
            'width' => '140', // px
            'height' => '140', // px
            'crop' => 1  // true
        );

        // Image sizes
        update_option('shop_catalog_image_size', $catalog);   // Product category thumbs
        update_option('shop_single_image_size', $single);   // Single product image
        update_option('shop_thumbnail_image_size', $thumbnail);  // Image gallery thumbs
    }

    /*
     * goes in theme functions.php or a custom plugin. Replace the image filename/path with your own :)
     *
     * */
    add_action('init', 'onepix_fix_thumbnail');

    function onepix_fix_thumbnail() {
        add_filter('woocommerce_placeholder_img_src', 'onepix_woocommerce_placeholder_img_src');

        function onepix_woocommerce_placeholder_img_src($src) {
            $src = get_template_directory_uri() . '/images/default-image-545x545.jpg';
            return $src;
        }

    }

//remove woocommerce breadcrumb (so we can change the location below)
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
//add hook for breadcrumb right side of shop pages (insdtead of the above)
    add_action('onepix_header_right_shop', 'woocommerce_breadcrumb', 20, 0);
}

// define the woocommerce_cart_actions callback
function action_woocommerce_cart_actions(  ) 
{
   //add continue shopping button
    echo '<a class = "button wc-backward continue-shopping" href = "' .  get_permalink(wc_get_page_id('shop')) . '">' . __('Continue Shopping', 'woocommerce') . '</a>';
};

// add the action
add_action('woocommerce_cart_actions', 'action_woocommerce_cart_actions', 10, 0);

/*-----------------------------------------------------------------------------------*/
// Apply theme's stylesheet to the visual editor. (enable this when close to done)
/*-----------------------------------------------------------------------------------*/

//add_action( 'init', 'cd_add_editor_styles' );
///**
//* 
//*
//* @uses add_editor_style() Links a stylesheet to visual editor
//* @uses get_stylesheet_uri() Returns URI of theme stylesheet
//*/
//function cd_add_editor_styles() {
// 
//add_editor_style( get_stylesheet_uri() );
// 
//}
   
?>