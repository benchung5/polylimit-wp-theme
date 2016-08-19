<?php 
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( 'onepix_testimonial' !== get_post_type() ) { ?>

<div class="meta">

    <?php

    $category = get_the_category();

    if(isset($category, $category[0])) {

    ?>

<!--	<span class="meta-cats">

	<?php// _e('Filed in', "1pixel"); ?> 

	</span>-->

        <time datetime="<?php the_time(get_option('date_format')); ?>"><span class="meta-date"><?php the_time(get_option('date_format')); ?></span></time><span class="meta-category"><span class="meta-separator">|</span><?php echo '<a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>'; ?></span><?php if ('open' == $post->comment_status) { ?><span class="meta-comments"><span class="meta-separator">|</span><a href="<?php comments_link(); ?>" rel="<?php _e("bookmark", "1pixel"); ?>" title="<?php _e("Comments for", "1pixel"); ?> <?php the_title(); ?>"><?php comments_number(__("0 Comments", "1pixel"), __("1 Comment", "1pixel"), __("% Comments", "1pixel")); ?></a></span><?php } ?> 

	<?php } ?> 

</div>

<?php } ?>