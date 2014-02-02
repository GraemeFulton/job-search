<?php
/*
Plugin Name: WordPress Visual Icon Fonts
Plugin URI: http://wordpress.org/plugins/
Description: Easily and quickly add an extended 'Font Awesome' icon font icons to your content in the visual editor, visual icon management, search and filter all at your fingertips with this handy plugin.
Version: 0.5.5
Author:  Paul van Zyl
Author URI: http://profiles.wordpress.org/pushplaybang/
*/

/**
 * Copyright (c) 2013 Paul van Zyl. All rights reserved.
 *
 * Released under the GPLv2 license
 * http://www.gnu.org/licenses/gpl-2.0.html
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * **********************************************************************
 *
 */

// Include Options
include 'wpvi-options.php';

function wpvi_return_font() {
	$opfont = get_option( 'font_select' );
	if ( isset($opfont) && !empty($opfont) ) {
		return $opfont;
	} else {
		return 'fa4';
	}
}

/* Load Icon CSS
- - - - - - - - - - - - - - - - - - - - - - - - - - */
function wpvi_set_css() {
	return plugins_url('/css/wpvi-'.wpvi_return_font().'.css', __FILE__ );
}

/* Load Icon List
- - - - - - - - - - - - - - - - - - - - - - - - - - */
function wpvi_include_icon_list() {
	include 'iconlists/wpvi-'.wpvi_return_font().'.php';
}

/* Register and Enqueue Admin Scripts and Styles
- - - - - - - - - - - - - - - - - - - - - - - - - - */
function wpvi_editor_scripts() {
	// admin scripts
	wp_register_script('chosen', plugins_url('/js/chosen.js',__FILE__) );
	wp_register_script('wpvi-admin-js', plugins_url('/js/'.wpvi_return_font().'-admin.js',__FILE__) );
	wp_enqueue_script('chosen');
	wp_enqueue_script('wpvi-admin-js');

	// admin style
	wp_register_style('wpvi-admin-css', plugins_url('/css/wpvi-admin-style.css', __FILE__ ) );
	wp_enqueue_style('wpvi-admin-css');

	// Font CSS
	wp_register_style('wpvi-font-css', wpvi_set_css() );
	wp_enqueue_style('wpvi-font-css');
}

/* Add Icon CSS to the Editor
- - - - - - - - - - - - - - - - - - - - - - - - - - */
function wpvi_plugin_mce_css( $mce_css ) {
	if ( ! empty( $mce_css ) ) {
		$mce_css .= ',';
	}

	$mce_css .= wpvi_set_css();
	return $mce_css;
}

/* Add Icon Select Drop Down above editor
- - - - - - - - - - - - - - - - - - - - - - - - - - */
function wpvi_add_icon_select() {
	$icons = wpvi_icon_list();
    echo '<a id="ico-trig" class="button">Icons</a><span class="ico-wrap"><select id="icon_select"><option>Icons</option>';
    	foreach($icons as $icon) {
    		echo '<option>'.$icon.'</option>';
    	}
    echo '</select><a id="ico-close" class="button">X</a></span>';
}

/* Additional editor buttons
  - - - - - - - - - - - - - - - - - - - - - - - - - */
function wpvi_add_more_buttons($buttons) {
	$buttons[] = 'fontsizeselect';
	$buttons[] = 'forecolorpicker';
	return $buttons;
}

/* Add a custom selection
  - - - - - - - - - - - - - - - - - - - - - - - - - */
function wpvi_text_sizes($initArray){
	$initArray['theme_advanced_font_sizes'] = "10px,12px,14px,16px,18px,20px,22px,24px,30px,36px,48px,54px,61px,72px,84px,96px";
	return $initArray;
}

/* Add Actions for plugin backend
  - - - - - - - - - - - - - - - - - - - - - - - - - */
function wpvi_admin() {
	add_action('edit_form_after_title', 'wpvi_icon_list', 10 );
	add_action('edit_form_after_title', 'wpvi_editor_scripts', 11);
	add_action('media_buttons','wpvi_add_icon_select',12);
	add_filter( 'mce_css', 'wpvi_plugin_mce_css' );
	add_filter("mce_buttons_3", "wpvi_add_more_buttons");
	add_filter('tiny_mce_before_init', 'wpvi_text_sizes');
}


/* Register and Enqueue Icons on the front End
  - - - - - - - - - - - - - - - - - - - - - - - - - */
function wp_v_icon_frontend_styles() {
	wp_register_style('wp-v-icons-css', wpvi_set_css() );
	wp_enqueue_style('wp-v-icons-css');
}

/* Run Actions
  - - - - - - - - - - - - - - - - - - - - - - - - - */
add_action('admin_head', 'wpvi_include_icon_list');
add_action('admin_head', 'wpvi_admin');
add_action( 'wp_head', 'wp_v_icon_frontend_styles' );


add_action( 'contextual_help', 'wptuts_screen_help', 10, 3 );
function wptuts_screen_help( $contextual_help, $screen_id, $screen ) {

    // The add_help_tab function for screen was introduced in WordPress 3.3.
    if ( ! method_exists( $screen, 'add_help_tab' ) )
        return $contextual_help;

    global $hook_suffix;

    // List screen properties
    $variables = '<ul style="width:50%;float:left;"> <strong>Screen variables </strong>'
        . sprintf( '<li> Screen id : %s</li>', $screen_id )
        . sprintf( '<li> Screen base : %s</li>', $screen->base )
        . sprintf( '<li>Parent base : %s</li>', $screen->parent_base )
        . sprintf( '<li> Parent file : %s</li>', $screen->parent_file )
        . sprintf( '<li> Hook suffix : %s</li>', $hook_suffix )
        . '</ul>';

    // Append global $hook_suffix to the hook stems
    $hooks = array(
        "load-$hook_suffix",
        "admin_print_styles-$hook_suffix",
        "admin_print_scripts-$hook_suffix",
        "admin_head-$hook_suffix",
        "admin_footer-$hook_suffix"
    );

    // If add_meta_boxes or add_meta_boxes_{screen_id} is used, list these too
    if ( did_action( 'add_meta_boxes_' . $screen_id ) )
        $hooks[] = 'add_meta_boxes_' . $screen_id;

    if ( did_action( 'add_meta_boxes' ) )
        $hooks[] = 'add_meta_boxes';

    // Get List HTML for the hooks
    $hooks = '<ul style="width:50%;float:left;"> <strong>Hooks </strong> <li>' . implode( '</li><li>', $hooks ) . '</li></ul>';

    // Combine $variables list with $hooks list.
    $help_content = $variables . $hooks;

    // Add help panel
    $screen->add_help_tab( array(
        'id'      => 'wptuts-screen-help',
        'title'   => 'Screen Information',
        'content' => $help_content,
    ));

    return $contextual_help;
}