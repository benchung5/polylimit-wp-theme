<?php
/*
 * Template Name: Fullwidth
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
// calling the header.php
get_header();
?>

<?php if(is_front_page() || is_home()) { ?>

    <?php get_template_part( 'temp', 'belowheader-home' ); ?>

<?php } else if (onepix_is_shop() || onepix_is_cart() || onepix_is_checkout()) { ?>

    <?php get_template_part( 'temp', 'belowheader-shop' ); ?>

<?php } else { ?>

    <?php get_template_part( 'temp', 'belowheader-page' ); ?>

<?php } ?>

<div class="row">
    <!--check if this is a WooCommerce page to get right sidebar (some pages need this others have their own templates)-->
    <?php if (onepix_is_cart() || onepix_is_checkout()) { ?>
        <div id="content" class="large-12 columns">
            <?php if (have_posts()) while (have_posts()) : the_post(); ?>

                    <?php the_content(); ?>

                <?php endwhile; ?>
            <div class="spacer"></div>
        </div><!--#content-->
        <?php
        /**
         * woocommerce_sidebar hook
         *
         * @hooked woocommerce_get_sidebar - 10
         */
//        do_action('woocommerce_sidebar');
        ?>
    <?php } else { ?>
        <div id="content" class="large-12 columns">
            <?php if (have_posts()) while (have_posts()) : the_post(); ?>

                    <?php the_content(); ?>

                <?php endwhile; ?>
        </div><!--#content-->
    <?php } ?>

</div><!--row-->
<?php get_footer(); ?>
