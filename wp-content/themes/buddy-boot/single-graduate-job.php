<?php
/**
 * The Template for displaying all single posts.
 *
 * @package klein
 *
 */

get_header(); ?>
<?php global $post; ?>
<div class="container-fluid theme-grey">
	<? include(get_stylesheet_directory().'/partials/side-nav.php');?>
	<?php require(JOB_RECOMMENDATIONS.'/public/views/partials/app-bar.php'); ?>

		<div id="primary" class="col-md-9 col-xs-12">
			<?php  include(get_stylesheet_directory().'/partials/loader.php');?>

<div class="row">


	<div class="col-md-8" id="content-header">
		<h1 class="entry-title" id="bp-klein-page-title">
			<?php the_title(); ?>
		</h1>
	</div>

<?php if(function_exists('bcn_display')){ ?>
	<div class="klein-breadcrumbs col-md-12">
		<?php bcn_display(); ?>
	</div>
<?php } ?>

</div>
<div class="row custom-tax-single shadow-z-2 col-md-8 col-sm-8">
	<div id="primary">
<?php

         $post_id= get_the_ID();
         $popup= new Popup_Filter($post_id, 'graduate-job', 'profession', 'company');

	$popup->template_response('table');
?>
<?php the_content(); ?>

<?php
//	echo '<hr><h3 style="margin-bottom:-20px;">Similar Jobs</h3>'.do_shortcode('[widgets_on_pages id="Related Taxonomy Widget"]');
?>

                    <?php
                        // If comments are open or we have at least one comment, load up the comment template
// 			if ( comments_open() || '0' != get_comments_number() )
// 			comments_template();
                    ?>
	</div>

</div>
	<div id="secondary" class="shadow-z-1 widget-area col-md-4 col-sm-4 pull-right" role="complementary">

		<?php
// 		echo do_shortcode('[widgets_on_pages id="Related Job Sidebar"]');
               get_sidebar(); ?>
	</div>
</div>
</div>

<?php get_footer(); ?>
