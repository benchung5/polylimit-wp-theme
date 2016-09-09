<?php 
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header(); ?>

<?php get_template_part( 'temp', 'belowheader-page' ); ?>

<?php 
//if showcase post type
if ('onepix_' . SHOWCASE_NAME == get_post_type()) { ?>

<?php get_template_part( 'temp', 'single-showcase' ); ?>

<?php } else { ?>

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


                        <h1 class="page-header single-header"><?php 
                            the_title();
                        ?>
                        </h1>

                        
                        <?php if (1 == 2 && has_post_thumbnail() && (!get_post_meta(get_the_ID(), 'onepix_video_embed', true))) {
                            $full_image_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?>
                            <div class="post-feature-img">
                            <a href="<?php echo $full_image_url[0] ?>" rel="<?php _e("bookmark", "1pixel"); ?>" title="<?php the_title(); ?>">
                            <?php echo the_post_thumbnail( 'single-post' ); ?>
                            </a>
                            </div>
                        <?php } else if(get_post_meta($post->ID, 'onepix_video_embed', true)) { ?>
                            <div class="post-feature-img">
                                <div class="videoWrapper">
                                    <?php echo get_post_meta($post->ID, 'onepix_video_embed', true); ?>
                                </div>
                            </div>
                        <?php } else { ?>
                        <?php } ?>

                        <div class="clear"></div>

                        <?php get_template_part('postmeta'); ?>

                        <?php the_content(); ?>
                        
                        <?php
                        //for use in the loop, list 5 post titles related to first tag on current post
                        $tags = wp_get_post_tags($post->ID);
                        if ($tags) {
                                      $first_tag = $tags[0]->term_id;
                                      $args = array(
                                          'tag__in' => array($first_tag),
                                          'post__not_in' => array($post->ID),
                                          'posts_per_page' => 3,
                                          'ignore_sticky_posts' => 1
                                      );
                                      $my_query = new WP_Query($args);
                                      
                                      if ($my_query->have_posts()) {
                                          
                                          ?>
                                          
                                         <h4>Related Posts</h4>
                                         <ul class="small-block-grid-1 medium-block-grid-3 post-after">
                                         
                                            <?php
                                             
                                            $post_count = $my_query->found_posts;
                                            $i = 1;
                                            while ($my_query->have_posts()) : $my_query->the_post();
                                            ?>
                                            <li>
                                                <div class="cat-header-wrapper">

                                                    <?php if (has_post_thumbnail()) { ?>
                                                        <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
                                                        <?php the_post_thumbnail( 'square-thumb' ) ?></a>
                                                    <?php } else { ?>
                                                        <img src="<?php echo DEFAULT_IMG_545; ?>" alt="placeholder" />
                                                    <?php } ?>
                                                        
                                                    <div class="cat-header"><a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php echo onepix_shorten(get_the_title(), 18, '&hellip;') ; ?></a></div>
                                                </div>
                                            </li>
                                               <?php
                                                 $i++;
                                           endwhile;
                                            ?>
                                               
                                          </ul>
    
                                         <?php 
                                        }
                                      wp_reset_query();
                                    }
                                    ?>
                                              
                        <div style="clear:both;"></div>
                        
                        <?php 
                        //if testimonials post type
                        if ('onepix_testimonial' !== get_post_type()) { ?>
                        
                            <div class="lineafter-header-container">
                                <h4 class="lineafter-heading">Share This</h4>
                            </div>
                            <?php display_socials(); ?>
                        
                            <?php if (has_tag()) { ?>
                                <div class = "lineafter-header-container">
                                    <h4 class = "lineafter-heading">Related Tags</h4>
                                </div >
                            <?php
                                the_tags('<div class="tags post-after">', '', '</div>');
                            } ?>

                        <?php } //end if testimonials post type ?>
                        
                    </div>
                </div>

                <?php // If a user bio is filled out & this is not a testimonial post type ?>
                <?php if ( get_the_author_meta('description') && 'onepix_testimonial' !== get_post_type() ) : ?>
                <aside>
                    <div class="lineafter-header-container">
                        <h4 class="lineafter-heading">About the Author</h4>
                    </div>
                    <div class="auth-bio clearfix">
                        <div class="bio">
                            <div class="left auth-avatar-wrapper">
                                <?php
                                if (function_exists('get_avatar')) {
                                    echo get_avatar(get_the_author_meta('email'), '80'); /* This avatar is the user's gravatar (http://gravatar.com) based on their administrative email address */
                                }
                                ?>
                            </div>
                            <div class="italic left bio-text">
                                <?php echo get_the_author_meta('description'); ?>
                                <a rel="author" class="auth-archive-link" href="<?php echo home_url(); ?>/?author=<?php the_author_meta('ID'); ?>"><?php _e("More from this author", "1pixel"); ?></a>
                            </div>
                        </div>
                    </div>
                </aside>
                <?php endif; ?>

                <?php if ('onepix_testimonial' !== get_post_type()) { ?>
                    <section>
                    <?php comments_template('', true); ?>
                    </section>
                   <?php }
            endwhile;
        endif;
        ?>

        <?php get_template_part('temp', 'post-nav'); ?>

    </article><!--#content-->
    
    <!--    sidebar-->
    <?php if ($onepix_option['onepix_blog_sidebar']) { ?>
            <?php get_template_part('sidebar-secondary'); ?>
    <?php } ?>

</div><!--row-->

<?php } ?>


<?php get_footer(); ?>