<?php
/**
 * Plugin Name: Gears
 * Plugin URI: http://themeforest.net/user/dunhakdis
 * Description: Contains handful of BuddyPress shortcodes integrated into Visual Composer
 * Version: 1.3
 * Author: Dunhakdis
 * Author URI: http://themeforest.net/user/dunhakdis
 * License: Envato License
 */


DEFINE( 'GEARS_APP_NAMESPACE', 'Gears' ); 
DEFINE( 'GEARS_APP_VERSION', 1.3 ); 
DEFINE( 'GEARS_APP_PATH', plugin_dir_path( __FILE__ )  ); 

require_once GEARS_APP_PATH . 'gears-engine.php';

$Gears = new Gears();

?>