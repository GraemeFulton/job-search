<?php
/*
Plugin Name: Tag Sticky Post
Plugin URI: http://tommcfarlin.com/tag-sticky-post/
Description: Mark a post to be placed at the top of a specified tag archive. It's sticky posts specifically for tags.
Version: 1.2
Author: Tom McFarlin
Author URI: http://tommcfarlin.com
Author Email: tom@tommcfarlin.com
License:

  Copyright 2012 - 2013 Tom McFarlin (tom@tommcfarlin.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class Tag_Sticky_Post {

	/*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/
	
	/**
	 * Initializes the plugin by setting localization, admin styles, and content filters.
	 */
	function __construct() {

		/* Setup the activation hook specifically for checking for the custom.css file
		 * I'm calling the same function using the activation hook - which is when the user activates the plugin,
		 * and during upgrade plugin event. This ensures that the custom.css file can also be managed
		 * when the plugin is updated.
		 *
		 * TODO: Restore this plugin when I've resolved the transient functionality properly.
		 */
		//register_activation_hook( __FILE__, array( $this, 'activate' ) );
		//add_action( 'pre_set_site_transient_update_plugins', array( $this, 'activate' ) );

		// Tag Meta Box actions
		add_action( 'add_meta_boxes', array( $this, 'add_tag_sticky_post_meta_box' ) );
		add_action( 'save_post', array( $this, 'save_tag_sticky_post_data' ) );
		add_action( 'wp_ajax_is_tag_sticky_post', array( $this, 'is_tag_sticky_post' ) );
				
		// Filters for displaying the sticky tag posts
		add_filter( 'post_class', array( $this, 'set_tag_sticky_class' ) );
		add_filter( 'the_posts', array( $this, 'reorder_tag_posts' ) );
		
		// Stylesheets
		add_action( 'admin_enqueue_scripts', array( $this, 'add_admin_styles_and_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'add_styles' ) );
		
	} // end constructor

	/*---------------------------------------------*
	 * Action Functions
	 *---------------------------------------------*/
	
	 /**
	  * Checks to see if a custom.css file exists. If not, creates it; otherwise, does nothing. This will
	  * prevent customizations from being overwritten in future upgrades.
	  */
	 function activate() {
		 
		 // The path where the custom.css should be stored.
		 $str_custom_path =  dirname( __FILE__ ) . '/css/custom.css';
		 
		 // If the custom.css file doesn't exist, then we create it
		 if( is_writable( $str_custom_path ) && ! file_exists( $str_custom_path ) ) {
			 file_put_contents( $str_custom_path, '' );
		 } // end if
		 
	 } // end activate
	
	/**
	 * Renders the meta box for allowing the user to select a tag in which to stick a given post.
	 */
	function add_tag_sticky_post_meta_box() {
		
		add_meta_box(
			'post_is_tag_sticky',
			__( 'Tag Sticky', 'tag-sticky-post' ),
			array( $this, 'tag_sticky_post_display' ),
			'post',
			'side',
			'low'
		);
		add_meta_box(
			'post_is_tag_sticky',
			__( 'Tag Sticky', 'tag-sticky-post' ),
			array( $this, 'tag_sticky_post_display' ),
			'university',
			'side',
			'low'
		);
		
	} // end add_tag_sticky_post_meta_box
	
	/**
	 * Renders the select box that allows users to choose the tag into which to stick the 
	 * specified post.
	 *
	 * @param	$post	The post to be marked as sticky for the specified tag.
	 */
	function tag_sticky_post_display( $post ) {
		
		// Set the nonce for security
		wp_nonce_field( plugin_basename( __FILE__ ), 'tag_sticky_post_nonce' );

		// First, read all the categories
		$tags = get_terms( 'uni', 'orderby=count&hide_empty=0' );;

		// Build the HTML that will display the select box
		$html = '<select id="tag_sticky_post" name="tag_sticky_post">';
			$html .= '<option value="0">' . __( 'Select a tag...', 'tag-sticky-post' ) . '</option>';
			foreach( $tags as $tag ) {
				$html .= '<option value="' . $tag->term_id . '" ' . selected( get_post_meta( $post->ID, 'tag_sticky_post', true ), $tag->term_id, false ) . ( $this->tag_has_sticky_post( $tag->term_id ) ? ' disabled ' : '' ) . '>';
					$html .= $tag->name;
				$html .= '</option>';	
			} // end foreach
		$html .= '</select>';
		
		echo $html;
		
	} // end tag_sticky_post_display
	
	/**
	 * Set the custom post meta for marking a post as sticky.
	 *
	 * @param	$post_id	The ID of the post to which we're saving the post meta
	 */
	function save_tag_sticky_post_data( $post_id ) {
	
		if( $this->user_can_save( $post_id, 'tag_sticky_post_nonce' ) ) {

			// Read the ID of the category to which we're going to stick this post
			$tag_id = '';
			if( isset( $_POST['tag_sticky_post'] ) ) {
				$tag_id = esc_attr( $_POST['tag_sticky_post'] );
			} // end if

			// If the value exists, delete it first. I don't want to write extra rows into the table.
			if ( 0 == count( get_post_meta( $post_id, 'tag_sticky_post' ) ) ) {
				delete_post_meta( $post_id, 'tag_sticky_post' );
			} // end if
	
			// Update it for this post.
			update_post_meta( $post_id, 'tag_sticky_post', $tag_id );
	
		} // end if
	
	} // end save_tag_sticky_post_data
	
	/**
	 * Register and enqueue the stylesheets and JavaScript dependencies for styling the sticky post.
	 */
	function add_admin_styles_and_scripts() {
	
		// Only register the stylesheet for the post page
		$screen = get_current_screen();
		if( 'post' == $screen->id ) { 
	
			// admin stylesheet
			wp_enqueue_style( 'tag-sticky-post', plugins_url( '/tag-sticky-post/css/admin.css' ) );

			// post editor javascript
			wp_enqueue_script( 'tag-sticky-post-editor', plugins_url( '/tag-sticky-post/js/editor.min.js' ), array( 'jquery' ) );
		
		// And only register the JavaScript for the post listing page
		} elseif( 'edit-post' == $screen->id ) {
		
			// posts display javascript
			wp_enqueue_script( 'tag-sticky-post', plugins_url( '/tag-sticky-post/js/admin.min.js' ), array( 'jquery' ) );
		
		} // end if
		
	} // end add_admin_styles_and_scripts
	
	/**
	 * Register and enqueue the stylesheets for styling the sticky post.
	 */
	function add_styles() {
	
		// Only render the stylesheet if we're on an archive page
		if( is_archive() ) {
			wp_enqueue_style( 'tag-sticky-post', plugins_url( '/tag-sticky-post/css/plugin.css' ) );
		} // end if
		
	} // end add_styles
	
	/**
	 * Ajax callback function used to decide if the specified post ID is marked as a category
	 * sticky post.
	 *
	 * TODO: I wanted to do this all server side but couldn't find the proper actions and filters to do it.
	 */
	function is_tag_sticky_post() {
	
		if( isset( $_GET['post_id'] ) ) {
		
			$post_id = trim ( $_GET['post_id'] );
			if( 0 == get_post_meta( $post_id, 'tag_sticky_post', true ) ) {
				die( '0' );
			} else {
				die( _e( ' - Tag Sticky Post', 'tag-sticky-post' ) );
			} // end if/else
		
		} // end if
		
	} // end is_tag_sticky_post
	
	/*---------------------------------------------*
	 * Filter Functions
	 *---------------------------------------------*/
	 
	 /**
	  * Adds a CSS class to make it easy to style the sticky post.
	  * 
	  * @param	$classes	The array of classes being applied to the given post
	  * @return				The updated array of classes for our posts
	  */
	 function set_tag_sticky_class( $classes ) {
	
		 // Get the tag either from multiple query string variables or the query var
		 if( ( $tag = $this->get_sticky_post() ) ) {
			 
			 // If we're on an archive and the current category ID matches the category of the given post, add the class name
			 if( is_archive() && 0 == get_query_var( 'paged' ) && $tag->term_id == get_post_meta( get_the_ID(), 'tag_sticky_post', true ) ) {
				 $classes[] = 'tag-sticky';
			 } // end if
		 
		 } // end if
		 
		 return $classes;
		 
	 } // end set_tag_sticky_class
	 
	 /**
	  * Places the sticky post at the top of the list of posts for the tag that is being displayed.
	  *
	  * @param	$posts	The lists of posts to be displayed for the given tag
	  * @return			The updated list of posts with the sticky post set as the first titem
	  */
	 function reorder_tag_posts( $posts ) {

	 	// We only care to do this for the first page of the archives
	 	if( is_archive() &&  0 == get_query_var( 'paged' ) ) {
	 
		 	// Read the current tag to find the sticky post
		 	if( null != ( $tag = get_term_by( 'slug', get_query_var( 'term' ), 'uni' ) ) ) {

			 	// Query for the ID of the post
			 	$sticky_query = new WP_Query(
			 		array(
				 		'fields'			=>	'ids',
				 		'post_type'			=>	'university',
				 		'posts_per_page'	=>	'1',
				 		'tax_query'			=> array(
				 			'terms'				=> 	null,
				 			'include_children'	=>	false
				 		),
				 		'meta_query'		=>	array(
				 			array(
					 			'key'		=>	'tag_sticky_post',
					 			'value'		=>	$tag->term_id,
					 		)
				 		)
			 		)
			 	);
			 	
			 	// If there's a post, then set the post ID
			 	$post_id = ( ! isset ( $sticky_query->posts[0] ) ) ? -1 : $sticky_query->posts[0];
			 	wp_reset_postdata();
	
	
			 	// If the query returns an actual post ID, then let's update the posts
			 	if( -1 < $post_id ) {
			 	
			 		// Store the sticky post in an array
				 	$new_posts = array( get_post( $post_id ) );
			 	
				 	// Look to see if the post exists in the current list of posts.
				 	foreach( $posts as $post_index => $post ) {
				 	
				 		// If so, then remove it so we don't duplicate its display
				 		if( $post_id == $posts[ $post_index ]->ID ) {
					 		unset( $posts[ $post_index ] );
				 		} // end if
					 	
				 	} // end foreach
				 	
				 	// Merge the existing array (with the sticky post first and the original posts second)
				 	$posts = array_merge( $new_posts, $posts );
				 	
			 	} // end if
			 	
		 	} // end if
	 	
	 	} // end if
	 	
	 	return $posts;
	 	
	 } // end reorder_tag_posts
	 
	/*---------------------------------------------*
	 * Helper Functions
	 *---------------------------------------------*/
	
	/**
	 * Determines if the given tag already has a sticky post.
	 * 
	 * @param	$tag_id	The ID of the category to check
	 * @return			Whether or not the tag has a sticky post
	 */
	private function tag_has_sticky_post( $tag_id ) {
	
		$has_sticky_post = false;
		
		$q = new WP_Query( 'meta_key=tag_sticky_post&meta_value=' . $tag_id );	
		$has_sticky_post = $q->have_posts();
		wp_reset_query();
		
		return $has_sticky_post;

	} // end tag_has_sticky_post
	
	/**
	 * Determines if the user is querying multiple tags.
	 *
	 * @return	bool	True if multiple tags are in the URL; otherwise, false.
	 * @version	1.0
	 * @since	1.2
	 */
	private function get_multiple_tags() {
		
		// First, determine if there are multiple tags. If so, read them into an array
		$all_tags = array();		
		if( 0 < strpos( get_query_var( 'tag' ), '+' ) ) { 
			$all_tags = explode( '+', get_query_var( 'term' ) );
		} // end if
		
		return $all_tags;
		
	} // end querying_multiple_tags
	
	/**
	 * Determines if a sticky tag exists in multiple tags. If so, returns the tag.
	 *
	 * @param	array	$all_tags	The set of tags specified in the query string
	 * @return	object	$tag		The tag that was found in the query string
	 * @version	1.0
	 * @since	1.2
	 */
	private function includes_sticky_post( $all_tags ) {
		
		$tag = null;
		
		// Next, determine which tag in the array is what we're looking at
		foreach( $all_tags as $tag ) {
			
			$tag = get_term_by( 'slug', $tag, 'uni' );
			if( $tag->term_id == get_post_meta( get_the_ID(), 'tag_sticky_post', true ) ) {
				break;
			} // end if
			
		} // end foreach
		
		return $tag;
		
	} // end includes_sticky_post
	
	/**
	 * Retrieves the tag for the post based on if it's queried in multiple variables or not.
	 *
	 * @return	object	$tag		The tag sticky post that was found in the query var or the query string collection
	 * @version	1.0
	 * @since	1.2
	 */
	private function get_sticky_post() {
	
		$all_tags = $this->get_multiple_tags();
		$tag_from_multiple = $this->includes_sticky_post( $all_tags );
		$tag_from_query = get_term_by( 'slug', get_query_var( 'term' ), 'uni' );
		
		return null == $tag_from_multiple ? $tag_from_query : $tag_from_multiple;

	} // end has_sticky_post
	
	/**
	 * Determines whether or not the current user has the ability to save meta data associated with this post.
	 *
	 * @param		int		$post_id	The ID of the post being save
	 * @param		bool				Whether or not the user has the ability to save this post.
	 * @version		1.0
	 * @since		1.2
	 */
	private function user_can_save( $post_id, $nonce ) {
		
	    $is_autosave = wp_is_post_autosave( $post_id );
	    $is_revision = wp_is_post_revision( $post_id );
	    $is_valid_nonce = ( isset( $_POST[ $nonce ] ) && wp_verify_nonce( $_POST[ $nonce ], plugin_basename( __FILE__ ) ) );
	    
	    // Return true if the user is able to save; otherwise, false.
	    return ! ( $is_autosave || $is_revision ) && $is_valid_nonce;
	
	} // end user_can_save
	
} // end class

new Tag_Sticky_Post();
?>