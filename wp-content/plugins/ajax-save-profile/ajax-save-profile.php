<?php
/*
Plugin Name: Ajax save profile settings
Plugin URI: http://graylien.tumblr.com
Description: save profile settings asynchronously
Version: 1.0
Author: Graeme Fulton
Author URI: http://gfulton.me.uk
*/
global $bp;

function ajax_save_main(){
if(bp_is_my_profile()){
	wp_register_script('ajax-save-profile', plugins_url('js/chb.js', __FILE__), array( 'jquery' ));
	wp_enqueue_script('ajax-save-profile');
	wp_localize_script('ajax-save-profile', 'ajax_var', array('url'=>admin_url('admin-ajax.php')));

	add_action('wp_ajax_ajax_save', 'ajax_save');
	add_action('wp_ajax_nopriv_ajax_save', 'ajax_save');
	}
}
add_action( 'bp_include', 'ajax_save_main' );

function ajax_save(){

	global $current_user;
	global $bp;
	get_currentuserinfo();

		//@TODO: filter cookies before inserting into db
		
	 		$selected_profession= StripSlashes($_POST["selected"]);
			$selected_profession=str_replace('&', '&amp;', $selected_profession);

			//$current_selections = xprofile_get_field_data()
			//we always need the parent id so we can add chosen options to the parent group
			$parent = get_term_top_most_parent($selected_profession, 'profession');


			if(!$parent){
				$parent=$selected_profession;
			}
				$field_id = xprofile_get_field_id_from_name($parent->name);
				$current_professions = xprofile_get_field_data($parent->name, $current_user->id);
				//if already selected, remove the item from the array
				if(in_array($selected_profession, $current_professions)){
					$index = array_search($selected_profession,$current_professions);
					if($index !== FALSE){
					    unset($current_professions[$index]);
					}
				}
				//if not selected push the item to the array
				else{
					array_push($current_professions, $selected_profession);
				}

				xprofile_set_field_data($field_id,$current_user->id,$current_professions);




}


// determine the topmost parent of a term
function get_term_top_most_parent($term_id, $taxonomy){
    // start from the current term
    $parent  = get_term_by( 'name', $term_id, $taxonomy);
    // climb up the hierarchy until we reach a term with parent = '0'
    while ($parent->parent != '0'){
        $term_id = $parent->parent;

        $parent  = get_term_by( 'id', $term_id, $taxonomy);
    }
    return $parent;
}



// function ajax_save(){
//
// 		global $current_user;
// 		global $bp;
// 		get_currentuserinfo();
//
// 		$obj = stripslashes($_POST['selected']);
// 		$object = json_decode($obj);
//
// 		foreach ($object as $item) {
//
// 			$item->value = str_replace('&', '&amp;', $item->value);
//
//
// 				//set the data
// 				if($item->value=='blank'){
// 					$item->value='';
// 				}
// 				$grp = explode(" ", $item->group);
// 				$id = explode("_", $grp[1]);
// 				$item->group = $id[1];
//
// 				if($item->group==null){
// 					$grp = explode('_', $item->id);
// 					$item->group=$grp[1];
// 				}
//
// 			//xprofile_set_field_data($field_id, $current_user->id, $item->value);
//
//
//
// 		}
//
// 		$new_array = array();
// 		foreach ($object as $item)
// 		    $new_array[$item->group][] = $item;
//
//
//
// 		foreach($new_array as $key => $items){
//
// 			$insert= array();
// 			foreach($items as $item){
//
// 				array_push($insert, $item->value);
//
// 			}
//
// 			$putin=array();
// 			foreach($insert as $ins){
// 				array_push($putin,$ins);
//
//
// 			}
//
// 							//    var_dump($key);
// 	            //    var_dump($putin);
// 						//	var_dump($putin);
// 						var_dump($current_user->id);
// 		//	xprofile_set_field_data($key, $current_user->id,$putin);
//
// 		}
//
// 		echo 'done';
//
// 		exit();
// }

?>
