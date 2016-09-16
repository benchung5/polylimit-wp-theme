<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
/* ------------------------------------------------------------------------ *
 * Widgets
 * ------------------------------------------------------------------------ */ 
add_action( 'widgets_init', 'onepix_register_widgets' );

//register our widget
function onepix_register_widgets() {
        register_widget( 'onepix_recent_posts' );
        register_widget('onepix_post_tabs');
        register_widget( 'onepix_post_boxes' );
        register_widget( 'onepix_portfolio_boxes' );
        register_widget( 'onepix_fa_title' );
        register_widget('onepix_woocat_boxes');
        register_widget( 'onepix_img_circles' );
        register_widget('onepix_fullwidth_container');
        register_widget('onepix_catch_phrase');
        register_widget('onepix_spacer');
}

//Category/Recent Posts/Archives tabs for sidebar
class onepix_post_tabs extends WP_Widget {

    //process our new widget
    function onepix_post_tabs() {
        $widget_ops = array('classname' => 'onepix_post_tabs', 'description' => __('Display latest posts with excerpt', '1pixel'));
        $this->__construct('onepix_post_tabs', __('One Pixel | Post Tabs', '1pixel'), $widget_ops);
    }

    //build our widget settings form
    function form($instance) {
        //recent posts values
        $defaults = array(
            'category_exclude' => '',            
            'post_type' => 'post',
            'number_posts' => '3',
            'show_thumbnail' => 'true',
            'excerpt_length' => '20',
            'archive_type' => 'monthly',
            'archive_limit' => '5',
            );
        $instance = wp_parse_args((array) $instance, $defaults);
        $category_exclude = strip_tags($instance['category_exclude']);
        $stored_post_type = strip_tags($instance['post_type']);
        $number_posts = strip_tags($instance['number_posts']);
        $show_thumbnail = isset($instance['show_thumbnail']) ? ' checked="checked"' : '';
        $show_excerpt = isset($instance['show_excerpt']) ? ' checked="checked"' : '';
        $excerpt_length = strip_tags($instance['excerpt_length']);
        $stored_archive_type = strip_tags($instance['archive_type']);
        $archive_limit = strip_tags($instance['archive_limit']);
        ?>
            <h4>Categories Tab</h4>
            <p><?php _e('Exclude by Category ID (ex: 1,39,64)', '1pixel') ?>: <input name="<?php echo $this->get_field_name('category_exclude'); ?>" type="text" value="<?php echo esc_attr($category_exclude); ?>" size="4" maxlength="4" /></p>
            <h4>Recent Posts Tab</h4>
            <p>
                <?php _e('Post Type', '1pixel') ?>: 

                <select name="<?php echo $this->get_field_name('post_type'); ?>">
                <?php
                $post_types = get_post_types('', 'names');

                foreach ($post_types as $post_type) {
                    if($post_type == $stored_post_type) {
                        echo '<option value=' . $post_type .' selected>' . $post_type . '</option>';
                    } else {
                        echo '<option value=' . $post_type .' >' . $post_type . '</option>';
                    }

                }
                ?>
                </select> 

            </p>
            <p><?php _e('Number of Posts', '1pixel') ?>: <input name="<?php echo $this->get_field_name('number_posts'); ?>" type="text" value="<?php echo esc_attr($number_posts); ?>" size="2" maxlength="2" /></p>
            <p><?php _e('Show Thumbnail', '1pixel') ?>: <input type="checkbox" name="<?php echo $this->get_field_name('show_thumbnail'); ?>" <?php echo $show_thumbnail ?>></p>
            <p><?php _e('Show Excerpt', '1pixel') ?>: <input type="checkbox" name="<?php echo $this->get_field_name('show_excerpt'); ?>" <?php echo $show_excerpt ?>></p>
            <p><?php _e('Excerpt Length', '1pixel') ?>: <input name="<?php echo $this->get_field_name('excerpt_length'); ?>" type="text" value="<?php echo esc_attr($excerpt_length); ?>" size="4" maxlength="4" /></p>
            <h4>Archives Tab</h4>
            <p>
                <?php _e('Archive Type', '1pixel') ?>: 

                <select name="<?php echo $this->get_field_name('archive_type'); ?>">
                    <?php
                    $archive_types = array(
                                //  'taxonomy'     => $taxonomy,
                                'yearly',
                                'monthly',
                                'daily',
                                'weekly',
                                'postbypost',
                                'alpha'
                            );

                    foreach ($archive_types as $archive_type) {
                        if ($archive_type == $stored_archive_type) {
                            echo '<option value=' . $archive_type . ' selected>' . $archive_type . '</option>';
                        } else {
                            echo '<option value=' . $archive_type . ' >' . $archive_type . '</option>';
                        }
                    }
                    ?>
                </select> 

            </p>
            <p><?php _e('Number of Archives', '1pixel') ?>: <input name="<?php echo $this->get_field_name('archive_limit'); ?>" type="text" value="<?php echo esc_attr($archive_limit); ?>" size="2" maxlength="2" /></p>
  <?php
        }

    //save our widget settings
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        
        //category
        $instance['category_exclude'] = strip_tags(esc_attr($new_instance['category_exclude']));
        //recent posts
        $instance['post_type'] = strip_tags(esc_attr($new_instance['post_type']));
        $instance['number_posts'] = intval($new_instance['number_posts']);
        $instance['columns'] = intval($new_instance['columns']);
        $instance['show_thumbnail'] = $new_instance['show_thumbnail'];
        $instance['show_excerpt'] = $new_instance['show_excerpt'];
        $instance['excerpt_length'] = intval($new_instance['excerpt_length']);
        //archives
        $instance['archive_type'] = strip_tags(esc_attr($new_instance['archive_type']));
        $instance['archive_limit'] = intval($new_instance['archive_limit']);
                
        return $instance;
    }

    //display our widget
    function widget($args, $instance) {
        global $post;
        extract($args);

        echo $before_widget;
        //category stored values
        $category_exclude = empty($instance['category_exclude']) ? '' : apply_filters('category_exclude', $instance['category_exclude']);
        //recent posts stored values
        $post_type = empty($instance['post_type']) ? '&nbsp;' : apply_filters('widget_post_type', $instance['post_type']);
        $number_posts = empty($instance['number_posts']) ? 1 : apply_filters('widget_number_posts', $instance['number_posts']);
        $show_thumbnail = isset($instance['show_thumbnail']) ? 'true' : 'false';
        $show_excerpt = isset($instance['show_excerpt']) ? '' : 'display:none;';
        $excerpt_length = empty($instance['excerpt_length']) ? 100 : apply_filters('widget_excerpt_length', $instance['excerpt_length']);
        //archives stored values
        $archive_type = empty($instance['archive_type']) ? '&nbsp;' : apply_filters('widget_archive_type', $instance['archive_type']);
        $archive_limit = empty($instance['archive_limit']) ? 1 : apply_filters('widget_archive_limit', $instance['archive_limit']);
        ?>
                                

        <div class="onepix-tabs" id="tabs">
                    <ul>
                        <li><a href="#tabs-1">Recent</a></li>
                        <li><a href="#tabs-2">Categories</a></li>
                        <li><a href="#tabs-3">Archives</a></li>
                    </ul>
                    <div id="tabs-1">
                        <div class="tabcontent">

                            <?php
                            $wpbp = new WP_Query(array(
                                'orderby' => 'date',
                                'order' => 'DESC',
                                'post_type' => $post_type,
                                'posts_per_page' => $number_posts
                            ));
                            ?>

                            <ul class="recent-posts-tab-content">
                                <?php if ($wpbp->have_posts()) : while ($wpbp->have_posts()) : $wpbp->the_post(); ?>

                                        <li class="onepix-recent-posts-item">
                                            <?php if (has_post_thumbnail() && ($show_thumbnail == "true")) { ?>
                                                <div class = "onepix-recent-posts-thumb">
                                                    <a href = "<?php the_permalink() ?>" rel = "<?php _e("bookmark", "1pixel"); ?>" title = "<?php _e("Permanent Link to", "1pixel"); ?> <?php the_title(); ?>">
                                                        <?php the_post_thumbnail('widget-thumb'); ?>
                                                    </a>
                                                </div>
                                                <div class="onepix-recent-posts-details withthumb">
                                                <?php } else { ?>

                                                    <div class="onepix-recent-posts-details nothumb">
                                                    <?php } ?>
                                                    <a class="onepix-recent-posts-title" rel="bookmark" title="Permalink to <?php echo get_the_title(); ?>" href="<?php the_permalink(); ?>"><?php echo onepix_shorten(get_the_title(), 42) ; ?></a>
                                                    <div class="meta">
                                                        <time datetime="<?php the_time(get_option('date_format')); ?>" class="onepix-recent-posts-date">
                                                            <span class="meta-date">
                                                                <?php the_time(get_option('date_format')); ?>
                                                            </span> 
                                                        </time>
                                                    </div>
                                                    <div class="onepix-recent-posts-excerpt" style="<?php echo $show_excerpt ?>">
                                                        <?php
                                                        $the_content = get_the_content();
                                                        echo onepix_shorten(strip_tags($the_content), $excerpt_length);
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="clear"></div>
                                        </li>
                                        <?php
                                    endwhile;
                                endif;
                                ?>
                                <?php wp_reset_query(); ?>
                            </ul>

                        </div>
                    </div>
                    <div id="tabs-2">
                        <div class="tabcontent">
                            <?php
                            //list terms in a given taxonomy using wp_list_categories (also useful as a widget if using a PHP Code plugin)
                            //$taxonomy     = 'genre';
                            $orderby = 'name';
                            $show_count = 0;      // 1 for yes, 0 for no
                            $pad_counts = 0;      // 1 for yes, 0 for no
                            $hierarchical = 1;      // 1 for yes, 0 for no

                            $args = array(
                                //  'taxonomy'     => $taxonomy,
                                'orderby' => $orderby,
                                'show_count' => $show_count,
                                'pad_counts' => $pad_counts,
                                'hierarchical' => $hierarchical,
                                'title_li' => __( '' ), //don't show the "categories" title ontop of the list,
                                'exclude' => $category_exclude
                            );
                            ?>
                            <ul class="categories-tab-content">
                                <?php wp_list_categories($args); ?>
                            </ul>
                        </div>
                    </div>
                    <div id="tabs-3">
                        <div class="tabcontent">
                            <?php
                            $args = array(
                                'type' => $archive_type,
                                'limit' => $archive_limit,
                                'format' => 'html',
                                'before' => '',
                                'after' => '',
                                'show_post_count' => false,
                                'echo' => 1,
                                'order' => 'DESC'
                            );
                            ?>
                            <ul class="archives-tab-content">
                            <?php wp_get_archives($args); ?>
                            </ul>
                        </div>
                    </div>
                </div>

        
        

        <?php
        echo $after_widget;
    }
}

//Recent Posts usually for footer or sidebar
class onepix_recent_posts extends WP_Widget {

    //process our new widget
    function onepix_recent_posts() {
        $widget_ops = array('classname' => 'onepix_recent_posts', 'description' => __('Display latest posts with excerpt', '1pixel'));
        $this->__construct('onepix_recent_posts', __('One Pixel | Recent Posts Widget', '1pixel'), $widget_ops);
    }

    //build our widget settings form
    function form($instance) {
        $defaults = array(
            'title' => __('Recent Posts', '1pixel'),
            'post_type' => 'post',            
            'number_posts' => '3',
            'excerpt_length' => '20'
            );
        $instance = wp_parse_args((array) $instance, $defaults);
        $title = strip_tags($instance['title']);
        $stored_post_type = strip_tags($instance['post_type']);
        $number_posts = strip_tags($instance['number_posts']);
        $show_thumbnail = isset($instance['show_thumbnail']) ? ' checked="checked"' : '';
        $show_excerpt = isset($instance['show_excerpt']) ? ' checked="checked"' : '';
        $excerpt_length = strip_tags($instance['excerpt_length']);
        ?>
            <p><?php _e('Title', '1pixel') ?>: <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
            <p>
                <?php _e('Post Type', '1pixel') ?>: 

                <select name="<?php echo $this->get_field_name('post_type'); ?>">
                <?php
                $post_types = get_post_types('', 'names');

                foreach ($post_types as $post_type) {
                    if($post_type == $stored_post_type) {
                        echo '<option value=' . $post_type .' selected>' . $post_type . '</option>';
                    } else {
                        echo '<option value=' . $post_type .' >' . $post_type . '</option>';
                    }

                }
                ?>
                </select> 

            </p>
            <p><?php _e('Number of Posts', '1pixel') ?>: <input name="<?php echo $this->get_field_name('number_posts'); ?>" type="text" value="<?php echo esc_attr($number_posts); ?>" size="2" maxlength="2" /></p>
            <p><?php _e('Show Thumbnail', '1pixel') ?>: <input type="checkbox" name="<?php echo $this->get_field_name('show_thumbnail'); ?>" <?php echo $show_thumbnail ?>></p>
            <p><?php _e('Show Excerpt', '1pixel') ?>: <input type="checkbox" name="<?php echo $this->get_field_name('show_excerpt'); ?>" <?php echo $show_excerpt ?>></p>
            <p><?php _e('Excerpt Length', '1pixel') ?>: <input name="<?php echo $this->get_field_name('excerpt_length'); ?>" type="text" value="<?php echo esc_attr($excerpt_length); ?>" size="4" maxlength="4" /></p>
  <?php
        }

    //save our widget settings
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags(esc_attr($new_instance['title']));
        $instance['post_type'] = strip_tags(esc_attr($new_instance['post_type']));
        $instance['number_posts'] = intval($new_instance['number_posts']);
        $instance['columns'] = intval($new_instance['columns']);
        $instance['show_thumbnail'] = $new_instance['show_thumbnail'];
        $instance['show_excerpt'] = $new_instance['show_excerpt'];
        $instance['excerpt_length'] = intval($new_instance['excerpt_length']);
        
        return $instance;
    }

    //display our widget
    function widget($args, $instance) {
        global $post;
        extract($args);

        echo $before_widget;
        $title = apply_filters('widget_title', $instance['title']);
        $post_type = empty($instance['post_type']) ? '&nbsp;' : apply_filters('widget_post_type', $instance['post_type']);
        $number_posts = empty($instance['number_posts']) ? 1 : apply_filters('widget_number_posts', $instance['number_posts']);
        $show_thumbnail = isset($instance['show_thumbnail']) ? 'true' : 'false';
        $show_excerpt = isset($instance['show_excerpt']) ? '' : 'display:none;';
        $excerpt_length = empty($instance['excerpt_length']) ? 100 : apply_filters('widget_excerpt_length', $instance['excerpt_length']);

        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        };
        ?>
                                
                                
        <?php
        $wpbp = new WP_Query(array(
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'post_type' => $post_type,
                    'posts_per_page' => $number_posts
                ));
        ?>

        <div class="onepix-recent-posts-widget">
                    <ul class="">
                        <?php if ($wpbp->have_posts()) : while ($wpbp->have_posts()) : $wpbp->the_post(); ?>

                                <li class="onepix-recent-posts-item">
                                    <?php if (has_post_thumbnail() && ($show_thumbnail == "true")) { ?>
                                        <div class = "onepix-recent-posts-thumb">
                                            <a href = "<?php the_permalink() ?>" rel = "<?php _e("bookmark", "1pixel"); ?>" title = "<?php _e("Permanent Link to", "1pixel"); ?> <?php echo onepix_shorten(get_the_title(), 42) ; ?>">
                                                <?php the_post_thumbnail('widget-thumb'); ?>
                                            </a>
                                        </div>
                                        <div class="onepix-recent-posts-details withthumb">
                                        <?php } else { ?>
                                            <div class="onepix-recent-posts-details nothumb">
                                            <?php } ?>
                                            <a class="onepix-recent-posts-title" rel="bookmark" title="Permalink to <?php echo get_the_title(); ?>" href="<?php the_permalink(); ?>"><?php echo onepix_shorten(get_the_title(), 42) ; ?></a>
                                            <div class="meta">
                                                <time datetime="<?php the_time(get_option('date_format')); ?>" class="onepix-recent-posts-date">
                                                    <span class="meta-date">
                                                        <?php the_time(get_option('date_format')); ?>
                                                    </span> 
                                                </time>
                                            </div>
                                            <div class="onepix-recent-posts-excerpt" style="<?php echo $show_excerpt ?>">
                                                <?php
                                                $the_content = get_the_content();
                                                echo onepix_shorten(strip_tags($the_content), $excerpt_length);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                </li>
                                <?php
                            endwhile;
                        endif;
                        ?>
                        <?php wp_reset_query(); ?>
                    </ul>
                </div>

        <?php
        echo $after_widget;
    }
}

//Post Boxes usually for home page, footer or sidebar
class onepix_post_boxes extends WP_Widget {

    //process our new widget
    function onepix_post_boxes() {
        $widget_ops = array('classname' => 'onepix_post_boxes', 'description' => __('Display Image Boxes that link to Latest Posts', '1pixel'));
        $this->__construct('onepix_post_boxes', __('One Pixel | Post Boxes Widget', '1pixel'), $widget_ops);
    }

    //build our widget settings form
    function form($instance) {
        $defaults = array(
            'post_type' => __('post', '1pixel'),
            'number_posts' => __('3', '1pixel'),
            'columns' => __('3', '1pixel'),
            );
        $instance = wp_parse_args((array) $instance, $defaults);
        $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
        $stored_post_type = strip_tags($instance['post_type']);
        $number_posts = strip_tags($instance['number_posts']);
        $columns = strip_tags($instance['columns']);
        $show_caption = isset($instance['show_caption']) ? ' checked="checked"' : '';
        //$show_caption = strip_tags($instance['show_caption']);
        ?>
            <p><?php _e('Title', '1pixel') ?>: <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
            <p>
                <?php _e('Posts Type', '1pixel') ?>: 

                <select name="<?php echo $this->get_field_name('post_type'); ?>">
                <?php
                $post_types = get_post_types('', 'names');

                foreach ($post_types as $post_type) {
                    if($post_type == $stored_post_type) {
                        echo '<option value=' . $post_type .' selected>' . $post_type . '</option>';
                    } else {
                        echo '<option value=' . $post_type .' >' . $post_type . '</option>';
                    }

                }
                ?>
                </select> 

            </p>
            <p><?php _e('Number of Posts', '1pixel') ?>: <input name="<?php echo $this->get_field_name('number_posts'); ?>" type="text" value="<?php echo esc_attr($number_posts); ?>" size="2" maxlength="2" /></p>
            <p><?php _e('Number of Colums', '1pixel') ?>: <input name="<?php echo $this->get_field_name('columns'); ?>" type="text" value="<?php echo esc_attr($columns); ?>" size="2" maxlength="2" /></p>
            <p><?php _e('Show Caption', '1pixel') ?>: <input type="checkbox" name="<?php echo $this->get_field_name('show_caption'); ?>" <?php echo $show_caption ?>></p>
        <?php
        }

    //save our widget settings
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags(esc_attr($new_instance['title']));
        $instance['post_type'] = strip_tags(esc_attr($new_instance['post_type']));
        $instance['number_posts'] = intval($new_instance['number_posts']);
        $instance['columns'] = intval($new_instance['columns']);
        $instance['show_caption'] = $new_instance['show_caption'];
        
        return $instance;
    }

    //display our widget
    function widget($args, $instance) {
        global $post;
        extract($args);

        echo $before_widget;
        $title = apply_filters('widget_title', $instance['title']);
        $post_type = empty($instance['post_type']) ? '&nbsp;' : apply_filters('widget_post_type', $instance['post_type']);
        $number_posts = empty($instance['number_posts']) ? '&nbsp;' : apply_filters('widget_number_posts', $instance['number_posts']);
        $columns = empty($instance['columns']) ? '2' : apply_filters('widget_columns', $instance['columns']);
        $show_caption = isset($instance['show_caption']) ? '' : 'display:none;';

        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        };
        ?>
        
        <?php
        //if there are sticky posts it adds to 'posts_per_page' in our wp_query so we need to subtract from
        //the posts_per_page amount by our amount of sticky posts
        if ($post_type == 'post') {
            $count_stickies = count( get_option( 'sticky_posts' ) );
            $number_posts = $number_posts - $count_stickies;
        }

        ?>
                                
                                
        <?php
        $wpbp = new WP_Query(array(
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'post_type' => $post_type,
                    'posts_per_page' => $number_posts
                ));
        ?>

    <div id="home-category-boxes">
                <ul class="small-block-grid-2 large-block-grid-<?php echo $columns ?>">
                    <?php if ($wpbp->have_posts()) : while ($wpbp->have_posts()) : $wpbp->the_post(); ?>

                            <li>
                                <div class="cat-header-wrapper">
                                <a href="<?php the_permalink() ?>" rel="<?php _e("bookmark", "1pixel"); ?>" title="<?php _e("Permanent Link to", "1pixel"); ?> <?php the_title(); ?>">
                                    <?php
                                    if (has_post_thumbnail()) {
                                        the_post_thumbnail();
                                    } else {
                                        ?>
                                        <img src="<?php echo DEFAULT_IMG_545; ?>" alt="<?php the_title(); ?>" />
                                    <?php } ?>
                                </a>
                                <div class="cat-header" style="<?php echo $show_caption ?>"><a href="<?php the_permalink(); ?>" title="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></a></div>
                            </div>
                            </li>
                            <?php
                        endwhile;
                    endif;
                    ?>
                <?php wp_reset_query(); ?>
                </ul>
            </div>

        <?php
        echo $after_widget;
    }
}

//showcase Boxes usually for home page
class onepix_portfolio_boxes extends WP_Widget {

    //process our new widget
    function onepix_portfolio_boxes() {
        $widget_ops = array('classname' => 'onepix_portfolio_boxes', 'description' => __('Display Image Boxes that link to showcase Skills', '1pixel'));
        $this->__construct('onepix_portfolio_boxes', __('One Pixel | showcase Boxes Widget', '1pixel'), $widget_ops);
    }

    //build our widget settings form
    function form($instance) {
        $defaults = array(
            'columns' => '3',
            'exclude' => '',
            );
        $instance = wp_parse_args((array) $instance, $defaults);
        $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
        $columns = strip_tags($instance['columns']);
        $exclude = strip_tags($instance['exclude']);
        $show_caption = isset($instance['show_caption']) ? ' checked="checked"' : '';
        ?>
            <p><?php _e('Title', '1pixel') ?>: <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
            <p><?php _e('Number of Columns', '1pixel') ?>: <input name="<?php echo $this->get_field_name('columns'); ?>" type="text" value="<?php echo esc_attr($columns); ?>" size="2" maxlength="2" /></p>
            <p><?php _e('Exclude Skill IDs, for example 34,45,66', '1pixel') ?>: <input class="widefat" name="<?php echo $this->get_field_name('exclude'); ?>" type="text" value="<?php echo esc_attr($exclude); ?>" /></p>
            <p><?php _e('Show Caption', '1pixel') ?>: <input type="checkbox" name="<?php echo $this->get_field_name('show_caption'); ?>" <?php echo $show_caption ?>></p>
        <?php
        }

    //save our widget settings
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags(esc_attr($new_instance['title']));
        $instance['columns'] = intval($new_instance['columns']);
        $instance['exclude'] = strip_tags(esc_attr($new_instance['exclude']));
        $instance['show_caption'] = $new_instance['show_caption'];

        return $instance;
    }

    //display our widget
    function widget($args, $instance) {
        global $post;
        extract($args);

        echo $before_widget;
        $title = apply_filters('widget_title', $instance['title']);
        $columns = empty($instance['columns']) ? '2' : apply_filters('widget_columns', $instance['columns']);
        $exclude = apply_filters('exclude', $instance['exclude']);
        $exclude = trim($exclude); // trim whitespace
        $excludeArray = onepix_string_to_array($exclude); // convert to an array
        $show_caption = isset($instance['show_caption']) ? '' : 'display:none;';
        


        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        };
        
        ?>
        
                  
        <?php
        //display taxonomy terms (skills)
        $taxonomy = TAXONOMY_NAME . 's';
        $tax_terms = get_terms($taxonomy, array(
            'hide_empty' => false,
            'exclude' => $excludeArray
            ));
        //make column amount match number of terms
        $term_count = count($tax_terms);
        ?>
    <div id="home-category-boxes">
            <ul class="small-block-grid-2 large-block-grid-<?php echo $columns ?>">
                <?php
                $i = 0;
                foreach ($tax_terms as $tax_term) {
                    if ($i < $term_count) {
                        $t_ID = $tax_term->term_id;
                        $term_data = get_option("taxonomy_$t_ID");
                        ?>
                        <li>
                            <div class="cat-header-wrapper">
                            <a href="<?php echo esc_attr(get_term_link($tax_term, $taxonomy)) ?>" title="<?php echo sprintf(__("View all %s"), $tax_term->name) ?>">
                                <?php if ($term_data['imgurl_term_meta'] !== '') {
                                    ?>

                                    <img src="<?php echo $term_data['imgurl_term_meta'] ?>">

                                <?php } else { ?>
                                    <img src="<?php echo DEFAULT_IMG_545; ?>" alt="placeholder" />
                                <?php } ?>
                            </a>
                            <div class="cat-header" style="<?php echo $show_caption ?>"><a href="<?php echo esc_attr(get_term_link($tax_term, $taxonomy)) ?>" title="<?php echo sprintf(__("View all %s"), $tax_term->name) ?>"><?php echo $tax_term->name ?></a></div>
                            </div>
                        </li>
                        <?php
                        $i++;
                    } else {  // Jump out of the loop if we hit the maximum
                        break;
                    }
                }
                ?>
            </ul>
    </div>
    <div class="clear"></div>
      
        <?php
        echo $after_widget;
    }
}

//Woocommerce Category Boxes usually for home page
class onepix_woocat_boxes extends WP_Widget {

    //process our new widget
    function onepix_woocat_boxes() {
        $widget_ops = array('classname' => 'onepix_woocat_boxes', 'description' => __('Display Image Boxes that link to WooCommerce Categories', '1pixel'));
        $this->__construct('onepix_woocat_boxes', __('One Pixel | Product Category Boxes Widget', '1pixel'), $widget_ops);
    }

    //build our widget settings form
    function form($instance) {
        $defaults = array(
            'number_products' => '5',
            'columns' => 3,
            'exclude' => '',
            );
        $instance = wp_parse_args((array) $instance, $defaults);
        $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
        $number_products = strip_tags($instance['number_products']);
        $columns = strip_tags($instance['columns']);
        $exclude = strip_tags($instance['exclude']);
        $show_caption = isset($instance['show_caption']) ? ' checked="checked"' : '';
        ?>
            <p><?php _e('Title', '1pixel') ?>: <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
            <p><?php _e('Product Categories', '1pixel') ?>: <input name="<?php echo $this->get_field_name('number_products'); ?>" type="text" value="<?php echo esc_attr($number_products); ?>" size="2" maxlength="2" /></p>
            <p><?php _e('Number of Columns', '1pixel') ?>: <input name="<?php echo $this->get_field_name('columns'); ?>" type="text" value="<?php echo esc_attr($columns); ?>" size="2" maxlength="2" /></p>
            <p><?php _e('Exclude Product Category IDs, for example 34,45,66', '1pixel') ?>: <input class="widefat" name="<?php echo $this->get_field_name('exclude'); ?>" type="text" value="<?php echo esc_attr($exclude); ?>" /></p>
            <p><?php _e('Show Caption', '1pixel') ?>: <input type="checkbox" name="<?php echo $this->get_field_name('show_caption'); ?>" <?php echo $show_caption ?>></p>
        <?php
    }

    //save our widget settings
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags(esc_attr($new_instance['title']));
        $instance['number_products'] = intval($new_instance['number_products']);
        $instance['columns'] = intval($new_instance['columns']);
        $instance['exclude'] = strip_tags(esc_attr($new_instance['exclude']));
        $instance['show_caption'] = $new_instance['show_caption'];

        return $instance;
    }

    //display our widget
    function widget($args, $instance) {
        global $post;
        extract($args);

        echo $before_widget;
        $title = apply_filters('widget_title', $instance['title']);
        $number_products = empty($instance['number_products']) ? '&nbsp;' : apply_filters('widget_number_products', $instance['number_products']);
        $columns = empty($instance['columns']) ? '2' : apply_filters('widget_columns', $instance['columns']);
        $exclude = apply_filters('exclude', $instance['exclude']);
        $exclude = trim($exclude); // trim whitespace
        $excludeArray = onepix_string_to_array($exclude); // convert to an array
        $show_caption = isset($instance['show_caption']) ? '' : 'display:none;';
        
        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        };
        ?>
                                    
        <?php
            global $post;

            $args = array(
                'hide_empty' => 0, 
                'orderby' => 'ASC', 
                'number' => $number_products,
                'exclude' => $excludeArray
                );
             ?>

             <!--<div id="home-category-boxes-wrapper">  for category boxes to overlap featured image -->
             <div id="home-category-boxes">
                <ul class="small-block-grid-2 large-block-grid-<?php echo $columns ?>">

                    <?php
                    $catTerms = get_terms('product_cat', $args);
                    $i = 0;

                    if ( ! empty( $catTerms ) && ! is_wp_error( $catTerms ) ){

                            foreach ($catTerms as $catTerm) :
                            
                            $thumbnail_id = get_woocommerce_term_meta($catTerm->term_id, 'thumbnail_id', true);
                            // get the image URL
                            $image = wp_get_attachment_url($thumbnail_id);
                            ?>

                            <li id="home-cat-box" class="cat-term-id-<?php echo $catTerm->term_id; ?> term-number-<?php echo $i ?>">
                                <div class="cat-header-wrapper">
                                <?php if ($image !== '') {
                                    ?>

                                    <a href="?product_cat=<?php echo $catTerm->slug; ?>">
                                        <img src="<?php echo $image ?>">
                                    </a>

                                <?php } else { ?>
                                    <img src="<?php echo DEFAULT_IMG_545; ?>" alt="placeholder" />
                                <?php } ?>

                                <div class="cat-header" style="<?php echo $show_caption ?>">
                                        <a href="?product_cat=<?php echo $catTerm->slug; ?>"><?php echo $catTerm->name; ?></a>
                                </div>

                                </div>
                            </li>
                            <?php
                            $i++;
                        endforeach;  
                    }
                    else {
                        echo "Please ensure WooCommerce is enabled to use this widget";
                    }
                    ?>     

                </ul>
             </div>
            <div class="clear"></div>
        
        <?php
        echo $after_widget;
    }
}

//Font Awesome Title for subfooter titles
class onepix_fa_title extends WP_Widget {

    //process our new widget
    function onepix_fa_title() {
        $widget_ops = array('classname' => 'onepix_fa_title', 'description' => __('Use FontAwesome title instead of standard widget title', '1pixel'));
        $this->__construct('onepix_fa_title', __('One Pixel | FontAwesome Widget Title', '1pixel'), $widget_ops);
    }

    //build our widget settings form
    function form($instance) {
        $defaults = array(
            'title' => __('', '1pixel'), 
            'fa_icon' => 'fa-coffee'
            );
        $instance = wp_parse_args((array) $instance, $defaults);
        $title = strip_tags($instance['title']);
        $fa_icon = strip_tags($instance['fa_icon']);
        ?>
                <p><?php _e('Title', '1pixel') ?>: <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
                <p><?php _e('FontAwesome Icon', '1pixel') ?>: <input name="<?php echo $this->get_field_name('fa_icon'); ?>" type="text" value="<?php echo esc_attr($fa_icon); ?>" /></p>
                <?php
            }

            //save our widget settings
            function update($new_instance, $old_instance) {
                $instance = $old_instance;
                $instance['title'] = strip_tags(esc_attr($new_instance['title']));
                $instance['fa_icon'] = strip_tags(esc_attr($new_instance['fa_icon']));

                return $instance;
            }

            //display our widget
            function widget($args, $instance) {
                global $post;
                extract($args);

                echo $before_widget;
                $title = apply_filters('widget_title', $instance['title']);
                $fa_icon = empty($instance['fa_icon']) ? '&nbsp;' : apply_filters('widget_fa_icon', $instance['fa_icon']);

                if (!empty($title)) {
                    echo $before_title . '<i class="fa ' .  $fa_icon . '"></i>&nbsp;&nbsp;' . $title . $after_title;
                };
                ?>

        <!--    </div>-->
            <div class="clear"></div>
                                
        <?php
        echo $after_widget;
    }
}

//Image circles normally for home page below featured
class onepix_img_circles extends WP_Widget {

    //process our new widget
    function onepix_img_circles() {
        $widget_ops = array('classname' => 'onepix_img_circles', 'description' => __('Call to action image circles', '1pixel'));
        $this->__construct('onepix_img_circles', __('One Pixel | Image Circles', '1pixel'), $widget_ops);
    }

    //build our widget settings form
    function form($instance) {
        
        $defaults = array(
            'columns' => __('3', '1pixel'), 
            'shape' => __('circle', '1pixel'), 
            'circle1_title' => __('', '1pixel'), 
            'circle1_img_url' => DEFAULT_IMG_545,
            'circle1_icon' => 'fa-coffee',
            'circle1_link' => '#',
            'circle1_info' => __('', '1pixel'),
            'circle2_title' => __('', '1pixel'), 
            'circle2_img_url' => DEFAULT_IMG_545,
            'circle2_icon' => 'fa-coffee',
            'circle2_link' => '#',
            'circle2_info' => __('', '1pixel'),
            'circle3_title' => __('', '1pixel'), 
            'circle3_img_url' => DEFAULT_IMG_545,
            'circle3_icon' => 'fa-coffee',
            'circle3_link' => '#',
            'circle3_info' => __('', '1pixel'),
            'circle4_title' => __('', '1pixel'), 
            'circle4_img_url' => DEFAULT_IMG_545,
            'circle4_icon' => 'fa-coffee',
            'circle4_link' => '#',
            'circle4_info' => __('', '1pixel')
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        
        $columns = strip_tags($instance['columns']);
        $shape = strip_tags($instance['shape']);
        $circle1_title = strip_tags($instance['circle1_title']);
        $circle1_img_url = strip_tags($instance['circle1_img_url']);
        $circle1_icon = strip_tags($instance['circle1_icon']);
        $circle1_link = strip_tags($instance['circle1_link']);
        $circle1_info = strip_tags($instance['circle1_info']);
        
        $circle2_title = strip_tags($instance['circle2_title']);
        $circle2_img_url = strip_tags($instance['circle2_img_url']);
        $circle2_icon = strip_tags($instance['circle2_icon']);
        $circle2_link = strip_tags($instance['circle2_link']);
        $circle2_info = strip_tags($instance['circle2_info']);
        
        $circle3_title = strip_tags($instance['circle3_title']);
        $circle3_img_url = strip_tags($instance['circle3_img_url']);
        $circle3_icon = strip_tags($instance['circle3_icon']);
        $circle3_link = strip_tags($instance['circle3_link']);
        $circle3_info = strip_tags($instance['circle3_info']);
        
        $circle4_title = strip_tags($instance['circle4_title']);
        $circle4_img_url = strip_tags($instance['circle4_img_url']);
        $circle4_icon = strip_tags($instance['circle4_icon']);
        $circle4_link = strip_tags($instance['circle4_link']);
        $circle4_info = strip_tags($instance['circle4_info']);
        ?> 
        <h4>General Settings</h4>
        <p><?php _e('Columns', '1pixel') ?>:
            <select name="<?php echo $this->get_field_name('columns'); ?>">
                <option value='2' <?php if ($columns == '2'){echo 'selected';} ?>>2</option>
                <option value='3' <?php if ($columns == '3'){echo 'selected';} ?>>3</option>
                <option value='4' <?php if ($columns == '4'){echo 'selected';} ?>>4</option>
            </select>
        </p>
        <p><?php _e('Shape', '1pixel') ?>:
            <select name="<?php echo $this->get_field_name('shape'); ?>">
                <option value='circle' <?php if ($shape == 'circle'){echo 'selected';} ?>>Circle</option>
                <option value='other' <?php if ($shape == 'other'){echo 'selected';} ?>>Other</option>
            </select>
        </p>
        <h4>Circle 1</h4>
        <p><?php _e('Circle 1 Title', '1pixel') ?>: <input class="widefat media-upload-input" name="<?php echo $this->get_field_name('circle1_title'); ?>" type="text" value="<?php echo esc_attr($circle1_title); ?>" /></p>
        <p><?php _e('Circle 1 Image Url', '1pixel') ?>: 
            <input class="widefat media-upload-input custom_media_url" id="onepix_circle1_img_url" name="<?php echo $this->get_field_name('circle1_img_url'); ?>" type="text" value="<?php echo esc_attr($circle1_img_url); ?>" />
            <input class='button upload-media-btn' type='button' data-input-id='onepix_circle1_img_url' id='onepix_circle1_img_url_button' value='Upload Image' >
        </p>
        <p><?php _e('Circle 1 Icon', '1pixel') ?>: <input class="widefat" name="<?php echo $this->get_field_name('circle1_icon'); ?>" type="text" value="<?php echo esc_attr($circle1_icon); ?>" /></p>
        <p><?php _e('Circle 1 Link', '1pixel') ?>: <input class="widefat" name="<?php echo $this->get_field_name('circle1_link'); ?>" type="text" value="<?php echo esc_attr($circle1_link); ?>" /></p>
        <p><?php _e('Circle 1 Info', '1pixel') ?>: <input class="widefat" name="<?php echo $this->get_field_name('circle1_info'); ?>" type="text" value="<?php echo esc_attr($circle1_info); ?>" /></p>
        <h4>Circle 2</h4>
        <p><?php _e('Circle 2 Title', '1pixel') ?>: <input class="widefat" name="<?php echo $this->get_field_name('circle2_title'); ?>" type="text" value="<?php echo esc_attr($circle2_title); ?>" /></p>
        <p><?php _e('Circle 2 Image Url', '1pixel') ?>: 
            <input class="widefat media-upload-input custom_media_url" id="onepix_circle2_img_url" name="<?php echo $this->get_field_name('circle2_img_url'); ?>" type="text" value="<?php echo esc_attr($circle2_img_url); ?>" />
            <input class='button upload-media-btn' type='button' data-input-id='onepix_circle2_img_url' id='onepix_circle2_img_url_button' value='Upload Image' >
        </p>
        <p><?php _e('Circle 2 Icon', '1pixel') ?>: <input class="widefat" name="<?php echo $this->get_field_name('circle2_icon'); ?>" type="text" value="<?php echo esc_attr($circle2_icon); ?>" /></p>
        <p><?php _e('Circle 2 Link', '1pixel') ?>: <input class="widefat" name="<?php echo $this->get_field_name('circle2_link'); ?>" type="text" value="<?php echo esc_attr($circle2_link); ?>" /></p> 
        <p><?php _e('Circle 2 Info', '1pixel') ?>: <input class="widefat" name="<?php echo $this->get_field_name('circle2_info'); ?>" type="text" value="<?php echo esc_attr($circle2_info); ?>" /></p>
        <h4>Circle 3</h4>
        <p><?php _e('Circle 3 Title', '1pixel') ?>: <input class="widefat" name="<?php echo $this->get_field_name('circle3_title'); ?>" type="text" value="<?php echo esc_attr($circle3_title); ?>" /></p>
        <p><?php _e('Circle 3 Image Url', '1pixel') ?>: 
            <input class="widefat media-upload-input custom_media_url" id="onepix_circle3_img_url" name="<?php echo $this->get_field_name('circle3_img_url'); ?>" type="text" value="<?php echo esc_attr($circle3_img_url); ?>" />
            <input class='button upload-media-btn' type='button' data-input-id='onepix_circle3_img_url' id='onepix_circle3_img_url_button' value='Upload Image' >
        </p>
        
        <p><?php _e('Circle 3 Icon', '1pixel') ?>: <input class="widefat" name="<?php echo $this->get_field_name('circle3_icon'); ?>" type="text" value="<?php echo esc_attr($circle3_icon); ?>" /></p>
        <p><?php _e('Circle 3 Link', '1pixel') ?>: <input class="widefat" name="<?php echo $this->get_field_name('circle3_link'); ?>" type="text" value="<?php echo esc_attr($circle3_link); ?>" /></p> 
        <p><?php _e('Circle 3 Info', '1pixel') ?>: <input class="widefat" name="<?php echo $this->get_field_name('circle3_info'); ?>" type="text" value="<?php echo esc_attr($circle3_info); ?>" /></p>
        <h4>Circle 4</h4>
        <p><?php _e('Circle 4 Title', '1pixel') ?>: <input class="widefat" name="<?php echo $this->get_field_name('circle4_title'); ?>" type="text" value="<?php echo esc_attr($circle4_title); ?>" /></p>
        <p><?php _e('Circle 4 Image Url', '1pixel') ?>: 
            <input class="widefat media-upload-input custom_media_url" id="onepix_circle4_img_url" name="<?php echo $this->get_field_name('circle4_img_url'); ?>" type="text" value="<?php echo esc_attr($circle4_img_url); ?>" />
            <input class='button upload-media-btn' type='button' data-input-id='onepix_circle4_img_url' id='onepix_circle4_img_url_button' value='Upload Image' >
        </p>
        <p><?php _e('Circle 4 Icon', '1pixel') ?>: <input class="widefat" name="<?php echo $this->get_field_name('circle4_icon'); ?>" type="text" value="<?php echo esc_attr($circle4_icon); ?>" /></p>
        <p><?php _e('Circle 4 Link', '1pixel') ?>: <input class="widefat" name="<?php echo $this->get_field_name('circle4_link'); ?>" type="text" value="<?php echo esc_attr($circle4_link); ?>" /></p> 
        <p><?php _e('Circle 4 Info', '1pixel') ?>: <input class="widefat" name="<?php echo $this->get_field_name('circle4_info'); ?>" type="text" value="<?php echo esc_attr($circle4_info); ?>" /></p>
                            
     <?php
    }

    //save our widget settings
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        
        $instance['columns'] = strip_tags(esc_attr($new_instance['columns']));
        $instance['shape'] = strip_tags(esc_attr($new_instance['shape']));
        $instance['circle1_title'] = strip_tags(esc_attr($new_instance['circle1_title']));
        $instance['circle1_img_url'] = strip_tags(esc_attr($new_instance['circle1_img_url']));
        $instance['circle1_icon'] = strip_tags(esc_attr($new_instance['circle1_icon']));
        $instance['circle1_link'] = strip_tags(esc_attr($new_instance['circle1_link']));
        $instance['circle1_info'] = strip_tags(esc_attr($new_instance['circle1_info']));
        
        $instance['circle2_title'] = strip_tags(esc_attr($new_instance['circle2_title']));
        $instance['circle2_img_url'] = strip_tags(esc_attr($new_instance['circle2_img_url']));
        $instance['circle2_icon'] = strip_tags(esc_attr($new_instance['circle2_icon']));
        $instance['circle2_link'] = strip_tags(esc_attr($new_instance['circle2_link']));
        $instance['circle2_info'] = strip_tags(esc_attr($new_instance['circle2_info']));
        
        $instance['circle3_title'] = strip_tags(esc_attr($new_instance['circle3_title']));
        $instance['circle3_img_url'] = strip_tags(esc_attr($new_instance['circle3_img_url']));
        $instance['circle3_icon'] = strip_tags(esc_attr($new_instance['circle3_icon']));
        $instance['circle3_link'] = strip_tags(esc_attr($new_instance['circle3_link']));
        $instance['circle3_info'] = strip_tags(esc_attr($new_instance['circle3_info']));
        
        $instance['circle4_title'] = strip_tags(esc_attr($new_instance['circle4_title']));
        $instance['circle4_img_url'] = strip_tags(esc_attr($new_instance['circle4_img_url']));
        $instance['circle4_icon'] = strip_tags(esc_attr($new_instance['circle4_icon']));
        $instance['circle4_link'] = strip_tags(esc_attr($new_instance['circle4_link']));
        $instance['circle4_info'] = strip_tags(esc_attr($new_instance['circle4_info']));

        return $instance;
    }

    //display our widget
    function widget($args, $instance) {
        extract($args);

        echo $before_widget;
        
        $content_display_4 = '';
        
        $columns = $instance['columns'];
        $shape = $instance['shape'];
        
        $circle1_title = $instance['circle1_title'];
        $circle1_img_url = $instance['circle1_img_url'];
        if(!$circle1_img_url) { $circle1_img_url = DEFAULT_IMG_545; }
        $circle1_icon = empty($instance['circle1_icon']) ? $content_display_1 = 'display:none;' : $instance['circle1_icon'];
        $circle1_link = empty($instance['circle1_link']) ? $content_display_1 = 'display:none;' : $instance['circle1_link'];
        $circle1_info = empty($instance['circle1_info']) ? '' : $instance['circle1_info'];
        
        $circle2_title = $instance['circle2_title'];
        $circle2_img_url = $instance['circle2_img_url'];
        if(!$circle2_img_url) { $circle2_img_url = DEFAULT_IMG_545; }
        $circle2_icon = empty($instance['circle2_icon']) ? $content_display_2 = 'display:none;' : $instance['circle2_icon'];
        $circle2_link = empty($instance['circle2_link']) ? $content_display_2 = 'display:none;' : $instance['circle2_link'];
        $circle2_info = empty($instance['circle2_info']) ? '' : $instance['circle2_info'];
        
        $circle3_title = $instance['circle3_title'];
        $circle3_img_url = $instance['circle3_img_url'];
        if(!$circle3_img_url) { $circle3_img_url = DEFAULT_IMG_545; }
        $circle3_icon = empty($instance['circle3_icon']) ? $content_display_3 = 'display:none;' : $instance['circle3_icon'];
        $circle3_link = empty($instance['circle3_link']) ? $content_display_3 = 'display:none;' : $instance['circle3_link'];
        $circle3_info = empty($instance['circle3_info']) ? '' : $instance['circle3_info'];
        
        $circle4_title = $instance['circle4_title'];
        $circle4_img_url = $instance['circle4_img_url'];
        if(!$circle4_img_url) { $circle4_img_url = DEFAULT_IMG_545; }
        $circle4_icon = empty($instance['circle4_icon']) ? $content_display_4 = 'display:none;' : $instance['circle4_icon'];
        $circle4_link = empty($instance['circle4_link']) ? $content_display_4 = 'display:none;' : $instance['circle4_link'];
        $circle4_info = empty($instance['circle4_info']) ? '' : $instance['circle4_info'];

        ?>
            
        <?php if($columns == '4') { ?>
                        
        <div id="home-circle-callboxes-wrapper">
            <!-- not the "four-col" class. this is because the circles need to be smaller for this one-->
            <div id="home-circle-callboxes" class="<?php echo $shape ?> four-col">

                <ul class="large-block-grid-4 media-center-lg">
                    <li>
                        <div class="cat-header-wrapper">
                            <div class="cat-header-image">
                                <a href="<?php echo $circle1_link ?>"><img src="<?php echo $circle1_img_url ?>"></a>       		        
                            </div>
                            <div class="circle-caption">
                                <?php if ($circle1_title): ?><a class="caption-title" href="<?php echo $circle1_link ?>"><h3><?php echo $circle1_title ?></h3></a><?php endif ?>
                                <?php if ($circle1_info): ?><div class="caption-info"><?php echo do_shortcode(html_entity_decode($circle1_info)); ?></div>
                                    <a class="read-more" href="<?php echo $circle1_link ?>">Read More &rarr;</a>
                                <?php endif ?>

                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="cat-header-wrapper">
                            <div class="cat-header-image">
                                <a href="<?php echo $circle1_link ?>"><img src="<?php echo $circle1_img_url ?>"></a>       		        
                            </div>
                            <div class="circle-caption">
                                <?php if ($circle1_title): ?><a class="caption-title" href="<?php echo $circle1_link ?>"><h3><?php echo $circle1_title ?></h3></a><?php endif ?>
                                <?php if ($circle1_info): ?><div class="caption-info"><?php echo do_shortcode(html_entity_decode($circle1_info)); ?></div>
                                    <a class="read-more" href="<?php echo $circle1_link ?>">Read More &rarr;</a>
                                <?php endif ?>

                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="cat-header-wrapper">
                            <div class="cat-header-image">
                                <a href="<?php echo $circle2_link ?>"><img src="<?php echo $circle2_img_url ?>"></a>       		        
                            </div>
                            <div class="circle-caption">
                                <?php if ($circle2_title): ?><a class="caption-title" href="<?php echo $circle2_link ?>"><h3><?php echo $circle2_title ?></h3></a><?php endif ?>
                                <?php if ($circle2_info): ?><div class="caption-info"><?php echo do_shortcode(html_entity_decode($circle2_info)); ?></div>
                                    <a class="read-more" href="<?php echo $circle2_link ?>">Read More &rarr;</a>
                                <?php endif ?>

                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="cat-header-wrapper">
                            <div class="cat-header-image">
                                <a href="<?php echo $circle3_link ?>"><img src="<?php echo $circle3_img_url ?>"></a>       		        
                            </div>
                            <div class="circle-caption">
                                <?php if ($circle3_title): ?><a class="caption-title" href="<?php echo $circle3_link ?>"><h3><?php echo $circle3_title ?></h3></a><?php endif ?>
                                <?php if ($circle3_info): ?><div class="caption-info"><?php echo do_shortcode(html_entity_decode($circle3_info)); ?></div>
                                    <a class="read-more" href="<?php echo $circle3_link ?>">Read More &rarr;</a>
                                <?php endif ?>

                            </div>
                        </div>
                    </li>
                </ul>

            </div>
        </div> 
            
        <?php } else if($columns == '3') { ?>
      
        <div id="home-circle-callboxes-wrapper">
            <div id="home-circle-callboxes" class="<?php echo $shape ?>">

                <ul class="large-block-grid-3 media-center-lg">
                    <li>
                        <div class="cat-header-wrapper">
                            <div class="cat-header-image">
                                <a href="<?php echo $circle1_link ?>"><img src="<?php echo $circle1_img_url ?>"></a>       		        
                            </div>
                            <div class="circle-caption">
                                <?php if ($circle1_title): ?><a class="caption-title" href="<?php echo $circle1_link ?>"><h3><?php echo $circle1_title ?></h3></a><?php endif ?>
                                <?php if ($circle1_info): ?><div class="caption-info"><?php echo do_shortcode(html_entity_decode($circle1_info)); ?></div>
                                    <a class="read-more" href="<?php echo $circle1_link ?>">Read More &rarr;</a>
                                <?php endif ?>

                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="cat-header-wrapper">
                            <div class="cat-header-image">
                                <a href="<?php echo $circle2_link ?>"><img src="<?php echo $circle2_img_url ?>"></a>       		        
                            </div>
                            <div class="circle-caption">
                                <?php if ($circle2_title): ?><a class="caption-title" href="<?php echo $circle2_link ?>"><h3><?php echo $circle2_title ?></h3></a><?php endif ?>
                                <?php if ($circle2_info): ?><div class="caption-info"><?php echo do_shortcode(html_entity_decode($circle2_info)); ?></div>
                                    <a class="read-more" href="<?php echo $circle2_link ?>">Read More &rarr;</a>
                                <?php endif ?>

                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="cat-header-wrapper">
                            <div class="cat-header-image">
                                <a href="<?php echo $circle3_link ?>"><img src="<?php echo $circle3_img_url ?>"></a>       		        
                            </div>
                            <div class="circle-caption">
                                <?php if ($circle3_title): ?><a class="caption-title" href="<?php echo $circle3_link ?>"><h3><?php echo $circle3_title ?></h3></a><?php endif ?>
                                <?php if ($circle3_info): ?><div class="caption-info"><?php echo do_shortcode(html_entity_decode($circle3_info)); ?></div>
                                    <a class="read-more" href="<?php echo $circle3_link ?>">Read More &rarr;</a>
                                <?php endif ?>

                            </div>
                        </div>
                    </li>
                </ul>

            </div>
        </div>
                        
             
        <?php } else if($columns == '2') { ?>
                        
        <div id="home-circle-callboxes-wrapper">
            <div id="home-circle-callboxes" class="<?php echo $shape ?>">

                <ul class="large-block-grid-2 media-center-lg">
                    <li>
                        <div class="cat-header-wrapper">
                            <div class="cat-header-image">
                                <a href="<?php echo $circle2_link ?>"><img src="<?php echo $circle2_img_url ?>"></a>       		        
                            </div>
                            <div class="circle-caption">
                                <?php if ($circle2_title): ?><a class="caption-title" href="<?php echo $circle2_link ?>"><h3><?php echo $circle2_title ?></h3></a><?php endif ?>
                                <?php if ($circle2_info): ?><div class="caption-info"><?php echo do_shortcode(html_entity_decode($circle2_info)); ?></div>
                                    <a class="read-more" href="<?php echo $circle2_link ?>">Read More &rarr;</a>
                                <?php endif ?>

                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="cat-header-wrapper">
                            <div class="cat-header-image">
                                <a href="<?php echo $circle3_link ?>"><img src="<?php echo $circle3_img_url ?>"></a>       		        
                            </div>
                            <div class="circle-caption">
                                <?php if ($circle3_title): ?><a class="caption-title" href="<?php echo $circle3_link ?>"><h3><?php echo $circle3_title ?></h3></a><?php endif ?>
                                <?php if ($circle3_info): ?><div class="caption-info"><?php echo do_shortcode(html_entity_decode($circle3_info)); ?></div>
                                    <a class="read-more" href="<?php echo $circle3_link ?>">Read More &rarr;</a>
                                <?php endif ?>

                            </div>
                        </div>
                    </li>
                </ul>

            </div>
        </div>       
                        
        <?php } else { echo 'no columns specified'; } ?>
                                                
        <!--    </div>-->
        <div class="clear"></div>
                                        
        <?php
        echo $after_widget;
    }

}

//full width container with background options to insert your custom text/html
class onepix_fullwidth_container extends WP_Widget {

    //process our new widget
    function onepix_fullwidth_container() {
        $widget_ops = array('classname' => 'onepix_fullwidth_container', 'description' => __('Full width container with background options to insert your custom text/html', '1pixel'));
        $this->__construct('onepix_fullwidth_container', __('One Pixel | Fullwidth Container', '1pixel'), $widget_ops);
    }

    //build our widget settings form
    function form($instance) {
        
        $defaults = array(
            'background_type' => __('parallax', '1pixel'), 
            'background_img_url' => get_bloginfo('template_directory') . '/images/default-parallax-image.jpg',
            'content' => ''
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        $background_type = strip_tags($instance['background_type']);
        $background_img_url = strip_tags($instance['background_img_url']);
        $content = $instance['content'];
        ?> 
                        <h4>Background Type</h4>
                        <p><?php _e('Background Type', '1pixel') ?>:
                            <select name="<?php echo $this->get_field_name('background_type'); ?>">
                                <option value='transparent' <?php if ($background_type == 'transparent'){echo 'selected';} ?>>Transparent</option>
                                <option value='image' <?php if ($background_type == 'image'){echo 'selected';} ?>>Image</option>
                                <option value='plax-img' <?php if ($background_type == 'plax-img'){echo 'selected';} ?>>Parallax Image</option>
                            </select>
                        </p>
                        <h4>Background Image Url</h4>
                        <p><?php _e('Background Image Url', '1pixel') ?>: 

                            <input class="widefat media-upload-input custom_media_url" id="onepix_background_img_url" name="<?php echo $this->get_field_name('background_img_url'); ?>" type="text" value="<?php echo esc_attr($background_img_url); ?>" />
                            <input class='button upload-media-btn' type='button' data-input-id='onepix_background_img_url' id='onepix_background_img_url_button' value='Upload Image' >
                        </p>
                        <h4>Content</h4>
                        <p><?php _e('Custom Text/HTML content', '1pixel') ?>: <textarea class="widefat" name="<?php echo $this->get_field_name('content'); ?>" cols="20" rows="16" ><?php echo esc_attr($content); ?></textarea></p>

   <?php
    }

    //save our widget settings
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        
        $instance['background_type'] = strip_tags(esc_attr($new_instance['background_type']));
        $instance['background_img_url'] = strip_tags(esc_attr($new_instance['background_img_url']));
        $instance['content'] = strip_tags(esc_attr($new_instance['content']));
        
        return $instance;
    }

    //display our widget
    function widget($args, $instance) {
        extract($args);

        echo $before_widget;
        
        $background_type = $instance['background_type'];
        $background_img_url = $instance['background_img_url'];
        $content = $instance['content'];
        
        
       if ($background_type == 'transparent') {
           $background_img_url =  '';
       }
       
       ?>
                        
        <div class="fullwidth-container full-width-img <?php echo $background_type ?>" <?php if($background_img_url !== '') { echo 'style="background-image: url(' . $background_img_url . ')"'; }   ?> >
            <div class="row"> 
                <div class="medium-12 columns">
                    <?php 
                    //must firt decode html entities to output proper html then use do_shortcode to allow shortcodes
                    echo do_shortcode(html_entity_decode($content)); 
                    ?>
                </div>
            </div>
            <div class="clear"></div>
        </div>      
                                        
        <?php
        echo $after_widget;
    }

}

//text and button catch phrase bar usually above the subfooter
class onepix_catch_phrase extends WP_Widget {

    //process our new widget
    function onepix_catch_phrase() {
        $widget_ops = array('classname' => 'onepix_catch_phrase', 'description' => __('Text and button catch phrase bar', '1pixel'));
        $this->__construct('onepix_catch_phrase', __('One Pixel | Catch Phrase', '1pixel'), $widget_ops);
    }

    //build our widget settings form
    function form($instance) {
        
        $defaults = array(
            'phrase' => __('Interested in working with us?', '1pixel'),
            'button_text' => __('Request a Consultation', '1pixel'),
            'link' => __('#', '1pixel'), 
            
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        $phrase = strip_tags($instance['phrase']);
        $button_text = strip_tags($instance['button_text']);
        $link = strip_tags($instance['link']);
        ?> 
        <h4>Catch Phrase</h4>
        <p><?php _e('Your catch phrase', '1pixel') ?>: <input class="widefat" name="<?php echo $this->get_field_name('phrase'); ?>" type="text" value="<?php echo esc_attr($phrase); ?>" /></p>
        <h4>Button Text</h4>
        <p><?php _e('Text to appear inside the button', '1pixel') ?>: <input class="widefat" name="<?php echo $this->get_field_name('button_text'); ?>" type="text" value="<?php echo esc_attr($button_text); ?>" /></p>
        <h4>Link</h4>
        <p><?php _e('The URL the button links to', '1pixel') ?>: <input class="widefat" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo esc_attr($link); ?>" /></p>
        <?php
        }

    //save our widget settings
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        
        $instance['phrase'] = strip_tags(esc_attr($new_instance['phrase']));
        $instance['button_text'] = strip_tags(esc_attr($new_instance['button_text']));
        $instance['link'] = strip_tags(esc_attr($new_instance['link']));
        
        return $instance;
    }

    //display our widget
    function widget($args, $instance) {
        extract($args);

        echo $before_widget;
        
        $phrase = $instance['phrase'];
        $button_text = $instance['button_text'];
        $link = $instance['link'];

       ?>
                        
        <div class="catch-phrase">
            <div class="row">
                <div class="medium-8 columns media-center-med">
                    <div class="left catch-phrase-text"><?php echo $phrase ?></div>
                </div>
                <div class="medium-4 columns media-center-med">
                    <a href="<?php echo $link ?>" class="btn shadow medium right" style="background-color:#121212;"><?php echo $button_text ?></a>
                </div>
            </div>
        </div>         
                         
        <?php
        echo $after_widget;
    }

}

class onepix_spacer extends WP_Widget {

    //process our new widget
    function onepix_spacer() {
        $widget_ops = array('classname' => 'onepix_spacer', 'description' => __('Spacer for home page widgets', '1pixel'));
        $this->__construct('onepix_spacer', __('One Pixel | Spacer', '1pixel'), $widget_ops);
    }

    //build our widget settings form
    function form($instance) {
        
        ?> 
        <h4>Widget Spacer</h4>
        <?php
        }

    //display our widget
    function widget($args, $instance) {
        extract($args);
        echo $before_widget;
       ?>
                        
        <div class="onepix-widget-spacer"></div>         
                         
        <?php
        echo $after_widget;
    }

}
?>