<?php
/**
 * WooCommerce Sidebar Sidebar Content
 *
 * @package Klein
 *
 */
?>

<div id="primary" class="col-md-6 col-md-push-6 col-sm-6 col-sm-push-6">
	<div id="content" class="site-content" role="main">
		<?php woocommerce_content(); ?>
	</div><!-- #content -->
</div><!-- #primary -->

<div class="col-md-3 col-md-pull-6 col-sm-3 col-sm-pull-6" id="secondary">
	<?php get_sidebar( 'woocommerce-sidebar-left'); ?>
</div>

<div class="col-md-3 col-md-pull-6 col-sm-3 col-sm-pull-6" id="tertiary">
	<?php get_sidebar( 'woocommerce-sidebar-right'); ?>
</div>



