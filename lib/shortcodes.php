<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
//this will remove extra p and br tags normally between shortcodes
remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop' , 12);
//section header shortcode [sectionheader title="Section Header Title" class=myclass]
function onepix_shortcode_sectionheader($atts, $content = null) {
	extract(shortcode_atts(array(
            "title" => '',
            "class" => ''
	), $atts));
	
        $sectionheader = '<div class="sectionHeader ' . $class . '"><div class="sectionHeadingWrap"><div class="sectionHeading-container"><span class="sectionHeading-before"></span><div class="sectionHeading">' . $title . '</div><span class="sectionHeading-after"></span></div></div></div>';
        return $sectionheader;
        
//        <div class="sectionHeading-container">
//            <span class="sectionHeading-before"></span>
//            <div class="sectionHeading">
//                <h4>Pick one and find out</h4>
//            </div>
//            <span class="sectionHeading-after"></span>
//        </div>
}
add_shortcode('sectionheader', 'onepix_shortcode_sectionheader');
//icon shortcode [icon-fa img=pencil size=med circle=true style=solid border=true]
function onepix_shortcode_icon_fa($atts, $content = null) {
	extract(shortcode_atts(array(
		"img" => 'pencil',
                "size" => 'med',
                "circle" => 'false',
                "style" => 'solid',
                "color" => '#5e5e5e',
                "border" => 'false'
	), $atts));
	
        $icon = '';
        $icon_color = $color;
        if ($style == "solid" || $style == "border") {
            $icon_color = "#fff";
        }
        if ($circle == "true") {
            $icon = '<div class="icon-border-' . $border . '" style="border-color:' . $color .';"><span class="icon-circle icon-' . $size . ' ' . $style . '" style="color:' . $icon_color . '; background-color: ' . $color . '; border-color:' . $color . '"><i class="fa fa-' . $img . '"></i></span></div>';
        } else { 
            $icon = '<i class="icon-' . $size . ' fa fa-' . $img . '"></i>';
        }
        return $icon;
}
add_shortcode('icon-fa', 'onepix_shortcode_icon_fa');
//icon list shortcode [icon-fa-list][/icon-fa-list]
function onepix_shortcode_icon_fa_list( $atts, $content = null ) {
        //do_shortcode() permits other shortcode to be allowed within this shortcode
        return '<ul class="fa-ul">' . do_shortcode($content) . '</ul>'; 
}
add_shortcode( 'icon-fa-list', 'onepix_shortcode_icon_fa_list' );
//icon list item shortcode [icon-fa-li img=check]List item 1[/icon-fa-li] (to go within [icon-fa-list][/icon-fa-list])
function onepix_shortcode_icon_fa_li($atts, $content = null) {
    extract(shortcode_atts(array(
        "img" => ''
                    ), $atts));
    return '<li><i class="fa-li fa fa-'. $img .'"></i>' . $content . '</li>'; 
}
add_shortcode('icon-fa-li', 'onepix_shortcode_icon_fa_li');
//spacer shortcode [spacer size=med]
function onepix_shortcode_spacer($atts, $content = null) {
	extract(shortcode_atts(array(
		"size" => ''
	), $atts));
        if($size) {
            $spacer = '<div class="spacer-' . $size . '"></div>';
        } else {
            $spacer = '<div class="spacer"></div>';
        }
        
        return $spacer;
}
add_shortcode('spacer', 'onepix_shortcode_spacer');
//socials shortcode [socials]
function onepix_shortcode_socials($atts, $content = null) {
    //must use get_template_part this way in shortcode since normally it just echoes content where called
    ob_start();  
    get_template_part( 'temp', 'socials' );
    $ret = ob_get_contents();
    ob_end_clean();
    return $ret;
}
add_shortcode('socials', 'onepix_shortcode_socials');
//imagebox shortcode [imagebox title="title" linkurl="yourlinkurl.com image=images/area-commercial-img.png" class=myclass]some filler content here...[/imagebox]
function onepix_shortcode_imagebox( $atts, $content = null ) {
    	extract(shortcode_atts(array(
            "title" => '',
            "image" => '',
            "linkurl" => '',
            "class" => ''
	), $atts));
        //do_shortcode() permits other shortcode to be allowed within this shortcode
        
        $imagebox = '<div class="imgbox-call-action ' . $class . '">
            <img src="' . $image . '" /><div class="imbox-content"><div class="caption">' . esc_attr($title) . '</div><div class="clear"></div>' . do_shortcode($content) . '</div><div class="clear"></div>
            <a href="' . $linkurl . '" class="read-more">Learn More &rarr;</a><div class="clear"></div></div>';
        
//        esc_attr($size);
        return $imagebox;
}
add_shortcode( 'imagebox', 'onepix_shortcode_imagebox' );
//brandbox shortcode [brandbox title="title" linkurl="yourlinkurl.com image=images/area-commercial-img.png" class=myclass]some filler content here...[/brandbox]
function onepix_shortcode_brandbox( $atts, $content = null ) {
    	extract(shortcode_atts(array(
            "title" => '',
            "image" => '',
            "linkurl" => '',
            "class" => ''
	), $atts));
        //do_shortcode() permits other shortcode to be allowed within this shortcode
        
        $titleNoSpaces =  preg_replace('/[^a-z]/', '', strtolower($title));
        
        $imagebox = '<div id="brand-' . $titleNoSpaces .'" class="brandbox-call-action ' . $class . '">
            <img src="' . $image . '" /> <div class="content-container"><div class="caption center">' . esc_attr($title) . '</div><div class="clear"></div>
            <div class="brandbox-content">' . do_shortcode($content) . '</div><div class="clear"></div>
            <div class="brandbox-learnmore"><a target="_blank" href="' . $linkurl . '" class="learnmore">Visit the ' . esc_attr($title) . ' Website &rsaquo;</a><div class="clear"></div></div></div></div>';
        
//        esc_attr($size);
        return $imagebox;
}
add_shortcode( 'brandbox', 'onepix_shortcode_brandbox' );
//infobox shortcode [infobox title="Infobox Title" class=myclass]some filler content here...[/infobox]
function onepix_shortcode_infobox( $atts, $content = null ) {
    	extract(shortcode_atts(array(
            "title" => '',
            "class" => ''
	), $atts));
        //do_shortcode() permits other shortcode to be allowed within this shortcode
        $infobox = '<div class="infobox  ' . $class . '">
            <div class="title">' . esc_attr($title) . '</div><div class="clear"></div>
            <div class="infobox-content">' . do_shortcode($content) . '</div><div class="clear"></div></div>';
        
//        esc_attr($size);
        return $infobox;
}
add_shortcode( 'infobox', 'onepix_shortcode_infobox' );
//row shortcode [row class="custom-class"]
function onepix_shortcode_row( $atts, $content = null ) {
    	extract(shortcode_atts(array(
		"class" => ''
	), $atts));
        //do_shortcode() permits other shortcode to be allowed within this shortcode
        return '<div class="row ' . esc_attr($class) . '">' . do_shortcode($content) . '</div>'; 
}
add_shortcode( 'row', 'onepix_shortcode_row' );
//columns shortcode [column size=large spaces=6 class="custom-class"]
function onepix_shortcode_column( $atts, $content = null ) {
    	extract(shortcode_atts(array(
            "size" => '',
            "spaces" => '',
            "class" => ''
	), $atts));
        //do_shortcode() permits other shortcode to be allowed within this shortcode
        return '<div class="' . esc_attr($size) . '-' . esc_attr($spaces) . ' columns ' . esc_attr($class) . '">' . do_shortcode($content) . '</div>'; 
}
add_shortcode( 'column', 'onepix_shortcode_column' );
//row_nest1 shortcode [row class="custom-class"]
function onepix_shortcode_row_nest1( $atts, $content = null ) {
    	extract(shortcode_atts(array(
		"class" => ''
	), $atts));
        //do_shortcode() permits other shortcode to be allowed within this shortcode
        return '<div class="row ' . esc_attr($class) . '">' . do_shortcode($content) . '</div>'; 
}
add_shortcode( 'row_nest1', 'onepix_shortcode_row_nest1' );
//column_nest1 shortcode - must make different name for shortcode parser [column size=large spaces=6 class="custom-class"]
function onepix_shortcode_column_nest1( $atts, $content = null ) {
    	extract(shortcode_atts(array(
            "size" => '',
            "spaces" => '',
            "class" => ''
	), $atts));
        //do_shortcode() permits other shortcode to be allowed within this shortcode
        return '<div class="' . esc_attr($size) . '-' . esc_attr($spaces) . ' columns ' . esc_attr($class) . '">' . do_shortcode($content) . '</div>'; 
}
add_shortcode( 'column_nest1', 'onepix_shortcode_column_nest1' );
//grid shortcode [grid small_block=1 medium_block=2] (for images in grid)
function onepix_shortcode_grid($atts, $content = null) {
    	extract(shortcode_atts(array(
            "small_block" => '',
            "medium_block" => '',
            "class" => ''
	), $atts));
    //do_shortcode() permits other shortcode to be allowed within this shortcode
    return '<ul class="small-block-grid-' . esc_attr($small_block) . ' medium-block-grid-' . esc_attr($medium_block) . '">' . do_shortcode($content) . '</ul>';
}
add_shortcode('grid', 'onepix_shortcode_grid');
//griditem shortcode [griditem imgurl=http://1pixeldesign.com/dev/wordpress2/wp-content/uploads/2014/07/545X545.jpg link=# caption="Sample Caption"] (items in grid)
function onepix_shortcode_griditem($atts) {
    
    extract(shortcode_atts(array(
        "imgurl" => DEFAULT_IMG_545,
        "link" => '#',
        "caption" => ''
    ), $atts));
    
    $output = '<li><div class = "cat-header-wrapper"><a title="' . $caption . '" href="' . $link . '"><img alt="' . $caption . '" class="attachment-post-thumbnail wp-post-image" src="' . $imgurl . '"></a>';
    if ($caption) {
        $output .= '<div class="cat-header"><a href="' . $link . '" title="' . $caption . '">' . $caption . '</a></div>'; 
    } else {
    }
    $output .= '</div></li>';
    
    return $output;
}
add_shortcode('griditem', 'onepix_shortcode_griditem');
//antispam email display shortcode [email] or [email email="you@youremaildomain.com"]
function onepix_shortcode_antispamemail( $atts, $content = null ) {
    	extract(shortcode_atts(array(
            "email" => ''
	), $atts));
        //use the built in antispambot in wordpress
        if($email) {
            //return provided emal address protected
            return antispambot($email);
        } else {
            //return admin emal address protected
            return antispambot(get_the_author_email());
        }
        
         
}
add_shortcode( 'email', 'onepix_shortcode_antispamemail' );
//content parallax caption shortcode [plaxcaption imgurl=http://yourimgurl.com buttontext=sometext link=http://thelink.com offset=1000]
function onepix_shortcode_plaxcaption( $atts, $content = null ) {
extract(shortcode_atts(array(
    "imgurl" => get_bloginfo('template_directory') . '/images/default-parallax-image.jpg',
    "buttontext" => 'Check Out Our Progress',
    "link" => '#',
    "offset" => '0',
), $atts));
//if(!$imgurl) {
//    $imgurl = get_bloginfo('template_directory') . '/images/default-parallax-image.jpg';
//}
//if(!$buttontext) {
//    $buttontext = 'Check Out Our Progress';   
//}
//if(!$link) {
//    $link = '#';
//}
return '<div class="full-width-img full-width-img-content plax-img" data-stellar-background-ratio="0.5" data-stellar-vertical-offset="' .  $offset .'" style="background: url(' . $imgurl . ');">
    <a href="' . $link . '" class="plax-img-button">' . $buttontext . '</a>
</div>';
}
add_shortcode( 'plaxcaption', 'onepix_shortcode_plaxcaption' );
//circle image shortcode [circleimage imgurl=http://yourimgurl.com align=right has_hovericon=true hovericon=fa-chevron-circle-right link=http://thelink.com caption=yourcaption]
function onepix_shortcode_circleimage( $atts, $content = null ) {
extract(shortcode_atts(array(
    "imgurl" => DEFAULT_IMG_545,
    "align" => '',
    "has_hovericon" => 'true',
    "hovericon" => 'fa-arrow-circle-right',
    "link" => '#',
    "caption" => '',
    "class" => '',
   ), $atts));
    $output = '';
    
    $caption_display = '';
    if ($caption) {
        $caption_display = '<div class="circle-caption"><div class="caption-info-sml">' . $caption . '</div></div>';
    }
    if($has_hovericon == 'true') {
        $output = '<div class="circle-container ' . $align . ' ' . $class . '">
            <div class="circle-wrapper">
                <div class="circle-padding">
                <div class="circle-img" style="background-image: url(' . $imgurl . ')"></div>
                <div class="circle-content">
                    <div class="circle-content-center">
                        <a href="' . $link . '"><i class="fa ' . $hovericon . '"></i></a>
                    </div>
                </div></div></div>' . $caption_display . '</div>';
    } else {
        
        $output = '<div class="circle-container ' . $align . ' ' . $class . '">
            <div class="circle-wrapper">
                <div class="circle-padding">
                <div class="circle-img" style="background-image: url(' . $imgurl . ')"></div></div>
            </div>' . $caption_display . '</div>';
        
        
    }
    
    
    return $output;
}
add_shortcode( 'circleimage', 'onepix_shortcode_circleimage' );
//Tabs Container [tabsholder class=myclass]...[/tabsholder]
function onepix_shortcode_tabsholder( $atts, $content = null ) {
    extract( shortcode_atts( array(
        "class" => ''
    ), $atts ) );
    
    preg_match_all( '/tab title="([^\"]+)"/i', $content, $matche, PREG_OFFSET_CAPTURE );
    $tab_title = array();
    if( isset($matche[1]) ) {
        $tab_title = $matche[1];
    }
    $output = '';
    if( count($tab_title) ) {
        $output .= '<div class="onepix-tabs ' . $class . '" id="tabs">';
        $output .= '<ul class="nav clearfix">';
        foreach( $tab_title as $tab ){
            $output .= '<li><a href="#tabs-'. sanitize_title( $tab[0] ) .'">' . $tab[0] . '</a></li>';
        }
        $output .= '</ul>' . do_shortcode( $content ) . '</div>';
    } else {
        $output .= do_shortcode( $content );
    }
    return $output;
}
add_shortcode( 'tabsholder', 'onepix_shortcode_tabsholder' );
//Tab [tab title="yourtitle" class=myclass]Content[/tab] (goes inside [tabsholder]...[/tabsholder])
function onepix_shortcode_tab( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'title' => '',
        "class" => ''
    ), $atts ) );
    return '<div id="tabs-'. sanitize_title( $title ) .'"><div class="tabcontent ' . $class . '">'. do_shortcode( $content ) .'</div></div>';
}
add_shortcode( 'tab', 'onepix_shortcode_tab' );
//Accordion Section [accordion_section title="yourtitle" class=myclass]Content[/accordion_section] (goes inside [accordion]...[/accordion])
function onepix_shortcode_accordion_section( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'title' => '',
        "class" => ''
    ), $atts ) );
    return '<div class="accordion-section ' . $class . '"><h3>'. $title .'</h3><div class="accordion-content">'. do_shortcode( $content ) .'</div></div>';
}
add_shortcode( 'accordion_section', 'onepix_shortcode_accordion_section' );
//Accordion [accordion class=myclass]...[/accordion]
function onepix_shortcode_accordion( $atts, $content = null ) {
    extract(shortcode_atts(array(
    "class" => ''
                ), $atts));
    return '<div class="onepix-accordion ' . $class . '">'. do_shortcode( $content ) .'</div>';
}
add_shortcode( 'accordion', 'onepix_shortcode_accordion' );
//Content Block [content_block class=myclass]...[/content_block]
function onepix_shortcode_content_block( $atts, $content = null ) {
    extract(shortcode_atts(array(
        "class" => ''
                    ), $atts));
    
    return '<div class="content-block ' . $class . '">'. do_shortcode( $content ) .'</div>';
}
add_shortcode( 'content_block', 'onepix_shortcode_content_block' );
//Button [button title="Shadow Button" link=# size=medium color=dark style=solid-shadow icon=fa-angle-double-right class=myclass]
function onepix_shortcode_button( $atts, $content = null ) {
extract(shortcode_atts(array(
    "title" => 'Read More',
    "link" => '#',
    "size" => 'medium',
    "color" => '#121212',
    "color_hover" => '',
    "style" => 'solid',
    "class" => '',
    "icon" => ''
), $atts));
$fa_icon_element = '';
$has_icon = '';
if($icon !== '') {
    $fa_icon_element = '<i class="fa ' . $icon . '"></i>';
}
if ($icon !== '') {
    $has_icon = 'has-icon';
}
if($style == 'outline') {
    return '<a data-color=' . $color . ' style="color:' . $color . '; box-shadow: inset 0 0 0 2px ' . $color . '; -moz-box-shadow: inset 0 0 0 2px ' . $color . '; -webkit-box-shadow: inset 0 0 0 2px ' . $color . ';" class="btn ' . $has_icon . ' ' . $style . ' ' . $size . ' ' . $class . '" href="' . $link . '"  data-color_hover=' . $color_hover . '>' . $title . $fa_icon_element . '</a>';
} else {
    return '<a style="background-color:' . $color . ';" class="btn ' . $has_icon . ' ' . $style . ' ' . $size . ' ' . $class . '" href="' . $link . '">' . $title . $fa_icon_element . '</a>';
}
}
add_shortcode( 'button', 'onepix_shortcode_button' );
//Dividers [divider style="double" class=myclass]
function onepix_shortcode_divider( $atts, $content = null ) {
extract(shortcode_atts(array(
    "style" => 'double',
    "class" => ''
), $atts));
return '<div class="divider ' . $style . ' ' . $class . '"></div>';
}
add_shortcode( 'divider', 'onepix_shortcode_divider' );
//Large Text [large class="center"]
function onepix_shortcode_large($atts, $content = null) {
        extract(shortcode_atts(array(
        "class" => '',
                    ), $atts));
    return '<p class="large ' . $class . '">' . do_shortcode( $content ) . '</p>';
}
add_shortcode('large', 'onepix_shortcode_large');
//Highlighted Text [highlight link=http://youlink.com class=myclass]
function onepix_shortcode_highlight($atts, $content = null) {
    
    extract(shortcode_atts(array(
        "link" => '',
        "class" => ''
                    ), $atts));
    
    if (!$link) {
        return '<span class="highlight ' . $class . '">' . do_shortcode( $content ) . '</span>';
    } else {
        return '<a class="highlight ' . $class . '" href="' . $link . '">' . do_shortcode( $content ) . '</a>';
    }
}
add_shortcode('highlight', 'onepix_shortcode_highlight');
//Custom Headings [heading style=divider divider=large size=3 class=myclass]Heading With Divider[/heading] (size: 1, 2, 3 = h1, h2, h3)
function onepix_shortcode_heading( $atts, $content = null ) {
extract(shortcode_atts(array(
    "style" => 'underline',
    "divider" => 'dotted',
    "size" => '3',
    "class" => ''
), $atts));
$output = '';
if($style == "underline") {
    $output = '<div class="underline-divider-wrapper center ' . $class . '"><h' . $size . '>' . $content . '</h' . $size . '>
<div class="divider ' . $divider . '"></div></div>';
} elseif($style == "divider") {
    $output = '<div class="heading-divider-wrapper ' . $class . '">
<h' . $size . ' class="divider-heading">' . $content . '</h' . $size . '>
<div class="divider-container">
<div class="heading-divider divider ' . $divider . '"></div>
</div>
</div>';
} elseif($style == "linethrough") {
        $output = '<div class="linethrough-header-container ' . $class . '">
<h' . $size . ' class="linethrough-heading">' . $content . '</h' . $size . '>
</div>';
} elseif ($style == "lineafter") {
        $output = '<div class="lineafter-header-container ' . $class . '">
<h' . $size . ' class="lineafter-heading">' . $content . '</h' . $size . '>
</div>';
    }
    return $output;
}
add_shortcode( 'heading', 'onepix_shortcode_heading' );
//Single Testimonial [testimonial random=true id=5 class=myclass title="What folks are saying"]
function onepix_shortcode_testimonial( $atts, $content = null ) {
extract(shortcode_atts(array(
    "title" => 'What they are saying about us',
    "random" => 'true',
    "id" => '',
    "class" => ''
), $atts));
$output = '';
    $output = '<div class="caption-bubble-wrapper"><div class="testimoinal quote-sml ' . $class . '"><h3>' . $title . '</h3>';
        $post_type = 'onepix_testimonial';
        
        if ($random == "true") {
            //wp-query (random)
            $the_query = new WP_Query(
                array(
                    'post_type' => $post_type,
                    'orderby' => 'rand',
                    'posts_per_page' => '1'
                )
            );
        } else {
             //wp-query (specific)
            $the_query = new WP_Query(
                array(
                    'post_type' => $post_type,
                    'p' => $id,
                    'posts_per_page' => '1'
                )
            );
        }
    // The Loop
        while ( $the_query->have_posts() ) : $the_query->the_post();
            $output .= '<p>' . get_the_content() . '</p>';
            $output .= '<p class="quote-sml author">' . esc_attr(get_the_title()) . ' | <a href="' . get_post_type_archive_link( $post_type ) . '">view all</a></p>';
            
        endwhile;
        wp_reset_query();
        
    $output .= '</div><div class="tail"></div></div>';
    
    return $output;
}
add_shortcode( 'testimonial', 'onepix_shortcode_testimonial' );
//Slider [slider style=slider class=myclass]..slides shortcodes go here[/slider] syles: slider, carousel
function onepix_shortcode_slider( $atts, $content = null ) {
extract(shortcode_atts(array(
    "style" => 'slider',
    "class" => ''
), $atts));
$output = '';
$openning_div = '<div class="flexslider slider ' . $class . '">';
if ($style == 'carousel') {
    $openning_div = '<div class="flexslider carousel">';
}
    $output .= $openning_div;
    $output .= '<ul class="slides">';
    $output .= do_shortcode($content);
    $output .= '</ul></div>';
    
    return $output;
}
add_shortcode( 'slider', 'onepix_shortcode_slider' );
//Slide [slide img=imgurl.jpg link=linkurl.com alt="your alt text"]
function onepix_shortcode_slide($atts, $content = null) {
    
    $default_img = get_bloginfo('template_directory') . '/images/default-image-935x523.jpg';
    
    extract(shortcode_atts(array(
            "img" => $default_img,
            "link" => '#',
            "alt" => ''
        ), $atts));
    $output = '<li><a href="' . $link . '"><img src="' . $default_img . '" alt="' . $alt . '" /></a></li>';
    return $output;
}
add_shortcode('slide', 'onepix_shortcode_slide');
?>