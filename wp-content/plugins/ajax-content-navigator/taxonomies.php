<?php

/**
*@This file contains custom taxonomies, they are commented/disabled
*@by default - I made this for testing purposes for hierarchical
*@taxonomies with ACN plugin. Simply uncomment it if you will use them
*/

add_action( 'init', 'acn_model_taxonomy' );
function acn_model_taxonomy() {
  $labels = array(
    'name' => __( 'Models' ),
    'singular_name' => __( 'Model' ),
    'search_items' =>  __( 'Search Models' ),
    'all_items' => __( 'All Models' ),
    'parent_item' => __( 'Parent Model' ),
    'parent_item_colon' => __( 'Parent Model:' ),
    'edit_item' => __( 'Edit Model' ), 
    'update_item' => __( 'Update Model' ),
    'add_new_item' => __( 'Add New Model' ),
    'new_item_name' => __( 'New Model Name' ),
    'menu_name' => __( 'Models' ),
  ); 	
  register_taxonomy('acn_models','post', array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'acn_models', 'hierarchical' => true ),
  ));
}