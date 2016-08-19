<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
// Home slider template
function onepix_slider_template() {
    
$onepix_option = onepix_get_global_options(); //need this to include theme settings option variables  
// Query Arguments
$args = array(
'post_type' => 'slides',
'posts_per_page' => 5
); 
// The Query
$the_query = new WP_Query( $args );
// Check if the Query returns any posts
if ( $the_query->have_posts() ) {
// Start the Slider ?>
<div id="slider" class="flexslider homeslider">
        <ul class="slides">
            <?php
            // The Loop
            while ( $the_query->have_posts() ) : $the_query->the_post();
            ?>
            <li style="height:<?php echo $onepix_option['onepix_featured_height']; ?>px;">
                <?php // Check if there's a Link URL given and if so let's a link to it
                if ( get_post_meta( get_the_id(), 'onepix_slideurl', true) != '' ) {
                ?>
            <a href="<?php echo esc_url( get_post_meta( get_the_id(), 'onepix_slideurl', true) ); ?>">
                <div class="featured-gradient"></div><!-- gradient overlay  -->
                <?php
                }
                // The Slide's Image
//                echo the_post_thumbnail();
                echo the_post_thumbnail( 'home-slider' ); 
                // Close off the Slide's Link if there is one
                if ( get_post_meta( get_the_id(), 'onepix_slideurl', true) != '' ) {
                ?>
            </a>
        <?php } ?>
                
        <?php if (!$onepix_option['onepix_has_fixed_caption']) { ?>
            <div class="flex-caption-wrapper" >
                <div class="flex-caption">
                    <div class="caption-container">
                        <div class="text-container caption-one">
                            <hgroup>
                                <h1 id="homepage-feature-title" ><?php echo do_shortcode(get_post_meta( get_the_id(), 'onepix_maintitle', true)); ?></h1>
                                <h2 id="homepage-subfeature-title"><?php echo do_shortcode(apply_filters('the_content', get_post_meta( get_the_id(), 'onepix_caption', true))); ?></h2>
                            </hgroup>
                            <div id="homepage-subfeature-secondary" ><?php echo do_shortcode(get_post_meta( get_the_id(), 'onepix_html', true)); ?></div>
                        </div>
                    </div>
                </div>
            </div>
         <?php } ?>
         
                
        </li>
<?php endwhile; ?>
    </ul><!-- .slides -->
    
    
    <?php if ($onepix_option['onepix_has_fixed_caption']) { ?>
    <div class="flex-caption-wrapper" >
        <div class="flex-caption">
            <div class="caption-container">
                <div class="text-container caption-one">
                    <hgroup>
                        <h1 id="homepage-feature-title" ><?php echo $onepix_option['onepix_featured_title']; ?></h1>
                        <h2 id="homepage-subfeature-title" ><?php echo $onepix_option['onepix_featured_tagline']; ?></h2>
                    </hgroup>
                    <div id="homepage-subfeature-secondary" ><?php echo do_shortcode($onepix_option['onepix_featured_tagline_html']); ?></div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
    
</div><!-- .flexslider -->
<?php
}
?>
<?php
// Reset Post Data
wp_reset_postdata();
}
?>