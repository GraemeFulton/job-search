<?php

/**
 * BuddyPress - Users Profile
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

function build_nav(){
	$view_active='';
	$edit_active='';
	if (bp_is_profile_edit()){
		$edit_active='active';
	}
	else
		$view_active='active';

	?>
	<div class="content-block">
		<div class="container">
			<div class=" profile-link-container">
				<div class="profile-link <?php echo $view_active;?>"><a href="<?php echo bp_loggedin_user_domain()?>"><i class="fa fa-user"></i> View Profile</a></div>
				<div class="profile-link <?php echo $edit_active;?>"><a href="<?php echo bp_loggedin_user_domain().'/profile/edit/group/1/'?>"><i class="fa fa-cog"></i> Edit Profile</a></div>
				<div class="profile-link pull-right"><a href="<?php echo site_url();?>"><i class="fa fa-chevron-left"></i> Back to Jobs</a></div>
			</div>
		</div>
	</div>
		<?php

}

?>

<div class="item-list-tabs no-ajax" id="subnav" role="navigation">
	<ul>
		<?php //bp_get_options_nav();
build_nav();
?>
	</ul>
</div><!-- .item-list-tabs -->

<?php do_action( 'bp_before_profile_content' ); ?>

<div class="profile  content-block" role="main">

<?php switch ( bp_current_action() ) :

	// Edit
	case 'edit'   :
		bp_get_template_part( 'members/single/profile/edit' );
		break;

	// Change Avatar
	case 'change-avatar' :
		bp_get_template_part( 'members/single/profile/change-avatar' );
		break;

	// Compose
	case 'public' :

		// Display XProfile
		if ( bp_is_active( 'xprofile' ) ){
			include(get_stylesheet_directory().'/page-templates/partials/job-role/selected-panel-old.php');

			bp_get_template_part( 'members/single/profile/profile-loop' );
		}

		// Display WordPress profile (fallback)
		else
			bp_get_template_part( 'members/single/profile/profile-wp' );

		break;

	// Any other
	default :
		bp_get_template_part( 'members/single/plugins' );
		break;
endswitch; ?>

</div><!-- .profile -->

<?php do_action( 'bp_after_profile_content' ); ?>
