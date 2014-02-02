<?php 
/*  
Plugin Name: Text to Custom Field
Plugin URI: http://www.wpgetready.com/download
Description: Allows adding custom fields easily from any desktop weblog client even without custom fields support.
Version: 1.11
Author: Fernando Zorrilla SM
Author URI: http://www.wpgetready.com
License: GPLv2
*/

add_action('publish_post', 'ttcf_buildcustomfield');

function ttcf_buildcustomfield($postid)
{
    //Global variable to make queries 
	global $wpdb;
	
	//Get the post content
	$post=get_post_types('course');
	$content=$post->post_content;
	
    //Define search pattern. Every match will return the custom field name(pos 1) and value (pos 2)
	$pattern="/{cf\s(.*)=(.*)}/U"; //U is for non Greedy search.
	
    //Return the result in $matches array
	preg_match_all($pattern,$content,$pattern_matches);
	
    //Loop the array to see any matches
	$counter=0;
	while ($counter<count($pattern_matches[0]))
	{
    //Add or update a custom field related with the actual post.
	//Documentation http://codex.wordpress.org/Function_Reference/add_post_meta
	
	add_post_meta   ($postid, $pattern_matches[1][$counter], $pattern_matches[2][$counter], true) or 
	update_post_meta($postid, $pattern_matches[1][$counter], $pattern_matches[2][$counter]);
	$counter +=1;
	}
	
    //Delete predefined tags from the content
	$pattern="/{cf\s.*=.*}/U"; //U is for non-Greedy searches
	//Replace string for nothing
	$content=preg_replace ($pattern,'',$content);
	
    //Directly update the database. This option actually works because another workarounds didn't. 
    //we can't use insert_post because it fires again (or it seems to be)
	$str="UPDATE $wpdb->posts SET post_content='".mysql_real_escape_string($content)."' WHERE ID=$postid";
	$wpdb->query($str);

return ;
}
?>