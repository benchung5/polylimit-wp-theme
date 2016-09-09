<?php 
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header(); ?>

<?php get_template_part( 'temp', 'belowheader-page' ); ?>

<div class="row">
    <div id="content" class="large-8 columns">
	<?php
		if(isset($_GET['author_name'])) :
			$curauth = get_userdatabylogin($author_name);
	    else :
			$curauth = get_userdata(intval($author));
		endif;
	?>
	<div class="row author">
		
            <div class="medium-2 columns avatar"><?php if(function_exists('get_avatar')) { echo get_avatar( $curauth->user_email, $size = '180' ); } ?></div>
		<?php if($curauth->description !="") { /* Displays the author's description from their Wordpress profile */ ?>
            <div class="medium-10 columns single-author-desc"><p><?php echo $curauth->description; ?></a></p></div>
		<?php } ?>
	</div><!--.author-->
        <div class="spacer"></div>
	
        <!--        Displays the most recent posts by that author. Note that this does not display custom content types-->
        <div id="recent-author-posts">
            <div class="underline-divider-wrapper">
                <h2><?php _e('Recent Posts by '); echo $curauth->display_name; ?></h2>
                <div class="divider solid"></div>
            </div>

            <?php get_template_part('temp', 'posts-standard'); ?>
        
        </div>
	<div id="recent-author-comments">
                <div class="underline-divider-wrapper">
                    <h3><?php _e('Recent Comments by '); echo $curauth->display_name; ?></h3>
                    <div class="divider solid"></div>
                </div>
		<?php
			$number=5; // number of recent comments to display
			$comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_approved = '1' and comment_author_email='$curauth->user_email' ORDER BY comment_date_gmt DESC LIMIT $number");
		?>
		<ul>
		  <?php
                    if ( $comments ) : foreach ( (array) $comments as $comment) :
                        echo  '<li class="recentcomments">' . sprintf(__('%1$s on %2$s'), get_comment_date(), '<a href="'. get_comment_link($comment->comment_ID) . '">' . get_the_title($comment->comment_post_ID) . '</a>') . '</li>';
                        endforeach; else: ?>
                    <p><?php _e('No comments by '); echo $curauth->display_name; ?></p>
		    <?php endif; ?>
		</ul>
	</div><!--#recentAuthorComments-->
        <div class="spacer"></div>
    </div><!--#content-->
<?php get_template_part( 'sidebar-secondary' ); ?>
        <?php // get_sidebar(); ?>
</div><!--row-->
<?php get_footer(); ?>