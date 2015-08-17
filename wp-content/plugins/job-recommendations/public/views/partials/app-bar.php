<!--template-job-recommendations-->
<?php if($suggest_more == true){
    ?>
  <div class='no-pad box-head col-xs-12  col-md-offset-2  col-md-10'>


    </div>
    <a href="<?php echo get_site_url() .'/members/'. bp_core_get_username( get_current_user_id() ) . '/profile/edit/group/14';?>" class="btn-primary btn-raised btn pull-right btn-settings"><i class="material-icons">settings</i></a>

<?php
}
else{
?>
   <div class='no-pad box-head col-xs-12 col-md-offset-2 col-md-10'>
    <?php if(!is_user_logged_in()){
        $link = get_site_url().'/register';
    }else{
        $link = get_site_url() .'/members/'.bp_core_get_username( get_current_user_id() ) . '/profile/edit/group/14';
    }

    ?>
    <?php
    include('menus/buddypress-menu.php');
    include('menus/jobpage-menu.php');
    ?>

    </div>
    <a href="<?php echo $link;?>" class="btn-primary btn-raised btn pull-right btn-settings"><i class="material-icons">settings</i></a>

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
}
?>
