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
	
	global $current_user;
	global $bp;
	get_currentuserinfo();
	
	$obj = stripslashes($_POST['selected']);
	$object = json_decode($obj);
	
	//var_dump($object);
	
	foreach ($object as $item) {
		
		$item->value = str_replace('&', '&amp;', $item->value);
			
						
			//set the data
			if($item->value=='blank'){
				$item->value='';
			}
			$grp = explode(" ", $item->group);
			$id = explode("_", $grp[1]);
			$item->group = $id[1];
			
			if($item->group==null){
				$grp = explode('_', $item->id); 
				$item->group=$grp[1];
			}
		
		//xprofile_set_field_data($field_id, $current_user->id, $item->value);
			
		
		
	}
	
	var_dump($object);
	$new_array = array();
	foreach ($object as $item)
	    $new_array[$item->group][] = $item;
	  	
	
	
	foreach($new_array as $key => $items){
		
		$insert= array();
		foreach($items as $item){
			
			array_push($insert, $item->value);
			
		}
// 		var_dump($key);
//		var_dump($insert);
		$putin=array();
		foreach($insert as $ins){
			array_push($putin,$ins);
			
			
		}
		var_dump($putin);
		xprofile_set_field_data($key, $current_user->id,$putin);
		
	}
	
	echo 'done';

	exit();
}

function array_2d_to_1d ($input_array) {
    $output_array = array();

    for ($i = 0; $i < count($input_array); $i++) {
      for ($j = 0; $j < count($input_array[$i]); $j++) {
        $output_array[] = $input_array[$i][$j];
      }
    }

    return $output_array;
}

?>
