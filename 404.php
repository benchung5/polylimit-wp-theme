<?php 
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header(); ?>

<?php get_template_part( 'temp', 'belowheader-page' ); ?>

<div class="row">
    <div id="content" class="large-12 columns">
            <div id="error404" class="post">
                    <h1><?php _e('Error 404 Not Found'); ?></h1>
                    <div class="post-content">
                            <p><?php _e('Oops. Sorry, the page cannot be found.'); ?></p>
                            <p><?php _e('Please check your URL or use the search form below.'); ?></p>
                            <?php get_search_form(); /* outputs the default Wordpress search form */ ?>
                    </div><!--.post-content-->
            </div><!--#error404 .post-->
        <div class="spacer"></div>
    </div><!--#content-->
</div><!--row-->
<?php get_footer(); ?>
