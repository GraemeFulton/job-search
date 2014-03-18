<?php
// Direct calls to this file are Forbidden when core files are not present
if (!function_exists ('add_action')) {
		header('Status: 403 Forbidden');
		header('HTTP/1.1 403 Forbidden');
		exit();
}

// Create the BPS Master /htaccess Folder Deny All .htaccess file automatically
// Create the BPS Backup /bps-backup Folder Deny All .htaccess file automatically
function bps_Master_htaccess_folder_bpsbackup_denyall() {
$denyAllHtaccess = WP_PLUGIN_DIR .'/bulletproof-security/admin/htaccess/deny-all.htaccess';
$denyAllHtaccessCopy = WP_PLUGIN_DIR .'/bulletproof-security/admin/htaccess/.htaccess';
$bpsBackup = WP_CONTENT_DIR . '/bps-backup';
$bpsBackupHtaccess = WP_CONTENT_DIR . '/bps-backup/.htaccess';

	if ( current_user_can('manage_options') ) { 
	
	if ( !file_exists($denyAllHtaccessCopy) ) {
		@copy($denyAllHtaccess, $denyAllHtaccessCopy);	
	}
	
	if ( is_dir($bpsBackup) && !file_exists($bpsBackupHtaccess) ) {
		@copy($denyAllHtaccess, $bpsBackupHtaccess);	
	}
	}
}
add_action('admin_notices', 'bps_Master_htaccess_folder_bpsbackup_denyall');

// BPS Master htaccess File Editing - file checks and get contents for editor
function bps_get_secure_htaccess() {
$secure_htaccess_file = WP_PLUGIN_DIR .'/bulletproof-security/admin/htaccess/secure.htaccess';
$bps_wpcontent_dir = str_replace( ABSPATH, '', WP_CONTENT_DIR);	
	
	if (file_exists($secure_htaccess_file)) {
		$bpsString = file_get_contents($secure_htaccess_file);
		echo $bpsString;
	} else {
		_e('The secure.htaccess file either does not exist or is not named correctly. Check the /', 'bulletproof-security').$bps_wpcontent_dir.__('/plugins/bulletproof-security/admin/htaccess/ folder to make sure the secure.htaccess file exists and is named secure.htaccess.', 'bulletproof-security');
	}
}

function bps_get_default_htaccess() {
$default_htaccess_file = WP_PLUGIN_DIR .'/bulletproof-security/admin/htaccess/default.htaccess';
$bps_plugin_dir = str_replace( ABSPATH, '', WP_PLUGIN_DIR);

	if (file_exists($default_htaccess_file)) {
		$bpsString = file_get_contents($default_htaccess_file);
		echo $bpsString;
	} else {
		_e('The default.htaccess file either does not exist or is not named correctly. Check the /', 'bulletproof-security').$bps_plugin_dir.__('/bulletproof-security/admin/htaccess/ folder to make sure the default.htaccess file exists and is named default.htaccess.', 'bulletproof-security');
	}
}

function bps_get_wpadmin_htaccess() {
$wpadmin_htaccess_file = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/wpadmin-secure.htaccess';
$bps_plugin_dir = str_replace( ABSPATH, '', WP_PLUGIN_DIR);

	if (file_exists($wpadmin_htaccess_file)) {
		$bpsString = file_get_contents($wpadmin_htaccess_file);
		echo $bpsString;
	} else {
		_e('The wpadmin-secure.htaccess file either does not exist or is not named correctly. Check the /', 'bulletproof-security').$bps_plugin_dir.__('/bulletproof-security/admin/htaccess/ folder to make sure the wpadmin-secure.htaccess file exists and is named wpadmin-secure.htaccess.', 'bulletproof-security');
	}
}

// The current active root htaccess file - file check
function bps_get_root_htaccess() {
$root_htaccess_file = ABSPATH . '.htaccess';
	
	if (file_exists($root_htaccess_file)) {
		$bpsString = file_get_contents($root_htaccess_file);
		echo $bpsString;
	} else {
		_e('An .htaccess file was not found in your website root folder.', 'bulletproof-security');
	}
}

// The current active wp-admin htaccess file - file check
function bps_get_current_wpadmin_htaccess_file() {
$current_wpadmin_htaccess_file = ABSPATH . 'wp-admin/.htaccess';
	
	if (file_exists($current_wpadmin_htaccess_file)) {
		$bpsString = file_get_contents($current_wpadmin_htaccess_file);
		echo $bpsString;
	} else {
		_e('An .htaccess file was not found in your wp-admin folder.', 'bulletproof-security');
	}
}

// File write checks for editor
function bps_secure_htaccess_file_check() {
$secure_htaccess_file = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/secure.htaccess';
	
	if (!is_writable($secure_htaccess_file)) {
 		$text = '<font color="red"><strong>'.__('Cannot write to the secure.htaccess file. Minimum file permission required is 600.', 'bulletproof-security').'</strong></font><br>';
		echo $text;
	} else {
		echo '';
	}
}

// File write checks for editor
function bps_default_htaccess_file_check() {
$default_htaccess_file = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/default.htaccess';
	
	if (!is_writable($default_htaccess_file)) {
 		$text = '<font color="red"><strong>'.__('Cannot write to the default.htaccess file. Minimum file permission required is 600.', 'bulletproof-security').'</strong></font><br>';
		echo $text;
	} else {
		echo '';
	}
}

// File write checks for editor
function bps_wpadmin_htaccess_file_check() {
$wpadmin_htaccess_file = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/wpadmin-secure.htaccess';
	
	if (!is_writable($wpadmin_htaccess_file)) {
 		$text = '<font color="red"><strong>'.__('Cannot write to the wpadmin-secure.htaccess file. Minimum file permission required is 600.', 'bulletproof-security').'</strong></font><br>';
		echo $text;
	} else {
		echo '';
	}
}
// File write checks for editor - not in use
function bps_root_htaccess_file_check() {
$root_htaccess_file = ABSPATH . '/.htaccess';
	
	if (!is_writable($root_htaccess_file)) {
 		$text = '<font color="red"><strong>'.__('Cannot write to the root .htaccess file. Minimum file permission required is 600.', 'bulletproof-security').'</strong></font><br>';
		echo $text;
	} else {
		echo '';
	}
}
// File write checks for editor - not in use
function bps_current_wpadmin_htaccess_file_check() {
$current_wpadmin_htaccess_file = ABSPATH . 'wp-admin/.htaccess';
	
	if (!is_writable($current_wpadmin_htaccess_file)) {
 		$text = '<font color="red"><strong>'.__('Cannot write to the wp-admin .htaccess file. Minimum file permission required is 600.', 'bulletproof-security').'</strong></font><br>';
		echo $text;
	 } else {
		echo '';
	}
}

// Get DNS Name Server from [target]
function bps_DNS_NS() {
$bpsHostName = esc_html($_SERVER['SERVER_NAME']);
$bpsTargetNS = '';
$bpsTarget = '';
$bpsNSHostSubject = '';
$bpsGetDNS = @dns_get_record($bpsHostName, DNS_NS);
	
	if (!isset($bpsGetDNS[0]['target'])) {
		echo '';
	} else {
		$bpsTargetNS = $bpsGetDNS[0]['target'];
	if ($bpsTargetNS != '') {
		preg_match('/[^.]+\.[^.]+$/', $bpsTargetNS, $bpsTmatches);
		$bpsNSHostSubject = $bpsTmatches[0];
	return $bpsNSHostSubject;
	} else {
		echo '';
	}
	}
	
	if ($bpsTargetNS == '') {
		@dns_get_record($bpsHostName, DNS_ALL, $authns, $addtl);
	if (!isset($authns[0]['target'])) {
		echo '';
	} else {
		$bpsTarget = $authns[0]['target'];
	if ($bpsTarget != '') {
		preg_match('/[^.]+\.[^.]+$/', $bpsTarget, $bpsTmatches);
		$bpsNSHostSubject = $bpsTmatches[0];
	return $bpsNSHostSubject;
	}
	}
	}	
	
	if ($bpsTarget && $bpsTargetNS == '') {
		@dns_get_record($bpsHostName, DNS_ANY, $authns, $addtl);
	if (!isset($authns[0]['target'])) {
		echo '';
	} else {
		$bpsTarget = $authns[0]['target'];
		preg_match('/[^.]+\.[^.]+$/', $bpsTarget, $bpsTmatches);
		$bpsNSHostSubject = $bpsTmatches[0];
	return $bpsNSHostSubject;
	}
	}
}


// Get Domain Root without prefix
function bpsGetDomainRoot() {
$ServerName = $_SERVER['SERVER_NAME'];
	preg_match('/[^.]+\.[^.]+$/', $ServerName, $matches);
	return $matches[0];
}

// Get the Current / Last Modifed Date of the bulletproof-security.php File - Minutes check
function getBPSInstallTime() {
$filename = WP_PLUGIN_DIR . '/bulletproof-security/bulletproof-security.php';

	if ( file_exists($filename) ) {
		$last_modified_install = date ("F d Y H:i", filemtime($filename));
	return $last_modified_install;
	}
}

// Get the Current / Last Modifed Date of the bulletproof-security.php File + one minute buffer - Minutes check
function getBPSInstallTime_plusone() {
$filename = WP_PLUGIN_DIR . '/bulletproof-security/bulletproof-security.php';
	
	if ( file_exists($filename) ) {
		$last_modified_install = date("F d Y H:i", filemtime($filename) + (60 * 1));
	return $last_modified_install;
	}
}

// Get the Current / Last Modifed Date of the Root .htaccess File - Minutes check
function getBPSRootHtaccessLasModTime_minutes() {
$filename = ABSPATH . '.htaccess';
	
	if ( file_exists($filename) ) {
		$last_modified_install = date ("F d Y H:i", filemtime($filename));
	return $last_modified_install;
	}
}

// Get the Current / Last Modifed Date of the wp-admin .htaccess File - Minutes check
function getBPSwpadminHtaccessLasModTime_minutes() {
$filename = ABSPATH . 'wp-admin/.htaccess';
	
	if ( file_exists($filename) ) {
		$last_modified_install = date ("F d Y H:i", filemtime($filename));
	return $last_modified_install;
	}
}

// Recreate the User Agent filters in the 403.php file on BPS upgrade
function bpsPro_autoupdate_useragent_filters() {		
global $wpdb;
$table_name = $wpdb->prefix . "bpspro_seclog_ignore";
$blankFile = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/blank.txt';
$userAgentMaster = WP_CONTENT_DIR . '/bps-backup/master-backups/UserAgentMaster.txt';
$bps403File = WP_PLUGIN_DIR . '/bulletproof-security/403.php';
$search = '';		

	if ( !file_exists($bps403File) ) {
		return;
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
	
	$UserAgentRulesT = file_get_contents($userAgentMaster);
	$stringReplace = file_get_contents($bps403File);

	$stringReplace = preg_replace('/# BEGIN USERAGENT FILTER(.*)# END USERAGENT FILTER/s', "# BEGIN USERAGENT FILTER\nif ( !preg_match('/".trim($UserAgentRulesT, "|")."/', \$_SERVER['HTTP_USER_AGENT']) ) {\n# END USERAGENT FILTER", $stringReplace);
		
	file_put_contents($bps403File, $stringReplace);
	}
}

// BPS Update/Upgrade Status Alert in WP Dashboard - Root .htaccess file
function bps_root_htaccess_status_dashboard() {
global $bps_version, $bps_last_version;
$options = get_option('bulletproof_security_options_autolock');	
$filename = ABSPATH . '.htaccess';
$permsHtaccess = @substr(sprintf('%o', fileperms($filename)), -4);
$sapi_type = @php_sapi_name();	
$check_string = @file_get_contents($filename);
$section = @file_get_contents($filename, NULL, NULL, 3, 46);	
$bps_denyall_htaccess = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/deny-all.htaccess';
$bps_denyall_htaccess_renamed = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/.htaccess';
$security_log_denyall_htaccess = WP_PLUGIN_DIR . '/bulletproof-security/admin/security-log/.htaccess';
$system_info_denyall_htaccess = WP_PLUGIN_DIR . '/bulletproof-security/admin/system-info/.htaccess';
$login_denyall_htaccess = WP_PLUGIN_DIR . '/bulletproof-security/admin/login/.htaccess';
$bps_get_domain_root = bpsGetDomainRoot();
$bps_get_wp_root_secure = bps_wp_get_root_folder();
$bps_plugin_dir = str_replace( ABSPATH, '', WP_PLUGIN_DIR);

	$patterna = '/RedirectMatch\s403\s\/\\\.\.\*\$/';
	$patternb = '/ErrorDocument\s400\s(.*)400\.php\s*ErrorDocument\s401\sdefault\s*ErrorDocument(.*)\s*ErrorDocument\s404\s\/404\.php/s';	
	// 95%/5% success/fail ratio - this code cannot be used as standard BPS htaccess code - pending deletion
	//$patternb = '/#\sBRUTE\sFORCE\sLOGIN\sPAGE\sPROTECTION\s*(.*)\s*(.*)\s*(RewriteCond(.*)\s*){4}\s*RewriteRule\s\^\(\.\*\)\$\s-\s\[F,L\]/';
	$pattern0 = '/#\sBPS\sPRO\sERROR\sLOGGING(.*)ErrorDocument\s404\s(.*)\/404\.php/s';
	$pattern1 = '/#\sFORBID\sEMPTY\sREFFERER\sSPAMBOTS(.*)RewriteCond\s%{HTTP_USER_AGENT}\s\^\$\sRewriteRule\s\.\*\s\-\s\[F\]/s';	
	$pattern2 = '/TIMTHUMB FORBID RFI and MISC FILE SKIP\/BYPASS RULE/s';
	$pattern3 = '/\[NC\]\s*RewriteCond %{HTTP_REFERER} \^\.\*(.*)\.\*\s*(.*)\s*RewriteRule \. \- \[S\=1\]/s';
	$pattern4 = '/\.\*\(allow_url_include\|allow_url_fopen\|safe_mode\|disable_functions\|auto_prepend_file\) \[NC,OR\]/s';
	//$pattern5 = '/FORBID COMMENT SPAMMERS ACCESS TO YOUR wp-comments-post.php FILE/s';
	$pattern6 = '/(\[|\]|\(|\)|<|>|%3c|%3e|%5b|%5d)/s';
	$pattern7 = '/RewriteCond %{QUERY_STRING} \^\.\*(.*)[3](.*)[5](.*)[5](.*)[7](.*)\)/';
	$pattern8 = '/\[NC\]\s*RewriteCond\s%{HTTP_REFERER}\s\^\.\*(.*)\.\*\s*(.*)\s*(.*)\s*(.*)\s*(.*)\s*(.*)\s*RewriteRule\s\.\s\-\s\[S=1\]/';
	$pattern9 = '/RewriteCond\s%{QUERY_STRING}\s\(sp_executesql\)\s\[NC\]\s*(.*)\s*(.*)END\sBPSQSE(.*)\s*RewriteCond\s%{REQUEST_FILENAME}\s!-f\s*RewriteCond\s%{REQUEST_FILENAME}\s!-d\s*RewriteRule\s\.(.*)\/index\.php\s\[L\]\s*(.*)LOOP\sEND/';
	$pattern10 = '/#\sBEGIN\sBPSQSE\sBPS\sQUERY\sSTRING\sEXPLOITS\s*#\sThe\slibwww-perl\sUser\sAgent\sis\sforbidden/';
	$pattern11 = '/RewriteCond\s%\{QUERY_STRING\}\s\[a-zA-Z0-9_\]\=http:\/\/\s\[OR\]/';
	$pattern12 = '/RewriteCond\s%\{QUERY_STRING\}\s\[a-zA-Z0-9_\]\=\(\\\.\\\.\/\/\?\)\+\s\[OR\]/';
	$pattern13 = '/RewriteCond\s%\{QUERY_STRING\}\s\(\\\.\\\.\/\|\\\.\\\.\)\s\[OR\]/';
	$pattern14 = '/RewriteCond\s%{QUERY_STRING}\s\(\\\.\/\|\\\.\.\/\|\\\.\.\.\/\)\+\(motd\|etc\|bin\)\s\[NC,OR\]/';

	$BPSVpattern = '/BULLETPROOF\s\.[\d](.*)[\>]/';
	$BPSVreplace = "BULLETPROOF $bps_version >>>>>>>";
	$ExcludedHosts = array('webmasters.com', 'rzone.de', 'softcomca.com');

	if ( current_user_can('manage_options') ) {
	
	if ( !file_exists($filename) ) {
		$text = '<div class="update-nag" style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:2px 5px;margin-top:2px;"><font color="red">'.__('BPS Alert! An htaccess file was NOT found in your root folder. Check the BPS ', 'bulletproof-security').'<a href="admin.php?page=bulletproof-security/admin/options.php#bps-tabs-2">'.__('Security Status page', 'bulletproof-security').'</a>'.__(' for more specific information.', 'bulletproof-security').'</font></div>';
		echo $text;
	
	} else {
	
	if ( file_exists($filename) ) {

switch ($bps_version) {
    case $bps_last_version: // for testing
		if (strpos($check_string, "BULLETPROOF $bps_last_version") && strpos($check_string, "BPSQSE")) {
			print($section);
		break;
		}
    case $bps_version:
		if (!strpos($check_string, "BULLETPROOF $bps_version") && strpos($check_string, "BPSQSE")) {
			
			// delete the old Maintenance Mode DB option - added in BPS .49.9
			if ( get_option('bulletproof_security_options_maint') ) {	
				delete_option('bulletproof_security_options_maint');
			}			
			
			if ( @substr($sapi_type, 0, 6) != 'apache' || @$permsHtaccess != '0666' || @$permsHtaccess != '0777') { // Windows IIS, XAMPP, etc
				@chmod($filename, 0644);
			}			

			$stringReplace = @file_get_contents($filename);
			$stringReplace = preg_replace($BPSVpattern, $BPSVreplace, $stringReplace);	
			
			$stringReplace = str_replace("RewriteCond %{HTTP_USER_AGENT} (libwww-perl|wget|python|nikto|curl|scan|java|winhttp|clshttp|loader) [NC,OR]", "RewriteCond %{HTTP_USER_AGENT} (havij|libwww-perl|wget|python|nikto|curl|scan|java|winhttp|clshttp|loader) [NC,OR]", $stringReplace);
			
		if ( preg_match($patterna, $stringReplace, $matches) ) {
			$stringReplace = preg_replace('/#\sDENY\sACCESS\sTO\sPROTECTED\sSERVER\sFILES(.*)RedirectMatch\s403\s\/\\\.\.\*\$/s', "# DENY ACCESS TO PROTECTED SERVER FILES AND FOLDERS\n# Files and folders starting with a dot: .htaccess, .htpasswd, .errordocs, .logs\nRedirectMatch 403 \.(htaccess|htpasswd|errordocs|logs)$", $stringReplace);
		}

		if ( preg_match($pattern0, $stringReplace, $matches) ) {
			$stringReplace = preg_replace('/#\sBPS\sPRO\sERROR\sLOGGING(.*)ErrorDocument\s404\s(.*)\/404\.php/s', "# BPS ERROR LOGGING AND TRACKING\n# BPS has premade 403 Forbidden, 400 Bad Request and 404 Not Found files that are used\n# to track and log 403, 400 and 404 errors that occur on your website. When a hacker attempts to\n# hack your website the hackers IP address, Host name, Request Method, Referering link, the file name or\n# requested resource, the user agent of the hacker and the query string used in the hack attempt are logged.\n# All BPS log files are htaccess protected so that only you can view them.\n# The 400.php, 403.php and 404.php files are located in /wp-content/plugins/bulletproof-security/\n# The 400 and 403 Error logging files are already set up and will automatically start logging errors\n# after you install BPS and have activated BulletProof Mode for your Root folder.\n# If you would like to log 404 errors you will need to copy the logging code in the BPS 404.php file\n# to your Theme's 404.php template file. Simple instructions are included in the BPS 404.php file.\n# You can open the BPS 404.php file using the WP Plugins Editor.\n# NOTE: By default WordPress automatically looks in your Theme's folder for a 404.php template file.\nErrorDocument 400 $bps_get_wp_root_secure"."$bps_plugin_dir/bulletproof-security/400.php\nErrorDocument 401 default\nErrorDocument 403 $bps_get_wp_root_secure"."$bps_plugin_dir/bulletproof-security/403.php\nErrorDocument 404 $bps_get_wp_root_secure"."404.php", $stringReplace);
		}

/* 95%/5% success/fail ratio - this code cannot be used as standard BPS htaccess code - pending deletion
		if ( !preg_match($patternb, $stringReplace, $matches) ) {
			$stringReplace = preg_replace('/# BPS ERROR LOGGING AND TRACKING/', "# BRUTE FORCE LOGIN PAGE PROTECTION\n# Protects the Login page from SpamBots & Proxies\n# that use Server Protocol HTTP/1.0 or a blank User Agent\nRewriteCond %{REQUEST_URI} ^(/wp-login\.php|.*wp-login\.php.*)$\nRewriteCond %{HTTP_USER_AGENT} ^$ [OR]\nRewriteCond %{THE_REQUEST} HTTP/1\.0$ [OR]\nRewriteCond %{SERVER_PROTOCOL} HTTP/1\.0$\nRewriteRule ^(.*)$ - [F,L]\n\n# BPS ERROR LOGGING AND TRACKING", $stringReplace);		
		}
*/
		if ( !preg_match($patternb, $stringReplace, $matches) ) {
			$stringReplace = preg_replace('/ErrorDocument\s400\s(.*)400\.php\s*ErrorDocument(.*)\s*ErrorDocument\s404\s\/404\.php/s', "ErrorDocument 400 $bps_get_wp_root_secure"."$bps_plugin_dir/bulletproof-security/400.php\nErrorDocument 401 default\nErrorDocument 403 $bps_get_wp_root_secure"."$bps_plugin_dir/bulletproof-security/403.php\nErrorDocument 404 $bps_get_wp_root_secure"."404.php", $stringReplace);
		}

		if ( preg_match($pattern1, $stringReplace, $matches) ) {
			$stringReplace = preg_replace('/#\sFORBID\sEMPTY\sREFFERER\sSPAMBOTS(.*)RewriteCond\s%{HTTP_USER_AGENT}\s\^\$\sRewriteRule\s\.\*\s\-\s\[F\]/s', '', $stringReplace);
		}			
			
		if (!preg_match($pattern2, $stringReplace, $matches)) {
			$stringReplace = str_replace("# TimThumb Forbid RFI By Host Name But Allow Internal Requests", "# TIMTHUMB FORBID RFI and MISC FILE SKIP/BYPASS RULE\n# Only Allow Internal File Requests From Your Website\n# To Allow Additional Websites Access to a File Use [OR] as shown below.\n# RewriteCond %{HTTP_REFERER} ^.*YourWebsite.com.* [OR]\n# RewriteCond %{HTTP_REFERER} ^.*AnotherWebsite.com.*", $stringReplace);
		}
		
		if (!preg_match($pattern3, $stringReplace, $matches)) {
			$stringReplace = str_replace("RewriteRule . - [S=1]", "RewriteCond %{HTTP_REFERER} ^.*$bps_get_domain_root.*\nRewriteRule . - [S=1]", $stringReplace);
		}
		
		if (preg_match($pattern3, $stringReplace, $matches)) {
			$stringReplace = preg_replace('/\[NC\]\s*RewriteCond %{HTTP_REFERER} \^\.\*(.*)\.\*\s*(.*)\s*RewriteRule \. \- \[S\=1\]/s', "[NC]\nRewriteCond %{HTTP_REFERER} ^.*$bps_get_domain_root.*\nRewriteRule . - [S=1]", $stringReplace);
		}

		if ( !preg_match($pattern10, $stringReplace, $matches) ) {
			$stringReplace = preg_replace('/#\sBPSQSE\sBPS\sQUERY\sSTRING\sEXPLOITS\s*#\sThe\slibwww-perl\sUser\sAgent\sis\sforbidden/', "# BEGIN BPSQSE BPS QUERY STRING EXPLOITS\n# The libwww-perl User Agent is forbidden", $stringReplace);
		}

		if ( preg_match($pattern11, $stringReplace, $matches) ) {
			$stringReplace = preg_replace('/RewriteCond\s%\{QUERY_STRING\}\s\[a-zA-Z0-9_\]\=http:\/\/\s\[OR\]/s', "RewriteCond %{QUERY_STRING} [a-zA-Z0-9_]=http:// [NC,OR]", $stringReplace);
		}

		if ( preg_match($pattern12, $stringReplace, $matches) ) {
			$stringReplace = preg_replace('/RewriteCond\s%\{QUERY_STRING\}\s\[a-zA-Z0-9_\]\=\(\\\.\\\.\/\/\?\)\+\s\[OR\]/s', "RewriteCond %{QUERY_STRING} [a-zA-Z0-9_]=(\.\.//?)+ [NC,OR]", $stringReplace);
		}

		if ( preg_match($pattern13, $stringReplace, $matches) ) {
			$stringReplace = preg_replace('/RewriteCond\s%\{QUERY_STRING\}\s\(\\\.\\\.\/\|\\\.\\\.\)\s\[OR\]/s', "RewriteCond %{QUERY_STRING} (\.\./|%2e%2e%2f|%2e%2e/|\.\.%2f|%2e\.%2f|%2e\./|\.%2e%2f|\.%2e/) [NC,OR]", $stringReplace);
		}

		if ( preg_match($pattern6, $stringReplace, $matches)) {
			$stringReplace = str_replace("RewriteCond %{QUERY_STRING} ^.*(\[|\]|\(|\)|<|>|%3c|%3e|%5b|%5d).* [NC,OR]", "RewriteCond %{QUERY_STRING} ^.*(\(|\)|<|>|%3c|%3e).* [NC,OR]", $stringReplace);
			$stringReplace = str_replace("RewriteCond %{QUERY_STRING} ^.*(\x00|\x04|\x08|\x0d|\x1b|\x20|\x3c|\x3e|\x5b|\x5d|\x7f).* [NC,OR]", "RewriteCond %{QUERY_STRING} ^.*(\x00|\x04|\x08|\x0d|\x1b|\x20|\x3c|\x3e|\x7f).* [NC,OR]", $stringReplace);		
		}
		
		if ( preg_match($pattern7, $stringReplace, $matches)) {
			$stringReplace = preg_replace('/RewriteCond %{QUERY_STRING} \^\.\*(.*)[5](.*)[5](.*)\)/', 'RewriteCond %{QUERY_STRING} ^.*(\x00|\x04|\x08|\x0d|\x1b|\x20|\x3c|\x3e|\x7f)', $stringReplace);
		}

		if ( preg_match($pattern14, $stringReplace, $matches) ) {
			$stringReplace = preg_replace('/RewriteCond\s%{QUERY_STRING}\s\(\\\.\/\|\\\.\.\/\|\\\.\.\.\/\)\+\(motd\|etc\|bin\)\s\[NC,OR\]/s', "RewriteCond %{QUERY_STRING} (\.{1,}/)+(motd|etc|bin) [NC,OR]", $stringReplace);
		}

		if (!preg_match($pattern4, $stringReplace, $matches)) {
			$stringReplace = str_replace("RewriteCond %{QUERY_STRING} union([^a]*a)+ll([^s]*s)+elect [NC,OR]", "RewriteCond %{QUERY_STRING} union([^a]*a)+ll([^s]*s)+elect [NC,OR]\nRewriteCond %{QUERY_STRING} \-[sdcr].*(allow_url_include|allow_url_fopen|safe_mode|disable_functions|auto_prepend_file) [NC,OR]", $stringReplace);
		}

		if ( !is_multisite() && !preg_match($pattern9, $stringReplace, $matches) ) {
			$stringReplace = preg_replace('/RewriteCond\s%{QUERY_STRING}\s\(sp_executesql\)\s\[NC\]\s*(.*)\s*RewriteCond\s%{REQUEST_FILENAME}\s!-f\s*RewriteCond\s%{REQUEST_FILENAME}\s!-d\s*RewriteRule\s\.(.*)\/index\.php\s\[L\]/', "RewriteCond %{QUERY_STRING} (sp_executesql) [NC]\nRewriteRule ^(.*)$ - [F,L]\n# END BPSQSE BPS QUERY STRING EXPLOITS\nRewriteCond %{REQUEST_FILENAME} !-f\nRewriteCond %{REQUEST_FILENAME} !-d\nRewriteRule . ".$bps_get_wp_root_secure."index.php [L]\n# WP REWRITE LOOP END", $stringReplace);
		}

		// Clean up - replace 3 and 4 multiple newlines with 1 newline
		if ( preg_match('/(\n\n\n|\n\n\n\n)/', $stringReplace, $matches) ) {			
			$stringReplace = preg_replace("/(\n\n\n|\n\n\n\n)/", "\n", $stringReplace);
		}
		// remove duplicate referer lines
		if ( preg_match($pattern8, $stringReplace, $matches) ) {
			$stringReplace = preg_replace("/\[NC\]\s*RewriteCond\s%{HTTP_REFERER}\s\^\.\*(.*)\.\*\s*(.*)\s*(.*)\s*(.*)\s*(.*)\s*(.*)\s*RewriteRule\s\.\s\-\s\[S=1\]/", "[NC]\nRewriteCond %{HTTP_REFERER} ^.*$bps_get_domain_root.*\nRewriteRule . - [S=1]", $stringReplace);
		}

			file_put_contents($filename, $stringReplace);
		
		if ( @$permsHtaccess == '0644' && @substr($sapi_type, 0, 6) != 'apache' && !in_array(bps_DNS_NS(), $ExcludedHosts) && $options['bps_root_htaccess_autolock'] != 'Off') {			
			@chmod($filename, 0404);
		}

		if ( getBPSInstallTime() == getBPSRootHtaccessLasModTime_minutes() || getBPSInstallTime_plusone() == getBPSRootHtaccessLasModTime_minutes() ) {
			$updateText = '<div class="update-nag" style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:2px 5px;margin-top:2px;"><font color="blue">'.__("The BPS Automatic htaccess File Update Completed Successfully!", 'bulletproof-security').'</font></div>';
			copy($bps_denyall_htaccess, $bps_denyall_htaccess_renamed);	
			copy($bps_denyall_htaccess, $security_log_denyall_htaccess);	
			copy($bps_denyall_htaccess, $system_info_denyall_htaccess);
			copy($bps_denyall_htaccess, $login_denyall_htaccess);
				
			// Recreate the User Agent filters in the 403.php file on BPS upgrade
			bpsPro_autoupdate_useragent_filters();

		print($updateText);	
		}
		}
		
		if (strpos($check_string, "BULLETPROOF $bps_version") && strpos($check_string, "BPSQSE") && getBPSInstallTime() != getBPSRootHtaccessLasModTime_minutes() || getBPSInstallTime() == getBPSRootHtaccessLasModTime_minutes() ) {
			//print($section);
		break;
		}
	default:
		$text = '<div class="update-nag" style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:2px 5px;margin-top:2px;"><font color="red">'.__('BPS Alert! Your site does not appear to be protected by BulletProof Security', 'bulletproof-security').'</font><br>'.__('Go to the Security Modes page and click the Create secure.htaccess File AutoMagic button and Activate Root Folder BulletProof Mode.', 'bulletproof-security').'<br>'.__('If your site is in Default Mode then it is NOT protected by BulletProof Security. Check the BPS ', 'bulletproof-security').'<a href="admin.php?page=bulletproof-security/admin/options.php#bps-tabs-2">'.__('Security Status page', 'bulletproof-security').'</a>'.__(' to view your BPS Security Status information.', 'bulletproof-security').'</div>';
		echo $text;
	}
}}}}

add_action('admin_notices', 'bps_root_htaccess_status_dashboard');


// BPS Update/Upgrade Status Alert in WP Dashboard - wp-admin .htaccess file
function bps_wpadmin_htaccess_status_dashboard() {
global $bps_version, $bps_last_version;
$filename = ABSPATH . 'wp-admin/.htaccess';
$permsHtaccess = @substr(sprintf('%o', fileperms($filename)), -4);	
$check_string = @file_get_contents($filename);
$pattern1 = '/(\[|\]|\(|\)|<|>)/s';
$BPSVpattern = '/BULLETPROOF\s\.[\d](.*)WP-ADMIN/';
$BPSVreplace = "BULLETPROOF $bps_version WP-ADMIN";
	
	if ( current_user_can('manage_options') ) {
	
	if ( !file_exists($filename) ) {
		$text = '<div class="update-nag" style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:2px 5px;margin-top:2px;"><font color="red">'.__('BPS Alert! An htaccess file was NOT found in your wp-admin folder. Check the BPS ', 'bulletproof-security').'<a href="admin.php?page=bulletproof-security/admin/options.php#bps-tabs-2">'.__('Security Status page', 'bulletproof-security').'</a>'.__(' for more specific information.', 'bulletproof-security').'</font></div>';
		echo $text;
	
	} else {
	
	if ( file_exists($filename) ) {

switch ($bps_version) {
    case $bps_last_version: // for Testing
		if (strpos($check_string, "BULLETPROOF $bps_last_version") && strpos($check_string, "BPSQSE-check")) {
			echo '';
		break;
		}
    case $bps_version:
		if (!strpos($check_string, "BULLETPROOF $bps_version") && strpos($check_string, "BPSQSE-check")) {
			
			if ( @substr($sapi_type, 0, 6) != 'apache' || @$permsHtaccess != '0666' || @$permsHtaccess != '0777') { // Windows IIS, XAMPP, etc
				@chmod($filename, 0644);
			}
			
			$stringReplace = @file_get_contents($filename);
			$stringReplace = preg_replace($BPSVpattern, $BPSVreplace, $stringReplace);	

		if ( preg_match($pattern1, $stringReplace, $matches) ) {
			$stringReplace = str_replace("RewriteCond %{QUERY_STRING} ^.*(\[|\]|\(|\)|<|>).* [NC,OR]", "RewriteCond %{QUERY_STRING} ^.*(\(|\)|<|>).* [NC,OR]", $stringReplace);		
		}

			file_put_contents($filename, $stringReplace);
		
		if ( getBPSInstallTime() == getBPSwpadminHtaccessLasModTime_minutes() || getBPSInstallTime_plusone() == getBPSwpadminHtaccessLasModTime_minutes() ) {
			//print("Testing wp-admin auto-update");	
		}		
		}
		
		if (strpos($check_string, "BULLETPROOF $bps_version") && strpos($check_string, "BPSQSE-check") && getBPSInstallTime() != getBPSwpadminHtaccessLasModTime_minutes() || getBPSInstallTime() == getBPSwpadminHtaccessLasModTime_minutes() ) {		
			//print($section);
		break;
		}
	default:
		$text = '<div class="update-nag" style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:2px 5px;margin-top:2px;"><font color="red">'.__('BPS Alert! A valid BPS htaccess file was NOT found in your wp-admin folder', 'bulletproof-security').'</font><br>'.__('BulletProof Mode for the wp-admin folder MUST be activated when you have BulletProof Mode activated for the Root folder.', 'bulletproof-security').'<br>'.__('Check the BPS ', 'bulletproof-security').'<a href="admin.php?page=bulletproof-security/admin/options.php#bps-tabs-2">'.__('Security Status page', 'bulletproof-security').'</a>'.__(' for more specific information.', 'bulletproof-security').'</div>';
		echo $text;
	}
}}}}

add_action('admin_notices', 'bps_wpadmin_htaccess_status_dashboard');

// B-Core Security Status inpage display - Root .htaccess
function bps_root_htaccess_status() {
global $bps_version, $bps_last_version;
$filename = ABSPATH . '.htaccess';
$section = @file_get_contents($filename, NULL, NULL, 3, 46);
$check_string = @file_get_contents($filename);	
	
	if ( !file_exists($filename) ) {
		$text = '<font color="red">'.__('ERROR: An htaccess file was NOT found in your root folder', 'bulletproof-security').'</font><br><br>'.__('wp-config.php is NOT htaccess protected by BPS', 'bulletproof-security').'</font><br><br>';
		echo $text;
	
	} else {
	
	if ( file_exists($filename) ) {
		$text = '<font color="green"><strong>'.__('The htaccess file that is activated in your root folder is:', 'bulletproof-security').'</strong></font><br>';
		echo $text;
	print($section);

switch ($bps_version) {
    case $bps_last_version: // for Testing
		if (!strpos($check_string, "BULLETPROOF $bps_last_version") && strpos($check_string, "BPSQSE")) {
			$text = '<font color="red"><br><br><strong>'.__('BPS may be in the process of updating the version number in your root htaccess file. Refresh your browser to display your current security status and this message should go away. If the BPS QUERY STRING EXPLOITS code does not exist in your root htaccess file then the version number update will fail and this message will still be displayed after you have refreshed your Browser. You will need to click the AutoMagic buttons and activate all BulletProof Modes again.', 'bulletproof-security').'<br><br>'.__('wp-config.php is NOT htaccess protected by BPS', 'bulletproof-security').'</strong></font><br><br>';
			echo $text;
		}
		if (strpos($check_string, "BULLETPROOF $bps_last_version") && strpos($check_string, "BPSQSE")) {
			$text = '<font color="green"><strong><br><br>&radic; '.__('wp-config.php is htaccess protected by BPS', 'bulletproof-security').'<br>&radic; '.__('php.ini and php5.ini are htaccess protected by BPS', 'bulletproof-security').'</strong></font><br><br>';
			echo $text;
		break;
		}
    case $bps_version:
		if (!strpos($check_string, "BULLETPROOF $bps_version") && strpos($check_string, "BPSQSE")) {
			$text = '<font color="red"><br><br><strong>'.__('BPS may be in the process of updating the version number in your root htaccess file. Refresh your browser to display your current security status and this message should go away. If the BPS QUERY STRING EXPLOITS code does not exist in your root htaccess file then the version number update will fail and this message will still be displayed after you have refreshed your Browser. You will need to click the AutoMagic buttons and activate all BulletProof Modes again.', 'bulletproof-security').'<br><br>'.__('wp-config.php is NOT htaccess protected by BPS', 'bulletproof-security').'</strong></font><br><br>';
			echo $text;
		}
		if (strpos($check_string, "BULLETPROOF $bps_version") && strpos($check_string, "BPSQSE")) {		
			$text = '<font color="green"><strong><br><br>&radic; '.__('wp-config.php is htaccess protected by BPS', 'bulletproof-security').'<br>&radic; '.__('php.ini and php5.ini are htaccess protected by BPS', 'bulletproof-security').'</strong></font><br><br>';
			echo $text;
		break;
		}
	default:
		$text = '<font color="red"><br><br><strong>'.__('ERROR: Either a BPS htaccess file was NOT found in your root folder or you have not activated BulletProof Mode for your Root folder yet, Default Mode is activated or the version of the BPS htaccess file that you are using is not the most current version or the BPS QUERY STRING EXPLOITS code does not exist in your root htaccess file. Please view the Read Me Help button above.', 'bulletproof-security').'<br><br>'.__('wp-config.php is NOT htaccess protected by BPS', 'bulletproof-security').'</strong></font><br><br>';
		echo $text;

}}}}

// B-Core Security Status inpage display - wp-admin .htaccess
function bps_wpadmin_htaccess_status() {
global $bps_version, $bps_last_version;
$filename = ABSPATH . 'wp-admin/.htaccess';
$section = @file_get_contents($filename, NULL, NULL, 3, 50);
$check_string = @file_get_contents($filename);	
	
	if ( !file_exists($filename) ) {
		$text = '<font color="red"><strong>'.__('ERROR: An htaccess file was NOT found in your wp-admin folder.', 'bulletproof-security').'<br>'.__('BulletProof Mode for the wp-admin folder MUST also be activated when you have BulletProof Mode activated for the Root folder.', 'bulletproof-security').'</strong></font><br>';
		echo $text;
	
	} else {
	
	if ( file_exists($filename) ) {

switch ($bps_version) {
    case $bps_last_version:
		if (!strpos($check_string, "BULLETPROOF $bps_last_version") && strpos($check_string, "BPSQSE-check")) {
			$text = '<font color="red"><strong><br><br>'.__('BPS may be in the process of updating the version number in your wp-admin htaccess file. Refresh your browser to display your current security status and this message should go away. If the BPS QUERY STRING EXPLOITS code does not exist in your wp-admin htaccess file then the version number update will fail and this message will still be displayed after you have refreshed your Browser. You will need to activate BulletProof Mode for your wp-admin folder again.', 'bulletproof-security').'</strong></font><br>';
			echo $text;
		}
		if (strpos($check_string, "BULLETPROOF $bps_last_version") && strpos($check_string, "BPSQSE-check")) {
			$text = '<font color="green"><strong>'.__('The htaccess file that is activated in your wp-admin folder is:', 'bulletproof-security').'</strong></font><br>';
			echo $text;
		print($section);
		break;
		}
    case $bps_version:
		if (!strpos($check_string, "BULLETPROOF $bps_version") && strpos($check_string, "BPSQSE-check")) {
			$text = '<font color="red"><strong><br><br>'.__('BPS may be in the process of updating the version number in your wp-admin htaccess file. Refresh your browser to display your current security status and this message should go away. If the BPS QUERY STRING EXPLOITS code does not exist in your wp-admin htaccess file then the version number update will fail and this message will still be displayed after you have refreshed your Browser. You will need to activate BulletProof Mode for your wp-admin folder again.', 'bulletproof-security').'</strong></font><br>';
			echo $text;
		}
		if (strpos($check_string, "BULLETPROOF $bps_version") && strpos($check_string, "BPSQSE-check")) {		
			$text = '<font color="green"><strong>'.__('The htaccess file that is activated in your wp-admin folder is:', 'bulletproof-security').'</strong></font><br>';
			echo $text;
		print($section);
		break;
		}
	default:
		$text = '<font color="red"><strong><br><br>'.__('ERROR: A valid BPS htaccess file was NOT found in your wp-admin folder. Either you have not activated BulletProof Mode for your wp-admin folder yet or the version of the wp-admin htaccess file that you are using is not the most current version. BulletProof Mode for the wp-admin folder MUST also be activated when you have BulletProof Mode activated for the Root folder. Please view the Read Me Help button above.', 'bulletproof-security').'</strong></font><br>';
		echo $text;
}}}}

// Check if BPS Deny ALL htaccess file is activated for the BPS Master htaccess folder
function bps_denyall_htaccess_status_master() {
$filename = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/.htaccess';
	
	if (file_exists($filename)) {
    	$text = '<font color="green"><strong>&radic; '.__('Deny All protection activated for BPS Master /htaccess folder', 'bulletproof-security').'</strong></font><br>';
		echo $text;
	} else {
    	$text = '<font color="red"><strong>'.__('ERROR: Deny All protection NOT activated for BPS Master /htaccess folder', 'bulletproof-security').'</strong></font><br>';
		echo $text;
	}
}
// Check if BPS Deny ALL htaccess file is activated for the /wp-content/bps-backup folder
function bps_denyall_htaccess_status_backup() {
$filename = WP_CONTENT_DIR . '/bps-backup/.htaccess';
$bps_wpcontent_dir = str_replace( ABSPATH, '', WP_CONTENT_DIR);

	if (file_exists($filename)) {
    	$text = '<font color="green"><strong>&radic; '.__('Deny All protection activated for /', 'bulletproof-security').$bps_wpcontent_dir.__('/bps-backup folder', 'bulletproof-security').'</strong></font><br><br>';
		echo $text;
	} else {
    	$text = '<font color="red"><strong>'.__('ERROR: Deny All protection NOT activated for /', 'bulletproof-security').$bps_wpcontent_dir.__('/bps-backup folder', 'bulletproof-security').'</strong></font><br><br>';
		echo $text;
	}
}

// File and Folder Permission Checking - substr error is suppressed @ else fileperms error if file does not exist
function bps_check_perms($name, $path, $perm) {
clearstatcache();
$current_perms = @substr(sprintf('%o', fileperms($path)), -4);
	
	echo '<table style="width:100%;background-color:#fff;">';
	echo '<tr>';
    echo '<td style="background-color:#fff;padding:2px;width:35%;">' . $name . '</td>';
    echo '<td style="background-color:#fff;padding:2px;width:35%;">' . $path . '</td>';
    echo '<td style="background-color:#fff;padding:2px;width:15%;">' . $perm . '</td>';
    echo '<td style="background-color:#fff;padding:2px;width:15%;">' . $current_perms . '</td>';
    echo '</tr>';
	echo '</table>';
}
	
// General BulletProof Security File Status Checking
function bps_general_file_checks() {
$rootHtaccess = ABSPATH . '.htaccess';
$wpadminHtaccess = ABSPATH . 'wp-admin/.htaccess';
$defaultHtaccess = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/default.htaccess';	
$secureHtaccess = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/secure.htaccess';	
$wpadminsecureHtaccess = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/wpadmin-secure.htaccess';
$bpsmaintenance = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/bps-maintenance.php';	
$bpsmaintenanceValues = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/bps-maintenance-values.php';	
$rootHtaccessBackup = WP_CONTENT_DIR . '/bps-backup/master-backups/root.htaccess';	
$wpadminHtaccessBackup = WP_CONTENT_DIR . '/bps-backup/master-backups/wpadmin.htaccess';	
	
	$files = array($rootHtaccess, $wpadminHtaccess, $defaultHtaccess, $secureHtaccess, $wpadminsecureHtaccess, $bpsmaintenance, $bpsmaintenanceValues, $rootHtaccessBackup, $wpadminHtaccessBackup);
	
	foreach( $files as $file ) {
		if ( file_exists($file) ) {				
			echo '<font color="green">&radic; '.$file.__(' File Found', 'bulletproof-security').'</font><br>';	
		} else {
			echo '<font color="red">'.$file.__(' File NOT Found', 'bulletproof-security').'</font><br>';
		}
	}
}

// Backup and Restore page - Backed up Root and wp-admin .htaccess file checks
function bps_backup_restore_checks() {
$bp_root_back = WP_CONTENT_DIR . '/bps-backup/master-backups/root.htaccess'; 
$bp_wpadmin_back = WP_CONTENT_DIR . '/bps-backup/master-backups/wpadmin.htaccess'; 	
	
	if ( file_exists($bp_root_back) ) { 
	 	$text = '<font color="green"><strong>&radic; '.__('Your Root .htaccess file is backed up.', 'bulletproof-security').'</strong></font><br>'; 
		echo $text;
	} else { 
		$text = '<font color="red"><strong>'.__('Your Root .htaccess file is NOT backed up either because you have not done a Backup yet, an .htaccess file did NOT already exist in your root folder or because of a file copy error. Read the "Current Backed Up .htaccess Files Status Read Me" button for more specific information.', 'bulletproof-security').'</strong></font><br><br>';
		echo $text;
	} 

	if ( file_exists($bp_wpadmin_back) ) { 
		$text = '<font color="green"><strong>&radic; '.__('Your wp-admin .htaccess file is backed up.', 'bulletproof-security').'</strong></font><br>';
		echo $text;
	} else { 
		$text = '<font color="red"><strong>'.__('Your wp-admin .htaccess file is NOT backed up either because you have not done a Backup yet, an .htaccess file did NOT already exist in your /wp-admin folder or because of a file copy error. Read the "Current Backed Up .htaccess Files Status Read Me" button for more specific information', 'bulletproof-security').'</strong></font><br>'; 
		echo $text;
	} 
}

// Backup and Restore page - General check
function bps_general_file_checks_backup_restore() {
$rootHtaccess = ABSPATH . '.htaccess';
$wpadminHtaccess = ABSPATH . 'wp-admin/.htaccess';	
	
	if ( file_exists($rootHtaccess) ) {
  		$text = '<font color="green">&radic; '.__('An .htaccess file was found in your root folder', 'bulletproof-security').'</font><br>';
		echo $text;
	} else {
    	$text = '<font color="red">'.__('An .htaccess file was NOT found in your root folder', 'bulletproof-security').'</font><br>';
		echo $text;
	}

	if ( file_exists($wpadminHtaccess) ) {
    	$text = '<font color="green">&radic; '.__('An .htaccess file was found in your /wp-admin folder', 'bulletproof-security').'</font><br>';
		echo $text;
	} else {
    	$text = '<font color="red">'.__('An .htaccess file was NOT found in your /wp-admin folder', 'bulletproof-security').'</font><br>';
		echo $text;
	}
}

// System Info page only - Check if Permalinks are enabled
function bps_check_permalinks() {
$permalink_structure = get_option('permalink_structure');	
	
	if ( get_option('permalink_structure') == '' ) { 
		$text = __('Custom Permalinks:', 'bulletproof-security').'<font color="red"><strong>'.__('WARNING! Custom Permalinks are NOT in use', 'bulletproof-security').'<br>'.__('It is recommended that you use Custom Permalinks', 'bulletproof-security').'</strong></font>';
		echo $text;
	} else {
		$text = __('Custom Permalinks:', 'bulletproof-security').' <font color="green"><strong>&radic; '.__('Custom Permalinks are in use', 'bulletproof-security').'</strong></font>';
		echo $text; 
	}
}

// Check PHP version
function bps_check_php_version() {
	
	if (version_compare(PHP_VERSION, '5.0.0', '>=')) {
    	$text = __('PHP Version Check: ', 'bulletproof-security').'<font color="green"><strong>&radic; '.__('Using PHP5', 'bulletproof-security').'</strong></font><br>';
		echo $text;
}
	if (version_compare(PHP_VERSION, '5.0.0', '<')) {
    	$text = '<font color="red"><strong>'.__('WARNING! BPS requires PHP5 to function correctly. Your PHP version is: ', 'bulletproof-security').PHP_VERSION.'</strong></font><br>';
		echo $text;
	}
}

// Heads Up Display - Check PHP version - top error message new activations / installations
function bps_check_php_version_error() {
	
	if (version_compare(PHP_VERSION, '5.0.0', '>=')) {
    	echo '';
	}
	if (version_compare(PHP_VERSION, '5.0.0', '<')) {
		$text = '<div style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:0px 5px;"><font color="red">'.__('WARNING! BPS requires at least PHP5 to function correctly. Your PHP version is: ', 'bulletproof-security').PHP_VERSION.'</font><br><a href="http://www.ait-pro.com/aitpro-blog/1166/bulletproof-security-plugin-support/bulletproof-security-plugin-guide-bps-version-45#bulletproof-security-issues-problems" target="_blank">'.__('BPS Guide - PHP5 Solution', 'bulletproof-security').'</a><br>'.__('The BPS Guide will open in a new browser window. You will not be directed away from your WordPress Dashboard.', 'bulletproof-security').'</div>';
		echo $text;
	}
}

add_action('admin_notices', 'bps_check_permalinks_error');

// Heads Up Display w/ Dismiss - Check if Permalinks are enabled - top error message new activations / installations
function bps_check_permalinks_error() {
global $current_user;
$user_id = $current_user->ID;
$permalink_structure = get_option('permalink_structure');
$options = get_option('bulletproof_security_options_monitor');	
	
	if ( current_user_can('manage_options') && get_option('permalink_structure') == '' && !get_user_meta($user_id, 'bps_ignore_Permalinks_notice')) { 
		$text = '<div class="update-nag" style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:2px 5px;margin-top:2px;"><font color="blue">'.__('HUD Check: Custom Permalinks are NOT being used.', 'bulletproof-security').'</font><br>'.__('It is recommended that you use Custom Permalinks: ', 'bulletproof-security').'<a href="http://www.ait-pro.com/aitpro-blog/2304/wordpress-tips-tricks-fixes/permalinks-wordpress-custom-permalinks-wordpress-best-wordpress-permalinks-structure/" target="_blank" title="Link opens in a new Browser window">'.__('How to setup Custom Permalinks', 'bulletproof-security').'</a><br>'.__('To Dismiss this Notice click the Dismiss Notice link below. To Reset Dismiss Notices click the Reset/Recheck Dismiss Notices button on the Security Status page.', 'bulletproof-security').'<br><a href="index.php?bps_Permalinks_nag_ignore=0">'.__('Dismiss Notice', 'bulletproof-security').'</a></div>';
		echo $text;
	} else {
		return;
	}
}

add_action('admin_init', 'bps_Permalinks_nag_ignore');

function bps_Permalinks_nag_ignore() {
global $current_user;
$user_id = $current_user->ID;
        
	if ( isset($_GET['bps_Permalinks_nag_ignore']) && '0' == $_GET['bps_Permalinks_nag_ignore'] ) {
		add_user_meta($user_id, 'bps_ignore_Permalinks_notice', 'true', true);
	}
}

add_action('admin_notices', 'bps_check_iis_supports_permalinks');

// Heads Up Display Dashboard - Check if Windows IIS server and if IIS7 supports permalink rewriting
function bps_check_iis_supports_permalinks() {
global $wp_rewrite, $is_IIS, $is_iis7, $current_user;
$user_id = $current_user->ID;	

	if ( current_user_can('manage_options') && $is_IIS && !iis7_supports_permalinks() && !get_user_meta($user_id, 'bps_ignore_iis_notice') ) {
		$text = '<div class="update-nag" style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:2px 5px;margin-top:2px;"><font color="red">'.__('WARNING! BPS has detected that your Server is a Windows IIS Server that does not support htaccess rewriting.', 'bulletproof-security').'</font><br>'.__('Do NOT activate BulletProof Modes unless you know what you are doing.', 'bulletproof-security').'<br>'.__('Your Server Type is: ', 'bulletproof-security').$_SERVER['SERVER_SOFTWARE'].'<br><a href="http://codex.wordpress.org/Using_Permalinks" target="_blank" title="This link will open in a new browser window.">'.__('WordPress Codex - Using Permalinks - see IIS section', 'bulletproof-security').'</a><br>'.__('To Dismiss this Notice click the Dismiss Notice link below. To Reset Dismiss Notices click the Reset/Recheck Dismiss Notices button on the Security Status page.', 'bulletproof-security').'<br><a href="index.php?bps_iis_nag_ignore=0">'.__('Dismiss Notice', 'bulletproof-security').'</a></div>';
		echo $text;
	} else {
		return;
	}
}

add_action('admin_init', 'bps_iis_nag_ignore');

function bps_iis_nag_ignore() {
global $current_user;
$user_id = $current_user->ID;
        
	if ( isset($_GET['bps_iis_nag_ignore']) && '0' == $_GET['bps_iis_nag_ignore'] ) {
		add_user_meta($user_id, 'bps_ignore_iis_notice', 'true', true);
	}
}

// Heads Up Display - mkdir and chmod errors are suppressed on activation - check if /bps-backup folder exists
function bps_hud_check_bpsbackup() {
$bps_wpcontent_dir = str_replace( ABSPATH, '', WP_CONTENT_DIR);

	if( !is_dir (WP_CONTENT_DIR . '/bps-backup')) {
		$text = '<div style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:0px 5px;"><font color="red">'.__('WARNING! BPS was unable to automatically create the /', 'bulletproof-security').$bps_wpcontent_dir.__('/bps-backup folder.', 'bulletproof-security').'</font><br>'.__('You will need to create the /', 'bulletproof-security').$bps_wpcontent_dir.__('/bps-backup folder manually via FTP. The folder permissions for the bps-backup folder need to be set to 755 in order to successfully perform permanent online backups.', 'bulletproof-security').'<br>'.__('To remove this message permanently click ', 'bulletproof-security').'<a href="http://www.ait-pro.com/aitpro-blog/2566/bulletproof-security-plugin-support/bulletproof-security-error-messages" target="_blank">'.__('here.', 'bulletproof-security').'</a></div>';
		echo $text;
	} else {
		echo '';
	}
	if( !is_dir (WP_CONTENT_DIR . '/bps-backup/master-backups')) {
		$text = '<div style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:0px 5px;"><font color="red">'.__('WARNING! BPS was unable to automatically create the /', 'bulletproof-security').$bps_wpcontent_dir.__('/bps-backup/master-backups folder.', 'bulletproof-security').'</font><br>'.__('You will need to create the /', 'bulletproof-security').$bps_wpcontent_dir.__('/bps-backup/master-backups folder manually via FTP. The folder permissions for the master-backups folder need to be set to 755 in order to successfully perform permanent online backups.', 'bulletproof-security').'<br>'.__('To remove this message permanently click ', 'bulletproof-security').'<a href="http://www.ait-pro.com/aitpro-blog/2566/bulletproof-security-plugin-support/bulletproof-security-error-messages" target="_blank">'.__('here.', 'bulletproof-security').'</a></div>';
		echo $text;
	} else {
		echo '';
	}
}

// Heads Up Display - Check if PHP Safe Mode is On - 1 is On - 0 is Off
function bps_check_safemode() {
	
	if (ini_get('safe_mode') == 1) {
		$text = '<div style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:0px 5px;"><font color="red">'.__('WARNING! BPS has detected that Safe Mode is set to On in your php.ini file.', 'bulletproof-security').'</font><br>'.__('If you see errors that BPS was unable to automatically create the backup folders this is probably the reason why.', 'bulletproof-security').'<br>'.__('To remove this message permanently click ', 'bulletproof-security').'<a href="http://www.ait-pro.com/aitpro-blog/2566/bulletproof-security-plugin-support/bulletproof-security-error-messages" target="_blank">'.__('here.', 'bulletproof-security').'</a></div>';
		echo $text;
	} else {
		echo '';
	}
}

// Heads Up Display - Check if W3TC is active or not and check root htaccess file for W3TC htaccess code 
function bps_w3tc_htaccess_check($plugin_var) {
$filename = ABSPATH . '.htaccess';
$string = file_get_contents($filename);
$bpsSiteUrl = get_option('siteurl');
$bpsHomeUrl = get_option('home');
$plugin_var = 'w3-total-cache/w3-total-cache.php';
$return_var = in_array( $plugin_var, apply_filters('active_plugins', get_option('active_plugins')));
	
	if ($return_var == 1 || is_plugin_active_for_network( 'w3-total-cache/w3-total-cache.php' )) { // checks if W3TC is active for Single site or Network
		if ($bpsSiteUrl == $bpsHomeUrl) {
		if (!strpos($string, "W3TC")) {
			$text = '<div style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:0px 5px;"><font color="red">'.__('W3 Total Cache is activated, but W3TC htaccess code was NOT found in your root htaccess file.', 'bulletproof-security').'</font><br>'.__('W3TC needs to be redeployed by clicking either the W3TC auto-install or deploy buttons. Your Root htaccess file must be temporarily unlocked so that W3TC can write to your Root htaccess file. Click to ', 'bulletproof-security').'<a href="admin.php?page=w3tc_general">'.__('Redeploy W3TC.', 'bulletproof-security').'</a><br>'.__('You can copy W3TC .htaccess code from your Root .htaccess file to BPS Custom Code to save it permanently so that you will not have to do these steps in the future.', 'bulletproof-security').'<br>'.__('Copy W3TC .htaccess code to this BPS Custom Code text box: CUSTOM CODE TOP PHP/PHP.INI HANDLER/CACHE CODE, click the Save Root Custom Code button, go to the BPS Security Modes page, click the Create secure.htaccess File AutoMagic button and activate Root folder BulletProof Mode again.', 'bulletproof-security').'</div>';
			echo $text;		
		} 
		}
	}
	elseif ($return_var != 1 || !is_plugin_active_for_network( 'w3-total-cache/w3-total-cache.php' )) { // checks if W3TC is active for Single site or Network
		if ($bpsSiteUrl == $bpsHomeUrl) {
		if (strpos($string, "W3TC")) {
			$text = '<div style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:0px 5px;"><font color="red">'.__('W3 Total Cache is deactivated and W3TC .htaccess code was found in your root .htaccess file.', 'bulletproof-security').'</font><br>'.__('If this is just temporary then this warning message will go away when you reactivate W3TC. If you are planning on uninstalling W3TC the W3TC .htaccess code will be automatically removed from your root .htaccess file when you uninstall W3TC. If you manually edit your root htaccess file then refresh your browser to perform a new HUD htaccess file check.', 'bulletproof-security').'</div>';
			echo $text;
		}
		} 
	}
}

// Heads Up Display - Check if WPSC is active or not and check root htaccess file for WPSC htaccess code 
function bps_wpsc_htaccess_check($plugin_var) {
$filename = ABSPATH . '.htaccess';
$string = file_get_contents($filename);
$bpsSiteUrl = get_option('siteurl');
$bpsHomeUrl = get_option('home');
$plugin_var = 'wp-super-cache/wp-cache.php';
$return_var = in_array( $plugin_var, apply_filters('active_plugins', get_option('active_plugins')));

	if ($return_var == 1 || is_plugin_active_for_network( 'wp-super-cache/wp-cache.php' )) { // checks if WPSC is active for Single site or Network
		if ($bpsSiteUrl == $bpsHomeUrl) {
		if (!strpos($string, "WPSuperCache")) { 
			$text = '<div style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:0px 5px;"><font color="red">'.__('WP Super Cache is activated, but either you are not using WPSC mod_rewrite to serve cache files or the WPSC htaccess code was NOT found in your root htaccess file.', 'bulletproof-security').'</font><br>'.__('If you are not using WPSC mod_rewrite then copy this: # WPSuperCache to this BPS Custom Code text box: CUSTOM CODE TOP PHP/PHP.INI HANDLER/CACHE CODE, click the Save Root Custom Code button, go to the Security Modes page, click the Create secure.htaccess File AutoMagic button and activate Root folder BulletProof Mode again.', 'bulletproof-security').'<br>'.__('If you are using WPSC mod_rewrite and the WPSC htaccess code is not in your root htaccess file then unlock your Root htaccess file temporarily then click this ', 'bulletproof-security').'<a href="options-general.php?page=wpsupercache&tab=settings">'.__('Update WPSC link', 'bulletproof-security').'</a>'.__(' to go to the WPSC Settings page and click the Update Mod_Rewrite Rules button.', 'bulletproof-security').'<br>'.__('If you have put your site in Default Mode then disregard this Alert and DO NOT update your Mod_Rewrite Rules. Refresh your browser to perform a new htaccess file check.', 'bulletproof-security').'<br>'.__('You can copy WPSC .htaccess code from your Root .htaccess file to BPS Custom Code to save it permanently so that you will not have to do these steps in the future.', 'bulletproof-security').'<br>'.__('Copy WPSC .htaccess code to this BPS Custom Code text box: CUSTOM CODE TOP PHP/PHP.INI HANDLER/CACHE CODE, click the Save Root Custom Code button, go to the BPS Security Modes page, click the Create secure.htaccess File AutoMagic button and activate Root folder BulletProof Mode again.', 'bulletproof-security').'</div>';
			echo $text;		
		} 
		}
	}
	elseif ($return_var != 1 || !is_plugin_active_for_network( 'wp-super-cache/wp-cache.php' )) { // checks if WPSC is NOT active for Single or Network
		if ($bpsSiteUrl == $bpsHomeUrl) {
		if (strpos($string, "WPSuperCache") ) {
			$text = '<div style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:0px 5px;"><font color="red">'.__('WP Super Cache is deactivated and WPSC .htaccess code - # BEGIN WPSuperCache # END WPSuperCache - was found in your root .htaccess file.', 'bulletproof-security').'</font><br>'.__('If this is just temporary then this warning message will go away when you reactivate WPSC. You will need to set up and reconfigure WPSC again when you reactivate WPSC. If you are planning on uninstalling WPSC the WPSC .htaccess code will be automatically removed from your root .htaccess file when you uninstall WPSC. If you added this commented out line of code in anywhere in your root htaccess file - # WPSuperCache - then delete it and refresh your browser.', 'bulletproof-security').'</div>';
			echo $text;
		}
		} 
	}
}

// Get WordPress Root Installation Folder - Borrowed from WP Core 
function bps_wp_get_root_folder() {
$site_root = parse_url(get_option('siteurl'));
	
	if ( isset( $site_root['path'] ) )
		$site_root = trailingslashit($site_root['path']);
	else
		$site_root = '/';
	return $site_root;
}

// Display Root or Subfolder Installation Type
function bps_wp_get_root_folder_display_type() {
$site_root = parse_url(get_option('siteurl'));
	
	if ( isset( $site_root['path'] ) )
		$site_root = trailingslashit($site_root['path']);
	else
		$site_root = '/';
	if (preg_match('/[a-zA-Z0-9]/', $site_root)) {
		_e('Subfolder Installation', 'bulletproof-security');
	} else {
		_e('Root Folder Installation', 'bulletproof-security');
	}
}

// System Info page - Check for GWIOD
function bps_gwiod_site_type_check() {
$WordPress_Address_url = get_option('home');
$Site_Address_url = get_option('siteurl');
	
	if ($WordPress_Address_url == $Site_Address_url) {
		echo '<strong>'.__('Standard WP Site Type', 'bulletproof-security').'</strong>';
	} else {
		echo '<strong>'.__('GWIOD WP Site Type', 'bulletproof-security').'</strong><br>';
		echo '<strong>'.__('WordPress Address (URL): ', 'bulletproof-security').$WordPress_Address_url.'</strong><br>';
		echo '<strong>'.__('Site Address (URL): ', 'bulletproof-security').$Site_Address_url.'</strong>';
	}	
}

// System Info page - Check for BuddyPress
function bps_buddypress_site_type_check() {

	if ( function_exists('bp_is_active') ) {
		echo '<strong>'.__('BuddyPress is installed/enabled', 'bulletproof-security').'</strong>';
	} else {
		echo '<strong>'.__('BuddyPress is not installed/enabled', 'bulletproof-security').'</strong>';
	}
}

// System Info page - Check for bbPress
function bps_bbpress_site_type_check() {

	if ( function_exists('is_bbpress') ) {
		echo '<strong>'.__('bbPress is installed/enabled', 'bulletproof-security').'</strong>';
	} else {
		echo '<strong>'.__('bbPress is not installed/enabled', 'bulletproof-security').'</strong>';
	}
}

// Check for Multisite
function bps_multsite_check() {  
	
	if ( is_multisite() ) { 
		$text = '<strong>'.__('Multisite is installed/enabled', 'bulletproof-security').'</strong>';
		echo $text;
	} else {
		$text = '<strong>'.__('Multisite is not installed/enabled', 'bulletproof-security').'</strong>';
		echo $text;
	}
}

// Security Modes Page - AutoMagic Single site message
function bps_multsite_check_smode_single() {  

	if ( !is_multisite() ) { 
		$text = '<div class="automagic-text">'.__('Use These AutoMagic Buttons For Your Website', 'bulletproof-security').'<br>'.__('For Standard WP Installations', 'bulletproof-security').'</div>';
		echo $text;
	} else {
		$text = '<strong>'.__('Do Not Use These AutoMagic Buttons', 'bulletproof-security').'</strong><br>'.__('For Standard WP Single Sites Only', 'bulletproof-security');
		echo $text;
	}
}

// Security Modes Page - AutoMagic Multisite sub-directory message
function bps_multsite_check_smode_MUSDir() {  
	
	if ( is_multisite() && !is_subdomain_install() ) { 
		$text = '<div class="automagic-text">'.__('Use These AutoMagic Buttons For Your Website', 'bulletproof-security').'<br>'.__('For WP Network / Multisite sub-directory Installations', 'bulletproof-security').'</div>';
		echo $text;
	} else {
		$text = '<strong>'.__('Do Not Use These AutoMagic Buttons', 'bulletproof-security').'</strong><br>'.__('For Multisite subdirectory Websites Only', 'bulletproof-security');
		echo $text;
	}
}

// Security Modes Page - AutoMagic Multisite sub-domain message
function bps_multsite_check_smode_MUSDom() {  
	
	if ( is_multisite() && is_subdomain_install() ) { 
		$text = '<div class="automagic-text">'.__('Use These AutoMagic Buttons For Your Website', 'bulletproof-security').'<br>'.__('For WP Network / Multisite sub-domain Installations', 'bulletproof-security').'</div>';
		echo $text;
	} else {
		$text = '<strong>'.__('Do Not Use These AutoMagic Buttons', 'bulletproof-security').'</strong><br>'.__('For Multisite subdomain Websites Only', 'bulletproof-security');
		echo $text;
	}
}

// Check if username Admin exists
function bps_check_admin_username() {
global $wpdb;
$name = $wpdb->get_var("SELECT user_login FROM $wpdb->users WHERE user_login='admin'");
	
	if ($name == "admin"){
		$text = '<font color="green"><strong>'.__('Recommended Security Changes: Username '.'"'.'admin'.'"'.' is being used. It is recommended that you change the default administrator username "admin" to a new unique username.', 'bulletproof-security').'</strong></font><br><br>';
		echo $text;
	} else {
		$text = '<font color="green"><strong>&radic; '.__('The Default Admin username '.'"'.'admin'.'"'.' is not being used', 'bulletproof-security').'</strong></font><br>';
		echo $text;
	}
}

// Check for WP readme.html file and if valid BPS .htaccess file is activated
// .49 check - will only check the 9 in position 15 - offset 14
function bps_filesmatch_check_readmehtml() {
global $bps_readme_install_ver;
$htaccess_filename = ABSPATH . '.htaccess';
$filename = ABSPATH . 'readme.html';
$section = @file_get_contents($htaccess_filename, NULL, NULL, 3, 45);
$check_string = @strpos($section, $bps_readme_install_ver, 14);
$check_stringBPSQSE = @file_get_contents($htaccess_filename);
	
	if ( file_exists($htaccess_filename) ) {
		if ($check_string == "15") { 
			echo '';
		}
		
		if ( !file_exists($filename) ) {
			$text = '<font color="black"><strong>&radic; '.__('The WP readme.html file does not exist', 'bulletproof-security').'</strong></font><br>';
			echo $text;
		} else {
		
		if ($check_string == "15" && strpos($check_stringBPSQSE, "BPSQSE")) {
			$text = '<font color="green"><strong>&radic; '.__('The WP readme.html file is .htaccess protected', 'bulletproof-security').'</strong></font><br>';
			echo $text;
		} else {
			$text = '<font color="red"><strong>'.__('The WP readme.html file is not .htaccess protected', 'bulletproof-security').'</strong></font><br>';
			echo $text;
		}
		}
	}
}

// Check for WP /wp-admin/install.php file and if valid BPS .htaccess file is activated
// .49 check - will only check the 9 in position 15 - offset 14
function bps_filesmatch_check_installphp() {
global $bps_readme_install_ver;
$htaccess_filename = ABSPATH . 'wp-admin/.htaccess';
$filename = ABSPATH . 'wp-admin/install.php';
$check_stringBPSQSE = @file_get_contents($htaccess_filename);
$section = @file_get_contents($htaccess_filename, NULL, NULL, 3, 45);
$check_string = @strpos($section, $bps_readme_install_ver, 14);	
	
	if ( file_exists($htaccess_filename) ) {
		if ($check_string == "15") { 
			echo '';
		}
		
		if ( !file_exists($filename) ) {
			$text = '<font color="green"><strong>&radic; '.__('The WP /wp-admin/install.php file does not exist', 'bulletproof-security').'</strong></font><br>';
			echo $text;
		} else {
		
		if ($check_string == "15" && strpos($check_stringBPSQSE, "BPSQSE-check")) {
			$text = '<font color="green"><strong>&radic; '.__('The WP /wp-admin/install.php file is .htaccess protected', 'bulletproof-security').'</strong></font><br>';
			echo $text;
		} else {
			$text = '<font color="red"><strong>'.__('The WP /wp-admin/install.php file is not .htaccess protected', 'bulletproof-security').'</strong></font><br>';
			echo $text;
		}
		}
	}
}

// Check BPS Pro Modules Status
function check_bps_pro_mod () {
global $bulletproof_security;
$filename_pro = WP_PLUGIN_DIR . '/bulletproof-security/admin/options-bps-pro-modules.php';
	
	if ( file_exists($filename_pro) ) {
		$section_pro = file_get_contents(ABSPATH . $filename, NULL, NULL, 5, 10);
		$text = '<font color="green"><strong>&radic; '.__('BulletProof Security Pro Modules are installed and activated.', 'bulletproof-security').'</strong></font><br>';
		echo $text;
	var_dump($section_pro);
	} else {
		$text = '<font color="black"><br>*'.__('BPS Pro Modules are not installed', 'bulletproof-security').'</font><br>';
		echo $text;
	}
}

// Get SQL Mode from WPDB
function bps_get_sql_mode() {
global $wpdb;
$mysqlinfo = $wpdb->get_results("SHOW VARIABLES LIKE 'sql_mode'");
	
	if (is_array($mysqlinfo)) $sql_mode = $mysqlinfo[0]->Value;
	if (empty($sql_mode)) $sql_mode = _e('Not Set', 'bulletproof-security');
	else $sql_mode = _e('Off', 'bulletproof-security');
} 

// Show DB errors should already be set to false in /includes/wp-db.php
// Extra function insurance show_errors = false
function bps_wpdb_errors_off() {
global $wpdb;
$wpdb->show_errors = false;
	
	if ($wpdb->show_errors != false) {
		$text = '<font color="red"><strong>'.__('WARNING! WordPress DB Show Errors Is Set To: true! DB errors will be displayed', 'bulletproof-security').'</strong></font><br>';
		echo $text;
	} else {
		$text = '<font color="green"><strong>&radic; '.__('WordPress DB Show Errors Function Is Set To: ', 'bulletproof-security').'</strong></font><font color="black"><strong> '.__('false', 'bulletproof-security').'</strong></font><br><font color="green"><strong>&radic; '.__('WordPress Database Errors Are Turned Off', 'bulletproof-security').'</strong></font><br>';
		echo $text;
	}	
}

// Hide / Remove WordPress Version Meta Generator Tag - echo only for remove_action('wp_head', 'wp_generator');
function bps_wp_remove_version() {
global $wp_version;
	$text = '<font color="green"><strong>&radic; '.__('WordPress Meta Generator Tag Removed', 'bulletproof-security').'<br>&radic; '.__('WordPress Version Is Not Displayed / Not Shown', 'bulletproof-security').'</strong></font><br>';
	echo $text;
}

// Return Nothing For WP Version Callback
function bps_wp_generator_meta_removed() {
	if ( !is_admin() ) {
		global $wp_version;
		$wp_version = '';
	}
}

add_action('admin_notices', 'bps_hud_NetworkActivationAlert_notice');

// Heads Up Display - Multisite/Network ONLY - BPS Pro Network Activation or Single activation for subsites
function bps_hud_NetworkActivationAlert_notice() {
global $current_user, $blog_id;
$user_id = $current_user->ID;

	if ( !is_multisite() ) {
		return;
	}
	
	if ( is_multisite() && is_super_admin() && !get_user_meta($user_id, 'bps_hud_NetworkActivationAlert_notice') ) {
		$text = '<div class="update-nag" style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:2px 5px;margin-top:2px;"><font color="blue">'.__('New Feature Notice: BPS can now be Network Activated on Multisite', 'bulletproof-security').'</font><br>'.__('Go to the BPS Whats New tab page for details about the new BPS Network/Multisite capabilities.', 'bulletproof-security').'<br>'.__('or just click the Dismiss Notice link below if you do not want to allow BPS to be used on your Multisite subsites.', 'bulletproof-security').'<br>'.__('To Reset Dismiss Notices click the Reset/Recheck Dismiss Notices button on the Security Status page.', 'bulletproof-security').'<br><a href="index.php?bps_networkactivation_nag_ignore=0">'.__('Dismiss Notice', 'bulletproof-security').'</a></div>';	
		echo $text;	
	}
}

add_action('admin_init', 'bps_networkactivation_nag_ignore');

function bps_networkactivation_nag_ignore() {
global $current_user;
$user_id = $current_user->ID;
        
	if ( !is_multisite() ) {
		return;
	}

	if ( isset($_GET['bps_networkactivation_nag_ignore']) && '0' == $_GET['bps_networkactivation_nag_ignore'] ) {
		add_user_meta($user_id, 'bps_hud_NetworkActivationAlert_notice', 'true', true);
	}
}

add_action('admin_notices', 'bps_brute_force_login_protection_notice');

// Dismiss Notice - Bonus Custom Code: Brute Force Login Protection code
function bps_brute_force_login_protection_notice() {
global $current_user;
$user_id = $current_user->ID;	
	
	if ( current_user_can('manage_options') && !get_user_meta($user_id, 'bps_brute_force_login_protection_notice') ) { 

		$text = '<div class="update-nag" style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:2px 5px;margin-top:2px;"><font color="blue">'.__('Bonus Custom Code: Brute Force Login Protection', 'bulletproof-security').'</font><br><a href="http://forum.ait-pro.com/forums/topic/protect-login-page-from-brute-force-login-attacks/" target="_blank">'.__('Click Here', 'bulletproof-security').'</a>'.__(' to get additional Brute Force Login Protection code for your website.', 'bulletproof-security').'<br>'.__('To Dismiss this Notice click the Dismiss Notice link below. To Reset Dismiss Notices click the Reset/Recheck Dismiss Notices button on the Security Status page.', 'bulletproof-security').'<br><a href="index.php?bps_brute_force_login_protection_nag_ignore=0">'.__('Dismiss Notice', 'bulletproof-security').'</a></div>';
		echo $text;
	}
}

add_action('admin_init', 'bps_brute_force_login_protection_nag_ignore');

function bps_brute_force_login_protection_nag_ignore() {
global $current_user;
$user_id = $current_user->ID;
        
	if ( isset($_GET['bps_brute_force_login_protection_nag_ignore']) && '0' == $_GET['bps_brute_force_login_protection_nag_ignore'] ) {
		add_user_meta($user_id, 'bps_brute_force_login_protection_notice', 'true', true);
	}
}

add_action('admin_notices', 'bps_speed_boost_cache_notice');

// Dismiss Notice - Bonus Custom Code: Speed Boost Cache code
// Only display this Dismiss notice if the Brute Force Login Protection Dismiss Notice has already been dismissed == true
function bps_speed_boost_cache_notice() {
global $current_user;
$user_id = $current_user->ID;	
	
	if ( current_user_can('manage_options') && !get_user_meta($user_id, 'bps_speed_boost_cache_notice') && get_user_meta($user_id, 'bps_brute_force_login_protection_notice', true) ) { 

		$text = '<div class="update-nag" style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:2px 5px;margin-top:2px;"><font color="blue">'.__('Bonus Custom Code: Speed Boost Cache Code', 'bulletproof-security').'</font><br><a href="http://forum.ait-pro.com/forums/topic/htaccess-caching-code-speed-boost-cache-code/" title="Link opens in a new Browser window" target="_blank">'.__('Click Here', 'bulletproof-security').'</a>'.__(' to get Speed Boost Cache code to speed up your website.', 'bulletproof-security').'<br>'.__('To Dismiss this Notice click the Dismiss Notice link below. To Reset Dismiss Notices click the Reset/Recheck Dismiss Notices button on the Security Status page.', 'bulletproof-security').'<br><a href="index.php?bps_speed_boost_cache_nag_ignore=0">'.__('Dismiss Notice', 'bulletproof-security').'</a></div>';
		echo $text;
	}
}

add_action('admin_init', 'bps_speed_boost_cache_nag_ignore');

function bps_speed_boost_cache_nag_ignore() {
global $current_user;
$user_id = $current_user->ID;
        
	if ( isset($_GET['bps_speed_boost_cache_nag_ignore']) && '0' == $_GET['bps_speed_boost_cache_nag_ignore'] ) {
		add_user_meta($user_id, 'bps_speed_boost_cache_notice', 'true', true);
	}
}

add_action('admin_notices', 'bps_author_enumeration_notice');

// Dismiss Notice - Bonus Custom Code: WP AUTHOR ENUMERATION BOT PROBE PROTECTION
// Only display this Dismiss notice if the Speed Boost Cache code Dismiss Notice has already been dismissed == true
function bps_author_enumeration_notice() {
global $current_user;
$user_id = $current_user->ID;	
	
	if ( current_user_can('manage_options') && !get_user_meta($user_id, 'bps_author_enumeration_notice') && get_user_meta($user_id, 'bps_speed_boost_cache_notice', true) ) { 

		$text = '<div class="update-nag" style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:2px 5px;margin-top:2px;"><font color="blue">'.__('Bonus Custom Code: Author Enumeration BOT Probe Code', 'bulletproof-security').'</font><br><a href="http://forum.ait-pro.com/forums/topic/wordpress-author-enumeration-bot-probe-protection-author-id-user-id/" title="Link opens in a new Browser window" target="_blank">'.__('Click Here', 'bulletproof-security').'</a>'.__(' to get Author Enumeration BOT Probe Code. Protects against hacker bots finding Author names & User names on your website.', 'bulletproof-security').'<br>'.__('To Dismiss this Notice click the Dismiss Notice link below. To Reset Dismiss Notices click the Reset/Recheck Dismiss Notices button on the Security Status page.', 'bulletproof-security').'<br><a href="index.php?bps_author_enumeration_nag_ignore=0">'.__('Dismiss Notice', 'bulletproof-security').'</a></div>';
		echo $text;
	}
}

add_action('admin_init', 'bps_author_enumeration_nag_ignore');

function bps_author_enumeration_nag_ignore() {
global $current_user;
$user_id = $current_user->ID;
        
	if ( isset($_GET['bps_author_enumeration_nag_ignore']) && '0' == $_GET['bps_author_enumeration_nag_ignore'] ) {
		add_user_meta($user_id, 'bps_author_enumeration_notice', 'true', true);
	}
}

add_action('admin_notices', 'bps_ignore_PhpiniHandler_notice');

// HUD w/ Dismiss - Check if php.ini handler code exists in root .htaccess file, but not in Custom Code
// Only display this Dismiss notice if the Speed Boost Dismiss Notice has already been dismissed
function bps_ignore_PhpiniHandler_notice() {
global $current_user;
$user_id = $current_user->ID;
$CustomCodeoptions = get_option('bulletproof_security_options_customcode');	
$file = ABSPATH . '.htaccess';
$file_contents = @file_get_contents($file);

	if ( current_user_can('manage_options') && !get_user_meta($user_id, 'bps_ignore_PhpiniHandler_notice') && get_user_meta($user_id, 'bps_speed_boost_cache_notice', true) ) { 
	
	if ( file_exists($file) ) {		

		preg_match_all('/AddHandler|SetEnv PHPRC|suPHP_ConfigPath|Action application/', $file_contents, $matches);
		preg_match_all('/AddHandler|SetEnv PHPRC|suPHP_ConfigPath|Action application/', $CustomCodeoptions['bps_customcode_one'], $DBmatches);
		
		if ( $matches[0] && !$DBmatches[0] ) {
			$text = '<div class="update-nag" style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:2px 5px;margin-top:2px;"><font color="blue">'.__('HUD Check: PHP/php.ini handler htaccess code check', 'bulletproof-security').'</font><br>'.__('PHP/php.ini handler htaccess code was found in your root .htaccess file, but was NOT found in BPS Custom Code.', 'bulletproof-security').'<br>'.__('It is recommended that you copy your PHP/php.ini handler htaccess code in your root htaccess file to BPS Custom Code.', 'bulletproof-security').'<br><a href="http://forum.ait-pro.com/forums/topic/pre-installation-wizard-checks-phpphp-ini-handler-htaccess-code-check/" target="_blank" title="Link opens in a new Browser window">'.__('Click Here', 'bulletproof-security').'</a>'.__(' for instructions on how to copy your PHP/php.ini handler htaccess code to BPS Custom Code.', 'bulletproof-security').'<br>'.__('To Dismiss this Notice click the Dismiss Notice link below. To Dismiss this Notice click the Dismiss Notice link below. To Reset Dismiss Notices click the Reset/Recheck Dismiss Notices button on the Security Status page.', 'bulletproof-security').'<br><a href="index.php?bps_PhpiniHandler_nag_ignore=0">'.__('Dismiss Notice', 'bulletproof-security').'</a></div>';
			echo $text;			
		}
	}
	}
}

add_action('admin_init', 'bps_PhpiniHandler_nag_ignore');

function bps_PhpiniHandler_nag_ignore() {
global $current_user;
$user_id = $current_user->ID;
        
	if ( isset($_GET['bps_PhpiniHandler_nag_ignore']) && '0' == $_GET['bps_PhpiniHandler_nag_ignore'] ) {
		add_user_meta($user_id, 'bps_ignore_PhpiniHandler_notice', 'true', true);
	}
}

// New Login Security Options notification - Error Messages & Password Reset options
// This admin notice is only displayed for BPS upgrade installations
function bps_LS_new_options_notification() {
$BPSoptions = get_option('bulletproof_security_options_login_security');

	if ( !get_option('bulletproof_security_options_login_security') ) {
		return;
	}
	
	if ( @$BPSoptions['bps_max_logins'] && @!$BPSoptions['bps_login_security_errors'] || @!$BPSoptions['bps_login_security_errors'] ) {
		$text = '<div class="update-nag" style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:2px 5px;margin-top:2px;"><font color="blue">'.__('New Login Security Options Notification', 'bulletproof-security').'</font><br><a href="admin.php?page=bulletproof-security/admin/login/login.php">'.__('Click Here', 'bulletproof-security').'</a>'.__(' to go to Login Security page and choose the settings you want to use for these 2 new Login Security Options:', 'bulletproof-security').'<br>'.__('Error Messages Option & Password Reset Option and then click the Save Options button.', 'bulletproof-security').'</div>';
		echo $text;		
	}
}

add_action('admin_notices', 'bps_LS_new_options_notification');

add_action('admin_notices', 'bps_ignore_sucuri_notice');

// HUD w/ Dismiss Notice - Sucuri 1-click Hardening wp-content .htaccess file problem - causes BPS Security Error Logging not to work
function bps_ignore_sucuri_notice() {
global $current_user;
$user_id = $current_user->ID;	
$filename = WP_CONTENT_DIR . '/.htaccess';
$check_string = @file_get_contents($filename);
$plugin_var = 'sucuri-scanner/sucuri.php';
$return_var = in_array( $plugin_var, apply_filters('active_plugins', get_option('active_plugins')));

	if ( $return_var == 1 && !file_exists($filename) ) { // 1 equals active
		return;	
	}
	
	if ( $return_var == 1 && file_exists($filename) && strpos($check_string, "deny from all") ) { // 1 equals active	
	
		if ( current_user_can('manage_options') && !get_user_meta($user_id, 'bps_ignore_sucuri_notice') ) { 
			$text = '<div class="update-nag" style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:2px 5px;margin-top:2px;"><font color="red">'.__('Sucuri 1-click Hardening wp-content .htaccess file problem detected', 'bulletproof-security').'</font><br>'.__('Using the Sucuri 1-click Hardening wp-content .htaccess file option will prevent BPS Security Error Logging from working.', 'bulletproof-security').'<br>'.__('To fix this issue delete the Sucuri .htaccess file in your wp-content folder.', 'bulletproof-security').'<br>'.__('To Dismiss this Notice click the Dismiss Notice link below. To Dismiss this Notice click the Dismiss Notice link below. To Reset Dismiss Notices click the Reset/Recheck Dismiss Notices button on the Security Status page.', 'bulletproof-security').'<br><a href="index.php?bps_sucuri_nag_ignore=0">'.__('Dismiss Notice', 'bulletproof-security').'</a></div>';
			echo $text;		
		}
	}
}

add_action('admin_init', 'bps_sucuri_nag_ignore');

function bps_sucuri_nag_ignore() {
global $current_user;
$user_id = $current_user->ID;
        
	if ( isset($_GET['bps_sucuri_nag_ignore']) && '0' == $_GET['bps_sucuri_nag_ignore'] ) {
		add_user_meta($user_id, 'bps_ignore_sucuri_notice', 'true', true);
	}
}

add_action('admin_notices', 'bps_ignore_BLC_notice');

// HUD w/ Dismiss - Broken Link Checker plugin - HEAD Request Method filter check
function bps_ignore_BLC_notice() {
global $current_user;
$user_id = $current_user->ID;
$filename = ABSPATH . '.htaccess';
$check_string = @file_get_contents($filename);
$plugin_var = 'broken-link-checker/broken-link-checker.php';
$return_var = in_array( $plugin_var, apply_filters('active_plugins', get_option('active_plugins')));

    if ( $return_var == 1 && !strpos($check_string, "HEAD|TRACE|DELETE|TRACK|DEBUG") ) { // 1 equals active
		return;
	}
	
	if ( $return_var == 1 && strpos($check_string, "HEAD|TRACE|DELETE|TRACK|DEBUG") ) {
		
		if ( current_user_can('manage_options') && !get_user_meta($user_id, 'bps_ignore_BLC_notice') ) { 
			$text = '<div class="update-nag" style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:2px 5px;margin-top:2px;"><font color="red">'.__('Broken Link Checker plugin HEAD Request Method filter problem detected', 'bulletproof-security').'</font><br><strong>'.__('To fix this problem ', 'bulletproof-security').'<a href="http://forum.ait-pro.com/forums/topic/broken-link-checker-plugin-403-error/" target="_blank">'.__('Click Here', 'bulletproof-security').'</a><br>'.__('To Dismiss this Notice click the Dismiss Notice link below. To Dismiss this Notice click the Dismiss Notice link below. To Reset Dismiss Notices click the Reset/Recheck Dismiss Notices button on the Security Status page.', 'bulletproof-security').'<br><a href="index.php?bps_BLC_nag_ignore=0">'.__('Dismiss Notice', 'bulletproof-security').'</a></div>';
			echo $text;
		}		
	}
}

add_action('admin_init', 'bps_BLC_nag_ignore');

function bps_BLC_nag_ignore() {
global $current_user;
$user_id = $current_user->ID;
        
	if ( isset($_GET['bps_BLC_nag_ignore']) && '0' == $_GET['bps_BLC_nag_ignore'] ) {
		add_user_meta($user_id, 'bps_ignore_BLC_notice', 'true', true);
	}
}

/***********************************************/
// BPS Free - Zip, Email, Delete Log File Cron //
/***********************************************/
// 262144 bytes = 256KB = .25MB
// 524288 bytes = 512KB = .5MB
// 1048576 bytes = 1024KB = 1MB
// 2097152 bytes = 2048KB = 2MB
// FailSafe - if log file is larger than 2MB zip, email and delete or just delete

// Pre-save Email Alerting & Log file zip, email and delete DB options
// or pre-save DB options for BPS upgraders
function bps_email_alerts_log_file_options() {
$SecurityLogEmailOptions = get_option('bulletproof_security_options_email');
$admin_email = get_option('admin_email');

	$bps_option_name = 'bulletproof_security_options_email';
	$bps_new_value_1 = $admin_email;
	$bps_new_value_2 = $admin_email;	
	$bps_new_value_3 = '';
	$bps_new_value_4 = '';
	$bps_new_value_5 = 'lockoutOnly';
	$bps_new_value_6 = '500KB';
	$bps_new_value_7 = 'email';

	$BPS_Options = array(
	'bps_send_email_to' => $bps_new_value_1, 
	'bps_send_email_from' => $bps_new_value_2, 
	'bps_send_email_cc' => $bps_new_value_3, 
	'bps_send_email_bcc' => $bps_new_value_4, 
	'bps_login_security_email' => $bps_new_value_5, 
	'bps_security_log_size' => $bps_new_value_6, 
	'bps_security_log_emailL' => $bps_new_value_7, 
	);

	if ( !get_option( $bps_option_name ) ) {	
		
		foreach( $BPS_Options as $key => $value ) {
			update_option('bulletproof_security_options_email', $BPS_Options);
		}
	
	} else {

		if ( !$SecurityLogEmailOptions['bps_security_log_size'] && !$SecurityLogEmailOptions['bps_security_log_emailL'] ) {

			$BPS_Options = array(
			'bps_send_email_to' => $SecurityLogEmailOptions['bps_send_email_to'], 
			'bps_send_email_from' => $SecurityLogEmailOptions['bps_send_email_from'], 
			'bps_send_email_cc' => $SecurityLogEmailOptions['bps_send_email_cc'], 
			'bps_send_email_bcc' => $SecurityLogEmailOptions['bps_send_email_bcc'], 
			'bps_login_security_email' => $SecurityLogEmailOptions['bps_login_security_email'], 
			'bps_security_log_size' => '500KB', 
			'bps_security_log_emailL' => 'email'
			);

			foreach( $BPS_Options as $key => $value ) {
				update_option('bulletproof_security_options_email', $BPS_Options);
			}
		}		
	}
}
add_action('admin_notices', 'bps_email_alerts_log_file_options');

add_action('bpsPro_email_log_files', 'bps_Log_File_Processing');

function bpsPro_schedule_Email_Log_Files() {
	if ( !wp_next_scheduled( 'bpsPro_email_log_files' ) ) {
		wp_schedule_event(time(), 'hourly', 'bpsPro_email_log_files');
	}
}
add_action('init', 'bpsPro_schedule_Email_Log_Files');

function bpsPro_add_hourly_email_log_cron( $schedules ) {
	$schedules['hourly'] = array('interval' => 3600, 'display' => __('Once Hourly'));
	return $schedules;
}
add_filter('cron_schedules', 'bpsPro_add_hourly_email_log_cron');

function bps_Log_File_Processing() {
$options = get_option('bulletproof_security_options_email');
$SecurityLog = WP_CONTENT_DIR . '/bps-backup/logs/http_error_log.txt';
$SecurityLogMaster = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/http_error_log.txt';

switch ($options['bps_security_log_size']) {
    case "256KB":
		if ( filesize($SecurityLog) >= 262144 && filesize($SecurityLog) < 524288 || filesize($SecurityLog) > 2097152) {
		if ( $options['bps_security_log_emailL'] == 'email') {
			if ( bps_Zip_Security_Log_File()==TRUE ) {
				bps_Email_Security_Log_File();
			}
		} elseif ( $options['bps_security_log_emailL'] == 'delete') {
			copy($SecurityLogMaster, $SecurityLog);	
		}
		break;
		}
    case "500KB":
		if ( filesize($SecurityLog) >= 524288 && filesize($SecurityLog) < 1048576 || filesize($SecurityLog) > 2097152) {
		if ( $options['bps_security_log_emailL'] == 'email') {
			if ( bps_Zip_Security_Log_File()==TRUE ) {
				bps_Email_Security_Log_File();
			}
		} elseif ( $options['bps_security_log_emailL'] == 'delete') {
			copy($SecurityLogMaster, $SecurityLog);	
		}		
		break;
		}
    case "1MB":
		if ( filesize($SecurityLog) >= 1048576 && filesize($SecurityLog) < 2097152 || filesize($SecurityLog) > 2097152) {
		if ( $options['bps_security_log_emailL'] == 'email') {
			if ( bps_Zip_Security_Log_File()==TRUE ) {
				bps_Email_Security_Log_File();
			}
		} elseif ( $options['bps_security_log_emailL'] == 'delete') {
			copy($SecurityLogMaster, $SecurityLog);	
		}		
		break;
		}
}
}

// EMAIL NOTES: You cannot fake a zip file by renaming a file extension 
// The zip file must be a real zip archive or it will not be successfully attached to an email.
// A plain txt file cannot be attached to an email.
// Email Security Log File
function bps_Email_Security_Log_File() {
$options = get_option('bulletproof_security_options_email');
$bps_email_to = $options['bps_send_email_to'];
$bps_email_from = $options['bps_send_email_from'];
$bps_email_cc = $options['bps_send_email_cc'];
$bps_email_bcc = $options['bps_send_email_bcc'];
$justUrl = get_site_url();
$timestamp = date_i18n(get_option('date_format'), strtotime("11/15-1976")) . ' - ' . date_i18n(get_option('time_format'), strtotime($date));
$SecurityLog = WP_CONTENT_DIR . '/bps-backup/logs/http_error_log.txt';
$SecurityLogMaster = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/http_error_log.txt';
$SecurityLogZip = WP_CONTENT_DIR . '/bps-backup/logs/security-log.zip';
	
	$attachments = array( $SecurityLogZip );
	$headers = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$headers .= "From: $bps_email_from" . "\r\n";
	$headers .= "Cc: $bps_email_cc" . "\r\n";
	$headers .= "Bcc: $bps_email_bcc" . "\r\n";	
	$subject = " BPS Security Log - $timestamp ";
	$message = '<p><font color="blue"><strong>Security Log File For:</strong></font></p>';
	$message .= '<p>Site: '."$justUrl".'</p>'; 
		
	$mailed = wp_mail($bps_email_to, $subject, $message, $headers, $attachments);

	if ( $mailed && file_exists($SecurityLogZip) ) {
		unlink($SecurityLogZip);
		copy($SecurityLogMaster, $SecurityLog);
	}
}

// Zip Security Log File - If ZipArchive Class is not available use PCLZip
function bps_Zip_Security_Log_File() {
	// Use ZipArchive
	if ( class_exists('ZipArchive') ) {

	$zip = new ZipArchive();
	$filename = WP_CONTENT_DIR . '/bps-backup/logs/security-log.zip';
	
	if ($zip->open($filename, ZIPARCHIVE::CREATE)!==TRUE) {
    	exit("Error: Cannot Open $filename\n");
	}

	$zip->addFile(WP_CONTENT_DIR . '/bps-backup/logs/http_error_log.txt', "http_error_log.txt");
	$zip->close();

	return true;

	} else {

// Use PCLZip
define( 'PCLZIP_TEMPORARY_DIR', WP_CONTENT_DIR . '/bps-backup/logs/' );
require_once( ABSPATH . 'wp-admin/includes/class-pclzip.php');
	
	if ( ini_get( 'mbstring.func_overload' ) && function_exists( 'mb_internal_encoding' ) ) {
		$previous_encoding = mb_internal_encoding();
		mb_internal_encoding( 'ISO-8859-1' );
	}
  		$archive = new PclZip(WP_CONTENT_DIR . '/bps-backup/logs/security-log.zip');
  		$v_list = $archive->create(WP_CONTENT_DIR . '/bps-backup/logs/http_error_log.txt', PCLZIP_OPT_REMOVE_PATH, WP_CONTENT_DIR . '/bps-backup/logs/');
  	
	return true;

	if ( $v_list == 0) {
		die("Error : ".$archive->errorInfo(true) );
		return false;	
	}
	}
}

add_action('admin_notices', 'bps_hud_BPSQSE_old_code_check');

// Check for older BPS Query String Exploits code saved to BPS Custom Code
function bps_hud_BPSQSE_old_code_check() {
$CustomCodeoptions = get_option('bulletproof_security_options_customcode');	
$subject = $CustomCodeoptions['bps_customcode_bpsqse'];	
$pattern = '/RewriteCond\s%{QUERY_STRING}\s\(\\\.\/\|\\\.\.\/\|\\\.\.\.\/\)\+\(motd\|etc\|bin\)\s\[NC,OR\]/';

	if ( $CustomCodeoptions['bps_customcode_bpsqse'] == '') {
		return;
	}
	
	if ( $CustomCodeoptions['bps_customcode_bpsqse'] != '' && preg_match($pattern, $subject, $matches) ) {

		$text = '<div class="update-nag" style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:2px 5px;margin-top:2px;"><font color="blue">'.__('Notice: BPS Query String Exploits Code Changes', 'bulletproof-security').'</font><br>'.__('Older BPS Query String Exploits code was found in BPS Custom Code. Several Query String Exploits rules were changed/added/modified in the root .htaccess file in BPS .49.6.', 'bulletproof-security').'<br>'.__('Copy the new Query String Exploits section of code from your root .htaccess file and paste it into this BPS Custom Code text box: CUSTOM CODE BPSQSE BPS QUERY STRING EXPLOITS and click the Save Root Custom Code button.', 'bulletproof-security').'<br>'.__('This Notice will go away once you have copied the new Query String Exploits code to BPS Custom Code and clicked the Save Root Custom Code button.', 'bulletproof-security').'</div>';
		echo $text;
	}
}

// Maintenance Mode On Dashboard Alert
function bpsPro_mmode_dashboard_alert() {
$MMoptions = get_option('bulletproof_security_options_maint_mode');	
$indexPHP = ABSPATH . 'index.php';
$wpadminHtaccess = ABSPATH . 'wp-admin/.htaccess';
$check_string_index = @file_get_contents($indexPHP);
$check_string_wpadmin = @file_get_contents($wpadminHtaccess);

if ( current_user_can('manage_options') ) {

	if ( !is_multisite() ) {
		
	if ( !get_option('bulletproof_security_options_maint_mode') || $MMoptions['bps_maint_on_off'] == 'Off' ) {
	return;
	}	
	
	if ( $MMoptions['bps_maint_on_off'] == 'On' && $MMoptions['bps_maint_dashboard_reminder'] == '1' ) {	
	
		if ( strpos($check_string_index, "BEGIN BPS MAINTENANCE MODE IP") && !strpos($check_string_wpadmin, "BEGIN BPS MAINTENANCE MODE IP") ) {
			$text = '<div class="update-nag" style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:2px 5px;margin-top:2px;"><font color="blue">'.__('Reminder: Frontend Maintenance Mode is Turned On.', 'bulletproof-security').'</font></div>';
			echo $text;				
		} elseif ( !strpos($check_string_index, "BEGIN BPS MAINTENANCE MODE IP") && strpos($check_string_wpadmin, "BEGIN BPS MAINTENANCE MODE IP") ) {
			$text = '<div class="update-nag" style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:2px 5px;margin-top:2px;"><font color="blue">'.__('Reminder: Backend Maintenance Mode is Turned On.', 'bulletproof-security').'</font></div>';
			echo $text;	
		} elseif ( strpos($check_string_index, "BEGIN BPS MAINTENANCE MODE IP") && strpos($check_string_wpadmin, "BEGIN BPS MAINTENANCE MODE IP") ) {
			$text = '<div class="update-nag" style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:2px 5px;margin-top:2px;"><font color="blue">'.__('Reminder: Frontend & Backend Maintenance Modes are Turned On.', 'bulletproof-security').'</font></div>';
			echo $text;				
		}
	}
	}
	
	if ( is_multisite() ) {
		global $current_blog, $blog_id;
		$root_folder_maintenance_values = ABSPATH . 'bps-maintenance-values.php';
		$check_string_values = @file_get_contents($root_folder_maintenance_values);			
	
	if ( $blog_id == 1 && $MMoptions['bps_maint_dashboard_reminder'] == '1' ) {

		if ( strpos($check_string_values, '$all_sites = \'1\';') ) {
			$text = '<div class="update-nag" style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:2px 5px;margin-top:2px;"><font color="blue">'.__('Reminder: Frontend Maintenance Mode is Turned On for The Primary Site and All Subsites.', 'bulletproof-security').'</font></div>';
			echo $text;	
		}
		
		if ( strpos($check_string_values, '$all_subsites = \'1\';') ) {
			$text = '<div class="update-nag" style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:2px 5px;margin-top:2px;"><font color="blue">'.__('Reminder: Frontend Maintenance Mode is Turned On for All Subsites, but Not The Primary Site.', 'bulletproof-security').'</font></div>';
			echo $text;	
		}	
	
	if ( $MMoptions['bps_maint_on_off'] == 'On' ) {

		if ( strpos($check_string_index, '$primary_site_status = \'On\';') && !strpos($check_string_wpadmin, "BEGIN BPS MAINTENANCE MODE IP") ) {
			$text = '<div class="update-nag" style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:2px 5px;margin-top:2px;"><font color="blue">'.__('Reminder: Frontend Maintenance Mode is Turned On.', 'bulletproof-security').'</font></div>';
			echo $text;				
		} elseif ( !strpos($check_string_index, '$primary_site_status = \'On\';') && strpos($check_string_wpadmin, "BEGIN BPS MAINTENANCE MODE IP") ) {
			$text = '<div class="update-nag" style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:2px 5px;margin-top:2px;"><font color="blue">'.__('Reminder: Backend Maintenance Mode is Turned On.', 'bulletproof-security').'</font></div>';
			echo $text;	
		} elseif ( strpos($check_string_index, '$primary_site_status = \'On\';') && strpos($check_string_wpadmin, "BEGIN BPS MAINTENANCE MODE IP") ) {
			$text = '<div class="update-nag" style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:2px 5px;margin-top:2px;"><font color="blue">'.__('Reminder: Frontend & Backend Maintenance Modes are Turned On.', 'bulletproof-security').'</font></div>';
			echo $text;				
		}
	}
	}
	
	if ( $blog_id != 1 ) {
			$subsite_remove_slashes = str_replace( '/', "", $current_blog->path );
			$subsite_maintenance_file = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/bps-maintenance-'.$subsite_remove_slashes.'.php';		

		if ( strpos($check_string_values, '$all_sites = \'1\';') ) {
			$text = '<div class="update-nag" style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:2px 5px;margin-top:2px;"><font color="blue">'.__('Reminder: Frontend Maintenance Mode is Turned On for The Primary Site and All Subsites.', 'bulletproof-security').'</font></div>';
			echo $text;	
		}
		
		if ( strpos($check_string_values, '$all_subsites = \'1\';') ) {
			$text = '<div class="update-nag" style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:2px 5px;margin-top:2px;"><font color="blue">'.__('Reminder: Frontend Maintenance Mode is Turned On for All Subsites, but Not The Primary Site.', 'bulletproof-security').'</font></div>';
			echo $text;	
		}		
		
	if ( $MMoptions['bps_maint_on_off'] == 'On' && $MMoptions['bps_maint_dashboard_reminder'] == '1' ) {

		if ( file_exists($subsite_maintenance_file) && !strpos($check_string_wpadmin, "BEGIN BPS MAINTENANCE MODE IP") ) {
			$text = '<div class="update-nag" style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:2px 5px;margin-top:2px;"><font color="blue">'.__('Reminder: Frontend Maintenance Mode is Turned On.', 'bulletproof-security').'</font></div>';
			echo $text;				
		} elseif ( !file_exists($subsite_maintenance_file) && strpos($check_string_wpadmin, "BEGIN BPS MAINTENANCE MODE IP") ) {
			$text = '<div class="update-nag" style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:2px 5px;margin-top:2px;"><font color="blue">'.__('Reminder: Backend Maintenance Mode is Turned On.', 'bulletproof-security').'</font></div>';
			echo $text;	
		} elseif ( file_exists($subsite_maintenance_file) && strpos($check_string_wpadmin, "BEGIN BPS MAINTENANCE MODE IP") ) {
			$text = '<div class="update-nag" style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:2px 5px;margin-top:2px;"><font color="blue">'.__('Reminder: Frontend & Backend Maintenance Modes are Turned On.', 'bulletproof-security').'</font></div>';
			echo $text;				
		}		
	}
	}
	}
}
}

add_action('admin_notices', 'bpsPro_mmode_dashboard_alert');

// Deletes unused po and mo Language files
function bps_delete_language_files() {
$base_path = WP_PLUGIN_DIR . '/bulletproof-security/languages/';
$lang_fileLTMO = $base_path.'bulletproof-security-lt_LT.mo';
$lang_fileLTPO = $base_path.'bulletproof-security-lt_LT.po';
$lang_fileRUMO = $base_path.'bulletproof-security-ru_RU.mo';
$lang_fileRUPO = $base_path.'bulletproof-security-ru_RU.po';
$lang_fileTLMO = $base_path.'bulletproof-security-tl_TL.mo';
$lang_fileTLPO = $base_path.'bulletproof-security-tl_TL.po';


	if ( defined('WPLANG') ) {

		if ( WPLANG == '' || WPLANG == 'en_US' ) {

		$delete_files = array($lang_fileLTMO, $lang_fileLTPO, $lang_fileRUMO, $lang_fileRUPO, $lang_fileTLMO, $lang_fileTLPO);
	
		foreach ( $delete_files as $file ) {
			if ( file_exists($file) ) {
				@unlink($file);	
			}
		}
		}
	
		if ( WPLANG == 'lt_LT' ) {

		$delete_files = array($lang_fileRUMO, $lang_fileRUPO, $lang_fileTLMO, $lang_fileTLPO);
	
		foreach ( $delete_files as $file ) {
			if ( file_exists($file) ) {
				@unlink($file);	
			}
		}
		}	

		if ( WPLANG == 'ru_RU' ) {

		$delete_files = array($lang_fileLTMO, $lang_fileLTPO, $lang_fileTLMO, $lang_fileTLPO);
	
		foreach ( $delete_files as $file ) {
			if ( file_exists($file) ) {
				@unlink($file);	
			}
		}
		}

		if ( WPLANG == 'tl_TL' ) {

		$delete_files = array($lang_fileLTMO, $lang_fileLTPO, $lang_fileRUMO, $lang_fileRUPO);
	
		foreach ( $delete_files as $file ) {
			if ( file_exists($file) ) {
				@unlink($file);	
			}
		}
		}
	}
}

/**
add to a later BPS version once the issue is fixed
possible issue: function_exists needs be to called outside of the function
either way this code needs more work before publicly releasing it - clunky/junky

// Daily Cron - BPS Plugin Upgrade Notification - add cron
function bpsPro_upgrade_check_add_cron( $schedules ) {
	$schedules['daily'] = array('interval' => 86400, 'display' => __('Once Daily'));
	//$schedules['hourly'] = array('interval' => 3600, 'display' => __('Once Hourly'));
	return $schedules;
}

add_filter('cron_schedules', 'bpsPro_upgrade_check_add_cron');

// Daily Cron - BPS Plugin Upgrade Notification - schedule event
function bpsPro_schedule_update_checks() {
	$bpsCronCheck = wp_get_schedule('bpsPro_update_check');
	
	if ( !wp_next_scheduled('bpsPro_update_check') ) {
		wp_schedule_event(time(), 'daily', 'bpsPro_update_check');
	//wp_schedule_event(time(), 'hourly', 'bpsPro_security_log_check');
	}
}

add_action('init', 'bpsPro_schedule_update_checks');

// Daily Cron - BPS Plugin Upgrade Notification - send email
// gets the latest version from WP.org
function bpsPro_update_checks() {
if (function_exists('get_transient')) {
require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
global $bps_version;

	if (false === ($bpsapi = get_transient('bulletproof-security_info'))) {
		$bpsapi = plugins_api('plugin_information', array('slug' => stripslashes( 'bulletproof-security' ) ));
	
	//if ( !is_wp_error($bpsapi) ) {
	//	$bpsexpire = 60 * 15; // Cache data for 15 minutes
	//	set_transient('bulletproof-security_info', $bpsapi, $bpsexpire);
	//}
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

	if ( version_compare($bpsapi->version, $bps_version, '>=') ) { 
		return false;	 
	} else {
	
	$Emailoptions = get_option('bulletproof_security_options_email');	
	
	if ( $Emailoptions['bps_upgrade_email'] == 'yes') {
	
	$bps_email = $Emailoptions['bps_send_email_to'];
	$bps_email_from = $Emailoptions['bps_send_email_from'];
	$bps_email_cc = $Emailoptions['bps_send_email_cc'];
	$bps_email_bcc = $Emailoptions['bps_send_email_bcc'];
	
	$justUrl = get_site_url();
	$timeNow = time();
	$gmt_offset = get_option( 'gmt_offset' ) * 3600;
	$timestamp = date_i18n(get_option('date_format'), strtotime("11/15-1976")) . ' - ' . date_i18n(get_option('time_format'), $timeNow + $gmt_offset);

	$mail_To = "$bps_email";
	$headers = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$headers .= "From: $bps_email_from" . "\r\n";
	$headers .= "Cc: $bps_email_cc" . "\r\n";
	$headers .= "Bcc: $bps_email_bcc" . "\r\n";
	$mail_Subject = " BPS Plugin Upgrade Notification - $timestamp ";

	$mail_message = '<p><font color="blue"><strong>A new version of BPS is available.</strong></font></p>';
	$mail_message .= '<p><font color="blue"><strong>Site: </strong></font>'."$justUrl".'</p>'; 
	$mail_message .= '<p>If you do not want to receive BPS Plugin Upgrade Email Notifications go to the BPS Login Security page, select the Do Not Send Email Alerts option and click the Save Options button.</p>';
	wp_mail($mail_To, $mail_Subject, $mail_message, $headers);
	}
	}
}
}
}
add_action('bpsPro_update_check', 'bpsPro_update_checks');
**/

?>