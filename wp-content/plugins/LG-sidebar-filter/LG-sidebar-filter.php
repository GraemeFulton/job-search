<?php
/*
Plugin Name: LG Sidebar Filter
Plugin URI: http://graylien.tumblr.com
Description: Provides the lostgrad sidebar filter panel as a widget
Version: 1.0
Author: Graeme Fulton
Author URI: http://gfulton.me.uk
*/

   /*
     * Action: load checkbox.js script
     */
    function lg_sidebar_css()
    {
        //css
        wp_register_style( 'lg_sidebar', plugins_url('/css/lg_sidebar.css', __FILE__) );
        wp_enqueue_style( 'lg_sidebar' );
    }
    
    add_action( 'wp_enqueue_scripts', 'lg_sidebar_css' );
    
    
    function lg_sidebar_scroll_js(){
    	wp_enqueue_script('lg_sidebar_scroll', plugins_url('/js/lg_sidebar_scroll.js',__FILE__) );

    }
    add_action( 'wp_enqueue_scripts', 'lg_sidebar_scroll_js' );
            
   //shortcode used on homepage to display featured posts (admins favourites)
    function lg_sidebar_filter() {
        global $lg_tree;
        global $wp;
    	$id=get_the_ID();
    	$page=get_post($id);
        
        if($page->post_title=='Learn'){
            $lg_tree= display_taxonomy_tree('subject', 'uni');
           require("templates/learn_sidebar_filter.php");
        }
        elseif($page->post_title=='Experience'){
            $lg_tree= display_taxonomy_tree('profession', 'company');
            require("templates/experience_sidebar_filter.php");
        }
        
        elseif($page->post_title=='Work'){
            $lg_tree= display_taxonomy_tree('profession', 'company');
            require("templates/work_sidebar_filter.php");        
        }
        elseif($page->post_title=='Inspire'){
            
            $lg_tree= display_taxonomy_tree('topic', 'inspire-tag');
            require("templates/inspire_sidebar_filter.php");
        }
        elseif($page->post_title=='Travel'){
          $lg_tree= display_taxonomy_tree('destination', 'destination');
            require("templates/travel_sidebar_filter.php");
        }
        
    }
    add_action('lostgrad_sidebar_filter','lg_sidebar_filter');
 
?>
