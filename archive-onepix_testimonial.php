<?php 
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header(); ?>
<?php 
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_template_part( 'temp', 'belowheader-page' ); ?>
<div class="row">
    <!--  change column width if sidebar turned on-->
    <?php if ($onepix_option['onepix_blog_sidebar']) { ?>
            <div id="content" class="large-8 columns">
    <?php } else { ?>
            <div id="content" class="large-12 columns">
    <?php } ?>
        <?php get_template_part('temp', 'posts-standard'); ?>
        <?php get_template_part('temp', 'post-nav'); ?>
        
    </div><!--#content-->
    
    <!--        show sidebar if turned on-->
    <?php if ($onepix_option['onepix_blog_sidebar']) { ?>
        <?php get_template_part('sidebar-secondary'); ?>
    <?php } ?>
    
</div><!--row-->
<?php get_footer(); ?>