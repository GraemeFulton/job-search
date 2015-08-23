<?php
/**
 * Template Name: Signed In
 */
$page_number = get_query_var('paged');
$total = get_query_var('total');

//if user logged in don't bother
if(is_user_logged_in()!==true){
            wp_redirect( home_url( '/sign-up/' ) ); exit;

}


?>
<?php get_header(); ?>

    <?php include(get_stylesheet_directory().'/partials/side-nav.php');?>

        <?php  do_action('profile_job_recommendation_loop')?>
<?php get_footer(); ?>

</body>
</html>
