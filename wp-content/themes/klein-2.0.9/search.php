<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package klein
 */

get_header(); ?>

<?php if( klein_is_blog() ){ ?>
	<?php if(function_exists('bcn_display')){ ?>
		<div class="klein-breadcrumbs row">
			<?php bcn_display(); ?>
		</div>
	<?php } ?>
<?php } ?>

	<div class="row" id="content-header">
		<div class="col-md-11 col-sm-11">
			<h1 class="entry-title" id="bp-klein-page-title">
				<?php printf( __( 'Search Results for: %s', 'klein' ), '<span>' . get_search_query() . '</span>' ); ?>
			</h1>
		</div>
	</div>
	
	<?php if(function_exists('bcn_display')){ ?>
		<div class="klein-breadcrumbs row">
			<div class="col-md-11 col-sm-11">
				<?php bcn_display(); ?>
			</div>	
		</div>
	<?php } ?>
	
	<div class="row clearfix">
		<div id="primary" class="content-area col-md-8 col-sm-8">
			<div id="content" class="site-content" role="main">
	
			<?php if ( have_posts() ) : ?>
	
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
	
					<?php
						/* Include the Post-Format-specific template for the content.
						* If you want to overload this in a child theme then include a file
						* called content-___.php (where ___ is the Post Format name) and that will be used instead.
						*/
						get_template_part( 'content', get_post_format() );
					?>
					
					
				<?php endwhile; ?>
	
				<?php klein_content_nav( 'nav-below' ); ?>
	
			<?php else : ?>
	
				<?php get_template_part( 'no-results', 'index' ); ?>
	
			<?php endif; ?>
	
			</div><!-- #content -->
		</div><!-- #primary -->
		
		<div class="col-md-4 col-sm-4">
			<?php get_sidebar(); ?>
		</div>
	</div><!--.row.clearfix-->
<?php get_footer(); ?>