<?php
/**
 * BuddyPress Full Content
 *
 * @package klein
 */ 
?>

<div id="primary" class="bp-content-area">
	
	<div id="content" class="site-content col-md-10 col-sm-10" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'page' ); ?>

		<?php endwhile; // end of the loop. ?>

	</div><!-- #content -->
</div><!-- #primary --> 