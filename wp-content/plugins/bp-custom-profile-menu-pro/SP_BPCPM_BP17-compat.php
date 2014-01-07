<?php
/**
 * Backwards compatibililty functions for < BP 1.7.
 *
 * @author r-a-y
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/** 1.7 compat *****************************************************/

if ( ! function_exists( 'bp_get_template_part' ) ) :
function bp_get_template_part( $slug, $name = null ) {

	// Execute code for this part
	do_action( 'get_template_part_' . $slug, $slug, $name );

	// Setup possible parts
	$templates = array();
	if ( isset( $name ) )
		$templates[] = $slug . '-' . $name . '.php';
	$templates[] = $slug . '.php';

	// Allow template parts to be filtered
	$templates = apply_filters( 'bp_get_template_part', $templates, $slug, $name );

	// Return the part that is found
	return bp_locate_template( $templates, true, false );
}
endif;

if ( ! function_exists( 'bp_locate_template' ) ) :
function bp_locate_template( $template_names, $load = false, $require_once = true ) {

	// No file found yet
	$located            = false;
	$template_locations = bp_get_template_stack();

	// Try to find a template file
	foreach ( (array) $template_names as $template_name ) {

		// Continue if template is empty
		if ( empty( $template_name ) )
			continue;

		// Trim off any slashes from the template name
		$template_name  = ltrim( $template_name, '/' );

		// Loop through template stack
		foreach ( (array) $template_locations as $template_location ) {

			// Continue if $template_location is empty
			if ( empty( $template_location ) )
				continue;

			// Check child theme first
			if ( file_exists( trailingslashit( $template_location ) . $template_name ) ) {
				$located = trailingslashit( $template_location ) . $template_name;
				break 2;
			}
		}
	}

	// Maybe load the template if one was located
	if ( ( true == $load ) && !empty( $located ) )
		load_template( $located, $require_once );

	return $located;
}
endif;

if ( ! function_exists( 'bp_get_template_stack' ) ) :
function bp_get_template_stack() {
	global $wp_filter, $merged_filters, $wp_current_filter;

	// Setup some default variables
	$tag  = 'bp_template_stack';
	$args = $stack = array();

	// Add 'bp_template_stack' to the current filter array
	$wp_current_filter[] = $tag;

	// Sort
	if ( ! isset( $merged_filters[ $tag ] ) ) {
		ksort( $wp_filter[$tag] );
		$merged_filters[ $tag ] = true;
	}

	// Ensure we're always at the beginning of the filter array
	reset( $wp_filter[ $tag ] );

	// Loop through 'bp_template_stack' filters, and call callback functions
	do {
		foreach( (array) current( $wp_filter[$tag] ) as $the_ ) {
			if ( ! is_null( $the_['function'] ) ) {
				$args[1] = $stack;
				$stack[] = call_user_func_array( $the_['function'], array_slice( $args, 1, (int) $the_['accepted_args'] ) );
			}
		}
	} while ( next( $wp_filter[$tag] ) !== false );

	// Remove 'bp_template_stack' from the current filter array
	array_pop( $wp_current_filter );

	// Remove empties and duplicates
	$stack = array_unique( array_filter( $stack ) );

	return (array) apply_filters( 'bp_get_template_stack', $stack ) ;
}
endif;

if ( ! function_exists( 'bp_register_template_stack' ) ) :
function bp_register_template_stack( $location_callback = '', $priority = 10 ) {

	// Bail if no location, or function does not exist
	if ( empty( $location_callback ) || ! function_exists( $location_callback ) )
		return false;

	// Add location callback to template stack
	return add_filter( 'bp_template_stack', $location_callback, (int) $priority );
}
endif;

if ( ! function_exists( 'bp_deregister_template_stack' ) ) :
function bp_deregister_template_stack( $location_callback = '', $priority = 10 ) {

	// Bail if no location, or function does not exist
	if ( empty( $location_callback ) || ! function_exists( $location_callback ) )
		return false;

	// Add location callback to template stack
	return remove_filter( 'bp_template_stack', $location_callback, (int) $priority );
}
endif;

if ( ! function_exists( 'bp_get_template_locations' ) ) :
function bp_get_template_locations( $templates = array() ) {
	$locations = array(
		'buddypress',
		'community',
		''
	);
	return apply_filters( 'bp_get_template_locations', $locations, $templates );
}
endif;

if ( ! function_exists( 'bp_add_template_stack_locations' ) ) :
function bp_add_template_stack_locations( $stacks = array() ) {
	$retval = array();

	// Get alternate locations
	$locations = bp_get_template_locations();

	// Loop through locations and stacks and combine
	foreach ( (array) $stacks as $stack )
		foreach ( (array) $locations as $custom_location )
			$retval[] = untrailingslashit( trailingslashit( $stack ) . $custom_location );

	return apply_filters( 'bp_add_template_stack_locations', array_unique( $retval ), $stacks );
}
endif;


if ( ! function_exists( 'bp_buffer_template_part' ) ) :
function bp_buffer_template_part( $slug, $name = null, $echo = true ) {
	ob_start();

	// Remove 'bp_replace_the_content' filter to prevent infinite loops
	remove_filter( 'the_content', 'bp_replace_the_content' );

	bp_get_template_part( $slug, $name );

	// Remove 'bp_replace_the_content' filter to prevent infinite loops
	add_filter( 'the_content', 'bp_replace_the_content' );

	// Get the output buffer contents
	$output = ob_get_contents();

	// Flush the output buffer
	ob_end_clean();

	// Echo or return the output buffer contents
	if ( true === $echo ) {
		echo $output;
	} else {
		return $output;
	}
}
endif;


if ( ! function_exists( 'bp_set_theme_compat_active' ) ) :
function bp_set_theme_compat_active( $set = true ) {
	buddypress()->theme_compat->active = $set;

	return (bool) buddypress()->theme_compat->active;
}
endif;


if ( ! function_exists( 'bp_theme_compat_reset_post' ) ) :
function bp_theme_compat_reset_post( $args = array() ) {
	global $wp_query, $post;

	// Default arguments
	$defaults = array(
		'ID'                    => -9999,
		'post_status'           => 'publish',
		'post_author'           => 0,
		'post_parent'           => 0,
		'post_type'             => 'page',
		'post_date'             => 0,
		'post_date_gmt'         => 0,
		'post_modified'         => 0,
		'post_modified_gmt'     => 0,
		'post_content'          => '',
		'post_title'            => '',
		'post_category'         => 0,
		'post_excerpt'          => '',
		'post_content_filtered' => '',
		'post_mime_type'        => '',
		'post_password'         => '',
		'post_name'             => '',
		'guid'                  => '',
		'menu_order'            => 0,
		'pinged'                => '',
		'to_ping'               => '',
		'ping_status'           => '',
		'comment_status'        => 'closed',
		'comment_count'         => 0,

		'is_404'          => false,
		'is_page'         => false,
		'is_single'       => false,
		'is_archive'      => false,
		'is_tax'          => false,
	);

	// Switch defaults if post is set
	if ( isset( $wp_query->post ) ) {
		$defaults = array(
			'ID'                    => $wp_query->post->ID,
			'post_status'           => $wp_query->post->post_status,
			'post_author'           => $wp_query->post->post_author,
			'post_parent'           => $wp_query->post->post_parent,
			'post_type'             => $wp_query->post->post_type,
			'post_date'             => $wp_query->post->post_date,
			'post_date_gmt'         => $wp_query->post->post_date_gmt,
			'post_modified'         => $wp_query->post->post_modified,
			'post_modified_gmt'     => $wp_query->post->post_modified_gmt,
			'post_content'          => $wp_query->post->post_content,
			'post_title'            => $wp_query->post->post_title,
			'post_excerpt'          => $wp_query->post->post_excerpt,
			'post_content_filtered' => $wp_query->post->post_content_filtered,
			'post_mime_type'        => $wp_query->post->post_mime_type,
			'post_password'         => $wp_query->post->post_password,
			'post_name'             => $wp_query->post->post_name,
			'guid'                  => $wp_query->post->guid,
			'menu_order'            => $wp_query->post->menu_order,
			'pinged'                => $wp_query->post->pinged,
			'to_ping'               => $wp_query->post->to_ping,
			'ping_status'           => $wp_query->post->ping_status,
			'comment_status'        => $wp_query->post->comment_status,
			'comment_count'         => $wp_query->post->comment_count,

			'is_404'          => false,
			'is_page'         => false,
			'is_single'       => false,
			'is_archive'      => false,
			'is_tax'          => false,
		);
	}
	$dummy = wp_parse_args( $args, $defaults ); //, 'theme_compat_reset_post' );

	// Clear out the post related globals
	unset( $wp_query->posts );
	unset( $wp_query->post  );
	unset( $post            );

	// Setup the dummy post object
	$wp_query->post                        = new stdClass;
	$wp_query->post->ID                    = $dummy['ID'];
	$wp_query->post->post_status           = $dummy['post_status'];
	$wp_query->post->post_author           = $dummy['post_author'];
	$wp_query->post->post_parent           = $dummy['post_parent'];
	$wp_query->post->post_type             = $dummy['post_type'];
	$wp_query->post->post_date             = $dummy['post_date'];
	$wp_query->post->post_date_gmt         = $dummy['post_date_gmt'];
	$wp_query->post->post_modified         = $dummy['post_modified'];
	$wp_query->post->post_modified_gmt     = $dummy['post_modified_gmt'];
	$wp_query->post->post_content          = $dummy['post_content'];
	$wp_query->post->post_title            = $dummy['post_title'];
	$wp_query->post->post_excerpt          = $dummy['post_excerpt'];
	$wp_query->post->post_content_filtered = $dummy['post_content_filtered'];
	$wp_query->post->post_mime_type        = $dummy['post_mime_type'];
	$wp_query->post->post_password         = $dummy['post_password'];
	$wp_query->post->post_name             = $dummy['post_name'];
	$wp_query->post->guid                  = $dummy['guid'];
	$wp_query->post->menu_order            = $dummy['menu_order'];
	$wp_query->post->pinged                = $dummy['pinged'];
	$wp_query->post->to_ping               = $dummy['to_ping'];
	$wp_query->post->ping_status           = $dummy['ping_status'];
	$wp_query->post->comment_status        = $dummy['comment_status'];
	$wp_query->post->comment_count         = $dummy['comment_count'];

	// Set the $post global
	$post = $wp_query->post;

	// Setup the dummy post loop
	$wp_query->posts[0] = $wp_query->post;

	// Prevent comments form from appearing
	$wp_query->post_count = 1;
	$wp_query->is_404     = $dummy['is_404'];
	$wp_query->is_page    = $dummy['is_page'];
	$wp_query->is_single  = $dummy['is_single'];
	$wp_query->is_archive = $dummy['is_archive'];
	$wp_query->is_tax     = $dummy['is_tax'];

	// If we are resetting a post, we are in theme compat
	bp_set_theme_compat_active();
}
endif;


// HOOKS ////////////////////////////////////////////////////////////

// Filter BuddyPress template locations
add_filter( 'bp_get_template_stack', 'bp_add_template_stack_locations' );

// Register template stacks
bp_register_template_stack( 'get_stylesheet_directory', 10 );
bp_register_template_stack( 'get_template_directory',   12 );
