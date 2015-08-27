<!--template-job-recommendations-->
<?php if(!is_user_logged_in()){
    $link = get_site_url().'/register';
}else{
    $link = get_site_url() .'/members/'.bp_core_get_username( get_current_user_id() ) . '/profile/edit/group/4';
}
?>
<div class='no-pad box-head col-xs-12 col-md-offset-2 col-md-10'>
    <?php
    include('menus/buddypress-menu.php');
    include('menus/jobpage-menu.php');
    ?>
</div>

<?php
  include('menus/settings-button.php');
?>
