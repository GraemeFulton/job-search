<?php
/** 
 * Content Sidebar Sidebar
 *
 * @package klein
 */
?>

<?php get_template_part( 'content','header'); ?>

<div class="row">
	<div id="primary" class="col-md-6 col-md-push-3 col-sm-6 col-sm-push-3">
		<?php get_template_part( 'content-single', get_post_format() ); ?>
	</div>

	<div id="secondary" class="widget-area col-md-3 col-md-pull-6 col-sm-3 col-sm-pull-6" role="complementary">
		<?php get_sidebar( 'left' ); ?>
	</div>

	<div id="tertiary" class="widget-area col-md-3 col-sm-3" role="complementary">
		
		<?php get_sidebar(); ?>
	</div>
</div>
