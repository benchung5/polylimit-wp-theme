<?php
/*
  Template Name: Blog
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
?>
<?php get_template_part( 'temp', 'belowheader-page' ); ?>
<!--if masonry blog style-->
<?php if ($onepix_option['onepix_blog_layout'] == 'Masonry') { ?>
    <div class="row masonary-blog">
                <!--  change column width if sidebar turned on-->
        <?php if ($onepix_option['onepix_blog_sidebar']) { ?>
                <div id="content" class="large-8 columns has-sidebar">
        <?php } else { ?>
                <div id="content" class="large-12 columns">
        <?php } ?>
            <!--        <div id="masonry-loop" data-masonry-options='{ "columnWidth": 400, itemSelector: ".masonry-entry" }'>-->
                    <?php get_template_part('temp', 'content-masonry'); ?>
            <div class="clear"></div>
        </div><!--#content-->
        <!--        show sidebar if turned on-->
        <?php if ($onepix_option['onepix_blog_sidebar']) { ?>
            <div id="masonry-sidebar">
                <?php get_template_part('sidebar-secondary'); ?>
            </div>
        <?php } ?>
    </div><!--row-->
<?php } else { ?>
<!--if standard, 2 or 3 column blog style-->
    <div class="row">
        
            
        <!--  change column width if sidebar turned on-->
        <?php if ($onepix_option['onepix_blog_sidebar']) { ?>
                <div id="content" class="large-8 columns">
        <?php } else { ?>
                <div id="content" class="large-12 columns">
        <?php } ?>
            
            
            <div class="post entry blog-page-template-2 clearfix">
                <?php the_post();
                $content = get_the_content(); ?>
                    <?php if (!empty($content)) : ?>
                    <div class="content">
                    <?php the_content(); ?>
                    </div>
                    <div class="spacer"></div>
                    <?php endif; ?>
            </div>
            <?php
    //      the query---------------------------------//
            global $do_not_duplicate;
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            //the query
            query_posts(array(
                'post__not_in' => $do_not_duplicate,
                'paged' => $paged,
                'category__not_in' => array(32) //exclude testimonials
            ));
    //      end the query---------------------------------//
            ?>
    <!--    select the columns template-->
            <?php if ($onepix_option['onepix_blog_layout'] == 'Standard') { ?>
                <?php get_template_part('temp', 'posts-standard'); ?>
            <?php } elseif ($onepix_option['onepix_blog_layout'] == '1 Columns') { ?>
                <?php get_template_part('temp', 'posts-1-col'); ?>
            <?php } elseif ($onepix_option['onepix_blog_layout'] == '2 Columns') { ?>
                <?php get_template_part('temp', 'posts-2-col'); ?>
            <?php } elseif ($onepix_option['onepix_blog_layout'] == '3 Columns') { ?>
                <?php get_template_part('temp', 'posts-3-col'); ?>
            <?php } else { ?>
                <?php get_template_part('temp', 'posts-1-col'); ?>
            <?php } ?>
            <?php get_template_part('temp', 'post-nav'); ?>
        </div><!--#content-->
        
        <!--        show sidebar if turned on-->
        <?php if ($onepix_option['onepix_blog_sidebar']) { ?>
            <?php get_template_part('sidebar-secondary'); ?>
        <?php } ?>
    </div><!--row-->
<?php } ?>
<?php get_footer(); ?>