<?php
// Direct calls to this file are Forbidden when core files are not present
if (!function_exists ('add_action')) {
		header('Status: 403 Forbidden');
		header('HTTP/1.1 403 Forbidden');
		exit();
}

function bulletproof_security_admin_init() {
global $wpdb, $wp_version, $blog_id;
$Stable_name = $wpdb->prefix . "bpspro_seclog_ignore";
$Ltable_name = $wpdb->prefix . "bpspro_login_security";

	if ( is_multisite() && $blog_id != 1 ) {

	if ($wpdb->get_var("SHOW TABLES LIKE '$Ltable_name'") != $Ltable_name) {

	$sql = "CREATE TABLE $Ltable_name (
  id bigint(20) NOT NULL AUTO_INCREMENT,
  status VARCHAR(60) DEFAULT '' NOT NULL,
  user_id VARCHAR(60) DEFAULT '' NOT NULL,
  username VARCHAR(60) DEFAULT '' NOT NULL,
  public_name VARCHAR(250) DEFAULT '' NOT NULL,
  email VARCHAR(100) DEFAULT '' NOT NULL,
  role VARCHAR(15) DEFAULT '' NOT NULL,
  human_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
  login_time VARCHAR(10) DEFAULT '' NOT NULL,
  lockout_time VARCHAR(10) DEFAULT '' NOT NULL,
  failed_logins VARCHAR(2) DEFAULT '' NOT NULL,
  ip_address VARCHAR(45) DEFAULT '' NOT NULL,
  hostname VARCHAR(60) DEFAULT '' NOT NULL,
  request_uri VARCHAR(255) DEFAULT '' NOT NULL,
  UNIQUE KEY id (id)
    );";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
	}	

	} else {

	if ($wpdb->get_var("SHOW TABLES LIKE '$Stable_name'") != $Stable_name) {

	$sql = "CREATE TABLE $Stable_name (
  id bigint(20) NOT NULL AUTO_INCREMENT,
  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
  user_agent_bot text NOT NULL,
  UNIQUE KEY id (id)
    );";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
	}

	if ($wpdb->get_var("SHOW TABLES LIKE '$Ltable_name'") != $Ltable_name) {

	$sql = "CREATE TABLE $Ltable_name (
  id bigint(20) NOT NULL AUTO_INCREMENT,
  status VARCHAR(60) DEFAULT '' NOT NULL,
  user_id VARCHAR(60) DEFAULT '' NOT NULL,
  username VARCHAR(60) DEFAULT '' NOT NULL,
  public_name VARCHAR(250) DEFAULT '' NOT NULL,
  email VARCHAR(100) DEFAULT '' NOT NULL,
  role VARCHAR(15) DEFAULT '' NOT NULL,
  human_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
  login_time VARCHAR(10) DEFAULT '' NOT NULL,
  lockout_time VARCHAR(10) DEFAULT '' NOT NULL,
  failed_logins VARCHAR(2) DEFAULT '' NOT NULL,
  ip_address VARCHAR(45) DEFAULT '' NOT NULL,
  hostname VARCHAR(60) DEFAULT '' NOT NULL,
  request_uri VARCHAR(255) DEFAULT '' NOT NULL,
  UNIQUE KEY id (id)
    );";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
	}
	}
	
	// whitelist BPS DB options 
	register_setting('bulletproof_security_options', 'bulletproof_security_options', 'bulletproof_security_options_validate');
	register_setting('bulletproof_security_options_autolock', 'bulletproof_security_options_autolock', 'bulletproof_security_options_validate_autolock');
	register_setting('bulletproof_security_options_customcode', 'bulletproof_security_options_customcode', 'bulletproof_security_options_validate_customcode');
	register_setting('bulletproof_security_options_customcode_WPA', 'bulletproof_security_options_customcode_WPA', 'bulletproof_security_options_validate_customcode_WPA');
	register_setting('bulletproof_security_options_login_security', 'bulletproof_security_options_login_security', 'bulletproof_security_options_validate_login_security');
	register_setting('bulletproof_security_options_maint_mode', 'bulletproof_security_options_maint_mode', 'bulletproof_security_options_validate_maint_mode');
	register_setting('bulletproof_security_options_mynotes', 'bulletproof_security_options_mynotes', 'bulletproof_security_options_validate_mynotes');
	register_setting('bulletproof_security_options_email', 'bulletproof_security_options_email', 'bulletproof_security_options_validate_email');			

	// Register BPS js
	wp_register_script( 'bps-js', plugins_url('/bulletproof-security/admin/js/bulletproof-security-admin-4.js'));
				
	// Register BPS stylesheet - will be adding other styles later - bulletproof-security-admin-wp3.8.css
	if ( version_compare( $wp_version, '3.8', '>=' ) || preg_match('/3.8-[a-zA-Z0-9]/', $wp_version, $matches ) ) {
		wp_register_style('bps-css-38', plugins_url('/bulletproof-security/admin/css/bulletproof-security-admin-wp3.8.css'));	
	} else {
		wp_register_style('bps-css', plugins_url('/bulletproof-security/admin/css/bulletproof-security-admin-blue-5.css'));
	}

	// Create BPS Backup Folder structure - suppressing errors on activation - errors displayed in HUD
	if( !is_dir (WP_CONTENT_DIR . '/bps-backup')) {
		@mkdir (WP_CONTENT_DIR . '/bps-backup/master-backups', 0755, true);
		@chmod (WP_CONTENT_DIR . '/bps-backup/', 0755);
		@chmod (WP_CONTENT_DIR . '/bps-backup/master-backups/', 0755);
	}
	
	// Create the BPS Backup folder Deny all .htaccess file - recursive will protect all /bps-backup subfolders
	$bps_denyall_htaccess = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/deny-all.htaccess';
	$bps_ARHtaccess = WP_CONTENT_DIR . '/bps-backup/.htaccess';
	
	if ( !file_exists($bps_ARHtaccess) ) {
		@copy($bps_denyall_htaccess, $bps_ARHtaccess);
	}

	// Create logs folder
	if( !is_dir (WP_CONTENT_DIR . '/bps-backup/logs')) {
		@mkdir (WP_CONTENT_DIR . '/bps-backup/logs', 0755, true);
		@chmod (WP_CONTENT_DIR . '/bps-backup/logs/', 0755);
	}

	// Create the Security / HTTP error log in /logs
	$bpsProLog = WP_PLUGIN_DIR . '/bulletproof-security/admin/htaccess/http_error_log.txt';
	$bpsProLogARQ = WP_CONTENT_DIR . '/bps-backup/logs/http_error_log.txt';
	
	if (!file_exists($bpsProLogARQ)) {
		@copy($bpsProLog, $bpsProLogARQ);
	}	

	// Load scripts and styles only on BPS specified pages
	add_action('load-bulletproof-security/admin/options.php', 'bulletproof_security_load_settings_page');
	add_action('load-bulletproof-security/admin/login/login.php', 'bulletproof_security_load_settings_page_login');
	add_action('load-bulletproof-security/admin/security-log/security-log.php', 'bulletproof_security_load_settings_page_security_log');
	add_action('load-bulletproof-security/admin/system-info/system-info.php', 'bulletproof_security_load_settings_page_system_info');
	add_action('load-bulletproof-security/admin/maintenance/maintenance.php', 'bulletproof_security_load_settings_page_maintenance');
}

// BPS Menu
function bulletproof_security_admin_menu() {
global $blog_id;
	
	if ( current_user_can('manage_options') ) {
	
	// Network / Multisite display partial BPS menus
	if ( is_multisite() && $blog_id != 1 ) {

	add_menu_page(__('BulletProof Security Settings', 'bulletproof-security'), __('BPS Security', 'bulletproof-security'), 'manage_options', 'bulletproof-security/admin/login/login.php', '', plugins_url('bulletproof-security/admin/images/bps-icon-small.png'));
	add_submenu_page('bulletproof-security/admin/login/login.php', __('Login Security', 'bulletproof-security'), __('Login Security', 'bulletproof-security'), 'manage_options', 'bulletproof-security/admin/login/login.php' );
	add_submenu_page('bulletproof-security/admin/login/login.php', __('Maintenance Mode', 'bulletproof-security'), __('Maintenance Mode', 'bulletproof-security'), 'manage_options', 'bulletproof-security/admin/maintenance/maintenance.php' );
	add_submenu_page('bulletproof-security/admin/login/login.php', __('System Info', 'bulletproof-security'), __('System Info', 'bulletproof-security'), 'manage_options', 'bulletproof-security/admin/system-info/system-info.php' );

	} else {

	add_menu_page(__('BulletProof Security ~ htaccess Core', 'bulletproof-security'), __('BPS Security', 'bulletproof-security'), 'manage_options', 'bulletproof-security/admin/options.php', '', plugins_url('bulletproof-security/admin/images/bps-icon-small.png'));
	add_submenu_page('bulletproof-security/admin/options.php', __('BulletProof Security ~ htaccess Core', 'bulletproof-security'), __('htaccess Core', 'bulletproof-security'), 'manage_options', 'bulletproof-security/admin/options.php' );
	add_submenu_page('bulletproof-security/admin/options.php', __('Login Security ', 'bulletproof-security'), __('Login Security', 'bulletproof-security'), 'manage_options', 'bulletproof-security/admin/login/login.php' );
	add_submenu_page('bulletproof-security/admin/options.php', __('Security Log', 'bulletproof-security'), __('Security Log', 'bulletproof-security'), 'manage_options', 'bulletproof-security/admin/security-log/security-log.php' );
	add_submenu_page('bulletproof-security/admin/options.php', __('Maintenance Mode', 'bulletproof-security'), __('Maintenance Mode', 'bulletproof-security'), 'manage_options', 'bulletproof-security/admin/maintenance/maintenance.php' );
	add_submenu_page('bulletproof-security/admin/options.php', __('System Info', 'bulletproof-security'), __('System Info', 'bulletproof-security'), 'manage_options', 'bulletproof-security/admin/system-info/system-info.php' );
	}
	}
}

// dequeue any rogue plugin or theme scripts & styles from loading in BPS pages and breaking stuff
function bpsPro_kill_rogue_plugin_theme_scripts_styles() {
global $wp_scripts, $wp_styles;
    
	$script_handles = array( 'bps-js', 'admin-bar', 'jquery', 'jquery-ui-core', 'jquery-ui-tabs', 'jquery-ui-dialog', 'jquery-form', 'jquery-ui-accordion', 'jquery-effects-core', 'jquery-effects-blind', 'jquery-effects-explode', 'common', 'utils', 'svg-painter', 'wp-auth-check' );

	$style_handles = array( 'bps-css', 'bps-css-38', 'admin-bar', 'colors', 'ie', 'wp-auth-check' );

	if ( preg_match( '/page=bulletproof-security/', $_SERVER['REQUEST_URI'], $matches) ) {		

		foreach( $wp_scripts->queue as $handle ) {
		
			if ( !in_array( $handle, $script_handles ) ) {
				wp_dequeue_script( $handle );
        		// uncomment line below to see all the script handles that are being blocked on BPS plugin pages
				//echo $handle . ' | ';
			}
		}
	
		foreach( $wp_styles->queue as $handle ) {
        	
			if ( !in_array( $handle, $style_handles ) ) {
				wp_dequeue_style( $handle );
				// uncomment line below to see all the style handles that are being blocked on BPS plugin pages
				//echo $handle . ' | ';
			}	
		}
	}
}

add_action( 'admin_enqueue_scripts', 'bpsPro_kill_rogue_plugin_theme_scripts_styles' );

// Loads Settings for H-Core
function bulletproof_security_load_settings_page() {
global $bulletproof_security, $wp_version;
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('jquery-ui-dialog');
	wp_enqueue_script('jquery-form');
	wp_enqueue_script('jquery-ui-accordion');
	wp_enqueue_script('jquery-effects-core');
	wp_enqueue_script('jquery-effects-blind');
	wp_enqueue_script('jquery-effects-explode');
	wp_enqueue_script('bps-js');
	// Engueue BPS stylesheet
	if ( version_compare( $wp_version, '3.8', '>=' ) || preg_match('/3.8-[a-zA-Z0-9]/', $wp_version, $matches ) ) {
		wp_enqueue_style('bps-css-38', plugins_url('/bulletproof-security/admin/css/bulletproof-security-admin-wp3.8.css'));	
	} else {
		wp_enqueue_style('bps-css', plugins_url('/bulletproof-security/admin/css/bulletproof-security-admin-blue-5.css'));
	}
}

// Loads Settings for BPS Login Security
function bulletproof_security_load_settings_page_login() {
global $bulletproof_security, $wp_version;
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('jquery-ui-dialog');
	wp_enqueue_script('jquery-form');
	wp_enqueue_script('jquery-ui-accordion');
	wp_enqueue_script('jquery-effects-core');
	wp_enqueue_script('jquery-effects-blind');
	wp_enqueue_script('jquery-effects-explode');
	wp_enqueue_script('bps-js');
	// Enqueue BPS stylesheet
	if ( version_compare( $wp_version, '3.8', '>=' ) || preg_match('/3.8-[a-zA-Z0-9]/', $wp_version, $matches ) ) {
		wp_enqueue_style('bps-css-38', plugins_url('/bulletproof-security/admin/css/bulletproof-security-admin-wp3.8.css'));	
	} else {
		wp_enqueue_style('bps-css', plugins_url('/bulletproof-security/admin/css/bulletproof-security-admin-blue-5.css'));
	}	
}

// Loads Settings for Security Log page - Enqueue BPS scripts and styles
function bulletproof_security_load_settings_page_security_log() {
global $bulletproof_security, $wp_version;
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('jquery-ui-dialog');
	wp_enqueue_script('jquery-form');
	wp_enqueue_script('jquery-ui-accordion');
	wp_enqueue_script('jquery-effects-core');
	wp_enqueue_script('jquery-effects-blind');
	wp_enqueue_script('jquery-effects-explode');
	wp_enqueue_script('bps-js');
	// Enqueue BPS stylesheet
	if ( version_compare( $wp_version, '3.8', '>=' ) || preg_match('/3.8-[a-zA-Z0-9]/', $wp_version, $matches ) ) {
		wp_enqueue_style('bps-css-38', plugins_url('/bulletproof-security/admin/css/bulletproof-security-admin-wp3.8.css'));	
	} else {
		wp_enqueue_style('bps-css', plugins_url('/bulletproof-security/admin/css/bulletproof-security-admin-blue-5.css'));
	}
}

// Loads Settings for BPS Pro Maintenance - Enqueue BPS scripts and styles
function bulletproof_security_load_settings_page_maintenance() {
global $bulletproof_security, $wp_version;
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('jquery-ui-dialog');
	wp_enqueue_script('jquery-form');
	wp_enqueue_script('jquery-ui-accordion');
	wp_enqueue_script('jquery-effects-core');
	wp_enqueue_script('jquery-effects-blind');
	wp_enqueue_script('jquery-effects-explode');
	wp_enqueue_script('bps-js');
	// Enqueue BPS stylesheet
	if ( version_compare( $wp_version, '3.8', '>=' ) || preg_match('/3.8-[a-zA-Z0-9]/', $wp_version, $matches ) ) {
		wp_enqueue_style('bps-css-38', plugins_url('/bulletproof-security/admin/css/bulletproof-security-admin-wp3.8.css'));
	} else {
		wp_enqueue_style('bps-css', plugins_url('/bulletproof-security/admin/css/bulletproof-security-admin-blue-5.css'));
	}
}

// Loads Settings for System Info page - Enqueue BPS scripts and styles
function bulletproof_security_load_settings_page_system_info() {
global $bulletproof_security, $wp_version;
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('jquery-ui-dialog');
	wp_enqueue_script('jquery-form');
	wp_enqueue_script('jquery-ui-accordion');
	wp_enqueue_script('jquery-effects-core');
	wp_enqueue_script('jquery-effects-blind');
	wp_enqueue_script('jquery-effects-explode');
	wp_enqueue_script('bps-js');
	// Enqueue BPS stylesheet
	if ( version_compare( $wp_version, '3.8', '>=' ) || preg_match('/3.8-[a-zA-Z0-9]/', $wp_version, $matches ) ) {
		wp_enqueue_style('bps-css-38', plugins_url('/bulletproof-security/admin/css/bulletproof-security-admin-wp3.8.css'));	
	} else {
		wp_enqueue_style('bps-css', plugins_url('/bulletproof-security/admin/css/bulletproof-security-admin-blue-5.css'));
	}
}

function bulletproof_security_install() {
global $bulletproof_security, $bps_version;
$previous_install = get_option('bulletproof_security_options');
	
	if ( $previous_install ) {
	if ( version_compare($previous_install['version'], $bps_version, '<') )
	remove_role('denied');
	}
}

// Deactivation - remove/delete nothing at this point
function bulletproof_security_deactivation() {
// nothing needs to removed on deactivation for now
}

// Partial Uninstall - BPS later version will have the option of complete removal in addition to a BPS Pro upgrade uninstall
// Currently options and files are not deleted on uninstall as a courtesy to BPS Pro customers
function bulletproof_security_uninstall() {
	require_once( ABSPATH . 'wp-admin/includes/plugin.php');
	$options = get_option('bulletproof_security_options');
	delete_option('bulletproof_security_options');
}

/* 
// This uninstall function will completely remove BPS files, DB Options & Tables
function bulletproof_security_uninstall() {
global $wpdb, $current_user;
require_once( ABSPATH . 'wp-admin/includes/plugin.php');

$user_id = $current_user->ID;
$Stable_name = $wpdb->prefix . "bpspro_seclog_ignore";
$Ltable_name = $wpdb->prefix . "bpspro_login_security";
$RootHtaccess = ABSPATH . '.htaccess';
$RootHtaccessBackup = WP_CONTENT_DIR . '/bps-backup/master-backups/root.htaccess';
$wpadminHtaccess = ABSPATH . 'wp-admin/.htaccess';
$wpadminHtaccessBackup = WP_CONTENT_DIR . '/bps-backup/master-backups/wpadmin.htaccess';
$options = get_option('bulletproof_security_options');

	if ( file_exists($RootHtaccess) ) {
		copy($RootHtaccess, $RootHtaccessBackup);
	}
	if ( file_exists($wpadminHtaccess) ) {
		copy($wpadminHtaccess, $wpadminHtaccessBackup);
	}

	delete_option('bulletproof_security_options');
	delete_option('bulletproof_security_options_customcode');
	delete_option('bulletproof_security_options_customcode_WPA');
	delete_option('bulletproof_security_options_maint');
	delete_option('bulletproof_security_options_maint_mode');
	delete_option('bulletproof_security_options_mynotes');
	delete_option('bulletproof_security_options_email');
	delete_option('bulletproof_security_options_autolock');
	delete_option('bulletproof_security_options_login_security');
	// will be adding this new upgrade notice option later
	// delete_option('bulletproof_security_options_upgrade_notice');	
	$wpdb->query("DROP TABLE IF EXISTS $Stable_name");
	$wpdb->query("DROP TABLE IF EXISTS $Ltable_name");
	delete_user_meta($user_id, 'bps_ignore_iis_notice');
	delete_user_meta($user_id, 'bps_ignore_sucuri_notice');
	delete_user_meta($user_id, 'bps_ignore_BLC_notice');
	delete_user_meta($user_id, 'bps_ignore_PhpiniHandler_notice');
	delete_user_meta($user_id, 'bps_ignore_Permalinks_notice');
	delete_user_meta($user_id, 'bps_brute_force_login_protection_notice');
	delete_user_meta($user_id, 'bps_speed_boost_cache_notice');
	@unlink($RootHtaccess);
	@unlink($wpadminHtaccess);
}
*/

// Validate BPS options 
function bulletproof_security_options_validate($input) {  
	$options = get_option('bulletproof_security_options');  
	$options['bps_blank'] = wp_filter_nohtml_kses($input['bps_blank']);
			
	return $options;  
}

// Validate BPS options - BPS .49.9 New Maintenance Mode Form options
function bulletproof_security_options_validate_maint_mode($input) {  
	$options = get_option('bulletproof_security_options_maint_mode');  
	$options['bps_maint_on_off'] = wp_filter_nohtml_kses($input['bps_maint_on_off']);
	$options['bps_maint_countdown_timer'] = wp_filter_nohtml_kses($input['bps_maint_countdown_timer']);
	$options['bps_maint_countdown_timer_color'] = wp_filter_nohtml_kses($input['bps_maint_countdown_timer_color']);
	$options['bps_maint_time'] = wp_filter_nohtml_kses($input['bps_maint_time']);
	$options['bps_maint_retry_after'] = wp_filter_nohtml_kses($input['bps_maint_retry_after']);
	$options['bps_maint_frontend'] = wp_filter_nohtml_kses($input['bps_maint_frontend']);
	$options['bps_maint_backend'] = wp_filter_nohtml_kses($input['bps_maint_backend']);
	$options['bps_maint_ip_allowed'] = wp_filter_nohtml_kses($input['bps_maint_ip_allowed']);
	$options['bps_maint_text'] = esc_html($input['bps_maint_text']);
	$options['bps_maint_background_images'] = wp_filter_nohtml_kses($input['bps_maint_background_images']);
	$options['bps_maint_center_images'] = wp_filter_nohtml_kses($input['bps_maint_center_images']);
	$options['bps_maint_background_color'] = wp_filter_nohtml_kses($input['bps_maint_background_color']);
	$options['bps_maint_show_visitor_ip'] = wp_filter_nohtml_kses($input['bps_maint_show_visitor_ip']);
	$options['bps_maint_show_login_link'] = wp_filter_nohtml_kses($input['bps_maint_show_login_link']);
	$options['bps_maint_dashboard_reminder'] = wp_filter_nohtml_kses($input['bps_maint_dashboard_reminder']);	
	$options['bps_maint_countdown_email'] = wp_filter_nohtml_kses($input['bps_maint_countdown_email']);
	$options['bps_maint_email_to'] = trim(wp_filter_nohtml_kses($input['bps_maint_email_to']));
	$options['bps_maint_email_from'] = trim(wp_filter_nohtml_kses($input['bps_maint_email_from']));
	$options['bps_maint_email_cc'] = trim(wp_filter_nohtml_kses($input['bps_maint_email_cc']));
	$options['bps_maint_email_bcc'] = trim(wp_filter_nohtml_kses($input['bps_maint_email_bcc']));	
	$options['bps_maint_mu_entire_site'] = wp_filter_nohtml_kses($input['bps_maint_mu_entire_site']);
	$options['bps_maint_mu_subsites_only'] = wp_filter_nohtml_kses($input['bps_maint_mu_subsites_only']);
	
	return $options;  
}

// Validate BPS options - Options.php - Edit/Uploads/Downloads page - Root .htaccess file AutoLock 
function bulletproof_security_options_validate_autolock($input) {  
	$options = get_option('bulletproof_security_options_autolock');  
	$options['bps_root_htaccess_autolock'] = wp_filter_nohtml_kses($input['bps_root_htaccess_autolock']);
		
	return $options;  
}

// Validate BPS options - BPS Custom Code - Root .htaccess
function bulletproof_security_options_validate_customcode($input) {  
	$options = get_option('bulletproof_security_options_customcode');  
	$options['bps_customcode_one'] = esc_html($input['bps_customcode_one']);
	$options['bps_customcode_directory_index'] = esc_html($input['bps_customcode_directory_index']);
	$options['bps_customcode_error_logging'] = esc_html($input['bps_customcode_error_logging']);
	$options['bps_customcode_admin_includes'] = esc_html($input['bps_customcode_admin_includes']);
	$options['bps_customcode_wp_rewrite_start'] = esc_html($input['bps_customcode_wp_rewrite_start']);
	$options['bps_customcode_request_methods'] = esc_html($input['bps_customcode_request_methods']);
	$options['bps_customcode_two'] = esc_html($input['bps_customcode_two']);
	$options['bps_customcode_timthumb_misc'] = esc_html($input['bps_customcode_timthumb_misc']);
	$options['bps_customcode_bpsqse'] = esc_html($input['bps_customcode_bpsqse']);
	$options['bps_customcode_deny_files'] = esc_html($input['bps_customcode_deny_files']);
	$options['bps_customcode_three'] = esc_html($input['bps_customcode_three']);
	$options['bps_customcode_server_protocol'] = esc_html($input['bps_customcode_server_protocol']);

	return $options;  
}

// Validate BPS options - BPS Custom Code - WP-admin .htaccess
function bulletproof_security_options_validate_customcode_WPA($input) {  
	$options = get_option('bulletproof_security_options_customcode_WPA');  
	$options['bps_customcode_deny_files_wpa'] = esc_html($input['bps_customcode_deny_files_wpa']);
	$options['bps_customcode_one_wpa'] = esc_html($input['bps_customcode_one_wpa']);
	$options['bps_customcode_two_wpa'] = esc_html($input['bps_customcode_two_wpa']);
	$options['bps_customcode_bpsqse_wpa'] = esc_html($input['bps_customcode_bpsqse_wpa']);		
	
	return $options;  
}

// Validate BPS options - BPS "My Notes" settings 
function bulletproof_security_options_validate_mynotes($input) {  
	$options = get_option('bulletproof_security_options_mynotes');  
	$options['bps_my_notes'] = esc_html($input['bps_my_notes']);
		
	return $options;  
}

// Validate BPS options - Login Security & Monitoring
function bulletproof_security_options_validate_login_security($input) {  
	$BPSoptions = get_option('bulletproof_security_options_login_security');  
	$BPSoptions['bps_max_logins'] = trim(wp_filter_nohtml_kses($input['bps_max_logins']));
	$BPSoptions['bps_lockout_duration'] = trim(wp_filter_nohtml_kses($input['bps_lockout_duration']));
	$BPSoptions['bps_manual_lockout_duration'] = trim(wp_filter_nohtml_kses($input['bps_manual_lockout_duration']));
	$BPSoptions['bps_max_db_rows_display'] = trim(wp_filter_nohtml_kses($input['bps_max_db_rows_display']));
	$BPSoptions['bps_login_security_OnOff'] = wp_filter_nohtml_kses($input['bps_login_security_OnOff']);
	$BPSoptions['bps_login_security_logging'] = wp_filter_nohtml_kses($input['bps_login_security_logging']);
	$BPSoptions['bps_login_security_errors'] = wp_filter_nohtml_kses($input['bps_login_security_errors']);
	$BPSoptions['bps_login_security_pw_reset'] = wp_filter_nohtml_kses($input['bps_login_security_pw_reset']);		
	
	return $BPSoptions;  
}

// Validate BPS options - BPS Free Email Alerts
function bulletproof_security_options_validate_email($input) {  
	$options = get_option('bulletproof_security_options_email');  
	$options['bps_send_email_to'] = trim(wp_filter_nohtml_kses($input['bps_send_email_to']));
	$options['bps_send_email_from'] = trim(wp_filter_nohtml_kses($input['bps_send_email_from']));
	$options['bps_send_email_cc'] = trim(wp_filter_nohtml_kses($input['bps_send_email_cc']));
	$options['bps_send_email_bcc'] = trim(wp_filter_nohtml_kses($input['bps_send_email_bcc']));
	$options['bps_login_security_email'] = wp_filter_nohtml_kses($input['bps_login_security_email']);
	//$options['bps_upgrade_email'] = wp_filter_nohtml_kses($input['bps_upgrade_email']);		
	$options['bps_security_log_size'] = wp_filter_nohtml_kses($input['bps_security_log_size']);
	$options['bps_security_log_emailL'] = wp_filter_nohtml_kses($input['bps_security_log_emailL']);	
	
	return $options;  
}
?>