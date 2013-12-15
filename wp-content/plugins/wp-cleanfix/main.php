<?php
/// @cond private
/**
 * Plugin Name: WP CleanFix
 * Plugin URI: https://wpxtre.me
 * Description: Clean and fix tools! Repair corrupted data and clean up your database
 * Version: 3.0.2
 * Author: wpXtreme, Inc.
 * Author URI: https://wpxtre.me
 * Text Domain: wpx-cleanfix
 * Domain Path: localization
 *
 * WPX PHP Min: 5.2.4
 * WPX WP Min: 3.5
 * WPX MySQL Min: 5.0
 * WPX wpXtreme Min: 1.0.0.b4
 *
 */
// @endcond

/* Avoid directly access. */
if ( !defined( 'ABSPATH' ) ) {
  exit;
}

/* Start. */
add_action( 'WPDK', 'wpx_cleanfix_boot' );

/* Load WPDK. */
require_once( trailingslashit( dirname( __FILE__ ) ) . 'wpdk/wpdk.php' );

/**
 * Start the plugin
 *
 * @brief Let's dance
 */
function wpx_cleanfix_boot()
{
  /* Load CleanFix. */
  require_once( trailingslashit( dirname( __FILE__ ) ) . 'wpx-cleanfix.php' );
  $GLOBALS['WPXCleanFix'] = WPXCleanFix::boot( __FILE__ );
}