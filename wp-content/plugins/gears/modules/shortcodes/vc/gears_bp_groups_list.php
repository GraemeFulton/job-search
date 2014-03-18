<?php

/**
 * BuddyPress Groups List
 *
 * @since 1.0
 */
 
// [gears_bp_groups_grid type=”” max_item=”” size=””]

vc_map( 
	array(
		"name" => __("BP Groups List"),
		"base" => "gears_bp_groups_list",
		"class" => "",
		"icon" => "gears-bp-icon",
		"category" => __('Gears'),
		'admin_enqueue_js' => array(),
		'admin_enqueue_css' => array(),
		"params" => array(
				array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __("Type"),
					"param_name" => "type",
					"value" => array(
							'Active' => 'active',
							'Newest' => 'newest',
							'Popular' => 'popular',
							'Alphabetical' => 'alphabetical',
							'Most Forum Topics' => 'most-forum-topics',
							'Most Forum Posts' => 'most-forum-posts',
							'Random' => 'random'
						),
					"description" => __("Select what type of members you want to display.")
				),
				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __("Max"),
					"param_name" => "max_item",
					"value" => 12,
					"description" => __("How many members you want to display.")
				)
			)
	)
);
?>