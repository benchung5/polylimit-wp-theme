<?php 
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header(); ?>

<?php get_template_part( 'temp', 'belowheader-page' ); ?>

<?php
//if is custom post type page
if('onepix_' . SHOWCASE_NAME == get_post_type()) {
?>
    <div class="row">
        <div id="content" class="large-12 columns">

            <?php get_template_part( 'temp', 'showcase' ); ?>
            
        </div><!--#content-->
    </div><!--row-->
<?php    
} else {
?>
<div class="row">
    <div id="content" class="large-8 columns">

        <?php get_template_part('temp', 'posts-1-col'); ?>

        <?php get_template_part('temp', 'post-nav'); ?>
        
    </div><!--#content-->
    
    <?php get_template_part('sidebar-secondary'); ?>
    
</div><!--row-->

<?php
}
?>


<?php get_footer(); ?>




