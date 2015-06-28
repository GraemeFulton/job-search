<?php
/*
Plugin Name: Ajax save profile settings
Plugin URI: http://graylien.tumblr.com
Description: save profile settings asynchronously
Version: 1.0
Author: Graeme Fulton
Author URI: http://gfulton.me.uk
*/
wp_register_script('ajax-save-profile', plugins_url('js/ajax-save-profile.js', __FILE__), array( 'jquery' ));
wp_enqueue_script('ajax-save-profile');
wp_localize_script('ajax-save-profile', 'ajax_var', array('url'=>admin_url('admin-ajax.php')));

add_action('wp_ajax_ajax_save', 'ajax_save');
add_action('wp_ajax_nopriv_ajax_save', 'ajax_save');

function ajax_save(){
	
	echo 'hola';
	exit();
}

?>
