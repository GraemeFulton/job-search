<?php
/**
 * Template Name: Signed In
 */

//if user logged in don't bother
if(is_user_logged_in()!==true){
            wp_redirect( home_url( '/sign-up/' ) ); exit;

}


?>
<?php get_header(); ?>


        <?php include('partials/job-role/selected-panel.php') ?>

<div class="container-fluid theme-grey">
    <section class="container">
        <?php include('partials/job-role/job-role-title.php') ?>

        <?php  do_action('job_recommendation_loop')?>
</section>
</div>
<?php get_footer(); ?>

</body>
</html>
