<?php

/**
 * BuddyPress - Users Header
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<?php do_action( 'bp_before_member_header' ); ?>
<div class="clearfix"></div>
<div class="row">
	<div class="col-md-4 col-sm-4">
		<div id="item-header-avatar">
			<a href="<?php bp_displayed_user_link(); ?>">
				<?php bp_displayed_user_avatar( 'type=full' ); ?>
			</a>
		</div><!-- #item-header-avatar -->
	</div>
	<div class="col-md-8 col-sm-4">
		<div id="item-header-content">
			<?php if ( bp_is_active( 'activity' ) && bp_activity_do_mentions() ) : ?>
				<h5 class="user-nicename">@<?php bp_displayed_user_username(); ?></h5>
			<?php endif; ?>
			<div>
				<span class="activity"><?php bp_last_activity( bp_displayed_user_id() ); ?></span>
			</div>
			<?php do_action( 'bp_before_member_header_meta' ); ?>
	
			<div id="item-meta">
	
				<?php if ( bp_is_active( 'activity' ) ) : ?>
	
					<div id="latest-update">
	
						<?php bp_activity_latest_update( bp_displayed_user_id() ); ?>
	
					</div>
	
				<?php endif; ?>
	
				<div id="item-buttons">
					
					<?php do_action( 'bp_member_header_actions' ); ?>
	
				</div><!-- #item-buttons -->
	
				<?php
				/***
				* If you'd like to show specific profile fields here use:
				* bp_member_profile_data( 'field=About Me' ); -- Pass the name of the field
				*/
				do_action( 'bp_profile_header_meta' );
	
				?>
	
			</div><!-- #item-meta -->
	
		</div><!-- #item-header-content -->
	</div>
</div>

<?php do_action( 'bp_after_member_header' ); ?>

<?php do_action( 'template_notices' ); ?>