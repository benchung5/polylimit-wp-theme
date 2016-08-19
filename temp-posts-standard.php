<?php if ( ! defined( 'ABSPATH' ) ) { exit; }  ?>
<div class="single-col-posts">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <?php  $do_not_duplicate[] = $post->ID; ?>
        
            <?php if (has_post_thumbnail()) { ?>
                <article class="posts-row">           
                <div class="row">
                <div class="medium-4 columns">
                    <div class="featured-thumbnail-1col">
                        <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
                        <?php the_post_thumbnail(); ?>
                        </a>
                    </div>
                </div>
                <div class="medium-8 columns post-excerpt">
                    <h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                    <?php get_template_part('postmeta'); ?>
                    <?php the_excerpt(); /* the excerpt is loaded to avoid duplicate content */ ?>
                    <div class="excerpt-bottom-meta">
                        <a class="read-more" href="<?php the_permalink() ?>" title="<?php _e("Permanent Link to", "1pixel"); ?> <?php the_title(); ?>" ><?php _e("Continue Reading ", "1pixel"); ?> &raquo;</a>
                        <?php display_socials(); ?>
                        <div class="clear"></div>
                    </div>
                </div><!--.postContent-->
                </div>
                <div class="row">
                    <div class="medium-12 columns">
<!--                        we must to it this way with the extra markup because of the columns padding-->
                        <div class="divider-posts"></div>
                    </div>
                </div>
                </article> 
            <?php } else if (get_post_meta(get_the_ID(), 'onepix_video_embed', true)) { ?>
                 <article class="posts-row">           
                    <div class="row">
                        <div class="medium-4 columns">
                            <div class="featured-thumbnail-1col">
                                <div class="videoWrapper">
                                    <?php echo get_post_meta(get_the_ID(), 'onepix_video_embed', true); ?>
                                </div>
                            </div>
                        </div>
                        <div class="medium-8 columns post-excerpt">
                            <h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                            <?php get_template_part('postmeta'); ?>
                            <?php the_excerpt(); /* the excerpt is loaded to avoid duplicate content */ ?>
                            <div class="excerpt-bottom-meta">
                                <a class="read-more" href="<?php the_permalink() ?>" title="<?php _e("Permanent Link to", "1pixel"); ?> <?php the_title(); ?>" ><?php _e("Continue Reading ", "1pixel"); ?> &raquo;</a>
                                <?php display_socials(); ?>
                                <div class="clear"></div>
                            </div>
                        </div><!--.postContent-->
                    </div>
                    <div class="row">
                        <div class="medium-12 columns">
                            <!-- we must to it this way with the extra markup because of the columns padding-->
                            <div class="divider-posts"></div>
                        </div>
                    </div>
                </article> 
            <?php } else { ?>
                <article class="row posts-row">
                <div class="medium-12 columns">
                    <h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                    <?php get_template_part('postmeta'); ?>
                    <?php the_excerpt(); /* the excerpt is loaded to avoid duplicate content */ ?>
                    <div class="excerpt-bottom-meta">
                        <a class="read-more" href="<?php the_permalink() ?>" title="<?php _e("Permanent Link to", "1pixel"); ?> <?php the_title(); ?>" ><?php _e("Continue Reading ", "1pixel"); ?> &raquo;</a>
                        <?php display_socials(); ?>
                        <div class="clear"></div>
                    </div>
                    <div class="divider-posts"></div>
                </div>
                </article>
            <?php } ?>
        
    
    <?php endwhile;
else:
    ?>
    <!--noResults-->
    <div class="no-results">
        <p><?php _e('There has been an error.'); ?></p>
    </div>
<?php endif; ?>
</div> <!--end single-col-posts-->
<div class="clear"></div>