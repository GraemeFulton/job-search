<?php
/*
Plugin Name: Select2
Plugin URI: http://graylien.tumblr.com
Description: Simply includes Select 2 Javascript and CSS to your site
Version: 1.0
Author: Graeme Fulton
Author URI: http://gfulton.me.uk
*/


    function select2_scripts()
    {
        //js
        wp_enqueue_script('select2', plugins_url('select2.min.js',__FILE__) );
       
        
        //css
        wp_register_style( 'select2', plugins_url('select2.css', __FILE__) );
        wp_enqueue_style( 'select2' );
        
         wp_register_style( 'select2-bootstrap', plugins_url('select2-bootstrap.css', __FILE__) );
        wp_enqueue_style( 'select2-bootstrap' );
    }
    add_action( 'wp_enqueue_scripts', 'select2_scripts' ); 
?>
