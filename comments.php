<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
	if ( post_password_required() ) { ?>
		<p class="nocomments">This post is password protected. Enter the password to view comments.</p>
	<?php
		return;
	}
?>
<!-- You can start editing here. -->
<div id="comments">
	<?php if ( have_comments() ) : ?>
		<!-- If there are comments, list them. -->
		<div class="allcomments">
                        <div class="underline-divider-wrapper">
                            <h3><span><?php comments_number(__("No Replies Yet", "1pixel"), __("This Post Has 1 Comment ", "1pixel"), __("This Post Has % Comments", "1pixel")); ?></span></h3>
                            <div class="divider solid"></div>
                        </div>
                    
			<h3 id="comments-title"></h3>
			<?php if ( ! empty($comments_by_type['pings']) ) : // list pings/trackbacks separately ?>
					<div class="pings">
						<h3><?php _e("Sites That Link to this Post", "1pixel"); ?></h3>
						<ol class="pinglist">
							<?php wp_list_comments('type=pings&callback=list_pings'); ?>
						</ol>
					</div>  <!-- End .pings div. -->
			<?php endif; ?>
			<ol class="commentlist">
				<?php 
					$avsize = 40;
					wp_list_comments('type=comment&avatar_size='.$avsize);
				?>
			</ol>  <!-- End .commentlist div. -->
			<div class="comments-navigation clearfix">
				<div class="alignleft"><?php previous_comments_link() ?></div>
				<div class="alignright"><?php next_comments_link() ?></div>
			</div> <!-- End .comments-navigation div. -->
		</div>   <!-- End .allcomments div. -->
	<?php else : // this is displayed if there are no comments so far ?>
		<?php if ('open' == $post->comment_status) : // If comments are open, but there are no comments ?>
                    no comments yet but open for them
		 <?php else : // comments are closed   ?>
                    comments closed
		<?php endif; ?>
	<?php endif; ?>
	<?php
		global $required_text;
		$comments_args = array(
			'comment_notes_after' => '',
			'title_reply' => __( 'Post a Reply', '1pixel' ),
			'title_reply_to' => __( 'Post a Reply to %s', '1pixel' ),
			'cancel_reply_link' => __( 'Cancel Reply', '1pixel' ),
			'label_submit' => __( 'Submit Your Reply', '1pixel' ),
		);
		comment_form($comments_args);
	?>
</div> <!-- End #comments div. -->