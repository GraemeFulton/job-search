<?php
/**
 * Sidebars Action
 *
 * @package Klein
 * @since 1.0
 */
?>
<?php

DEFINE( 'KLEIN_SIDEBAR_UNIQUE_ID', 'klein_register_sidebar_settings_menu' );

add_action( 'wp_ajax_klein_sidebar_add', 'klein_sidebar_add' );
add_action( 'wp_ajax_klein_sidebar_delete', 'klein_sidebar_delete' );
add_action( 'wp_ajax_klein_sidebar_update', 'klein_sidebar_update' );

add_action('admin_menu', 'klein_register_sidebar_settings');

/**
 * Register Unlimited Sidebar Option
 */
function klein_register_sidebar_settings() {
	// add option page under appearance
	
	add_theme_page( 
			__( 'Sidebars','klein'),
			__('Sidebars','klein'), 
				'read', 
				KLEIN_SIDEBAR_UNIQUE_ID, 
				'klein_register_sidebar_settings_page'
		);
}

function klein_register_sidebar_settings_page(){
	locate_template(
		array(
			'klein/sidebars.php'
		),
		true,
		true
	);
}


/**
 *
 */
function klein_sidebar_update(){
	
	// check if user has the right to manage options
	if( current_user_can( 'manage_options' ) ){
		
		$sidebar_id = esc_attr( $_POST['sidebar_id'] );
		
		if( empty( $sidebar_id ) ) die();
		
		$option_key = KLEIN_SIDEBAR_KEY;
		$existing_sidebar = unserialize( get_option( $option_key ) );
		// remove the sidebar from the serialized array
		$existing_sidebar[ $sidebar_id ]['klein-sidebar-name'] = esc_attr( $_POST['klein-sidebar-name'] );
		$existing_sidebar[ $sidebar_id ]['klein-sidebar-description'] = esc_attr( $_POST['klein-sidebar-description'] );
	
		update_option( KLEIN_SIDEBAR_KEY, serialize( $existing_sidebar ) );
		wp_safe_redirect( admin_url( 'themes.php?page='.KLEIN_SIDEBAR_UNIQUE_ID.'&action=edit&sidebar=' . $sidebar_id ) );
	}
	
	die();
} 
/**
 * Removes a sidebar
 */
function klein_sidebar_delete(){
	
	// check if user has the right to manage options
	if( current_user_can( 'manage_options' ) ){
		
		$sidebar_id = esc_attr( $_GET['sidebar'] );
		
		if( empty( $sidebar_id ) ) die();
		
		$option_key = KLEIN_SIDEBAR_KEY;
		$existing_sidebar = unserialize( get_option( $option_key ) );
		// remove the sidebar from the serialized array
		unset( $existing_sidebar[ $sidebar_id ] );
		update_option( KLEIN_SIDEBAR_KEY, serialize( $existing_sidebar ) );
		wp_safe_redirect( admin_url( 'themes.php?page='.KLEIN_SIDEBAR_UNIQUE_ID.'' ) );
	}
	
	die();
	
}
/**
 * adds new custom sidebar
 */
function klein_sidebar_add(){

	// check if current user has the ability
	// to manage the option, most probably the 
	// website administrator
	// @klein version 1
	
	$option_key = KLEIN_SIDEBAR_KEY; // to make sure the option is unique to avoid 
												// any pitfalls that may happen in the future
	
	
	if( current_user_can('manage_options') ){
		
		$current_sidebars = unserialize( get_option( $option_key ) );	
		
		// just insert the serialized data if no sidebars
		// are added yet
		if( empty( $_POST['klein-sidebar-name'] ) ){
			wp_safe_redirect( admin_url( 'themes.php?page='.KLEIN_SIDEBAR_UNIQUE_ID.'&sidebar-error=true' ) );
			die();
		}
		
		// allow only alpha numeric
		if( preg_match('/[^a-z_\-0-9\s]/i', $_POST['klein-sidebar-name'] ))
		{
			wp_safe_redirect( admin_url( 'themes.php?page='.KLEIN_SIDEBAR_UNIQUE_ID.'&sidebar-error=true&type=c' ) );
			die();
		}
		
		$sidebar_name = esc_attr( stripslashes( $_POST['klein-sidebar-name'] ) );
		$sidebar_id = sanitize_title( $_POST['klein-sidebar-name'] );
		$value = array(
				$sidebar_id => array(
						'klein-sidebar-name' => $sidebar_name,
						'klein-sidebar-id' => $sidebar_id,
						'klein-sidebar-description' => esc_attr( $_POST['klein-sidebar-description'] )
					)
				);
			
		// check if there are no sidebars	
		if( empty( $current_sidebars ) ){
			// update the option
			update_option(  $option_key, serialize( $value ) );
			wp_safe_redirect( admin_url( 'themes.php?page='.KLEIN_SIDEBAR_UNIQUE_ID.'&sidebar-success=true' ) );
		}else{
			// if option is already set, it means there are existing sidebars
			// then, get all the sidebars first
			$existing_sidebars = unserialize( get_option( $option_key ) );
			
			// check if the same sidebar already exists
			if( array_key_exists( $sidebar_id , $existing_sidebars ) ){
				wp_safe_redirect( admin_url( 'themes.php?page='.KLEIN_SIDEBAR_UNIQUE_ID.'&sidebar-error=true&type=u' ) );
			}else{
				// add new sidebar :)
				$existing_sidebars[$sidebar_id] = array(
						'klein-sidebar-name' => $sidebar_name,
						'klein-sidebar-id' => $sidebar_id,
						'klein-sidebar-description' => esc_attr( $_POST['klein-sidebar-description'] )
					);				
				// update the option after appending our new 
				// sidebar to existing one				
				update_option(  $option_key, serialize( $existing_sidebars ) );
				wp_safe_redirect( admin_url( 'themes.php?page='.KLEIN_SIDEBAR_UNIQUE_ID.'&sidebar-success=true' ) );
			}
			
		}
	}
	die();
}
?>