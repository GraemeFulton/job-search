<?php

class acn_admin {

	var $options;

	/* constructor for admin panel */
	function __construct() {
		$this->slug = 'wp-acn';
		$this->tabs = array( 'general' => __('General','acn'), 'rules' => __('Exclude Rules','acn'), 'grid' => __('Grid','acn'), 'theming' => __('Theming','acn') );
		$this->default_tab = 'general';
		add_action('admin_menu', array(&$this, 'add_menu'), 9);
		add_action('admin_enqueue_scripts', array(&$this, 'add_styles'), 9);
		$this->defaults = array(
			'show_count' => 1,
			'num_loaded_first_time' => 3,
			'num_loaded_every_time' => 3,
			'num_load_more' => 9,
			'distance_before_autoload' => 400,
			'style' => 'default',
			'enable_toggle' => 1,
			'show_wooprice' => 0,
			'show_author' => 1,
			'show_teaser' => 1,
			'show_title' => 1,
			'show_date' => 1,
			'show_comments' => 1,
			'show_likes' => 1,
			'show_perma_icon' => 1,
			'show_social' => 1,
			'show_sliders' => 1,
			'show_menu' => 1,
			'excluded_taxonomies' => array('nav_menu', 'link_category', 'post_format'),
			'excluded_types' => array('attachment', 'revision', 'nav_menu_item'),
			'excluded_sort' => array(''),
			'excluded_formats' => array(''),
			'enable_post_types' => 1,
			'enable_post_formats' => 1,
			'enable_sort' => 1,
			'grid' => 0,
			'grid_ecommerce' => 0
		);
		$themes = apply_filters('acn_builtin_skins',array());
		$this->defaults = array_merge($this->defaults, $themes['default']);
		$this->options = get_option('acn_options');
		if (!get_option('acn_options')) {
			update_option('acn_options', $this->defaults);
		}
	}
	
	/* Backend styles */
	function add_styles(){
	
		/* admin panel css */
		wp_register_style( 'acn_admin',acn_url.'admin/css/acn-admin.css');
		wp_enqueue_style('acn_admin');
	
		wp_register_script( 'acn_admin', acn_url.'admin/js/admin.js', array('jquery', 'wp-color-picker'));
		wp_enqueue_script( 'acn_admin' );
		
		/* include the color picker in admin */
		wp_enqueue_style( 'wp-color-picker' );
	
	}
	
	// add menu
	function add_menu() {
		add_submenu_page( 'options-general.php', __('Ajax Content Navigator','acn'), __('Ajax Content Navigator','acn'), 'manage_options', $this->slug, array(&$this, 'settings_page'), null);
	}
	
	// get value in admin option
	function get_value($option_id) {
		if (isset($this->options[$option_id]) && $this->options[$option_id] != '' ) {
			return $this->options[$option_id];
		} elseif (isset($this->defaults[$option_id]) && $this->defaults[$option_id] != '' ) {
			return $this->defaults[$option_id];
		} else {
			return null;
		}
	}
	
	// add normal info
	function add_plugin_info($label, $content) {
		print "<tr valign=\"top\">
				<th scope=\"row\"><label>$label</label></th>
				<td class=\"acn-label\">$content</td>
			</tr>";
	}

	// add setting field
	function add_plugin_setting($type, $id, $label, $pairs, $help, $extra=null) {
		
		print "<tr valign=\"top\">
				<th scope=\"row\"><label for=\"$id\">$label</label></th>
				<td>";
				
				switch ($type) {
				
					case 'textarea':
						$value = $this->get_value($id);
						print "<textarea name=\"$id\" type=\"text\" id=\"$id\" class=\"large-text code\" rows=\"3\">$value</textarea>";
						break;
				
					case 'input':
						$value = $this->get_value($id);
						print "<input name=\"$id\" type=\"text\" id=\"$id\" value=\"$value\" class=\"regular-text\" />";
						break;
				
					case 'select':
						print "<select name=\"$id\" id=\"$id\">";
							foreach($pairs as $k => $v) {
						
								if (is_array($v)) {
									$v = $v['name'];
								}
								
								echo '<option value="'.$k.'"';
								if (isset($this->options[$id]) && $k == $this->options[$id]) {
									echo ' selected="selected"';
								}
								echo '>';
								echo $v;
								echo '</option>';
								
							}
						print "</select>";
						break;
						
					case 'multiselect':
						print "<select name=\"$id"."[]\" size=\"10\" multiple=\"true\">";
							
							if ($pairs == 'taxonomy_list') {
									$taxonomies=get_taxonomies('','names'); 
									foreach ($taxonomies as $taxonomy ) {
										$the_tax = get_taxonomy( $taxonomy );
										echo '<option value="'.$taxonomy.'"';
										if (isset($this->options[$id]) && is_array($this->options[$id]) && in_array($taxonomy, $this->options[$id])) {
											echo ' selected="selected"';
										}
										echo '>';
										echo $the_tax->labels->name;
										echo '</option>';
									}
							}
							
							if ($pairs == 'posttype_list') {
									$post_types=get_post_types('','names'); 
									foreach ($post_types as $post_type ) {
										$object = get_post_type_object( $post_type );
										echo '<option value="'.$post_type.'"';
										if (isset($this->options[$id]) && is_array($this->options[$id]) && in_array($post_type, $this->options[$id])) {
											echo ' selected="selected"';
										}
										echo '>';
										echo $object->labels->name;
										echo '</option>';
									}
							}
							
							if ($pairs == 'format_list') {
								if ( current_theme_supports( 'post-formats' ) ) {
									$post_formats = get_theme_support( 'post-formats' );
									if ( is_array( $post_formats[0] ) ) {
										$formats = $post_formats[0];
										foreach($formats as $format) {
										
										echo '<option value="'.$format.'"';
										if (isset($this->options[$id]) && is_array($this->options[$id]) && in_array($format, $this->options[$id])) {
											echo ' selected="selected"';
										}
										echo '>';
										echo ucfirst($format);
										echo '</option>';
										
										
										}
									}
								}
							}
							
							if ($pairs == 'sort_list') {
									$sort_array = array(
										'name' => __('Alphabetically','acn'),
										'comment_count' => __('Most Popular','acn'),
										'date' => __('Newest First','acn'),
										'date_asc' => __('Oldest First','acn'),
										'meta_value_num' => __('Top Liked','acn')
										);
									foreach($sort_array as $k => $v) {
										echo '<option value="'.$k.'"';
										if (isset($this->options[$id]) && is_array($this->options[$id]) && in_array($k, $this->options[$id])) {
											echo ' selected="selected"';
										}
										echo '>';
										echo $v;
										echo '</option>';
									}
							}
							
								"</select>";
						break;
						
					case 'color':
						global $acn;
						$themes = apply_filters('acn_builtin_skins',array());
						$default_color = $themes['default'][$id];
						if (isset($this->options[$id]) && $this->options[$id] != '' ) {
							$value = $this->options[$id];
						} else {
							$value = $themes['default'][$id];
						}
						print "<input name=\"$id\" type=\"text\" id=\"$id\" value=\"$value\" class=\"my-color-field\" data-default-color=\"$default_color\" />";
						break;
						
				}
		
		if ($help)
			print "<p class=\"description\">$help</p>";
		
		if (is_array($extra)) {
			echo "<div class=\"helper-wrap\">";
			foreach ($extra as $a) {
				echo $a;
			}
			echo "</div>";
		}
					
		print "</td></tr>";
		
	}
	
	// save form
	function saveform() {
		foreach($_POST as $key => $value) {
			if ($key != 'submit') {
				if (!is_array($_POST[$key])) {
				$this->options[$key] = esc_attr($_POST[$key]);
				} else {
				$this->options[$key] = $_POST[$key];
				}
				if ($key == 'custom_css') {
				$this->options[$key] = stripslashes($_POST[$key]);
				}
			}
		}
		if (!isset($_POST['excluded_taxonomies']) && isset($_GET['tab']) && $_GET['tab'] == 'rules') {
			$this->options['excluded_taxonomies'] = '';
		}
		if (!isset($_POST['excluded_types']) && isset($_GET['tab']) && $_GET['tab'] == 'rules') {
			$this->options['excluded_types'] = '';
		}
		if (!isset($_POST['excluded_sort']) && isset($_GET['tab']) && $_GET['tab'] == 'rules') {
			$this->options['excluded_sort'] = '';
		}
		if (!isset($_POST['excluded_formats']) && isset($_GET['tab']) && $_GET['tab'] == 'rules') {
			$this->options['excluded_formats'] = '';
		}
	}
	
	// save default colors
	function save_default_colors() {
		$alloptions = get_option('acn_options');
		foreach( $this->colorsdefault as $k =>$v) {
			$alloptions[$k] = $v;
			$this->options[$k] = $v;
		}
	}
	
	// update settings
	function update() {
		update_option('acn_options', $this->options);
		echo '<div class="updated"><p><strong>'.__('Settings saved.','acn').'</strong></p></div>';
	}
	
	// reset settings
	function reset() {
		update_option('acn_options', $this->defaults );
		$this->options = array_merge( $this->options, $this->defaults );
		echo '<div class="updated"><p><strong>'.__('Settings are reset to default.','acn').'</strong></p></div>';
	}
	
	/* Get admin tabs */
	function admin_tabs( $current = null ) {
			$tabs = $this->tabs;
			$links = array();
			if ( isset ( $_GET['tab'] ) ) {
				$current = $_GET['tab'];
			} else {
				$current = $this->default_tab;
			}
			foreach( $tabs as $tab => $name ) :
				if ( $tab == $current ) :
					$links[] = "<a class='nav-tab nav-tab-active' href='?page=".$this->slug."&tab=$tab'>$name</a>";
				else :
					$links[] = "<a class='nav-tab' href='?page=".$this->slug."&tab=$tab'>$name</a>";
				endif;
			endforeach;
			foreach ( $links as $link )
				echo $link;
	}
	
	/* get tab ID and load its content */
	function get_tab_content() {
		$screen = get_current_screen();
		if( strstr($screen->id, $this->slug ) ) {
			if ( isset ( $_GET['tab'] ) ) {
				$tab = $_GET['tab'];
			} else {
				$tab = $this->default_tab;
			}
			$this->load_tab($tab);
		}
	}
	
	/* load tab */
	function load_tab($tab) {
		require_once acn_path.'admin/'.$tab.'.php';
	}

	// add settings
	function settings_page() {
	
		/**
		* @submit settings page
		*/
		if (isset($_POST['submit'])) {
			$this->saveform();
			$this->update();
		}
		
		/**
		* @submit theme reset button
		*/
		if (isset($_POST['reset-custom-theme'])) {
			$this->saveform();
			$this->save_default_colors();
			$this->update();
		}
		
		/**
		* @callback to restore all options
		*/
		if (isset($_POST['reset-options'])) {
			$this->reset();
		}
		
	?>
	
		<div class="wrap">
			<div id="icon-<?php echo $this->slug; ?>" class="icon32"><br /></div><h2 class="nav-tab-wrapper"><?php $this->admin_tabs(); ?></h2>
			<form method="post" action="">
				<?php $this->get_tab_content(); ?>
				<p class="submit">
					<input type="submit" name="submit" id="submit" value="<?php _e('Save Changes','acn'); ?>" class="button button-primary" />
					<input type="submit" name="reset-options" value="<?php _e('Reset Options','acn'); ?>" class="button button-secondary" />
				</p>
			</form>
		</div>

	<?php }

}

$acn_admin = new acn_admin();