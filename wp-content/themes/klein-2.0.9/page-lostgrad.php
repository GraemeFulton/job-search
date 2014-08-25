<?php
/*
 * Template Name: Lostgrad Filterable Template
 * 
 * A Page for courses
*/


get_header();
do_action('enable_isotopes');

?>
</div>
	<div id="main" class="container lg-container">

<div id="page-container" class="mobile-menu">
<?php do_action('lostgrad_sidebar_filter');?>
    
    
<?php do_action('lostgrad_gridview');?>
    
    <?php do_action('lostgrad_sidebar_adverts');?>

</div>

<?php get_footer(); ?>
