<?php

/**
 * BuddyPress - Users Home
 *
 * @package BuddyPress
 * @subpackage bp-default
 */

include (TEMPLATEPATH . '/templates-headers/header-profile.php');
$title =ucwords(str_replace('-', ' ', get_query_var('pagename')));

?>
<div class='single-container'>
	<div id="content" class='single_content single_content_profile mobile-menu'>
               <div class="toggle-title"><i class="fa fa-chevron-circle-up fa-2x"></i> &nbsp;<?php echo $title; ?> </div>

		<div class="padder">

			<?php do_action( 'bp_before_member_home_content' ); ?>

			<div id="item-header" role="complementary">

				<?php locate_template( array( 'members/single/member-header.php' ), true ); ?>

			</div><!-- #item-header -->
                        
			<div id="item-nav" class="mobile-menu-side">
                    
                            <?php do_action( 'bp_before_single_members_nav' ); ?>

				<div class="item-list-tabs no-ajax" id="object-nav" role="navigation">
					<ul>

						<?php bp_get_displayed_user_nav(); ?>

						<?php do_action( 'bp_member_options_nav' ); ?>

					</ul>
				</div>
			</div><!-- #item-nav -->

                        <div id="item-body">

				<?php do_action( 'bp_before_member_body' );

				if ( bp_is_user_activity() || !bp_current_component() ) :
					locate_template( array( 'members/single/activity.php'  ), true );

				 elseif ( bp_is_user_blogs() ) :
					locate_template( array( 'members/single/blogs.php'     ), true );

				elseif ( bp_is_user_friends() ) :
					locate_template( array( 'members/single/friends.php'   ), true );

				elseif ( bp_is_user_groups() ) :
					locate_template( array( 'members/single/groups.php'    ), true );

				elseif ( bp_is_user_messages() ) :
					locate_template( array( 'members/single/messages.php'  ), true );

				elseif ( bp_is_user_profile() ) :
					locate_template( array( 'members/single/profile.php'   ), true );

				elseif ( bp_is_user_forums() ) :
					locate_template( array( 'members/single/forums.php'    ), true );

				elseif ( bp_is_user_settings() ) :
					locate_template( array( 'members/single/settings.php'  ), true );
                                
                                elseif (bp_is_user_notifications() ) :
					locate_template( array( 'members/single/notifications.php'  ), true );


				// If nothing sticks, load a generic template
				else :
					locate_template( array( 'members/single/plugins.php'   ), true );

				endif;

				do_action( 'bp_after_member_body' ); ?>

			</div><!-- #item-body -->

			<?php do_action( 'bp_after_member_home_content' ); ?>

		</div><!-- .padder -->
	</div><!-- #content -->
        <div class='sidebar-single'>
        <?php get_sidebar( 'buddypress' ); ?>
        </div>
</div>

<?php get_footer( 'buddypress' ); ?>
