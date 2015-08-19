<!--template-job-recommendations-->
<?php if(!is_user_logged_in()){
    $link = get_site_url().'/register';
}else{
    $link = get_site_url() .'/members/'.bp_core_get_username( get_current_user_id() ) . '/profile/edit/group/14';
}
?>
<div class='no-pad box-head col-xs-12 col-md-offset-2 col-md-10'>
    <?php
    include_once('menus/buddypress-menu.php');
    include_once('menus/jobpage-menu.php');
    ?>
</div>

<?php
  include_once('menus/settings-button.php');
?>

<?php
if($nothing_found==true){
    ?>
     <?php if ($paged<3){?>
	<div class="container-margin-bottom">
		<h3><i class="fa fa-thumbs-o-up"></i> We've found <?php echo $wp_query->found_posts;?> related jobs within the UK</h3>
	   <p><i class="fa fa-info-circle"></i> There are no more jobs in the location you selected</p>
    </div>
    <?php } ?>

<?php
}
?>
