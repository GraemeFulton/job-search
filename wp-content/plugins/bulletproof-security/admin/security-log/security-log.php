<?php
// Direct calls to this file are Forbidden when core files are not present
if ( !current_user_can('manage_options') ){ 
		header('Status: 403 Forbidden');
		header('HTTP/1.1 403 Forbidden');
		exit();
}
?>

<div class="wrap">
<div id="bpsUprade"><strong>
<a href="http://www.ait-pro.com/bulletproof-security-pro-flash/bulletproof.html" target="_blank" title="BulletProof Security Pro Flash Movie">Upgrade to BulletProof Security Pro</a></strong></div>

<!-- Begin Rating CSS - needs to be inline to load on first launch -->
<style type="text/css">
div.bps-star-container { float:right; position: relative; top:-10px; right:-100px; height:19px; width:100px; font-size:19px;}
div.bps-star {height: 100%; position:absolute; top:0px; left:0px; background-color: transparent; letter-spacing:1ex; border:none;}
.bps-star1 {width:20%;} .bps-star2 {width:40%;} .bps-star3 {width:60%;} .bps-star4 {width:80%;} .bps-star5 {width:100%;}
.bps-star.bps-star-rating {background-color: #fc0;}
.bps-star img{display:block; position:absolute; right:0px; border:none; text-decoration:none;}
div.bps-star img {width:19px; height:19px; border-left:1px solid #fff; border-right:1px solid #fff;}
.bps-downloaded {float:right; position: relative; top:15px; right:0px; }
.bps-star-link {position: relative; top:43px; right:0px; font-size:12px;}
</style>
<!-- End Rating CSS - needs to be inline to load on first launch -->

<?php
if (function_exists('get_transient')) {
require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );

	if (false === ($bpsapi = get_transient('bulletproof-security_info'))) {
		$bpsapi = plugins_api('plugin_information', array('slug' => stripslashes( 'bulletproof-security' ) ));
	
	if ( !is_wp_error($bpsapi) ) {
		$bpsexpire = 60 * 15; // Cache data for 15 minutes
		set_transient('bulletproof-security_info', $bpsapi, $bpsexpire);
	}
	}
  
	if ( !is_wp_error($bpsapi) ) {
		$plugins_allowedtags = array('a' => array('href' => array(), 'title' => array(), 'target' => array()),
								'abbr' => array('title' => array()), 'acronym' => array('title' => array()),
								'code' => array(), 'pre' => array(), 'em' => array(), 'strong' => array(),
								'div' => array(), 'p' => array(), 'ul' => array(), 'ol' => array(), 'li' => array(),
								'h1' => array(), 'h2' => array(), 'h3' => array(), 'h4' => array(), 'h5' => array(), 'h6' => array(),
								'img' => array('src' => array(), 'class' => array(), 'alt' => array()));
	//Sanitize HTML
	foreach ( (array)$bpsapi->sections as $section_name => $content )
		$bpsapi->sections[$section_name] = wp_kses($content, $plugins_allowedtags);
	foreach ( array('version', 'author', 'requires', 'tested', 'homepage', 'downloaded', 'slug') as $key )
		$bpsapi->$key = wp_kses($bpsapi->$key, $plugins_allowedtags);

	  if ( !empty($bpsapi->downloaded) ) {
        echo '<div class="bps-downloaded">'.sprintf(__('%s Downloads', 'bulletproof-security'),number_format_i18n($bpsapi->downloaded)).'</div>';
      }
?>
		<?php if ( !empty($bpsapi->rating) ) : ?>
		<div class="bps-star-container" title="<?php //echo esc_attr(sprintf(__('Average Rating (%s ratings)', 'bulletproof-security'),number_format_i18n($bpsapi->num_ratings))); ?>">
			<div class="bps-star bps-star-rating" style="width: <?php echo esc_attr($bpsapi->rating) ?>px"></div>
			<div class="bps-star bps-star5"><img src="<?php echo plugins_url('/bulletproof-security/admin/images/star.png'); ?>" alt="<?php _e('5 stars', 'bulletproof-security') ?>" /></div>
			<div class="bps-star bps-star4"><img src="<?php echo plugins_url('/bulletproof-security/admin/images/star.png'); ?>" alt="<?php _e('4 stars', 'bulletproof-security') ?>" /></div>
			<div class="bps-star bps-star3"><img src="<?php echo plugins_url('/bulletproof-security/admin/images/star.png'); ?>" alt="<?php _e('3 stars', 'bulletproof-security') ?>" /></div>
			<div class="bps-star bps-star2"><img src="<?php echo plugins_url('/bulletproof-security/admin/images/star.png'); ?>" alt="<?php _e('2 stars', 'bulletproof-security') ?>" /></div>
			<div class="bps-star bps-star1"><img src="<?php echo plugins_url('/bulletproof-security/admin/images/star.png'); ?>" alt="<?php _e('1 star', 'bulletproof-security') ?>" /></div>
		
        <div class="bps-star-link"><a target="_blank" title="Link opens in new browser window" href="http://wordpress.org/extend/plugins/<?php echo $bpsapi->slug ?>/"> <?php _e('Rate BPS', 'bulletproof-security'); ?></a> <small><?php //echo sprintf(__('%s Ratings', 'bulletproof-security'),number_format_i18n($bpsapi->num_ratings)); ?> </small></div>
        
        </div>
		
        <br />
		<?php endif; 
	  } // if ( !is_wp_error($bpsapi)
 }// end if (function_exists('get_transient'
?>


<h2 style="margin-left:70px;"><?php _e('BulletProof Security ~ Security Log', 'bulletproof-security'); ?></h2>
<div id="message" class="updated" style="border:1px solid #999999; margin-left:70px;background-color: #000;">

<?php
// HUD - Heads Up Display - Warnings and Error messages
echo bps_check_php_version_error();
echo bps_hud_check_bpsbackup();
echo bps_check_safemode();
echo @bps_w3tc_htaccess_check($plugin_var);
echo @bps_wpsc_htaccess_check($plugin_var);
bps_delete_language_files();

// General all purpose "Settings Saved." message for forms
if ( current_user_can('manage_options') && wp_script_is( 'bps-js', $list = 'queue' ) ) {
if ( @$_GET['settings-updated'] == true) {
	$text = '<p style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:5px;margin:0px;"><font color="green"><strong>'.__('Settings Saved', 'bulletproof-security').'</strong></font></p>';
	echo $text;
	}
}

$bpsSpacePop = '-------------------------------------------------------------';

// Replace ABSPATH = wp-content/plugins
$bps_plugin_dir = str_replace( ABSPATH, '', WP_PLUGIN_DIR);
// Replace ABSPATH = wp-content
$bps_wpcontent_dir = str_replace( ABSPATH, '', WP_CONTENT_DIR);

// Top div echo & bottom div echo
$bps_topDiv = '<div id="message" class="updated" style="background-color:#ffffe0;font-size:1em;font-weight:bold;border:1px solid #999999; margin-left:70px;"><p>';
$bps_bottomDiv = '</p></div>';

// Form - Security Log page - Turn Error Logging Off
if (isset($_POST['Submit-Error-Log-Off']) && current_user_can('manage_options')) {
	check_admin_referer( 'bps-error-log-off' );

$AutoLockoptions = get_option('bulletproof_security_options_autolock');	
$filename = ABSPATH . '.htaccess';
$permsHtaccess = @substr(sprintf('%o', fileperms($filename)), -4);
$sapi_type = php_sapi_name();	
$stringReplace = file_get_contents($filename);
$pattern1 = '/#ErrorDocument\s400(.*)ErrorDocument\s404\s(.*)\/404\.php/s';
$pattern2 = '/ErrorDocument\s400(.*)ErrorDocument\s404\s(.*)\/404\.php/s';
$bps_get_wp_root_secure = bps_wp_get_root_folder();		
	
	if ( file_exists($filename) && preg_match($pattern1, $stringReplace, $matches) ) {
		
		if ( @substr($sapi_type, 0, 6) != 'apache' || @$permsHtaccess != '0666' || @$permsHtaccess != '0777') { // Windows IIS, XAMPP, etc
			@chmod($filename, 0644);
		}		
		
		$stringReplace = preg_replace('/#ErrorDocument\s400(.*)ErrorDocument\s404\s(.*)\/404\.php/s', "ErrorDocument 400 $bps_get_wp_root_secure"."$bps_plugin_dir/bulletproof-security/400.php\n#ErrorDocument 401 default\n#ErrorDocument 403 $bps_get_wp_root_secure"."$bps_plugin_dir/bulletproof-security/403.php\n#ErrorDocument 404 $bps_get_wp_root_secure"."404.php", $stringReplace);
		
		if ( !file_put_contents($filename, $stringReplace) ) {
			echo $bps_topDiv;
			$text = '<font color="red"><strong>'.__('Error: Unable to turn Error Logging Off. Either the root .htaccess file is not writable, it does not exist or the ErrorDocument .htaccess code does not exist in your Root .htaccess file. Check that the root .htaccess file exists, the code exists and that file permissions allow writing.', 'bulletproof-security').'</strong></font>';
			echo $text;
			echo $bps_bottomDiv;
		} else {
			
			if ( @$permsHtaccess == '0644' && @substr($sapi_type, 0, 6) != 'apache' && $AutoLockoptions['bps_root_htaccess_autolock'] != 'Off') {			
				@chmod($filename, 0404);
			}			
		}
	}

	if ( file_exists($filename) && preg_match($pattern2, $stringReplace, $matches) ) {
		
		if ( @substr($sapi_type, 0, 6) != 'apache' || @$permsHtaccess != '0666' || @$permsHtaccess != '0777') { // Windows IIS, XAMPP, etc
			@chmod($filename, 0644);
		}		

		$stringReplace = preg_replace('/ErrorDocument\s400(.*)ErrorDocument\s404\s(.*)\/404\.php/s', "#ErrorDocument 400 $bps_get_wp_root_secure"."$bps_plugin_dir/bulletproof-security/400.php\n#ErrorDocument 401 default\n#ErrorDocument 403 $bps_get_wp_root_secure"."$bps_plugin_dir/bulletproof-security/403.php\n#ErrorDocument 404 $bps_get_wp_root_secure"."404.php", $stringReplace);
		
		if ( !file_put_contents($filename, $stringReplace) ) {
			echo $bps_topDiv;
			$text = '<font color="red"><strong>'.__('Error: Unable to turn Error Logging Off. Either the root .htaccess file is not writable, it does not exist or the ErrorDocument .htaccess code does not exist in your Root .htaccess file. Check that the root .htaccess file exists, the code exists and that file permissions allow writing.', 'bulletproof-security').'</strong></font>';
			echo $text;
			echo $bps_bottomDiv;
		} else {
			
			if ( @$permsHtaccess == '0644' && @substr($sapi_type, 0, 6) != 'apache' && $AutoLockoptions['bps_root_htaccess_autolock'] != 'Off') {			
				@chmod($filename, 0404);
			}	

			echo $bps_topDiv;
			$text = '<p><font color="green"><strong>'.__('Error Logging has been turned Off', 'bulletproof-security').'</strong></font></p>';
			echo $text;		
			echo $bps_bottomDiv;
		}
	}
}

// Form - Security Log page - Turn Error Logging On
if (isset($_POST['Submit-Error-Log-On']) && current_user_can('manage_options')) {
	check_admin_referer( 'bps-error-log-on' );

$AutoLockoptions = get_option('bulletproof_security_options_autolock');	
$filename = ABSPATH . '.htaccess';
$permsHtaccess = @substr(sprintf('%o', fileperms($filename)), -4);
$sapi_type = php_sapi_name();
$stringReplace = file_get_contents($filename);
$pattern1 = '/ErrorDocument\s400(.*)ErrorDocument\s404\s(.*)\/404\.php/s';	
$pattern2 = '/#ErrorDocument\s400(.*)ErrorDocument\s404\s(.*)\/404\.php/s';
$bps_get_wp_root_secure = bps_wp_get_root_folder();
$htaccessARQ = WP_CONTENT_DIR . '/bps-backup/autorestore/root-files/auto_.htaccess';
	
	// This factors in the scenario of #ErrorDocument 403 being commented out if other ErrorDocument directives are NOT commented out
	// Create a new ErrorDocument .htaccess block of code with all ErrorDocument directives uncommented
	if ( file_exists($filename) && preg_match($pattern1, $stringReplace, $matches) ) {
		
		if ( @substr($sapi_type, 0, 6) != 'apache' || @$permsHtaccess != '0666' || @$permsHtaccess != '0777') { // Windows IIS, XAMPP, etc
			@chmod($filename, 0644);
		}	

		$stringReplace = preg_replace('/ErrorDocument\s400(.*)ErrorDocument\s404\s(.*)\/404\.php/s', "ErrorDocument 400 $bps_get_wp_root_secure"."$bps_plugin_dir/bulletproof-security/400.php\nErrorDocument 401 default\nErrorDocument 403 $bps_get_wp_root_secure"."$bps_plugin_dir/bulletproof-security/403.php\nErrorDocument 404 $bps_get_wp_root_secure"."404.php", $stringReplace);		
		
		if ( !file_put_contents($filename, $stringReplace) ) {		
			echo $bps_topDiv;
			$text = '<font color="red"><strong>'.__('Error: Unable to turn Error Logging On. Either the root .htaccess file is not writable, it does not exist or the ErrorDocument .htaccess code does not exist in your Root .htaccess file. Check that the root .htaccess file exists, the code exists and that file permissions allow writing.', 'bulletproof-security').'</strong></font>';
			echo $text;
			echo $bps_bottomDiv;
		} else {
			
			if ( @$permsHtaccess == '0644' && @substr($sapi_type, 0, 6) != 'apache' && $AutoLockoptions['bps_root_htaccess_autolock'] != 'Off') {			
				@chmod($filename, 0404);
			}			

			echo $bps_topDiv;
			$text = '<font color="green"><strong>'.__('Error Logging has been turned On', 'bulletproof-security').'</strong></font>';
			echo $text;	
			echo $bps_bottomDiv;
		}
	}
	
	if ( file_exists($filename) && preg_match($pattern2, $stringReplace, $matches) ) {
		
		if ( @substr($sapi_type, 0, 6) != 'apache' || @$permsHtaccess != '0666' || @$permsHtaccess != '0777') { // Windows IIS, XAMPP, etc
			@chmod($filename, 0644);
		}
		
		$stringReplace = preg_replace('/#ErrorDocument\s400(.*)ErrorDocument\s404\s(.*)\/404\.php/s', "ErrorDocument 400 $bps_get_wp_root_secure"."$bps_plugin_dir/bulletproof-security/400.php\nErrorDocument 401 default\nErrorDocument 403 $bps_get_wp_root_secure"."$bps_plugin_dir/bulletproof-security/403.php\nErrorDocument 404 $bps_get_wp_root_secure"."404.php", $stringReplace);
		
		if ( !file_put_contents($filename, $stringReplace) ) {
			echo $bps_topDiv;
			$text = '<font color="red"><strong>'.__('Error: Unable to turn Error Logging On. Either the root .htaccess file is not writable, it does not exist or the ErrorDocument .htaccess code does not exist in your Root .htaccess file. Check that the root .htaccess file exists, the code exists and that file permissions allow writing.', 'bulletproof-security').'</strong></font>';
			echo $text;
			echo $bps_bottomDiv;
		} else {
			
			if ( @$permsHtaccess == '0644' && @substr($sapi_type, 0, 6) != 'apache' && $AutoLockoptions['bps_root_htaccess_autolock'] != 'Off') {			
				@chmod($filename, 0404);
			}				
		}
	}
}

?>
</div>

<!-- jQuery UI Tab Menu -->
<div id="bps-container">
	<div id="bps-tabs" class="bps-menu">
    <div id="bpsHead" style="position:relative; top:0px; left:0px;"><img src="<?php echo plugins_url('/bulletproof-security/admin/images/bps-security-shield.png'); ?>" style="float:left; padding:0px 8px 0px 0px; margin:-72px 0px 0px 0px;" /></div>
		<ul>
			<li><a href="#bps-tabs-1"><?php _e('Security Log', 'bulletproof-security'); ?></a></li>
			<li><a href="#bps-tabs-2"><?php _e('Help &amp; FAQ', 'bulletproof-security'); ?></a></li>
		</ul>
            
<div id="bps-tabs-1" class="bps-tab-page">
<h2><?php _e('Blocked Hackers, Spammers, Scrapers, Bots Logged ~ HTTP Errors Logged', 'bulletproof-security'); ?></h2>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="bps-help_faq_table">
  <tr>
    <td class="bps-table_title">&nbsp;</td>
  </tr>
  <tr>
    <td class="bps-table_cell_help">

<h3><?php _e('Security Log / HTTP Error Log', 'bulletproof-security'); ?>  <button id="bps-open-modal9" class="bps-modal-button"><?php _e('Read Me', 'bulletproof-security'); ?></button></h3>

<div id="bps-modal-content9" title="<?php _e('Security Log / HTTP Error Log', 'bulletproof-security'); ?>">
	<p><?php $text = '<strong>'.__('This Read Me Help window is draggable (top) and resizable (bottom right corner)', 'bulletproof-security').'</strong><br><br><strong>'.__('Security Log General Information', 'bulletproof-security').'</strong><br>'.__('Your Security Log file is a plain text static file and not a dynamic file or dynamic display to keep your website resource usage at a bare minimum and keep your website performance at a maximum. Log entries are logged in descending order by Date and Time. You can copy, edit and delete this plain text file.', 'bulletproof-security').'<br><br><strong>'.__('NOTE: BPS Pro Login Security & Security Log email alerting & Log File options are located in S-Monitor BPS Pro Email Alerting & Log File Options instead of being on the Login Security page & the Security Log pages.', 'bulletproof-security').'</strong><br>'.__('If you upgrade to BPS Pro from BPS Free your option settings will be saved. Your Login Security Database table and rows will also be saved. The Email Alerts & Log Files Options Form is identical on the Login Security & Security Log page in BPS free. You can change and save your email alerting and log file options on either page.', 'bulletproof-security').'<strong><br><br>'.__('NOTE: ', 'bulletproof-security').'</strong>'.__('If a particular User Agent/Bot is generating excessive log entries you can add it to Add User Agents/Bots to Ignore/Not Log tool and that User Agent/Bot will no longer be logged. See the Ignoring/Not Logging User Agents/Bots help section.', 'bulletproof-security').'<br><br>'.__('The Security Log logs 400 and 403 HTTP Response Status Codes by default. You can also log 404 HTTP Response Status Codes by opening this BPS 404 Template file - /bulletproof-security/404.php and copying the logging code into your Theme\'s 404 Template file. When you open the BPS Pro 404.php file you will see simple instructions on how to add the 404 logging code to your Theme\'s 404 Template file.', 'bulletproof-security').'<br><br><strong>'.__('HTTP Response Status Codes', 'bulletproof-security').'</strong><br>'.__('400 Bad Request - The request could not be understood by the server due to malformed syntax.', 'bulletproof-security').'<br><br>'.__('403 Forbidden - The Server understood the request, but is refusing to fulfill it.', 'bulletproof-security').'<br><br>'.__('404 Not Found - The server has not found anything matching the Request-URI / URL. No indication is given of whether the condition is temporary or permanent.', 'bulletproof-security').'<br><br><strong>'.__('Security Log File Size', 'bulletproof-security').'</strong><br>'.__('Displays the size of your Security Log file. 500KB is the optimum recommended log file size setting that you should choose for your log file to be automatically zipped, emailed and replaced with a new blank Security Log file.', 'bulletproof-security').'<br><br><strong>'.__('Security Log Status:', 'bulletproof-security').'</strong><br>'.__('Displays whether your Security Log / Error Log is turned On or Off.', 'bulletproof-security').'<br><br><strong>'.__('Security Log Last Modified Time:', 'bulletproof-security').'</strong><br>'.__('Displays the last time a Security Log entry was logged.', 'bulletproof-security').'<br><br><strong>'.__('Turn Off Error Logging button', 'bulletproof-security').'</strong><br>'.__('Turns off Error Logging.', 'bulletproof-security').'<br><br><strong>'.__('Turn On Error Logging button', 'bulletproof-security').'</strong><br>'.__('Turns On Error Logging.', 'bulletproof-security').'<br><br><strong>'.__('Delete Log Button', 'bulletproof-security').'</strong><br>'.__('Clicking the Delete Log button will delete the entire contents of your Security Log File.', 'bulletproof-security').'<br><br><strong>'.__('Ignoring/Not Logging User Agents/Bots - Allowing/Logging User Agents/Bots', 'bulletproof-security').'</strong><br>'.__('Adding or Removing User Agents/Bots adds or removes User Agents/Bots to your Database and also writes new code to the 403.php Security Logging template. The 403.php Security Logging file is where the check occurs whether or not to log or not log a User Agent/Bot. It would be foolish and costly to website performance to have your WordPress database handle the task/function/burden of checking which User Agents/Bots to log or not log. WordPress database queries are the most resource draining function of a WordPress website. The more database queries that are happening at the same time on your website the slower your website will perform and load. For this reason the Security Logging check is done from code in the 403.php Security Logging file.', 'bulletproof-security').'<br><br>'.__('If a particular User Agent/Bot is being logged excessively in your Security Log file you can Ignore/Not Log that particular User Agent/Bot based on the HTTP_USER_AGENT string in your Security Log. Example User Agent strings: Mozilla/5.0 (compatible; 008/0.85; http://www.80legs.com/webcrawler.html) Gecko/2008032620 and facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php). You could enter 008 or 80legs or webcrawler to Ignore/Not Log the 80legs User Agent/Bot. You could enter facebookexternalhit or facebook or externalhit_uatext to Ignore/Not Log the facebook User Agent/Bot.', 'bulletproof-security').'<br><br><strong>'.__('Add User Agents/Bots to Ignore/Not Log', 'bulletproof-security').'</strong><br>'.__('Add the User Agent/Bot names you would like to Ignore/Not Log in your Security Log.', 'bulletproof-security').'<br><br><strong>'.__('Removing User Agents/Bots to Allow/Log', 'bulletproof-security').'</strong><br>'.__('To search for ALL User Agents/Bots to remove/delete from your database leave the text box blank and click the Remove / Allow button. You will see a Dynamically generated Radio Button Form that will display the User Agents/Bots in the BPS User Agent/Bot database Table, Remove or Do Not Remove Radio buttons and the Timestamp when the User Agent/Bot was added to your DB. Select the Remove Radio buttons for the User Agents/Bots you want to remove/delete from your database and click the Remove button. Removing/deleting User Agents/Bots from your database means that you want to have these User Agents/Bots logged again in your Security/HTTP Error Log.', 'bulletproof-security'); echo $text; ?></p>
</div>

<div id="SecurityLogTable" style="position:relative; top:0px; left:0px; margin:15px 0px 15px -3px;">

<table width="500" border="0">
  <tr>
    <td>
<form name="BPSErrorLogOff" action="admin.php?page=bulletproof-security/admin/security-log/security-log.php" method="post">
<?php wp_nonce_field('bps-error-log-off'); ?>
<input type="submit" name="Submit-Error-Log-Off" value="<?php esc_attr_e('Turn Off Error Logging', 'bulletproof-security') ?>" class="bps-blue-button" onclick="return confirm('<?php $text = __('Click OK to Turn Off Error Logging or click Cancel.', 'bulletproof-security'); echo $text; ?>')" />
</form>
</td>
    <td>
<form name="BPSErrorLogOn" action="admin.php?page=bulletproof-security/admin/security-log/security-log.php" method="post">
<?php wp_nonce_field('bps-error-log-on'); ?>
<input type="submit" name="Submit-Error-Log-On" value="<?php esc_attr_e('Turn On Error Logging', 'bulletproof-security') ?>" class="bps-blue-button" onclick="return confirm('<?php $text = __('Click OK to Turn On Error Logging or click Cancel.', 'bulletproof-security'); echo $text; ?>')" />
</form>
</td>
    <td>
<form name="DeleteLogForm" action="admin.php?page=bulletproof-security/admin/security-log/security-log.php" method="post">
<?php wp_nonce_field('bps-delete-security-log'); ?>
<input type="submit" name="Submit-Delete-Log" value="<?php esc_attr_e('Delete Log', 'bulletproof-security') ?>" class="bps-blue-button" onclick="return confirm('<?php $text = __('Clicking OK will delete the contents of your Security Log file.', 'bulletproof-security').'\n\n'.$bpsSpacePop.'\n\n'.__('Click OK to Delete the Log file contents or click Cancel.', 'bulletproof-security'); echo $text; ?>')" />
</form>
</td>
  </tr>
</table>
</div>

<?php
// Get File Size of the Security Log File
function bps_getSecurityLogSize() {
$filename = WP_CONTENT_DIR . '/bps-backup/logs/http_error_log.txt';

if ( @file_exists($filename) ) {
	$logSize = filesize($filename);
	
	if ($logSize < 2097152) {
 		$text = '<strong>'. __('Security Log File Size: ', 'bulletproof-security').'<font color="blue">'. round($logSize / 1024, 2) .' KB</font></strong><br>';
		echo $text;
	} else {
		 $text = '<strong>'. __('Security Log File Size: ', 'bulletproof-security').'<font color="red">'. round($logSize / 1024, 2) .' KB<br>'.__('Your Security Log file is larger than 2MB. It appears that BPS is unable to automatically zip, email and delete your Security Log file.', 'bulletproof-security').'</font></strong><br>'.__('Check your Email Alerts & Log File Options.', 'bulletproof-security').'<br>'.__('You can manually delete the contents of this log file by clicking the Delete Log button.', 'bulletproof-security').'<br>';		
		echo $text;
	}
	}
}
bps_getSecurityLogSize();

// Echo Error Logging On or Off
function bpsErrorLoggingOnOff() {
$filename = ABSPATH . '.htaccess';
$check_string = file_get_contents($filename);
$pattern = '/#ErrorDocument\s400(.*)ErrorDocument\s404\s(.*)\/404\.php/s';	

	if ( file_exists($filename) && preg_match($pattern, $check_string, $matches) ) {
		$text = '<strong>'.__('Security Log Status: ', 'bulletproof-security').'<font color="blue">'.__('Error Logging is Turned Off', 'bulletproof-security').'</font></strong><br>';
		echo $text;
	} else {
		$text = '<strong>'.__('Security Log Status: ', 'bulletproof-security').'<font color="blue">'.__('Error Logging is Turned On', 'bulletproof-security').'</font></strong><br>';
		echo $text;		
	}
}
echo bpsErrorLoggingOnOff();

// Get the Current / Last Modifed Date of the Security Log File
function bps_getSecurityLogLastMod() {
$filename = WP_CONTENT_DIR . '/bps-backup/logs/http_error_log.txt';

	if ( file_exists($filename) ) {
		$gmt_offset = get_option( 'gmt_offset' ) * 3600;
		$timestamp = date_i18n(get_option('date_format').' - '.get_option('time_format'), @filemtime($filename) + $gmt_offset);

	$text = '<strong>'. __('Security Log Last Modified Time: ', 'bulletproof-security').'<font color="blue">'.$timestamp.'</font></strong><br>';
	echo $text;
	}
}
echo bps_getSecurityLogLastMod();

// Delete Security Log
if (isset($_POST['Submit-Delete-Log']) && current_user_can('manage_options')) {
	check_admin_referer( 'bps-delete-security-log' );

	$SecurityLog = WP_CONTENT_DIR . '/bps-backup/logs/http_error_log.txt';
	$SecurityLogMaster = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/http_error_log.txt'; 
	copy($SecurityLogMaster, $SecurityLog);
		echo $bps_topDiv;
		$text = '<font color="green"><strong>'.__('Success! Your Security Log file has been deleted and replaced with a new blank Security Log file.', 'bulletproof-security').'</strong></font>';
		echo $text;	
		echo $bps_bottomDiv;

}

// Security Log Form - Add User Agents to DB and write them to the 403.php template
if (isset($_POST['Submit-UserAgent-Ignore']) && current_user_can('manage_options')) {
check_admin_referer( 'bulletproof_security_useragent_ignore' );   
		
$userAgent = trim(stripslashes($_POST['user-agent-ignore']));
$table_name = $wpdb->prefix . "bpspro_seclog_ignore";
$blankFile = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/blank.txt';
$userAgentMaster = WP_CONTENT_DIR . '/bps-backup/master-backups/UserAgentMaster.txt';
$bps403File = WP_PLUGIN_DIR . '/bulletproof-security/403.php';
$search = '';		

	// characters that are not allowed: / and |
	if ( $userAgent != '' && !preg_match ('#/#', $userAgent) || !preg_match ('#|#', $userAgent) ) {
		
		echo $bps_topDiv;
		$rows_affected = $wpdb->insert( $table_name, array( 'time' => current_time('mysql'), 'user_agent_bot' => $userAgent ) );
		$text = '<font color="green"><strong>'.__('Success! ', 'bulletproof-security').$userAgent.__(' User Agent/Bot has been added to your DB. ', 'bulletproof-security').'</strong></font>';
		echo $text;
		echo $bps_bottomDiv;
		
	} else {
		
		echo $bps_topDiv;
		$text = '<font color="red"><strong>'.__('Error: ', 'bulletproof-security').$userAgent.__(' User Agent/Bot was not successfully added. Click the Blue Read Help button for examples of valid User Agent/Bot names.', 'bulletproof-security').'</strong></font>';
		echo $text;
		echo $bps_bottomDiv;		
	}

	if ( !file_exists($bps403File) ) {
			echo $bps_topDiv;
			$text = '<font color="red"><strong>'.__('Error: The ', 'bulletproof-security').$bps403File.__(' does not exist.', 'bulletproof-security').'</strong></font>';
			echo $text;		
			echo $bps_bottomDiv;
	}
	
	if ( file_exists($blankFile) ) {
		copy($blankFile, $userAgentMaster);
	}

	$getSecLogTable = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE user_agent_bot LIKE %s", "%$search%") );
	$UserAgentRules = array();
		
	if ( $wpdb->num_rows != 0 ) {

		foreach ( $getSecLogTable as $row ) {
			$UserAgentRules[] = "(.*)".$row->user_agent_bot."(.*)|";
			file_put_contents($userAgentMaster, $UserAgentRules);
		}
	
	$UserAgentRulesT = @file_get_contents($userAgentMaster);
	$stringReplace = @file_get_contents($bps403File);

			$stringReplace = preg_replace('/# BEGIN USERAGENT FILTER(.*)# END USERAGENT FILTER/s', "# BEGIN USERAGENT FILTER\nif ( !preg_match('/".trim($UserAgentRulesT, "|")."/', \$_SERVER['HTTP_USER_AGENT']) ) {\n# END USERAGENT FILTER", $stringReplace);
		
		if ( !file_put_contents($bps403File, $stringReplace) ) {
			echo $bps_topDiv;
			$text = '<font color="red"><strong>'.__('Error: Unable to write to file ', 'bulletproof-security').$bps403File.__('. Check that file permissions allow writing to this file. If you have a DSO Server check file and folder Ownership.', 'bulletproof-security').'</strong></font>';
			echo $text;	
			echo $bps_bottomDiv;
		} else {
			echo $bps_topDiv;
			$text = '<font color="green"><strong>'.__('Success! The BPS 403.php Security Logging template file has been updated. This User Agent/Bot will be no longer be logged in your Security Log.', 'bulletproof-security').'</strong></font>';
			echo $text;	
			echo $bps_bottomDiv;
		}
	}
}
?>

<!-- margin: 20px 0px 0px 0px;  -->
<div id="LoginSecurityEmailOptions" style="margin: 20px 0px 0px 0px;">   
    <form name="bpsEmailAlerts" action="options.php" method="post">
    <?php settings_fields('bulletproof_security_options_email'); ?>
	<?php $options = get_option('bulletproof_security_options_email'); ?>
	<?php $admin_email = get_option('admin_email'); ?>
<strong><label for="bps-monitor-email1"><?php _e('Send Email Alerts & Log Files To:', 'bulletproof-security'); ?> </label></strong>
<input type="text" name="bulletproof_security_options_email[bps_send_email_to]" class="regular-text-long-fixed" style="width:200px;" value="<?php if ($options['bps_send_email_to'] != '') { echo $options['bps_send_email_to']; } else { echo $admin_email; } ?>" /><br />
<strong><label for="bps-monitor-email2" style="margin:0px 0px 0px 0px;vertical-align:middle;"><?php _e('Send Email Alerts & Log Files From:', 'bulletproof-security'); ?> </label></strong>
<input type="text" name="bulletproof_security_options_email[bps_send_email_from]" class="regular-text-long-fixed" style="width:200px;" value="<?php if ($options['bps_send_email_from'] != '') { echo $options['bps_send_email_from']; } else { echo $admin_email; } ?>" /><br />
<strong><label for="bps-monitor-email3"><?php _e('Send Email Alerts & Log Files Cc:', 'bulletproof-security'); ?> </label></strong>
<input type="text" name="bulletproof_security_options_email[bps_send_email_cc]" class="regular-text-long-fixed" style="width:200px;" value="<?php echo $options['bps_send_email_cc']; ?>" /><br />
<strong><label for="bps-monitor-email4"><?php _e('Send Email Alerts & Log Files Bcc:', 'bulletproof-security'); ?> </label></strong>
<input type="text" name="bulletproof_security_options_email[bps_send_email_bcc]" class="regular-text-long-fixed" style="width:200px; margin:0px 0px 20px 0px;" value="<?php echo $options['bps_send_email_bcc']; ?>" /><br />
<input type="hidden" name="bpsEMA" value="bps-EMA" />
<strong><label for="bps-monitor-email"><?php _e('Login Security: Send Login Security Email Alert When...', 'bulletproof-security'); ?></label></strong><br />
<select name="bulletproof_security_options_email[bps_login_security_email]" style="width:340px;">
<option value="lockoutOnly" <?php selected( $options['bps_login_security_email'], 'lockoutOnly'); ?>><?php _e('A User Account Is Locked Out', 'bulletproof-security'); ?></option>
<option value="adminLoginOnly" <?php selected( $options['bps_login_security_email'], 'adminLoginOnly'); ?>><?php _e('An Administrator Logs In', 'bulletproof-security'); ?></option>
<option value="adminLoginLock" <?php selected( $options['bps_login_security_email'], 'adminLoginLock'); ?>><?php _e('An Administrator Logs In & A User Account is Locked Out', 'bulletproof-security'); ?></option>
<option value="anyUserLoginLock" <?php selected( $options['bps_login_security_email'], 'anyUserLoginLock'); ?>><?php _e('Any User Logs In & A User Account is Locked Out', 'bulletproof-security'); ?></option>
<option value="no" <?php selected( $options['bps_login_security_email'], 'no'); ?>><?php _e('Do Not Send Email Alerts', 'bulletproof-security'); ?></option>
</select><br /><br />
<!-- display:none but keep the options together - position:relative; top:-40px; left:0px;  -->
<strong><label for="bps-monitor-email-log"><?php _e('Security Log: Email/Delete Security Log File When...', 'bulletproof-security'); ?></label></strong><br />
<select name="bulletproof_security_options_email[bps_security_log_size]" style="width:80px;">
<option value="500KB" <?php selected( $options['bps_security_log_size'], '500KB' ); ?>><?php _e('500KB', 'bulletproof-security'); ?></option>
<option value="256KB" <?php selected( $options['bps_security_log_size'], '256KB'); ?>><?php _e('256KB', 'bulletproof-security'); ?></option>
<option value="1MB" <?php selected( $options['bps_security_log_size'], '1MB' ); ?>><?php _e('1MB', 'bulletproof-security'); ?></option>
</select>
<select name="bulletproof_security_options_email[bps_security_log_emailL]" style="width:255px;">
<option value="email" <?php selected( $options['bps_security_log_emailL'], 'email' ); ?>><?php _e('Email Log & Then Delete Log File', 'bulletproof-security'); ?></option>
<option value="delete" <?php selected( $options['bps_security_log_emailL'], 'delete' ); ?>><?php _e('Delete Log File', 'bulletproof-security'); ?></option>
</select><br /><br />
<!-- <strong><label for="bps-monitor-email" style="margin:0px 0px 0px 0px;"><?php //_e('BPS Plugin Upgrade Email Notification', 'bulletproof-security'); ?></label></strong><br />
<select name="bulletproof_security_options_email[bps_upgrade_email]" style="width:340px;">
<option value="yes" <?php //selected( @$options['bps_upgrade_email'], 'yes'); ?>><?php //_e('Send Email Alerts', 'bulletproof-security'); ?></option>
<option value="no" <?php //selected( @$options['bps_upgrade_email'], 'no'); ?>><?php //_e('Do Not Send Email Alerts', 'bulletproof-security'); ?></option>
</select><br /><br /> -->
<input type="submit" name="bpsEmailAlertSubmit" class="bps-blue-button" style="margin:0px 0px 20px 0px;" value="<?php esc_attr_e('Save Options', 'bulletproof-security') ?>" />
</form>
</div>

<div id="bpsUserAgent1" style="margin:0px 0px 0px 0px;">
<form action="admin.php?page=bulletproof-security/admin/security-log/security-log.php" method="post">
<?php wp_nonce_field('bulletproof_security_useragent_ignore'); ?>
    <strong><label for="UA-ignore"><?php _e('Add User Agents/Bots to Ignore/Not Log', 'bulletproof-security'); ?></label></strong><br />
    <strong><label for="UA-ignore"><?php _e('Click the Blue Read Me Help button for examples', 'bulletproof-security'); ?></label></strong><br />    
    <input type="text" name="user-agent-ignore" class="regular-text" style="width:320px;" value="" />
    <input type="submit" name="Submit-UserAgent-Ignore" value="<?php esc_attr_e('Add / Ignore', 'bulletproof-security') ?>" class="bps-blue-button" onclick="return confirm('<?php $text = __('Clicking OK will Add the User Agent/Bot name you have entered to your DB and the 403.php Security Logging template.', 'bulletproof-security').'\n\n'.$bpsSpacePop.'\n\n'.__('Security logging checks are done by the 403.php Security Logging file and not by DB Queries.', 'bulletproof-security').'\n\n'.$bpsSpacePop.'\n\n'.__('To remove User Agents/Bots from being ignored / not logged use the Remove / Allow tool.', 'bulletproof-security').'\n\n'.$bpsSpacePop.'\n\n'.__('Click OK to proceed or click Cancel.', 'bulletproof-security'); echo $text; ?>')" />
</form>
</div>

<?php
/**************************************/
//  BEGIN Dynamic Security Log Form   //
/**************************************/

	// Initial User Agent/Bot Search Form - hands off to Dynamic Radio Button Form
	echo '<form name="bpsDB-UA-Search" action="admin.php?page=bulletproof-security/admin/security-log/security-log.php" method="post">';
	wp_nonce_field('bulletproof_security_seclog_db_search');
	echo '<strong>'.__('Remove User Agents/Bots to Allow/Log', 'bulletproof-security').'</strong><br>';
	echo '<input type="text" name="userAgentSearchRemove" class="regular-text" style="width:320px;" value="" />';
	echo '<input type="submit" name="Submit-SecLog-Search" value="'.esc_attr('Remove / Allow', 'bulletproof-security').'" class="bps-blue-button" style="margin-left:4px;" onclick="return confirm('."'".__('Clicking OK will search your database and display User Agent/Bot DB search results in a Dynamic Radio button Form.', 'bulletproof-security').'\n\n'.$bpsSpacePop.'\n\n'.__('To search for ALL User Agents/Bots to remove/delete from your database leave the text box blank and click the Remove / Allow button.', 'bulletproof-security').'\n\n'.$bpsSpacePop.'\n\n'.__('Click OK to proceed or click Cancel.', 'bulletproof-security')."'".')" />';
	echo '</form><br><br>';

// Get the Search Post variable for processing other search/remove Forms 
if (isset($_POST['Submit-SecLog-Search']) && current_user_can('manage_options')) {
	check_admin_referer( 'bulletproof_security_seclog_db_search' );
	
$search = $_POST['userAgentSearchRemove'];
$bpspro_seclog_table = $wpdb->prefix . "bpspro_seclog_ignore";
$bps403File = WP_PLUGIN_DIR . '/bulletproof-security/403.php';
$stringReplace = @file_get_contents($bps403File);
$searchAll = '';

		if ( !file_exists($bps403File) ) {
			echo $bps_topDiv;
			$text = '<font color="red"><strong>'.__('Error: The ', 'bulletproof-security').$bps403File.__(' does not exist.', 'bulletproof-security').'</strong></font>';
			echo $text;		
			echo $bps_bottomDiv;
		}

			$getSecLogTableSearch = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $bpspro_seclog_table WHERE user_agent_bot LIKE %s", "%$searchAll%") );
			
		if ($wpdb->num_rows == 0) { // if no rows exist in DB add the BPSUserAgentPlaceHolder back into the 403.php security logging template
			
			$stringReplace = preg_replace('/# BEGIN USERAGENT FILTER(.*)# END USERAGENT FILTER/s', "# BEGIN USERAGENT FILTER\nif ( !preg_match('/BPSUserAgentPlaceHolder/', \$_SERVER['HTTP_USER_AGENT']) ) {\n# END USERAGENT FILTER", $stringReplace);		
		
		if ( !file_put_contents($bps403File, $stringReplace) ) {
			echo $bps_topDiv;
			$text = '<font color="red"><strong>'.__('Error: Unable to write to file ', 'bulletproof-security').$bps403File.__('. Check that file permissions allow writing to this file. If you have a DSO Server check file and folder Ownership.', 'bulletproof-security').'</strong></font>';
			echo $text;	
			echo $bps_bottomDiv;
		} else {
			// blah
		}		
		} // end if ($wpdb->num_rows == 0) { // No database rows
}

// Remove User Agents/Bots Dynamic Radio button Form proccessing code
if (isset($_POST['Submit-SecLog-Remove']) && current_user_can('manage_options')) {
	check_admin_referer('bulletproof_security_seclog_db_remove');
	
$removeornot = $_POST['removeornot'];
$bpspro_seclog_table = $wpdb->prefix . "bpspro_seclog_ignore";
$userAgentMaster = WP_CONTENT_DIR . '/bps-backup/master-backups/UserAgentMaster.txt';
$bps403File = WP_PLUGIN_DIR . '/bulletproof-security/403.php';
$searchALLD = '';

	switch($_POST['Submit-SecLog-Remove']) {
		case __('Remove', 'bulletproof-security'):
	
		$remove_rows = array();

		if (!empty($removeornot)) {
			foreach ($removeornot as $key => $value) {
				if ($value == 'remove') {
					$remove_rows[] = $key;
				} elseif ($value == 'donotremove') {
					$donotremove .=  ', '.$key;
				}
				}
			}
			$donotremove = substr($donotremove, 2);
		
		if (!empty($remove_rows)) {
			
			foreach ($remove_rows as $remove_row) {
				if ( !$delete_row = $wpdb->query( $wpdb->prepare( "DELETE FROM $bpspro_seclog_table WHERE user_agent_bot = %s", $remove_row) )) {
					$textSecLogRemove = '<font color="red"><strong>'.sprintf(__('%s unable to delete row from your DB.', 'bulletproof-security'), $remove_row).'</strong></font><br>';			
				} else {
					$textSecLogRemove = '<font color="green"><strong>'.sprintf(__('%s has been deleted from your DB.', 'bulletproof-security'), $remove_row).'</strong></font><br>';
	
					$getSecLogTableRemove = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $bpspro_seclog_table WHERE user_agent_bot LIKE %s", "%$searchALLD%") );
					$UserAgentRules = array();		

					foreach ($getSecLogTableRemove as $row) {
						$UserAgentRules[] = "(.*)".$row->user_agent_bot."(.*)|";
							file_put_contents($userAgentMaster, $UserAgentRules);
					}
				} // end if ( !$delete_row
			} // foreach ($remove_rows as $remove_row) {

			// Important these variables MUST BE HERE inside the switch
			$UserAgentRulesT = @file_get_contents($userAgentMaster);
			$stringReplace = @file_get_contents($bps403File);
					
			$stringReplace = preg_replace('/# BEGIN USERAGENT FILTER(.*)# END USERAGENT FILTER/s', "# BEGIN USERAGENT FILTER\nif ( !preg_match('/".trim($UserAgentRulesT, "|")."/', \$_SERVER['HTTP_USER_AGENT']) ) {\n# END USERAGENT FILTER", $stringReplace);

		if ( !file_put_contents($bps403File, $stringReplace) ) {
			echo $bps_topDiv;
			$text = '<font color="red"><strong>'.__('Error: Unable to write to file ', 'bulletproof-security').$bps403File.__('. Check that file permissions allow writing to this file. If you have a DSO Server check file and folder Ownership.', 'bulletproof-security').'</strong></font>';
			echo $text;	
			echo $bps_bottomDiv;
		} else {
			// need to run the Query again just in case there are 0 DB rows
			$getSecLogTableRemove = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $bpspro_seclog_table WHERE user_agent_bot LIKE %s", "%$searchAll%") );
			
		if ($wpdb->num_rows == 0) { // if no rows exist in DB add the BPSUserAgentPlaceHolder back into the 403.php security logging template
			
			$stringReplace = preg_replace('/# BEGIN USERAGENT FILTER(.*)# END USERAGENT FILTER/s', "# BEGIN USERAGENT FILTER\nif ( !preg_match('/BPSUserAgentPlaceHolder/', \$_SERVER['HTTP_USER_AGENT']) ) {\n# END USERAGENT FILTER", $stringReplace);
			file_put_contents($bps403File, $stringReplace);		
		}
			//copy($bps403File, $bps403FileARQ);
			echo $bps_topDiv;
			$text = '<font color="green"><strong>'.__('Success! The BPS 403.php Security Logging template file has been updated. This User Agent/Bot will be logged again in your Security Log.', 'bulletproof-security').'</strong></font>';
			echo $text;	
			echo $bps_bottomDiv;
		}
		} // end if (!empty($remove_rows)) { // no rows selected to delete
		
		if (!empty($donotremove)) {
		// do nothing here - do not echo a message because it would be repeated X times
		//$textDB = '<font color="green">'.sprintf(__('DB Rows %s Not Removed', 'bulletproof-security'), $donotremove).'</font>';
		}
		break;
	} // end switch
}

if ( !empty($textSecLogRemove) ) { 
echo '<div id="message" class="updated" style="border:1px solid #999999; margin-left:70px;background-color:#ffffe0;"><p>'.$textSecLogRemove.'</p></div>'; 
}
?>

<!-- Dynamic User Agent/Bot Radio Button Remove Form -->
<form name="bpsSecLogRadio" action="admin.php?page=bulletproof-security/admin/security-log/security-log.php" method="post">
<?php 
	wp_nonce_field('bulletproof_security_seclog_db_remove');

	$bpspro_seclog_table = $wpdb->prefix . "bpspro_seclog_ignore";
	$search = @$_POST['userAgentSearchRemove'];

	if ( isset($_POST['Submit-SecLog-Search']) ) {

	$getSecLogTableSearchForm = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $bpspro_seclog_table WHERE user_agent_bot LIKE %s", "%$search%") );
		
		echo '<h3>'.__('Search Results For User Agents/Bots To Remove', 'bulletproof-security').'</h3>';	
		echo '<table class="widefat" style="margin-bottom:20px;width:675px;">';
		echo '<thead>';
		echo '<tr>';
		echo '<th scope="col" style="width:20%;"><strong>'.__('User Agents/Bots in DB', 'bulletproof-security').'</strong></th>';
		echo '<th scope="col" style="width:7%;"><strong>'.__('Remove', 'bulletproof-security').'</strong></th>';
		echo '<th scope="col" style="width:7%;"><strong>'.__('Do Not<br>Remove', 'bulletproof-security').'</strong></th>';
		echo '<th scope="col" style="width:10%;"><strong>'.__('Time Added<br>To DB', 'bulletproof-security').'</strong></th>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
		echo '<tr>';
		
		foreach ($getSecLogTableSearchForm as $row) {
		
		echo '<th scope="row" style="border-bottom:none;">'.$row->user_agent_bot.'</th>';
		echo "<td><input type=\"radio\" id=\"remove\" name=\"removeornot[$row->user_agent_bot]\" value=\"remove\" /></td>";
		echo "<td><input type=\"radio\" id=\"donotremove\" name=\"removeornot[$row->user_agent_bot]\" value=\"donotremove\" checked /></td>";
		echo '<td>'.$row->time.'</td>'; 
		echo '</tr>';			
		}
		echo '</tbody>';
		echo '</table>';	
		if ($wpdb->num_rows != 0) {		
		echo $bps_topDiv;
		$text = '<font color="green"><strong>'.__('Your DB Search Results For User Agents/Bots To Remove are displayed below the Remove / Allow Search tool.', 'bulletproof-security').'</strong></font><br>';
		echo $text;
		} else {
		echo $bps_topDiv;
		$text = '<font color="blue"><strong>'.__('You do not have any User Agents/Bots in your DB To Remove. An empty/blank dynamic radio button form is displayed below the Remove / Allow Search tool since you do not have any User Agents/Bot to remove.', 'bulletproof-security').'</strong></font><br>';
		echo $text;
		}
	echo $bps_bottomDiv;

?>
<input type="submit" name="Submit-SecLog-Remove" value="<?php _e('Remove', 'bulletproof-security'); ?>" class="bps-blue-button" onclick="return confirm('<?php $text = __('Clicking OK will Remove the User Agent/Bot DB entries for any Remove Radio button selections you have made. User Agents/Bots will also be removed from the 403.php Security Logging template.', 'bulletproof-security').'\n\n'.$bpsSpacePop.'\n\n'.__('To add a User Agent/Bot, use the Add / Ignore tool.', 'bulletproof-security').'\n\n'.$bpsSpacePop.'\n\n'.__('Click OK to proceed or click Cancel.', 'bulletproof-security'); echo $text; ?>')" />
</form><br />
<?php } 
/*************************************/
//   END Dynamic Security Log Form   //
/*************************************/
?>

<div id="messageinner" class="updatedinner" style="width:690px;">

<?php
// Get BPS Security log file contents
function bps_get_security_log() {
if (current_user_can('manage_options')) {
$bps_sec_log = WP_CONTENT_DIR . '/bps-backup/logs/http_error_log.txt';
	
	if (file_exists($bps_sec_log)) {
		$bps_sec_log = file_get_contents($bps_sec_log);
	return esc_html($bps_sec_log);
	
	} else {
		_e('The Security Log File Was Not Found! Check that the file really exists here - /', 'bulletproof-security').$bps_wpcontent_dir.__('/bps-backup/logs/http_error_log.txt and is named correctly.', 'bulletproof-security');
	}
	}
}

// Form - Security Log - Perform File Open and Write test - If append write test is successful write to file
if (current_user_can('manage_options')) {
$bps_sec_log = WP_CONTENT_DIR . '/bps-backup/logs/http_error_log.txt';
$write_test = "";
	
	if (is_writable($bps_sec_log)) {
    if (!$handle = fopen($bps_sec_log, 'a+b')) {
    	exit;
    }
    if (fwrite($handle, $write_test) === FALSE) {
		exit;
    }
	$text = '<font color="green"><strong>'.__('File Open and Write test successful! Your Security Log file is writable.', 'bulletproof-security').'</strong></font><br>';
	echo $text;
	}
	}
	
	if (isset($_POST['submit-security-log']) && current_user_can('manage_options')) {
		check_admin_referer( 'bulletproof_security_save_security_log' );
		$newcontentSecLog = stripslashes($_POST['newcontentSecLog']);
	if ( is_writable($bps_sec_log) ) {
		$handle = fopen($bps_sec_log, 'w+b');
		fwrite($handle, $newcontentSecLog);
	$text = '<font color="green"><strong>'.__('Success! Your Security Log file has been updated.', 'bulletproof-security').'</strong></font><br>';
	echo $text;	
    fclose($handle);
	}
}
$scrolltoSecLog = isset($_REQUEST['scrolltoSecLog']) ? (int) $_REQUEST['scrolltoSecLog'] : 0;
?>
</div>

<div id="SecLogEditor">
<form name="bpsSecLog" id="bpsSecLog" action="admin.php?page=bulletproof-security/admin/security-log/security-log.php" method="post">
<?php wp_nonce_field('bulletproof_security_save_security_log'); ?>
<div id="bpsSecLog">
    <textarea class="bps-text-area-600x700" name="newcontentSecLog" id="newcontentSecLog" tabindex="1"><?php echo bps_get_security_log(); ?></textarea>
	<input type="hidden" name="scrolltoSecLog" id="scrolltoSecLog" value="<?php echo esc_html($scrolltoSecLog); ?>" />
    <p class="submit">
	<input type="submit" name="submit-security-log" class="bps-blue-button" value="<?php esc_attr_e('Update File', 'bulletproof-security') ?>" /></p>
</div>
</form>
<script type="text/javascript">
/* <![CDATA[ */
jQuery(document).ready(function($){
	$('#bpsSecLog').submit(function(){ $('#scrolltoSecLog').val( $('#newcontentSecLog').scrollTop() ); });
	$('#newcontentSecLog').scrollTop( $('#scrolltoSecLog').val() ); 
});
/* ]]> */
</script>
</div>

</td>
  </tr>
  <tr>
    <td class="bps-table_cell_bottom">&nbsp;</td>
  </tr>
</table>

</div>

<div id="bps-tabs-2" class="bps-tab-page">
<h2><?php _e('BulletProof Security Help &amp; FAQ', 'bulletproof-security'); ?></h2>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="bps-help_faq_table">
   <tr>
    <td colspan="2" class="bps-table_title">&nbsp;</td>
  </tr>
  <tr>
    <td width="50%" class="bps-table_cell_help"><a href="http://forum.ait-pro.com/forums/forum/bulletproof-security-free/" target="_blank"><?php _e('BulletProof Security Forum', 'bulletproof-security'); ?></a></td>
    <td width="50%" class="bps-table_cell_help"><a href="http://www.ait-pro.com/aitpro-blog/category/bulletproof-security-contributors/" target="_blank"><?php _e('Contributors Page', 'bulletproof-security'); ?></a></td>
  </tr>
  <tr>
    <td class="bps-table_cell_help"><a href="http://www.ait-pro.com/aitpro-blog/2252/bulletproof-security-plugin-support/checking-plugin-compatibility-with-bps-plugin-testing-to-do-list/" target="_blank"><?php _e('Plugin Compatibility Testing - Recent New Permanent Plugin Fixes', 'bulletproof-security'); ?></a></td>
    <td class="bps-table_cell_help">&nbsp;</td>
  </tr>
  <tr>
    <td class="bps-table_cell_help">&nbsp;</td>
    <td class="bps-table_cell_help">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="bps-table_cell_bottom">&nbsp;</td>
  </tr>
</table>
</div>
         
<div id="AITpro-link">BulletProof Security <?php echo BULLETPROOF_VERSION; ?> Plugin by <a href="http://www.ait-pro.com/" target="_blank" title="AITpro Website Security">AITpro Website Security</a>
</div>
</div>
</div>