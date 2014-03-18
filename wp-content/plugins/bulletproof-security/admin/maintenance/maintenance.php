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

<h2 style="margin-left:70px;">
<?php 
if ( is_multisite() && $blog_id != 1 ) {
_e('BulletProof Security ~ Maintenance Mode', 'bulletproof-security');
} else {
_e('Maintenance Mode ~ FrontEnd ~ BackEnd', 'bulletproof-security');
}
?>
</h2>

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

// Preview - write a new denyall htaccess file with the user's current IP address
// on Network sites if 2 users with 2 different ips are using mmode this will be a problem 
// see what happens and then beef this function up if needed
function bpsPro_maintenance_mode_preview_ip() {

	if ( current_user_can('manage_options') ) {
	
	$ip = $_SERVER['REMOTE_ADDR'];
	$denyall_htaccess_file = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/.htaccess';
	
	if ( file_exists($denyall_htaccess_file) ) {
	
		file_put_contents( $denyall_htaccess_file, "order deny,allow\ndeny from all\nallow from $ip" );
	}
	}
}
bpsPro_maintenance_mode_preview_ip();

$bpsSpacePop = '-------------------------------------------------------------';

// Replace ABSPATH = wp-content/plugins
$bps_plugin_dir = str_replace( ABSPATH, '', WP_PLUGIN_DIR);
// Replace ABSPATH = wp-content
$bps_wpcontent_dir = str_replace( ABSPATH, '', WP_CONTENT_DIR);
// Top div echo & bottom div echo
$bps_topDiv = '<div id="message" class="updated" style="border:1px solid #999999;margin-left:220px;background-color:#ffffe0;"><p>';
$bps_bottomDiv = '</p></div>';
?>
</div>

<!-- jQuery UI Tab Menu -->
<div id="bps-container">
	<div id="bps-tabs" class="bps-menu">
    <div id="bpsHead" style="position:relative; top:0px; left:0px;"><img src="<?php echo plugins_url('/bulletproof-security/admin/images/bps-security-shield.png'); ?>" style="float:left; padding:0px 8px 0px 0px; margin:-72px 0px 0px 0px;" /></div>
		<ul>
			<li><a href="#bps-tabs-1"><?php _e('Maintenance Mode', 'bulletproof-security'); ?></a></li>
            <li><a href="#bps-tabs-2"><?php _e('Help &amp; FAQ', 'bulletproof-security'); ?></a></li>
		</ul>
            
<div id="bps-tabs-1" class="bps-tab-page">
<h2>
<?php
if ( is_multisite() && $blog_id != 1 ) {
_e('Display FrontEnd Maintenance Mode Page', 'bulletproof-security');
} else {
_e('FrontEnd ~ Display Maintenance Mode Page / BackEnd ~ Lock BackEnd with Deny All htaccess Protection', 'bulletproof-security'); 
}
?>
</h2>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="bps-help_faq_table">
  <tr>
    <td class="bps-table_title">&nbsp;</td>
  </tr>
  <tr>
    <td class="bps-table_cell_help">

<h3><?php _e('Maintenance Mode', 'bulletproof-security'); ?>  <button id="bps-open-modal1" class="bps-modal-button"><?php _e('Read Me', 'bulletproof-security'); ?></button></h3>

<div id="bps-modal-content1" style="background-color:#fff; padding:0px 10px 10px 10px;" title="<?php _e('Maintenance Mode', 'bulletproof-security'); ?>">
	<p><?php $text = '<strong>'.__('This Read Me Help window is draggable (top) and resizable (bottom right corner)', 'bulletproof-security').'</strong><br><br><strong>'.__('Select your options/settings, click the Save Options button, Preview your Maintenance Mode page and click the Turn On button. Rinse and repeat if you make any new changes to your options/settings.', 'bulletproof-security').'</strong><br><br><strong>'.__('For more extensive help info or CSS Code, Image & Video Embed examples to add in the Maintenance Mode Text, CSS Style Code, Images, Videos Displayed To Website Visitors text area go to this Maintenance Mode Guide Forum Topic link: http://forum.ait-pro.com/forums/topic/maintenance-mode-guide-read-me-first/.', 'bulletproof-security').'</strong><br><br><strong>'.__('Enable Countdown Timer:', 'bulletproof-security').'</strong><br>'.__('Check this checkbox to enable a javascript Countdown Timer that will be displayed to visitors.', 'bulletproof-security').'<br><br><strong>'.__('Countdown Timer Text Color:', 'bulletproof-security').'</strong><br>'.__('Select the text color for the Countdown Timer.', 'bulletproof-security').'<br><br><strong>'.__('Maintenance Mode Time (in Minutes):', 'bulletproof-security').'</strong><br>'.__('Enter the amount of time that you want to put your site into Maintenance Mode in minutes. Example: 10 = 10 minutes, 180 = 3 hours, 1440 = 24 hours, 4320 = 3 days.', 'bulletproof-security').'<br><br><strong>'.__('Header Retry-After (enter the same time as Maintenance Mode Time above):', 'bulletproof-security').'</strong><br>'.__('This is the amount of time that you are telling Search Engines to wait before visiting your website again. Enter the same time in minutes that you entered for Maintenance Mode Time.', 'bulletproof-security').'<br><br><strong>'.__('Enable FrontEnd Maintenance Mode:', 'bulletproof-security').'</strong><br>'.__('Check this checkbox to enable FrontEnd Maintenance Mode. When you Turn On FrontEnd Maintenance Mode your website Maintenance Mode page will be displayed to website visitors instead of your website. Hint: besides using Preview to see what your site will look like to visitors you can also not enter your IP address in the Maintenance Mode IP Address Whitelist Text Box - CAUTION: do not enable BackEnd Maintenance Mode if you do that or you will be locked out of your WordPress Dashboard.', 'bulletproof-security').'<br><br><strong>'.__('Enable BackEnd Maintenance Mode:', 'bulletproof-security').'</strong><br>'.__('Check this checkbox to enable BackEnd Maintenance Mode. Be sure to enter the Your IP address/the Recommended IP address in the Maintenance Mode IP Address Whitelist Text Box before you click the Save Options button and click the Turn On button. If you Turn On BackEnd Maintenance Mode and your IP address is not entered and saved then you will be locked out of your WordPress Dashboard. To get back into your WordPress Dashboard, FTP to your website and delete the /wp-admin/.htaccess file to be able to log back into your WordPress Dashboard.', 'bulletproof-security').'<br><br><strong>'.__('Maintenance Mode IP Address Whitelist Text Box:', 'bulletproof-security').'</strong><br>'.__('Enter The IP Address That Can View The Website Normally (not in Maintenance Mode):', 'bulletproof-security').'<br>'.__('Enter Multiple IP addresses separated by a comma and a single space. Example: 100.99.88.77, 200.66.55.44, 44.33.22.1 It is recommended that you use the Recommended IP address that is displayed to you. IP addresses are dynamic and will be changed frequently by your ISP. The Recommended IP address is 3 octets (xxx.xxx.xxx.) of your IP address instead of 4 octets (xxx.xxx.xxx.xxx). ISP\'s typically only change the 4th octet of IP addresses that are assigned to you. You can use/enter either 1 octet, 2 octets, 3 octets or your current IP address to whitelist your IP address.', 'bulletproof-security').'<br><br><strong>'.__('Maintenance Mode Text, CSS Style Code, Images, Videos Displayed To Website Visitors:', 'bulletproof-security').'</strong><br>'.__('This text box allows you to enter plain text, CSS or HTML code. You can embed images or YouTube videos using CSS and HTML code. For CSS and HTML code examples that you can copy and paste into this text box go to this Maintenance Mode Guide Forum Topic link: http://forum.ait-pro.com/forums/topic/maintenance-mode-guide-read-me-first/. After you cppy and paste the code into this text box, edit it and change the links or whatever else you want to modify and click the Save Options button to save your edits.', 'bulletproof-security').'<br><br><strong>'.__('Background Images:', 'bulletproof-security').'</strong><br>'.__('Select a background image that you want to use. BPS includes 20 background images and 15 center images (text box images) that you can mix and match to your design/color scheme preference.', 'bulletproof-security').'<br><br><strong>'.__('Center Images:', 'bulletproof-security').'</strong>'.__('Select a center image that you want to use. BPS includes 20 background images and 15 center images (text box images) that you can mix and match to your design/color scheme preference.', 'bulletproof-security').'<br><br><strong>'.__('Background Colors (If not using a Background Image):', 'bulletproof-security').'</strong><br>'.__('Select a background color that you want to use. If you do not want to use a background image then you can instead choose a background color.', 'bulletproof-security').'<br><strong>'.__('Display Visitor IP Address:', 'bulletproof-security').'</strong>'.__('Check this checkbox to display the website visitor\'s IP addresses.', 'bulletproof-security').'<br><br><strong>'.__('Display Admin/Login Link', 'bulletproof-security').'</strong><br>'.__('Check this checkbox to display a Login link that points to your wp-admin folder/Login page.', 'bulletproof-security').'<br><br><strong>'.__('Display Dashboard Reminder Message when site is in Maintenance Mode:', 'bulletproof-security').'</strong><br>'.__('Check this checkbox to display a WordPress Dashboard Reminder Notice that your website is in Maintenance Mode.', 'bulletproof-security').'<br><br><strong>'.__('Send Email Reminder when Maintenance Mode Countdown Timer has completed:', 'bulletproof-security').'</strong><br>'.__('Check this checkbox to enable the javascript Countdown Timer to send you an email reminder when the Countdown Timer reaches 0 / is completed. More importantly when this option is selected you will receive another email reminder each time a visitor visits your website.', 'bulletproof-security').'<br><br><strong>'.__('Testing the Countdown Timer Send Email Option:', 'bulletproof-security').'</strong><br>'.__('There is a 1 minute buffer so that when the Maintenance Mode page is created an email will not be sent immediately. To test the Send Email option use 2 minutes for the Maintenance Mode Time, click the Save Options button and click the Preview button. Leave the Preview Browser Window/Tab open. When the Countdown Timer has completed (reached 0) an email will be sent. You may receive the email immediately or it may take several minutes depending on how fast your Mail Server sends the email to you.', 'bulletproof-security').'<br><br><strong>'.__('Send Countdown Timer Email:', 'bulletproof-security').'</strong><br>'.__('Enter the email addresses that you would like the Countdown Timer reminder email sent to, from, cc or bcc.', 'bulletproof-security').'<br><br><strong>'.__('Network/Multisite Primary Site Options ONLY:', 'bulletproof-security').'</strong><br>'.__('These options/settings are for Network/Multisite ONLY and are ONLY displayed on the Primary Network/Multisite site. Checking these options on a Single/Standard WordPress installation have no effect since these options are ONLY for Network/Multisite WordPress installations.', 'bulletproof-security').'<br><br><strong>'.__('Put The Primary Site And All Subsites In Maintenance Mode:', 'bulletproof-security').'</strong><br>'.__('Check this checkbox to put all of the sites into Maintenance Mode.', 'bulletproof-security').'<br><br><strong>'.__('Put All Subsites In Maintenance Mode, But Not The Primary Site:', 'bulletproof-security').'</strong><br>'.__('Check this checkbox to put all of the subsites into Maintenance Mode except for the Primary site.', 'bulletproof-security').'<br><br><strong>'.__('Save Options Button', 'bulletproof-security').'</strong><br>'.__('Clicking the Save Options button does 2 things: Saves all your options/settings to your Database and creates all necessary Maintenance Mode files/Forms. Clicking the Save Options button does NOT Turn On Maintenance Mode. Click the Turn On button after clicking the Save Options button.', 'bulletproof-security').'<br><br><strong>'.__('Preview Button', 'bulletproof-security').'</strong><br>'.__('Clicking the Preview button allows you to preview the Maintenance Mode files/Forms that were created when you clicked the Save Options button. Preview allows you to view what will be displayed to visitors to your website when you turn On Maintenance Mode. Maintenance Mode is not turned On when you click the Preview button. Maintenance Mode is turned On by clicking the Turn On button.', 'bulletproof-security').'<br><br><strong>'.__('Turn On Button', 'bulletproof-security').'</strong><br>'.__('Clicking the Turn On button turns On Maintenance Mode. Turn On is conditional and allows you to make changes to your Maintenance Mode page that is displayed to your website visitors. You can make any new changes to your options/settings, click the Save Options button again, click the Turn On button again and your new changes/settings will be immediately displayed on your Maintenance Mode page.', 'bulletproof-security').'<br><br><strong>'.__('Turn Off Button', 'bulletproof-security').'</strong><br>'.__('Clicking the Turn Off button turns Off Maintenance Mode. Turn Off is non-conditional and works like a Form Reset, but does not remove any of your Saved Options/settings. All active/enabled maintenance mode files/Forms are removed from your site and of course maintenance mode is turned Off. If you have a Network/Multisite site then some Maintenance Mode files need to remain in your website root folder, but Maintenance Mode will be turned Off.', 'bulletproof-security').'<br><br><strong>'.__('BPS help links can be found in the Help & FAQ pages.', 'bulletproof-security').'</strong>'; echo $text; ?></p>
</div>

<?php
// Maintenance Mode Values Form Single/GWIOD/Network - Saves DB Options & creates bps-maintenance-values.php
// Uses $current_blog->path for Network file naming bps-maintenance-values-{subsite-uri}.php & bps-maintenance-{subsite-uri}.php
function bpsPro_maintenance_mode_values_form() {
global $current_blog, $blog_id, $bps_topDiv, $bps_bottomDiv;

if (isset($_POST['Submit-Maintenance-Mode-Form']) && current_user_can('manage_options')) {
	check_admin_referer( 'bpsMaintenanceMode' );

$MMoptions = get_option('bulletproof_security_options_maint_mode');

	if ( $MMoptions['bps_maint_on_off'] == 'On' ) {
		$bps_maint_on_off = 'On';
	} else {
		$bps_maint_on_off = 'Off';
	}
	
	if ( is_multisite() && $blog_id != 1 ) {	
		$bps_maint_backend = '';
		$bps_maint_mu_entire_site = '';
		$bps_maint_mu_subsites_only = '';
	
	} else {
		
		$bps_maint_backend = $_POST['mmode_backend'];
		$bps_maint_mu_entire_site = $_POST['mmode_mu_entire_site'];
		$bps_maint_mu_subsites_only = $_POST['mmode_mu_subsites_only'];	
	}
	
	if ( $_POST['mmode_time'] == '' ) {	
		echo $bps_topDiv;
    	$text = '<font color="red"><strong>'.__('Error: You did not enter anything in the Maintenance Mode Time Text Box.', 'bulletproof-security').'</strong></font>';
		echo $text;		
		echo $bps_bottomDiv;
	return;
	}

	if ( $_POST['mmode_ip_allowed'] == '' ) {	
		echo $bps_topDiv;
    	$text = '<font color="red"><strong>'.__('Error: You did not enter an IP Address in the Maintenance Mode IP Address Whitelist Text Box.', 'bulletproof-security').'</strong></font>';
		echo $text;		
		echo $bps_bottomDiv;
	return;
	
	} else {
		
		$bps_maint_ip_allowed = trim( $_POST['mmode_ip_allowed'], ", \t\n\r");		
	}

	$BPS_Options = array(
	'bps_maint_on_off' => $bps_maint_on_off, 
	'bps_maint_countdown_timer' => $_POST['mmode_countdown_timer'], 
	'bps_maint_countdown_timer_color' => $_POST['mmode_countdown_timer_color'], 
	'bps_maint_time' => $_POST['mmode_time'], 
	'bps_maint_retry_after' => $_POST['mmode_retry_after'], 
	'bps_maint_frontend' => $_POST['mmode_frontend'], 
	'bps_maint_backend' => $bps_maint_backend, 
	'bps_maint_ip_allowed' => $bps_maint_ip_allowed, 
	'bps_maint_text' => $_POST['bpscustomeditor'], 
	'bps_maint_background_images' => $_POST['mmode_background_images'], 
	'bps_maint_center_images' => $_POST['mmode_center_images'], 
	'bps_maint_background_color' => $_POST['mmode_background_color'], 
	'bps_maint_show_visitor_ip' => $_POST['mmode_visitor_ip'], 
	'bps_maint_show_login_link' => $_POST['mmode_login_link'], 
	'bps_maint_dashboard_reminder' => $_POST['mmode_dashboard_reminder'], 
	'bps_maint_countdown_email' => $_POST['mmode_countdown_email'], 
	'bps_maint_email_to' => $_POST['mmode_email_to'], 
	'bps_maint_email_from' => $_POST['mmode_email_from'], 
	'bps_maint_email_cc' => $_POST['mmode_email_cc'], 
	'bps_maint_email_bcc' => $_POST['mmode_email_bcc'], 
	'bps_maint_mu_entire_site' => $bps_maint_mu_entire_site, 
	'bps_maint_mu_subsites_only' => $bps_maint_mu_subsites_only
	);	
	
		foreach( $BPS_Options as $key => $value ) {
			update_option('bulletproof_security_options_maint_mode', $BPS_Options);
		}	

	// Get the new saved/updated DB option values for Form processing with current values
	$MMoptions = get_option('bulletproof_security_options_maint_mode');
	$bps_maintenance_file = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/bps-maintenance.php';
	$bps_maintenance_values = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/bps-maintenance-values.php';
	$bps_maint_time = time() + ($MMoptions['bps_maint_time'] * 60);
	$subsite_remove_slashes = str_replace( '/', "", $current_blog->path );
	$bps_maintenance_values_network = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/bps-maintenance-values-'.$subsite_remove_slashes.'.php';
	$subsite_maintenance_file = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/bps-maintenance-'.$subsite_remove_slashes.'.php';

	if ( is_multisite() && $blog_id == '1' ) {
		$primary_site_uri_path = $current_blog->path;
	} else {
		$primary_site_uri_path = '';	
	}
	
$bps_maint_content = '<?php'."\n".'# BEGIN BPS MAINTENANCE MODE'."\n"
.'$bps_maint_countdown_timer = \''.$MMoptions['bps_maint_countdown_timer'].'\';'."\n"
.'$bps_maint_countdown_timer_color = \''.$MMoptions['bps_maint_countdown_timer_color'].'\';'."\n"
.'$bps_maint_time = \''.$bps_maint_time.'\';'."\n"
.'$bps_maint_retry_after = \''.$MMoptions['bps_maint_retry_after'].'\';'."\n"
.'$bps_maint_text = "'.htmlspecialchars_decode($MMoptions['bps_maint_text'], ENT_QUOTES).'";'."\n"
.'$bps_maint_background_images = \''.$MMoptions['bps_maint_background_images'].'\';'."\n"
.'$bps_maint_center_images = \''.$MMoptions['bps_maint_center_images'].'\';'."\n"
.'$bps_maint_background_color = \''.$MMoptions['bps_maint_background_color'].'\';'."\n"
.'$bps_maint_show_visitor_ip = \''.$MMoptions['bps_maint_show_visitor_ip'].'\';'."\n"
.'$bps_maint_show_login_link = \''.$MMoptions['bps_maint_show_login_link'].'\';'."\n"
.'$bps_maint_login_link = \''.get_site_url().'/wp-admin/' .'\';'."\n"
.'$bps_maint_countdown_email = \''.$MMoptions['bps_maint_countdown_email'].'\';'."\n"
.'$bps_maint_email_to = \''.$MMoptions['bps_maint_email_to'].'\';'."\n"
.'$bps_maint_email_from = \''.$MMoptions['bps_maint_email_from'].'\';'."\n"
.'$bps_maint_email_cc = \''.$MMoptions['bps_maint_email_cc'].'\';'."\n"
.'$bps_maint_email_bcc = \''.$MMoptions['bps_maint_email_bcc'].'\';'."\n"
.'# BEGIN BPS MAINTENANCE MODE PRIMARY SITE'."\n"
.'$all_sites = \''.$MMoptions['bps_maint_mu_entire_site'].'\';'."\n"
.'$all_subsites = \''.$MMoptions['bps_maint_mu_subsites_only'].'\';'."\n"
.'$primary_site_uri = \''.$primary_site_uri_path.'\';'."\n"
.'# END BPS MAINTENANCE MODE PRIMARY SITE'."\n"
.'# END BPS MAINTENANCE MODE'."\n".'?>';

	if ( is_multisite() && $blog_id != 1 ) {
		
		$bps_maintenance_file_include = '/#\sBEGIN\sBPS\sINCLUDE(\s*(.*)){3}\s*#\sEND\sBPS\sINCLUDE/';
		
		if ( @copy($bps_maintenance_file, $subsite_maintenance_file) ) {
			$stringReplaceMaint = file_get_contents($subsite_maintenance_file);
		}
		
		if ( preg_match($bps_maintenance_file_include, $stringReplaceMaint, $matches ) ) {
			
			$stringReplaceMaint = preg_replace('/#\sBEGIN\sBPS\sINCLUDE(\s*(.*)){3}\s*#\sEND\sBPS\sINCLUDE/', "# BEGIN BPS INCLUDE\nif ( file_exists( dirname( __FILE__ ) . '/bps-maintenance-values-$subsite_remove_slashes.php' ) ) {\ninclude( dirname( __FILE__ ) . '/bps-maintenance-values-$subsite_remove_slashes.php' );\n}\n# END BPS INCLUDE", $stringReplaceMaint);
		}		

		if ( file_put_contents( $subsite_maintenance_file, $stringReplaceMaint ) ) {
			// ARQ condition not used in BPS free
		}

		@copy($bps_maintenance_values, $bps_maintenance_values_network);
		
		$stringReplace = file_get_contents($bps_maintenance_values_network);
		$stringReplace = $bps_maint_content;

		if ( file_put_contents( $bps_maintenance_values_network, $stringReplace ) ) {
    		
			echo $bps_topDiv;
			$text = '<font color="green"><strong>'.__('Success! Your Options have been saved and your Maintenance Mode Form has been created successfully! Click the Preview button to preview your Website Under Maintenance page. To Enable/Turn On Maintenance Mode click the Turn On button.', 'bulletproof-security').'</strong></font>';
			echo $text;		
			echo $bps_bottomDiv;
		
		} else {
		
			echo $bps_topDiv;
    $text = '<font color="red"><strong>'.__('The file ', 'bulletproof-security').$bps_maintenance_values_network.__(' is not writable or does not exist.', 'bulletproof-security').'</strong></font><br><strong>'.__('Check that the file exists in the /bulletproof-security/admin/htaccess/ master folder. If this is not the problem ', 'bulletproof-security').'<a href="http://forum.ait-pro.com/" target="_blank">'.__('Click Here', 'bulletproof-security').'</a>'.__(' for assistance.', 'bulletproof-security').'</strong>';
			echo $text;		
			echo $bps_bottomDiv;
		}	
	
	} else {
	
		$stringReplace = file_get_contents($bps_maintenance_values);
		$stringReplace = $bps_maint_content;
		
		if ( file_put_contents( $bps_maintenance_values, $stringReplace ) ) {
    		
			echo $bps_topDiv;
			$text = '<font color="green"><strong>'.__('Success! Your Options have been saved and your Maintenance Mode Form has been created successfully! Click the Preview button to preview your Website Under Maintenance page. To Enable/Turn On Maintenance Mode click the Turn On button.', 'bulletproof-security').'</strong></font>';
			echo $text;		
			echo $bps_bottomDiv;
		
		} else {
		
			echo $bps_topDiv;
    $text = '<font color="red"><strong>'.__('The file ', 'bulletproof-security').$bps_maintenance_values.__(' is not writable or does not exist.', 'bulletproof-security').'</strong></font><br><strong>'.__('Check that the bps-maintenance-values.php file exists in the /bulletproof-security/admin/htaccess/ master folder. If this is not the problem ', 'bulletproof-security').'<a href="http://forum.ait-pro.com/" target="_blank">'.__('Click Here', 'bulletproof-security').'</a>'.__(' for assistance.', 'bulletproof-security').'</strong>';
			echo $text;		
			echo $bps_bottomDiv;
		}
	}
}
}

$scrolltommode1 = isset($_REQUEST['scrolltommode1']) ? (int) $_REQUEST['scrolltommode1'] : 0;
//$scrolltommode2 = isset($_REQUEST['scrolltommode2']) ? (int) $_REQUEST['scrolltommode2'] : 0;

// MMODE Background Image Paths
$background_image_url = plugins_url('/bulletproof-security/images/');
$blackHL = $background_image_url.'black-honeycomb-large.png';
$blackHLG = $background_image_url.'black-honeycomb-large-grey-line.png';
$blackMS = $background_image_url.'black-mesh-small.png';
$blackMSG = $background_image_url.'black-mesh-small-grey-line.png';
$blueHL = $background_image_url.'blue-honeycomb-large.png';
$blueMS = $background_image_url.'blue-mesh-small.png';
$brownHL = $background_image_url.'brown-honeycomb-large.png';
$brownMS = $background_image_url.'brown-mesh-small.png';
$greenHL = $background_image_url.'green-honeycomb-large.png';
$greenMS = $background_image_url.'green-mesh-small.png';
$grayHL = $background_image_url.'grey-honeycomb-large.png';
$grayMS = $background_image_url.'grey-mesh-small.png';
$orangeHL = $background_image_url.'orange-honeycomb-large.png';
$orangeMS = $background_image_url.'orange-mesh-small.png';
$purpleHL = $background_image_url.'purple-honeycomb-large.png';
$purpleMS = $background_image_url.'purple-mesh-small.png';
$redHL = $background_image_url.'red-burgundy-honeycomb-large.png';
$redMS = $background_image_url.'red-burgundy-mesh-small.png';
$yellowHL = $background_image_url.'yellow-honeycomb-large.png';
$yellowMS = $background_image_url.'yellow-mesh-small.png';

// MMODE Center Image Paths
$basicBlack = $background_image_url.'basic-black-center.png';
$blackVeins = $background_image_url.'black-veins-center.png';
$blueGlass = $background_image_url.'blue-glass-center.png';
$brushedMetal = $background_image_url.'brush-metal-stamped-center.png';
$chrome = $background_image_url.'chrome-center.png';
$chromeSlick = $background_image_url.'slick-chrome-center.png';
$fire = $background_image_url.'fire-center.png';
$gunMetal = $background_image_url.'gun-metal-center.png';
$mercury = $background_image_url.'mercury-center.png';
$smoke = $background_image_url.'smoke-center.png';
$stripedCone = $background_image_url.'striped-cone-center.png';
$swampBevel = $background_image_url.'swamp-bevel-center.png';
$toy = $background_image_url.'toy-center.png';
$waterReflection = $background_image_url.'water-reflection-center.png';
$woodGrain = $background_image_url.'wood-grain-center.png';

// Get Real IP address & 3 Octets - USE EXTREME CAUTION!!!
function bps_get_proxy_real_ip_address_maint() {
if ( is_admin() && wp_script_is( 'bps-js', $list = 'queue' ) && current_user_can('manage_options') ) {
	
	$pattern = "/\d{1,3}\.\d{1,3}\.\d{1,3}\./";
	
	if ( isset($_SERVER['HTTP_CLIENT_IP'] ) ) {
		$ip = esc_html($_SERVER['HTTP_CLIENT_IP']);
		$octets_ip = preg_match( $pattern, $_SERVER['HTTP_CLIENT_IP'], $matches );
		echo '<font color="blue" style="font-size:14px;"><strong>'.__('Your Current IP Address: ', 'bulletproof-security').$ip.'<br>'.__('Recommended IP Address: ', 'bulletproof-security');
		print_r($matches[0]);
		echo '</strong></font><br>';
	
	} elseif ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		$ip = esc_html($_SERVER['HTTP_X_FORWARDED_FOR']);
		$octets_ip = preg_match( $pattern, $_SERVER['HTTP_X_FORWARDED_FOR'], $matches );
		echo '<font color="blue" style="font-size:14px;"><strong>'.__('Your Current IP Address: ', 'bulletproof-security').$ip.'<br>'.__('Recommended IP Address: ', 'bulletproof-security');
		print_r($matches[0]);
		echo '</strong></font><br>';
	
	} elseif ( isset( $_SERVER['REMOTE_ADDR'] ) ) {
		$ip = esc_html($_SERVER['REMOTE_ADDR']);
		$octets_ip = preg_match( $pattern, $_SERVER['REMOTE_ADDR'], $matches );
		echo '<font color="blue" style="font-size:14px;"><strong>'.__('Your Current IP Address: ', 'bulletproof-security').$ip.'<br>'.__('Recommended IP Address: ', 'bulletproof-security');
		print_r($matches[0]);
		echo '</strong></font><br>';	
	}
}
}	
?>

<div id="Maintenance-Mode" style="position:relative; top:0px; left:0px; margin:0px 0px 0px 0px;">

<form name="bpsMaintenanceMode" action="admin.php?page=bulletproof-security/admin/maintenance/maintenance.php" method="post">
<?php 
wp_nonce_field('bpsMaintenanceMode'); 
bpsPro_maintenance_mode_values_form();
$MMoptions = get_option('bulletproof_security_options_maint_mode');
?>
<div>
	<input type="checkbox" name="mmode_countdown_timer" value="1" <?php checked( $MMoptions['bps_maint_countdown_timer'], 1 ); ?> /><label for="mmode"><?php _e('Enable Countdown Timer', 'bulletproof-security'); ?></label><br /><br />
    
    <label for="mmode"><?php _e('Countdown Timer Text Color:', 'bulletproof-security'); ?></label><br />
<select name="mmode_countdown_timer_color" style="width:300px;">
<option value="lime" <?php selected('lime', $MMoptions['bps_maint_countdown_timer_color']); ?>><?php _e('LCD/Lime Green', 'bulletproof-security'); ?></option>
<option value="white" <?php selected('white', $MMoptions['bps_maint_countdown_timer_color']); ?>><?php _e('White', 'bulletproof-security'); ?></option>
<option value="silver" <?php selected('silver', $MMoptions['bps_maint_countdown_timer_color']); ?>><?php _e('Silver', 'bulletproof-security'); ?></option>
<option value="gray" <?php selected('gray', $MMoptions['bps_maint_countdown_timer_color']); ?>><?php _e('Gray', 'bulletproof-security'); ?></option>
</select><br /><br />

    <label for="mmode"><?php _e('Maintenance Mode Time (in Minutes):', 'bulletproof-security'); ?></label><br />
    <label for="mmode"><?php _e('Example: 10 = 10 minutes, 180 = 3 hours, 1440 = 24 hours.', 'bulletproof-security'); ?></label><br />
    <input type="text" name="mmode_time" class="regular-text-short-fixed" style="width:250px;" value="<?php echo $MMoptions['bps_maint_time']; ?>" /><br /><br />
    
    <label for="mmode"><?php _e('Header Retry-After (enter the same time as Maintenance Mode Time above):', 'bulletproof-security'); ?></label><br />
    <label for="mmode"><?php _e('Example: 10 = 10 minutes, 180 = 3 hours, 1440 = 24 hours.', 'bulletproof-security'); ?></label><br />
    <input type="text" name="mmode_retry_after" class="regular-text-short-fixed" style="width:250px;" value="<?php echo $MMoptions['bps_maint_retry_after']; ?>" /><br /><br />   
     
	<input type="checkbox" name="mmode_frontend" value="1" <?php checked( $MMoptions['bps_maint_frontend'], 1 ); ?> /><label for="mmode"><?php _e('Enable FrontEnd Maintenance Mode', 'bulletproof-security'); ?></label><br /><br />    
    
<?php if ( is_multisite() && $blog_id != 1 ) { echo '<div style="margin:0px 0px 0px 0px;"></div>'; } else { ?>
	<!-- Delete Me - leave this style inline for 1 BPS Pro version -->	
    <div id="mmode-caution" style="font-weight:bold;margin:0px 0px 10px 0px;border:2px solid #000;width:400px;background-color:#ffffe0;padding:5px;">
    <label for="mmode"><?php $text = '<font color="red">'.__('CAUTION: ', 'bulletproof-security').'</font><font color="blue">'.__('You MUST enter Your Current IP Address or the', 'bulletproof-security').'<br>'.__('Recommended IP Address if you Enable BackEnd Maintenance Mode', 'bulletproof-security').'<br>'.__('or you will be locked out of your WordPress Dashboard.', 'bulletproof-security').'</font>'; echo $text; ?></label></div>
    <input type="checkbox" name="mmode_backend" value="1" <?php checked( $MMoptions['bps_maint_backend'], 1 ); ?> /><label for="mmode"><?php _e('Enable BackEnd Maintenance Mode ', 'bulletproof-security'); ?></label><br /><br />        
<?php } ?>    

    <!-- important note: in a text area you cannot leave whitespace within the form code or that whitespace will be echoed -->
	<label for="mmode"><?php _e('Maintenance Mode IP Address Whitelist Text Box:', 'bulletproof-security'); ?></label><br />
	<label for="mmode"><?php _e('Enter The IP Address That Can View The Website Normally (not in Maintenance Mode).', 'bulletproof-security'); ?></label><br />
	<label for="mmode"><?php _e('Enter Multiple IP addresses separated by a comma and a single space.', 'bulletproof-security'); ?></label><br />
	<label for="mmode"><?php _e('Example: 100.99.88.77, 200.66.55.44, 44.33.22.1', 'bulletproof-security'); ?></label><br />
    <?php bps_get_proxy_real_ip_address_maint(); ?>
	<input type="hidden" name="scrolltommode1" id="scrolltommode1" value="<?php echo $scrolltommode1; ?>" />
    <!-- Delete Me - leave this style inline for 1 BPS Pro version -->
    <textarea class="PFW-Allow-From-Text-Area" style="width:400px; height:100px; margin-top:5px;" name="mmode_ip_allowed" id="mmode_ip_allowed" tabindex="1"><?php echo trim( $MMoptions['bps_maint_ip_allowed'], ", \t\n\r"); ?></textarea><br /><br />

    <label for="mmode"><?php _e('Maintenance Mode Text, CSS Style Code, Images, Videos Displayed To Website Visitors:', 'bulletproof-security'); ?></label><br />
    <label for="mmode"><?php _e('Click the Maintenance Mode Guide link below for CSS Code, Image & Video Embed examples.', 'bulletproof-security'); ?></label><br />
    <label for="mmode"><?php $text = '<div style="margin:0px 0px -10px 0px;"><strong><a href="http://forum.ait-pro.com/forums/topic/maintenance-mode-guide-read-me-first/" target="_blank" title="Link opens in a new Browser window">'.__('Maintenance Mode Guide', 'bulletproof-security').'</a></strong></div>'; echo $text; ?></label><br />
	
 	<!-- Delete Me - leave this style inline for 1 BPS Pro version -->
    <div class="mmode-tinymce" style="width:50%">
	<?php wp_editor( stripslashes(htmlspecialchars_decode($MMoptions['bps_maint_text'], ENT_QUOTES)), 'bpscustomeditor' ); ?><br />
    </div>    

    <label for="mmode"><?php _e('Background Images:', 'bulletproof-security'); ?></label><br />
<select name="mmode_background_images" style="width:300px;">
<option value="0" <?php selected('0', $MMoptions['bps_maint_background_images']); ?>><?php _e('No Background Image', 'bulletproof-security'); ?></option>
<option value="<?php echo $blackHL; ?>" <?php selected($blackHL, $MMoptions['bps_maint_background_images']); ?>><?php _e('Black Honeycomb Large', 'bulletproof-security'); ?></option>
<option value="<?php echo $blackHLG; ?>" <?php selected($blackHLG, $MMoptions['bps_maint_background_images']); ?>><?php _e('Black Honeycomb Large Grey Line', 'bulletproof-security'); ?></option>
<option value="<?php echo $blackMS; ?>" <?php selected($blackMS, $MMoptions['bps_maint_background_images']); ?>><?php _e('Black Mesh Small', 'bulletproof-security'); ?></option>
<option value="<?php echo $blackMSG; ?>" <?php selected($blackMSG, $MMoptions['bps_maint_background_images']); ?>><?php _e('Black Mesh Small Grey Line', 'bulletproof-security'); ?></option>
<option value="<?php echo $blueHL; ?>" <?php selected($blueHL, $MMoptions['bps_maint_background_images']); ?>><?php _e('Blue Honeycomb Large', 'bulletproof-security'); ?></option>
<option value="<?php echo $blueMS; ?>" <?php selected($blueMS, $MMoptions['bps_maint_background_images']); ?>><?php _e('Blue Mesh Small', 'bulletproof-security'); ?></option>
<option value="<?php echo $brownHL; ?>" <?php selected($brownHL, $MMoptions['bps_maint_background_images']); ?>><?php _e('Brown Honeycomb Large', 'bulletproof-security'); ?></option>
<option value="<?php echo $brownMS; ?>" <?php selected($brownMS, $MMoptions['bps_maint_background_images']); ?>><?php _e('Brown Mesh Small', 'bulletproof-security'); ?></option>
<option value="<?php echo $greenHL; ?>" <?php selected($greenHL, $MMoptions['bps_maint_background_images']); ?>><?php _e('Green Honeycomb Large', 'bulletproof-security'); ?></option>
<option value="<?php echo $greenMS; ?>" <?php selected($greenMS, $MMoptions['bps_maint_background_images']); ?>><?php _e('Green Mesh Small', 'bulletproof-security'); ?></option>
<option value="<?php echo $grayHL; ?>" <?php selected($grayHL, $MMoptions['bps_maint_background_images']); ?>><?php _e('Gray Honeycomb Large', 'bulletproof-security'); ?></option>
<option value="<?php echo $grayMS; ?>" <?php selected($grayMS, $MMoptions['bps_maint_background_images']); ?>><?php _e('Gray Mesh Small', 'bulletproof-security'); ?></option>
<option value="<?php echo $orangeHL; ?>" <?php selected($orangeHL, $MMoptions['bps_maint_background_images']); ?>><?php _e('Orange Honeycomb Large', 'bulletproof-security'); ?></option>
<option value="<?php echo $orangeMS; ?>" <?php selected($orangeMS, $MMoptions['bps_maint_background_images']); ?>><?php _e('Orange Mesh Small', 'bulletproof-security'); ?></option>
<option value="<?php echo $purpleHL; ?>" <?php selected($purpleHL, $MMoptions['bps_maint_background_images']); ?>><?php _e('Purple Honeycomb Large', 'bulletproof-security'); ?></option>
<option value="<?php echo $purpleMS; ?>" <?php selected($purpleMS, $MMoptions['bps_maint_background_images']); ?>><?php _e('Purple Mesh Small', 'bulletproof-security'); ?></option>
<option value="<?php echo $redHL; ?>" <?php selected($redHL, $MMoptions['bps_maint_background_images']); ?>><?php _e('Red/Burgundy Honeycomb Large', 'bulletproof-security'); ?></option>
<option value="<?php echo $redMS; ?>" <?php selected($redMS, $MMoptions['bps_maint_background_images']); ?>><?php _e('Red/Burgundy Mesh Small', 'bulletproof-security'); ?></option>
<option value="<?php echo $yellowHL; ?>" <?php selected($yellowHL, $MMoptions['bps_maint_background_images']); ?>><?php _e('Yellow Honeycomb Large', 'bulletproof-security'); ?></option>
<option value="<?php echo $yellowMS; ?>" <?php selected($yellowMS, $MMoptions['bps_maint_background_images']); ?>><?php _e('Yellow Mesh Small', 'bulletproof-security'); ?></option>
</select><br /><br />    

    <label for="mmode"><?php _e('Center Images:', 'bulletproof-security'); ?></label><br />
<select name="mmode_center_images" style="width:300px;">
<option value="0" <?php selected('0', $MMoptions['bps_maint_center_images']); ?>><?php _e('No Center Image', 'bulletproof-security'); ?></option>
<option value="<?php echo $basicBlack; ?>" <?php selected($basicBlack, $MMoptions['bps_maint_center_images']); ?>><?php _e('Basic Black', 'bulletproof-security'); ?></option>
<option value="<?php echo $blackVeins; ?>" <?php selected($blackVeins, $MMoptions['bps_maint_center_images']); ?>><?php _e('Black Veins', 'bulletproof-security'); ?></option>
<option value="<?php echo $blueGlass; ?>" <?php selected($blueGlass, $MMoptions['bps_maint_center_images']); ?>><?php _e('Blue Glass', 'bulletproof-security'); ?></option>
<option value="<?php echo $brushedMetal; ?>" <?php selected($brushedMetal, $MMoptions['bps_maint_center_images']); ?>><?php _e('Brushed Metal Stamped', 'bulletproof-security'); ?></option>
<option value="<?php echo $chrome; ?>" <?php selected($chrome, $MMoptions['bps_maint_center_images']); ?>><?php _e('Chrome', 'bulletproof-security'); ?></option>
<option value="<?php echo $chromeSlick; ?>" <?php selected($chromeSlick, $MMoptions['bps_maint_center_images']); ?>><?php _e('Chrome Slick', 'bulletproof-security'); ?></option>
<option value="<?php echo $fire; ?>" <?php selected($fire, $MMoptions['bps_maint_center_images']); ?>><?php _e('Fire', 'bulletproof-security'); ?></option>
<option value="<?php echo $gunMetal; ?>" <?php selected($gunMetal, $MMoptions['bps_maint_center_images']); ?>><?php _e('Gun Metal', 'bulletproof-security'); ?></option>
<option value="<?php echo $mercury; ?>" <?php selected($mercury, $MMoptions['bps_maint_center_images']); ?>><?php _e('Mercury', 'bulletproof-security'); ?></option>
<option value="<?php echo $smoke; ?>" <?php selected($smoke, $MMoptions['bps_maint_center_images']); ?>><?php _e('Smoke', 'bulletproof-security'); ?></option>
<option value="<?php echo $stripedCone; ?>" <?php selected($stripedCone, $MMoptions['bps_maint_center_images']); ?>><?php _e('Striped Cone', 'bulletproof-security'); ?></option>
<option value="<?php echo $swampBevel; ?>" <?php selected($swampBevel, $MMoptions['bps_maint_center_images']); ?>><?php _e('Swamp Bevel', 'bulletproof-security'); ?></option>
<option value="<?php echo $toy; ?>" <?php selected($toy, $MMoptions['bps_maint_center_images']); ?>><?php _e('Toy', 'bulletproof-security'); ?></option>
<option value="<?php echo $waterReflection; ?>" <?php selected($waterReflection, $MMoptions['bps_maint_center_images']); ?>><?php _e('Water Reflection', 'bulletproof-security'); ?></option>
<option value="<?php echo $woodGrain; ?>" <?php selected($woodGrain, $MMoptions['bps_maint_center_images']); ?>><?php _e('Wood Grain', 'bulletproof-security'); ?></option>
</select><br /><br />    

    <label for="mmode"><?php _e('Background Colors (If not using a Background Image):', 'bulletproof-security'); ?></label><br />
<select name="mmode_background_color" style="width:300px;">
<option value="white" <?php selected('white', $MMoptions['bps_maint_background_color']); ?>><?php _e('No Background Color', 'bulletproof-security'); ?></option>
<option value="white" <?php selected('white', $MMoptions['bps_maint_background_color']); ?>><?php _e('White', 'bulletproof-security'); ?></option>
<option value="black" <?php selected('black', $MMoptions['bps_maint_background_color']); ?>><?php _e('Black', 'bulletproof-security'); ?></option>
<option value="gray" <?php selected('gray', $MMoptions['bps_maint_background_color']); ?>><?php _e('Gray', 'bulletproof-security'); ?></option>
</select><br /><br />

    <input type="checkbox" name="mmode_visitor_ip" value="1" <?php checked( $MMoptions['bps_maint_show_visitor_ip'], 1 ); ?> /><label for="mmode"><?php _e('Display Visitor IP Address', 'bulletproof-security'); ?></label><br /><br />
	
    <input type="checkbox" name="mmode_login_link" value="1" <?php checked( $MMoptions['bps_maint_show_login_link'], 1 ); ?> /><label for="mmode"><?php _e('Display Admin/Login Link', 'bulletproof-security'); ?></label><br /><br />

    <input type="checkbox" name="mmode_dashboard_reminder" value="1" <?php checked( $MMoptions['bps_maint_dashboard_reminder'], 1 ); ?> /><label for="mmode"><?php _e('Display Dashboard Reminder Message when site is in Maintenance Mode', 'bulletproof-security'); ?></label><br /><br />

	<input type="checkbox" name="mmode_countdown_email" value="1" <?php checked( $MMoptions['bps_maint_countdown_email'], 1 ); ?> /><label for="mmode"><?php _e('Send Email Reminder when Maintenance Mode Countdown Timer has completed', 'bulletproof-security'); ?></label><br /><br />
    
    <strong><label for="mmode-email"><?php _e('Send Countdown Timer Email To:', 'bulletproof-security'); ?> </label></strong><br />
    <input type="text" name="mmode_email_to" class="regular-text-short-fixed" style="width:250px;" value="<?php echo $MMoptions['bps_maint_email_to']; ?>" /><br />
    <strong><label for="mmode-email"><?php _e('Send Countdown Timer Email From:', 'bulletproof-security'); ?> </label></strong><br />
    <input type="text" name="mmode_email_from" class="regular-text-short-fixed" style="width:250px;" value="<?php echo $MMoptions['bps_maint_email_from']; ?>" /><br />
    <strong><label for="mmode-email"><?php _e('Send Countdown Timer Email Cc:', 'bulletproof-security'); ?> </label></strong><br />
    <input type="text" name="mmode_email_cc" class="regular-text-short-fixed" style="width:250px;" value="<?php echo $MMoptions['bps_maint_email_cc']; ?>" /><br />
    <strong><label for="mmode-email"><?php _e('Send Countdown Timer Email Bcc:', 'bulletproof-security'); ?> </label></strong><br />
    <input type="text" name="mmode_email_bcc" class="regular-text-short-fixed" style="width:250px;" value="<?php echo $MMoptions['bps_maint_email_bcc']; ?>" /><br />

<?php if ( is_multisite() && $blog_id != 1 ) { echo '<div style="margin:0px 0px 10px 0px;"></div>'; } else { ?>

 	<h3><?php _e('Network/Multisite Primary Site Options ONLY', 'bulletproof-security'); ?></h3> 
    <input type="checkbox" name="mmode_mu_entire_site" value="1" <?php checked( $MMoptions['bps_maint_mu_entire_site'], 1 ); ?> /><label for="mmode"><?php _e('Put The Primary Site And All Subsites In Maintenance Mode', 'bulletproof-security'); ?></label><br /><br />

    <input type="checkbox" name="mmode_mu_subsites_only" value="1" <?php checked( $MMoptions['bps_maint_mu_subsites_only'], 1 ); ?> /><label for="mmode"><?php _e('Put All Subsites In Maintenance Mode, But Not The Primary Site', 'bulletproof-security'); ?></label><br /><br />   
    
<?php } ?> 

<p class="submit" style="float:left; margin:0px 10px 10px 0px;">
    <input type="submit" name="Submit-Maintenance-Mode-Form" class="bps-blue-button" value="<?php esc_attr_e('Save Options', 'bulletproof-security') ?>" onclick="return confirm('<?php $text = __('Clicking OK Saves your Options/Settings to your Database and also creates your Maintenance Mode page. Click the Preview button to preview your Maintenance Mode page. After previewing your Maintenance Mode page click the Turn On button to enable Maintenance Mode on your website.', 'bulletproof-security').'\n\n'.$bpsSpacePop.'\n\n'.__('Click OK to proceed or click Cancel.', 'bulletproof-security'); echo $text; ?>')" />
</p>
</div>
</form>
</div>  

<script type="text/javascript">
/* <![CDATA[ */
jQuery(document).ready(function($){
	$('#bpsMaintenanceMode').submit(function(){ $('#scrolltommode1').val( $('#mmode_ip_allowed').scrollTop() ); });
	$('#mmode_ip_allowed').scrollTop( $('#scrolltommode1').val() );
});
/* ]]> */
</script>

<?php
// Maintenance Mode Preview - check Referer
if (isset($_POST['maintenance-mode-preview-submit']) && current_user_can('manage_options')) {
	check_admin_referer( 'bulletproof_security_maintenance_preview' );
}
?>

<?php if ( is_multisite() && $blog_id != 1 ) { $subsite_remove_slashes = str_replace( '/', "", $current_blog->path ); ?>
	
<form name="MaintenanceModePreview" method="post" action="admin.php?page=bulletproof-security/admin/maintenance/maintenance.php" target="" onSubmit="window.open('<?php echo plugins_url('/bulletproof-security/admin/htaccess/bps-maintenance-'.$subsite_remove_slashes.'.php'); ?>','','scrollbars=yes,menubar=yes,width=800,height=600,resizable=yes,status=yes,toolbar=yes')">
<?php wp_nonce_field('bulletproof_security_maintenance_preview'); ?>
<p class="submit" style="float:left; margin:0px 10px 0px 0px;">
<input type="submit" name="maintenance-mode-preview-submit" class="bps-blue-button" value="<?php esc_attr_e('Preview', 'bulletproof-security') ?>" />
</p>
</form>

<?php } else { ?>
		
<form name="MaintenanceModePreview" method="post" action="admin.php?page=bulletproof-security/admin/maintenance/maintenance.php" target="" onSubmit="window.open('<?php echo plugins_url('/bulletproof-security/admin/htaccess/bps-maintenance.php'); ?>','','scrollbars=yes,menubar=yes,width=800,height=600,resizable=yes,status=yes,toolbar=yes')">
<?php wp_nonce_field('bulletproof_security_maintenance_preview'); ?>
<p class="submit" style="float:left; margin:0px 10px 0px 0px;">
<input type="submit" name="maintenance-mode-preview-submit" class="bps-blue-button" value="<?php esc_attr_e('Preview', 'bulletproof-security') ?>" />
</p>
</form>

<?php } ?>

<?php
// Maintenance Mode Single/GWIOD: Turn On - Frontend & Backend Maintenance Modes are independent of each other
function bpsPro_mmode_single_gwiod_turn_on() {
global $bps_topDiv, $bps_bottomDiv;

$MMoptions = get_option('bulletproof_security_options_maint_mode');
$permsIndex = @substr(sprintf('%o', fileperms($root_index_file)), -4);
$sapi_type = php_sapi_name();
$root_index_file = ABSPATH . 'index.php';
$root_index_file_backup = WP_CONTENT_DIR . '/bps-backup/master-backups/backup_index.php';
$MMindexMaster = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/maintenance-mode-index.php';
$bps_maintenance_file = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/bps-maintenance.php';
$bps_maintenance_values = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/bps-maintenance-values.php';
$root_folder_maintenance = ABSPATH . 'bps-maintenance.php';
$root_folder_maintenance_values = ABSPATH . 'bps-maintenance-values.php';
$pattern = '/#\sBEGIN\sBPS\sMAINTENANCE\sMODE\sIP\s*(.*)\s*#\sEND\sBPS\sMAINTENANCE\sMODE\sIP/';
$format_error_1 = '/,(\s){2,20}/'; // 2 to 20 extra whitespaces
$format_error_2 = '/,[^\s]/'; // no whitespaces between commas
		
	if ( $MMoptions['bps_maint_ip_allowed'] == '' ) {	
		echo $bps_topDiv;
    	$text = '<font color="red"><strong>'.__('Error: You did not enter an IP Address in the Maintenance Mode IP Address Whitelist Text Box.', 'bulletproof-security').'</strong></font>';
		echo $text;		
		echo $bps_bottomDiv;
	return;
	}	
	
	// IP Address Text Box Error Checking: 2 to 20 extra whitespaces, no whitespace between commas, no commas
	if ( substr_count( $MMoptions['bps_maint_ip_allowed'], '.' ) > 3 && substr_count( $MMoptions['bps_maint_ip_allowed'], ',' ) <= 0 || preg_match( $format_error_1, $MMoptions['bps_maint_ip_allowed'] ) || preg_match( $format_error_2, $MMoptions['bps_maint_ip_allowed'] ) ) {
		
		echo $bps_topDiv;
    	$text = '<font color="red"><strong>'.__('IP Address Format Error: You have entered multiple IP Addresses using an incorrect Format.', 'bulletproof-security').'</font><br>'.__('The correct IP Address Format is: IP Address comma single space. Example: 100.99.88.77, 200.66.55.44, 44.33.22.1 or 100.99.88., 200.66.55., 44.33.22. if you are using the recommended 3 octet IP addresses.', 'bulletproof-security').'<br>'.__('Correct the IP Address Format and click the Save Options button again.', 'bulletproof-security').'</strong>';
		echo $text;		
		echo $bps_bottomDiv;
	return;		
	}	
	
	// Frontend Maintenance Mode
	// Single/GWIOD: if a user unchecks frontend mmode, saves options again and then clicks turn on then frontend mmode needs to be turned off
	if ( $MMoptions['bps_maint_frontend'] != '1' ) {
		bpsPro_mmode_single_gwiod_turn_off_frontend();
	}
	
	if ( $MMoptions['bps_maint_ip_allowed'] != '' && $MMoptions['bps_maint_frontend'] == '1' ) {
		
		if ( get_option('home') != get_option('siteurl') ) {
			bpsPro_mmode_gwiod_site_root_index_file_on();
		}
		
		$stringReplace = file_get_contents($MMindexMaster);
			
	if ( preg_match($pattern, $stringReplace, $matches ) ) {
			
		$stringReplace = preg_replace('/#\sBEGIN\sBPS\sMAINTENANCE\sMODE\sIP\s*(.*)\s*#\sEND\sBPS\sMAINTENANCE\sMODE\sIP/', "# BEGIN BPS MAINTENANCE MODE IP\n".'$bps_maintenance_ip'." = array('".str_replace(', ', "', '", $MMoptions['bps_maint_ip_allowed'])."');\n# END BPS MAINTENANCE MODE IP", $stringReplace);			
			
		if ( file_put_contents($MMindexMaster, $stringReplace) ) {
					
			if ( @$permsIndex == '0400') {
				$lock = '0400';			
			}
			
			if ( @substr($sapi_type, 0, 6) != 'apache' && @$permsIndex != '0666' || @$permsIndex != '0777') { // Windows IIS, XAMPP, etc
				@chmod($root_index_file, 0644);
			}	

			$index_contents = file_get_contents($root_index_file);

		// First click Turn On: backup the WP root index.php file. Second... click Turn On: do not backup the index.php file to master-backups again
		if ( !strpos($index_contents, "BPS MAINTENANCE MODE IP") ) {
			copy( $root_index_file, $root_index_file_backup );			
		} 
			
			// first, second, third clicks...
			@copy($bps_maintenance_values, $root_folder_maintenance_values);
				
			// first click only, but someone may want to modify the Master mmode template file so copy it again
			@copy($bps_maintenance_file, $root_folder_maintenance);

			// first, second, third clicks...
			@copy($MMindexMaster, $root_index_file);
		
				echo $bps_topDiv;
				$text = '<font color="green"><strong>'.__('FrontEnd Maintenance Mode has been Turned On.', 'bulletproof-security').'</strong></font>';
				echo $text;
    			echo $bps_bottomDiv;

			if ( $lock == '0400') {	
				@chmod($root_index_file, 0400);
			}
		}
	}
	} // end if ( $MMoptions['bps_maint_ip_allowed'] != '' && $MMoptions['bps_maint_frontend'] == '1' ) {

	// Backend Maintenance Mode
	// if a user unchecks backend mmode, saves options again and then clicks turn on then backend mmode needs to be turned off
	if ( $MMoptions['bps_maint_backend'] != '1' ) {
		bpsPro_mmode_single_gwiod_turn_off_backend();
	}
	
	$MMAllowFromTXT = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/maintenance-mode.txt';
	$wpadminHtaccess = ABSPATH . 'wp-admin/.htaccess';
	$permsHtaccess = @substr(sprintf('%o', fileperms($wpadminHtaccess)), -4);
	$sapi_type = php_sapi_name();
	$pattern2 = '/#\sBEGIN\sBPS\sMAINTENANCE\sMODE\sIP\s*Order(.*)\s*(Allow(.*)\s*){1,}#\sEND\sBPS\sMAINTENANCE\sMODE\sIP/';
	
	if ( $MMoptions['bps_maint_ip_allowed'] != '' && $MMoptions['bps_maint_backend'] == '1' ) {

		if ( @$permsHtaccess == '0404') {
			$lock = '0404';			
		}		
		
		if ( @substr($sapi_type, 0, 6) != 'apache' || @$permsHtaccess != '0666' || @$permsHtaccess != '0777') { // Windows IIS, XAMPP, etc
			@chmod($wpadminHtaccess, 0644);
		}	
		
		$wpadmin_allow_from = array_filter( explode(', ', trim( $MMoptions['bps_maint_ip_allowed'], ", \t\n\r") ) );
		$allow_whiteList = array();
		
		foreach ( $wpadmin_allow_from as $allow_Key => $allow_Value ) {
			$allow_whiteList[] = 'Allow from '.$allow_Value."\n";
			file_put_contents($MMAllowFromTXT, $allow_whiteList);
		}

		$AllowFromRules = file_get_contents($MMAllowFromTXT);
		$stringReplace = file_get_contents($wpadminHtaccess);
				
		if ( !preg_match( $pattern2, $stringReplace, $matches ) ) {
				
			$stringReplace = "# BEGIN BPS MAINTENANCE MODE IP\nOrder Allow,Deny\n".$AllowFromRules."# END BPS MAINTENANCE MODE IP";	
			file_put_contents($wpadminHtaccess, $stringReplace, FILE_APPEND | LOCK_EX);				
				
		} else {
				
			$stringReplace = preg_replace('/#\sBEGIN\sBPS\sMAINTENANCE\sMODE\sIP\s*Order(.*)\s*(Allow(.*)\s*){1,}#\sEND\sBPS\sMAINTENANCE\sMODE\sIP/', "# BEGIN BPS MAINTENANCE MODE IP\nOrder Allow,Deny\n".$AllowFromRules."# END BPS MAINTENANCE MODE IP", $stringReplace);	

			file_put_contents($wpadminHtaccess, $stringReplace);		
		}			
		
		if ( $lock == '0404') {	
			@chmod($wpadminHtaccess, 0404);
		}
		
		echo $bps_topDiv;
		$text = '<font color="green"><strong>'.__('BackEnd Maintenance Mode has been Turned On.', 'bulletproof-security').'</strong></font>';
		echo $text;
    	echo $bps_bottomDiv;
	}
}

// Maintenance Mode Network/GWIOD: Turn On - Frontend & Backend Maintenance Modes are independent of each other
function bpsPro_mmode_network_turn_on() {
global $current_blog, $blog_id, $bps_topDiv, $bps_bottomDiv;

$MMoptions = get_option('bulletproof_security_options_maint_mode');
$permsIndex = @substr(sprintf('%o', fileperms($root_index_file)), -4);
$sapi_type = php_sapi_name();
$root_index_file = ABSPATH . 'index.php';
$root_index_file_backup = WP_CONTENT_DIR . '/bps-backup/master-backups/backup_index.php';
$MMindexMaster = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/maintenance-mode-index-MU.php';

// Primary Site
$bps_maintenance_file = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/bps-maintenance.php';
$bps_maintenance_values = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/bps-maintenance-values.php';
$root_folder_maintenance = ABSPATH . 'bps-maintenance.php';
$root_folder_maintenance_values = ABSPATH . 'bps-maintenance-values.php';

// Subsites
$subsite_remove_slashes = str_replace( '/', "", $current_blog->path );
$subsite_maintenance_file = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/bps-maintenance-'.$subsite_remove_slashes.'.php';
$subsite_maintenance_values = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/bps-maintenance-values-'.$subsite_remove_slashes.'.php';
$subsite_root_folder_maintenance = ABSPATH . 'bps-maintenance-'.$subsite_remove_slashes.'.php';
$subsite_root_folder_maintenance_values = ABSPATH . 'bps-maintenance-values-'.$subsite_remove_slashes.'.php';

// Regex
$subsite_case_pattern = '/#\sBEGIN\s'.$subsite_remove_slashes.'\sCASE\s*((.*)\s*){13}break;\s*#\sEND\s'.$subsite_remove_slashes.'\sCASE/';
$subsite_case_ip_pattern = '/#\sBEGIN\sBPS\sMAINTENANCE\sMODE\s'.$subsite_remove_slashes.'\sIP\s*(.*)\s*#\sEND\sBPS\sMAINTENANCE\sMODE\s'.$subsite_remove_slashes.'\sIP/';
$primary_site_ip_pattern = '/#\sBEGIN\sBPS\sMAINTENANCE\sMODE\sPRIMARY\sIP\s*(.*)\s*#\sEND\sBPS\sMAINTENANCE\sMODE\sPRIMARY\sIP/';

// Error Checks
$format_error_1 = '/,(\s){2,20}/'; // 2 to 20 extra whitespaces
$format_error_2 = '/,[^\s]/'; // no whitespaces between commas

	if ( $MMoptions['bps_maint_ip_allowed'] == '' ) {	
		echo $bps_topDiv;
    	$text = '<font color="red"><strong>'.__('Error: You did not enter an IP Address in the Maintenance Mode IP Address Whitelist Text Box.', 'bulletproof-security').'</strong></font>';
		echo $text;		
		echo $bps_bottomDiv;
	return;
	}	
	
	// IP Address Text Box Error Checking: 2 to 20 extra whitespaces, no whitespace between commas, no commas
	if ( substr_count( $MMoptions['bps_maint_ip_allowed'], '.' ) > 3 && substr_count( $MMoptions['bps_maint_ip_allowed'], ',' ) <= 0 || preg_match( $format_error_1, $MMoptions['bps_maint_ip_allowed'] ) || preg_match( $format_error_2, $MMoptions['bps_maint_ip_allowed'] ) ) {
		
		echo $bps_topDiv;
    	$text = '<font color="red"><strong>'.__('IP Address Format Error: You have entered multiple IP Addresses using an incorrect Format.', 'bulletproof-security').'</font><br>'.__('The correct IP Address Format is: IP Address comma single space. Example: 100.99.88.77, 200.66.55.44, 44.33.22.1 or 100.99.88., 200.66.55., 44.33.22. if you are using the recommended 3 octet IP addresses.', 'bulletproof-security').'<br>'.__('Correct the IP Address Format and click the Save Options button again.', 'bulletproof-security').'</strong>';
		echo $text;		
		echo $bps_bottomDiv;
	return;		
	}	
	
	// Frontend Maintenance Mode
	// Network/Multisite: if a user unchecks frontend mmode, saves options again and then clicks turn on then frontend mmode needs to be turned off
	if ( $MMoptions['bps_maint_frontend'] != '1' ) {
		bpsPro_mmode_network_turn_off_frontend();
	}
	
	if ( $MMoptions['bps_maint_ip_allowed'] != '' && $MMoptions['bps_maint_frontend'] == '1' ) {
		
		// backup the original WP root index.php file ONLY once the first time mmode is turned On and never again.
		if ( !file_exists($root_index_file_backup) ) {
			@copy( $root_index_file, $root_index_file_backup );			
		} 

	// Primary Network Site
	if ( is_multisite() && $blog_id == 1 ) {

		$stringReplace = file_get_contents($MMindexMaster);

	if ( preg_match( '/#\sBEGIN\sPRIMARY\sSITE\sSTATUS\s*(.*)\s*#\sEND\sPRIMARY\sSITE\sSTATUS/', $stringReplace, $matches ) ) {
		$stringReplace = preg_replace( '/#\sBEGIN\sPRIMARY\sSITE\sSTATUS\s*(.*)\s*#\sEND\sPRIMARY\sSITE\sSTATUS/', "# BEGIN PRIMARY SITE STATUS\n\$primary_site_status = 'On';\n# END PRIMARY SITE STATUS", $stringReplace);	
	}
	
	if ( preg_match( $primary_site_ip_pattern, $stringReplace, $matches ) ) {
			
		$stringReplace = preg_replace('/#\sBEGIN\sBPS\sMAINTENANCE\sMODE\sPRIMARY\sIP\s*(.*)\s*#\sEND\sBPS\sMAINTENANCE\sMODE\sPRIMARY\sIP/', "# BEGIN BPS MAINTENANCE MODE PRIMARY IP\n		".'$bps_maintenance_ip'." = array('".str_replace(', ', "', '", $MMoptions['bps_maint_ip_allowed'])."');\n		# END BPS MAINTENANCE MODE PRIMARY IP", $stringReplace);			
			
		if ( file_put_contents($MMindexMaster, $stringReplace) ) {
					
			if ( @$permsIndex == '0400') {
				$lock = '0400';			
			}			
			
			if ( @substr($sapi_type, 0, 6) != 'apache' && @$permsIndex != '0666' || @$permsIndex != '0777') { // Windows IIS, XAMPP, etc
				@chmod($root_index_file, 0644);
			}	

			@copy($bps_maintenance_values, $root_folder_maintenance_values);
			@copy($bps_maintenance_file, $root_folder_maintenance);
			@copy($MMindexMaster, $root_index_file);
		
			echo $bps_topDiv;
			$text = '<font color="green"><strong>'.__('FrontEnd Maintenance Mode has been Turned On.', 'bulletproof-security').'</strong></font>';
			echo $text;
    		echo $bps_bottomDiv;

			// Network GWIOD Site type - process this function after the new index file has been created with file_put_contents
			if ( network_site_url() != get_site_option('siteurl') ) {
				bpsPro_mmode_network_gwiod_site_root_index_file_on();
			}			
			
			if ( $lock == '0400') {	
				@chmod($root_index_file, 0400);
			}
		}
	}
	
	/** Network/Multisite Subsites **/
	// Up to this point / after Save Options for subsites:
	// subsite values and maintenance files have been created & the subsite include: bps-maintenance-values-{subsite-uri}.php 
	// has been created in the subsite maintenance file: bps-maintenance-{subsite-uri}.php
	// the same index master file is used for all sites, each subsite will string replace its ip address array and copy the index file to the root folder again
	
	} else {
		
		$stringReplace = file_get_contents($MMindexMaster);

		// Create or update the subsite Status variable with value On in maintenance-mode-index-MU.php
		if ( !preg_match( '/\$'.$subsite_remove_slashes.'_status = \'(.*)\';/', $stringReplace, $matches ) ) {	
			
			$stringReplace = preg_replace('/#\sEND\sSUBSITE\sSTATUS/', "\$$subsite_remove_slashes".'_status'." = 'On';\n# END SUBSITE STATUS", $stringReplace);
		
		} else {
		
			$stringReplace = preg_replace( '/\$'.$subsite_remove_slashes.'_status = \'(.*)\';/', "\$$subsite_remove_slashes".'_status'." = 'On';", $stringReplace);		
		}		

		// Create the subsite URI in maintenance-mode-index-MU.php if it does not already exist
		if ( !preg_match( '/\$'.$subsite_remove_slashes.' = \'\/'.$subsite_remove_slashes.'\/\';/', $stringReplace, $matches ) ) {	
			
			$stringReplace = preg_replace('/#\sEND\sSUBSITE\sURI/', "\$$subsite_remove_slashes = '$current_blog->path';\n# END SUBSITE URI", $stringReplace);
		}	
	
		// Create a new subsite Switch case in maintenance-mode-index-MU.php if it does not already exist
		if ( !preg_match($subsite_case_pattern, $stringReplace, $matches ) ) {
			
			$stringReplace = preg_replace('/default:(\s*(.*)){5}\s*#\sEND\sBPS\sSWITCH\s*\}/', "# BEGIN $subsite_remove_slashes CASE\n	case \$$subsite_remove_slashes:\n		# BEGIN BPS MAINTENANCE MODE $subsite_remove_slashes IP\n		\$bps_maintenance_ip = array('127.0.0.1');\n		# END BPS MAINTENANCE MODE $subsite_remove_slashes IP\n		if ( \$all_sites == '1' || \$all_subsites == '1' ) {\n		require( dirname( __FILE__ ) . '/bps-maintenance.php' );\n		} else {\n		if ( in_array( \$_SERVER['REMOTE_ADDR'], \$bps_maintenance_ip ) || in_array( \$matches_three[0], \$bps_maintenance_ip ) || in_array( \$matches_two[0], \$bps_maintenance_ip ) || in_array( \$matches_one[0], \$bps_maintenance_ip ) || \$$subsite_remove_slashes".'_status'." == 'Off' ) {\n		require( dirname( __FILE__ ) . '/wp-blog-header.php' );\n		} else {\n		require( dirname( __FILE__ ) . '/bps-maintenance-$subsite_remove_slashes.php' );\n		}\n		}\n		break;\n 	# END $subsite_remove_slashes CASE\n	default:\n		if ( \$all_sites == '1' || \$all_subsites == '1' ) {\n		require( dirname( __FILE__ ) . '/bps-maintenance.php' );\n		} else {\n		require( dirname( __FILE__ ) . '/wp-blog-header.php' );\n		}\n	# END BPS SWITCH\n	}", $stringReplace );
			}
	
		// Create the subsite IP addresses array in maintenance-mode-index-MU.php
		if ( preg_match( $subsite_case_ip_pattern, $stringReplace, $matches ) ) {
			
		$stringReplace = preg_replace( $subsite_case_ip_pattern, "# BEGIN BPS MAINTENANCE MODE $subsite_remove_slashes IP\n		".'$bps_maintenance_ip'." = array('".str_replace(', ', "', '", $MMoptions['bps_maint_ip_allowed'])."');\n		# END BPS MAINTENANCE MODE $subsite_remove_slashes IP", $stringReplace);			
			
			if ( file_put_contents($MMindexMaster, $stringReplace) ) {
					
				if ( @$permsIndex == '0400') {
					$lock = '0400';			
				}				
				
				if ( @substr($sapi_type, 0, 6) != 'apache' && @$permsIndex != '0666' || @$permsIndex != '0777') { // Windows IIS, XAMPP, etc
					@chmod($root_index_file, 0644);
				}	

				@copy($subsite_maintenance_values, $subsite_root_folder_maintenance_values);
				@copy($bps_maintenance_values, $root_folder_maintenance_values);
				@copy($subsite_maintenance_file, $subsite_root_folder_maintenance);
				@copy($bps_maintenance_file, $root_folder_maintenance);
				@copy($MMindexMaster, $root_index_file);
		
				echo $bps_topDiv;
				$text = '<font color="green"><strong>'.__('FrontEnd Maintenance Mode has been Turned On.', 'bulletproof-security').'</strong></font>';
				echo $text;
    			echo $bps_bottomDiv;
			
			// Network GWIOD Site type - process this function after the new index file has been created with file_put_contents
			if ( network_site_url() != get_site_option('siteurl') ) {
				bpsPro_mmode_network_gwiod_site_root_index_file_on();
			}
			
			if ( $lock == '0400') {	
				@chmod($root_index_file, 0400);
			}
		}	
	}
	}
	} // end if ( $MMoptions['bps_maint_ip_allowed'] != '' && $MMoptions['bps_maint_frontend'] == '1' ) {

	// Backend Maintenance Mode - Primary Site ONLY - subsites do not have this option available
	// if a user unchecks backend mmode, saves options again and then clicks turn on then backend mmode needs to be turned off
	if ( is_multisite() && $blog_id == 1 ) {	

	if ( $MMoptions['bps_maint_backend'] != '1' ) {
		bpsPro_mmode_single_gwiod_turn_off_backend();
	}
	
	$MMAllowFromTXT = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/maintenance-mode.txt';
	$wpadminHtaccess = ABSPATH . 'wp-admin/.htaccess';
	$permsHtaccess = @substr(sprintf('%o', fileperms($wpadminHtaccess)), -4);
	$sapi_type = php_sapi_name();
	$pattern2 = '/#\sBEGIN\sBPS\sMAINTENANCE\sMODE\sIP\s*Order(.*)\s*(Allow(.*)\s*){1,}#\sEND\sBPS\sMAINTENANCE\sMODE\sIP/';
	
	if ( $MMoptions['bps_maint_ip_allowed'] != '' && $MMoptions['bps_maint_backend'] == '1' ) {

		if ( @$permsHtaccess == '0404') {
			$lock = '0404';			
		}		
		
		if ( @substr($sapi_type, 0, 6) != 'apache' || @$permsHtaccess != '0666' || @$permsHtaccess != '0777') { // Windows IIS, XAMPP, etc
			@chmod($wpadminHtaccess, 0644);
		}	
		
		$wpadmin_allow_from = array_filter( explode(', ', trim( $MMoptions['bps_maint_ip_allowed'], ", \t\n\r") ) );
		$allow_whiteList = array();
		
		foreach ( $wpadmin_allow_from as $allow_Key => $allow_Value ) {
			$allow_whiteList[] = 'Allow from '.$allow_Value."\n";
			file_put_contents($MMAllowFromTXT, $allow_whiteList);
		}

		$AllowFromRules = file_get_contents($MMAllowFromTXT);
		$stringReplace = file_get_contents($wpadminHtaccess);
				
		if ( !preg_match( $pattern2, $stringReplace, $matches ) ) {
				
			$stringReplace = "# BEGIN BPS MAINTENANCE MODE IP\nOrder Allow,Deny\n".$AllowFromRules."# END BPS MAINTENANCE MODE IP";	
			file_put_contents($wpadminHtaccess, $stringReplace, FILE_APPEND | LOCK_EX);				
				
		} else {
				
			$stringReplace = preg_replace('/#\sBEGIN\sBPS\sMAINTENANCE\sMODE\sIP\s*Order(.*)\s*(Allow(.*)\s*){1,}#\sEND\sBPS\sMAINTENANCE\sMODE\sIP/', "# BEGIN BPS MAINTENANCE MODE IP\nOrder Allow,Deny\n".$AllowFromRules."# END BPS MAINTENANCE MODE IP", $stringReplace);	

			file_put_contents($wpadminHtaccess, $stringReplace);		
		}			
		
		if ( $lock == '0404') {	
			@chmod($wpadminHtaccess, 0404);
		}		
		
		echo $bps_topDiv;
		$text = '<font color="green"><strong>'.__('BackEnd Maintenance Mode has been Turned On.', 'bulletproof-security').'</strong></font>';
		echo $text;
    	echo $bps_bottomDiv;
	}	
	}
}

// Form - Turn On Maintenance Mode
if (isset($_POST['Submit-maintenance-mode-on']) && current_user_can('manage_options')) {
	check_admin_referer( 'bulletproof_security_mmode_on' );

$MMoptions = get_option('bulletproof_security_options_maint_mode');

	if ( !get_option('bulletproof_security_options_maint_mode') ) {
		echo $bps_topDiv;
    	$text = '<font color="red"><strong>'.__('Error: You have not saved your option settings yet. Click the Save Options button.', 'bulletproof-security').'</strong></font>';
		echo $text;		
		echo $bps_bottomDiv;
	return;
	}

	if ( is_multisite() && $blog_id != 1 ) {	
		$bps_maint_backend = '';
		$bps_maint_mu_entire_site = '';
		$bps_maint_mu_subsites_only = '';
	
	} else {
		
		$bps_maint_backend = $MMoptions['bps_maint_backend'];
		$bps_maint_mu_entire_site = $MMoptions['bps_maint_mu_entire_site'];
		$bps_maint_mu_subsites_only = $MMoptions['bps_maint_mu_subsites_only'];	
	}
	
	$BPS_Options = array(
	'bps_maint_on_off' => 'On', 
	'bps_maint_countdown_timer' => $MMoptions['bps_maint_countdown_timer'], 
	'bps_maint_countdown_timer_color' => $MMoptions['bps_maint_countdown_timer_color'], 
	'bps_maint_time' => $MMoptions['bps_maint_time'], 
	'bps_maint_retry_after' => $MMoptions['bps_maint_retry_after'], 
	'bps_maint_frontend' => $MMoptions['bps_maint_frontend'], 
	'bps_maint_backend' => $bps_maint_backend, 
	'bps_maint_ip_allowed' => $MMoptions['bps_maint_ip_allowed'], 
	'bps_maint_text' => $MMoptions['bps_maint_text'], 
	'bps_maint_background_images' => $MMoptions['bps_maint_background_images'], 
	'bps_maint_center_images' => $MMoptions['bps_maint_center_images'], 
	'bps_maint_background_color' => $MMoptions['bps_maint_background_color'], 
	'bps_maint_show_visitor_ip' => $MMoptions['bps_maint_show_visitor_ip'], 
	'bps_maint_show_login_link' => $MMoptions['bps_maint_show_login_link'], 
	'bps_maint_dashboard_reminder' => $MMoptions['bps_maint_dashboard_reminder'], 
	'bps_maint_countdown_email' => $MMoptions['bps_maint_countdown_email'], 
	'bps_maint_email_to' => $MMoptions['bps_maint_email_to'], 
	'bps_maint_email_from' => $MMoptions['bps_maint_email_from'], 
	'bps_maint_email_cc' => $MMoptions['bps_maint_email_cc'], 
	'bps_maint_email_bcc' => $MMoptions['bps_maint_email_bcc'], 
	'bps_maint_mu_entire_site' => $bps_maint_mu_entire_site, 
	'bps_maint_mu_subsites_only' => $bps_maint_mu_subsites_only
	);	
	
		foreach( $BPS_Options as $key => $value ) {
			update_option('bulletproof_security_options_maint_mode', $BPS_Options);
		}	
	
	if ( !is_multisite() ) {
		bpsPro_mmode_single_gwiod_turn_on();
	} else {
		bpsPro_mmode_network_turn_on();
	}
}

// Maintenance Mode - Turn On for Single GWIOD site root index.php file
function bpsPro_mmode_gwiod_site_root_index_file_on() {
global $bps_topDiv, $bps_bottomDiv;

$MMoptions = get_option('bulletproof_security_options_maint_mode');
$publicly_displayed_url = get_option('home');
$actual_wp_install_url = get_option('siteurl');
$gwiod_MMindexMaster = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/maintenance-mode-index-GWIOD.php';
$gwiod_pattern = '/#\sBEGIN\sBPS\sMAINTENANCE\sMODE\sGWIOD\s*require(.*)\s*\}(.*)\s*require(.*)\s*\}\s*#\sEND\sBPS\sMAINTENANCE\sMODE\sGWIOD/';
$gwiod_pattern_ip = '/#\sBEGIN\sBPS\sMAINTENANCE\sMODE\sIP\s*(.*)\s*#\sEND\sBPS\sMAINTENANCE\sMODE\sIP/';

	if ( $publicly_displayed_url != $actual_wp_install_url ) {

		$gwiod_url = str_replace( $publicly_displayed_url, "", $actual_wp_install_url );
		//$gwiod_url_path = str_replace( $gwiod_url, "", str_replace('\\', '/', ABSPATH ) );
		//$gwiod_root_index_file = $gwiod_url_path . 'index.php';
		$gwiod_url_path = str_replace( '\\', '/', ABSPATH );
		$gwiod_root_index_file = dirname( $gwiod_url_path ) . '/index.php';		
		$gwiod_root_index_file_backup = WP_CONTENT_DIR . '/bps-backup/master-backups/backup_gwiod_index.php';
		$gwiod_permsIndex = @substr(sprintf('%o', fileperms($gwiod_root_index_file)), -4);
		$sapi_type = php_sapi_name();

		if ( !file_exists( $gwiod_root_index_file ) ) {
			echo $bps_topDiv;
    		$text = '<font color="red"><strong>'.__('Error: Unable to get/find the site root index.php file for this GWIOD - Giving WordPress Its Own Directory - website.', 'bulletproof-security').'</font><br>'.__('GWIOD Site Root index.php File Path Checked: ', 'bulletproof-security').$gwiod_root_index_file.'<br>'.__('Please copy this error message and send it in an email to info@ait-pro.com for assistance.', 'bulletproof-security').'</strong>';
			echo $text;		
			echo $bps_bottomDiv;
		return;		
	
	} else {

		$gwiod_stringReplace = file_get_contents($gwiod_MMindexMaster);
	
		if ( preg_match($gwiod_pattern_ip, $gwiod_stringReplace, $matches ) ) {
			
			$gwiod_stringReplace = preg_replace('/#\sBEGIN\sBPS\sMAINTENANCE\sMODE\sIP\s*(.*)\s*#\sEND\sBPS\sMAINTENANCE\sMODE\sIP/', "# BEGIN BPS MAINTENANCE MODE IP\n".'$bps_maintenance_ip'." = array('".str_replace(', ', "', '", $MMoptions['bps_maint_ip_allowed'])."');\n# END BPS MAINTENANCE MODE IP", $gwiod_stringReplace);			
		}		
		
		if ( preg_match($gwiod_pattern, $gwiod_stringReplace, $matches ) ) {
			
			$gwiod_stringReplace = preg_replace('/#\sBEGIN\sBPS\sMAINTENANCE\sMODE\sGWIOD\s*require(.*)\s*\}(.*)\s*require(.*)\s*\}\s*#\sEND\sBPS\sMAINTENANCE\sMODE\sGWIOD/', "# BEGIN BPS MAINTENANCE MODE GWIOD\nrequire( dirname( __FILE__ ) . '".$gwiod_url."/wp-blog-header.php' );\n} else {\nrequire( dirname( __FILE__ ) . '".$gwiod_url."/bps-maintenance.php' );\n}\n# END BPS MAINTENANCE MODE GWIOD", $gwiod_stringReplace);		
		}

			if ( file_put_contents($gwiod_MMindexMaster, $gwiod_stringReplace) ) {
		
				if ( @$gwiod_permsIndex == '0400') {
					$lock = '0400';			
				}
				
				if ( @substr($sapi_type, 0, 6) != 'apache' && @$gwiod_permsIndex != '0666' || @$gwiod_permsIndex != '0777') { // Windows IIS, XAMPP, etc
					@chmod($gwiod_root_index_file, 0644);
				}	
			
				$gwiod_index_contents = file_get_contents($gwiod_root_index_file);

				// First click Turn On: backup the WP root index.php file. Second... click Turn On: do not backup the index.php file to master-backups again
				if ( !strpos($gwiod_index_contents, "BPS MAINTENANCE MODE IP") ) {
					copy( $gwiod_root_index_file, $gwiod_root_index_file_backup );	
				} 
			
				@copy($gwiod_MMindexMaster, $gwiod_root_index_file);
				
				if ( $lock == '0400') {	
					@chmod($gwiod_root_index_file, 0400);
				}	
			}
		}
	}
}

// Maintenance Mode - Turn On for Network GWIOD site root index.php file
function bpsPro_mmode_network_gwiod_site_root_index_file_on() {
global $current_blog, $blog_id, $bps_topDiv, $bps_bottomDiv;

$MMoptions = get_option('bulletproof_security_options_maint_mode');
$MMindexMaster = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/maintenance-mode-index-MU.php';
$publicly_displayed_url = network_site_url();
$actual_wp_install_url = get_site_option('siteurl');

	if ( $publicly_displayed_url != $actual_wp_install_url ) {

		$gwiod_url = str_replace( $publicly_displayed_url, "", $actual_wp_install_url );
		//$gwiod_url_path = str_replace( $gwiod_url, "", str_replace('\\', '/', ABSPATH ) );
		//$gwiod_root_index_file = $gwiod_url_path . 'index.php';
		$gwiod_url_path = str_replace( '\\', '/', ABSPATH );
		$gwiod_root_index_file = dirname( $gwiod_url_path ) . '/index.php';
		$gwiod_root_index_file_backup = WP_CONTENT_DIR . '/bps-backup/master-backups/backup_gwiod_index.php';
		$gwiod_permsIndex = @substr(sprintf('%o', fileperms($gwiod_root_index_file)), -4);
		$sapi_type = php_sapi_name();
		
	if ( !file_exists( $gwiod_root_index_file ) ) {
		echo $bps_topDiv;
    	$text = '<font color="red"><strong>'.__('Error: Unable to get/find the site root index.php file for this Network GWIOD - Giving WordPress Its Own Directory - website.', 'bulletproof-security').'</font><br>'.__('Network GWIOD Site Root index.php File Path Checked: ', 'bulletproof-security').$gwiod_root_index_file.'<br>'.__('Please copy this error message and send it in an email to info@ait-pro.com for assistance.', 'bulletproof-security').'</strong>';
		echo $text;		
		echo $bps_bottomDiv;
	return;		
	
	} else {

		if ( @$gwiod_permsIndex == '0400') {
			$lock = '0400';			
		}		
		
		if ( @substr($sapi_type, 0, 6) != 'apache' && @$gwiod_permsIndex != '0666' || @$gwiod_permsIndex != '0777') { // Windows IIS, XAMPP, etc
			@chmod($gwiod_root_index_file, 0644);
		}	
	
	if ( !file_exists($gwiod_root_index_file_backup) ) {
			
		copy( $gwiod_root_index_file, $gwiod_root_index_file_backup );
	}
		
	if ( copy( $MMindexMaster, $gwiod_root_index_file ) ) {
		
		$gwiod_stringReplace = file_get_contents($gwiod_root_index_file);
	}
		
	if ( !strpos($gwiod_stringReplace, "/$gwiod_urlbps-maintenance" ) ) {
			
		$gwiod_stringReplace = preg_replace('/\/bps-maintenance/', "/$gwiod_url".'bps-maintenance', $gwiod_stringReplace);
	}			
		
	if ( !strpos($gwiod_stringReplace, "/$gwiod_urlwp-blog-header" ) ) {
			
		$gwiod_stringReplace = preg_replace('/\/wp-blog-header/', "/$gwiod_url".'wp-blog-header', $gwiod_stringReplace);
	}	
		
	if ( file_put_contents($gwiod_root_index_file, $gwiod_stringReplace) ) {
		
				if ( $lock == '0400') {	
					@chmod($gwiod_root_index_file, 0400);
				}
			}
		}
	}	
}
?>

<form name="bpsMaintenanceModeOn" action="admin.php?page=bulletproof-security/admin/maintenance/maintenance.php" method="post">
<?php wp_nonce_field('bulletproof_security_mmode_on'); ?>
<p class="submit" style="float:left; margin:0px 10px 0px 0px;">
<input type="submit" name="Submit-maintenance-mode-on" class="bps-blue-button" value="<?php esc_attr_e('Turn On', 'bulletproof-security') ?>" />
</p>
</form>

<?php
// Maintenance Mode - Frontend MMODE Turn Off used in Turn On function - Single & GWIOD
// conditional / based on $MMoptions['bps_maint_frontend'] != '1' in bpsPro_mmode_single_gwiod_turn_on()
function bpsPro_mmode_single_gwiod_turn_off_frontend() {
global $bps_topDiv, $bps_bottomDiv;

$MMoptions = get_option('bulletproof_security_options_maint_mode');
$permsIndex = @substr(sprintf('%o', fileperms($root_index_file)), -4);
$sapi_type = php_sapi_name();
$root_index_file = ABSPATH . 'index.php';
$root_index_file_backup = WP_CONTENT_DIR . '/bps-backup/master-backups/backup_index.php';
$root_folder_maintenance = ABSPATH . 'bps-maintenance.php';
$root_folder_maintenance_values = ABSPATH . 'bps-maintenance-values.php';

	if ( file_exists($root_index_file_backup) ) {
		
		if ( @$permsIndex == '0400') {
			$lock = '0400';			
		}		
		
		if ( @substr($sapi_type, 0, 6) != 'apache' && @$permsIndex != '0666' || @$permsIndex != '0777') { // Windows IIS, XAMPP, etc
			@chmod($root_index_file, 0644);
		}	
		
		if ( @copy($root_index_file_backup, $root_index_file) ) {
	
			$delete_files = array($root_folder_maintenance, $root_folder_maintenance_values);

			foreach ( $delete_files as $file ) {
				if ( file_exists($file) ) {
					@unlink($file);	
				}
			}
		
		if ( $lock == '0400') {	
			@chmod($root_index_file, 0400);
		}			
		
		echo $bps_topDiv;
		$text = '<font color="green"><strong>'.__('FrontEnd Maintenance Mode has been Turned Off.', 'bulletproof-security').'</strong></font>';
		echo $text;
    	echo $bps_bottomDiv;		
		
		}
	}

	// GWIOD
	$publicly_displayed_url = get_option('home');
	$actual_wp_install_url = get_option('siteurl');
	$gwiod_root_index_file_backup = WP_CONTENT_DIR . '/bps-backup/master-backups/backup_gwiod_index.php';
	$gwiod_url = str_replace( $publicly_displayed_url, "", $actual_wp_install_url );
	//$gwiod_url_path = str_replace( $gwiod_url, "", str_replace('\\', '/', ABSPATH ) );
	//$gwiod_root_index_file = $gwiod_url_path . 'index.php';
	$gwiod_url_path = str_replace( '\\', '/', ABSPATH );
	$gwiod_root_index_file = dirname( $gwiod_url_path ) . '/index.php';
	
	$gwiod_permsIndex = @substr(sprintf('%o', fileperms($gwiod_root_index_file)), -4);
	
	if ( file_exists($gwiod_root_index_file_backup) ) {
	
		if ( @$gwiod_permsIndex == '0400') {
			$lock = '0400';			
		}		
		
		if ( @substr($sapi_type, 0, 6) != 'apache' && @$gwiod_permsIndex != '0666' || @$gwiod_permsIndex != '0777') { // Windows IIS, XAMPP, etc
			@chmod($gwiod_root_index_file, 0644);
		}	
	
		@copy($gwiod_root_index_file_backup, $gwiod_root_index_file);
		
		if ( $lock == '0400') {	
			@chmod($gwiod_root_index_file, 0400);
		}
	}
}

// Maintenance Mode - Frontend MMODE Turn Off used in Turn On function - Network/GWIOD
// conditional / based on $MMoptions['bps_maint_frontend'] != '1' in bpsPro_mmode_network_turn_on()
function bpsPro_mmode_network_turn_off_frontend() {
global $current_blog, $blog_id, $bps_topDiv, $bps_bottomDiv;

$MMoptions = get_option('bulletproof_security_options_maint_mode');
$permsIndex = @substr(sprintf('%o', fileperms($root_index_file)), -4);
$sapi_type = php_sapi_name();
$root_index_file = ABSPATH . 'index.php';
$root_index_file_backup = WP_CONTENT_DIR . '/bps-backup/master-backups/backup_index.php';
$bps_maintenance_values = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/bps-maintenance-values.php';
$root_folder_maintenance_values = ABSPATH . 'bps-maintenance-values.php';
$root_folder_maintenance = ABSPATH . 'bps-maintenance.php';
$MMindexMaster = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/maintenance-mode-index-MU.php';

		if ( @$permsIndex == '0400') {
			$lock = '0400';			
		}		
		
		if ( @substr($sapi_type, 0, 6) != 'apache' && @$permsIndex != '0666' || @$permsIndex != '0777') { // Windows IIS, XAMPP, etc
			@chmod($root_index_file, 0644);
		}	

			// Primary Network Site
			if ( is_multisite() && $blog_id == 1 ) {
			
				$stringReplace = @file_get_contents($MMindexMaster);

				if ( preg_match( '/#\sBEGIN\sPRIMARY\sSITE\sSTATUS\s*(.*)\s*#\sEND\sPRIMARY\sSITE\sSTATUS/', $stringReplace, $matches ) ) {
			
					$stringReplace = preg_replace( '/#\sBEGIN\sPRIMARY\sSITE\sSTATUS\s*(.*)\s*#\sEND\sPRIMARY\sSITE\sSTATUS/', "# BEGIN PRIMARY SITE STATUS\n\$primary_site_status = 'Off';\n# END PRIMARY SITE STATUS", $stringReplace);		
				}
				
				if ( file_put_contents($MMindexMaster, $stringReplace) ) {
					@copy( $MMindexMaster, $root_index_file );
					@copy( $bps_maintenance_values, $root_folder_maintenance_values );
				}
			
			// Subsites
			} else {
				
				$subsite_remove_slashes = str_replace( '/', "", $current_blog->path );
				$subsite_root_folder_maintenance = ABSPATH . 'bps-maintenance-'.$subsite_remove_slashes.'.php';
				$subsite_root_folder_maintenance_values = ABSPATH . 'bps-maintenance-values-'.$subsite_remove_slashes.'.php';
								
				$stringReplace = @file_get_contents($MMindexMaster);

				if ( preg_match( '/\$'.$subsite_remove_slashes.'_status = \'(.*)\';/', $stringReplace, $matches ) ) {
			
					$stringReplace = preg_replace( '/\$'.$subsite_remove_slashes.'_status = \'(.*)\';/', "\$$subsite_remove_slashes".'_status'." = 'Off';", $stringReplace);		
				}
				
				if ( file_put_contents($MMindexMaster, $stringReplace) ) {
					@copy( $MMindexMaster, $root_index_file );
				}			
				
				$delete_files = array($subsite_root_folder_maintenance, $subsite_root_folder_maintenance_values);

				foreach ( $delete_files as $file ) {
					if ( file_exists($file) ) {
						@unlink($file);	
					}
				}
			}
		
		if ( $lock == '0400') {	
			@chmod($root_index_file, 0400);
		}			
		
		echo $bps_topDiv;
		$text = '<font color="green"><strong>'.__('FrontEnd Maintenance Mode has been Turned Off.', 'bulletproof-security').'</strong></font>';
		echo $text;
    	echo $bps_bottomDiv;		

	// Network GWIOD
	$publicly_displayed_url = network_site_url();
	$actual_wp_install_url = get_site_option('siteurl');
	$gwiod_root_index_file_backup = WP_CONTENT_DIR . '/bps-backup/master-backups/backup_gwiod_index.php';
	$gwiod_url = str_replace( $publicly_displayed_url, "", $actual_wp_install_url );
	//$gwiod_url_path = str_replace( $gwiod_url, "", str_replace('\\', '/', ABSPATH ) );
	//$gwiod_root_index_file = $gwiod_url_path . 'index.php';
	$gwiod_url_path = str_replace( '\\', '/', ABSPATH );
	$gwiod_root_index_file = dirname( $gwiod_url_path ) . '/index.php';
	$gwiod_permsIndex = @substr(sprintf('%o', fileperms($gwiod_root_index_file)), -4);
	
		if ( @$gwiod_permsIndex == '0400') {
			$lock = '0400';			
		}		
		
		if ( @substr($sapi_type, 0, 6) != 'apache' && @$gwiod_permsIndex != '0666' || @$gwiod_permsIndex != '0777') { // Windows IIS, XAMPP, etc
			@chmod($gwiod_root_index_file, 0644);
		}	
	
	if ( @copy( $MMindexMaster, $gwiod_root_index_file ) ) {
		
		$gwiod_stringReplace = file_get_contents($gwiod_root_index_file);
	}
		
	if ( !strpos($gwiod_stringReplace, "/$gwiod_urlbps-maintenance" ) ) {
			
		$gwiod_stringReplace = preg_replace('/\/bps-maintenance/', "/$gwiod_url".'bps-maintenance', $gwiod_stringReplace);
	}			
		
	if ( !strpos($gwiod_stringReplace, "/$gwiod_urlwp-blog-header" ) ) {
			
		$gwiod_stringReplace = preg_replace('/\/wp-blog-header/', "/$gwiod_url".'wp-blog-header', $gwiod_stringReplace);
	}		

	if ( file_put_contents($gwiod_root_index_file, $gwiod_stringReplace) ) {		
		
		if ( $lock == '0400') {	
			@chmod($gwiod_root_index_file, 0400);
		}	
	}	
}

// Maintenance Mode - Backend MMODE Turn Off used in Turn On function - Single & GWIOD & Network
// conditional / based on $MMoptions['bps_maint_backend'] != '1' in bpsPro_mmode_single_gwiod_turn_on()
function bpsPro_mmode_single_gwiod_turn_off_backend() {
global $bps_topDiv, $bps_bottomDiv;

$MMoptions = get_option('bulletproof_security_options_maint_mode');
$sapi_type = php_sapi_name();
$pattern2 = '/#\sBEGIN\sBPS\sMAINTENANCE\sMODE\sIP\s*Order(.*)\s*(Allow(.*)\s*){1,}#\sEND\sBPS\sMAINTENANCE\sMODE\sIP/';
$wpadminHtaccess = ABSPATH . 'wp-admin/.htaccess';
$permsHtaccess = @substr(sprintf('%o', fileperms($wpadminHtaccess)), -4);

	if ( file_exists($wpadminHtaccess) ) {
		
		if ( @$permsHtaccess == '0404') {
			$lock = '0404';			
		}		
		
		if ( @substr($sapi_type, 0, 6) != 'apache' || @$permsHtaccess != '0666' || @$permsHtaccess != '0777') { // Windows IIS, XAMPP, etc
			@chmod($wpadminHtaccess, 0644);
		}
	
		$stringReplace = file_get_contents($wpadminHtaccess);
		
		if ( preg_match( $pattern2, $stringReplace, $matches ) ) {
				
			$stringReplace = preg_replace('/#\sBEGIN\sBPS\sMAINTENANCE\sMODE\sIP\s*Order(.*)\s*(Allow(.*)\s*){1,}#\sEND\sBPS\sMAINTENANCE\sMODE\sIP/', "", $stringReplace);	

			if ( file_put_contents($wpadminHtaccess, $stringReplace) ) {
		
				if ( $lock == '0404') {	
					@chmod($wpadminHtaccess, 0404);
				}				
				
				echo $bps_topDiv;
				$text = '<font color="green"><strong>'.__('BackEnd Maintenance Mode has been Turned Off.', 'bulletproof-security').'</strong></font>';
				echo $text;
    			echo $bps_bottomDiv;
			}
		}			
	}
}

// Maintenance Mode - Turn Off - Single & GWIOD
// non-conditional / not based on option settings so that clicking turn off again will not cause problems
function bpsPro_mmode_single_gwiod_turn_off() {
global $bps_topDiv, $bps_bottomDiv;

$MMoptions = get_option('bulletproof_security_options_maint_mode');
$permsIndex = @substr(sprintf('%o', fileperms($root_index_file)), -4);
$sapi_type = php_sapi_name();
$root_index_file = ABSPATH . 'index.php';
$root_index_file_backup = WP_CONTENT_DIR . '/bps-backup/master-backups/backup_index.php';
$root_folder_maintenance = ABSPATH . 'bps-maintenance.php';
$root_folder_maintenance_values = ABSPATH . 'bps-maintenance-values.php';
$pattern = '/#\sBEGIN\sBPS\sMAINTENANCE\sMODE\sIP\s*(.*)\s*#\sEND\sBPS\sMAINTENANCE\sMODE\sIP/';
$pattern2 = '/#\sBEGIN\sBPS\sMAINTENANCE\sMODE\sIP\s*Order(.*)\s*(Allow(.*)\s*){1,}#\sEND\sBPS\sMAINTENANCE\sMODE\sIP/';
$wpadminHtaccess = ABSPATH . 'wp-admin/.htaccess';
$permsHtaccess = @substr(sprintf('%o', fileperms($wpadminHtaccess)), -4);

	if ( file_exists($root_index_file_backup) ) {
		
		if ( @$permsIndex == '0400') {
			$lock = '0400';			
		}		
		
		if ( @substr($sapi_type, 0, 6) != 'apache' && @$permsIndex != '0666' || @$permsIndex != '0777') { // Windows IIS, XAMPP, etc
			@chmod($root_index_file, 0644);
		}	
		
		if ( @copy($root_index_file_backup, $root_index_file) ) {
	
			$delete_files = array($root_folder_maintenance, $root_folder_maintenance_values);

			foreach ( $delete_files as $file ) {
				if ( file_exists($file) ) {
					@unlink($file);	
				}
			}
		
		if ( $lock == '0400') {	
			@chmod($root_index_file, 0400);
		}	
		
		echo $bps_topDiv;
		$text = '<font color="green"><strong>'.__('FrontEnd Maintenance Mode has been Turned Off.', 'bulletproof-security').'</strong></font>';
		echo $text;
    	echo $bps_bottomDiv;			
		}
	}
		
	// GWIOD
	$publicly_displayed_url = get_option('home');
	$actual_wp_install_url = get_option('siteurl');
	$gwiod_root_index_file_backup = WP_CONTENT_DIR . '/bps-backup/master-backups/backup_gwiod_index.php';
	$gwiod_url = str_replace( $publicly_displayed_url, "", $actual_wp_install_url );
	//$gwiod_url_path = str_replace( $gwiod_url, "", str_replace('\\', '/', ABSPATH ) );
	//$gwiod_root_index_file = $gwiod_url_path . 'index.php';
	$gwiod_url_path = str_replace( '\\', '/', ABSPATH );
	$gwiod_root_index_file = dirname( $gwiod_url_path ) . '/index.php';
	$gwiod_permsIndex = @substr(sprintf('%o', fileperms($gwiod_root_index_file)), -4);
	
	if ( file_exists($gwiod_root_index_file_backup) ) {
	
		if ( @$gwiod_permsIndex == '0400') {
			$lock = '0400';			
		}		
		
		if ( @substr($sapi_type, 0, 6) != 'apache' && @$gwiod_permsIndex != '0666' || @$gwiod_permsIndex != '0777') { // Windows IIS, XAMPP, etc
			@chmod($gwiod_root_index_file, 0644);
		}	
	
		@copy($gwiod_root_index_file_backup, $gwiod_root_index_file);
	
		if ( $lock == '0400') {	
			@chmod($gwiod_root_index_file, 0400);
		}	
	}
	
	// wp-admin .htaccess
	if ( file_exists($wpadminHtaccess) ) {
		
		if ( @$permsHtaccess == '0404') {
			$lock = '0404';			
		}		
		
		if ( @substr($sapi_type, 0, 6) != 'apache' || @$permsHtaccess != '0666' || @$permsHtaccess != '0777') { // Windows IIS, XAMPP, etc
			@chmod($wpadminHtaccess, 0644);
		}
	
		$stringReplace = file_get_contents($wpadminHtaccess);
		
		if ( preg_match( $pattern2, $stringReplace, $matches ) ) {
				
			$stringReplace = preg_replace('/#\sBEGIN\sBPS\sMAINTENANCE\sMODE\sIP\s*Order(.*)\s*(Allow(.*)\s*){1,}#\sEND\sBPS\sMAINTENANCE\sMODE\sIP/', "", $stringReplace);	

			if ( file_put_contents($wpadminHtaccess, $stringReplace) ) {
			
				if ( $lock == '0404') {	
					@chmod($wpadminHtaccess, 0404);
				}				
				
				echo $bps_topDiv;
				$text = '<font color="green"><strong>'.__('BackEnd Maintenance Mode has been Turned Off.', 'bulletproof-security').'</strong></font>';
				echo $text;
    			echo $bps_bottomDiv;
			}
		}			
	}
}

// Maintenance Mode - Turn Off - Network/GWIOD
// non-conditional / not based on option settings so that clicking turn off again will not cause problems
function bpsPro_mmode_network_turn_off() {
global $current_blog, $blog_id, $bps_topDiv, $bps_bottomDiv;
$MMoptions = get_option('bulletproof_security_options_maint_mode');
$permsIndex = @substr(sprintf('%o', fileperms($root_index_file)), -4);
$sapi_type = php_sapi_name();
$root_index_file = ABSPATH . 'index.php';
$root_index_file_backup = WP_CONTENT_DIR . '/bps-backup/master-backups/backup_index.php';
$root_folder_maintenance = ABSPATH . 'bps-maintenance.php';
$root_folder_maintenance_values = ABSPATH . 'bps-maintenance-values.php';
$bps_maintenance_values = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/bps-maintenance-values.php';
$pattern = '/#\sBEGIN\sBPS\sMAINTENANCE\sMODE\sIP\s*(.*)\s*#\sEND\sBPS\sMAINTENANCE\sMODE\sIP/';
$pattern2 = '/#\sBEGIN\sBPS\sMAINTENANCE\sMODE\sIP\s*Order(.*)\s*(Allow(.*)\s*){1,}#\sEND\sBPS\sMAINTENANCE\sMODE\sIP/';
$wpadminHtaccess = ABSPATH . 'wp-admin/.htaccess';
$permsHtaccess = @substr(sprintf('%o', fileperms($wpadminHtaccess)), -4);
$MMindexMaster = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/maintenance-mode-index-MU.php';

		if ( @$permsIndex == '0400') {
			$lock = '0400';			
		}		
		
		if ( @substr($sapi_type, 0, 6) != 'apache' && @$permsIndex != '0666' || @$permsIndex != '0777') { // Windows IIS, XAMPP, etc
			@chmod($root_index_file, 0644);
		}	

			// Primary Network Site
			if ( is_multisite() && $blog_id == 1 ) {
			
				$stringReplace = @file_get_contents($MMindexMaster);

				if ( preg_match( '/#\sBEGIN\sPRIMARY\sSITE\sSTATUS\s*(.*)\s*#\sEND\sPRIMARY\sSITE\sSTATUS/', $stringReplace, $matches ) ) {
			
					$stringReplace = preg_replace( '/#\sBEGIN\sPRIMARY\sSITE\sSTATUS\s*(.*)\s*#\sEND\sPRIMARY\sSITE\sSTATUS/', "# BEGIN PRIMARY SITE STATUS\n\$primary_site_status = 'Off';\n# END PRIMARY SITE STATUS", $stringReplace);		
				}
				
				if ( file_put_contents($MMindexMaster, $stringReplace) ) {
					@copy( $MMindexMaster, $root_index_file );
					@copy( $bps_maintenance_values, $root_folder_maintenance_values );
				}
			
			// Subsites
			} else {
				
				$subsite_remove_slashes = str_replace( '/', "", $current_blog->path );
				$subsite_root_folder_maintenance = ABSPATH . 'bps-maintenance-'.$subsite_remove_slashes.'.php';
				$subsite_root_folder_maintenance_values = ABSPATH . 'bps-maintenance-values-'.$subsite_remove_slashes.'.php';
				
				$stringReplace = @file_get_contents($MMindexMaster);

				if ( preg_match( '/\$'.$subsite_remove_slashes.'_status = \'(.*)\';/', $stringReplace, $matches ) ) {
			
					$stringReplace = preg_replace( '/\$'.$subsite_remove_slashes.'_status = \'(.*)\';/', "\$$subsite_remove_slashes".'_status'." = 'Off';", $stringReplace);		
				}
				
				if ( file_put_contents($MMindexMaster, $stringReplace) ) {
					@copy( $MMindexMaster, $root_index_file );
				}			
				
				$delete_files = array($subsite_root_folder_maintenance, $subsite_root_folder_maintenance_values);

				foreach ( $delete_files as $file ) {
					if ( file_exists($file) ) {
						@unlink($file);	
					}
				}
			}
		
		if ( $lock == '0400') {	
			@chmod($root_index_file, 0400);
		}			
		
		echo $bps_topDiv;
		$text = '<font color="green"><strong>'.__('FrontEnd Maintenance Mode has been Turned Off.', 'bulletproof-security').'</strong></font>';
		echo $text;
    	echo $bps_bottomDiv;
		
		// Network/GWIOD
		$publicly_displayed_url = network_site_url();
		$actual_wp_install_url = get_site_option('siteurl');
		$gwiod_root_index_file_backup = WP_CONTENT_DIR . '/bps-backup/master-backups/backup_gwiod_index.php';
		$gwiod_url = str_replace( $publicly_displayed_url, "", $actual_wp_install_url );
		//$gwiod_url_path = str_replace( $gwiod_url, "", str_replace('\\', '/', ABSPATH ) );
		//$gwiod_root_index_file = $gwiod_url_path . 'index.php';
		$gwiod_url_path = str_replace( '\\', '/', ABSPATH );
		$gwiod_root_index_file = dirname( $gwiod_url_path ) . '/index.php';
		$gwiod_permsIndex = @substr(sprintf('%o', fileperms($gwiod_root_index_file)), -4);
	
	if ( @$gwiod_permsIndex == '0400') {
		$lock = '0400';			
	}	
	
	if ( @substr($sapi_type, 0, 6) != 'apache' && @$gwiod_permsIndex != '0666' || @$gwiod_permsIndex != '0777') { // Windows IIS, XAMPP, etc
		@chmod($gwiod_root_index_file, 0644);
	}	
	
	if ( @copy( $MMindexMaster, $gwiod_root_index_file ) ) {
		
		$gwiod_stringReplace = file_get_contents($gwiod_root_index_file);
	}
		
	if ( !strpos($gwiod_stringReplace, "/$gwiod_urlbps-maintenance" ) ) {
			
		$gwiod_stringReplace = preg_replace('/\/bps-maintenance/', "/$gwiod_url".'bps-maintenance', $gwiod_stringReplace);
	}			
		
	if ( !strpos($gwiod_stringReplace, "/$gwiod_urlwp-blog-header" ) ) {
			
		$gwiod_stringReplace = preg_replace('/\/wp-blog-header/', "/$gwiod_url".'wp-blog-header', $gwiod_stringReplace);
	}	
		
	if ( file_put_contents($gwiod_root_index_file, $gwiod_stringReplace) ) {
		
		if ( $lock == '0400') {	
			@chmod($gwiod_root_index_file, 0400);
		}
	}
	
	// wp-admin .htaccess
	if ( is_multisite() && $blog_id == 1 && file_exists($wpadminHtaccess) ) {
		
		if ( @$permsHtaccess == '0404') {
			$lock = '0404';			
		}		
		
		if ( @substr($sapi_type, 0, 6) != 'apache' || @$permsHtaccess != '0666' || @$permsHtaccess != '0777') { // Windows IIS, XAMPP, etc
			@chmod($wpadminHtaccess, 0644);
		}
	
		$stringReplace = file_get_contents($wpadminHtaccess);
		
		if ( preg_match( $pattern2, $stringReplace, $matches ) ) {
				
			$stringReplace = preg_replace('/#\sBEGIN\sBPS\sMAINTENANCE\sMODE\sIP\s*Order(.*)\s*(Allow(.*)\s*){1,}#\sEND\sBPS\sMAINTENANCE\sMODE\sIP/', "", $stringReplace);	

			if ( file_put_contents($wpadminHtaccess, $stringReplace) ) {
			
				if ( $lock == '0404') {	
					@chmod($wpadminHtaccess, 0404);
				}				
				
				echo $bps_topDiv;
				$text = '<font color="green"><strong>'.__('BackEnd Maintenance Mode has been Turned Off.', 'bulletproof-security').'</strong></font>';
				echo $text;
    			echo $bps_bottomDiv;
			}
		}			
	}
}

// Form - Turn Off Maintenance Mode
if (isset($_POST['Submit-maintenance-mode-off']) && current_user_can('manage_options')) {
	check_admin_referer( 'bulletproof_security_mmode_off' );

$MMoptions = get_option('bulletproof_security_options_maint_mode');

	if ( !get_option('bulletproof_security_options_maint_mode') ) {
		echo $bps_topDiv;
    	$text = '<font color="red"><strong>'.__('Error: You have not saved your option settings yet. Click the Save Options button.', 'bulletproof-security').'</strong></font>';
		echo $text;		
		echo $bps_bottomDiv;
	return;
	}
	
	if ( is_multisite() && $blog_id != 1 ) {	
		$bps_maint_backend = '';
		$bps_maint_mu_entire_site = '';
		$bps_maint_mu_subsites_only = '';
	
	} else {
		
		$bps_maint_backend = $MMoptions['bps_maint_backend'];
		$bps_maint_mu_entire_site = $MMoptions['bps_maint_mu_entire_site'];
		$bps_maint_mu_subsites_only = $MMoptions['bps_maint_mu_subsites_only'];	
	}
	
	$BPS_Options = array(
	'bps_maint_on_off' => 'Off', 
	'bps_maint_countdown_timer' => $MMoptions['bps_maint_countdown_timer'], 
	'bps_maint_countdown_timer_color' => $MMoptions['bps_maint_countdown_timer_color'], 
	'bps_maint_time' => $MMoptions['bps_maint_time'], 
	'bps_maint_retry_after' => $MMoptions['bps_maint_retry_after'], 
	'bps_maint_frontend' => $MMoptions['bps_maint_frontend'], 
	'bps_maint_backend' => $bps_maint_backend, 
	'bps_maint_ip_allowed' => $MMoptions['bps_maint_ip_allowed'], 
	'bps_maint_text' => $MMoptions['bps_maint_text'], 
	'bps_maint_background_images' => $MMoptions['bps_maint_background_images'], 
	'bps_maint_center_images' => $MMoptions['bps_maint_center_images'], 
	'bps_maint_background_color' => $MMoptions['bps_maint_background_color'], 
	'bps_maint_show_visitor_ip' => $MMoptions['bps_maint_show_visitor_ip'], 
	'bps_maint_show_login_link' => $MMoptions['bps_maint_show_login_link'], 
	'bps_maint_dashboard_reminder' => $MMoptions['bps_maint_dashboard_reminder'], 
	'bps_maint_countdown_email' => $MMoptions['bps_maint_countdown_email'], 
	'bps_maint_email_to' => $MMoptions['bps_maint_email_to'], 
	'bps_maint_email_from' => $MMoptions['bps_maint_email_from'], 
	'bps_maint_email_cc' => $MMoptions['bps_maint_email_cc'], 
	'bps_maint_email_bcc' => $MMoptions['bps_maint_email_bcc'], 
	'bps_maint_mu_entire_site' => $bps_maint_mu_entire_site, 
	'bps_maint_mu_subsites_only' => $bps_maint_mu_subsites_only
	);	
	
		foreach( $BPS_Options as $key => $value ) {
			update_option('bulletproof_security_options_maint_mode', $BPS_Options);
		}	
		
	if ( !is_multisite() ) {
		bpsPro_mmode_single_gwiod_turn_off();
	} else {
		bpsPro_mmode_network_turn_off();
	}
}
?>

<form name="bpsMaintenanceModeOff" action="admin.php?page=bulletproof-security/admin/maintenance/maintenance.php" method="post">
<?php wp_nonce_field('bulletproof_security_mmode_off'); ?>
<p class="submit" style="margin:0px 0px 0px 0px;">
<input type="submit" name="Submit-maintenance-mode-off" class="bps-blue-button" value="<?php esc_attr_e('Turn Off', 'bulletproof-security') ?>" />
</p>
</form>

</td>
  </tr>
  <tr>
    <td class="bps-table_cell_bottom">&nbsp;</td>
  </tr>
</table>

</div>

<div id="bps-tabs-2" class="bps-tab-page">
<h2><?php _e('Help & FAQ', 'bulletproof-security'); ?></h2>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="bps-help_faq_table">
  <tr>
    <td colspan="2" class="bps-table_title">&nbsp;</td>
  </tr>
  <tr>
    <td class="bps-table_cell_help"><a href="http://forum.ait-pro.com/forums/topic/maintenance-mode-guide-read-me-first/" target="_blank"><?php _e('Maintenance Mode Guide', 'bulletproof-security'); ?></a></td>
    <td class="bps-table_cell_help"><a href="http://www.ait-pro.com/aitpro-blog/category/bulletproof-security-contributors/" target="_blank"><?php _e('Contributors Page', 'bulletproof-security'); ?></a></td>
  </tr>
  <tr>
    <td class="bps-table_cell_help"><a href="http://forum.ait-pro.com/forums/forum/bulletproof-security-free/" target="_blank"><?php _e('BulletProof Security Forum', 'bulletproof-security'); ?></a></td>
    <td class="bps-table_cell_help"><a href="http://www.ait-pro.com/aitpro-blog/2252/bulletproof-security-plugin-support/checking-plugin-compatibility-with-bps-plugin-testing-to-do-list/" target="_blank"><?php _e('OLD: Plugin Compatibility Testing - Recent New Permanent Fixes', 'bulletproof-security'); ?></a></td>
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