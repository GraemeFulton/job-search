<?php
/**
 * WooCommerce Content Sidebar
 *
 * @package Klein
 */
?>


<div id="primary" class="content-area col-sm-8 col-md-8">
	<div id="content" class="site-content" role="main">
		<?php woocommerce_content(); ?>
	</div><!-- #content -->
</div><!-- #primary -->

<div id="secondary" class="col-sm-4 col-md-4 ">
	<?php get_sidebar( 'woocommerce-sidebar-right'); ?>
</div>
