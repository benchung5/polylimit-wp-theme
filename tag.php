<?php 
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header(); ?>

<?php get_template_part( 'temp', 'belowheader-page' ); ?>

<div class="row">
    <div id="content" class="large-8 columns">
        <?php
        global $do_not_duplicate;
        if (have_posts()) : while (have_posts()) : the_post();
                $do_not_duplicate[] = $post->ID;
                ?>

                <div <?php post_class('singlepost'); ?> id="single-post-<?php the_ID(); ?>">
                    <div class="entry">
                        <?php
                        if (has_post_thumbnail()) {
                            $full_image_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
                            echo '<div class="post-feature-img">';
                            echo '<a href="' . $full_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" >';
                            echo '<div class="featured-thumbnail">';
                            the_post_thumbnail();
                            echo '</div>';
                            echo '</a>';
                            echo '</div>';
                        }
                        ?>

                        <div class="clear"></div>
                        <h1 class="post-title single">
                            <?php the_title(); ?>
                        </h1>
                        <div class="clear"></div>
                        <?php get_template_part('postmeta'); ?>
                        <?php the_content(); ?>
                        <div style="clear:both;"></div>

                        <?php if (has_tag()) { ?>
                            <div class = "lineafter-header-container">
                                <h4 class = "lineafter-heading">Related Tags</h4>
                            </div >
                            <?php
                            the_tags('<div class="tags">', '', '</div>');
                        }
                        ?>

                    </div>
                </div>

        
                <?php if (get_the_author_meta('description')) : // If a user bio is filled out ?>
                    <div class="lineafter-header-container">
                        <h4 class="lineafter-heading">About the Author</h4>
                    </div>
                    <div class="auth-bio clearfix">
                        <div class="bio">
                            <div class="italic">
                                <?php
                                if (function_exists('get_avatar')) {
                                    echo get_avatar(get_the_author_meta('email'), '80'); /* This avatar is the user's gravatar (http://gravatar.com) based on their administrative email address */
                                }
                                ?>
                                <?php echo get_the_author_meta('description'); ?>
                                <a rel="author" class="auth-archive-link" href="<?php echo home_url(); ?>/?author=<?php the_author_meta('ID'); ?>"><?php _e("More from this author", "1pixel"); ?> &raquo;</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php
                comments_template('', true);
                get_template_part('temp', 'post-nav');
                ?>
                
                <div class="spacer"></div>
        <?php
            endwhile;
        endif;
        ?>

    </div><!--#content-->
<?php get_template_part('sidebar-secondary'); ?>
</div><!--row-->
<?php get_footer(); ?>