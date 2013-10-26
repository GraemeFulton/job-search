<?php
/*
Plugin Name: Display Taxonomies
Plugin URI: http://graylien.tumblr.com
Description: Displays taxonomies for sidebar
Version: 1.0
Author: Graeme Fulton
Author URI: http://gfulton.me.uk
*/

//add_action( 'plugins_loaded', array( 'Display_Taxonomy', 'init' ));

class Display_Taxonomy{

    //instantiate new display_taxonomy class
    public static function init() {
        $class = __CLASS__;
        new $class;
    }

    //use constructor to kickstart things
    public function __construct() {
        
        $this->display_tree();
        
    }
    
    public function display_tree(){
        
        $args = array(
       	'type'                     => 'post',
	'child_of'                 => 0,
	'parent'                   => '',
	'orderby'                  => 'name',
	'order'                    => 'ASC',
	'hide_empty'               => 1,
	'hierarchical'             => 1,
	'exclude'                  => '',
	'include'                  => '',
	'number'                   => '',
	'taxonomy'                 => 'subject',
	'pad_counts'               => false 
        );
        ?>
<ul><?php  wp_list_categories($args);?></ul>

<?php

        
    }
    
}

function display_taxonomy_tree(){
        
        $dp= new Display_Taxonomy();
       // $dp->display_tree();
    }

?>

