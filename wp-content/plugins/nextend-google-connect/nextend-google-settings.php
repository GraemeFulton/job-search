<?php
/*
Nextend Twitter Connect Settings Page
*/

$newfb_status = "normal";

if(isset($_POST['newgoogle_update_options'])) {
	if($_POST['newgoogle_update_options'] == 'Y') {
    foreach($_POST AS $k => $v){
      $_POST[$k] = stripslashes($v);
    }
		update_option("nextend_google_connect", maybe_serialize($_POST));
		$newgoogle_status = 'update_success';
	}
}

if(!class_exists('NextendGoogleSettings')) {
class NextendGoogleSettings {
function NextendGoogle_Options_Page() {
  $domain = get_option('siteurl');
  $domain = str_replace(array('http://', 'https://'), array('',''), $domain);
  $domain = str_replace('www.', '', $domain);
  $a = explode("/",$domain);
  $domain = $a[0]; 
	?>

	<div class="wrap">
	<div id="newgoogle-options">
	<div id="newgoogle-title"><h2>Nextend Google Connect Settings</h2></div>
	<?php
	global $newgoogle_status;
	if($newgoogle_status == 'update_success')
		$message =__('Configuration updated', 'nextend-google-connect') . "<br />";
	else if($newgoogle_status == 'update_failed')
		$message =__('Error while saving options', 'nextend-google-connect') . "<br />";
	else
		$message = '';

	if($message != "") {
	?>
		<div class="updated"><strong><p><?php
		echo $message;
		?></p></strong></div><?php
	} ?>
	<div id="newgoogle-desc">
	<p><?php _e('This plugins helps you create Google login and register buttons. The login and register process only takes one click and you can fully customize the buttons with images and other assets.', 'nextend-google-connect'); ?></p>
	<h3><?php _e('Setup', 'nextend-google-connect'); ?></h3>
  <p>
  <?php _e('<ol><li><a href="https://www.google.com/accounts/ManageDomains" target="_blank">Add your domain to Google system!</a></li>', 'nextend-google-connect'); ?>
  <?php _e('<li>The bottom of the page will contain a link to your domain. Click on it and follow Google\'s veryfication steps.</li>', 'nextend-google-connect'); ?>
  <?php _e('<li>After you are done, <a href="https://code.google.com/apis/console" target="_blank">We have to create and API access.</a></li>', 'nextend-google-connect'); ?>
  <?php _e('<li>Create a new API access with your product name.<br><img src="http://www.nextendweb.com/wp-content/uploads/2012/10/googleapi11.png" /></li>', 'nextend-google-connect'); ?>
  <?php _e('<li>Search for the Google+ API row and enable the service</li>', 'nextend-google-connect'); ?>
  <?php _e('<li>Then click on the API access panel and create and OAuth 2 clien ID!<br><img src="http://www.nextendweb.com/wp-content/uploads/2012/10/googleapi21.png" /></li>', 'nextend-google-connect'); ?>
  <?php _e('<li>Product name can be anything then click on next.</li>', 'nextend-google-connect'); ?>
  <?php _e('<li>Click on the <b>more options</b> link and copy and paste <b>'.new_google_login_url().'</b> to the textarea.<br><img src="http://www.nextendweb.com/wp-content/uploads/2012/10/googleapi31.png" /></li>', 'nextend-google-connect'); ?>
  <?php _e('<li>Now you should use the values in the fields below.<br><img src="http://www.nextendweb.com/wp-content/uploads/2012/10/googleapi4.png" /></li>', 'nextend-google-connect'); ?>
  <?php _e('<li><b>Save changes!</b></li></ol>', 'nextend-google-connect'); ?>
  
  
  </p>
  <h3><?php _e('Usage', 'nextend-google-connect'); ?></h3>
  <h4><?php _e('Simple link', 'nextend-google-connect'); ?></h4>
	<p><?php _e('&lt;a href="'.new_google_login_url().'&redirect='.get_option('siteurl').'" onclick="window.location = \''.new_google_login_url().'&redirect=\'+window.location.href; return false;"&gt;Click here to login or register with google&lt;/a&gt;', 'nextend-google-connect'); ?></p>
	
  <h4><?php _e('Image button', 'nextend-google-connect'); ?></h4>
	<p><?php _e('&lt;a href="'.new_google_login_url().'&redirect='.get_option('siteurl').'" onclick="window.location = \''.new_google_login_url().'&redirect=\'+window.location.href; return false;"&gt; &lt;img src="HereComeTheImage" /&gt; &lt;/a&gt;', 'nextend-google-connect'); ?></p>
  
  <h3><?php _e('Note', 'nextend-google-connect'); ?></h3>
  <p><?php _e('If the google user\'s email address already used by another member of your site, the google profile will be automatically linked to the existing profile!', 'nextend-google-connect'); ?></p>
  
  </div>

	<!--right-->
	<div class="postbox-container" style="float:right;width:30%;">
	<div class="metabox-holder">
	<div class="meta-box-sortables">

	<!--about-->
	<div id="newgoogle-about" class="postbox">
	<h3 class="hndle"><?php _e('About this plugin', 'nextend-google-connect'); ?></h3>
	<div class="inside"><ul>
  
  <li><a href="http://www.nextendweb.com/social-connect-plugins-for-wordpress.html" target="_blank"><?php _e('Check the realted <b>blog post</b>!', 'nextend-google-connect'); ?></a></li>
	<li><br></li>
	<li><a href="http://wordpress.org/extend/plugins/nextend-google-connect/" target="_blank"><?php _e('Nextend Google Connect', 'nextend-google-connect'); ?></a></li>
	<li><br></li>
  <li><a href="http://profiles.wordpress.org/nextendweb" target="_blank"><?php _e('Nextend  plugins at WordPress.org', 'nextend-google-connect'); ?></a></li>
	</ul></div>
	</div>
	<!--about end-->

	<!--others-->
	<!--others end-->

	</div></div></div>
	<!--right end-->

	<!--left-->
	<div class="postbox-container" style="float:left;width: 69%;">
	<div class="metabox-holder">
	<div class="meta-box-sortabless">

	<!--setting-->
	<div id="newgoogle-setting" class="postbox">
	<h3 class="hndle"><?php _e('Settings', 'nextend-google-connect'); ?></h3>
	<?php $nextend_google_connect = maybe_unserialize(get_option('nextend_google_connect')); ?>

	<form method="post" action="<?php echo get_bloginfo("wpurl"); ?>/wp-admin/options-general.php?page=nextend-google-connect">
	<input type="hidden" name="newgoogle_update_options" value="Y">

	<table class="form-table">
		<tr>
		<th scope="row"><?php _e('Google Client ID:', 'nextend-google-connect'); ?></th>
		<td>
		<input type="text" name="google_client_id" value="<?php echo $nextend_google_connect['google_client_id']; ?>" />
		</td>
		</tr>

		<tr>
		<th scope="row"><?php _e('Google Client Secret:', 'nextend-google-connect'); ?></th>
		<td>
		<input type="text" name="google_client_secret" value="<?php echo $nextend_google_connect['google_client_secret']; ?>" />
		</td>
		</tr>
    
    <tr>
		<th scope="row"><?php _e('Google API key:', 'nextend-google-connect'); ?></th>
		<td>
		<input type="text" name="google_api_key" value="<?php echo $nextend_google_connect['google_api_key']; ?>" />
		</td>
		</tr>

		<tr>
		<th scope="row"><?php _e('New user prefix:', 'nextend-google-connect'); ?></th>
		<td>
    <?php if(!isset($nextend_google_connect['google_user_prefix'])) $nextend_google_connect['google_user_prefix'] = 'Google - '; ?>
		<input type="text" name="google_user_prefix" value="<?php echo $nextend_google_connect['google_user_prefix']; ?>" />
		</td>
		</tr>

		<tr>
		<th scope="row"><?php _e('New user prefix:', 'nextend-google-connect'); ?></th>
		<td>
    <?php if(!isset($nextend_google_connect['google_user_prefix'])) $nextend_google_connect['google_user_prefix'] = 'Facebook - '; ?>
		<input type="text" name="google_user_prefix" value="<?php echo $nextend_google_connect['google_user_prefix']; ?>" />
		</td>
		</tr>

		<tr>
		<th scope="row"><?php _e('Fixed redirect url for login:', 'nextend-google-connect'); ?></th>
		<td>
    <?php if(!isset($nextend_google_connect['google_redirect'])) $nextend_google_connect['google_redirect'] = 'auto'; ?>
		<input type="text" name="google_redirect" value="<?php echo $nextend_google_connect['google_redirect']; ?>" />
		</td>
		</tr>

		<tr>
		<th scope="row"><?php _e('Fixed redirect url for register:', 'nextend-google-connect'); ?></th>
		<td>
    <?php if(!isset($nextend_google_connect['google_redirect_reg'])) $nextend_google_connect['google_redirect_reg'] = 'auto'; ?>
		<input type="text" name="google_redirect_reg" value="<?php echo $nextend_google_connect['google_redirect_reg']; ?>" />
		</td>
		</tr>

		<tr>
		<th scope="row"><?php _e('Load button stylesheet:', 'nextend-google-connect'); ?></th>
		<td>
    <?php if(!isset($nextend_google_connect['google_load_style'])) $nextend_google_connect['google_load_style'] = 1; ?>
		<input name="google_load_style" id="google_load_style_yes" value="1" type="radio" <?php if(isset($nextend_google_connect['google_load_style']) && $nextend_google_connect['google_load_style']){?> checked <?php } ?>> Yes  &nbsp;&nbsp;&nbsp;&nbsp;
    <input name="google_load_style" id="google_load_style_no" value="0" type="radio" <?php if(isset($nextend_google_connect['google_load_style']) && $nextend_google_connect['google_load_style'] == 0){?> checked <?php } ?>> No		
		</td>
		</tr>
    
    <tr>
		<th scope="row"><?php _e('Login button:', 'nextend-google-connect'); ?></th>
		<td>
      <?php if(!isset($nextend_google_connect['google_login_button'])) $nextend_google_connect['google_login_button'] = '<div class="new-google-btn new-google-1 new-google-default-anim"><div class="new-google-1-1"><div class="new-google-1-1-1">CONNECT WITH</div></div></div>'; ?>
		  <textarea cols="83" rows="3" name="google_login_button"><?php echo $nextend_google_connect['google_login_button']; ?></textarea>
		</td>
		</tr>
    
    <tr>
		<th scope="row"><?php _e('Link account button:', 'nextend-google-connect'); ?></th>
		<td>
      <?php if(!isset($nextend_google_connect['google_link_button'])) $nextend_google_connect['google_link_button'] = '<div class="new-google-btn new-google-1 new-google-default-anim"><div class="new-google-1-1"><div class="new-google-1-1-1">LINK ACCOUNT TO</div></div></div>'; ?>
		  <textarea cols="83" rows="3" name="google_link_button"><?php echo $nextend_google_connect['google_link_button']; ?></textarea>
		</td>
		</tr>
    
    <tr>
		<th scope="row"><?php _e('Unlink account button:', 'nextend-google-connect'); ?></th>
		<td>
      <?php if(!isset($nextend_google_connect['google_unlink_button'])) $nextend_google_connect['google_unlink_button'] = '<div class="new-google-btn new-google-1 new-google-default-anim"><div class="new-google-1-1"><div class="new-google-1-1-1">UNLINK ACCOUNT</div></div></div>'; ?>
		  <textarea cols="83" rows="3" name="google_unlink_button"><?php echo $nextend_google_connect['google_unlink_button']; ?></textarea>
		</td>
		</tr>
    
    <tr>
		<th scope="row"></th>
		<td>
    <a href="http://www.nextendweb.com/social-connect-button-generator" target="_blank"><img style="margin-left: -4px;" src="<?php echo plugins_url('generatorbanner.png', __FILE__); ?>" /></a>
    </td>
		</tr>
	</table>

	<p class="submit">
	<input style="margin-left: 10%;" type="submit" name="Submit" value="<?php _e('Save Changes', 'nextend-google-connect'); ?>" />
	</p>
	</form>
	</div>
	<!--setting end-->

	<!--others-->
	<!--others end-->

	</div></div></div>
	<!--left end-->

	</div>
	</div>
	<?php
}

function NextendGoogle_Menu() {
	add_options_page(__('Nextend Google Connect'), __('Nextend Google Connect'), 'manage_options', 'nextend-google-connect', array(__CLASS__,'NextendGoogle_Options_Page'));
}

}
}
?>
