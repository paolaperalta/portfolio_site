<?php 
global $comment_data;
$args = $comment_data['args'];
$depth = $comment_data['depth'];
$comment = $comment_data['comment'];
?>

<div <?php comment_class( 'hentry' );?> id="comment-<?php comment_ID() ?>">

    <?php if(isset($comment->comment_author_url) && $comment->comment_author_url != ''):?>
        <a href="<?php echo esc_url( $comment->comment_author_url );?>"><h4 class="name"><?php echo get_comment_author(); ?></h4></a>
    <?php else:?>
        <h4 class="name"><?php echo get_comment_author(); ?></h4>
    <?php endif;?>

    <?php if ( $comment->comment_approved == '0' ) : ?>
		<div class="comment-notification"><em><?php _e( 'Your comment is awaiting moderation','flotheme' ); ?></em></div>
	<?php endif; ?>
	
	<div class="comment-text">
		<p><?php echo get_comment_text(); ?></p>
	</div>

	<?php if (false): ?>
		<div class="edit-comment"><?php edit_comment_link(); ?></div>
	<?php endif ?>

	<div class="comment-action">
		<h6 class="date"><?php echo get_comment_date('H:i F j, Y '); ?></h6>
		<?php if ( function_exists( 'comment_reply_link' ) ) { comment_reply_link( array_merge( $args, array( 'respond_id' => 'respond', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ), $comment, $post ); } ?>
	</div>
</div>


