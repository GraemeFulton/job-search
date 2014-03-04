<?php
function wpfp_widget_init() {
	/*************************
	 *  Most favorites widget
	 *************************/
    function wpfp_widget_view($args) {
        extract($args);
        $options = wpfp_get_options();
        if (isset($options['widget_limit'])) {
            $limit = $options['widget_limit'];
        }
        $title = empty($options['widget_title']) ? 'Most Favorited Posts' : $options['widget_title'];
        echo $before_widget;
        echo $before_title . $title . $after_title;
        wpfp_list_most_favorited($limit);
        echo $after_widget;
    }

    function wpfp_widget_control() {
        $options = wpfp_get_options();
        if (isset($_POST["wpfp-widget-submit"])):
            $options['widget_title'] = strip_tags(stripslashes($_POST['wpfp-title']));
            $options['widget_limit'] = strip_tags(stripslashes($_POST['wpfp-limit']));
            update_option("wpfp_options", $options);
        endif;
        $title = $options['widget_title'];
        $limit = $options['widget_limit'];
    ?>
        <p>
            <label for="wpfp-title">
                <?php _e('Title:'); ?> <input type="text" value="<?php echo $title; ?>" class="widefat" id="wpfp-title" name="wpfp-title" />
            </label>
        </p>
        <p>
            <label for="wpfp-limit">
                <?php _e('Number of posts to show:'); ?> <input type="text" value="<?php echo $limit; ?>" style="width: 28px; text-align:center;" id="wpfp-limit" name="wpfp-limit" />
            </label>
        </p>
        <?php if (!$options['statics']) { ?>
        <p>
            You must enable statics from favorite posts <a href="plugins.php?page=wp-favorite-posts" title="Favorite Posts Configuration">configuration page</a>.
        </p>
        <?php } ?>
        <input type="hidden" name="wpfp-widget-submit" value="1" />
    <?php
    }
    wp_register_sidebar_widget('wpfp-most_favorited_posts', 'Most Favorited Posts', 'wpfp_widget_view');
    wp_register_widget_control('wpfp-most_favorited_posts', 'Most Favorited Posts', 'wpfp_widget_control' );

    /*************************
     *  Users favorites widget
    *************************/
    function wpfp_users_favorites_widget_view($args) {
        extract($args);
        $options = wpfp_get_options();
        if (isset($options['uf_widget_limit'])) {
            $limit = $options['uf_widget_limit'];
        }
        $title = empty($options['uf_widget_title']) ? 'Users Favorites' : $options['uf_widget_title'];
        echo $before_widget;
        echo $before_title
             . $title
             . $after_title;
        $favorite_post_ids = wpfp_get_users_favorites();

		$limit = $options['uf_widget_limit'];
        if (@file_exists(TEMPLATEPATH.'/wpfp-your-favs-widget.php')):
            include(TEMPLATEPATH.'/wpfp-your-favs-widget.php');
        else:
            include("wpfp-your-favs-widget.php");
        endif;
        echo $after_widget;
    }
    

    function wpfp_users_favorites_widget_control() {
        $options = wpfp_get_options();
        if (isset($_POST["wpfp-uf-widget-submit"])):
            $options['uf_widget_title'] = strip_tags(stripslashes($_POST['wpfp-uf-title']));
            $options['uf_widget_limit'] = strip_tags(stripslashes($_POST['wpfp-uf-limit']));
            update_option("wpfp_options", $options);
        endif;
        $uf_title = $options['uf_widget_title'];
        $uf_limit = $options['uf_widget_limit'];
    ?>
        <p>
            <label for="wpfp-uf-title">
                <?php _e('Title:'); ?> <input type="text" value="<?php echo $uf_title; ?>" class="widefat" id="wpfp-uf-title" name="wpfp-uf-title" />
            </label>
        </p>
        <p>
            <label for="wpfp-uf-limit">
                <?php _e('Number of posts to show:'); ?> <input type="text" value="<?php echo $uf_limit; ?>" style="width: 28px; text-align:center;" id="wpfp-uf-limit" name="wpfp-uf-limit" />
            </label>
        </p>

        <input type="hidden" name="wpfp-uf-widget-submit" value="1" />
    <?php
    }
    wp_register_sidebar_widget('wpfp-users_favorites','User\'s Favorites', 'wpfp_users_favorites_widget_view');
    wp_register_widget_control('wpfp-users_favorites','User\'s Favorites', 'wpfp_users_favorites_widget_control' );
}
add_action('widgets_init', 'wpfp_widget_init');

/****************************************************************************
 * >>>>>>>>>>>>>New updates by graylien: should add this to a new file>>>>>>
 * **************************************************************************
 */

//*** graylien favorites widget ***//
function wpfp_graylien_users_favorites_widget_view($user_name) {

	$options = wpfp_get_options();
	if (isset($options['uf_widget_limit'])) {
		$limit = $options['uf_widget_limit'];
	}
	$title = empty($options['uf_widget_title']) ? 'Users Favorites' : "<h4>".$user_name."'s Favourites</h4>";
	echo $before_widget;
	echo $before_title
	. $title
	. $after_title;
	$favorite_post_ids = wpfp_get_users_favorites($user_name);

	$limit = $options['uf_widget_limit'];
	if (@file_exists(TEMPLATEPATH.'/wpfp-your-favs-widget.php')):
	include(TEMPLATEPATH.'/wpfp-your-favs-widget.php');
	else:
	include("wpfp-your-favs-widget.php");
	endif;
	echo $after_widget;
}
/*************************
 *  Lostgrad ALL favorites widget
*************************/
function wpfp_lostgrad_widget_view($args) {
	extract($args);
$options = wpfp_get_options();
if (isset($options['lg_widget_limit'])) {
	$limit = $options['lg_widget_limit'];
}
if (isset($options['lg_widget_posttype'])) {
	$posttype = $options['lg_widget_posttype'];
}
//$title = empty($options['lg_widget_title']) ? 'Users Favorites' : $options['lg_widget_title'];
//echo $before_widget;
//echo $before_title. $title. $after_title;
global $bp;
$favorite_post_ids = wpfp_get_users_favorites($bp->displayed_user->fullname);

$limit = $options['lg_widget_limit'];

include("templates/all_favourites.php");

echo $after_widget;
}

function wpfp_lostgrad_widget_control() {
	$options = wpfp_get_options();
	if (isset($_POST["wpfp-lg-widget-submit"])):
	$options['lg_widget_title'] = strip_tags(stripslashes($_POST['wpfp-title']));
	$options['lg_widget_limit'] = strip_tags(stripslashes($_POST['wpfp-limit']));
	$options['lg_widget_posttype'] = strip_tags(stripslashes($_POST['wpfp-posttype']));
	
	update_option("wpfp_options", $options);
	endif;
	$title = $options['lg_widget_title'];
	$limit = $options['lg_widget_limit'];
	$posttype = $options['lg_widget_posttype'];
	
	?>
        <p>
            <label for="wpfp-title">
                <?php _e('Title:'); ?> <input type="text" value="<?php echo $title; ?>" class="widefat" id="wpfp-title" name="wpfp-title" />
            </label>
        </p>
         <p>
            <label for="wpfp-posttype">
                <?php _e('Type of posts to show:'); ?> <input type="text" value="<?php echo $posttype; ?>" style="width: 100px; text-align:left;" id="wpfp-posttype" name="wpfp-posttype" />
            </label>
        </p>
        <p>
            <label for="wpfp-limit">
                <?php _e('Number of posts to show:'); ?> <input type="text" value="<?php echo $limit; ?>" style="width: 28px; text-align:center;" id="wpfp-limit" name="wpfp-limit" />
            </label>
        </p>
        <?php if (!$options['statics']) { ?>
        <p>
            You must enable statics from favorite posts <a href="plugins.php?page=wp-favorite-posts" title="Favorite Posts Configuration">configuration page</a>.
        </p>
        <?php } ?>
        <input type="hidden" name="wpfp-lg-widget-submit" value="1" />
    <?php
    }
    wp_register_sidebar_widget('wpfp-lostgrad_favorited_posts', 'Lostgrad Favorited Posts', 'wpfp_lostgrad_widget_view');
    wp_register_widget_control('wpfp-lostgrad_favorited_posts', 'Lostgrad Favorited Posts', 'wpfp_lostgrad_widget_control' );
	
    /*************************
     *  Lostgrad TABBED favorites shortcode
    *************************/
    //shortcode used on homepage to display featured posts (admins favourites)
    function wpfp_lostgrad_favourites($args) {

		$slug=$args['slug'];
		$username=$args['user'];
                if($username=="me"){
                      global $bp;
                    $username=$bp->displayed_user->fullname;
                }
    	$favorite_post_ids = wpfp_get_users_favorites($username);
        
    	include("templates/tab_favourites.php");
    }
    add_shortcode('profile_favourites','wpfp_lostgrad_favourites');
    
    
    ///////////utility functions
    
    function in_array_r($needle, $haystack, $strict = false) {
    	foreach ($haystack as $item) {
    		if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
    			return true;
    		}
    	}
    
    	return false;
    }
    
function array_search_2d($needle, $haystack){
    foreach($haystack as $k => $h){ 
        $key = array_search($needle, $h);
        if($key !== false){
echo "__";
            return  $h;
            
        }
    }
    return false;
}

function get_the_image($post_id){
	$post_type=get_post_type( $post_id );

if($post_type=='course')
{
	$course_tree=display_taxonomy_tree('subject', 'uni');	
	return $image=$course_tree->get_post_image($group_parent_id, $post_id);
}
elseif ($post_type=='graduate-job')
{
	$job_tree=display_taxonomy_tree('profession', 'company');
	return $image=$job_tree->get_post_image($group_parent_id, $post_id);
}
elseif ($post_type=='work-experience-job')
{
	$job_tree=display_taxonomy_tree('profession', 'company');
	return $image=$job_tree->get_post_image($group_parent_id, $post_id);
}
elseif($post_type=='travel-opportunities'){
	$travel_tree=display_taxonomy_tree('location', 'location');
	return $image=$travel_tree->get_post_image($group_parent_id, $post_id);

}
elseif($post_type=='inspire-posts'){
          $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id), 'single-post-thumbnail' );
          return $image[0];
}
elseif($post_type=="post")
{
    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id), 'single-post-thumbnail' );
    
    return $image[0];
}

}

function wpfp_get_post_title($slug){

	if ($slug=='course'){
		return '<i class="fa fa-book fa-2x"></i> Learn';
	}
	elseif ($slug=='graduate-job')
		return '<i class="fa fa-bullseye fa-2x"></i> Work';
		
	elseif ($slug=='work-experience-job')
		return '<i class="fa fa-gears fa-2x"></i> Experience';
		
	elseif ($slug=='travel-opportunities')
		return '<i class="fa fa-plane fa-2x"></i> Travel';
        
        elseif ($slug=='post')
		return '<i class="fa fa-smile-o fa-2x"></i> Posts';
	
         elseif ($slug=='inspire-posts')
		return '<i class="fa fa-lightbulb-o fa-2x"></i>&nbsp; Inspire';
	

}

function wpfp_get_order($slug){
	if ($slug=='course'){
	return "a";
}
elseif ($slug=='graduate-job')
return "c";

elseif ($slug=='work-experience-job')
return "d";

elseif ($slug=='travel-opportunities')
return "b";

elseif ($slug=='inspire-posts')
return "e";

elseif ($slug=='post')
return "f";
}

function wpfp_limit_post_title($title){
$the_excerpt = $title; //Gets post_content to be used as a basis for the excerpt
$excerpt_length = 4; //Sets excerpt length by word count
$the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images
$words = explode(' ', $the_excerpt, $excerpt_length + 1);
if(count($words) > $excerpt_length) :
array_pop($words);
array_push($words, '…');
$the_excerpt = implode(' ', $words);
endif;
return $the_excerpt;
}

// function compareElems($elem1, $elem2) {
//     return strcmp($elem1[0], $elem2[0]);
// }

/////////////////////////////
?>
