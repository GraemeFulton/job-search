<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to klein_comment() which is
 * located in the inc/template-tags.php file.
 *
 * @package klein
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>

	<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>
	<?php if ( have_comments() ) : ?>
		<h4 class="comments-title">
			<span class="glyphicon glyphicon-comment"></span> 
			<?php
				printf( 
					_nx( __('One thought on &ldquo;%2$s&rdquo;','klein'), 
						 __('%1$s thoughts on &ldquo;%2$s&rdquo;', 'klein'), 
						get_comments_number(), 
						'comments title', 
						'klein' 
					),
					number_format_i18n( get_comments_number() ), 
						'<span>' . get_the_title() . '</span>' 
					);
			?>
		</h4>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above" class="clearfix comment-navigation" role="navigation">
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'klein' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'klein' ) ); ?></div>
		</nav><!-- #comment-nav-above -->
		<?php endif; // check for comment navigation ?>

		<ol class="comment-list">
			<?php
				/* Loop through and list the comments. Tell wp_list_comments()
				 * to use klein_comment() to format the comments.
				 * If you want to overload this in a child theme then you can
				 * define klein_comment() and that will be used instead.
				 * See klein_comment() in inc/template-tags.php for more.
				 */
				wp_list_comments( array( 'callback' => 'klein_comment' ) );
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="clearfix comment-navigation" role="navigation">
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'klein' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'klein' ) ); ?></div>
		</nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'klein' ); ?></p>
	<?php endif; ?>
	<div class="clearfix">
		<?php comment_form(); ?>
	</div>
</div><!-- #comments -->
