<?php

/**
 * BuddyPress Members Visual Composer
 *
 * @since 1.0
 */
 
vc_map( 
	array(
		"name" => __("BP Members Carousel"),
		"base" => "gears_bp_members_carousel",
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
							'Online' => 'online',
							'Alphabetical' => 'alphabetical',
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
					"value" => 10,
					"description" => __("How many members you want to display.")
				),
				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __("Max Slide"),
					"param_name" => "max_slides",
					"value" => 7,
					"description" => __("Maximum number of items you want your carousel to have.")
				),
				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __("Min Slide"),
					"param_name" => "min_slides",
					"value" => 1,
					"description" => __("Minimum number of items you want your carousel to have. Applies to mobile.")
				),
				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __("Item Width"),
					"param_name" => "item_width",
					"value" => 85,
					"description" => __("How many members you want to display.")
				)
			)
	)
);
?>