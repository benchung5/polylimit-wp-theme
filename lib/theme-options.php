<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
/* ------------------------------------------------------------------------ *
 * Define our settings sections 
 * ------------------------------------------------------------------------ */ 
 
    function onepix_options_page_sections() {
        
        /** 
        * array key=$id, array value=$title in: add_settings_section( $id, $title, $callback, $page ); 
        * @return array 
        */ 
          
        $sections = array();  
        // $sections[$id]       = __($title, 'onepix_textdomain');  
        $sections['general_section']    = __('General Settings', 'onepix_textdomain');
        $sections['typography_section']    = __('Typography Settings', 'onepix_textdomain');
        $sections['color_section']    = __('Color & Background Settings', 'onepix_textdomain'); 
        $sections['header_section'] = __('Header Settings', 'onepix_textdomain');
        $sections['layout_section']    = __('Layout Settings', 'onepix_textdomain');
        $sections['featured_section']    = __('Featured Area Settings', 'onepix_textdomain');
        $sections['featured_slider_section']    = __('Featured Slider Settings', 'onepix_textdomain');
        $sections['featured_image_section']    = __('Featured Image Settings', 'onepix_textdomain');
        $sections['socials_section']    = __('Social Media Settings', 'onepix_textdomain');
        $sections['contact_section']    = __('Contact Settings', 'onepix_textdomain');
//        $sections['txt_section']    = __('Text Form Fields', 'onepix_textdomain');  
//        $sections['txtarea_section']    = __('Textarea Form Fields', 'onepix_textdomain');  
//        $sections['select_section']     = __('Select Form Fields', 'onepix_textdomain');  
//        $sections['checkbox_section']   = __('Checkbox Form Fields', 'onepix_textdomain');  
          
        return $sections;     
    }
    
        /** 
     * Define our form fields (settings)  
     * 
     * @return array 
     */  
    function onepix_options_page_fields() {
        
// General Settings 
        
       $options[] = array(
            "section" => "general_section",
            "id" => ONEPIX_SHORTNAME . "_showcase_name",
            "title" => __('Showcase Post Type Name'),
            "desc" => __('Enter the name for the custom post type showcase (avoid using Gallery - that belongs to WordPress)', 'onepix_textdomain'),
            "type" => "text",
            "std" => "showcase",
            "class" => "text"
        );
       
        $options[] = array(
            "section" => "general_section",
            "id" => ONEPIX_SHORTNAME . "_taxonomy_name",
            "title" => __('Showcase Taxonomy Name'),
            "desc" => __('Enter the name for your custom post type taxonomy (non-plural form)', 'onepix_textdomain'),
            "type" => "text",
            "std" => "skill",
            "class" => "text"
        );
        
        $options[] = array(
            "section" => "general_section",
            "id" => ONEPIX_SHORTNAME . "_gravatar",
            "title" => __('Gravatar Image URL', 'onepix_textdomain'),
            "desc" => __('Upload/add custom gravatar image. Select this in <a href="' . home_url() . '/wp-admin/options-discussion.php">Discussion</a> (80X80px)', 'onepix_textdomain'),
            "type" => "img",
            "std" => "http://yoursite.com/gravatarimageurl",
            "class" => "url"
        );
        
        $options[] = array(
            "section" => "general_section",
            "id" => ONEPIX_SHORTNAME . "_current_tab",
            "title" => __('Current Tab Item', 'onepix_textdomain'),
            "desc" => __('Hidden input for tab tracking', 'onepix_textdomain'),
            "type" => "text",
            "std" => "1",
            "class" => "current-tab"
        );
        
//Header Settings

        $options[] = array(
            "section" => "header_section",
            "id" => ONEPIX_SHORTNAME . "_logo_img_url",
            "title" => __('Logo Image URL', 'onepix_textdomain'),
            "desc" => __('Enter the url for you logo image', 'onepix_textdomain'),
            "type" => "img",
            "std" => "http://yoursite.com/logoimageurl",
            "class" => "url"
        );

        $options[] = array(
            "section" => "header_section",
            "id" => ONEPIX_SHORTNAME . "_logo_max_width",
            "title" => __('Logo Maximum Width', 'onepix_textdomain'),
            "desc" => __('The Maximum width in pixels for your logo', 'onepix_textdomain'),
            "type" => "text",
            "std" => "200",
            "class" => "numeric"
        );

        $options[] = array(
            "section" => "header_section",
            "id" => ONEPIX_SHORTNAME . "_header_height",
            "title" => __('Header Height', 'onepix_textdomain'),
            "desc" => __('The inner height of the site header', 'onepix_textdomain'),
            "type" => "text",
            "std" => "60",
            "class" => "numeric"
        );

        $options[] = array(
            "section" => "header_section",
            "id" => ONEPIX_SHORTNAME . "_menu_type",
            "title" => __('Menu Type', 'onepix_textdomain'),
            "desc" => __('Select menu placement and style', 'onepix_textdomain'),
            "type" => "select",
            "std" => "3",
            "choices" => array("Standard", "Giant"),
            "class" => "select"
        );
        
// Typography Settings 
        
        $options[] = array(
            "section" => "typography_section",
            "id" => ONEPIX_SHORTNAME . "_body_font",
            "title" => __('Body Font', 'onepix_textdomain'),
            "desc" => __('Select the Font for the body text', 'onepix_textdomain'),
            "type" => "select",
            "std" => "1",
            "choices" => array("PT Sans", "Roboto", "Open Sans", "Cabin", "Cuprum")
        );
        
        $options[] = array(
            "section" => "typography_section",
            "id" => ONEPIX_SHORTNAME . "_headline_font",
            "title" => __('Heading Font', 'onepix_textdomain'),
            "desc" => __('Select the Font for headlines', 'onepix_textdomain'),
            "type" => "select",
            "std" => "1",
            "choices" => array("Open Sans", "Lato", "Oswald", "Roboto", "Bitter")
    );
        
// Color Settings 
        
        $options[] = array(
            "section" => "color_section",
            "id" => ONEPIX_SHORTNAME . "_bodytext_color",
            "title" => __('Body Text Color'),
            "desc" => __('The color for body text', 'onepix_textdomain'),
            "type" => "color",
            "std" => "#5e5e5e",
            "class" => "hex-color"
        );

        $options[] = array(
            "section" => "color_section",
            "id" => ONEPIX_SHORTNAME . "_largetext_color",
            "title" => __('Large Text Color'),
            "desc" => __('The color for large version text', 'onepix_textdomain'),
            "type" => "color",
            "std" => "#8b9196",
            "class" => "hex-color"
        );

        $options[] = array(
            "section" => "color_section",  
            "id"      => ONEPIX_SHORTNAME . "_highlight_color",  
            "title"   => __( 'Link/Highlight Color' ),  
            "desc"    => __( 'The color for links, hovers and highlighted graphics', 'onepix_textdomain' ),  
            "type"    => "color",  
            "std"     => "#ADD8E6",
            "class" => "hex-color"
         );

        $options[] = array(
            "section" => "color_section",
            "id" => ONEPIX_SHORTNAME . "_midtone_color",
            "title" => __('Midtone Background'),
            "desc" => __('The background for midtone areas', 'onepix_textdomain'),
            "type" => "text",
            "std" => "#7c7c7c",
            "class" => "allhtml"
        );

       $options[] = array(
            "section" => "color_section",  
            "id"      => ONEPIX_SHORTNAME . "_subfooter_color",  
            "title"   => __( 'Sub-Footer Color' ),  
            "desc"    => __( 'The background for top of the footer', 'onepix_textdomain' ),  
            "type" => "text", 
            "std"     => "#333",
            "class" => "allhtml"
        );
       
        $options[] = array(
            "section" => "color_section",
            "id" => ONEPIX_SHORTNAME . "_subfooter_bg_img",
            "title" => __('Sub-Footer Background Image'),
            "desc" => __('Optional background image for the subfooter', 'onepix_textdomain'),
            "type" => "img",
            "std" => "http://yoursite.com/imageurl",
            "class" => "url"
        );

        $options[] = array(
            "section" => "color_section",
            "id" => ONEPIX_SHORTNAME . "_footer_color",
            "title" => __('Footer Background Color'),
            "desc" => __('The bottom footer color', 'onepix_textdomain'),
            "type" => "text",
            "std" => "#121212",
            "class" => "allhtml"
        );

       $options[] = array(
            "section" => "color_section",
            "id" => ONEPIX_SHORTNAME . "_header_color",
            "title" => __('Header Background'),
            "desc" => __('The header color (on pages without background header image)', 'onepix_textdomain'),
            "type" => "text",
            "std" => "#121212",
            "class" => "allhtml"
        );
       
        $options[] = array(
            "section" => "color_section",
            "id" => ONEPIX_SHORTNAME . "_html_background_img",
            "title" => __('HTML Background Image'),
            "desc" => __('The optional HTML Background Image (if unboxed layout)', 'onepix_textdomain'),
            "type"    => "img",  
            "std"     => "http://yoursite.com/imageurl",
            "class"   => "url"
        );

        $options[] = array(
            "section" => "color_section",
            "id" => ONEPIX_SHORTNAME . "_html_background",
            "title" => __('HTML Background Color'),
            "desc" => __('The HTML Background (if unboxed layout)', 'onepix_textdomain'),
            "type" => "text",
            "std" => "#121212",
            "class" => "allhtml"
        );
        
        $options[] = array(  
            "section" => "color_section",  
            "id"      => ONEPIX_SHORTNAME . "_sitewide_img",  
            "title"   => __( 'Internal Page Featured Image', 'onepix_textdomain' ),  
            "desc"    => __( 'Enter the url for the default page featured image (shows if not set in the page options)', 'onepix_textdomain' ),  
            "type"    => "img",  
            "std"     => "http://yoursite.com/imageurl",
            "class"   => "url"  
        );

// Featured Area Settings 

        $options[] = array(
            "section" => "featured_section",
            "id" => ONEPIX_SHORTNAME . "_featured_area_type",
            "title" => __('Featured Area Type'),
            "desc" => __('What to use for the featured area', 'onepix_textdomain'),
            "type" => "select",
            "std" => "1",
            "choices" => array("image", "parallax image", "slider")
        );
        
        $options[] = array(
           "section" => "featured_section",  
           "id"      => ONEPIX_SHORTNAME . "_featured_title",  
           "title"   => __( 'Featured Title' ),  
           "desc"    => __( 'Enter featured area title', 'onepix_textdomain' ),  
           "type"    => "text",  
           "std"     => "Your Site Title",
           "class" => "text"
        );
         
         
        $options[] = array(
            "section" => "featured_section",  
            "id"      => ONEPIX_SHORTNAME . "_featured_tagline",  
            "title"   => __( 'Featured Tagline' ),  
            "desc"    => __( 'Enter featured area tagline (html/shortcodes allowed)', 'onepix_textdomain' ),  
            "type"    => "text",  
            "std"     => "What your site is all about",
            "class"   => "allhtml"
        );
        
        $options[] = array(  
            "section" => "featured_section",  
            "id"      => ONEPIX_SHORTNAME . "_featured_tagline_html",  
            "title"   => __( 'Featured Area Below Tagline HTML' ),  
            "desc"    => __( 'Optional HTML/shortcodes below the featured tagline', 'onepix_textdomain' ),  
            "type"    => "textarea",  
            "std"     => "Secondary tagline",
            "type"    => "textarea",
            "class"   => "allhtml"
        );
        
        $options[] = array(
            "section" => "featured_image_section",
            "id" => ONEPIX_SHORTNAME . "_featured_height",
            "title" => __('Featured Area Height'),
            "desc" => __('Enter your desired featured image or slider height in pixels', 'onepix_textdomain'),
            "type" => "text",
            "std" => "600",
            "class" => "numeric"
        );
        
        $options[] = array(
            "section" => "featured_section",
            "id" => ONEPIX_SHORTNAME . "_caption_margin",
            "title" => __('Featured Caption Top Margin'),
            "desc" => __('The featured caption distance from the top of the slider. ex: 33%', 'onepix_textdomain'),
            "type" => "text",
            "std" => "31%",
            "class" => "allhtml"
        );
        
        $options[] = array(  
            "section" => "featured_image_section",  
            "id"      => ONEPIX_SHORTNAME . "_home_featured_img",  
            "title"   => __( 'Featured Image', 'onepix_textdomain' ),  
            "desc"    => __( 'The featured image (at least 1500px wide for best results)', 'onepix_textdomain' ),  
            "type"    => "img",  
            "std"     => "http://yoursite.com/imageurl",
            "class"   => "url"  
        );
        
// Featured Slider Settings 
        
    $options[] = array(
        "section" => "featured_slider_section",
        "id" => ONEPIX_SHORTNAME . "_has_home_slider",
        "title" => __('Has Featured Area Slider', 'onepix_textdomain'),
        "desc" => __('Indicate whether to have a slider to replace the home page featured image', 'onepix_textdomain'),
        "type" => "checkbox",
        "std" => 0 // 0 for off  
    );

    $options[] = array(
        "section" => "featured_slider_section",
        "id" => ONEPIX_SHORTNAME . "_has_fixed_caption",
        "title" => __('Fixed Caption', 'onepix_textdomain'),
        "desc" => __('Have a non changing caption', 'onepix_textdomain'),
        "type" => "checkbox",
        "std" => 1 // 0 for off  
    );
    
    $options[] = array(
        "section" => "featured_slider_section",
        "id" => ONEPIX_SHORTNAME . "_slideshow_direction",
        "title" => __('Slideshow Direction'),
        "desc" => __('The direction the slideshow animates in', 'onepix_textdomain'),
        "type" => "select",
        "std" => "1",
        "choices" => array("horizontal", "vertical")
    );
    
    $options[] = array(
            "section" => "featured_slider_section",
            "id" => ONEPIX_SHORTNAME . "_slideshow_speed",
            "title" => __('Slider Speed'),
            "desc" => __('The frequency of slider transition in ms (larger numbers = longer wait)', 'onepix_textdomain'),
            "type" => "text",
            "std" => "7000",
            "class" => "numeric"
    );
    
    $options[] = array(
        "section" => "featured_slider_section",
        "id" => ONEPIX_SHORTNAME . "_animation_speed",
        "title" => __('Animation Speed'),
        "desc" => __('The speed of the animation during transition in ms (larger numbers = slower animation)', 'onepix_textdomain'),
        "type" => "text",
        "std" => "600",
        "class" => "numeric"
    );

    $options[] = array(
        "section" => "featured_slider_section",
        "id" => ONEPIX_SHORTNAME . "_animation_type",
        "title" => __('Slideshow Animation Type'),
        "desc" => __('The type of slideshow', 'onepix_textdomain'),
        "type" => "select",
        "std" => "1",
        "choices" => array("fade", "slide")
    );
    
    $options[] = array(
        "section" => "featured_slider_section",
        "id" => ONEPIX_SHORTNAME . "_animation_loop",
        "title" => __('Animation Loop', 'onepix_textdomain'),
        "desc" => __('Have the slideshow loop back to the start when finished', 'onepix_textdomain'),
        "type" => "checkbox",
        "std" => 1 // 0 for off  
    );


//Layout Settings
        
        $options[] = array(  
            "section" => "layout_section",  
            "id"      => ONEPIX_SHORTNAME . "_unboxed_layout",  
            "title"   => __( 'Unboxed Layout', 'onepix_textdomain' ),  
            "desc"    => __( 'Choose a contained or full width layout', 'onepix_textdomain' ),  
            "type"    => "checkbox",  
            "std"     => 1 // 0 for off  
        );  
        
        
        $options[] = array(  
            "section" => "layout_section",  
            "id"      => ONEPIX_SHORTNAME . "_blog_layout",
            "title"   => __( 'Blog Layout', 'onepix_textdomain' ),  
            "desc"    => __( 'Select blog layout style', 'onepix_textdomain' ),  
            "type"    => "select",  
            "std"    => "3",  
            "choices" => array( "Standard", "1 Columns", "2 Columns", "3 Columns", "Masonry")  
        );
        
        $options[] = array(
            "section" => "layout_section",
            "id" => ONEPIX_SHORTNAME . "_blog_sidebar",
            "title" => __('Blog Sidebar', 'onepix_textdomain'),
            "desc" => __('Show sidebar for blog pages. (Uncheck for full width)', 'onepix_textdomain'),
            "type" => "checkbox",
            "std" => 0 // 0 for off  
        );
        
        $options[] = array(
            "section" => "layout_section",
            "id" => ONEPIX_SHORTNAME . "_shop_sidebar",
            "title" => __('Shop Sidebar', 'onepix_textdomain'),
            "desc" => __('Show sidebar for shop pages. (Uncheck for full width)', 'onepix_textdomain'),
            "type" => "checkbox",
            "std" => 1 // 0 for off  
        );
        
        $options[] = array(
            "section" => "layout_section",
            "id" => ONEPIX_SHORTNAME . "_showcase_count",
            "title" => __('Showcase Item Count', 'onepix_textdomain'),
            "desc" => __('The number of items to display per page in the showcase area', 'onepix_textdomain'),
            "type" => "text",
            "std" => "6",
            "class" => "text"
        );

        $options[] = array(  
            "section" => "layout_section",  
            "id"      => ONEPIX_SHORTNAME . "_has_subfooter",  
            "title"   => __( 'Subfooter', 'onepix_textdomain' ),  
            "desc"    => __( 'Show Subfooter', 'onepix_textdomain' ),  
            "type"    => "checkbox",  
            "std"     => 1 // 0 for off  
        );
        
// Social Media links
        
        $options[] = array(
            "section" => "socials_section",
            "id" => ONEPIX_SHORTNAME . "_socials_size",
            "title" => __('Social Icon Size', 'onepix_textdomain'),
            "desc" => __('The default size for all social icons)', 'onepix_textdomain'),
            "type" => "select",
            "std" => "1",
            "choices" => array("Large", "Small")
        );
        
        $options[] = array(
            "section" => "socials_section",
            "id" => ONEPIX_SHORTNAME . "_socials_shape",
            "title" => __('Social Icon Shape', 'onepix_textdomain'),
            "desc" => __('The default shape for all social icons)', 'onepix_textdomain'),
            "type" => "select",
            "std" => "1",
            "choices" => array("Round", "Square")
        );
    
        $options[] = array(
            "section" => "socials_section",
            "id" => ONEPIX_SHORTNAME . "_socials_color",
            "title" => __('Social Icon Color', 'onepix_textdomain'),
            "desc" => __('The default color scheme for all social icons)', 'onepix_textdomain'),
            "type" => "select",
            "std" => "1",
            "choices" => array("Greyscale", "Color", "Icon-Only")
        );

    $options[] = array(  
            "section" => "socials_section",  
            "id"      => ONEPIX_SHORTNAME . "_facebook_url_input",  
            "title"   => __( 'Facebook link URL', 'onepix_textdomain' ),  
            "desc"    => __( 'Enter the url for your Facebook page (leave blank for none)', 'onepix_textdomain' ),  
            "type"    => "text",  
            "std"     => "http://facebook.com",
            "class"   => "url"  
        ); 
        
    $options[] = array(  
            "section" => "socials_section",  
            "id"      => ONEPIX_SHORTNAME . "_twitter_url_input",  
            "title"   => __( 'Twitter link URL', 'onepix_textdomain' ),  
            "desc"    => __( 'Enter the url for your Twitter page (leave blank for none)', 'onepix_textdomain' ),  
            "type"    => "text",  
            "std"     => "http://twitter.com",
            "class"   => "url"
        ); 

    $options[] = array(  
            "section" => "socials_section",  
            "id"      => ONEPIX_SHORTNAME . "_linkedin_url_input",  
            "title"   => __( 'Linkedin link URL', 'onepix_textdomain' ),  
            "desc"    => __( 'Enter the url for your Linkedin page (leave blank for none)', 'onepix_textdomain' ),  
            "type"    => "text",  
            "std"     => "http://linkedin.com",
            "class"   => "url"  
        ); 

    $options[] = array(  
            "section" => "socials_section",  
            "id"      => ONEPIX_SHORTNAME . "_pinterest_url_input",  
            "title"   => __( 'Pinterest link URL', 'onepix_textdomain' ),  
            "desc"    => __( 'Enter the url for your Pinterest page (leave blank for none)', 'onepix_textdomain' ),  
            "type"    => "text",  
            "std"     => "http://pinterest.com",
            "class"   => "url"  
        ); 

    $options[] = array(  
            "section" => "socials_section",  
            "id"      => ONEPIX_SHORTNAME . "_googleplus_url_input",  
            "title"   => __( 'Google+ link URL', 'onepix_textdomain' ),  
            "desc"    => __( 'Enter the url for your Google+ page (leave blank for none)', 'onepix_textdomain' ),  
            "type"    => "text",  
            "std"     => "http://googleplus.com",
            "class"   => "url"  
        ); 

    $options[] = array(  
            "section" => "socials_section",  
            "id"      => ONEPIX_SHORTNAME . "_instagram_url_input",  
            "title"   => __( 'Instagram link URL', 'onepix_textdomain' ),  
            "desc"    => __( 'Enter the url for your Instagram page (leave blank for none)', 'onepix_textdomain' ),  
            "type"    => "text",  
            "std"     => "http://instagram.com",
            "class"   => "url"  
        );

    $options[] = array(
        "section" => "socials_section",
        "id" => ONEPIX_SHORTNAME . "_youtube_url_input",
        "title" => __('Youtube link URL', 'onepix_textdomain'),
        "desc" => __('Enter the url for your Youtube page (leave blank for none)', 'onepix_textdomain'),
        "type" => "text",
        "std" => "http://youtube.com",
        "class" => "url"
        );
    
// Contact settings
    
    
    $options[] = array(
            "section" => "contact_section",
            "id" => ONEPIX_SHORTNAME . "_has_googlemap",
            "title" => __('Google Map', 'onepix_textdomain'),
            "desc" => __('Show a Google map on the contact page', 'onepix_textdomain'),
            "type" => "checkbox",
            "std" => 1 // 0 for off  
        );

    $options[] = array(
        "section" => "contact_section",
        "id" => ONEPIX_SHORTNAME . "_googlemap_address",
        "title" => __('Your Address', 'onepix_textdomain'),
        "desc" => __('Enter your address for the contact page google map', 'onepix_textdomain'),
        "type" => "text",
        "std" => "490 E Main Street Norwich CT 06360",
        "class" => "text"
        );

    $options[] = array(
        "section" => "contact_section",
        "id" => ONEPIX_SHORTNAME . "_googlemap_latitude",
        "title" => __('Google Map Latitude', 'onepix_textdomain'),
        "desc" => __('Enter the latitude of your location. More info at <a target="_blank" alt="google maps help" href="https://support.google.com/maps/answer/18539?hl=en">Google Maps Help</a>', 'onepix_textdomain'),
        "type" => "text",
        "std" => "53.80583",
        "class" => "text"
        );

    $options[] = array(
        "section" => "contact_section",
        "id" => ONEPIX_SHORTNAME . "_googlemap_longitude",
        "title" => __('Google Map Longitude', 'onepix_textdomain'),
        "desc" => __('Enter the longitude of your location', 'onepix_textdomain'),
        "type" => "text",
        "std" => "-1.548903",
        "class" => "text"
        );



// Text Form Fields section  
//        $options[] = array(  
//            "section" => "txt_section",  
//            "id"      => ONEPIX_SHORTNAME . "_txt_input",  
//            "title"   => __( 'Text Input - Some HTML OK!', 'onepix_textdomain' ),  
//            "desc"    => __( 'A regular text input field. Some inline HTML (<a>, <b>, <em>, <i>, <strong>) is allowed.', 'onepix_textdomain' ),  
//            "type"    => "text",  
//            "std"     => __('<h1>Html</h1> and text','onepix_textdomain')  
//        );  
//          
//        $options[] = array(  
//            "section" => "txt_section",  
//            "id"      => ONEPIX_SHORTNAME . "_nohtml_txt_input",  
//            "title"   => __( 'No HTML!', 'onepix_textdomain' ),  
//            "desc"    => __( 'A text input field where no html input is allowed.', 'onepix_textdomain' ),  
//            "type"    => "text",  
//            "std"     => __('Some plsin text','onepix_textdomain'),
//            "class"   => "nohtml"  
//        );  
//          
//        $options[] = array(  
//            "section" => "txt_section",  
//            "id"      => ONEPIX_SHORTNAME . "_numeric_txt_input",  
//            "title"   => __( '12345', 'onepix_textdomain' ),  
//            "desc"    => __( 'A text input field where only numeric input is allowed.', 'onepix_textdomain' ),  
//            "type"    => "text",  
//            "std"     => "123",  
//            "class"   => "numeric"  
//        );  
//          
//        $options[] = array(  
//            "section" => "txt_section",  
//            "id"      => ONEPIX_SHORTNAME . "_multinumeric_txt_input",  
//            "title"   => __( 'Multinumeric Input', 'onepix_textdomain' ),  
//            "desc"    => __( 'A text input field where only multible numeric input (i.e. comma separated numeric values) is allowed.', 'onepix_textdomain' ),  
//            "type"    => "text",  
//            "std"     => "123,234,345",  
//            "class"   => "multinumeric"  
//        );  
//          
//        $options[] = array(  
//            "section" => "txt_section",  
//            "id"      => ONEPIX_SHORTNAME . "_url_txt_input",  
//            "title"   => __( 'URL Input', 'onepix_textdomain' ),  
//            "desc"    => __( 'A text input field which can be used for urls.', 'onepix_textdomain' ),  
//            "type"    => "text",  
//            "std"     => "http://www.website.com",  
//            "class"   => "url"  
//        );  
//          
//        $options[] = array(  
//            "section" => "txt_section",  
//            "id"      => ONEPIX_SHORTNAME . "_email_txt_input",  
//            "title"   => __( 'Email Input', 'onepix_textdomain' ),  
//            "desc"    => __( 'A text input field which can be used for email input.', 'onepix_textdomain' ),  
//            "type"    => "text",  
//            "std"     => "email@email.com<script type=\"text/javascript\">  /* <![CDATA[ */ (function(){try{var s,a,i,j,r,c,l,b=document.getElementsByTagName(\"script\");l=b[b.length-1].previousSibling;a=l.getAttribute('data-cfemail');if(a){s='';r=parseInt(a.substr(0,2),16);for(j=2;a.length-j;j+=2){c=parseInt(a.substr(j,2),16)^r;s+=String.fromCharCode(c);}s=document.createTextNode(s);l.parentNode.replaceChild(s,l);}}catch(e){}})(); /* ]]> */ </script>",  
//            "class"   => "email"  
//        );  
//          
//        $options[] = array(  
//            "section" => "txt_section",  
//            "id"      => ONEPIX_SHORTNAME . "_multi_txt_input",  
//            "title"   => __( 'Multi-Text Inputs', 'onepix_textdomain' ),  
//            "desc"    => __( 'A group of text input fields', 'onepix_textdomain' ),  
//            "type"    => "multi-text",  
//            "choices" => array( __('Text input 1','onepix_textdomain') . "|txt_input1", __('Text input 2','onepix_textdomain') . "|txt_input2", __('Text input 3','onepix_textdomain') . "|txt_input3", __('Text input 4','onepix_textdomain') . "|txt_input4"),  
//            "std"     => ""  
//        );  
//          
//        // Textarea Form Fields section  
//        $options[] = array(  
//            "section" => "txtarea_section",  
//            "id"      => ONEPIX_SHORTNAME . "_txtarea_input",  
//            "title"   => __( 'Textarea - HTML OK!', 'onepix_textdomain' ),  
//            "desc"    => __( 'A textarea for a block of text. HTML tags allowed!', 'onepix_textdomain' ),  
//            "type"    => "textarea",  
//            "std"     => __('Some default value','onepix_textdomain')  
//        );  
//      
//        $options[] = array(  
//            "section" => "txtarea_section",  
//            "id"      => ONEPIX_SHORTNAME . "_nohtml_txtarea_input",  
//            "title"   => __( 'No HTML!', 'onepix_textdomain' ),  
//            "desc"    => __( 'A textarea for a block of text. No HTML!', 'onepix_textdomain' ),  
//            "type"    => "textarea",  
//            "std"     => __('Some default value','onepix_textdomain'),  
//            "class"   => "nohtml"  
//        );  
//          
//        $options[] = array(  
//            "section" => "txtarea_section",  
//            "id"      => ONEPIX_SHORTNAME . "_allowlinebreaks_txtarea_input",  
//            "title"   => __( 'No HTML! Line breaks OK!', 'onepix_textdomain' ),  
//            "desc"    => __( 'No HTML! Line breaks allowed!', 'onepix_textdomain' ),  
//            "type"    => "textarea",  
//            "std"     => __('Some default value','onepix_textdomain'),  
//            "class"   => "allowlinebreaks"  
//        );  
//      
//        $options[] = array(  
//            "section" => "txtarea_section",  
//            "id"      => ONEPIX_SHORTNAME . "_inlinehtml_txtarea_input",  
//            "title"   => __( 'Some Inline HTML ONLY!', 'onepix_textdomain' ),  
//            "desc"    => __( 'A textarea for a block of text.  
//                Only some inline HTML  
//                (<a>, <b>, <em>, <strong>, <abbr>, <acronym>, <blockquote>, <cite>, <code>, <del>, <q>, <strike>)   
//                is allowed!', 'onepix_textdomain' ),  
//            "type"    => "textarea",  
//            "std"     => __('Some default value','onepix_textdomain'),  
//            "class"   => "inlinehtml"  
//        );    
//          
//        // Select Form Fields section  
//        $options[] = array(  
//            "section" => "select_section",  
//            "id"      => ONEPIX_SHORTNAME . "_select_input",  
//            "title"   => __( 'Select (type one)', 'onepix_textdomain' ),  
//            "desc"    => __( 'A regular select form field', 'onepix_textdomain' ),  
//            "type"    => "select",  
//            "std"    => "3",  
//            "choices" => array( "1", "2", "3")  
//        );  
//          
//        $options[] = array(  
//            "section" => "select_section",  
//            "id"      => ONEPIX_SHORTNAME . "_select2_input",  
//            "title"   => __( 'Select (type two)', 'onepix_textdomain' ),  
//            "desc"    => __( 'A select field with a label for the option and a corresponding value.', 'onepix_textdomain' ),  
//            "type"    => "select2",  
//            "std"    => "",  
//            "choices" => array( __('Option 1','onepix_textdomain') . "|opt1", __('Option 2','onepix_textdomain') . "|opt2", __('Option 3','onepix_textdomain') . "|opt3", __('Option 4','onepix_textdomain') . "|opt4")  
//        );  
//          
//        // Checkbox Form Fields section  
//        $options[] = array(  
//            "section" => "checkbox_section",  
//            "id"      => ONEPIX_SHORTNAME . "_checkbox_input",  
//            "title"   => __( 'Checkbox', 'onepix_textdomain' ),  
//            "desc"    => __( 'Some Description', 'onepix_textdomain' ),  
//            "type"    => "checkbox",  
//            "std"     => 1 // 0 for off  
//        );  
//          
//        $options[] = array(  
//            "section" => "checkbox_section",  
//            "id"      => ONEPIX_SHORTNAME . "_multicheckbox_inputs",  
//            "title"   => __( 'Multi-Checkbox', 'onepix_textdomain' ),  
//            "desc"    => __( 'Some Description', 'onepix_textdomain' ),  
//            "type"    => "multi-checkbox",  
//            "std"     => '',  
//            "choices" => array( __('Checkbox 1','onepix_textdomain') . "|chckbx1", __('Checkbox 2','onepix_textdomain') . "|chckbx2", __('Checkbox 3','onepix_textdomain') . "|chckbx3", __('Checkbox 4','onepix_textdomain') . "|chckbx4")    
//        );  
          
        return $options;      
    }
    
    
 /* ------------------------------------------------------------------------ *
 * Contextual Help
 * ------------------------------------------------------------------------ */ 
    
    function onepix_options_page_contextual_help() {  
      
    $settings = array(
        'id'	=> 'onepix_help_tab',
        'title'	=> __('One Pixel Help'),
        'content' => '<p>' . __( 'Descriptive content that will show in My Help Tab-body goes here.' ) . '</p>',
    );    

    // return text  
    return $settings;  
}
?>