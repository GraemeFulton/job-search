<?php

/**
 * BuddyPress - Members Loop
 *
 * Querystring is set via AJAX in _inc/ajax.php - bp_legacy_theme_object_filter()
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<?php do_action( 'bp_before_members_loop' ); ?>

<?php if ( bp_has_members( bp_ajax_querystring( 'members' ) ) ) : ?>

	<div id="pag-top" class="pagination ">

		<div class="pag-count" id="member-dir-count-top">

			<?php bp_members_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="member-dir-pag-top">

			<?php bp_members_pagination_links(); ?>

		</div>

	</div>

	<?php do_action( 'bp_before_directory_members_list' ); ?>

	<ul id="members-list" class="item-list row" role="main">
	<?php $count = 0; ?>
	<?php while ( bp_members() ) : bp_the_member(); ?>
	<?php $count++ ;?>
		<li class="bp-klein-members-item col-md-6 col-sm-6 break-row-bottom">
		
			<div class="row">
				<div class="col-md-4 col-sm-4 item-avatar">
					<a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar( $args = array(  'type' => 'full' ) ); ?></a>
				</div>
	
				<div class="col-sm-8 col-md-8 item">
					<div class="item-title">
					
						<?php $user_displayed_name_max = 18; ?>
						<?php $user_displayed_name = bp_get_member_name(); ?>
						<?php $user_displayed_name_count = strlen( $user_displayed_name ); ?>
						<?php if( $user_displayed_name_count >=  $user_displayed_name_max ){ ?>
							<h5><a class="tip" data-original-title="<?php echo $user_displayed_name; ?>" href="<?php bp_member_permalink(); ?>"><?php echo substr( $user_displayed_name, 0, $user_displayed_name_max ); ?>&hellip;</a></h5>
						<?php }else{ ?>
							<h5><a href="<?php bp_member_permalink(); ?>"><?php echo $user_displayed_name; ?></a></h5>
						<?php } ?>
						
					</div>
	
					<div class="item-meta"><span class="activity"><?php bp_member_last_active(); ?></span></div>
	
					<?php do_action( 'bp_directory_members_item' ); ?>
	
					<?php
					/***
					* If you want to show specific profile fields here you can,
					* but it'll add an extra query for each member in the loop
					* (only one regardless of the number of fields you show):
					*
					* bp_member_profile_data( 'field=the field name' );
					*/
					?>
				</div>
	
				
			</div>

			<div class="clear"></div>
		</li>

	<?php endwhile; ?>

	</ul>
	<div class="clearfix"></div>
	<?php do_action( 'bp_after_directory_members_list' ); ?>

	<?php bp_member_hidden_fields(); ?>

	<div id="pag-bottom" class="pagination">

		<div class="pag-count" id="member-dir-count-bottom">

			<?php bp_members_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="member-dir-pag-bottom">

			<?php bp_members_pagination_links(); ?>

		</div>

	</div>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( "Sorry, no members were found.", 'buddypress' ); ?></p>
	</div>

<?php endif; ?>

<?php do_action( 'bp_after_members_loop' ); ?>
