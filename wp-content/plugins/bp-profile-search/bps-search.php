<?php

add_action ('wp_loaded', 'bps_set_cookie');
function bps_set_cookie ()
{
	global $bps_args;

	if (isset ($_POST['bp_profile_search']))
	{
		$bps_args = $_POST;
		add_action ('bp_before_directory_members_content', 'bps_your_search');
		setcookie ('bp-profile-search', serialize ($_POST), 0, COOKIEPATH);
	}
	else if (isset ($_COOKIE['bp-profile-search']))
	{
		if (defined ('DOING_AJAX'))
			$bps_args = unserialize (stripslashes ($_COOKIE['bp-profile-search']));
	}
}

add_action ('wp', 'bps_del_cookie');
function bps_del_cookie ()
{
	if (isset ($_POST['bp_profile_search']))  return false;

	if (isset ($_COOKIE['bp-profile-search']))
	{
		if (is_page (bp_get_members_root_slug ()))
			setcookie ('bp-profile-search', '', 0, COOKIEPATH);
	}
}

function bps_minmax ($posted, $index, $type)
{
	$min = (isset ($posted[$index]) && is_numeric (trim ($posted[$index])))? trim ($posted[$index]): '';
	$max = (isset ($posted[$index. '_max']) && is_numeric (trim ($posted[$index. '_max'])))? trim ($posted[$index. '_max']): '';

	if ($type == 'datebox')
	{
		if (is_numeric ($min))  $min = (int)$min;
		if (is_numeric ($max))  $max = (int)$max;
	}

	return array ($min, $max);
}

function bps_search ($posted)
{
	global $bp, $wpdb;
	global $bps_options;

	$emptyform = true;
	$results = array ('users' => array (0), 'validated' => true);

	foreach ($bps_options['field_name'] as $k => $id)
	{
		$field = new BP_XProfile_Field ($id);
		if (empty ($field->id))  continue;

		$fname = 'field_'. $id;
		$range = isset ($bps_options['field_range'][$k]);
		$sql = "SELECT DISTINCT user_id FROM {$bp->profile->table_name_data}";

		if ($range)
		{
			list ($min, $max) = bps_minmax ($posted, $fname, $field->type);
			if ($min === '' && $max === '')  continue;

			switch ($field->type)
			{
			case 'textbox':
			case 'textarea':
			case 'selectbox':
			case 'radio':
				$sql .= $wpdb->prepare (" WHERE field_id = %d", $id);
				if ($min !== '')  $sql .= $wpdb->prepare (" AND value >= %f", $min);
				if ($max !== '')  $sql .= $wpdb->prepare (" AND value <= %f", $max);
				break;

			case 'multiselectbox':
			case 'checkbox':
				continue 2;
				break;

			case 'datebox':
				$time = time ();
				$day = date ("j", $time);
				$month = date ("n", $time);
				$year = date ("Y", $time);
				$ymin = $year - $max - 1;
				$ymax = $year - $min;

				$sql .= $wpdb->prepare (" WHERE field_id = %d", $id);
				if ($max !== '')  $sql .= $wpdb->prepare (" AND DATE(value) > %s", "$ymin-$month-$day");
				if ($min !== '')  $sql .= $wpdb->prepare (" AND DATE(value) <= %s", "$ymax-$month-$day");
				break;
			}
		}
		else
		{
			if (empty ($posted[$fname]))  continue;

			switch ($field->type)
			{
			case 'textbox':
			case 'textarea':
				$value = $posted[$fname];
				$escaped = '%'. esc_sql (like_escape ($posted[$fname])). '%';
				if ($bps_options['searchmode'] == 'Partial Match')
					$sql .= $wpdb->prepare (" WHERE field_id = %d AND value LIKE %s", $id, $escaped);
				else					
					$sql .= $wpdb->prepare (" WHERE field_id = %d AND value = %s", $id, $value);
				break;

			case 'selectbox':
			case 'radio':
				$value = $posted[$fname];
				$sql .= $wpdb->prepare (" WHERE field_id = %d AND value = %s", $id, $value);
				break;

			case 'multiselectbox':
			case 'checkbox':
				$values = $posted[$fname];
				$sql .= $wpdb->prepare (" WHERE field_id = %d", $id);
				$like = array ();
				foreach ($values as $value)
				{
					$escaped = '%"'. esc_sql (like_escape ($value)). '"%';
					$like[] = $wpdb->prepare ("value = %s OR value LIKE %s", $value, $escaped);
				}	
				$sql .= ' AND ('. implode (' OR ', $like). ')';	
				break;

			case 'datebox':
				continue 2;
				break;
			}
		}

		$sql = apply_filters ('bps_field_query', $sql);
		$found = $wpdb->get_col ($sql);
		if (!isset ($users)) 
			$users = $found;
		else
			$users = array_intersect ($users, $found);

		$emptyform = false;
		if (count ($users) == 0)  return $results;
	}

	if ($emptyform == true)
	{
		$results['validated'] = false;
		return $results;
	}

	$results['users'] = $users;
	return $results;
}

add_action ('bp_before_members_loop', 'bps_add_filter');
add_action ('bp_after_members_loop', 'bps_remove_filter');
function bps_add_filter ()
{
	add_filter ('bp_pre_user_query_construct', 'bps_user_query');
}
function bps_remove_filter ()
{
	remove_filter ('bp_pre_user_query_construct', 'bps_user_query');
}

function bps_user_query ($query)
{
	global $bps_args;

	if (!isset ($bps_args))  return $query;

	$bps_results = bps_search ($bps_args);
	if ($bps_results['validated'])
	{
		$users = $bps_results['users'];

		if ($query->query_vars['include'] !== false)
		{
			$included = $query->query_vars['include'];
			if (!is_array ($included))
				$included = explode (',', $included);

			$users = array_intersect ($users, $included);
			if (count ($users) == 0)  $users = array (0);
		}

		$query->query_vars['include'] = $users;
	}

	return $query;
}

add_shortcode ('bp_profile_search_form', 'bps_shortcode');
function bps_shortcode ($attr, $content)
{
	ob_start ();
	bps_display_form (0, 'bps_shortcode');
	return ob_get_clean ();
}

class bps_widget extends WP_Widget
{
	function bps_widget ()
	{
		$widget_ops = array ('description' => __('Your Profile Search form.', 'bps'));
		$this->WP_Widget ('bp_profile_search', __('Profile Search', 'bps'), $widget_ops);
	}

	function widget ($args, $instance)
	{
		extract ($args);
		$title = apply_filters ('widget_title', $instance['title']);
	
		echo $before_widget;
		if ($title)
			echo $before_title. $title. $after_title;
		bps_display_form (0, 'bps_widget');
		echo $after_widget;
	}

	function update ($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		return $instance;
	}

	function form ($instance)
	{
		$title = $instance['title'];
?>
<p>
	<label for="<?php echo $this->get_field_id ('title'); ?>"><?php _e('Title:', 'bps'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id ('title'); ?>" name="<?php echo $this->get_field_name ('title'); ?>" type="text" value="<?php echo esc_attr ($title); ?>" />
</p>
<?php
	}
}

add_action ('widgets_init', 'bps_widget_init');
function bps_widget_init ()
{
	register_widget ('bps_widget');
}
?>
