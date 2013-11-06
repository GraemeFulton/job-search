<?php
/*
  Plugin Name: Smooth Scroll Up
  Plugin URI: http://wordpress.org/extend/plugins/smooth-scroll-up/
  Author URI: http://www.kouratoras.gr
  Author: Konstantinos Kouratoras
  Contributors: kouratoras
  Tags: page, scroll up, scroll, up, navigation, back to top, back, to, top, scroll to top
  Requires at least: 2.9.0
  Tested up to: 3.7
  Stable tag: 0.5.2
  Version: 0.5.2
  License: GPLv2 or later
  Description: Scroll Up plugin lightweight plugin that creates a customizable "Scroll to top" feature in any post/page of your WordPress website.

  Copyright 2012 Konstantinos Kouratoras (kouratoras@gmail.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

define('PLUGIN_DIR_NAME', 'smooth-scroll-up');

class ScrollUp {
	/* -------------------------------------------------- */
	/* Constructor
	  /*-------------------------------------------------- */

	public function __construct() {

		load_plugin_textdomain('scroll-up-locale', false, plugin_dir_path(__FILE__) . '/lang/');

		//Register scripts and styles
		add_action('wp_enqueue_scripts', array(&$this, 'register_plugin_scripts'));
		add_action('wp_enqueue_scripts', array(&$this, 'register_plugin_styles'));
		
		//Action links
		add_filter('plugin_action_links', array(&$this, 'plugin_action_links'), 10, 2);
		
		//Inline CSS
		add_action( 'wp_head', array(&$this, 'plugin_css'));
		
		//Start up script
		add_action( 'wp_footer', array(&$this, 'plugin_js'));

		//Options Page
		add_action('admin_menu', array(&$this, 'plugin_add_options'));
	}
	
	public function plugin_action_links($links, $file) {
		static $current_plugin;

		if (!$current_plugin) {
			$current_plugin = plugin_basename(__FILE__);
		}
		
		if ($file == $current_plugin) {
			$settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/options-general.php?page=scrollupoptions">'.__('Settings','scroll-up-locale').'</a>';
			array_unshift($links, $settings_link);
		}

		return $links;
	}

	function plugin_css()
	{
		$scrollup_position = get_option('scrollup_position', 'left');
		if($scrollup_position=='left')
			echo '<style>#scrollUp {left: 20px;}</style>';
		else
			echo '<style>#scrollUp {right: 20px;}</style>';
	}
	
	function plugin_js()
	{
		$scrollup_text = get_option('scrollup_text', 'Scroll to top!');
		echo '<script> var $nocnflct = jQuery.noConflict();
			$nocnflct(function () {
			    $nocnflct.scrollUp({
				scrollName: \'scrollUp\', // Element ID
				scrollDistance: 300, // Distance from top/bottom before showing element (px)
				scrollFrom: \'top\', // top or bottom
				scrollSpeed: 300, // Speed back to top (ms)
				easingType: \'linear\', // Scroll to top easing (see http://easings.net/)
				animation: \'fade\', // Fade, slide, none
				animationInSpeed: 200, // Animation in speed (ms)
				animationOutSpeed: 200, // Animation out speed (ms)
				scrollText: \''.$scrollup_text.'\', // Text for element, can contain HTML
				scrollTitle: false, // Set a custom <a> title if required. Defaults to scrollText
				scrollImg: false, // Set true to use image
				activeOverlay: false, // Set CSS color to display scrollUp active point
				zIndex: 2147483647 // Z-Index for the overlay
			    });
			});
			</script>';
	}

	public function plugin_add_options() {
		add_options_page('Scroll Up Options', 'Scroll Up Options', 'manage_options', 'scrollupoptions', array(&$this, 'plugin_options_page'));
	}

	function plugin_options_page() {

		$opt_name = array(
				'scrollup_text' => 'scrollup_text',
				'scrollup_type' => 'scrollup_type',
				'scrollup_show' => 'scrollup_show',
				'scrollup_position' => 'scrollup_position'
				);
		$hidden_field_name = 'scrollup_submit_hidden';

		$opt_val = array(
				'scrollup_text' => get_option($opt_name['scrollup_text']),
				'scrollup_type' => get_option($opt_name['scrollup_type']),
				'scrollup_show' => get_option($opt_name['scrollup_show']),
				'scrollup_position' => get_option($opt_name['scrollup_position'])
			);

		if (isset($_POST[$hidden_field_name]) && $_POST[$hidden_field_name] == 'Y') {
			$opt_val = array(
					'scrollup_text' => $_POST[$opt_name['scrollup_text']],
					'scrollup_type' => $_POST[$opt_name['scrollup_type']],
					'scrollup_show' => $_POST[$opt_name['scrollup_show']],
					'scrollup_position' => $_POST[$opt_name['scrollup_position']]
				    );
			update_option($opt_name['scrollup_text'], $opt_val['scrollup_text']);
			update_option($opt_name['scrollup_type'], $opt_val['scrollup_type']);
			update_option($opt_name['scrollup_show'], $opt_val['scrollup_show']);
			update_option($opt_name['scrollup_position'], $opt_val['scrollup_position']);
			?>
			<div id="message" class="updated fade">
				<p><strong>
						<?php _e('Options saved.', 'scroll-up-locale'); ?>
					</strong></p>
			</div>
			<?php
		}
		?>

		<div class="wrap">
			<h2><?php _e('Smooth Scroll Up', 'att_trans_domain'); ?></h2>
			<form name="att_img_options" method="post" action="<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>">
				<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

				<p><label for="">Scroll Up text:</label>
					<input type="text" name="<?php echo $opt_name['scrollup_text']; ?>" id="<?php echo $opt_name['scrollup_text']; ?>" value="<?php echo $opt_val['scrollup_text']; ?>"/>
				</p>
				
				<p><label for="">Scroll Up type</label>
					<select name="<?php echo $opt_name['scrollup_type']; ?>">
						<option value="link" <?php echo ($opt_val['scrollup_type'] == "link") ? 'selected="selected"' : ''; ?> ><?php _e('Text link', 'scroll-up-locale'); ?></option>
						<option value="pill" <?php echo ($opt_val['scrollup_type'] == "pill") ? 'selected="selected"' : ''; ?> ><?php _e('Pill', 'scroll-up-locale'); ?></option>
						<option value="tab" <?php echo ($opt_val['scrollup_type'] == "tab") ? 'selected="selected"' : ''; ?> ><?php _e('Tab', 'scroll-up-locale'); ?></option>
					</select>
				</p>
				
				<p><label for="">Scroll Up position</label>
					<select name="<?php echo $opt_name['scrollup_position']; ?>">
						<option value="left" <?php echo ($opt_val['scrollup_position'] == "left") ? 'selected="selected"' : ''; ?> ><?php _e('Left', 'scroll-up-locale'); ?></option>
						<option value="right" <?php echo ($opt_val['scrollup_position'] == "right") ? 'selected="selected"' : ''; ?> ><?php _e('Right', 'scroll-up-locale'); ?></option>
					</select>
				</p>
				
				<p><label for="">Show in homepage</label>
					<select name="<?php echo $opt_name['scrollup_show']; ?>">
						<option value="0" <?php echo ($opt_val['scrollup_show'] == "0") ? 'selected="selected"' : ''; ?> ><?php _e('No', 'scroll-up-locale'); ?></option>
						<option value="1" <?php echo ($opt_val['scrollup_show'] == "1") ? 'selected="selected"' : ''; ?> ><?php _e('Yes', 'scroll-up-locale'); ?></option>
					</select>
				</p>

				<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes', 'scroll-up-locale'); ?>"></p>
			</form>

			<?php
		}

		/* -------------------------------------------------- */
		/* Registers and enqueues scripts.
		  /* -------------------------------------------------- */

		public function register_plugin_scripts() {

			$scrollup_show = get_option('scrollup_show', '0');
			
			if(
				$scrollup_show=="1"
				||
				$scrollup_show=="0" && (!is_home() || !is_front_page())
			){
			
				wp_enqueue_script('jquery');

				wp_register_script('scrollup', plugins_url(PLUGIN_DIR_NAME . '/js/jquery.scrollUp.min.js'), '', '', true);
				wp_enqueue_script('scrollup');
			}
		}

		/* -------------------------------------------------- */
		/* Registers and enqueues styles.
		  /* -------------------------------------------------- */

		public function register_plugin_styles() {

			$scrollup_type = get_option('scrollup_type', 'tab');

			if ($scrollup_type == 'link') {
				wp_register_style('link', plugins_url(PLUGIN_DIR_NAME . '/css/link.css'));
				wp_enqueue_style('link');
			}

			else if ($scrollup_type == 'pill') {
				wp_register_style('pill', plugins_url(PLUGIN_DIR_NAME . '/css/pill.css'));
				wp_enqueue_style('pill');
			}

			else {
				wp_register_style('tab', plugins_url(PLUGIN_DIR_NAME . '/css/tab.css'));
				wp_enqueue_style('tab');
			}
		}

	}

	new ScrollUp();