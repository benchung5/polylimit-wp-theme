<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<div class="posts-wrapper single-col-posts">
    <?php
    $count = 1;
    if (have_posts()) : while (have_posts()) : the_post();
    
            //if this is the very first post start the first row tag.
            $do_not_duplicate[] = $post->ID;
            ?>
    <div class="row posts-row">
            <div class="medium-12 columns">
                <div <?php post_class(); ?> id="post-main-<?php the_ID(); ?>">
                    <div class="entry clearfix">
                                <a href="<?php the_permalink() ?>" rel="<?php _e("bookmark", "1pixel"); ?>" title="<?php _e("Permanent Link to", "1pixel"); ?> <?php the_title(); ?>">
                            <?php if (has_post_thumbnail() && (!get_post_meta(get_the_ID(), 'onepix_video_embed', true))) { 
                                $full_image_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?>
                                <div class="post-feature-img">
                                <a href="<?php the_permalink() ?>" rel="<?php _e("bookmark", "1pixel"); ?>" title="<?php the_title(); ?>">
                                <?php echo the_post_thumbnail( 'single-post' ); ?>
                                </a>
                                </div>
                            <?php } else if(get_post_meta(get_the_ID(), 'onepix_video_embed', true)) { ?>
                                <div class="post-feature-img">
                                    <?php echo get_post_meta(get_the_ID(), 'onepix_video_embed', true); ?>
                                </div>
                            <?php } else { ?>
                            <?php } ?>
                                </a>
                            <h2 class="post-title"><a href="<?php the_permalink() ?>" rel="<?php _e("bookmark", "1pixel"); ?>" title="<?php _e("Permanent Link to", "1pixel"); ?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
                            <?php get_template_part('postmeta'); ?>
                            <p>
                            <?php
                            $the_content = get_the_content();
                            echo onepix_shorten(strip_tags($the_content), 600);
                            ?>
                            </p>
                            <div class="excerpt-bottom-meta">
                                <a class="read-more" href="<?php the_permalink() ?>" title="<?php _e("Permanent Link to", "1pixel"); ?> <?php the_title(); ?>" ><?php _e("Continue Reading ", "1pixel"); ?> &raquo;</a>
                                <?php display_socials(); ?>
                                <div class="clear"></div>
                            </div>
                            <div class="divider-posts"></div>
                    </div>
                </div>
            </div>
    </div><!--  end posts-row -->
    
    <?php
    endwhile;
    else : echo '<p>' . __("Sorry, there were no posts found.", "1pixel") . '</p>';
    endif;
    ?>
    <?php 
//    if($count % 1 == 0) {
////   if an odd number, add a closing div tag to close the row
//        echo '</div>';
//    }
    ?>
    
</div><!--  end post wrapper-->
<div class="clear"></div>
