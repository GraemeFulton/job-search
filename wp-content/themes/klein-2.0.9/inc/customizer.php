<?php
/**
 * Theme Customization File
 *
 * @package klein
 */

 
function tcx_register_theme_customizer( $wp_customize ) {

		// Theme settings color option
		$wp_customize->add_section(	'klein_color_options',
			array(
				'title'     => 'Colors',
				'priority'  => 200
			)
		);
		
		// Navigation background register setting
			$wp_customize->add_setting( 'klein_navigation_background',
				array(
					'default'    =>  '#222',
					'transport'  =>  'postMessage'
				)
			);
		
		// Navigation background settings control
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'navigation_background',
					array(
						'label'      => __( 'Navigation Background', 'klein' ),
						'section'    => 'klein_color_options',
						'settings'   => 'klein_navigation_background'
					)
				)
			);
		
		// Navigation foreground register settings
			$klein_navigation_color_settings = array(
				'default' => '#fff',
				'transport' => 'postMessage'
			);
			$wp_customize->add_setting( 'klein_navigation_color', $klein_navigation_color_settings );
		
		// Navigation foreground settings color
			$klein_navigation_color_control = array(
				'label'      => __( 'Navigation Link', 'klein' ),
				'section'    => 'klein_color_options',
				'settings'   => 'klein_navigation_color'
			);
			
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'navigation_link',
					$klein_navigation_color_control
				)
			);
			
		// Navigation hover color
			$klein_navigation_hover_settings = array(
				'default' => '#444',
				'transport' => 'refresh'
			);
			$wp_customize->add_setting( 'klein_navigation_hover', $klein_navigation_hover_settings );
			// Controls
				$klein_navigation_hover_controls = array(
					'label' => __( 'Navigation Hover','klein' ),
					'section' => 'klein_color_options',
					'settings' => 'klein_navigation_hover'
				);
				$wp_customize->add_control(
					new WP_Customize_Color_Control(
							$wp_customize,
							'navigation_hover',
							$klein_navigation_hover_controls
						)
				);
				
		// Footer background color
			$klein_footer_background_settings = array(
				'default' => '',
				'transport' => 'postMessage'
			);
			
			$wp_customize->add_setting( 'klein_footer_background', $klein_footer_background_settings );
				// Controls
					$klein_footer_background_controls = array(
						'label' => __( 'Footer Background', 'klein' ),
						'section' => 'klein_color_options',
						'settings' => 'klein_footer_background'
					);
					$wp_customize->add_control(
						new WP_Customize_Color_Control(
							$wp_customize,
							'footer_background',
							$klein_footer_background_controls
						)
					);
					
		// Footer color
			$klein_footer_color_settings = array(
				'default' => '',
				'transport' => 'postMessage'
			);
			
			$wp_customize->add_setting( 'klein_footer_color', $klein_footer_color_settings );
				// Controls
					$klein_footer_color_controls = array(
						'label' => __( 'Footer Color', 'klein' ),
						'section' => 'klein_color_options',
						'settings' => 'klein_footer_color'
					);
					$wp_customize->add_control(
						new WP_Customize_Color_Control(
							$wp_customize,
							'klein_footer_color',
							$klein_footer_color_controls
						)
					);			
					
}

add_action( 'customize_register', 'tcx_register_theme_customizer' );

function tcx_customizer_css() {
    ?>
    <style type="text/css">
	
        #header,.desktop-menu ul.sub-menu li a { background: <?php echo get_theme_mod( 'klein_navigation_background' ); ?>; }
		#footer{ background: <?php echo get_theme_mod( 'klein_footer_background' ); ?>; }
		#footer{ color: <?php echo get_theme_mod( 'klein_footer_color' ); ?>; }
		
		.desktop-menu ul.sub-menu li:first-child:before, 
		.desktop-menu ul.children li:first-child:before{
			border-bottom-color: <?php echo get_theme_mod( 'klein_navigation_background' ); ?> 
		}
		
		.desktop-menu ul.sub-menu > li > ul.sub-menu > li:first-child:before, .desktop-menu ul.children > li > ul.children > li:first-child:before{
			border-right-color: <?php echo get_theme_mod( 'klein_navigation_background' ); ?> 
		}
		
		.desktop-menu ul li a{ color: <?php echo get_theme_mod('klein_navigation_color'); ?> }
		
		.desktop-menu ul.sub-menu li a:hover, .desktop-menu ul.children li a:hover{ 
			background: <?php echo get_theme_mod( 'klein_navigation_hover'); ?>
		}
		
		
    </style>
    <?php
}
add_action( 'wp_head', 'tcx_customizer_css' );

function klein_customizer_live_preview() {
	wp_enqueue_script(
		'klein-theme-customizer',
		get_template_directory_uri() . '/js/customizer.js?__xcache=' . time(),
		array( 'jquery', 'customize-preview' ),
		'0.3.0',
		true
	);
}
add_action( 'customize_preview_init', 'klein_customizer_live_preview' );
?>
