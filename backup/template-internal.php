<?php
/*
 * Template Name: Internal
 * MultiEdit: Block1,Block2,Block3
 */

    // calling the header.php
    get_header();
?>

<!-- main container-->
<?php multieditDisplay('Block1'); ?>
<?php multieditDisplay('Block2'); ?>
<?php multieditDisplay('Block3'); ?>

<div class="row">
    <div id="content" class="large-8 columns">
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

                <?php the_content(); ?>
        
	<?php endwhile; ?>
    </div><!--#content-->
<?php  get_sidebar(); ?>
</div><!--row-->
<?php get_footer(); ?>