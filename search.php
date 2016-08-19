<?php 
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header(); ?>

<?php get_template_part( 'temp', 'belowheader-page' ); ?>

<div class="row">
    <div id="content" class="large-8 columns">

        <h1>Search results for:</h1>
        <p><?php the_search_query(); ?></p>

        <?php get_template_part('temp', 'posts-1-col'); ?>

        <?php get_template_part('temp', 'post-nav'); ?>
        
    </div><!--#content-->
    
    <?php get_template_part('sidebar-secondary'); ?>
    
</div><!--row-->
<?php get_footer(); ?>