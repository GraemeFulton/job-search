<?php
/**
 * bbPress Forum Wrapper
 *
 * @package klein
 */

get_header(); ?>
<?php global $post, $klein; ?>

<?php
// if is forum archive
// use bbPress content-sidebar 
// use bbPress right sidebar
if( bbp_is_forum_archive() ){?>
	<?php //get option tree record ?>
	<?php $post_layout = ot_get_option( 'bbp_layout', 'content-sidebar' ); ?>
	<?php get_template_part( 'layout-page', $post_layout ); ?>
<?php }else{ // end bbp_is_forum_archive ?>
	<?php 
		$post_layout = get_post_meta( $post->ID, 'klein_page_layout', true ); 
		// if there is no page template saved
		// load the default
		if( empty( $post_layout ) ){
			// $settings_layout = $klein::get( 'page_layout' );
			$settings_layout = ot_get_option( 'default_layout', 'content-sidebar' );
			
			get_template_part( 'layout-page', $settings_layout );
			// if options still empty, load it directly
			if( empty( $settings_layout ) ){
				get_template_part( 'layout-page', 'content-sidebar' );
			}
		}
		get_template_part( 'layout-page', $post_layout );
	?>
<?php } ?>
<?php get_footer(); ?>
