<?php do_action( 'bp_before_sidebar' ); ?>

<div id="sidebar" role="complementary">
	<div class="padder">

	<?php do_action( 'bp_inside_before_sidebar' ); ?>

	<?php if ( is_user_logged_in() ) : ?>
            <style>.widget_loginwithajaxwidget{display:none;}</style>
		<?php do_action( 'bp_before_sidebar_me' ); ?>

		<div id="sidebar-me">

			<a id="provatar" href="<?php echo bp_loggedin_user_domain(); ?>">
				<?php bp_loggedin_user_avatar( 'type=thumb&width=40&height=40' ); ?>
			</a>	
                                <div class="clear_both"></div>

                         <div class="profile-buttons">
              	<?php echo '<p class="profile-button"><a href="'.bp_loggedin_user_domain().'profile/edit"><i class="fa fa-edit"></i> Edit Profile</a></p>' ?>
                <br>  <?php echo '<p class="profile-button"><a href="'.bp_loggedin_user_domain().'profile/change-avatar"><i class="fa fa-camera"></i> Change Avatar</a></p>' ?>
                <br>    <?php echo '<p class="profile-button"><a href="'.bp_loggedin_user_domain().'activity"><i class="fa fa-comments-o"></i> My Activity</a></p>' ?>
                <br> <?php echo '<p class="profile-button"><a href="'.bp_loggedin_user_domain().'backpack"><i class="fa fa-briefcase"></i> My Backpack</a></p>' ?>
                <br>     <p class="profile-button"><a href="<?php echo wp_logout_url( wp_guess_url() ); ?>"><?php _e( '<i class="fa fa-sign-out"></i> Log Out', 'buddypress' ); ?></a></p>
                    </div>
			<?php do_action( 'bp_sidebar_me' ); ?>
		</div>
            <div class="clear_both"></div>

		<?php do_action( 'bp_after_sidebar_me' ); ?>

		<?php if ( bp_is_active( 'messages' ) ) : ?>
			<?php bp_message_get_notices(); /* Site wide notices to all users */ ?>
		<?php endif; ?>

	<?php else : ?>

		<?php do_action( 'bp_before_sidebar_login_form' ); ?>

		<?php if ( bp_get_signup_allowed() ) : ?>
		
		

		<?php endif; ?>

	

		<?php do_action( 'bp_after_sidebar_login_form' ); ?>

	<?php endif; ?>

	<?php /* Show forum tags on the forums directory */
	if ( bp_is_active( 'forums' ) && bp_is_forums_component() && bp_is_directory() ) : ?>
		<div id="forum-directory-tags" class="widget tags">
			<h3 class="widgettitle"><?php _e( 'Forum Topic Tags', 'buddypress' ); ?></h3>
			<div id="tag-text"><?php bp_forums_tag_heat_map(); ?></div>
		</div>
	<?php endif; ?>

	<?php dynamic_sidebar( 'sidebar-1' ); ?>

	<?php do_action( 'bp_inside_after_sidebar' ); ?>

	<?php wp_meta(); ?>

	</div><!-- .padder -->
</div><!-- #sidebar -->

<?php do_action( 'bp_after_sidebar' ); ?>
