<?php
/*
Plugin Name: BP Profile Search
Plugin URI: http://www.dontdream.it/bp-profile-search/
Description: Search your BuddyPress Members Directory.
Version: 3.6
Author: Andrea Tarantini
Author URI: http://www.dontdream.it/
*/

include 'bps-functions.php';

add_action ('plugins_loaded', 'bps_translate');
function bps_translate ()
{
	load_plugin_textdomain ('bps', false, basename (dirname (__FILE__)). '/languages');
}

register_activation_hook (__FILE__, 'bps_activate');
function bps_activate ()
{
	global $bps_options;

	bps_init ();
	if (isset ($bps_options['version']) && version_compare ($bps_options['version'], '3.6', 'ge'))  return true;

	bps_init_form ();
	bps_active_for_network ()? update_site_option ('bps_options', $bps_options): update_option ('bps_options', $bps_options);

	return true;
}

add_action ('init', 'bps_init');
function bps_init ()
{
	global $bps_options;

	$bps_options = bps_active_for_network ()? get_site_option ('bps_options'): get_option ('bps_options');
	if ($bps_options == false)
	{
		bps_init_form ();
	}	

	return true;
}

function bps_active_for_network ()
{
	include_once ABSPATH. '/wp-admin/includes/plugin.php';
	return is_plugin_active_for_network ('bp-profile-search/bps-main.php');
}

function bps_admin_url ($tab=false)
{
	$page = 'users.php?page=bp-profile-search';
	if ($tab)  $page .= '&tab='. $tab;

	$url = bps_active_for_network ()? network_admin_url ($page): admin_url ($page);
	return $url;
}

add_action (bps_active_for_network ()? 'network_admin_menu': 'admin_menu', 'bps_add_pages', 20);
function bps_add_pages ()
{
	$page = add_submenu_page ('users.php', __('Profile Search', 'bps'), __('Profile Search', 'bps'), 'manage_options', 'bp-profile-search', 'bps_admin');
	add_action ('load-'. $page, 'bps_help');
	add_action ('load-'. $page, 'bps_admin_js');

	return true;
}

add_filter (bps_active_for_network ()? 'network_admin_plugin_action_links': 'plugin_action_links', 'bps_row_meta', 10, 2);
function bps_row_meta ($links, $file)
{
	if ($file == plugin_basename (__FILE__))
	{
		$settings_link = '<a href="'. bps_admin_url (). '">'. __('Settings', 'buddypress'). '</a>';
		array_unshift ($links, $settings_link);
	}
	return $links;
}

function bps_init_form ()
{
	global $bps_options;

	$bps_options = array ();
	$bps_options['version'] = '3.6';
	$bps_options['field_name'] = array ();
	$bps_options['field_label'] = array ();
	$bps_options['field_desc'] = array ();
	$bps_options['field_range'] = array ();
	$bps_options['directory'] = 'No';
	$bps_options['header'] = __('<h4>Advanced Search</h4>', 'bps');
	$bps_options['show'] = array ('Enabled');
	$bps_options['message'] = __('Toggle Form', 'bps');
	$bps_options['searchmode'] = 'Partial Match';

	return true;
}

function bps_admin ()
{
	$tabs = array ('main' => __('Form Configuration', 'bps'), 'options' => __('Advanced Options', 'bps'));
	$tab = (isset ($_GET['tab']) && isset ($tabs[$_GET['tab']]))? $_GET['tab']: 'main';
?>

<div class="wrap">
  <h2><?php _e('Profile Search', 'bps'); ?></h2>

  <ul class="subsubsub">
<?php
	foreach ($tabs as $action => $text)
	{
		$sep = (end ($tabs) != $text)? ' | ' : '';
		$class = ($action == $tab)? ' class="current"' : '';
		$href = bps_admin_url ($action);
		echo "\t\t<li><a href='$href'$class>$text</a>$sep</li>\n";
	}
?>
  </ul>
  <br class="clear" />

<?php
	$function = 'bps_admin_'. $tab;
	$function ();
?>
</div>
<?php
	global $wpdb;
}

function bps_admin_main ()
{
	global $bps_options;

	if (isset ($_POST['action']) && $_POST['action'] == 'update')
	{
		bps_update_fields ();
		$message = bps_update_form (array ('directory', 'header', 'message'), array ('show'));
	}	
?>

<?php if (isset ($message)) : ?>
  <div id="message" class="updated fade"><p><?php echo $message; ?></p></div>
<?php endif; ?>

  <form method="post" action="<?php echo bps_admin_url ('main'); ?>">
	<?php wp_nonce_field ('bps_admin_main'); ?>
	<input type="hidden" name="action" value="update" />

	<h3><?php _e('Form Fields', 'bps'); ?></h3>

	<p>
	<?php _e('Select the profile fields to show in your search form.', 'bps'); ?>
	<?php _e('Click the <em>Help</em> tab for more information.', 'bps'); ?>
	</p>

	<table class="form-table">
	<tr valign="top"><th scope="row"><?php _e('Form Fields:', 'bps'); ?></th><td>
		<?php bps_form_fields (); ?>
	</td></tr>
	</table>

	<h3><?php _e('Add to Directory', 'bps'); ?></h3>

	<p><?php _e('Insert your search form in your Members Directory page.', 'bps'); ?></p>

	<table class="form-table">
	<tr valign="top"><th scope="row"><?php _e('Add to Directory:', 'bps'); ?></th><td>
	<fieldset>
		<label><input type="radio" name="bps_options[directory]" value="Yes"<?php if ('Yes' == $bps_options['directory']) echo ' checked="checked"'; ?> /> <span><?php _e('Yes', 'bps'); ?></span></label><br />
		<label><input type="radio" name="bps_options[directory]" value="No"<?php if ('No' == $bps_options['directory']) echo ' checked="checked"'; ?> /> <span><?php _e('No', 'bps'); ?></span></label><br />
	</fieldset>
	</td></tr>
	<tr valign="top"><th scope="row"><?php _e('Form Header:', 'bps'); ?></th><td>
		<textarea name="bps_options[header]" class="large-text code" rows="4"><?php echo $bps_options['header']; ?></textarea>
	</td></tr>
	<tr valign="top"><th scope="row"><?php _e('Toggle Form:', 'bps'); ?></th><td>
		<label><input type="checkbox" name="bps_options[show][]" value="Enabled"<?php if (in_array ('Enabled', $bps_options['show'])) echo ' checked="checked"'; ?> /> <?php _e('Enabled', 'bps'); ?></label><br />
	</td></tr>
	<tr valign="top"><th scope="row"><?php _e('Toggle Form Button:', 'bps'); ?></th><td>
		<input type="text" name="bps_options[message]" value="<?php echo $bps_options['message']; ?>"  />
	</td></tr>
	</table>

	<p class="submit">
	  <input type="submit" class="button-primary" value="<?php _e('Save Settings', 'bps'); ?>" />
	</p>
  </form>

<?php
}

function bps_admin_options ()
{
	global $bps_options;

	if (isset ($_POST['action']) && $_POST['action'] == 'update')
		$message = bps_update_form (array ('searchmode'), array ());
?>

<?php if (isset ($message)) : ?>
  <div id="message" class="updated fade"><p><?php echo $message; ?></p></div>
<?php endif; ?>

  <form method="post" action="<?php echo bps_admin_url ('options'); ?>">
	<?php wp_nonce_field ('bps_admin_options'); ?>
	<input type="hidden" name="action" value="update" />
	
	<h3><?php _e('Text Search Mode', 'bps'); ?></h3>

	<p>
	<?php _e('Select your text search mode.', 'bps'); ?>
	<?php _e('Click the <em>Help</em> tab for more information.', 'bps'); ?>
	</p>

	<table class="form-table">
	<tr valign="top"><th scope="row"><?php _e('Text Search Mode:', 'bps'); ?></th><td>
	<fieldset>
		<label><input type="radio" name="bps_options[searchmode]" value="Partial Match"<?php if ('Partial Match' == $bps_options['searchmode']) echo ' checked="checked"'; ?> /> <span><?php _e('Partial Match', 'bps'); ?></span></label><br />
		<label><input type="radio" name="bps_options[searchmode]" value="Exact Match"<?php if ('Exact Match' == $bps_options['searchmode']) echo ' checked="checked"'; ?> /> <span><?php _e('Exact Match', 'bps'); ?></span></label><br />
	</fieldset>
	</td></tr>
	</table>

	<p class="submit">
	  <input type="submit" class="button-primary" value="<?php _e('Save Settings', 'bps'); ?>" />
	</p>
  </form>

<?php
}

function bps_update_form ($vars, $arrays)
{
	global $bps_options;

	foreach ($vars as $var)
		$bps_options[$var] = stripslashes ($_POST['bps_options'][$var]);

	foreach ($arrays as $array)
		if (isset ($_POST['bps_options'][$array]))
			$bps_options[$array] = stripslashes_deep ($_POST['bps_options'][$array]);
		else
			$bps_options[$array] = array ();

	bps_active_for_network ()? update_site_option ('bps_options', $bps_options): update_option ('bps_options', $bps_options);

	return __('Settings saved.', 'bps');
}
?>
