<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
//include theme settings option global variables 
$onepix_option = onepix_get_global_options();
//include header type global variable 
global $header_type;
?>
<?php 
if ( $header_type == 'standard' ) { ?>   
    <div class="full-width-img full-width-img-internal plax-img" data-stellar-background-ratio="0.5" data-stellar-vertical-offset="0" style="background: url(<?php 
    if (get_post_meta(get_the_ID(), 'onepix_custom_img_url_input', true) != '') {
        echo get_post_meta(get_the_ID(), 'onepix_custom_img_url_input', true);
    } else {
        echo $onepix_option['onepix_sitewide_img'];
    }
    ?>) top right;">
        <div id="internal-header-grad">
            <div id="internal-page-header-wrapper">
                <div class="row">
                    <div class="medium-12 columns">
                        <h1 class="page-header internal-page-header"><?php 
                        if (is_category()) {
                            single_cat_title();
                            
                        } elseif (is_tag()) {
                            single_tag_title();
                        } elseif (is_archive()) {
                            wp_title('');
                        } elseif (is_search()) {
                            echo 'Search for &quot;' . wp_specialchars($s);
                        } elseif (is_404()) {
                            echo 'Error 404 Not Found';
                        } elseif (is_single()) {
                            wp_title('');
                        } else {
                            //echo wp_title( ' | ', false, right ); 
                            echo get_the_title();
                        }
                        ?>
                        </h1>
                        <div class="page-header-right">
                            <?php the_breadcrumb(); ?>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div> <!--internal header grad-->
    </div>
<?php //} elseif (is_page_template( 'template-contact.php' ) && $onepix_option['onepix_has_googlemap']) { 
 } elseif ($header_type == "contact_page") { ?>
    <div class="contact-map-header">        
            <div class="map">
                <div id="map_leeds" style="width: 100%; height: 400px"></div>  
            </div>
    </div>
<?php } elseif ($header_type == "custom") { ?>
    <div class="full-width-img full-width-img-internal plax-img" data-stellar-background-ratio="0.5" data-stellar-vertical-offset="0" style="background: url(<?php 
    if (get_post_meta(get_the_ID(), 'onepix_custom_img_url_input', true) !== "") {
        echo get_post_meta(get_the_ID(), 'onepix_custom_img_url_input', true);
    } else {
        echo $onepix_option['onepix_sitewide_img'];
    }
    ?>) top right;">
        
    <div id="internal-header-grad">
            <div id="internal-page-header-wrapper">
                <div class="row">
                    <div class="medium-12 columns">
                        <?php echo do_shortcode(get_post_meta(get_the_ID(), 'onepix_custom_html', true)); ?>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div> <!--internal header grad-->
    </div>
<?php } elseif ($header_type == "plain") { ?>
    <!--render nothing-->
<?php } else { ?>
    <div class="plain-internal-header">
        <div class="row">
            <div class="medium-12 columns">
                <h1 class="page-header"><?php 
                if (is_category()) {
                    single_cat_title();
                } elseif (is_tag()) {
                    single_tag_title();
                } elseif (is_archive()) {
                    wp_title('');
                } elseif (is_search()) {
                    echo 'Search for &quot;' . wp_specialchars($s);
                } elseif (is_404()) {
                    echo 'Error 404 Not Found';
                } elseif (is_single()) {
                    wp_title('');
                } else {
                    //echo wp_title( ' | ', false, right ); 
                    echo get_the_title();
                }
                ?>
                </h1>
            </div>
        </div>
    </div>
<?php } ?>
<div class="body-container">