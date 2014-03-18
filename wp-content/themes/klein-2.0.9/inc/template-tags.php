<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package klein
 */

if ( ! function_exists( 'klein_content_nav' ) ) :

/**
 * Display navigation to next/previous pages when applicable
 */
function klein_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = ( is_single() ) ? 'post-navigation' : 'paging-navigation';

	?>
	<?php 
		wp_link_pages(array(  
			'before' => '<div class="row page-link">' . 'Pages:',  
			'after' => '</div>'  
		)) 
	?>
	
	<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?>">

	<?php if ( is_single() ) : // navigation links for single posts ?>
		
			<?php 
				previous_post_link( 
					'<div class="nav-previous pull-left"><p>%link</p></div>', 
					'<span class="meta-nav">' . _x( '<i class="glyphicon glyphicon-chevron-left"></i>', 'Previous post link', 'klein' ) . '</span> ' . __('Previous Article','klein') 
				); 
			?>
			<?php
				next_post_link( 
					'<div class="nav-next pull-right"><p>%link</p></div>', 
					__('Next Article','klein'). ' <span class="meta-nav">' . _x( '<i class="glyphicon glyphicon-chevron-right"></i>', 'Next post link', 'klein' ) . '</span>'
			); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous-link">
				<?php next_posts_link( __( '<div class="pull-left nav-previous"><span class="meta-nav"><i class="glyphicon glyphicon-chevron-left"></i></span> '.__('Older Posts','klein').' </div>', 'klein' ) ); ?>
			</div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next-link">
				<?php previous_posts_link( __( '<div class="pull-right nav-next">'.__('Newer Posts','klein').' <span class="meta-nav"><i class="glyphicon glyphicon-chevron-right"></i></span></div>', 'klein' ) ); ?>
			</div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
	<?php
}
endif; // klein_content_nav

if ( ! function_exists( 'klein_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function klein_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment-body">
			<?php _e( 'Pingback:', 'klein' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'klein' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

	<?php else : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
					<?php printf( __( '%s <span class="says">says:</span>', 'klein' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author -->

				<div class="comment-metadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'klein' ), get_comment_date(), get_comment_time() ); ?>
						</time>
					</a>
					<?php edit_comment_link( __( 'Edit', 'klein' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-metadata -->

				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'klein' ); ?></p>
				<?php endif; ?>
			</footer><!-- .comment-meta -->

			<div class="comment-content">
				<?php comment_text(); ?>
			</div><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- .comment-body -->

	<?php
	endif;
}
endif; // ends check for klein_comment()

if ( ! function_exists( 'klein_the_attached_image' ) ) :
/**
 * Prints the attached image with a link to the next attached image.
 */
function klein_the_attached_image() {
	$post                = get_post();
	$attachment_size     = apply_filters( 'klein_attachment_size', array( 1200, 1200 ) );
	$next_attachment_url = wp_get_attachment_url();

	/**
	 * Grab the IDs of all the image attachments in a gallery so we can get the
	 * URL of the next adjacent image in a gallery, or the first image (if
	 * we're looking at the last image in a gallery), or, in a gallery of one,
	 * just the link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID'
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id )
			$next_attachment_url = get_attachment_link( $next_id );

		// or get the URL of the first image attachment.
		else
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
	}

	printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
		esc_url( $next_attachment_url ),
		the_title_attribute( array( 'echo' => false ) ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

if ( ! function_exists( 'klein_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function klein_posted_on( $echo = true ) {
	
	global $post;
	
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	
	//if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) )
		//$time_string .= ' and was updated on <time class="updated" datetime="%3$s">%4$s</time>';

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);
	
	
	//echo get_the_author_meta( 'display_name', 1 );
	//echo get_the_author_meta( 'user_url', 1 );
	
	$entry_meta = sprintf( __( '<span class="posted-on">%1$s</span><span class="byline"> / %2$s</span>', 'klein' ),
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark">%3$s</a>',
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			$time_string
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID', $post->post_author ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'klein' ), get_the_author() ) ),
			esc_html( get_the_author_meta( 'display_name', $post->post_author ) )
		)
	);
	
	if( $echo ){
		echo $entry_meta;
	}else{		
		return $entry_meta;
	}
	
}
endif;

/**
 * Returns true if a blog has more than 1 category
 */
function klein_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so klein_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so klein_categorized_blog should return false
		return false;
	}
}



/**
 * Shows entry meta of a post inside the 'loop'
 */
 
function klein_entry_meta(){
?>
	<footer class="entry-meta">
		
		<?php
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ', ', 'klein' ) );
	
			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'klein' ) );
	
			// always show the date and the author
			_e( sprintf( 'This entry was publish on %s. ', klein_posted_on( false ) ), 'klein' );
			
			if ( ! klein_categorized_blog() ) {
				// This blog only has 1 category so we just need to worry about tags in the meta text
				if ( '' != $tag_list ) {
					$meta_text = __( 'Tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'klein' );
				} else {
					$meta_text = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'klein' );
				}
	
			} else {
				// But this blog has loads of categories so we should probably display them here
				if ( '' != $tag_list ) {
					$meta_text = __( 'Posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'klein' );
				} else {
					$meta_text = __( 'Posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'klein' );
				}
	
			} // end check for categories on this blog
			
			printf(				
				$meta_text,
				$category_list,
				$tag_list,
				get_permalink(),
				the_title_attribute( 'echo=0' )
			);
		?>
	
		<?php edit_post_link( __( 'Edit', 'klein' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
<?php
}

/**
 * Pulls vimeo/youtube and display it
 */
 
if( !function_exists( 'klein_post_formats_video' ) ){
	function klein_post_formats_video( $height = '275', $width ='100%' ){
	global $post;
	$video = get_post_meta( $post->ID, 'klein_video', true );
	
	if( !empty( $video) ){
		// if it's not numeric then it's youtube, otherwise, it's vimeo
		if( !is_numeric( $video ) ){
			// youtube  ?>
			<iframe width="<?php echo $width;?>" height="<?php echo $height;?>" src="//www.youtube.com/embed/<?php echo $video ?>" frameborder="0" allowfullscreen></iframe>
		<?php }else{
			// vimeo ?>
			<iframe src="http://player.vimeo.com/video/<?php echo $video ?>?badge=0" width="<?php echo $width;?>" height="<?php echo $height;?>" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
		<?php } ?>
		<?php
	} //end !empty $video
	
	} // function
}// end function_exists

/**
 * Check wheter the current page is blog
 * @return bool
 */
 
if( !function_exists( 'klein_is_blog' ) ){
	function klein_is_blog() {
	 
		global $post;
		
		// get the post type of the current page
		$type = get_post_type( $post );
		// return bool
		return (
			( is_home() || is_archive() || is_single() )
			&& ($type == 'post')
		) ? true : false ;
		
	}
} 

/**
 * Displays user info in loop
 */
if( !function_exists( 'klein_author' ) ){
	function klein_author(){
	global $post;
	?>
	<?php if( function_exists( 'bp_core_fetch_avatar' ) ){ ?>
			<div class="blog-author-avatar">
				<?php echo bp_core_fetch_avatar( array( 'type' => 'full', 'item_id' => $post->post_author ) ); ?>
			</div>
			<div class="blog-author-name center">
				<?php the_author_meta( 'display_name' ); ?>
			</div>
			<div class="blog-author-links">
				<div class="bp-profile-link">
					<a class="tip" data-delay="0" data-placement="bottom" data-original-title="<?php _e( 'Profile', 'klein' ); ?>" href="<?php echo bp_core_get_user_domain( get_the_author_meta( 'ID' ) ); ?>">
						<i class="glyphicon glyphicon-user"></i>
					</a>
				</div>
				<div class="author-post-link blog-pad-left">
					<a class="tip" data-delay="0" data-placement="bottom" data-original-title="<?php _e( 'Posts', 'klein' ); ?>" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
						<i class="glyphicon glyphicon-pencil"></i>
					</a>
				</div>
			</div>
		<?php }else{ ?>
			<div class="blog-author-avatar no-bp"><?php echo get_avatar( $post->post_author, 75 ); ?></div>
			<div class="blog-author-name no-bp center">
				<a class="tip" data-delay="0" data-placement="bottom" data-original-title="<?php _e( 'Posts', 'klein' ); ?>" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
					<?php echo get_the_author(); ?>
				</a>
			</div>
		<?php } ?>
	<?php
	}
}
/**
 *
 * klein_is_blog()
 *
 * Check if current page is blog
 * returns true otherwhise false
 *
 * @package klein
 * @return bool
 */
 
function klein_is_blog() {
	global  $post;
	$posttype = get_post_type($post );
	return ( ((is_archive()) || (is_author()) || (is_category()) || (is_home()) || (is_single()) || (is_tag())) && ( $posttype == 'post')  ) ? true : false ;
}

/**
 * 
 * klein_sidebar_left()
 *
 * Renders the sidebar. Check for page settings and fallbacks
 * Specific section default sidebar
 *
 * @package klein
 * 
 */
if( !function_exists( 'klein_sidebar_left' ) ){ 

	function klein_sidebar_left( $fallback = 'sidebar-2' ){

		global $post;
		 
		$sidebar_meta = get_post_meta( $post->ID, 'klein_sidebar_left', true ); 
		do_action( 'before_sidebar_left' ); 
		
		if( !empty( $sidebar_meta ) ){
				dynamic_sidebar( $sidebar_meta ); 
			}else{ 
				dynamic_sidebar( $fallback ); 
			}
			
		return;
	} 
}

/**
 * 
 * klein_sidebar_right()
 *
 * Renders the sidebar. Check for page settings and fallbacks
 * Specific section default sidebar
 *
 * @package klein
 * 
 */
if( !function_exists( 'klein_sidebar_right' ) ){ 

	function klein_sidebar_right( $fallback = 'sidebar-1' ){

		global $post;
		 
		$sidebar_meta = get_post_meta( $post->ID, 'klein_sidebar', true ); 
		do_action( 'before_sidebar' ); 
		
		
		if( !empty( $sidebar_meta ) ){
			dynamic_sidebar( $sidebar_meta ); 
		}else{ 
			dynamic_sidebar( $fallback ); 
		} 
		
		return;
	} 
}

/**
 * Displays user updates in a dropdown
 */
if( !function_exists( 'klein_user_nav') ){
	function klein_user_nav(){
		global $current_user;
		
		// replaced deprecated tempalte tag 'bp_core_get_notifications_for_user'
		// @since 1/16/2014
		
		if( function_exists( 'bp_notifications_get_notifications_for_user' ) ){
		?>
		<?php $notifications = bp_notifications_get_notifications_for_user( get_current_user_id() ); ?>
	
			<section id="klein-top-updates">
				<a id="klein-top-updates-btn" class="btn btn-primary" href="#" title="<?php _e('Updates','klein'); ?>">
					<i class="glyphicon glyphicon-chevron-down"></i> 
					<?php if( !empty( $notifications ) ){ ?>
						<span id="klein-top-updates-badge"><?php echo count( $notifications ); ?></span>
					<?php } ?>	
				</a>
				<nav id="klein-top-updates-nav">
					<ul class="pull-right bp-klein-dropdown-menu" role="menu" aria-labelledby="global-updates">
						<?php do_action( 'klein_before_user_nav' ); ?>
						<li id="klein-user-nav-user-profile">
							<a href="<?php echo bp_core_get_user_domain( $current_user->ID );?>">
								<?php echo get_avatar( $current_user->ID, 32 ); ?>
								<span><?php _e( 'My Profile','klein' ); ?></span>
							</a>
						</li>
						<?php if( !empty( $notifications ) ){ ?>
							<?php foreach( $notifications as $notification ){ ?> 
								<li role="presentation">
									<?php
										// check if the format of notification is array
										// assume array has [text] and [link] element
										//
										// @patch 1/16/2014
										// @fix bp update
									?>
									<?php if( is_array( $notification ) ){ ?>
									
										<?php $notification_text = !empty( $notification['text'] ) ? $notification['text'] : ''; ?>
										<?php $notification_link = !empty( $notification['link'] ) ? $notification['link'] : ''; ?>
										
										<a title="<?php echo esc_attr( $notification_text ); ?>" href="<?php echo esc_url( $notification_link ); ?>">
											<?php echo esc_attr( $notification_text ); ?>
										</a>
										
									<?php }else{ ?>
											<?php echo $notification; ?>
									<?php } ?>
								</li>
							<?php } ?>
						<?php } // !empty( $notifications )?>
						<?php if( function_exists('bp_loggedin_user_domain') ){ ?>
							<?php if( bp_is_active( 'settings' ) ){ ?>
								<li role="presentation">
									<a href="<?php echo bp_loggedin_user_domain(); ?>settings" title="<?php _e( 'Settings','klein' ); ?>">
										<span class="glyphicon glyphicon-cog"></span>
										<?php _e( 'Settings', 'klein' ); ?>
									</a>
								</li>
							<?php } ?>
						<?php } ?>	
							<li role="presentation">
								<a href="<?php echo wp_logout_url( get_permalink() ); ?>" title="<?php _e( 'Logout','klein' ); ?>">
									<i class="glyphicon glyphicon-log-out"></i> <?php _e( 'Logout','klein' ); ?>
								</a>
							</li>
						<?php do_action( 'klein_after_user_nav' ); ?>
					</ul>	
				</nav>
			</section>
			
		
		<?php 
		} // end function_exists('bp_core_get_notifications_for_user')
	} // end function klein_user_updates()
} // end !function_exists( 'klein_user_updates')

/**
 * klein_has_rev_slider
 * 
 * Checks whether the slider revolution is available for display
 * returns true if current template is front-page-rev-slider.php
 * and there is a rev-slider available on the settings
 * 
 * @package klein
 *
 */

if( !function_exists( 'klein_has_rev_slider' ) ){
	function klein_has_rev_slider(){
		if( !function_exists( 'putRevSlider' ) ){
			return false;
		}
		$current_template =	basename( get_page_template() ); 
		$rev_slider_page_template_names = array( 'front-page-rev-slider.php', 'front-page-rev-slider-content.php' );
		$rev_slider_id = ot_get_option( 'front_page_slider_id', '' );
		
		if( empty( $rev_slider_id ) ){
			return false;
		};
		
		if( in_array( $current_template, $rev_slider_page_template_names ) ){
			return true;
		}else{
			return false;
		}
	}
}

/**
 * Flush out the transients used in klein_categorized_blog
 */
 
function klein_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}

add_action( 'edit_category', 'klein_category_transient_flusher' );
add_action( 'save_post',     'klein_category_transient_flusher' );
