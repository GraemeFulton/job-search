<?php
/**
 * (Beta)Template Name: Front Page (Slider Revolution + Custom Content)
 */
 
 /**
  * @package klein
  * @since 2.0
  */

get_header();

/**
 * Just allow the content 
 * to be place here..
 */

if( have_posts() ){
	while( have_posts() ){
		the_post();
		// using the WordPress loop, we'll display the post content here
		// inorder for page builder to work, you need the page builder's shortcode
		// right into the textarea wherein you compose your blog
		the_content();
	}
}

get_footer();
?>