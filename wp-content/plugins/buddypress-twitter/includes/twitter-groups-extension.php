<?php

// Twitter Group Extension for Buddypress by Charl Kruger

// Add the form

add_filter( 'groups_custom_group_fields_editable', 'group_header_twittercj_markup' );
add_action( 'groups_group_details_edited', 'group_header_twittercj_save' );
add_action( 'groups_created_group',  'group_header_twittercj_save' );

// Retrieve the meta specific to the group

function plus_field_onecj() {
	global $bp, $wpdb;
	$field_onecj = groups_get_groupmeta( $bp->groups->current_group->id, 'group_plus_header_field-onecj' );
	return $field_onecj;
}

// Create the form to save the meta for the group

function group_header_twittercj_markup() {
global $bp, $wpdb;

 ?>
	<label for="group-field-onecj"><?php echo get_option('twittercj_group_label'); ?></label>
	<input type="text" name="group-field-onecj" id="group-field-onecj" value="<?php echo plus_field_onecj(); ?>" />
    <?php

}

// show the group twittercj score in group header
function show_field_in_headercj( $plus_field_meta ) {
	if ( plus_field_onecj() != '' && get_option('twittercj-groups-placement') == '1') { // check to see the twittercj field has data
		
		
		
		
		// check if follower count is enabled
		if ( get_option('twittercj-count') == '1' ) {
			$bp_twitter_group_count = 'true';
		} else {
			$bp_twitter_group_count = 'false';
		}
		
		
		// check if button size is large
		if (get_option('twittercj-button-size')==1) {
			$bp_twitter_group_button_size = 'data-size="large""';
		}
		
		
		
		
		$plus_field_meta .= '<a href="https://twitter.com/'. plus_field_onecj() .'" class="twitter-follow-button" data-show-count="'. $bp_twitter_group_count .'" '. $bp_twitter_group_button_size .' >Follow @'. plus_field_onecj() .'</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
		
		}
	
	return $plus_field_meta;
}
add_filter( 'bp_get_group_description', 'show_field_in_headercj' );

// show the group twittercj button in group header - before the description
function show_field_before_headercj() {
	if ( plus_field_onecj() != '' && get_option('twittercj-groups-placement') == '') { // check to see the twittercj field has data

			// check if follower count is enabled
		if ( get_option('twittercj-count') == '1' ) {
			$bp_twitter_group_count = 'true';
		} else {
			$bp_twitter_group_count = 'false';
		}
		
		
		// check if button size is large
		if (get_option('twittercj-button-size')==1) {
			$bp_twitter_group_button_size = 'data-size="large""';
		}
	
?><?php echo plus_field_onecj();?>
<a href="https://twitter.com/<?php echo plus_field_onecj();?>" class="twitter-follow-button" data-show-count="<?php echo $bp_twitter_group_count;?>" <?php echo $bp_twitter_group_button_size; ?>>Follow @<?php echo plus_field_onecj();?></a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<?php

		}
}
add_filter( 'bp_before_group_header_meta', 'show_field_before_headercj' );

// save the group header meta
function group_header_twittercj_save( $group_id ) {
	global $bp, $wpdb;

	$plain_fields = array(
		'field-onecj'
	);
	foreach( $plain_fields as $field ) {
		$key = 'group-' . $field;
		if ( isset( $_POST[$key] ) ) {
			$value = $_POST[$key];
			groups_update_groupmeta( $group_id, 'group_plus_header_' . $field, $value );
		}
	}
}



?>