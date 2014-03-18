<?php

/**
 * BuddyPress Groups Carousel
 *
 * @since 1.0
 */
 
// [gears_bp_groups_carousel type=’active’ max_item =’10’ max_slides=’7’ min_slides=’1’ item_width=’100’] 

vc_map( 
	array(
		"name" => __("BP Groups Carousel"),
		"base" => "gears_bp_groups_carousel",
		"class" => "",
		"category" => __('Gears'),
		"icon" => "gears-bp-icon",
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
				),
				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __("Max Slides"),
					"param_name" => "max_slides",
					"value" => 7,
					"description" => __("The maximum number of slides to show in screen.")
				),
				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __("Min Slides"),
					"param_name" => "min_slides",
					"value" => 1,
					"description" => __("The minimum number of slides to show in screen.")
				),
				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __("Item Width"),
					"param_name" => "item_width",
					"value" => '100',
					"description" => __("The width of group’s image per item.")
				)
			)
	)
);
?>