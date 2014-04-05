<?php

add_action ('bp_before_directory_members_tabs', 'bps_add_form');
function bps_add_form ()
{
	global $bps_options;

	if ($bps_options['directory'] == 'Yes')  bps_display_form (0, 'bps_auto');
}

add_action ('bp_profile_search_form', 'bps_display_form');
function bps_display_form ($name, $tag='bps_action')
{
	global $bps_options;

	if (empty ($bps_options['field_name']))
	{
		printf ('<p class="bps_error">'. __('%s: Error, you have not configured your search form.', 'bps'). '</p>',
			"<strong>BP Profile Search $bps_options[version]</strong>");
		return false;
	}

	$action = bp_get_root_domain (). '/'. bp_get_members_root_slug (). '/';

echo "\n<!-- BP Profile Search $bps_options[version] - start -->\n";
if ($tag != 'bps_auto')  echo "<div id='buddypress'>";

	if ($tag == 'bps_auto')
	{
?>	
	<div class="item-list-tabs">
	<ul>
	<li><?php echo $bps_options['header']; ?></li>
<?php if (in_array ('Enabled', $bps_options['show'])) { ?>
	<li class="last">
	<input id="bps_show" type="submit" value="<?php echo $bps_options['message']; ?>" />
	</li>
<?php } ?>
	</ul>
<?php if (in_array ('Enabled', $bps_options['show'])) { ?>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('#<?php echo $tag; ?>').hide();
		$('#bps_show').click(function(){
			$('#<?php echo $tag; ?>').toggle();
		});
	});
</script>
<?php } ?>
	</div>
<?php
	}

echo "<form action='$action' method='post' id='$tag' class='standard-form'>";

	$j = 0;
	foreach ($bps_options['field_name'] as $k => $id)
	{
		$field = new BP_XProfile_Field ($id);
		if (empty ($field->id))  continue;

		$label = $bps_options['field_label'][$k];
		$desc = $bps_options['field_desc'][$k];
		$range = isset ($bps_options['field_range'][$k]);

		$fname = 'field_'. $id;
		$name = sanitize_title ($field->name);
		$alt = ($j++ % 2)? ' alt': '';

echo "<div class='editfield field_$id field_$name$alt'>";

		if ($range)
		{
			list ($min, $max) = bps_minmax ($_POST, $fname, $field->type);

echo "<label for='$fname'>$label</label>";
echo "<input style='width: 10%;' type='text' name='$fname' id='$fname' value='$min' />";
echo '&nbsp;-&nbsp;';
echo "<input style='width: 10%;' type='text' name='{$fname}_max' value='$max' />";
		}
		else switch ($field->type)
		{
		case 'textbox':
			$posted = isset ($_POST[$fname])? $_POST[$fname]: '';
			$value = esc_attr (stripslashes ($posted));
echo "<label for='$fname'>$label</label>";
echo "<input type='text' name='$fname' id='$fname' value='$value' />";
			break;

		case 'textarea':
			$posted = isset ($_POST[$fname])? $_POST[$fname]: '';
			$value = esc_textarea (stripslashes ($posted));
echo "<label for='$fname'>$label</label>";
echo "<textarea rows='5' cols='40' name='$fname' id='$fname'>$value</textarea>";
			break;

		case 'selectbox':
echo "<label for='$fname'>$label</label>";
echo "<select name='$fname' id='$fname'>";
echo "<option value=''></option>";

			$posted = isset ($_POST[$fname])? $_POST[$fname]: '';
			$options = $field->get_children ();
			foreach ($options as $option)
			{
				$option->name = trim ($option->name);
				$value = esc_attr (stripslashes ($option->name));
				$selected = ($option->name == $posted)? "selected='selected'": "";
echo "<option $selected value='$value'>$value</option>";
			}
echo "</select>";
			break;

		case 'multiselectbox':
echo "<label for='$fname'>$label</label>";
echo "<select name='{$fname}[]' id='$fname' multiple='multiple'>";

			$posted = isset ($_POST[$fname])? $_POST[$fname]: array ();
			$options = $field->get_children ();
			foreach ($options as $option)
			{
				$option->name = trim ($option->name);
				$value = esc_attr (stripslashes ($option->name));
				$selected = (in_array ($option->name, $posted))? "selected='selected'": "";
echo "<option $selected value='$value'>$value</option>";
			}
echo "</select>";
			break;

		case 'radio':
echo "<div class='radio'>";
echo "<span class='label'>$label</span>";
echo "<div id='$fname'>";

			$posted = isset ($_POST[$fname])? $_POST[$fname]: '';
			$options = $field->get_children ();
			foreach ($options as $option)
			{
				$option->name = trim ($option->name);
				$value = esc_attr (stripslashes ($option->name));
				$selected = ($option->name == $posted)? "checked='checked'": "";
echo "<label><input $selected type='radio' name='$fname' value='$value'>$value</label>";
			}
echo '</div>';
echo "<a class='clear-value' href='javascript:clear(\"$fname\");'>". __('Clear', 'buddypress'). "</a>";
echo '</div>';
			break;

		case 'checkbox':
echo "<div class='checkbox'>";
echo "<span class='label'>$label</span>";

			$posted = isset ($_POST[$fname])? $_POST[$fname]: array ();
			$options = $field->get_children ();
			foreach ($options as $option)
			{
				$option->name = trim ($option->name);
				$value = esc_attr (stripslashes ($option->name));
				$selected = (in_array ($option->name, $posted))? "checked='checked'": "";
echo "<label><input $selected type='checkbox' name='{$fname}[]' value='$value'>$value</label>";
			}
echo '</div>';
			break;
		}

echo "<p class='description'>$desc</p>";
echo '</div>';
	}

echo "<div class='submit'>";
echo "<input type='submit' value='". __('Search', 'buddypress'). "' />";
echo '</div>';
echo "<input type='hidden' name='bp_profile_search' value='true' />";
echo '</form>';
if ($tag != 'bps_auto')  echo '</div>';
echo "\n<!-- BP Profile Search $bps_options[version] - end -->\n";

	return true;
}

function bps_your_search ()
{
	global $bps_options;

	$posted = $_POST;
	$action = bp_get_root_domain (). '/'. bp_get_members_root_slug (). '/';
	$emptyform = true;

echo '<p class="bps_filters">';

	foreach ($bps_options['field_name'] as $k => $id)
	{
		$field = new BP_XProfile_Field ($id);
		if (empty ($field->id))  continue;

		$fname = 'field_'. $id;
		$label = $bps_options['field_label'][$k];
		$range = isset ($bps_options['field_range'][$k]);

		if ($range)
		{
			list ($min, $max) = bps_minmax ($posted, $fname, $field->type);
			if ($min === '' && $max === '')  continue;

			$emptyform = false;
echo "<strong>$label:</strong>";
			if ($min !== '')
echo " <strong>". __('min', 'bps'). "</strong> $min";
			if ($max !== '')
echo " <strong>". __('max', 'bps'). "</strong> $max";
echo "<br/>";
		}
		else
		{
			if (empty ($posted[$fname]))  continue;

			$emptyform = false;
			switch ($field->type)
			{
			case 'textbox':
			case 'textarea':
			case 'selectbox':
			case 'radio':
				$value = esc_html (stripslashes ($posted[$fname]));
echo "<strong>$label:</strong> $value<br/>";
				break;

			case 'multiselectbox':
			case 'checkbox':
				$values = stripslashes_deep ($posted[$fname]);
echo "<strong>$label:</strong> ". esc_html (implode (', ', $values)). "<br/>";
				break;
			}
		}
	}

	if ($emptyform == false)
echo "<a href='$action'>". __('Clear', 'buddypress'). "</a><br/>";
echo '</p>';
	return true;
}
?>
