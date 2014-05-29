<?php
/*
Plugin Name: Related Posts via Taxonomies
Plugin URI: http://alphasis.info/developments/wordpress-plugins/related-posts-via-taxonomies/
Description: This Plugin will display the related posts list via categories, tags and custom taxonomies. It can automatically display the related posts list after the content of any single post of selected post types by options.
Version: 1.0.1
Author: alphasis
Author URI: http://alphasis.info/
*/

/*
Copyright 2012  alphasis  (http://alphasis.info/)
*/


// Admin

if( is_admin() ){
	require_once dirname( __FILE__ ) . '/includes/admin.php';
}


// Display

add_filter( 'the_content', 'relatedPostsViaTaxonomies_autoDisplay', 88 );

function relatedPostsViaTaxonomies_autoDisplay( $content ) {
	$option_data = get_option("related_posts_via_taxonomies");
	if( $option_data['auto_display'] == 'yes' and is_singular( $option_data['post_types'] ) ) { 
		require_once dirname( __FILE__ ) . '/includes/display.php';
		$output = $GLOBALS['relatedPostsViaTaxonomies_display']->core();
		$content = $content . $output;
	}
	return $content;
}

function display_related_posts_via_taxonomies() {
	$option_data = get_option("related_posts_via_taxonomies");
	if( is_singular( $option_data['post_types'] ) ) { 
		require_once dirname( __FILE__ ) . '/includes/display.php';
		$output = $GLOBALS['relatedPostsViaTaxonomies_display']->core();
		echo $output;
	}
}


// Register

register_activation_hook( __FILE__, 'activate_related_posts_via_taxonomies' );

function activate_related_posts_via_taxonomies() {
	require_once dirname( __FILE__ ) . '/includes/activate.php';
	$GLOBALS['relatedPostsViaTaxonomies_activate']->activate();
}

load_plugin_textdomain( 'related-posts-via-taxonomies', false, basename( dirname( __FILE__ ) ) . '/languages' );


?>
