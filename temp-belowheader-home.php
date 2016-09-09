<?php 
if ( ! defined( 'ABSPATH' ) ) { exit; }
$onepix_option = onepix_get_global_options(); //need this to include theme settings option variables   ?>
<?php // if ($onepix_option['onepix_has_home_slider']) { ?>
<?php if ($onepix_option['onepix_featured_area_type'] == 'slider') { ?>
<!--your loading icon-->
    <section class="homeslider flexslider-wrapper">
        <?php echo onepix_slider_template(); ?>
    </section>
<?php } else { ?>
    <section class="full-width-img-home-wrapper">
    <?php if ($onepix_option['onepix_featured_area_type'] == 'image') { ?>
        <div class="full-width-img full-width-img-home" style="background-image: url(<?php echo $onepix_option['onepix_home_featured_img']; ?>); min-height:<?php echo $onepix_option['onepix_featured_height']; ?>px;" >
    <?php } else if ($onepix_option['onepix_featured_area_type'] == 'parallax image') { ?>
        <div class="full-width-img full-width-img-home" data-stellar-background-ratio="0.5" data-stellar-vertical-offset="0" style="background-image: url(<?php echo $onepix_option['onepix_home_featured_img']; ?>); min-height:<?php echo $onepix_option['onepix_featured_height']; ?>px;" >
    <?php } ?>
            <div class="flex-caption">
                    <div class="caption-container">
                        <div class="text-container">
                            <hgroup>
                                <h1 id="homepage-feature-title" ><?php echo $onepix_option['onepix_featured_title']; ?></h1>
                                <h2 id="homepage-subfeature-title" ><?php echo do_shortcode($onepix_option['onepix_featured_tagline']); ?></h2>
                            </hgroup>
                            <div id="homepage-subfeature-secondary" ><?php echo do_shortcode($onepix_option['onepix_featured_tagline_html']); ?></div>
                        </div>
                        <div class="featured-img-front">
                            <img src="<?php echo $onepix_option['onepix_home_foreground_img']; ?>" />
                        </div>
                    </div>
                <div class="clear"></div>
                </div>
            <div class="featured-gradient"></div><!-- gradient overlay  -->
        </div> <!--end full width image home-->
    </section>
<?php } ?>

<?php if (is_active_sidebar('Home Below Featured')) { ?>
    <section class="home-below-featured-wrapper">
        <!--below header featured widget area-->
        <?php if (!dynamic_sidebar('Home Below Featured')) : ?><!--Wigitized Below Featured--><?php endif ?>
    </section>
<?php } ?>
