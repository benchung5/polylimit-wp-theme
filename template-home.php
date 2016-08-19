<?php
/*
 * Template Name: Home
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
    // calling the header.php
    get_header();
?>

<?php get_template_part( 'temp', 'belowheader-home' ); ?>


<?php if (is_active_sidebar('Home Above Content')) { ?>
    <!--home below content widget area-->
    <section class="home-above-content-wrapper">
        <?php if (!dynamic_sidebar('Home Above Content')) : ?><!--Wigitized Below Content--><?php endif ?>
    </section>
<?php } ?>

<!-- begin home body content-->
<section class="home-body-container">


<!-- content-->
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

        <?php the_content(); ?>

<?php endwhile; ?>


<?php if (is_active_sidebar('Home Below Content')) { ?>
    <!--home below content widget area-->
    <div class="home-below-content-wrapper">
        <?php if (!dynamic_sidebar('Home Below Content')) : ?><!--Wigitized Below Content--><?php endif ?>
    </div>
<?php } ?>

<!--#content-->
<?php get_footer(); ?>