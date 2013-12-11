<?php
/*
Plugin Name: Display Taxonomies
Plugin URI: http://graylien.tumblr.com
Description: Displays taxonomies for sidebar
Version: 1.0
Author: Graeme Fulton
Author URI: http://gfulton.me.uk
*/

    
    /* display_taxonomy_tree
     * 
     * plugin hook called from sidebar
     * @params: 
     * tag_type - the tag group e.g. subject
     * grouped_taxonomy - the taxonomy group e.g. uni
     * 
     * Creates a new Display_Taxonomy instance, and prints the relevant 
     * filters
     * 
     */
     
    include("display-tax-libs.php");
    
    function display_taxonomy_tree($tag_type, $grouped_taxonomy)
    {
        global $dp;
        $dp= new Display_Taxonomy($tag_type, $grouped_taxonomy);

        return $dp;
    }
   // add_action( 'plugins_loaded', array( 'Display_Taxonomy', 'init' ));

    /*
     * Action: load checkbox.js script
     */
    function load_js()
    {
        wp_enqueue_script('display-taxonomy', plugins_url('/js/display-taxonomy.js',__FILE__) );
        wp_enqueue_script('listeners', plugins_url('/js/listeners.js',__FILE__) );

        echo '<script> templateUrl = "'.plugins_url("display-taxonomy").'"</script>';
    }
    add_action('wp_head','load_js');


    /*
     * ajax course subject filter hooks
     */
    include("ajax-filters.php");

    add_action('wp_ajax_nopriv_check_box_filters', 'process_filter');
    add_action('wp_ajax_check_box_filters', 'process_filter');

    
?>

