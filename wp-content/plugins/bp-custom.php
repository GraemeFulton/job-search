<?php

/*
 * put custom post types in the activity stream (when commented on)
 */
function bbg_record_my_custom_post_type_comments( $post_types ) {
	$post_types = array ('course', 'travel', 'post');  // Hier die Slugs der Custom Post Types eintragen, bei denen Erwähnungen in den Kommentaren berücksichtigt werden
	return $post_types;
}
add_filter( 'bp_blogs_record_comment_post_types', 'bbg_record_my_custom_post_type_comments' );



/* Add a new activity stream item for when people change their Profile Picute */
function xprofile_new_avatar_activity($post_ID, $post) {
	global $bp;
	$user_id = $bp->loggedin_user->id;
	$userlink = $bp->loggedin_user->domain;
	$username= $bp->loggedin_user->fullname;
	
	bp_activity_add( array(
	'user_id' => $user_id,
	
	'action' => '<a href="'.$userlink.'">'.$username
	.'</a> has a new favourite '.get_post_type( $post_ID )
	.': <a href="'.get_permalink( $post_ID)
	.'">'.get_the_title($post_ID).'</a>',
	
	'component' => 'profile',
	'type' => 'new_favourite'
	) );
}
add_action( 'wpfp_after_add', 'xprofile_new_avatar_activity', 10, 2 );
?>