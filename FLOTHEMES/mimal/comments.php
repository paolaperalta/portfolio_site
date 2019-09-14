<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package options_sample
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<div class="comments-list">
			<?php
				wp_list_comments( array(
					'style'      => 'ol',
					'short_ping' => true,
					'callback' => 'flo_comment'
				) );
			?>
		</div>
		<?php flo_comment_nav(); ?>
	<?php endif;?>

	<div class="row">
		<div class="columns medium-12">

			<?php if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
				<p class="no-comments"><?php _e( 'Comments are closed.', 'flotheme' ); ?></p>
			<?php endif; ?>
		
			<?php 

				$commenter = wp_get_current_commenter();
				$req = get_option( 'require_name_email' );
				$aria_req = ( $req ? " aria-required='true'" : '' );

				$fields =  array(

				  'author' => '<div class="left-side"><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
				    '" size="30"' . $aria_req . ' placeholder="Name" />',


				  'email' =>
				    '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
				    '" size="30"' . $aria_req . ' placeholder="Email" 	/>',

			    'url' =>
				    '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
				    '" size="30" placeholder="Website" /></div>',
				);
				$comments_args = array(
				  'id_form'           => 'commentform',
				  'id_submit'         => 'submit',
				  'class_submit'      => 'submit',
				  'name_submit'       => 'submit',
				  'title_reply'       => '',
				  'title_reply_to'    => __( 'Leave a Reply to %s','flotheme' ),
				  'cancel_reply_link' => __( 'Cancel Reply','flotheme' ),
				  'label_submit'      => __( 'Add Comment','flotheme' ),
				  'format'            => 'xhtml',

				  'comment_field' => 
				    '<div class="right-side"><textarea id="comment" name="comment" cols="45" rows="3" aria-required="true" placeholder="'. __( 'Your Comment','flotheme' ) . '">' .
				    '</textarea></div>',

				  'must_log_in' => '<p class="must-log-in">' .

				    sprintf(
				      __( 'You must be <a href="%s">logged in</a> to post a comment.','flotheme' ),
				      wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
				    ) . '</p>',

				  'logged_in_as' => '<p class="logged-in-as">' .
				    sprintf(
				    __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>','flotheme' ),
				      admin_url( 'profile.php' ),
				      $user_identity,
				      wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
				    ) . '</p>',

				  'comment_notes_before' => '',

				  'comment_notes_after' => '',

				  'fields' => apply_filters( 'comment_form_default_fields', $fields ),
				); ?>

			<?php comment_form($comments_args); ?>
		</div>
	</div>
</div><!-- #comments -->
