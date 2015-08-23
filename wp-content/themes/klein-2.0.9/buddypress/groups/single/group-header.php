<?php

do_action( 'bp_before_group_header' );

?>
<div class="break-row-bottom">
	<div class="row">
		<div class="col-md-4 col-sm-4" id="item-header-avatar">
			<div class="bp-klein-group-avatar">
				<a href="<?php bp_group_permalink(); ?>" title="<?php bp_group_name(); ?>">
					<?php 
						$bp_group_avatar_args = array(
							'type' => 'full'
						); 
					?>
					<?php bp_group_avatar( $bp_group_avatar_args ); ?>
				</a>
			</div>
		</div><!-- #item-header-avatar -->

		<div class="col-md-8 col-sm-8" id="item-header-content">

			<ul class="no-list nav nav-tabs" id="group-tab">
				<li class="active"><a data-toggle="tab" href="#about"><?php _e('About','klein');?></a></li>
				<li><a data-toggle="tab" href="#managers"><?php _e('Group Managers','klein');?></a></li>
			</ul>
			 
			<div class="tab-content">
			
			  <div class="tab-pane active" id="about">
			  <?php do_action( 'bp_before_group_header_meta' ); ?>
					<div id="item-meta">
						<div class="break-row-top clearfix">
								<?php bp_group_description(); ?>
						</div>
						<div class="clearfix small">
							<span class=""><?php bp_group_type(); ?></span>
							<span class=""><?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ); ?></span>
						</div>
						<div id="item-buttons">
							<?php do_action( 'bp_group_header_actions' ); ?>
						</div><!-- #item-buttons -->
				
						<?php do_action( 'bp_group_header_meta' ); ?>
					</div>
			  </div>
			  
			  <div class="tab-pane" id="managers">
				<div class="clearfix" id="item-actions">
					<?php if ( bp_group_is_visible() ) : ?>
					<div class="break-row-top clearfix">
						<?php _e( 'Group Admins', 'buddypress' ); ?>
						<?php bp_group_list_admins(); ?>
					</div>
					<div class="break-row-top  clearfix"></div>
					<?php do_action( 'bp_after_group_menu_admins' );
					if ( bp_group_has_moderators() ) :
						do_action( 'bp_before_group_menu_mods' ); ?>
						<div class="clearfix">
							<?php _e( 'Group Mods' , 'buddypress' ); ?>
							<?php bp_group_list_mods(); ?>
						</div>
						<?php 
						do_action( 'bp_after_group_menu_mods' );
					endif;
				endif; ?>
				</div><!-- #item-actions -->
			  </div>
			</div><!--.tab-content -->
		</div><!-- #item-header-content -->
	</div>
</div>	
<?php
do_action( 'bp_after_group_header' );
do_action( 'template_notices' );
?>