<?php
/*
 * Template Name: Contact
 */
 if ( ! defined( 'ABSPATH' ) ) { exit; }
    // calling the header.php
    get_header();
?>

<!-- #container -->

<?php get_template_part( 'temp', 'belowheader-page' ); ?>

<div class="row">
    <div id="content" class="large-12 columns">
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

                <?php the_content(); ?>
        
	<?php endwhile; ?>
    </div><!--#content-->
</div><!--row-->
<?php get_footer(); ?>