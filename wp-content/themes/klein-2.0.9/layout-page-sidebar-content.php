<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package klein
 */

get_header(); ?>

	<?php get_template_part( 'content','header'); ?>
	<div class="row">
		<div id="primary" class="content-area col-md-8 col-sm-8 col-md-push-4 col-sm-push-4">
			<div id="content" class="site-content" role="main">
	
				<?php while ( have_posts() ) : the_post(); ?>
	
					<?php get_template_part( 'content', 'page' ); ?>
	
					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || '0' != get_comments_number() )
							comments_template();
					?>
	
				<?php endwhile; // end of the loop. ?>
	
			</div><!-- #content -->
		</div><!-- #primary -->
	
		<div id="secondary" class="widget-area col-md-4 col-sm-4 col-md-pull-8 col-sm-pull-8" role="complementary">
			<?php get_sidebar('left'); ?>
		</div>
	</div>
<?php get_footer(); ?>