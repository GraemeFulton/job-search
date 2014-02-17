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
function xprofile_new_bookmark_activity($post_ID, $post) {
	global $bp;
	$user_id = $bp->loggedin_user->id;
	$userlink = $bp->loggedin_user->domain;
	$username= $bp->loggedin_user->fullname;
	$image=get_the_image($post_ID);
	
	bp_activity_add( array(
	'user_id' => $user_id,
	
	'action' => '<a href="'.$userlink.'">'.$username
	.'</a> bookmarked this ',
	'component' => 'profile',
	'type' => 'new_bookmark',
	'item_id'=>$post_ID,
	'content'=>'<a href="'.get_permalink( $post_ID)
	.'"><span class="activity-bookmark-title">'.get_the_title($post_ID).'</span>'.
			 //image
        '<img class="activity-bookmark-image" src="'.$image.'"/>'.
        "</a>"
	) );
}
add_action( 'wpfp_after_add', 'xprofile_new_bookmark_activity', 10, 2 );

/*
//front end posts

add_action('bp_init','my_post_form',4);//register a form
//it will register a fomr
function my_post_form(){
	$settings=array('post_type'=>'post',//which post type
			'post_author'=>  bp_loggedin_user_id(),//who will be the author of the submitted post
			'post_status'=>'draft',//how the post should be saved, change it to 'publish' if you want to make the post published automatically
			'current_user_can_post'=>  is_user_logged_in(),//who can post
			'show_categories'=>true,//whether to show categories list or not, make sure to keep it true
			'allowed_categories'=>array(1,2,3,4)//array of allowed categories which should be shown, use  get_all_category_ids() if you want to allow all categories
	);
	$form=bp_new_simple_blog_post_form('my form',$settings);//create a Form Instance and register it
}*/

/*
 * HIDE ADMIN ACTIVE
 */
add_action('bp_init', function() {
    global $bp;

    if (is_super_admin()) {
            //first remove the action that record the last activity
            remove_action('wp_head', 'bp_core_record_activity');

            //then remove the last activity, if present
            delete_usermeta($bp->loggedin_user->id, 'last_activity');
    }
});

// "Not recently active" yazısını super admin için kaldır
add_filter( 'bp_core_get_last_activity', function($last_active){
    global $bp;
    if ( bp_is_active( 'xprofile' ) ){
        $last_active_bp_string = __( 'Not recently active', 'buddypress' );
        if( ($last_active_bp_string == $last_active) && is_super_admin($bp->displayed_user->id)) {
            $last_active = __('Network Admin');
        }
    }
    return $last_active;
});
?>