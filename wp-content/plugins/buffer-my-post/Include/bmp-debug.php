<?php

function BMP_DEBUG( $str ) {
	global $bmp_debug;
        $bmp_enable_log = get_option('bmp_enable_log');
        if($bmp_enable_log)
        {
	$bmp_debug->enable(true);
        }
        
	$bmp_debug->add_to_log( $str );
}

function bmp_is_debug_enabled() {
	global $bmp_debug;
	
	return $bmp_debug->is_enabled();
}

class bmpDebug {
	var $debug_file;
	var $log_messages;

	function bmpDebug() {
		$this->debug_file = false;
	}
	
	function is_enabled() {
		return ( $this->debug_file );	
	}

	function enable( $enable_or_disable ) {
		if ( $enable_or_disable ) {
			$this->debug_file = fopen( WP_CONTENT_DIR . '/plugins/Buffer-My-Post/log.txt', 'a+t' );
			$this->log_messages = 0;
		} else if ( $this->debug_file ) {
			fclose( $this->debug_file );
			$this->debug_file = false;		
		}
	}

	function add_to_log( $str ) {
		if ( $this->debug_file ) {
			
			$log_string = $str;
			
			// Write the data to the log file
			fwrite( $this->debug_file, sprintf( "%12s %s\n", time(), $log_string ) );
			fflush( $this->debug_file );
			
			$this->log_messages++;
		}
	}
}

global $bmp_debug;
$bmp_debug = &new bmpDebug;


?>
