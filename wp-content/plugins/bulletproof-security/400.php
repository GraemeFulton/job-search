<?php session_cache_limiter('nocache'); ?>
<?php session_start(); ?>
<?php error_reporting(0); ?>
<?php session_destroy(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>400 Bad Request</title>
<style type="text/css">
<!--
body { 
	/* If you want to add a background image uncomment the CSS properties below */
	/* background-image:url(http://www.example.com/wp-content/plugins/bulletproof-security/abstract-blue-bg.png); /*
	/* background-repeat:repeat; */
	background-color:#CCCCCC;
	line-height: normal;
}

#bpsMessage {
	text-align:center; 
	background-color: #F7F8F9; 
	border:5px solid #000000; 
	padding:10px;
}

p {
    font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size:18px;
	font-weight:bold;
}
-->
</style>
</head>

<body>
<div id="bpsMessage">
	<p><?php $bps_hostname = $_SERVER['SERVER_NAME']; 
	$bps_hostname = str_replace('www.', '', $bps_hostname); 
	echo $bps_hostname; ?> 400 Bad Request Error Page</p>
	<p>If you arrived here due to a search or clicking on a link click your Browser's back button to return to the previous page. Thank you.</p>
</div>

<?php 
require_once('../../../wp-load.php');
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

	$fh = @fopen($bpsProLog, 'a');
 	@fwrite($fh, "\r\n>>>>>>>>>>> 400 POST Request Error Logged - $timestamp <<<<<<<<<<<\r\n");
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
 	@fclose($fh);

	} else {
	// log anything else that triggered a 404 Error
	$fh = @fopen($bpsProLog, 'a');
 	@fwrite($fh, "\r\n>>>>>>>>>>> 400 GET or Other Request Error Logged - $timestamp <<<<<<<<<<<\r\n");
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
 	@fclose($fh);
}
?>
</body>
</html>