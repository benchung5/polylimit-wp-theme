<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
//include theme settings option global variables 
$onepix_option = onepix_get_global_options();
?>
<div class="row">
    <?php if ($onepix_option['onepix_blog_sidebar']) { ?>
            <article id="content" class="large-8 columns">
    <?php } else { ?>
            <article id="content" class="large-12 columns">
    <?php } ?>
        <?php
        global $do_not_duplicate;
        if (have_posts()) : while (have_posts()) : the_post();
                $do_not_duplicate[] = $post->ID;
                ?>

                <div <?php post_class('singlepost'); ?> id="single-post-<?php the_ID(); ?>">

                    <div class="entry">

                            <?php if (has_post_thumbnail()) { 
                                $full_image_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?>
                                <div class="post-feature-img">
                                <a href="<?php echo $full_image_url[0] ?>" rel="<?php _e("bookmark", "1pixel"); ?>" title="<?php the_title(); ?>">
                                <?php echo the_post_thumbnail( 'single-post' ); ?>
                                </a>
                                </div>
                            <?php } else { ?>

                            <?php } ?>

                        <div class="clear"></div>

                        <?php the_content(); ?>

                        <div style="clear:both;"></div>
                        <div class="lineafter-header-container">
                            <h4 class="lineafter-heading">Share This</h4>
                        </div>
                        <?php display_socials(); ?>

                        <?php wp_link_pages(); ?>
                        <?php the_tags('<div class="tags">' . __('Tags', "1pixel") . ':  ','' ,'</div>'); ?>
                    </div>
                </div>
                <?php
            endwhile;
        endif;
        ?>

        <?php get_template_part('temp', 'post-nav'); ?>

    </article><!--#content-->
<?php if ($onepix_option['onepix_blog_sidebar']) { 
         get_template_part('sidebar'); 
        } else { ?>

<?php } ?>
</div><!--row-->