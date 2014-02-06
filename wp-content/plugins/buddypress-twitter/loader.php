<?php 
/**
Plugin Name: BuddyPress Twitter
Plugin URI: http://buddypress.org/community/groups/buddypress-twitter
Description: Let your members and groups show their Twitter Follow Button on their profile page and group page. Using the twitter's @username widget, the plugin fetches your members and/or groups username and displays their folow button in the member's/group's header.

If your BuddyPress community is active on Twitter, this plugin is a great tool for boosting communication both on and off your website.
Version: 1.2
Author: Charl Kruger
Author URI: Charlkruger.com
License:GPL2
**/

function bp_twittercj_init() {
	require( dirname( __FILE__ ) . '/buddypress-twitter.php' );
}
add_action( 'bp_include', 'bp_twittercj_init' );

?>