<?php
/**
 * The Template for displaying all single posts.
 *
 * @package klein
 *
 */

get_header(); ?>
<?php global $post; ?>
<?php 

	$post_layout = get_post_meta( $post->ID, 'klein_page_layout', true );
	$layout = empty( $post_layout ) ? 'content-sidebar' : $post_layout;
	
	get_template_part( 'layout', $layout );
?>
<?php get_footer(); ?>