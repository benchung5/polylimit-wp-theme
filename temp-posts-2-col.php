<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<div class="posts-wrapper two-col-posts">
    <?php
    $count = 1;
    if (have_posts()) : while (have_posts()) : the_post();
    
            //if this is the very first post start the first row tag.
            if ($count == 1) { ?>
                <div class="row posts-row">
                  
                <?php  } else {
                   
                }
            $do_not_duplicate[] = $post->ID;
            ?>
            <div class="medium-6 columns">
                <div <?php post_class(); ?> id="post-main-<?php the_ID(); ?>">
                    <div class="entry clearfix">
                            <div class="featured-thumbnail-multicol">
                                <a href="<?php the_permalink() ?>" rel="<?php _e("bookmark", "1pixel"); ?>" title="<?php _e("Permanent Link to", "1pixel"); ?> <?php the_title(); ?>">
                                <?php if (has_post_thumbnail() && (!get_post_meta(get_the_ID(), 'onepix_video_embed', true))) {
                                        the_post_thumbnail();
                                    } else if(get_post_meta(get_the_ID(), 'onepix_video_embed', true)) { ?>
                                <div class="post-feature-img">
                                    <?php echo get_post_meta(get_the_ID(), 'onepix_video_embed', true); ?>
                                </div>
                                <?php } else { ?>
                                     <img src="<?php bloginfo('template_directory'); ?>/images/default-image-545x545.jpg" alt="<?php the_title(); ?>" />
                                    <?php } ?>
                                </a>
                            </div>
                            <h2 class="post-title"><a href="<?php the_permalink() ?>" rel="<?php _e("bookmark", "1pixel"); ?>" title="<?php _e("Permanent Link to", "1pixel"); ?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
                            <?php get_template_part('postmeta'); ?>
                            <p>
                            <?php
                            $the_content = get_the_content();
                            echo onepix_shorten(strip_tags($the_content), 150);
                            ?>
                            </p>
                            <div class="excerpt-bottom-meta">
                                <a class="read-more" href="<?php the_permalink() ?>" title="<?php _e("Permanent Link to", "1pixel"); ?> <?php the_title(); ?>" ><?php _e("Continue Reading ", "1pixel"); ?> &raquo;</a>
                            </div>
                            <div class="spacer"></div>
                            <?php display_socials(); ?>
                    </div>
                </div>
            </div>
    
            <?php
            //if this is the third post (every third) end the row and start the first tag of the next.
            if ($count % 2 == 0) { ?>
            
            </div><!--  end posts-row -->
            <div class="row posts-row">
            <?php
            } else {
            }
        ?>
    
    <?php
    //itterate the count for columns
    $count = $count + 1;
    endwhile;
    else : echo '<p>' . __("Sorry, there were no posts found.", "1pixel") . '</p>';
    endif;
    ?>
    </div><!--  end posts-row -->
    <?php 
//    if($count % 1 == 0) {
////   if an odd number, add a closing div tag to close the row
//        echo '</div>';
//    }
    ?>
    
</div><!--  end post wrapper-->
<div class="clear"></div>
