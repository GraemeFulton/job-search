<?php
/**
 * WooCommerce Sidebar Content
 *
 * @package Klein
 */
?>

<div id="primary" class="content-area col-md-8 col-md-push-4 col-sm-8 col-sm-push-4">
	<div id="content" class="site-content" role="main">
		<?php woocommerce_content(); ?>
	</div><!-- #content -->
</div><!-- #primary -->

<div id="secondary" class="col-md-4 col-md-pull-8 col-sm-4 col-sm-pull-8">
	<?php get_sidebar( 'woocommerce-sidebar-left'); ?>
</div>

	