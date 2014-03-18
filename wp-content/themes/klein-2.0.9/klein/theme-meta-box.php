<?php
/**
 * Theme Meta Box
 * 
 * @package Klein
 * @since 1.0
 */
?>
<?php
/* 
 hook our post meta boxes in WordPress Editor
*/
add_action( 'load-post.php', 'klein_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'klein_post_meta_boxes_setup' );

/* Save post meta on the 'save_post' hook. */
add_action( 'save_post', 'klein_save_post_class_meta', 10, 2 );
/* Meta box setup function. */
/* Save the meta box's post metadata. */
function klein_save_post_class_meta( $post_id, $post ) {

	/* Verify the nonce before proceeding. */
	if ( !isset( $_POST['klein_appearance_nonce'] ) || !wp_verify_nonce( $_POST['klein_appearance_nonce'], basename( __FILE__ ) ) )
		return $post_id;

	/* Get the post type object. */
	$post_type = get_post_type_object( $post->post_type );

	/* Check if the current user has permission to edit the post. */
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;

	$klein_metas = array(
		'klein_sidebar' => isset( $_POST['klein_sidebar'] ) ? sanitize_html_class( $_POST['klein_sidebar'] ) : '',
		'klein_sidebar_left' => isset( $_POST['klein_sidebar_left'] ) ? sanitize_html_class( $_POST['klein_sidebar_left'] ) : '',
		'klein_page_layout' => isset( $_POST['klein_page_layout'] ) ? sanitize_html_class( $_POST['klein_page_layout'] ) : '',
		'klein_page_title_hide' => isset( $_POST['klein_page_title_hide'] ) ? sanitize_html_class( $_POST['klein_page_title_hide'] ) : ''
	);
	
	foreach( $klein_metas as $meta_key => $new_meta_value ){
	
		/* Get the meta value of the custom field key. */
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		
		/* If a new meta value was added and there was no previous value, add it. */
		if ( $new_meta_value && '' == $meta_value )
			add_post_meta( $post_id, $meta_key, $new_meta_value, true );

		/* If the new meta value does not match the old value, update it. */
		elseif ( $new_meta_value && $new_meta_value != $meta_value )
			update_post_meta( $post_id, $meta_key, $new_meta_value );

		/* If there is no new meta value but an old value exists, delete it. */
		elseif ( '' == $new_meta_value && $meta_value )
			delete_post_meta( $post_id, $meta_key, $meta_value );
	}
	
}
/* Meta box setup function. */
function klein_post_meta_boxes_setup() {

	/* Add meta boxes on the 'add_meta_boxes' hook. */
	add_action( 'add_meta_boxes', 'klein_add_post_meta_boxes' );
}

/* Create one or more meta boxes 
   to be displayed on the 
   post editor screen. */
   
function klein_add_post_meta_boxes() {
	
	global $bp, $post;
	
	if( !empty( $bp  ) ){
	
		$klein_metabox_disallow_pages = $bp->pages;
		$klein_disable_metabox_to_bp_pages = array();
		
		foreach( (array)$klein_metabox_disallow_pages as $klein_pages ){
			$klein_disable_metabox_to_bp_pages[] = $klein_pages->slug;
		}
		
		if( in_array( $post->post_name, $klein_disable_metabox_to_bp_pages ) ){
			// if buddypress page return
			return;
		}
	}
	// post
	add_meta_box(
		'klein-appearance-meta-box',
		esc_html__( 'Appearance', 'example' ),
		'klein_appearance_meta_box',
		'post',
		'side',
		'default'
	);
	
	// page
	add_meta_box(
		'klein-appearance-meta-box',
		esc_html__( 'Appearance', 'example' ),
		'klein_appearance_meta_box',
		'page',
		'side',
		'default'
	);
	
	// check if bbPress is active
	// enable sidebar support
		if( function_exists('bbpress' ) ){
			// forums
			add_meta_box(
				'klein-appearance-meta-box',
				esc_html__( 'Appearance', 'example' ),
				'klein_appearance_meta_box',
				'forum',
				'side',
				'default'
			);
			
			// topics
			add_meta_box(
				'klein-appearance-meta-box',
				esc_html__( 'Appearance', 'example' ),
				'klein_appearance_meta_box',
				'topic',
				'side',
				'default'
			);
		}
	
	// check if wooCommerce is active
	// add sidebar support for WooCommerce products
	if( class_exists( 'Woocommerce' ) ){
		if( function_exists('bbpress' ) ){
			// product
			add_meta_box(
				'klein-appearance-meta-box',
				esc_html__( 'Appearance', 'example' ),
				'klein_appearance_meta_box',
				'product',
				'side',
				'default'
			);
			
		}
	}
	// add support for events manager
	if( class_exists( 'EM_Events' ) ){
		if( function_exists('bbpress' ) ){
			// product
			add_meta_box(
				'klein-appearance-meta-box',
				esc_html__( 'Appearance', 'example' ),
				'klein_appearance_meta_box',
				'event',
				'side',
				'default'
			);
			
		}
	}
}

/* Display the post meta box. */
function klein_appearance_meta_box( $object, $box ) { ?>

	<?php global $wp_registered_sidebars, $post; ?>
	
	<?php $registered_sidebars = $wp_registered_sidebars; ?>
	
	<?php wp_nonce_field( basename( __FILE__ ), 'klein_appearance_nonce' ); ?>
	
		<!-- Sidebar Left -->
		<?php if( !empty( $registered_sidebars ) ){ ?>
		
			<?php $default_sidebar = get_post_meta( $post->ID, 'klein_sidebar_left', true ); ?>
			
			<?php // prepare default sidebars for each post types ?>
			
			<?php $post_type_default_sidebar = array(
				'post' => array(
					'sidebar-left' => 'sidebar-2',
					'sidebar-right' => 'sidebar-1'
				),
				'page' => array(
					'sidebar-left' => 'sidebar-2',
					'sidebar-right' => 'sidebar-1'
				),
				'product' => array(
					'sidebar-left' => 'wc-klein-sidebar-left',
					'sidebar-right' => 'wc-klein-sidebar-right'
				),
				'forum' => array(
					'sidebar-left' => 'bbp-klein-sidebar-left',
					'sidebar-right' => 'bbp-klein-sidebar'
				),
				'topic' => array(
					'sidebar-left' => 'bbp-klein-sidebar-left',
					'sidebar-right' => 'bbp-klein-sidebar'
				),
			); ?>
			
			<?php
				// if post meta sidebar is not define,
				// use the default sidebar for each post type
				if( empty( $default_sidebar ) ){
					$default_sidebar = $post_type_default_sidebar[$post->post_type]['sidebar-left'];
				}
			?>
			<p class="howto">
				<?php _e( 'Left Sidebar', 'klein' ); ?>
			</p>
			
			<p>
				<select name="klein_sidebar_left" id="klein_sidebar_left">
					<?php foreach( (array) $registered_sidebars as $sidebar ){ ?>
						<?php $selected = $sidebar['id'] == $default_sidebar ? 'selected' : ''; ?>
						<option <?php echo $selected; ?> value="<?php echo $sidebar['id']; ?>"><?php echo $sidebar['name']; ?></option>
					<?php } ?>
				</select>
			</p>
			
		<?php }else{?>
			<p class="howto">
				<?php _e( 'No Sidebars Available', 'klein' ); ?>
			</p>
		<?php } ?>
		
		<?php // reset sidebar
			unset( $registered_sidebars );
		?>
		<!-- Sidebar Right -->
		
		
		<?php $registered_sidebars = $wp_registered_sidebars; ?>
		
		<?php if( !empty( $registered_sidebars ) ){ ?>
			<?php $default_sidebar = get_post_meta( $post->ID, 'klein_sidebar', true ); ?>
			<p class="howto">
				<?php _e( 'Right Sidebar', 'klein' ); ?>
			</p>
			<?php
				// if post meta sidebar is not define,
				// use the default sidebar for each post
				if( empty( $default_sidebar ) ){
					$default_sidebar = $post_type_default_sidebar[$post->post_type]['sidebar-right'];
				}
			?>
			
			<p>
				<select name="klein_sidebar" id="klein_sidebar">
					<?php foreach( (array) $registered_sidebars as $sidebar ){ ?>
						<?php $selected = $sidebar['id'] == $default_sidebar ? 'selected' : ''; ?>
						<option <?php echo $selected; ?> value="<?php echo $sidebar['id']; ?>"><?php echo $sidebar['name']; ?></option>
					<?php } ?>
				</select>
			</p>
			
		<?php }else{?>
			<p class="howto">
				<?php _e( 'No Sidebars Available', 'klein' ); ?>
			</p>
		<?php } ?>
		
		<p class="howto">
			<?php _e( 'Page Layout', 'klein' ); ?>
		</p>
		<p>
			<?php $page_layout = get_post_meta( $post->ID, 'klein_page_layout', true ); ?>
			<?php if( empty( $page_layout ) ){ ?>
				<?php // if page layout is empty, use the default settings; ?>
				<?php $page_layout = 'layout_post'; ?>
			<?php } ?>
			
			<?php $page_layouts_option = array(
				'content-sidebar' => __( 'Content / Sidebar Right', 'klein' ),
				'sidebar-content' => __( 'Sidebar Left / Content', 'klein' ),
				'sidebar-content-sidebar' => __( 'Sidebar Left / Content / Sidebar Right', 'klein' ),
				'content-sidebar-sidebar' => __( 'Content / Sidebar Left / Sidebar Right', 'klein' ),
				'sidebar-sidebar-content' => __( 'Sidebar Left / Sidebar Right / Content', 'klein' ),
				'full-content' => __('Full Content / No Sidebar','klein')
			); ?>
			<select name="klein_page_layout" id="klein_page_layout">
				<?php foreach( (array) $page_layouts_option as $key => $page_layout_option ){ ?>
					<?php $selected = ( $page_layout == $key ) ? 'selected' : ''; ?>
					<option <?php echo $selected; ?> value="<?php echo $key;?>"><?php echo $page_layout_option; ?></option>
				<?php } ?>
			</select>
		</p>
		
<?php }

?>