<?php
/** 
 * Full Content
 *
 * @package klein
 */
?>

<?php get_template_part( 'content','header'); ?>

<div class="row">
	<div id="primary" class="col-md-9 col-md-push-1 col-sm-9 col-sm-push-1">
		<?php get_template_part( 'content-single', get_post_format() ); ?>
	</div>
</div>
