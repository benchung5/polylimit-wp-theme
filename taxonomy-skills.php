<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
//this template is used for linking homepage skills boxes to a skills taxonomy page showing your selection only
get_header(); 
?>
<?php get_template_part('temp', 'belowheader-page'); ?>
<div class="row">
   <div id="content" class="large-12 columns">
       <?php get_template_part( 'temp', 'showcase' ); ?>
   </div><!--#content-->
</div><!--row-->
<?php get_footer(); ?>
