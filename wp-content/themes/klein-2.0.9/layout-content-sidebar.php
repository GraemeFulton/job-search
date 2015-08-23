<?php
/**
 * Content Sidebar
 *
 * @package klein
 */
?>

<?php get_template_part( 'content','header'); ?>

<div class="row">
	<div id="primary" class="col-md-8 col-sm-8">
		<?php get_template_part( 'content-single', get_post_format() ); ?>
	</div>
	<div id="secondary" class="widget-area col-md-4 col-sm-4" role="complementary">
		<?php get_sidebar(); ?>
	</div>
</div>