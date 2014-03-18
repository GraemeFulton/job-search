<!-- BEGIN COPY CODE - BPS 404 Error logging code -->
<?php 
// Copy this logging code from BEGIN COPY CODE above to END COPY CODE below and paste it right after <?php get_header(); > in
// your Theme's 404.php template file located in your themes folder /wp-content/themes/your-theme-folder-name/404.php.
$bpsProLog = WP_CONTENT_DIR . '/bps-backup/logs/http_error_log.txt';
$hostname = @gethostbyaddr($_SERVER['REMOTE_ADDR']);
$timeNow = time();
$gmt_offset = get_option( 'gmt_offset' ) * 3600;
	
	if ( !get_option( 'gmt_offset' ) ) {
		$timestamp = date("F j, Y g:i a", time() );
	} else {
		$timestamp = date_i18n(get_option('date_format'), strtotime("11/15-1976")) . ' - ' . date_i18n(get_option('time_format'), $timeNow + $gmt_offset);
	}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$fh = fopen($bpsProLog, 'a');
 	@fwrite($fh, "\r\n>>>>>>>>>>> 404 POST Request Error Logged - $timestamp <<<<<<<<<<<\r\n");
	@fwrite($fh, 'REMOTE_ADDR: '.$_SERVER['REMOTE_ADDR']."\r\n");
	@fwrite($fh, 'Host Name: '."$hostname\r\n");
	@fwrite($fh, 'SERVER_PROTOCOL: '.$_SERVER['SERVER_PROTOCOL']."\r\n");
	@fwrite($fh, 'HTTP_CLIENT_IP: '.$_SERVER['HTTP_CLIENT_IP']."\r\n");
	@fwrite($fh, 'HTTP_FORWARDED: '.$_SERVER['HTTP_FORWARDED']."\r\n");
	@fwrite($fh, 'HTTP_X_FORWARDED_FOR: '.$_SERVER['HTTP_X_FORWARDED_FOR']."\r\n");
	@fwrite($fh, 'HTTP_X_CLUSTER_CLIENT_IP: '.$_SERVER['HTTP_X_CLUSTER_CLIENT_IP']."\r\n");
 	@fwrite($fh, 'REQUEST_METHOD: '.$_SERVER['REQUEST_METHOD']."\r\n");
 	@fwrite($fh, 'HTTP_REFERER: '.$_SERVER['HTTP_REFERER']."\r\n");
 	@fwrite($fh, 'REQUEST_URI: '.$_SERVER['REQUEST_URI']."\r\n");
 	@fwrite($fh, 'QUERY_STRING: '.$_SERVER['QUERY_STRING']."\r\n");
	@fwrite($fh, 'HTTP_USER_AGENT: '.$_SERVER['HTTP_USER_AGENT']."\r\n");
 	fclose($fh);

	} else {
	// log anything else that triggered a 404 Error
	$fh = fopen($bpsProLog, 'a');
 	@fwrite($fh, "\r\n>>>>>>>>>>> 404 GET or Other Request Error Logged - $timestamp <<<<<<<<<<<\r\n");
	@fwrite($fh, 'REMOTE_ADDR: '.$_SERVER['REMOTE_ADDR']."\r\n");
	@fwrite($fh, 'Host Name: '."$hostname\r\n");
	@fwrite($fh, 'SERVER_PROTOCOL: '.$_SERVER['SERVER_PROTOCOL']."\r\n");
	@fwrite($fh, 'HTTP_CLIENT_IP: '.$_SERVER['HTTP_CLIENT_IP']."\r\n");
	@fwrite($fh, 'HTTP_FORWARDED: '.$_SERVER['HTTP_FORWARDED']."\r\n");
	@fwrite($fh, 'HTTP_X_FORWARDED_FOR: '.$_SERVER['HTTP_X_FORWARDED_FOR']."\r\n");
	@fwrite($fh, 'HTTP_X_CLUSTER_CLIENT_IP: '.$_SERVER['HTTP_X_CLUSTER_CLIENT_IP']."\r\n");
 	@fwrite($fh, 'REQUEST_METHOD: '.$_SERVER['REQUEST_METHOD']."\r\n");
 	@fwrite($fh, 'HTTP_REFERER: '.$_SERVER['HTTP_REFERER']."\r\n");
 	@fwrite($fh, 'REQUEST_URI: '.$_SERVER['REQUEST_URI']."\r\n");
 	@fwrite($fh, 'QUERY_STRING: '.$_SERVER['QUERY_STRING']."\r\n");
	@fwrite($fh, 'HTTP_USER_AGENT: '.$_SERVER['HTTP_USER_AGENT']."\r\n");
 	fclose($fh);
}
?>
<!-- END COPY CODE - BPS Error logging code -->