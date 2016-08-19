<?php 
if ( ! defined( 'ABSPATH' ) ) { exit; }
$onepix_option = onepix_get_global_options(); //need this to include theme settings option variables ?>
<?php if ( is_single() ) { ?>
                <div class="spacer-sml"></div>
                <div class="leftnav single">
                    <?php previous_post_link ( '&laquo; %link', '%title' ) ?>
                </div>
                <div class="rightnav single">
                    <?php next_post_link( '%link &raquo;', '%title' ) ?>
                </div>
<?php } else { ?>
<?php //only show nav if more than one post
global $wp_query; 
if ( $wp_query->max_num_pages > 1 ) : ?>     
                
	<?php if ( function_exists('wp_pagenavi') ) { ?>
            <div class="navigation clearfix">
                <?php wp_pagenavi(); ?>
            </div>
	<?php } else { ?>
                <div class="spacer-sml"></div>
		<?php posts_nav_link( ' | ' , '&larr; Newer Posts', 'Older Posts &rarr;' ); ?>
	<?php } ?>
                
    <?php endif; ?>
<?php } ?>
<?php
//use when using query_posts();
wp_reset_query(); 
?>