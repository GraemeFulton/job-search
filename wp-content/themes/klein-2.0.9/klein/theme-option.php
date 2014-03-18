<?php
/**
 * Theme Option
 * 
 * @package Klein
 * @since 1.0
 */
?>
<?php
/**
 * Initialize the options before anything else. 
 */
add_action( 'admin_init', 'custom_theme_options', 1 );

/**
 * Build the custom settings & update OptionTree.
 */
function custom_theme_options() {
  /**
   * Get a copy of the saved settings array. 
   */
  $saved_settings = get_option( 'option_tree_settings', array() );
  
  /**
   * Custom settings array that will eventually be 
   * passes to the OptionTree Settings API Class.
   */
  $klein_options_settings = array(
    'contextual_help' => array(
      'content'       => array( 
        array(
          'id'        => 'general_help',
          'title'     => 'General',
          'content'   => '<p>Thank you for purchasing Klein WordPress Theme. Please visit http://dunhakdis.ticksy.com for support and inquiry.</p>'
        )
      ),
      'sidebar'       => '<p>:)</p>',
    ),
    'sections'        => array(
      array(
        'id'          => 'general',
        'title'       => 'General'
      ),
	  array(
        'id'          => 'custom_css',
        'title'       => 'Style Sheets'
      ),
	  array(
		'id'			=> 'layouts',
		'title'		=> 'Layouts'
	  ),
	   array(
		'id'			=> 'skin',
		'title'		=> 'Skin/Colors'
	  )
    ),
    'settings'   => array(
				array(
					'id'          => 'favicon',
					'label'       => 'Favicon',
					'desc'        => 'Select an image to use as favicon for your site. Please upload an icon file (.ico), other file types might not be supported in other browsers such as IE. Recommended size is 16x16 (pixels). <a href="http://www.thesitewizard.com/archive/favicon.shtml" target="_blank" title="About Favicons">Click here to learn more about favicons.</a>',
					'std'         => get_template_directory_uri() . '/favicon.ico',
					'type'        => 'upload',
					'section'     => 'general',
					'class'       => '',
					'choices'     => array(
						array( 
							'value' => 'yes',
							'label' => 'Yes' 
						)
					)
				),
				array(
					'id'          => 'logo',
					'label'       => 'Site Logo',
					'desc'        => 'Ideal image dimensions is 135x50 (pixels). Use your favorite image manipulation tool in-order to re-size or crop your logo.',
					'std'         => get_template_directory_uri() . '/logo.png',
					'type'        => 'upload',
					'section'     => 'general',
					'class'       => '',
					'choices'     => array(
						array( 
							'value' => 'yes',
							'label' => 'Yes' 
						)
					)
				),
				array(
					'id'          => 'container',
					'label'       => 'Container',
					'desc'        => 'Select what\'s the right layout for your site.',
					'std'         => '',
					'type'        => 'select',
					'section'     => 'layouts',
					'class'       => '',
					'choices'     => array(
							array( 'value' => 'fluid', 'label' => 'Fluid' ),
							array( 'value' => 'boxed', 'label' => 'Boxed' ),
						)
					
				),
				array(
					'id'          => 'base_preset',
					'label'       => 'Base Preset',
					'desc'        => 'Base preset skin you want your site to have.',
					'std'         => '',
					'type'        => 'select',
					'section'     => 'skin',
					'class'       => '',
					'choices'     => array(
							array( 'value' => 'default', 'label' => 'Default' ),
							array( 'value' => 'turquoise', 'label' => 'Turquoise' ),
							array( 'value' => 'alizarin', 'label' => 'Alizarin' ),
							array( 'value' => 'amethyst', 'label' => 'Amethyst' ),
							array( 'value' => 'asbestos', 'label' => 'Asbestos' ),
							array( 'value' => 'carrot', 'label' => 'Carrot' ),
							array( 'value' => 'emerald', 'label' => 'Emerald' ),
							array( 'value' => 'peter-river', 'label' => 'Peter River' ),
							array( 'value' => 'sun-flower', 'label' => 'Sun Flower' )
						)
					
				),
				array(
					'id'          => 'dark_layout_enable',
					'label'       => 'Dark Layout',
					'desc'        => 'Do you want to enable dark layout?',
					'type'        => 'checkbox',
					'section'     => 'skin',
					'class'       => '',
					'choices'     => array(
						array( 
							'value' => 'yes',
							'label' => 'Yes' 
						)
					)
				),
				array(
					'id'          => 'background',
					'label'       => 'Background (Boxed Container)',
					'desc'        => 'Upload a new background for your WordPress site.',
					'std'         => '',
					'type'        => 'background',
					'section'     => 'skin',
					'class'       => '',
					'choices'     => array(
						array( 
							'value' => 'yes',
							'label' => 'Yes' 
						)
					)
				),
				
				array(
					'id'          => 'header_fonts',
					'label'       => 'Header Fonts',
					'desc'        => 'Leave blank to use the default font (Montserrat). Otherwise, select the font you want to apply for the headings.',
					'std'         => '',
					'type'        => 'typography',
					'section'     => 'general',
					'class'       => '',
					'choices'     => array(
						array( 
							'value' => 'yes',
							'label' => 'Yes' 
						)
					)
				),
				
				array(
					'id'          => 'body_fonts',
					'label'       => 'Body Fonts',
					'desc'        => 'Leave blank to use the default font (PT Sans). Otherwise, select the font you want to apply for the body.',
					'std'         => '',
					'type'        => 'typography',
					'section'     => 'general',
					'class'       => '',
					'choices'     => array(
						array( 
							'value' => 'yes',
							'label' => 'Yes' 
						)
					)
				),
				array(
					'id'          => 'front_page_slider_id',
					'label'       => 'Front Page Slider ID',
					'desc'        => 'Enter or paste the revolution slider id you want to display in "Front Page (Slider Revolution) page template".',
					'std'         => '',
					'type'        => 'text',
					'section'     => 'general',
					'class'       => ''
				),
				array(
					'id'          => 'featured_category',
					'label'       => 'Featured Category',
					'desc'        => 'Choose the category you want the featured slider to have. The posts under the chosen category will be displayed in the homepage under featured slider. Maximum number of post that can be display is 10 and it is sorted from latest to oldest.',
					'std'         => '',
					'type'        => 'category_select',
					'section'     => 'general',
					'class'       => '',
					'choices'     => array(
						array( 
							'value' => 'yes',
							'label' => 'Yes' 
						)
					)
				),
				array(
					'id'          => 'highlights_category',
					'label'       => 'Highlights Category',
					'desc'        => 'Choose the category you want the highlights section to have. The posts under the chosen category will be displayed in the highlights section carousel. Maximum number of post that can be display is 15 and it is sorted from latest to oldest.',
					'std'         => '',
					'type'        => 'category_select',
					'section'     => 'general',
					'class'       => '',
					'choices'     => array(
						array( 
							'value' => 'yes',
							'label' => 'Yes' 
						)
					)
				),
				array(
					'id'          => 'smooth_scroll_enable',
					'label'       => 'Smooth Scrolling',
					'desc'        => 'Do you want to activate Smooth Scrolling?',
					'type'        => 'checkbox',
					'section'     => 'general',
					'class'       => '',
					'std'		=> true,
					'choices'     => array(
						array( 
							'value' => 'yes',
							'label' => 'Yes' 
						)
					)
				),
				array(
					'id'          => 'copyright_text',
					'label'       => 'Copyright Text',
					'desc'        => 'Copyright notice and other cool stuff.',
					'std'         => 'Copyright &copy; 2013 Klein WordPress Theme (Co. Reg. No. 123456789). All Rights Reserved. Your Company Inc.',
					'type'        => 'textarea',
					'section'     => 'general',
					'class'       => '',
					'choices'     => array(
						array( 
							'value' => 'yes',
							'label' => 'Yes' 
						)
					)
				),
				array(
					'id'          => 'css',
					'label'       => 'CSS',
					'desc'        => 'Custom CSS here, it\'s a good practice that you do your changes here and not directly edit css files inside the theme.<br><br><strong>Caveats:</strong>There is a dynamic.css file in the root of this theme. This file handles the css codes you enter into this textarea. Some server may restrict file writing due to permission issues. Please set the permission of the said file to 0777. If this doesn\'t work, you may try playing with different permission. 0777 permission often works on my end.',
					'std'         => '',
					'type'        => 'css',
					'section'     => 'custom_css',
					'class'       => '',
					'choices'     => array(
						array( 
							'value' => 'yes',
							'label' => 'Yes' 
						)
					)
				)
      
			)
  );
  
  // if plugin gears is installed
  // add the configuration for each module
  
  if( class_exists( 'Gears' ) ){
  
		$klein_options_settings['sections'][] = array(
			'id'          => 'members',
			'title'       => 'Members'
		);
		
		$klein_options_settings['settings'][] = array(
				'id'          => 'is_fb_enabled',
				'label'       => 'Enable Facebook Connect',
				'desc'        => 'Check to enable Facebok Connect/Register. Make sure to enable the registration in general settings.',
				'type'        => 'checkbox',
				'section'     => 'members',
				'choices'     => array(
					array(
						'value' => 'yes',
						'label' => 'Yes' 
					)
				)
		);
		
		$klein_options_settings['settings'][] = array(
				'id'          => 'gears_fb_btn_label',
				'label'       => 'Button Label',
				'desc'        => 'Enter a custom label for your facebook connect button to replace the default text (Connect w/ Facebook)',
				'type'        => 'text',
				'section'     => 'members'
			);
			
		$klein_options_settings['settings'][] = array(
				'id'          => 'application_secret',
				'label'       => 'Application Secret',
				'desc'        => '',
				'type'        => 'text',
				'section'     => 'members'
			);
			
		$klein_options_settings['settings'][] = array(
				'id'          => 'application_id',
				'label'       => 'Application ID',
				'desc'        => 'Enter your Facebook <b>App ID</b> and <b>App SEcret</b> in the following text field. <a href="http://goo.gl/LTtQFK" target="_blank">Click here to locate your App ID and Key.</a>',
				'type'        => 'text',
				'section'     => 'members'
			);
		
		$klein_options_settings['settings'][] = array(
				'id'          => 'application_secret',
				'label'       => 'Application Secret',
				'desc'        => '',
				'type'        => 'text',
				'section'     => 'members'
			);
			
		$klein_options_settings['settings'][] = array(
				'id'          => 'registrant_setting',
				'label'       => 'Registrant Settings',
				'desc'        => '',
				'type'        => 'radio',
				'section'     => 'members',
				'std'		  => 'unique',
				'choices'     => array(
					array(
						'value' => 'unique',
						'label' => '(Recommended) Apply unique usernames for future registrants. This will ensure that every user who register via facebook in your website will receive it\'s own unique username. If the username already exists in the database then it will automatically logged that user. Useful for websites that has a lot of users already, this is to prevent username collision with your old username\'s record.'
					),
					array(
						'value' => 'not_unique',
						'label' => 'Use user\'s FB account as the username by default for future registrants. If the username already exists in the database then it will automatically logged that user.'
					)
				)
		);	
	}
	
 // buddypress options
 if( class_exists( 'BuddyPress' ) )
 {
	
	$klein_options_settings['settings'][] = array(
		'id'          => 'bp_layout',
		'label'       => 'BuddyPress Default',
		'desc'        => 'Default layout for BuddyPress pages such as member\'s profile page, groups, etc.',
		'std'         => '',
		'type'        => 'select',
		'section'     => 'layouts',
		'class'       => '',
		'choices'     => array(
				array( 'value' => 'right-sidebar', 'label' => 'Sidebar Right' ),
				array( 'value' => 'left-sidebar', 'label' => 'Sidebar Left' ),
				array( 'value' => 'full-width', 'label' => 'Full Width' ),
			)
		);
}

// Woocommerce options
if( class_exists( 'Woocommerce' ) )
{

	$klein_options_settings['settings'][] = array(
		'id'          => 'wc_layout',
		'label'       => 'WooCommerce Product Index',
		'desc'        => 'Default Layout for WooCommerce Index.',
		'std'         => '',
		'type'        => 'select',
		'section'     => 'layouts',
		'class'       => '',
		'choices'     => array(
				array( 'value' => 'content-sidebar', 'label' => 'Sidebar Right' ),
				array( 'value' => 'sidebar-content', 'label' => 'Sidebar Left' ),
				array( 'value' => 'sidebar-content-sidebar', 'label' => 'Sidebar Content Sidebar' ),
				array( 'value' => 'content-sidebar-sidebar', 'label' => 'Content Dual Sidebar' ),
				array( 'value' => 'sidebar-sidebar-content', 'label' => 'Dual Sidebar Content' ),
				array( 'value' => 'full-content', 'label' => 'Full Width' )
			)
		);
}

// bbPress options
if( class_exists( 'bbPress' ) )
{

	$klein_options_settings['settings'][] = array(
		'id'          => 'bbp_layout',
		'label'       => 'bbPress Forum Index',
		'desc'        => 'Default Layout for bbPress Forum Index.',
		'std'         => '',
		'type'        => 'select',
		'section'     => 'layouts',
		'class'       => '',
		'choices'     => array(
				array( 'value' => 'content-sidebar', 'label' => 'Sidebar Right' ),
				array( 'value' => 'sidebar-content', 'label' => 'Sidebar Left' ),
				array( 'value' => 'sidebar-content-sidebar', 'label' => 'Sidebar Content Sidebar' ),
				array( 'value' => 'content-sidebar-sidebar', 'label' => 'Content Dual Sidebar' ),
				array( 'value' => 'sidebar-sidebar-content', 'label' => 'Dual Sidebar Content' ),
				array( 'value' => 'full-content', 'label' => 'Full Width' )
			)
		);
}
  // if settings are not the same as the record update the DB
  if ( $saved_settings !== $klein_options_settings ) {
		update_option( 'option_tree_settings', $klein_options_settings ); 
  }
}
?>