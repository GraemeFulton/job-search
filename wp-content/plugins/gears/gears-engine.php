<?php
/**
 * Community Essentials Engine
 * 
 * Community Essentials class file. Act as driver
 * for this plugin
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'Gears' ) )
{
	class Gears{
	
		/**
		 * initialize plugin modules, admin styles, and buddypress setup
		 */
		function __construct(){
		
			// modules
			add_action( 'init', array( $this, 'load_modules' ) );
			
			// admin stylesheets	
			add_action( 'admin_init', array( $this, 'admin_styles' ) );
			
			// BuddyPress config
			add_action( 'init', array( $this, 'bp_setup' ), 1 ); 
		}
		
		/**
		 * method module loader
		 */
		public function load_modules(){
			
			
			// Load the shortcodes
			require_once GEARS_APP_PATH. '/modules/shortcodes/library.php';
				new Gears_Shortcodes();

			// Facebook Connect
			$is_ce_module_facebook_login_enabled = $this->ot_theme_option( 'is_fb_enabled' );
			if( !is_user_logged_in() and $is_ce_module_facebook_login_enabled and get_option('users_can_register') ){
			
				// if facebook login is enabled
				// require the essential plugin
				// we need to check if there is curl installed/activated in the server
				// added in 2.1.0
				if( function_exists('curl_version') ){
					require_once GEARS_APP_PATH . '/modules/facebook-login/index.php';
					// Instantiate the module
					new GEARS_MODULES_FACEBOOK_LOGIN(
						$app_id = $this->ot_theme_option( 'application_id', '' ),
						$app_secret = $this->ot_theme_option( 'application_secret', '' ),
						$registrant_settings = $this->ot_theme_option( 'registrant_setting', 'not_unique' ),
						$button_label = $this->ot_theme_option( 'gears_fb_btn_label' , __('Connect w/ Facebook','gears') )
					);
				}
				
			}
			
			// Login Modal
			$is_ce_module_login_modal = true;
					
		}
		
		/**
		 * admin styling
		 */
		public function admin_styles(){
		
			//register our admin stylesheet
			wp_register_style( 'gears-admin-css', plugins_url('assets/admin.css', __FILE__) );
				wp_enqueue_style( 'gears-admin-css' );
		}
		
		/**
		 * option tree helper method
		 */
		public function ot_theme_option( $option_id, $default = '' ){
		
			// get the saved options
			$options = get_option( 'option_tree' );
			
			// look for the saved value
			if ( isset( $options[$option_id] ) && '' != $options[$option_id] ) {
				return $options[$option_id];
			}
			
			return $default;
 
		}
		
		/**
		 * buddypress configs
		 */
		function bp_setup(){
		
			// define avatar thumbnail width and height
			if( class_exists( 'BuddyPress' ) ){
				$bp = buddypress();
				
				DEFINE( 'BP_AVATAR_THUMB_WIDTH', 75 );
				DEFINE( 'BP_AVATAR_THUMB_HEIGHT', 75 );
				DEFINE( 'BP_AVATAR_FULL_WIDTH', 250 );
				DEFINE( 'BP_AVATAR_FULL_HEIGHT', 250 );
			}
		}
		
	}
} 
?>
