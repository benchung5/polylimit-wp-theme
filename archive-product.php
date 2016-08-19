<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 	WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$onepix_option = onepix_get_global_options();
get_header( 'shop' ); ?>
<?php if(is_front_page() || is_home()) { ?>
    <?php get_template_part( 'temp', 'belowheader-home' ); ?>
<?php } else if (is_shop() || is_product_category()) { ?>
    <?php get_template_part( 'temp', 'belowheader-shop' ); ?>
<?php } else { ?>
    <?php get_template_part( 'temp', 'belowheader-page' ); ?>
<?php } ?>
<div class="row">
        <!--  show sidebar if turned on-->
        <?php if ($onepix_option['onepix_shop_sidebar']) { ?>
        
                <?php
            if (is_shop() || is_product_category() || is_checkout() || is_cart()) {
                if (is_active_sidebar('sidebar-shop')) {
                    wc_get_template_part('temp', 'products-sidebar');
                }
            } else {
                ?>
                <?php
                /**
                 * woocommerce_sidebar hook
                 *
                 * @hooked woocommerce_get_sidebar - 10
                 */
                do_action('woocommerce_sidebar');
                ?>
            <?php } ?>
        
            <div id="content" class="large-9 columns">
        <?php } else { ?>
                
            <div id="content" class="large-12 columns">
                
        <?php } ?>
    
            
        <?php
        /**
         * woocommerce_before_main_content hook
         *
         * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
         * @hooked woocommerce_breadcrumb - 20
         */
        do_action('woocommerce_before_main_content');
        ?>
        
        <?php
////        for displaying category image
//        if (is_product_category()) {
//            global $wp_query;
//            $cat = $wp_query->get_queried_object();
//            $thumbnail_id = get_woocommerce_term_meta($cat->term_id, 'thumbnail_id', true);
//            $image = wp_get_attachment_url($thumbnail_id);
//            if ($image) {
//                echo '<img src="' . $image . '" alt="" />';
//            }
//        }
        ?>
        <?php if (have_posts()) : ?>
            
            <?php
            /**
             * woocommerce_before_shop_loop hook
             *
             * @hooked woocommerce_result_count - 20
             * @hooked woocommerce_catalog_ordering - 30
             */
            do_action('woocommerce_before_shop_loop');
            ?>
            <?php woocommerce_product_loop_start(); ?>
            <?php woocommerce_product_subcategories(); ?>
            <?php while (have_posts()) : the_post(); ?>
                <?php wc_get_template_part('content', 'product'); ?>
            <?php endwhile; // end of the loop. ?>
            <?php woocommerce_product_loop_end(); ?>
            <?php
            /**
             * woocommerce_after_shop_loop hook
             *
             * @hooked woocommerce_pagination - 10
             */
            do_action('woocommerce_after_shop_loop');
            ?>
        <?php elseif (!woocommerce_product_subcategories(array('before' => woocommerce_product_loop_start(false), 'after' => woocommerce_product_loop_end(false)))) : ?>
            <?php wc_get_template('loop/no-products-found.php'); ?>
        <?php endif; ?>
        <?php
        /**
         * woocommerce_after_main_content hook
         *
         * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
         */
        do_action('woocommerce_after_main_content');
        ?>
        
    </div><!--#content-->
</div><!--row-->
<?php get_footer( 'shop' ); ?>