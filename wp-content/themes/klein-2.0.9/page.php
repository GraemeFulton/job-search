<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package klein
 */

get_header(); ?>

<?php global $post; ?>
<?php 
	$post_layout = get_post_meta( $post->ID, 'klein_page_layout', true ); 
	// if there is no page template saved
	// load the default
	if( empty( $post_layout ) ){
		$post_layout = 'content-sidebar';
	}
	
	get_template_part( 'layout-page', $post_layout );
	

?>

<?php get_footer(); ?>
