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


<h2 style="margin-left:70px;"><?php _e('BulletProof Security ~ System Information', 'bulletproof-security'); ?></h2>
<div id="message" class="updated" style="border:1px solid #999999; margin-left:70px;background-color: #000;">

<?php
// HUD - Heads Up Display - Warnings and Error messages
echo bps_check_php_version_error();
//echo bps_check_permalinks_error(); // this is now an admin notice w/dimiss button
//echo bps_check_iis_supports_permalinks(); // this is now an admin notice w/dimiss button
echo bps_hud_check_bpsbackup();
echo bps_check_safemode();
echo @bps_w3tc_htaccess_check($plugin_var);
echo @bps_wpsc_htaccess_check($plugin_var);

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

?>
</div>

<!-- jQuery UI Tab Menu -->
<div id="bps-container">
	<div id="bps-tabs" class="bps-menu">
    <div id="bpsHead" style="position:relative; top:0px; left:0px;"><img src="<?php echo plugins_url('/bulletproof-security/admin/images/bps-security-shield.png'); ?>" style="float:left; padding:0px 8px 0px 0px; margin:-72px 0px 0px 0px;" /></div>
		<ul>
			<li><a href="#bps-tabs-1"><?php _e('System Info', 'bulletproof-security'); ?></a></li>
			<li><a href="#bps-tabs-2"><?php _e('Help &amp; FAQ', 'bulletproof-security'); ?></a></li>
		</ul>
            
<div id="bps-tabs-1">
<h2><?php _e('System Information', 'bulletproof-security'); ?></h2>

<?php 
if ( !current_user_can('manage_options') ) { _e('Permission Denied', 'bulletproof-security'); 
} else { 
if ( is_admin() && wp_script_is( 'bps-js', $list = 'queue' ) && current_user_can('manage_options') ) {
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="bps-system_info_table">
  <tr>
    <td width="49%" class="bps-table_title"><?php _e('Website / Server / Opcode Cache / Accelerators / IP Info', 'bulletproof-security'); ?></td>
    <td width="2%">&nbsp;</td>
    <td width="49%" class="bps-table_title"><?php _e('SQL Database / Permalink Structure / WP Installation Folder / Site Type', 'bulletproof-security'); ?></td>
  </tr>
  <tr>
    <td class="bps-table_cell">&nbsp;</td>
    <td>&nbsp;</td>
    <td class="bps-table_cell">&nbsp;</td>
  </tr>
  <tr>
    <td class="bps-table_cell">
    
	<?php 

// Get DNS Name Server from [target]
$bpsHostName = esc_html($_SERVER['SERVER_NAME']);
$bpsTargetNS = '';
$bpsTarget = '';
	
	$bpsGetDNS = @dns_get_record($bpsHostName, DNS_NS);
	if (!isset($bpsGetDNS[0]['target'])) {
		echo '';
	} else {
		$bpsTargetNS = $bpsGetDNS[0]['target'];
	}
	
	if ($bpsTargetNS == '') {
		@dns_get_record($bpsHostName, DNS_ALL, $authns, $addtl);
		if (!isset($authns[0]['target'])) {
			echo '';
		} else {
			$bpsTarget = $authns[0]['target'];
		}
	}	
	
	if ($bpsTarget && $bpsTargetNS == '') {
		@dns_get_record($bpsHostName, DNS_ANY, $authns, $addtl);
		if (!isset($authns[0]['target'])) {
			echo '';
		} else {
			$bpsTarget = $authns[0]['target'];
		}
	}

	echo __('Website Root URL', 'bulletproof-security').': <strong>'.get_site_url().'</strong><br>';
	echo __('Document Root Path', 'bulletproof-security').': <strong>'.esc_html($_SERVER['DOCUMENT_ROOT']).'</strong><br>'; 
	echo __('WP ABSPATH', 'bulletproof-security').': <strong>'.ABSPATH.'</strong><br>';
	echo __('Parent Directory', 'bulletproof-security').': <strong>'.dirname(ABSPATH).'</strong><br>';  
	echo __('Server / Website IP Address', 'bulletproof-security').': <strong>'.esc_html($_SERVER['SERVER_ADDR']).'</strong><br>';    
	echo __('Host by Address', 'bulletproof-security').': <strong>'.esc_html(@gethostbyaddr($_SERVER['SERVER_ADDR'])).'</strong><br>';    
	echo __('DNS Name Server', 'bulletproof-security').': <strong>'; if ($bpsTargetNS != '') { echo $bpsTargetNS; } else { echo $bpsTarget; } echo '</strong><br>';
	echo __('Public ISP IP / Your Computer IP Address', 'bulletproof-security').': <strong>'.esc_html($_SERVER['REMOTE_ADDR']).'</strong><br>';
	echo __('Server Type', 'bulletproof-security').': <strong>'.esc_html($_SERVER['SERVER_SOFTWARE']).'</strong><br>';
	echo __('Operating System', 'bulletproof-security').': <strong>'.PHP_OS.'</strong><br>';  
	echo __('WP Filesystem API Method', 'bulletproof-security').': <strong>'.get_filesystem_method().'</strong><br>';	
	if ( get_filesystem_method() != 'direct' && function_exists('getmyuid') && function_exists('fileowner') ) {
	echo __('Script Owner ID', 'bulletproof-security').': <strong>' . getmyuid().'</strong><br>';
	echo __('File Owner ID', 'bulletproof-security').': <strong>' . @fileowner(WP_PLUGIN_DIR . '/bulletproof-security/admin/options.php').'</strong><br>';
	}
	if ( get_filesystem_method() != 'direct' && function_exists('get_current_user') ) {
	echo __('Script Owner Name', 'bulletproof-security').': <strong>' . get_current_user().'</strong><br>';
	}	
	echo __('Server API', 'bulletproof-security').': <strong>';
	
	$sapi_type = php_sapi_name();
	if ( @substr($sapi_type, 0, 6) != 'apache') {	
		echo $sapi_type.' - '.__('Your Host Server is using CGI', 'bulletproof-security');
	} else {
    	echo $sapi_type.' - '.__('Your Host Server is using DSO', 'bulletproof-security');
	}
	echo '</strong><br>';
	echo __('cURL', 'bulletproof-security').': <strong>';
	if (extension_loaded('curl')) {
		_e('cURL Extension is Loaded', 'bulletproof-security');
	} else {
		_e('cURL Extension is Not Loaded', 'bulletproof-security');
	}
	echo '</strong><br>';	
	echo __('Zend Engine Version', 'bulletproof-security').': <strong>'.zend_version().'</strong><br>'; 
	echo __('Zend Guard/Optimizer', 'bulletproof-security').': <strong>';
	if (extension_loaded('Zend Optimizer+') && ini_get('zend_optimizerplus.enable') == 1 || ini_get('zend_optimizerplus.enable') == 'On' ) {
		_e('Zend Optimizer+ Extension is Loaded and Enabled', 'bulletproof-security');
	}
	if (extension_loaded('Zend Optimizer')) {
		_e('Zend Optimizer Extension is Loaded', 'bulletproof-security');
	}
	if (extension_loaded('Zend Guard Loader')) {
		_e('Zend Guard Loader Extension is Loaded', 'bulletproof-security');
	} else {
	if (!extension_loaded('Zend Optimizer+') && !extension_loaded('Zend Optimizer') && !extension_loaded('Zend Guard Loader')) {
		_e('A Zend Extension is Not Loaded', 'bulletproof-security');		
	}
	}
	echo '</strong><br>';    
	echo __('ionCube Loader', 'bulletproof-security').': <strong>'; 
	if (extension_loaded('IonCube Loader') && function_exists('ioncube_loader_iversion')) {
		echo __('ionCube Loader Extension is Loaded ', 'bulletproof-security').__('Version: ', 'bulletproof-security').ioncube_loader_iversion();
	} else {
		echo __('ionCube Loader Extension is Not Loaded', 'bulletproof-security');
	}
	echo '</strong><br>';
	echo __('Suhosin', 'bulletproof-security').': <strong>';
	
	$bpsconstants = get_defined_constants();
	if (isset($bpsconstants['SUHOSIN_PATCH']) && $bpsconstants['SUHOSIN_PATCH'] == 1) {
		_e('The Suhosin-Patch is installed', 'bulletproof-security');
	}
	if (extension_loaded('suhosin')) {
		_e('Suhosin-Extension is Loaded', 'bulletproof-security');	
	} else {
	if (!isset($bpsconstants['SUHOSIN_PATCH']) && @$bpsconstants['SUHOSIN_PATCH'] != 1 && !extension_loaded('suhosin')) {
		_e('Suhosin is Not Installed/Loaded', 'bulletproof-security');			
	}
	}
	echo '</strong><br>';
	echo __('APC', 'bulletproof-security').': <strong>';
	if (extension_loaded('apc') && ini_get('apc.enabled') == 1 || ini_get('apc.enabled') == 'On' ) {
		_e('APC Extension is Loaded and Enabled', 'bulletproof-security');
	} 
	elseif (extension_loaded('apc') && ini_get('apc.enabled') == 0 || ini_get('apc.enabled') == 'Off' ) {
		_e('APC Extension is Loaded but Not Enabled', 'bulletproof-security');
	} else {
		_e('APC Extension is Not Loaded', 'bulletproof-security');	
	}
	echo '</strong><br>';  	    
	echo __('eAccelerator', 'bulletproof-security').': <strong>';
	if (extension_loaded('eaccelerator') && ini_get('eaccelerator.enable') == 1 || ini_get('eaccelerator.enable') == 'On' ) {
		_e('eAccelerator Extension is Loaded and Enabled', 'bulletproof-security');
	} 
	elseif (extension_loaded('eaccelerator') && ini_get('eaccelerator.enable') == 0 || ini_get('eaccelerator.enable') == 'Off' ) {
		_e('eAccelerator Extension is Loaded but Not Enabled', 'bulletproof-security');
	} else {
		_e('eAccelerator Extension is Not Loaded', 'bulletproof-security');	
	}	
	echo '</strong><br>';  	  
	echo __('XCache', 'bulletproof-security').': <strong>';
	if (extension_loaded('xcache') && ini_get('xcache.size') > 0 && ini_get('xcache.cacher') == 'On' || ini_get('xcache.cacher') == '1') {
		_e('XCache Extension is Loaded and Enabled', 'bulletproof-security');
	} 
	elseif (extension_loaded('xcache') && ini_get('xcache.size') <= 0 && ini_get('xcache.cacher') == 'Off' || ini_get('xcache.cacher') == '0') {
		_e('XCache Extension is Loaded but Not Enabled', 'bulletproof-security');
	} else {
		_e('XCache Extension is Not Loaded', 'bulletproof-security');	
	}	
	echo '</strong><br>';
	echo __('Varnish', 'bulletproof-security').': <strong>';
	if (extension_loaded('varnish')) {
		_e('Varnish Extension is Loaded', 'bulletproof-security');
	} else {
		_e('Varnish Extension is Not Loaded', 'bulletproof-security');	
	}	
	echo '</strong><br>';
	echo __('Memcache', 'bulletproof-security').': <strong>';
	if (extension_loaded('memcache')) {
	$memcache = new Memcache;
	@$memcache->connect('localhost', 11211);
	echo __('Memcache Extension is Loaded', 'bulletproof-security').__('Version: ', 'bulletproof-security').@$memcache->getVersion();
	} else {
		_e('Memcache Extension is Not Loaded', 'bulletproof-security');	
	}	
	echo '</strong><br>';
	echo __('Memcached', 'bulletproof-security').': <strong>';
	if (extension_loaded('memcached')) {
	$memcached = new Memcached();
	@$memcached->addServer('localhost', 11211);
	echo __('Memcached Extension is Loaded', 'bulletproof-security').__('Version: ', 'bulletproof-security').@$memcached->getVersion();
	} else {
		_e('Memcached Extension is Not Loaded', 'bulletproof-security');	
	}	
	echo '</strong><br>';
	?>

    </td>
    <td>&nbsp;</td>
    <td rowspan="2" class="bps-table_cell">
	
	<?php 
	if ( is_multisite() && $blog_id != 1 ) {
		echo '<font color="blue"><strong>'.__('MySQL DB Info is not displayed on Network/Multisite subsites', 'bulletproof-security').'</strong></font><br><br>';
	
	} else {
	
	echo __('MySQL Database Version', 'bulletproof-security').': ';
	$sqlversion = $wpdb->get_var("SELECT VERSION() AS version");
	echo '<strong>'.$sqlversion.'</strong><br>';
	function bps_mysqli_get_client_info() {
		if ( function_exists('mysqli_get_client_info') ) { 
			return mysqli_get_client_info(); 
		}
	}
	echo __('MySQL Client Version', 'bulletproof-security').': <strong>'.bps_mysqli_get_client_info().'</strong><br>';	
	echo __('Database Host', 'bulletproof-security').': <strong>'.DB_HOST.'</strong><br>';
	echo __('Database Name', 'bulletproof-security').': <strong>'.DB_NAME.'</strong><br>';
	echo __('Database User', 'bulletproof-security').': <strong>'.DB_USER.'</strong><br>';
	echo __('SQL Mode', 'bulletproof-security').': ';
	
	$mysqlinfo = $wpdb->get_results("SHOW VARIABLES LIKE 'sql_mode'");
	if (is_array($mysqlinfo)) { 
		$sql_mode = $mysqlinfo[0]->Value;
    if (empty($sql_mode)) { 
		$sql_mode = '<strong>'.__('Not Set', 'bulletproof-security').'</strong>';
	} else {
		$sql_mode = '<strong>'.__('Off', 'bulletproof-security').'</strong>';
	}}
	echo $sql_mode;
	echo '<br><br>';
	}
	
	echo __('WordPress Installation Folder', 'bulletproof-security').': <strong>';
	echo bps_wp_get_root_folder().'</strong><br>';
	echo __('Plugins Folder', 'bulletproof-security').': <strong>';
	echo str_replace(ABSPATH, '', WP_PLUGIN_DIR).'</strong><br>';	
	echo __('WordPress Installation Type', 'bulletproof-security').': ';
	echo bps_wp_get_root_folder_display_type().'<br>';
	echo __('Standard/GWIOD Site Type', 'bulletproof-security').': ';
	echo bps_gwiod_site_type_check().'<br>';
	echo __('Network/Multisite', 'bulletproof-security').': ';
	echo bps_multsite_check().'<br>';
	echo __('BuddyPress', 'bulletproof-security').': ';
	echo bps_buddypress_site_type_check().'<br>';
	echo __('bbPress', 'bulletproof-security').': ';
	echo bps_bbpress_site_type_check().'<br>';	
	
/*
	echo __('WordPress Installation Folder', 'bulletproof-security').': <strong>';
	echo bps_wp_get_root_folder().'</strong><br>';
	echo __('WordPress Installation Type', 'bulletproof-security').': ';
	echo bps_wp_get_root_folder_display_type().'<br>';
	echo __('Network/Multisite', 'bulletproof-security').': ';
	echo bps_multsite_check().'<br>';
*/	
	echo __('WP Permalink Structure', 'bulletproof-security').': <strong>';
	$permalink_structure = get_option('permalink_structure'); 
	echo $permalink_structure.'</strong><br>';
	echo bps_check_permalinks().'<br>';
	echo bps_check_php_version().'<br>';
	echo __('Browser Compression Supported', 'bulletproof-security').': <strong>'.esc_html($_SERVER['HTTP_ACCEPT_ENCODING']).'</strong>';
	
	?>
      </td>
  </tr>
  <tr>
    <td class="bps-table_cell">&nbsp;</td>
    <td>&nbsp;</td>
    <!-- <td class="bps-table_cell">&nbsp;</td> -->
    </tr>
  <tr>
    <td class="bps-table_title"><?php _e('PHP Server / PHP.ini Info', 'bulletproof-security'); ?></td>
    <td>&nbsp;</td>
    <td class="bps-table_title"><?php _e('Check Website Headers Tool', 'bulletproof-security'); ?></td>
  </tr>
  <tr>
    <td class="bps-table_cell">&nbsp;</td>
    <td>&nbsp;</td>
    <td class="bps-table_cell">&nbsp;</td>
  </tr>
  <tr>
    <td class="bps-table_cell">
	
	<?php 
	echo __('PHP Version', 'bulletproof-security').': <strong>'.PHP_VERSION.'</strong><br>';
	echo __('PHP Memory Usage', 'bulletproof-security').': <strong>'.round(memory_get_usage() / 1024 / 1024, 2) . __(' MB').'</strong><br>';    
	echo __('WordPress Admin Memory Limit', 'bulletproof-security').': '; $memory_limit = ini_get('memory_limit');
	echo '<strong>'.$memory_limit.'</strong><br>';
	echo __('WordPress Base Memory Limit', 'bulletproof-security').': <strong>'.WP_MEMORY_LIMIT.'</strong><br>';
	echo __('PHP Actual Configuration Memory Limit', 'bulletproof-security').': <strong>'.get_cfg_var('memory_limit').'</strong><br>';
	echo __('PHP Max Upload Size', 'bulletproof-security').': '; $upload_max = ini_get('upload_max_filesize');
	echo '<strong>'.$upload_max.'</strong><br>';
	echo __('PHP Max Post Size', 'bulletproof-security').': '; $post_max = ini_get('post_max_size');
	echo '<strong>'.$post_max.'</strong><br>';
	echo __('PHP Safe Mode', 'bulletproof-security').': ';
	
	if (ini_get('safe_mode') == 1) { 
		$text = '<font color="red"><strong>'.__('On', 'bulletproof-security').'</strong></font>';
		echo $text.'<br>'; 
	} else { 
		$text = '<font color="green"><strong>'.__('Off', 'bulletproof-security').'</strong></font>';
		echo $text.'<br>';
	}
	echo __('PHP Allow URL fopen', 'bulletproof-security').': ';
	if (ini_get('allow_url_fopen') == 1) { 
		$text = '<font color="red"><strong>'.__('On', 'bulletproof-security').'</strong></font>';
		echo $text.'<br>';
	} else { 
		$text = '<font color="green"><strong>'.__('Off', 'bulletproof-security').'</strong></font>';
		echo $text.'<br>';
	}	
	echo __('PHP Allow URL Include', 'bulletproof-security').': ';
	if (ini_get('allow_url_include') == 1) { 
		$text = '<font color="red"><strong>'.__('On', 'bulletproof-security').'</strong></font>';
		echo $text.'<br>'; 
	} else { 
		$text = '<font color="green"><strong>'.__('Off', 'bulletproof-security').'</strong></font>';
		echo $text.'<br>';
	} 
	echo __('PHP Display Errors', 'bulletproof-security').': ';
	if (ini_get('display_errors') == 1) { 
		$text = '<font color="red"><strong>'.__('On', 'bulletproof-security').'</strong></font>';
		echo $text.'<br>'; 
	} else { 
		$text = '<font color="green"><strong>'.__('Off', 'bulletproof-security').'</strong></font>';
		echo $text.'<br>';
	}
	echo __('PHP Display Startup Errors', 'bulletproof-security').': ';
	if (ini_get('display_startup_errors') == 1) { 
		$text = '<font color="red"><strong>'.__('On', 'bulletproof-security').'</strong></font>';
		echo $text.'<br>';
	} else { 
		$text = '<font color="green"><strong>'.__('Off', 'bulletproof-security').'</strong></font>';
		echo $text.'<br>';
	}
	echo __('PHP Expose PHP', 'bulletproof-security').': ';
	if (ini_get('expose_php') == 1) { 
		$text = '<font color="red"><strong>'.__('On', 'bulletproof-security').'</strong></font>';
		echo $text.'<br>';
	} else { 
		$text = '<font color="green"><strong>'.__('Off', 'bulletproof-security').'</strong></font>';
		echo $text.'<br>';
	}
	echo __('PHP Register Globals', 'bulletproof-security').': ';
	if (ini_get('register_globals') == 1) { 
		$text = '<font color="red"><strong>'.__('On', 'bulletproof-security').'</strong></font>';
		echo $text.'<br>';
	} else { 
		$text = '<font color="green"><strong>'.__('Off', 'bulletproof-security').'</strong></font>';
		echo $text.'<br>';
	}
	echo __('PHP MySQL Allow Persistent Connections', 'bulletproof-security').': ';
	if (ini_get('mysql.allow_persistent') == 1) { 
		$text = '<font color="red"><strong>'.__('On', 'bulletproof-security').'</strong></font>';
		echo $text.'<br>'; 
	} else { 
		$text = '<font color="green"><strong>'.__('Off', 'bulletproof-security').'</strong></font>';
		echo $text.'<br>';
	}
	echo __('PHP Output Buffering', 'bulletproof-security').': ';
	$output_buffering = ini_get('output_buffering');
	if (ini_get('output_buffering') != 0) { 
		echo '<font color="red"><strong>'.$output_buffering.'</strong></font><br>';
	} else { 
		echo '<font color="green"><strong>'.$output_buffering.'</strong></font><br>'; 
	}
	echo __('PHP Max Script Execution Time', 'bulletproof-security').': '; $max_execute = ini_get('max_execution_time');
	echo '<strong>'.$max_execute.' Seconds</strong><br>';
	echo __('PHP Magic Quotes GPC', 'bulletproof-security').': ';
	if (ini_get('magic_quotes_gpc') == 1) { 
		$text = '<font color="red"><strong>'.__('On', 'bulletproof-security').'</strong></font>';
		echo $text.'<br>'; 
	} else { 
		$text = '<font color="green"><strong>'.__('Off', 'bulletproof-security').'</strong></font>';
		echo $text.'<br>'; 
	}
	echo __('PHP open_basedir', 'bulletproof-security').': ';
	$open_basedir = ini_get('open_basedir');
	if ($open_basedir != '') {
		echo '<strong>'.$open_basedir.'</strong><br>';
	} else {
		echo '<strong>'.__('not in use', 'bulletproof-security').'</strong><br>';	
	}
	echo __('PHP XML Support', 'bulletproof-security').': ';
	if (is_callable('xml_parser_create')) { 
		$text = '<strong>'.__('Yes', 'bulletproof-security').'</strong></font>';
		echo $text.'<br>';
	} else { 
		$text = '<strong>'.__('No', 'bulletproof-security').'</strong></font>';
		echo $text.'<br>';
	}
	echo __('PHP IPTC Support', 'bulletproof-security').': ';
	if (is_callable('iptcparse')) { 
		$text = '<strong>'.__('Yes', 'bulletproof-security').'</strong></font>';
		echo $text.'<br>';
	} else { 
		$text = '<strong>'.__('No', 'bulletproof-security').'</strong></font>';
		echo $text.'<br>';
	}
	echo __('PHP Exif Support', 'bulletproof-security').': ';
	if (is_callable('exif_read_data')) { 
		$text = '<strong>'.__('Yes', 'bulletproof-security').'</strong></font>';
		echo $text.'<br>';
	} else { 
		$text = '<strong>'.__('No', 'bulletproof-security').'</strong></font>';
		echo $text.'<br>';
	}
	?>
	
    </td>      
    <td>&nbsp;</td>
    <td rowspan="2" class="bps-table_cell">
	<?php 
	//echo bpsPro_sysinfo_mod_checks_smon().'<br>';
	//echo bpsPro_sysinfo_mod_checks_hud().'<br>';
	//echo bpsPro_sysinfo_mod_checks_phpini().'<br>';
	//echo bpsPro_sysinfo_mod_checks_elog().'<br>';
    
	_e('Check your website Headers or another website\'s Headers by making a GET Request', 'bulletproof-security').'<br>';

// Form - wp_remote_get Headers check - GET Request Method
function bps_sysinfo_get_headers_get() {
	if (isset($_POST['Submit-Headers-Check-Get']) && current_user_can('manage_options')) {
		check_admin_referer( 'bpsHeaderCheckGet' );

	$url = ( isset($_POST['bpsURLGET']) ) ? $_POST['bpsURLGET'] : '';
	$response = wp_remote_get( $url );

	if ( !is_wp_error( $response ) ) {	

	echo '<strong>'.__('GET Request Headers: ', 'bulletproof-security').'</strong>'.$url.'<br>';
	echo '<pre>';
	echo 'HTTP Status Code: ';
	print_r($response['response']['code']);
	echo ' ';
	print_r($response['response']['message']);
	echo '<br><br>';
	echo 'Headers: ';
	print_r($response['headers']);
	echo '</pre>';	

	} else {
		
		$text = '<font color="red"><strong>'.__('Error: The WordPress wp_remote_get function is not available or is blocked on your website/server.', 'bulletproof-security').'</strong></font><br>';
		echo $text;
	}
	}
}
?>

<form name="bpsHeadersGet" action="admin.php?page=bulletproof-security/admin/system-info/system-info.php" method="post">
<?php wp_nonce_field('bpsHeaderCheckGet'); ?>
<div><label for="bpsHeaders"><strong><?php _e('Enter a Website URL - Example: http://www.ait-pro.com/', 'bulletproof-security'); ?></strong></label><br />
    <input type="text" name="bpsURLGET" value="" size="50" /> <br />
    <p class="submit">
	<input type="submit" name="Submit-Headers-Check-Get" class="bps-blue-button" value="<?php esc_attr_e('Check Headers GET Request', 'bulletproof-security') ?>" onclick="return confirm('<?php $text = __('This Headers check makes a GET Request using the WordPress wp_remote_get function.', 'bulletproof-security').'\n\n'.$bpsSpacePop.'\n\n'.__('You can use the Check Headers HEAD Request tool to check headers using HEAD instead of GET.', 'bulletproof-security').'\n\n'.$bpsSpacePop.'\n\n'.__('Click OK to proceed or click Cancel.', 'bulletproof-security'); echo $text; ?>')" /></p>
</div>
<?php bps_sysinfo_get_headers_get(); ?>
</form>

<?php
_e('Check your website Headers or another website\'s Headers by making a HEAD Request', 'bulletproof-security').'<br>';

// Form - cURL Headers check - HEAD Request Method
function bps_sysinfo_get_headers_head() {
	if (isset($_POST['Submit-Headers-Check-Head']) && current_user_can('manage_options')) {
		check_admin_referer( 'bpsHeaderCheckHead' );

	$disabled = explode(',', ini_get('disable_functions'));	

	if ( extension_loaded('curl') && !in_array('curl_init', $disabled) && !in_array('curl_exec', $disabled) && !in_array('curl_setopt', $disabled) ) {

		$url = ( isset($_POST['bpsURL']) ) ? $_POST['bpsURL'] : '';
		$useragent = 'BPS Headers Check';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_FILETIME, true);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_NOBODY, true); // HEAD Request method
		$ce = curl_exec($ch);
		curl_close($ch);

		echo '<strong>'.__('HEAD Request Headers: ', 'bulletproof-security').'</strong>'.$url.'<br>';
		echo '<pre>';
		print_r($ce);
		echo '</pre>';
	
	} else {
		
		$text = '<font color="red"><strong>'.__('Error: The cURL Headers Check does not work on your website. Either the cURL Extension is not loaded or one of these functions is disabled in your php.ini file: curl_init, curl_exec and/or curl_setopt.', 'bulletproof-security').'</strong></font><br>';
		echo $text;
	}
	}
}
?>

<form name="bpsHeadersHead" action="admin.php?page=bulletproof-security/admin/system-info/system-info.php" method="post">
<?php wp_nonce_field('bpsHeaderCheckHead'); ?>
<div><label for="bpsHeaders"><strong><?php _e('Enter a Website URL - Example: http://www.ait-pro.com/', 'bulletproof-security'); ?></strong></label><br />
    <input type="text" name="bpsURL" value="" size="50" /> <br />
    <p class="submit">
	<input type="submit" name="Submit-Headers-Check-Head" class="bps-blue-button" value="<?php esc_attr_e('Check Headers HEAD Request', 'bulletproof-security') ?>" onclick="return confirm('<?php $text = __('This cURL Headers check makes a HEAD Request and you will see HTTP/1.1 403 Forbidden displayed if you are blocking HEAD Requests in your BPS root .htaccess file on your website.', 'bulletproof-security').'\n\n'.$bpsSpacePop.'\n\n'.__('Use the Check Headers GET Request tool to check your headers using GET instead of HEAD. This tool can also be used to check that your Security Log is working correctly and will generate a Security Log entry when you make a HEAD Request using this tool if you are blocking HEAD Requests in your BPS root .htaccess file on your website.', 'bulletproof-security').'\n\n'.$bpsSpacePop.'\n\n'.__('Click OK to proceed or click Cancel.', 'bulletproof-security'); echo $text; ?>')" /></p>
</div>
<?php bps_sysinfo_get_headers_head(); ?>
</form>

    </td>
  </tr>
  <tr>
    <td class="bps-table_cell">&nbsp;</td>
    <td>&nbsp;</td>
    <!-- <td class="bps-table_cell">&nbsp;</td> -->
  </tr>
  <tr>
    <td class="bps-table_cell_bottom">&nbsp;</td>
    <td>&nbsp;</td>
    <td class="bps-table_cell_bottom">&nbsp;</td>
  </tr>
</table>
<br />
<?php }} // end if ( is_admin() && wp_script_is( 'bps-js', $list = 'queue' ) && current_user_can('manage_options') ) { ?>
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