<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
//include theme settings option global variables 
$onepix_option = onepix_get_global_options();
?>

<div class="full-width-img full-width-img-internal plax-img" data-stellar-background-ratio="0.5" data-stellar-vertical-offset="0" style="background: url(<?php 
    if($onepix_option['onepix_sitewide_img']) { echo $onepix_option['onepix_sitewide_img']; }
?>) top right;">
    <div id="internal-header-grad">
        <div id="internal-page-header-wrapper">
            <div class="row">
                <div class="medium-12 columns">
                <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
                        <h1 class="page-title internal-page-header"><?php woocommerce_page_title(); ?></h1>
                        <div class="page-header-right"><?php do_action('onepix_header_right_shop'); ?></div>
                <?php endif; ?>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div> <!--internal header grad-->
</div>

<div class="body-container">
