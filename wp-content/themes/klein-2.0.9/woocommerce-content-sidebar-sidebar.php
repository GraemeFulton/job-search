<?php
/**
 * WooCommerce Content Sidebar Sidebar
 *
 * @package Klein
 */
?>

<div id="primary" class="content-area col-md-6 col-sm-6">
	<div id="content" class="site-content" role="main">
		<?php woocommerce_content(); ?>
	</div><!-- #content -->
</div><!-- #primary -->

<div id="secondary" class="col-md-3 col-sm-3">
	<?php get_sidebar( 'woocommerce-sidebar-left'); ?>
</div>
<div id="tertiary" class="col-md-3 col-sm-3">
	<?php get_sidebar( 'woocommerce-sidebar-right'); ?>
</div>