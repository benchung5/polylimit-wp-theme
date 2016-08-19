<?php 
if ( ! defined( 'ABSPATH' ) ) { exit; }
$onepix_option = onepix_get_global_options(); ?>
<div id="masonry-loop" class="<?php if ($onepix_option['onepix_blog_sidebar']) { echo "has-sidebar"; } else { echo "no-sidebar";} ?>">
    <div class="posts-wrapper">
        <!--  posts will be appended to here and laid out by masonry-->
    </div>
<!--    used so we can use % sizes. no other use for this element-->
<div class="gutter-sizer" syle="<?php //if($onepix_option['onepix_blog_sidebar']) { echo "width: 3.7%;"; } else { echo "width: 3.3%;"; }  ?>"></div>
</div>
<div id="masonry-data-holder">
    <!--  posts will be loaded here via ajax-->
</div>
<!-- Ajax Load More script block -->
<section id="ajax-load-more">
    <!-- Note to set these data attributes to control query:
    data-post-type
    data-category
    data-display-posts
    -->
    <ul class="listing" data-post-type="post" data-category="<?php echo get_query_var('cat') ?>" data-display-posts="<?php get_option('posts_per_page'); // grab the post per page from settings?>" data-button-text="More Posts" >
        <!-- Load Ajax Posts Here -->
    </ul>
    <!-- Button is generated Here -->
</section>
<!-- /Ajax Load More -->