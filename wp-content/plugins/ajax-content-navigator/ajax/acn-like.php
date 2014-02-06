<?php

/* include WordPress */
define( 'WP_USE_THEMES', false );
require('../../../../wp-load.php');

global $acn;
$data = array();

	/* post id */
	if (!isset($_POST['post_id']))
		return false;

	$post_id = $_POST['post_id'];

	/* validate user like */
	$already_liked = $acn->already_liked($post_id, $_SERVER["REMOTE_ADDR"]);
	
	if ( !$already_liked ) {
	
		/* add like to post */
		$acn->add_like($post_id);
		
		/* store like globally */
		$acn->add_like_to_blog($post_id);

		/* show likes count */
		$data['show_likes'] = $acn->get_faves($post_id);
		
		/* now grey out button if needed */
		if ($acn->grey_out_button($post_id)) {
			$data['grey_out'] = true;
		}
		
	} else {
		
		/* now grey out button if needed */
		if ($acn->grey_out_button($post_id)) {
			$data['grey_out'] = true;
		}
	
	}

echo json_encode($data);