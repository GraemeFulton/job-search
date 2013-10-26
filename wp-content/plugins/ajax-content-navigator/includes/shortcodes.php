<?php

	/* display function */
	add_shortcode('acn', 'acn_display');
	function acn_display($atts) {
		global $acn;
		return $acn->show( $atts );
	}
	
	/* add button */
	add_action( 'init', 'acn_add_button' );
	add_filter( 'tiny_mce_version', 'acn_refresh_mce' );
	function acn_add_button() {
	   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )
	   {
		add_filter('mce_external_plugins', 'acn_add_shortcode_tinymce_plugin');
		add_filter('mce_buttons', 'acn_register_button');
	   }
	}
	
	function acn_refresh_mce( $ver ) {
		$ver += 3;
		return $ver;
	}
	
	/* Register button */
	function acn_register_button($buttons) {
		array_push($buttons, "|", "acn_shortcodes_button");
		return $buttons;
	}

	function acn_add_shortcode_tinymce_plugin($plugin_array) {
		global $upme;
		$plugin_array['ACNShortcodes'] = acn_url . 'admin/js/editor_plugin.js';
		return $plugin_array;
	}