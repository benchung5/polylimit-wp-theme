<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
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
        <section id="content" class="large-12 columns">
            <?php if (have_posts()) while (have_posts()) : the_post(); ?>

                    <?php the_content(); ?>

                <?php endwhile; ?>
            <div class="spacer"></div>
        </section><!--#content-->
        <?php
        /**
         * woocommerce_sidebar hook
         *
         * @hooked woocommerce_get_sidebar - 10
         */
//        do_action('woocommerce_sidebar');
        ?>
    <?php } else { ?>
        <section id="content" class="large-8 columns">
            <?php if (have_posts()) while (have_posts()) : the_post(); ?>

                    <?php the_content(); ?>

                <?php endwhile; ?>
        </section><!--#content-->
        <?php get_sidebar(); ?>
    <?php } ?>

</div><!--row-->

<?php get_footer(); ?>
