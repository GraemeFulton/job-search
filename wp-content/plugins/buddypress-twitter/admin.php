<?php



add_action('admin_menu', 'bp_twittercj_plugin_menu');

add_action( 'network_admin_menu', 'bp_twittercj_plugin_menu' );



function bp_twittercj_plugin_menu() {

	add_submenu_page( 'bp-general-settings', 'Bp Twitter', 'BuddyPress Twitter', 'manage_options', 'bp-twittercj', 'bptwittercj_plugin_options');

	
	//call register settings function

	add_action( 'admin_init', 'bptwittercj_register_settings' );

}



function bptwittercj_register_settings() {

	//register our settings

	register_setting( 'bptwittercj_plugin_options', 'twittercj-members' );

	register_setting( 'bptwittercj_plugin_options', 'twittercj-groups' );
	
	register_setting( 'bpgooglepluscj_plugin_options', 'twittercj-groups-placement' );
	
	register_setting( 'bptwittercj_plugin_options', 'twittercj-count' );
	
	register_setting( 'bptwittercj_plugin_options', 'twittercj-button-size' );


	//name to cerrelate to the members profile field label
	register_setting( 'bptwittercj_plugin_options', 'twittercj_member_label' );


	//name to cerrelate to the gropus field label
	register_setting( 'bptwittercj_plugin_options', 'twittercj_group_label' );}



function bptwittercj_plugin_options() {

	if (!current_user_can('manage_options'))  {

		wp_die( __('You do not have sufficient permissions to access this page.') );

				
	}
	

?>



			<?php if ( !empty( $_GET['settings-updated'] ) ) : ?>
				<div id="message" class="updated">
					<p><strong><?php _e('Buddypress Twitter Settings have been saved.' ); ?></strong></p>
				</div>
			<?php endif; ?>






<div class="wrap">

<h2>
<?php _e('BuddyPress Twitter Settings', 'bptwittercj') ?>
</h2>


<h3><?php _e('Member and Group Components.', 'bptwittercj') ?></h3>


<p><?php _e('The plugin uses Buddypress XProfile Fields and requires you to name the "Mirror Profile Field Title" below the same as your custom Profile Field Title - Please read the <a href="http://wordpress.org/extend/plugins/buddypress-twitter/installation/" target="_blank" title="Opens in a new tab">plugin installation instructions</a> if you are not sure what to do.', 'bptwittercj') ?></p>

<form method="post" action="<?php echo admin_url('options.php');?>">

<?php wp_nonce_field('update-options'); ?>


<table class="form-table">



<hr></hr>


































<?php // members admin options ?>



<table class="form-table">






	<tr valign="top">

		<th scope="row"><b>Members</b></th>

			<td>
				<input type="checkbox" name="twittercj-members" value="1" <?php if (get_option('twittercj-members')==1) echo 'checked="checked"'; ?>/>
				Let your members display their twitter follow button on their profile page.
			</td>

	</tr>

	<tr valign="top">
		<th scope="row"><colored-text style="color: red;">Mirror</colored-text> Profile Field Title</th>
            		<td>
				<input <?php if ( get_option('twittercj-members') == '' ) {?>disabled="disabled"<?php }?> name="twittercj_member_label" value="<?php echo get_option('twittercj_member_label') ?>"/><?php if ( get_option('twittercj-members') == '' ) {?><br /><i><colored-text style="color: orange;">Disabled</colored-text> - Tick the check-box above and save to enable this feature</i><?php }?>
                <p><colored-text style="color: green;">Quick links:</colored-text> Visit <a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=bp-profile-setup&group_id=1&mode=add_field" target="_blank" title="opens in a new tab">Add Field</a> to set up a new XProfile field or <a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=bp-profile-setup" target="_blank" title="opens in a new tab">Extended Profile Fields</a> to edit a existing field</p>
			</td>
		</tr>
</table>

<?php // groups admin options ?>

<table class="form-table">


	<tr valign="top">

		<th scope="row"><b>Groups</b></th>

			<td>
				<input type="checkbox" name="twittercj-groups" value="1" <?php if (get_option('twittercj-groups')==1) echo 'checked="checked"'; ?>/>
				Let your groups display their Twitter follow button on the group's home page.
			</td>

	</tr>



	<tr valign="top">
		<th scope="row">Group Field Title</th>
            		<td>
				<input <?php if ( get_option('twittercj-groups') == '' ) {?>disabled="disabled"<?php }?> name="twittercj_group_label" value="<?php echo get_option('twittercj_group_label') ?>"/><?php if ( get_option('twittercj-groups') == '' ) {?><br /><i><colored-text style="color: orange;">Disabled</colored-text> - Tick the check-box above and save to enable this feature</i><?php }?>  
			</td>
		</tr>
</table>





<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="twittercj-members,twittercj-groups,twittercj_member_label,twittercj_group_label" />



<p class="submit">

	<input type="submit" class="button-primary" value="<?php _e('Save Component Settings') ?>" />

</p>


</form>







<h3><?php _e('Display Settings.', 'bptwittercj') ?></h3>


<p><?php _e('Alter the appearance of the twitter button - note that the appearance will be the same for members and for groups. Click the save button to preview the changes.', 'bptwittercj') ?></p>

<form method="post" action="<?php echo admin_url('options.php');?>">

<?php wp_nonce_field('update-options'); ?>


<table class="form-table">
<hr></hr>


	<tr valign="top">

		<th scope="row"><b>Groups Button Position</b></th>

			<td>
				 <label>
    				<input <?php if ( get_option('twittercj-groups') == '' ) {?>disabled="disabled"<?php }?> type="radio" name="twittercj-groups-placement" value="" <?php if (get_option('twittercj-groups-placement')=='') echo 'checked="checked"'; ?> />
    			Before the group description</label>
  			<br />
  				<label>
   					<input <?php if ( get_option('twittercj-groups') == '' ) {?>disabled="disabled"<?php }?> type="radio" name="twittercj-groups-placement" value="1" <?php if (get_option('twittercj-groups-placement')==1) echo 'checked="checked"'; ?> />
    			After the group description</label>
                <?php if ( get_option('twittercj-groups') == '' ) {?><br /><i><colored-text style="color: orange;">Disabled</colored-text> - This feature requires the groups component to be enable above.</i><?php }?>
			</td>

	</tr>

	<tr valign="top">

		<th scope="row"><b>Follower Button Size</b></th>

			<td>
				 <label>
    				<input type="radio" name="twittercj-button-size" value="" <?php if (get_option('twittercj-button-size')=='') echo 'checked="checked"'; ?> />
    			Normal</label>
  			<br />
  				<label>
   					<input type="radio" name="twittercj-button-size" value="1" <?php if (get_option('twittercj-button-size')==1) echo 'checked="checked"'; ?> />
    			Large</label>
			</td>

	</tr>

	<tr valign="top">

		<th scope="row"><b>Follower Count</b></th>

			<td>
				<input type="checkbox" name="twittercj-count" value="1" <?php if (get_option('twittercj-count')==1) echo 'checked="checked"'; ?>/>
				Shows the user's/group's follower count next to their follow button.
			</td>

	</tr>






</table>

<div id="bp-twitter-button-preview" style="padding:0 10px 10px;margin-top:20px;border: 1px solid #CCC;">

<p><colored-text style="color: green;">Button Preview</colored-text></p>

<a href="https://twitter.com/itsCharlKruger" class="twitter-follow-button" data-show-count="<?php if (get_option('twittercj-count')==1) {
		echo 'true';
	}
	else {
		echo 'false';
	} ?>" <?php if (get_option('twittercj-button-size')==1) echo 'data-size="large""'; ?> >Follow @itsCharlKruger</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

</div>

<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="twittercj-groups-placement, twittercj-count, twittercj-button-size" />



<p class="submit">

	<input type="submit" class="button-primary" value="<?php _e('Save Display Settings') ?>" />

</p>


</form>






<p>If you enjoy the plugin and would like to keep up to speed on future features and updates, <b>follow me on twitter</b> or check out my blog - <a href="http://charlkruger.com" target="_blank">CharlKruger.com</a></p>
<p>Feel free to retweet the plugin to let your followers know and don't forget to give me a +K on <a href="http://klout.com/#/itsCharlkruger" target="_blank" title="Charl Kruger's Klout - opens in a new tab">Klout.com</a></p>
<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://buddypress.org/community/groups/buddypress-twitter/home/" data-text="Let your #Buddypress members and groups add their twitter follow button to their profiles" data-via="itsCharlKruger">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

</div>

<iframe src="http://widgets.klout.com/badge/itsCharlkruger?size=s" style="margin-top:10px;border:0" scrolling="no" allowTransparency="true" frameBorder="0" width="120px" height="59px"></iframe>


<?php

}


?>