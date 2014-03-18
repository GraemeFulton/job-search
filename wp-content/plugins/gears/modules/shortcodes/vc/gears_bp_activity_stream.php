<?php
/**
 * Gears BP Activity Stream
 */
 /* 'activity_button_link' => '',
					'activity_button_label' => '',
					'max' => 5,
					'show' => false */
vc_map( 
	array(
		"name" => __("Members Activity Stream"),
		"base" => "gears_bp_activity_stream",
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
					"heading" => __("Show"),
					"param_name" => "show",
					"value" => array(
						'All' => false,
						'Blogs' => 'blogs',
						'Groups' => 'groups',
						'Friends' => 'friends',
						'Profile' => 'profile',
						'Status' => 'status'
					),
					"description" => __("Activity filter. Select 'All' option to show all kinds of activity.")
				),
				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __("Max"),
					"param_name" => "max",
					"value" => '5',
					"description" => __("The max number of feeds you'd like to appear in the stream.")
				),
				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __("Activity Button Link"),
					"param_name" => "activity_button_link",
					"value" => 'htt://yoursite.com/activity',
					"description" => __( 'Enter the url of your activity page.', 'gears' )
				),
				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __("Activity Button Label"),
					"param_name" => "activity_button_label",
					"value" => 'Show All Activity',
					"description" => __("The label of link that appears at this activity stream. Leave blank to disable.")
				)
			)
	)
);
?>