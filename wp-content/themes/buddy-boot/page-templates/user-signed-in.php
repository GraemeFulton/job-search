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


<div class="container-fluid theme-grey">
    <? include(get_stylesheet_directory().'/partials/side-nav.php');?>
    
    <section class="col-md-9 col-xs-12">
        <?php  do_action('profile_job_recommendation_loop')?>
</section>
</div>
<?php get_footer(); ?>

</body>
</html>
