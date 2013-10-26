<?php

	/**
	* @Filter default skins/styles for the plugin
	*/
	add_filter('acn_builtin_skins', 'acn_builtin_skins');
	function acn_builtin_skins($array=array()) {
	
		$array['default'] = array(
			'name' => 'Default',
			'wrapper_bg_color' => '#eee',
			'item_bg_color' => '#fff',
			'item_shadow_color' => '#333',
			'primary_color' => '#ff0067',
			'nav_link_color' => '#666',
			'nav_link_color_hover' => '#222',
			'unchecked_color' => '#ccc',
			'checked_color' => '#444',
			'count_bg_color' => '#ccc',
			'count_color' => '#fff',
			'count_bg_color_hover' => '#888',
			'count_color_hover' => '#fff',
			'primary_link_color' => '#333',
			'date_color' => '#aaa',
			'zoom_bg_color' => '#666',
			'zoom_color' => '#fff',
			'zoom_bg_color_hover' => '#fff',
			'tags_bg_color' => '#f5f5f5',
			'author_bg' => '#ddd',
			'solid_border' => '#eee',
			'dotted_border' => '#ddd',
			'nav_bg_color' => '#fff',
			'ecom_bg_color' => '#f5f5f5'
		);

		ksort($array);
		return $array;
	}