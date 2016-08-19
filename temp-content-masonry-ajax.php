<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$onepix_option = onepix_get_global_options(); //need this to include theme settings option variables 
// Our include
define('WP_USE_THEMES', false);
//require_once('../../../wp-load.php');
// Our variables
$postType = (isset($_GET['postType'])) ? $_GET['postType'] : 'post';
$category = (isset($_GET['category'])) ? $_GET['category'] : '';
$numPosts = (isset($_GET['numPosts'])) ? $_GET['numPosts'] : 6;
$currentpage = (isset($_GET['pageNumber'])) ? $_GET['pageNumber'] : 0;
$args = array(
    'post_type' => $postType,
    'cat' => $category,
    'posts_per_page' => $numPosts,
    'paged'          => $currentpage,
    'post_status' => 'publish',
);
// EXCLUDE POSTS
// Create new array of excluded posts
/* Example array from parent page:
   $features = array();
   foreach( $posts as $post):
       setup_postdata($post);
       $features[] = $post->ID;
   endforeach;
   if($features){           
       $postsNotIn = implode(",", $features);
   }
*/
// rewind
rewind_posts();
// QUERY BY TAXONOMY
//if(empty($taxonomy)){
//    $args['tag'] = $tag;
//}else{
//    $args[$taxonomy] = $tag;
//}
$the_query = new WP_Query( $args );
?>
            <?php
            if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post();
                    ?>
                    <article class="masonry-entry" style="<?php if ($onepix_option['onepix_blog_sidebar']) { echo "width:47.8%;"; } ?>" id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
                        <?php if (has_post_thumbnail()) { ?>
                            <div class="masonry-thumbnail">
                                <a href="<?php the_permalink(' ') ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('masonry-thumb'); ?></a>
                            </div><!--.masonry-thumbnail-->
                        <?php } else if(get_post_meta(get_the_ID(), 'onepix_video_embed', true)) { ?>
                            <div class="masonry-thumbnail">
                                <?php echo get_post_meta(get_the_ID(), 'onepix_video_embed', true); ?>
                            </div>
                        <?php } else { ?>
                        <?php } ?>
                        <div class="masonry-details">
                            <h2 class="post-title"><a href="<?php the_permalink(' ') ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                            <?php get_template_part('postmeta'); ?>
                            <?php
                            //put the excerpt markup in variable so we don't have to repeat it multiple times.
                            $excerpt = '<div class="masonry-post-excerpt">';
                            $excerpt .= the_excerpt();
                            $excerpt .= '</div><!--.masonry-post-excerpt-->';
                            ?>
                            <div class="excerpt-bottom-meta">
                                <a class="read-more" href="<?php the_permalink(' ') ?>">Read More &rarr;</a>
                                <div class="excerpt-comment-count"><?php comments_number(__("0", "1pixel"), __("1", "1pixel"), __("%", "1pixel")); ?></div>
                                <div class="clear"></div>
                            </div>
                            <div class="socials-wrapper">
                                <?php display_socials(); ?>
                            </div>
                        </div><!--/.masonry-entry-details -->  
                    </article><!--/.masonry-entry-->
                    <?php
                    //itterate the count for columns
//                    $count = $count + 1;
                endwhile;
            else : echo '<p>' . __("No further posts.", "1pixel") . '</p>';
            endif;
            ?>
            <?php
// Restore original Post Data
wp_reset_postdata();
            
            ?>
<?php  
//echo 'post type: ' . $postType . '<br>';
//echo 'cat: ' . $category . '<br>';
//echo 'num: ' . $numPosts . '<br>';
?>
<?php // wp_reset_query(); ?>