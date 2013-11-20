<?php
/*
Plugin Name: Isotopes
Plugin URI: http://graylien.tumblr.com
Description: Adds Isotope/Masonry to gridview
Version: 1.0
Author: Graeme Fulton
Author URI: http://gfulton.me.uk
*/

   /*
     * Action: load checkbox.js script
     */
    function isotopes_scripts()
    {
        //js
        wp_enqueue_script('isotopes', plugins_url('/js/isotopes.js',__FILE__) );
        wp_enqueue_script('isotopes_action', plugins_url('/js/isotopes_action.js',__FILE__) );
        
        //css
        wp_register_style( 'isotopes_css', plugins_url('/css/isotopes_css.css', __FILE__) );
        wp_enqueue_style( 'isotopes_css' );
    }
    add_action( 'wp_enqueue_scripts', 'isotopes_scripts' );

    
    /*
     * add isotope class to post items
     */
//    function additional_classes($class) {
//       $class[] = 'isotope-item';
//       return $class;
//    }   
//    add_filter('post_class', 'additional_classes');

   
?>

