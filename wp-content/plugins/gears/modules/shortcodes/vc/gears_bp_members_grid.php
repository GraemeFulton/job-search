<?php

/**
 * BuddyPress Members Grid Visual Composer
 *
 * @since 1.0
 */
//[gears_bp_members_grid type="alphabetical" max_item="12" size="2"]
vc_map( 
	array(
		"name" => __("BP Members Grid"),
		"base" => "gears_bp_members_grid",
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
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __("Size"),
					"param_name" => "size",
					"value" => array(
							'1' => '1',
							'2' => '2',
							'3' => '3',
							'4' => '4',
							'5' => '5',
							'6' => '6',
							'7' => '7',
							'8' => '8',
							'9' => '9',
							'10' => '10',
							'11' => '11',
							'12' => '12'
						),
					"description" => __("Ranging from 1 - 12. Select the best size for avatars.")
				)
			)
	)
);
?>