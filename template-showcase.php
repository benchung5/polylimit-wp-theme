<?php 
/* 
 * Template Name: Showcase 
 * a page template version of the showcase archive page
 */ 
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<?php get_header(); ?>
     <?php get_template_part('temp', 'belowheader-page'); ?>
    <section class="row">
        <div id="content" class="large-12 columns">
            <?php get_template_part( 'temp', 'showcase' ); ?>
            
        </div><!--#content-->
    </section><!--row-->
    
<?php get_footer(); ?>
