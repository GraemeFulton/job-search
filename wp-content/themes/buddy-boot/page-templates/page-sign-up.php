
<?php
/*
 * Template Name: Sign Up
 *
 * A Page for courses
*/
get_header();?>
<script>var url = "<?php echo get_template_directory_uri();?>/page-templates/partials/page-sign-up/"</script>
<script src="<?php echo get_template_directory_uri()?>/page-templates/partials/page-sign-up/js/load_job.js"></script>
<?php
$page_number = get_query_var('paged');
if($page_number==0){
} ?>

<? include(get_stylesheet_directory().'/partials/side-nav.php');?>

    <?php  do_action('job_recommendation_loop')?>

    <?php include('partials/page-sign-up/sign-up-panel.php') ?>

    <?php include('partials/page-sign-up/sign-up-modal.php') ?>

<?php  get_footer(); ?>

</body>
</html>
