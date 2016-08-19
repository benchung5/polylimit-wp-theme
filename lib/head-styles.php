<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
/* ------------------------------------------------------------------------ *
 * theme option invoked styles to insert into wp_head
 * ------------------------------------------------------------------------ */ 
$onepix_option = onepix_get_global_options();
if( !function_exists( 'wp_gwf_header_init' ) ):
function wp_gwf_header_init(){
    
global $onepix_option;
$bodytext_color = $onepix_option['onepix_bodytext_color'];
$largetext_color = $onepix_option['onepix_largetext_color'];
$highlight_color = $onepix_option['onepix_highlight_color'];
$midtone_color = $onepix_option['onepix_midtone_color'];
$subfooter_color = $onepix_option['onepix_subfooter_color'];
$subfooter_bg_img = $onepix_option['onepix_subfooter_bg_img'];
$footer_color = $onepix_option['onepix_footer_color'];
$header_color = $onepix_option['onepix_header_color'];
$html_bg = $onepix_option['onepix_html_background'];
$html_bg_img = $onepix_option['onepix_html_background_img'];
$caption_margin = $onepix_option['onepix_caption_margin'];
$featured_height = $onepix_option['onepix_featured_height'];
//get the width of the uploaded image
//list($featured_img_width, $featured_img_height) = getimagesize($onepix_option['onepix_sitewide_img']);
// if the file name has space in it, encode it properly
//$size = getimagesize("http://www.example.com/gifs/lo%20go.gif");
//load get google web fonts -----------------------------------------//
$http = (!empty($_SERVER['HTTPS'])) ? "https" : "http";
$un_bodytype = $onepix_option['onepix_body_font'];
$un_headtype = $onepix_option['onepix_headline_font'];
$bodytype = str_replace(' ' , '+', $onepix_option['onepix_body_font']);
$headtype = str_replace(' ' , '+', $onepix_option['onepix_headline_font']);
$font_var = '300,400,600,700,900,300italic,400italic,600italic,700italic,900italic';
if ( $bodytype != "" ){
echo "<link href='" . $http . "://fonts.googleapis.com/css?family=" . $bodytype . ":" . $font_var . "' rel='stylesheet' type='text/css'>";
}
if ($headtype != ""){
echo "<link href='" . $http . "://fonts.googleapis.com/css?family=" . $headtype . ":" . $font_var . "' rel='stylesheet' type='text/css'>";
}
?>
    <?php echo "<style type='text/css' media='all'>"; ?>
/*google fonts*/
    body { font-family: <?php echo $onepix_option['onepix_body_font']; ?> !important; }
    h1,h2,h3,h4,h5,h6, .large { font-family: <?php echo $onepix_option['onepix_headline_font']; ?>; }
    
/*colors-----------------------------------*/
    /*bodytext color*/
    body { color: <?php echo $bodytext_color ?> !important;}
    /*large text color*/
    .large { color: <?php echo $largetext_color ?> !important;}    
    
    /*highlight*/
    .highlight { color: <?php echo $highlight_color ?> !important;}
    .content-block { border-top-color: <?php echo $highlight_color ?> !important; }
    
    #giant-submenu-wrapper.depth-0 > ul > li > a:hover, #giant-submenu-wrapper.depth-0 > ul > li > ul#giant-sub-menu > li a:hover,
    a:link:hover, a:visited:hover, #mobile-menu > ul.menu li a:hover, #sidebar .widget-area > ul > li > a:link:hover, 
    #sidebar .widget-area > ul > li > a:visited:hover, #nav-primary > .nav-wrapper > nav > div > ul > li > a:hover, 
    #nav-primary-giant > .nav-wrapper > nav > div > ul > li > a:hover, #nav-primary-b > .nav-wrapper > nav > div > ul > li > a:hover,
    #nav-primary-b ul.sub-menu > li > a:hover, #nav-primary ul.sub-menu > li > a:hover
    { color: <?php echo $highlight_color ?>;}
    
    ::-moz-selection
    {background: <?php echo $highlight_color ?>;}
    ::selection
    {background: <?php echo $highlight_color ?>;}
    
    input[type="submit"], button[type="submit"], .slider-widget .flex-control-paging li a.flex-active ,
    .woocommerce .cart-collaterals .shipping_calculator .button, .woocommerce-page .cart-collaterals .shipping_calculator .button, a.wc-forward, a.wc-backward,
    .rightnav a, .leftnav a, .leftnav, .rightnav
    {background: <?php echo $highlight_color ?>;}
    /*midtone color*/
    .catch-phrase { background: <?php echo $midtone_color ?> !important; }
    
    /*subfooter background*/
    #footertop { background: <?php echo $subfooter_color ?>  url(<?php echo $subfooter_bg_img ?>) no-repeat center top !important; 
                -webkit-background-size: cover !important;
                -moz-background-size: cover !important;
                -o-background-size: cover !important;
                background-size: cover !important; 
                }
    
    /*darkest color*/
    #footer { background: <?php echo $footer_color ?> !important; }
    /*header color*/
    .no-pageheader #header-main-wrapper, .custom-pageheader #header-main-wrapper { background: <?php echo $header_color ?>; }
    
    .homeslider, .full-width-img-home { max-height:<?php echo $featured_height ?>px; }
    
    /*set the min-width to the size of the uploaded image*/
    .homeslider .flexslider .slides img {
        min-width: <?php echo $featured_img_width ?>px;
    }
    
    /*flexslider caption*/
   .homeslider .flex-caption { top: <?php echo $caption_margin ?>; }
    
    @media only screen and (max-width: 479px) {
    .homeslider .flex-caption { top:0; }
    .homeslider, .full-width-img-home, .homeslider .flex-viewport .slides > li { height: auto !important; }
    }
    
    /*html background img*/
    html { background: <?php echo $html_bg ?>  url(<?php echo $html_bg_img ?>) no-repeat center top fixed !important; 
            -webkit-background-size: cover !important;
            -moz-background-size: cover !important;
            -o-background-size: cover !important;
            background-size: cover !important;
            }
    
    
    
    <?php echo "</style>"; ?>
<?php }
endif;
add_action('wp_head','wp_gwf_header_init');
////get the Google Web Fonts API list --------------------------------------------------------//
//if( !function_exists('wp_get_google_webfonts_list') ):
//function wp_get_google_webfonts_list($key='', $sort='') {
//    /*
//    $key = Web Fonts Developer API
//    $sort=
//    alpha: Sort the list alphabetically
//    date: Sort the list by date added (most recent font added or updated first)
//    popularity: Sort the list by popularity (most popular family first)
//    style: Sort the list by number of styles available (family with most styles first)
//    trending: Sort the list by families seeing growth in usage (family seeing the most growth first)
//    */
//
//$http = (!empty($_SERVER['HTTPS'])) ? "https" : "http";
//
//$google_api_url = 'https://www.googleapis.com/webfonts/v1/webfonts?key=' . $key . '&sort=' . $sort;
////lets fetch it
//$response = wp_remote_retrieve_body( wp_remote_get($google_api_url, array('sslverify' => false )));
//if( is_wp_error( $response ) ) {
//} else {
//$data = json_decode($response, true);
//$items = $data['items'];
//foreach ($items as $item) {
//$font_list[] .= $item['family'];
//}
//}
////Return the saved list of Google Web Fonts
//return $font_list;
//}
//endif;
// Exit if accessed directly
?>