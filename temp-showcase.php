<?php 
if ( ! defined( 'ABSPATH' ) ) { exit; }
$onepix_option = onepix_get_global_options(); //need this to include theme settings option variables  ?>            
<div class="clear"></div>
            <div class="showcase-container">
                <div class="showcase-header">
                    <h1><?php echo SHOWCASE_NAME ;?></h1>
                    <ul class="filter clearfix">
                        <li class="active"><a href="javascript:void(0)" class="all">All</a></li>
                        <?php
                        //
//            $terms = get_terms('skills', $args);
                        $taxonomy = TAXONOMY_NAME . 's';
                        $args = array(
//            order by the custom tax meta stored in 'term_group' table see lib>showcase>showcase-post-type 
                            'orderby' => 'term_group',
                            'hide_empty'  =>  false
                            );
                        $terms = get_terms($taxonomy, $args );
                        $count = count($terms);
                        $i = 0;
                        $term_list = '';
                        if ($count > 0) {
                            foreach ($terms as $term) {
                                $i++;
                                $term_list .= '<li ' . 'data-type=' . $term->slug . ' >
                                    <a href="javascript:void(0)" class="' . $term->slug . '">' . $term->name . '</a></li>';
                                if ($count != $i) {
                                    $term_list .= '';
                                } else {
                                    $term_list .= '';
                                }
                            }
                            echo $term_list;
                        }
                        ?>
                    </ul>
                    <div class="clear"></div>
                </div>
                <ul class="filterable-grid clearfix">
                    <?php 
                    //if ( function_exists('wp_pagenavi') ) { 
                    //}
                    //for the wp_pagenavi plugin
                    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                    $wpbp = new WP_Query(array( 
                        'post_type' => 'onepix_' . SHOWCASE_NAME, 
                        'posts_per_page' => -1, //all posts (the per page slice amount is set in the data from theme settings sent to the onePixShowcase.js file)
//                        'paged' => $paged,
//                        'orderby' => 'title', //order by title A-Z
//                        'order' => 'ASC'
                        ));
                    ?>
                    <?php if ($wpbp->have_posts()) : while ($wpbp->have_posts()) : $wpbp->the_post(); ?>
                        <?php $terms = get_the_terms(get_the_ID(), TAXONOMY_NAME . 's'); ?>
                            
                                <li data-id="id-<?php echo  $count; ?>" data-type="
                                    <?php 
                                    if ($terms) {
                                        foreach ($terms as $term) {
                                            
                                                echo "terms are:";
                                                print_r($term);
                                                echo $term->slug. ' ';
                                            } 
                                    }
                                    ?>"> 
                                    <div class="cat-header-wrapper">
                                         <?php if (has_post_thumbnail()) { 
                                        // for pretty photo
                                        $large_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'fullsize', false, '' );
                                        $large_image = $large_image[0]; ?>
                                        <a rel="prettyPhoto[gallery]" href="<?php  echo $large_image ?>"><?php the_post_thumbnail();  ?></a>
                                       
                                        <?php } else { ?>
                                            <a rel="prettyPhoto[gallery]" href="<?php bloginfo('template_directory'); ?>/images/default-image-545x545.jpg"><img src="<?php bloginfo('template_directory'); ?>/images/default-image-545x545.jpg" alt="<?php the_title(); ?>" /></a>
                                        <?php } ?>
                                        <div class="cat-header"><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></div>
                                    </div>
                                </li>
                            <?php $count++; ?>
                    <?php endwhile;
                    endif; ?>
                <?php wp_reset_query(); ?>
                </ul>
                <div class="spacer-showcase-bottom clear"></div>
                <div id="showcase-pagination" data-page="<?php echo $onepix_option['onepix_showcase_count']; ?>">
                    <a class="pagenav prev"><span class="caption"> &larr;</span></a>
                    <a class="pagenav next"><span class="caption">&rarr; </span></a>
                    <!--               for testing-->
                    <!--               <br><br>
                                   <div class="clear"></div>
                                   total items length : <span id="test-itemlength"></span><br>
                                   page items to: <span id="test-itemsto"></span><br>
                                   current page: <span id="test-currentpage"></span><br>-->
                </div>
           </div><!-- end showcase container-->
            <?php
//            if (function_exists('wp_pagenavi')) {
//                wp_pagenavi(array('query' => $wpbp));
                wp_reset_postdata();
//            }
            ?>