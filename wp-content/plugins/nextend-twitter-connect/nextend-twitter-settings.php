<?php
/*
Nextend Twitter Connect Settings Page
*/

$newtwitter_status = "normal";

if(isset($_POST['newtwitter_update_options'])) {
	if($_POST['newtwitter_update_options'] == 'Y') {
    foreach($_POST AS $k => $v){
      $_POST[$k] = stripslashes($v);
    }
		update_option("nextend_twitter_connect", maybe_serialize($_POST));
		$newtwitter_status = 'update_success';
	}
}

if(!class_exists('NextendTwitterSettings')) {
class NextendTwitterSettings {
function NextendTwitter_Options_Page() {
  $domain = get_option('siteurl');
  $domain = str_replace(array('http://', 'https://'), array('',''), $domain);
  $domain = str_replace('www.', '', $domain);
  $a = explode("/",$domain);
  $domain = $a[0]; 
	?>

	<div class="wrap">
	<div id="newtwitter-options">
	<div id="newtwitter-title"><h2>Nextend Twitter Connect Settings</h2></div>
	<?php
	global $newtwitter_status;
	if($newtwitter_status == 'update_success')
		$message =__('Configuration updated', 'nextend-twitter-connect') . "<br />";
	else if($newtwitter_status == 'update_failed')
		$message =__('Error while saving options', 'nextend-twitter-connect') . "<br />";
	else
		$message = '';

	if($message != "") {
	?>
		<div class="updated"><strong><p><?php
		echo $message;
		?></p></strong></div><?php
	} ?>
	<div id="newtwitter-desc">
	<p><?php _e('This plugins helps you create Twitter login and register buttons. The login and register process only takes one click and you can fully customize the buttons with images and other assets.', 'nextend-twitter-connect'); ?></p>
	<h3><?php _e('Setup', 'nextend-twitter-connect'); ?></h3>
  <p>
  <?php _e('<ol><li><a href="https://dev.twitter.com/apps/new" target="_blank">Create a twitter app!</a></li>', 'nextend-twitter-connect'); ?>
  <?php _e('<li>Choose an App Name, it can be anything you like. Fill out the description and your website home page: '.site_url().'</li>', 'nextend-twitter-connect'); ?>
  <?php _e('<li>Callback url must be: '.new_twitter_login_url().'</li>', 'nextend-twitter-connect'); ?>
  <?php _e('<li>Accept the rules and Click on <b>Create your twitter application</b></li>', 'nextend-twitter-connect'); ?>
  <?php _e('<li>The next page contains the <b>Consumer key</b> and <b>Consumer secret</b> which you have to copy and past below.</li>', 'nextend-twitter-connect'); ?>
  <?php _e('<li><b>Save changes!</b></li></ol>', 'nextend-twitter-connect'); ?>
  
  
  </p>
  <h3><?php _e('Usage', 'nextend-twitter-connect'); ?></h3>
  <h4><?php _e('Simple link', 'nextend-twitter-connect'); ?></h4>
	<p><?php _e('&lt;a href="'.new_twitter_login_url().'&redirect='.get_option('siteurl').'" onclick="window.location = \''.new_twitter_login_url().'&redirect=\'+window.location.href; return false;"&gt;Click here to login or register with twitter&lt;/a&gt;', 'nextend-twitter-connect'); ?></p>
	
  <h4><?php _e('Image button', 'nextend-twitter-connect'); ?></h4>
	<p><?php _e('&lt;a href="'.new_twitter_login_url().'&redirect='.get_option('siteurl').'" onclick="window.location = \''.new_twitter_login_url().'&redirect=\'+window.location.href; return false;"&gt; &lt;img src="HereComeTheImage" /&gt; &lt;/a&gt;', 'nextend-twitter-connect'); ?></p>
  
  <h3><?php _e('Note', 'nextend-twitter-connect'); ?></h3>
  <p><?php _e('If the twitter user\'s email address already used by another member of your site, the twitter profile will be automatically linked to the existing profile!', 'nextend-twitter-connect'); ?></p>
  
  </div>

	<!--right-->
	<div class="postbox-container" style="float:right;width:30%;">
	<div class="metabox-holder">
	<div class="meta-box-sortables">

	<!--about-->
	<div id="newtwitter-about" class="postbox">
	<h3 class="hndle"><?php _e('About this plugin', 'nextend-twitter-connect'); ?></h3>
	<div class="inside"><ul>
  <li><a href="http://www.nextendweb.com/social-connect-plugins-for-wordpress.html" target="_blank"><?php _e('Check the realted <b>blog post</b>!', 'nextend-google-connect'); ?></a></li>
  <li><br></li>
	<li><a href="http://wordpress.org/extend/plugins/nextend-twitter-connect/"><?php _e('Nextend Twitter Connect', 'nextend-twitter-connect'); ?></a></li>
  <li><br></li>
	<li><a href="http://profiles.wordpress.org/nextendweb" target="_blank"><?php _e('Nextend  plugins at WordPress.org', 'nextend-twitter-connect'); ?></a></li>
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
	<div id="newtwitter-setting" class="postbox">
	<h3 class="hndle"><?php _e('Settings', 'nextend-twitter-connect'); ?></h3>
	<?php $nextend_twitter_connect = maybe_unserialize(get_option('nextend_twitter_connect')); ?>

	<form method="post" action="<?php echo get_bloginfo("wpurl"); ?>/wp-admin/options-general.php?page=nextend-twitter-connect">
	<input type="hidden" name="newtwitter_update_options" value="Y">

	<table class="form-table">
		<tr>
		<th scope="row"><?php _e('Twitter Consumer key:', 'nextend-twitter-connect'); ?></th>
		<td>
		<input type="text" name="twitter_consumer_key" value="<?php echo $nextend_twitter_connect['twitter_consumer_key']; ?>" />
		</td>
		</tr>

		<tr>
		<th scope="row"><?php _e('Twitter Consumer secret:', 'nextend-twitter-connect'); ?></th>
		<td>
		<input type="text" name="twitter_consumer_secret" value="<?php echo $nextend_twitter_connect['twitter_consumer_secret']; ?>" />
		</td>
		</tr>

		<tr>
		<th scope="row"><?php _e('New user prefix:', 'nextend-twitter-connect'); ?></th>
		<td>
    <?php if(!isset($nextend_twitter_connect['twitter_user_prefix'])) $nextend_twitter_connect['twitter_user_prefix'] = 'twitter - '; ?>
		<input type="text" name="twitter_user_prefix" value="<?php echo $nextend_twitter_connect['twitter_user_prefix']; ?>" />
		</td>
		</tr>

		<tr>
		<th scope="row"><?php _e('Fixed redirect url for login:', 'nextend-twitter-connect'); ?></th>
		<td>
    <?php if(!isset($nextend_twitter_connect['twitter_redirect'])) $nextend_twitter_connect['twitter_redirect'] = 'auto'; ?>
		<input type="text" name="twitter_redirect" value="<?php echo $nextend_twitter_connect['twitter_redirect']; ?>" />
		</td>
		</tr>

		<tr>
		<th scope="row"><?php _e('Fixed redirect url for register:', 'nextend-twitter-connect'); ?></th>
		<td>
    <?php if(!isset($nextend_twitter_connect['twitter_redirect_reg'])) $nextend_twitter_connect['twitter_redirect_reg'] = 'auto'; ?>
		<input type="text" name="twitter_redirect_reg" value="<?php echo $nextend_twitter_connect['twitter_redirect_reg']; ?>" />
		</td>
		</tr>

		<tr>
		<th scope="row"><?php _e('Load button stylesheet:', 'nextend-twitter-connect'); ?></th>
		<td>
      <?php if(!isset($nextend_twitter_connect['twitter_load_style'])) $nextend_twitter_connect['twitter_load_style'] = 1; ?>
		<input name="twitter_load_style" id="twitter_load_style_yes" value="1" type="radio" <?php if(isset($nextend_twitter_connect['twitter_load_style']) && $nextend_twitter_connect['twitter_load_style']){?> checked <?php } ?>> Yes  &nbsp;&nbsp;&nbsp;&nbsp;
    <input name="twitter_load_style" id="twitter_load_style_no" value="0" type="radio" <?php if(isset($nextend_twitter_connect['twitter_load_style']) && $nextend_twitter_connect['twitter_load_style'] == 0){?> checked <?php } ?>> No		
		</td>
		</tr>
    
    <tr>
		<th scope="row"><?php _e('Login button:', 'nextend-twitter-connect'); ?></th>
		<td>
      <?php if(!isset($nextend_twitter_connect['twitter_login_button'])) $nextend_twitter_connect['twitter_login_button'] = '<div class="new-twitter-btn new-twitter-1 new-twitter-default-anim"><div class="new-twitter-1-1"><div class="new-twitter-1-1-1">CONNECT WITH</div></div></div>'; ?>
		  <textarea cols="83" rows="3" name="twitter_login_button"><?php echo $nextend_twitter_connect['twitter_login_button']; ?></textarea>
		</td>
		</tr>
    
    <tr>
		<th scope="row"><?php _e('Link account button:', 'nextend-twitter-connect'); ?></th>
		<td>
      <?php if(!isset($nextend_twitter_connect['twitter_link_button'])) $nextend_twitter_connect['twitter_link_button'] = '<div class="new-twitter-btn new-twitter-1 new-twitter-default-anim"><div class="new-twitter-1-1"><div class="new-twitter-1-1-1">LINK ACCOUNT TO</div></div></div>'; ?>
		  <textarea cols="83" rows="3" name="twitter_link_button"><?php echo $nextend_twitter_connect['twitter_link_button']; ?></textarea>
		</td>
		</tr>
    
    <tr>
		<th scope="row"><?php _e('Unlink account button:', 'nextend-twitter-connect'); ?></th>
		<td>
      <?php if(!isset($nextend_twitter_connect['twitter_unlink_button'])) $nextend_twitter_connect['twitter_unlink_button'] = '<div class="new-twitter-btn new-twitter-1 new-twitter-default-anim"><div class="new-twitter-1-1"><div class="new-twitter-1-1-1">UNLINK ACCOUNT</div></div></div>'; ?>
		  <textarea cols="83" rows="3" name="twitter_unlink_button"><?php echo $nextend_twitter_connect['twitter_unlink_button']; ?></textarea>
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
	<input style="margin-left: 10%;" type="submit" name="Submit" value="<?php _e('Save Changes', 'nextend-twitter-connect'); ?>" />
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

function NextendTwitter_Menu() {
	add_options_page(__('Nextend Twitter Connect'), __('Nextend Twitter Connect'), 'manage_options', 'nextend-twitter-connect', array(__CLASS__,'NextendTwitter_Options_Page'));
}

}
}
?>
