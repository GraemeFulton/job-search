<?php
/*
Plugin Name: LG Sidebar Adverts
Plugin URI: http://graylien.tumblr.com
Description: Provides the lostgrad sidebar filter panel as a widget
Version: 1.0
Author: Graeme Fulton
Author URI: http://gfulton.me.uk
*/

//shortcode to display gridview
    function lg_sidebar_adverts() {
        
        require("templates/sidebar-right.php");
        
        
    }
    add_action('lostgrad_sidebar_adverts','lg_sidebar_adverts');
