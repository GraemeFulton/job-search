
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



<div class="container-fluid theme-grey">

    <?php  do_action('job_recommendation_loop')?>
           
</div>

    <?php include('partials/page-sign-up/sign-up-panel.php') ?>
           
    <?php include('partials/page-sign-up/sign-up-modal.php') ?>

<?php  get_footer(); ?>

</body>
</html>