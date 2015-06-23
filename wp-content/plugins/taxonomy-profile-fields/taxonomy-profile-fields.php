<?php
/**
 * The WordPress Plugin Boilerplate.
 *
 * A foundation off of which to build well-documented WordPress plugins that
 * also follow WordPress Coding Standards and PHP best practices.
 *
 * @package   Taxonomy Profile Fields
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 *
 * @wordpress-plugin
 * Plugin Name:       Taxonomy Profile Fields
 * Plugin URI:        @TODO
 * Description:       Allows users to register to taxonomy items within buddypress profile section
 * Version:           1.0.0
 * Author:            Graeme Fulton
 * Author URI:        @TODO
 * Text Domain:       plugin-name-locale
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/<owner>/<repo>
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

/*
 *Include vlearn google news class
 */
require_once( plugin_dir_path( __FILE__ ) . 'public/class-taxonomy-profile-fields.php' );

/*
 *Instantiate the Vlearn Google news
 */
add_action( 'plugins_loaded', array( 'Taxonomy_Profile_Fields', 'get_instance' ) );
