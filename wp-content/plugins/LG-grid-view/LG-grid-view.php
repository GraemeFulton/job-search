<?php
/*
Plugin Name: LG Gridview
Plugin URI: http://graylien.tumblr.com
Description: Provides the lostgrad gridview to any theme
Version: 1.0
Author: Graeme Fulton
Author URI: http://gfulton.me.uk
*/

   /*
     * Action: load checkbox.js script
     */
    function lg_gridview_css()
    {
        //css
        wp_register_style( 'lg_gridview', plugins_url('/css/lg_gridview.css', __FILE__) );
        wp_enqueue_style( 'lg_gridview' );
    }
    
    add_action( 'wp_enqueue_scripts', 'lg_gridview_css' );
    
    /****************
 * SINGLE TEMPLATES
 ******************/
//Gets post cat slug and looks for single-[cat slug].php and applies it
add_filter('single_template', create_function(
	'$the_template',
	'foreach( (array) get_the_category() as $cat ) {
		if ( file_exists(TEMPLATEPATH . "/single-{$cat->slug}.php") )
		return TEMPLATEPATH . "/single-{$cat->slug}.php"; }
	return $the_template;' )
);

    
    
   //shortcode to display gridview
    function lg_gridview() {
        global $lg_tree;
        global $wp;
    	$id=get_the_ID();
    	$page=get_post($id);
         
        if($page->post_title=='Learn')
            {
                $include="gridview_learn.php";
                $post_category="course";
                $tag_type="subject";
                $body_type="uni";
            }
            elseif($page->post_title=='Experience')
            {
                add_filter( 'posts_where', 'wpa57065_filter_where' );
                $include= "gridview_experience.php";
                $post_category='work-experience-job';
                 $tag_type="profession";
              $body_type="company";
            }
            elseif($page->post_title=='Work')
            {
                add_filter( 'posts_where', 'wpa57065_filter_where' );
              $include="gridview_work.php"; 
              $post_category='graduate-job';
              $tag_type="profession";
              $body_type="company";
            }
            elseif($page->post_title=='Inspire')
            {
                $include="gridview_inspire.php";
                $post_category='inspire-posts';
                $tag_type="topic";
                $body_type="inspire-tag";

            }
            elseif($page->post_title=='Travel')
            {
                $include="gridview_travel.php";
                $post_category='travel-opportunities';
                $tag_type="destination";
                $body_type="destination";
            }
                                           
        include("templates/base_gridview.php");       
    }
    add_action('lostgrad_gridview','lg_gridview');
    
?>
