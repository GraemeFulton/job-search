<?php
/**
 * Sidebars
 *
 * @package Klein
 * @since 1.0
 */
?>
<div class="wrap">
	<div class="con-container">
		<?php screen_icon(); echo "<h2>". __( 'Sidebars', 'klein' ) . "</h2>"; ?>
		<p>
			<?php _e( 'You may add number of sidebars here. After adding a', 'klein' ); ?><br /> 
			<?php _e( 'sidebar, you may select it in the edit post or page section.', 'klein' ); ?>
		</p>
		<br />
		<?php
			if( isset( $_GET['sidebar-error'] ) ){
				if( $_GET['type'] == 'u' ){
					?>
					<div id="message" class="error below-h2">
						<p><strong><?php _e('There was an error while adding your sidebar. Sidebar already exists.','klein'); ?></strong></p>
					</div>
					<?php
				}elseif( $_GET['type'] == 'c' ){
					?>
					<div id="message" class="error below-h2">
						<p><strong><?php _e('Invalid sidebar name. Only alphanumeric characters are allowed.','klein'); ?></strong></p>
					</div>
					<?php
				}else{
					?>
					<div id="message" class="error below-h2">
						<p><strong><?php _e('There was an error while adding sidebar. Sidebar name is required.','klein'); ?></strong></p>
					</div>
					<?php
				}
			}
			if( isset( $_GET['sidebar-success'] ) ){
				?>
				<div id="message" class="updated below-h2">
					<p><strong><?php _e('Sidebar has been added.','klein'); ?></strong></p>
				</div>
				<?php
			}
			?>
		<div id="col-right">
			<div class="col-wrap">
				<?php $sidebars = unserialize( get_option( KLEIN_SIDEBAR_KEY ) ); ?>
				<?php if( !empty( $sidebars ) ){ ?>
					<table class="widefat">
						<thead>
							<tr>
								<th><?php _e( 'Name', 'klein' ); ?></th>
								<th><?php _e( 'Description', 'klein' ); ?></th>       
							</tr>
						</thead>
						<tbody>
						<?php $row = 0; ?>
							<?php foreach( $sidebars as $sidebar ){ ?>
								<?php if( !empty( $sidebar['klein-sidebar-name'] ) ){ ?>
									<?php $class = ( $row % 2 == 0 ) ? 'alternate': 'alternate-non'; ?>
									<?php $row++ ;?>
									<tr class="<?php echo $class;?>">
										<td>
											<a href="<?php echo admin_url('themes.php?page=klein_register_sidebar_settings_menu&action=edit&sidebar=' . $sidebar['klein-sidebar-id'] ); ?>">
											<strong>
												<?php echo $sidebar['klein-sidebar-name']; ?>
											</strong>
											</a>
											<br />
											<div class="row-actions">
												<span class="edit"><a class="edit-tag" href="<?php echo admin_url('themes.php?page=klein_register_sidebar_settings_menu&action=edit&sidebar=' . $sidebar['klein-sidebar-id'] ); ?>">Edit</a></span> | 
												<span class="delete"><a onclick="return confirm('Are you sure you want to delete this sidebar?');" class="delete-tag" href="<?php echo admin_url('admin-ajax.php?action=klein_sidebar_delete&sidebar='.$sidebar['klein-sidebar-id'].''); ?>">Delete</a></span>
											</div>
										</td>
										<td><?php echo $sidebar['klein-sidebar-description']; ?></td>
									</tr>
								<?php } ?>
							<?php } // endforeach ?>
						</tbody>	
						<tfoot>
							<tr>
								<th><?php _e( 'Name', 'klein' ); ?></th>
								<th><?php _e( 'Description', 'klein' ); ?></th>
							</tr>
						</tfoot>
					</table>
				<?php }else{ ?>
					<p class="howto"><?php _e( 'No Custom Sidebars Yet.', 'klein' ); ?></p>
				<?php } ?>
			</div>
		</div>
		<div id="col-left">
			<div class="col-wrap">
				<h3><?php _e( 'Add New Sidebar', 'klein' ); ?></h3>
				<div class="form-wrap">
					<?php 
						$is_edit_sidebar = isset( $_GET['action'] ) ? true: false;
					?>
					
					<form method="post" action="admin-ajax.php">
							<?php 
							
							if( $is_edit_sidebar ){
								
								$edit__sidebar = unserialize( get_option( KLEIN_SIDEBAR_KEY ) );
								$edit__sidebar = $edit__sidebar[$_GET['sidebar']];
							}
							if( empty( $edit__sidebar ) ){
								$edit__sidebar = array();
							}
							
							$edit__sidebar_name = !empty( $edit__sidebar['klein-sidebar-name'] ) ? $edit__sidebar['klein-sidebar-name'] : '';
							$edit__sidebar_description = !empty( $edit__sidebar['klein-sidebar-description'] ) ? $edit__sidebar['klein-sidebar-name'] : '';
							$edit__sidebar_id = !empty( $edit__sidebar['klein-sidebar-id'] ) ? $edit__sidebar['klein-sidebar-id']: '';
							?>
							
							<div class="form-field">
								<label for="klein-sidebar-name"><?php _e( 'Name: *', 'klein' ); ?></label>
									<input type="text" id="klein-sidebar-name" name="klein-sidebar-name" value="<?php echo $edit__sidebar_name; ?>" />
									<p class="description"><?php _e( 'Sidebar name (must be unique)', 'klein' ); ?></p>
							</div>
							<div class="form-field">
								<label for="klein-sidebar-description"><?php _e( 'Description: (optional)', 'klein' ); ?></label>
									<textarea style="width:300px;" id="klein-sidebar-description" name="klein-sidebar-description" rows="4" cols="50"><?php echo $edit__sidebar_description; ?></textarea>
									<p class="description"><?php _e( 'Text description of what/where the sidebar is. Shown on widget management screen.', 'klein' ); ?></p>
							</div>
							
							<p class="submit">
								<?php if( $is_edit_sidebar && !empty( $edit__sidebar ) ){ ?>
									<input type="hidden" name="action" value="klein_sidebar_update"/>
									<input type="hidden" name="sidebar_id" value="<?php echo $edit__sidebar_id; ?>" />
									<input type="submit" class="button button-primary" value="<?php _e( 'Update Sidebar', 'klein' ); ?>">
								<?php } else { ?>
									<input type="hidden" name="action" value="klein_sidebar_add"/>
									<input type="submit" class="button button-primary" value="<?php _e( 'Add Sidebar', 'klein' ); ?>">
								<?php } ?>
							</p>
						
					</form>
				</div>
			</div>
		</div>
	</div><!-- .con-container -->
</div><!-- wrap -->