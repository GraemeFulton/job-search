<?php
/**
 * BuddyPress Sidebar Content
 *
 * @package klein
 */ 
?>


	<div id="primary" class="bp-content-area col-md-8 col-sm-8 col-md-push-4 col-sm-push-4">
		
		<div id="content" class="site-content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary --> 

	<div id="secondary" class="col-md-4 col-sm-4 col-md-pull-8 col-sm-pull-8">
		<?php get_sidebar( 'buddypress-left' ); ?>
	</div>
