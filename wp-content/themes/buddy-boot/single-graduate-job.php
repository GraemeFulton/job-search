<?php
/**
 * The Template for displaying all single posts.
 *
 * @package klein
 *
 */

get_header(); ?>
<?php global $post; ?>
	<?php include(get_stylesheet_directory().'/partials/side-nav.php');?>
	<?php require(JOB_RECOMMENDATIONS.'/public/views/partials/app-bar.php'); ?>

<div id="primary" class="col-md-9 main-content-area  col-md-offset-2  col-xs-12">
	<?php  include(get_stylesheet_directory().'/partials/loader.php');?>

	<div class="pagi-top container col-sm-8 no-pad">
		<a class='pull-right' href="javascript:history.go(-1)">
			<i class="material-icons pagi-back-arrow icon-large">arrow_back</i>
			Go back
		</a>

  </div>
	<div class="row custom-tax-single copy-card col-md-8 col-sm-8">
		<div id="primary">
			<?php
	    	$post_id= get_the_ID();
	    	$popup= new Popup_Filter($post_id, 'graduate-job', 'profession', 'company');
				$popup->template_response('table');

?>
<style>
#yasr-custom-text-before-visitor-rating{font-size:22px;}
</style>
<hr>
<div class="cont">
<style>.cont p{display:none}</style>
<h2 style="margin-bottom:15px;">Have your say</h2>
<?php
		the_content();
				?>
</div>
		</div>
	</div>
	<div id="secondary" class="shadow-z-1 widget-area col-md-4 col-sm-4 pull-right" role="complementary">
		<?php  get_sidebar(); ?>
	</div>
</div>

<?php get_footer(); ?>
