<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package klein
 */

get_header(); ?>

	<div class="clearfix">
		
			<div class="archive-page-header" id="content-header">
				<h1 class="entry-title">
					<?php
						if ( is_category() ) :
							single_cat_title();

						elseif ( is_tag() ) :
							single_tag_title();

						elseif ( is_author() ) :
							/* Queue the first post, that way we know
							 * what author we're dealing with (if that is the case).
							*/
							the_post();
							printf( __( 'Author: %s', 'klein' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );
							/* Since we called the_post() above, we need to
							 * rewind the loop back to the beginning that way
							 * we can run the loop properly, in full.
							 */
							rewind_posts();

						elseif ( is_day() ) :
							printf( __( 'Day: %s', 'klein' ), '<span>' . get_the_date() . '</span>' );

						elseif ( is_month() ) :
							printf( __( 'Month: %s', 'klein' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

						elseif ( is_year() ) :
							printf( __( 'Year: %s', 'klein' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

						elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
							_e( 'Asides', 'klein' );

						elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
							_e( 'Images', 'klein');

						elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
							_e( 'Videos', 'klein' );

						elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
							_e( 'Quotes', 'klein' );

						elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
							_e( 'Links', 'klein' );

						else :
							_e( 'Archives', 'klein' );

						endif;
					?>
				</h1>
				<?php
					// Show an optional term description.
					$term_description = term_description();
					if ( ! empty( $term_description ) ) :
						printf( '<div class="taxonomy-description">%s</div>', $term_description );
					endif;
				?>
			</div><!-- .page-header -->
		
	</div><!-- .clearfix -->
		<!--breadcrumbs -->
	<?php if(function_exists('bcn_display')){ ?>
		<div class="klein-breadcrumbs clearfix">
			<?php bcn_display(); ?>
		</div>
	<?php } ?>
	<!-- end breadcrumbs -->
	<div class="clear"></div>
	
	<div class="row">
		<section id="primary" class="content-area col-md-8 col-sm-8">
			<div id="content" class="site-content" role="main">
	
			<?php if ( have_posts() ) : ?>
	
	
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<div class="clearfix klein-blog-article-list">
					<?php
						/* Include the Post-Format-specific template for the content.
						* If you want to overload this in a child theme then include a file
						* called content-___.php (where ___ is the Post Format name) and that will be used instead.
						*/
						get_template_part( 'content', get_post_format() );
					?>
					</div>
				<?php endwhile; ?>
	
				<?php klein_content_nav( 'nav-below' ); ?>
	
			<?php else : ?>
	
				<?php get_template_part( 'no-results', 'archive' ); ?>
	
			<?php endif; ?>
	
			</div><!-- #content -->
		</section><!-- #primary -->
	
		<div class="col-md-4 col-sm-4">
			<?php get_sidebar(); ?>
		</div>
		
	</div><!--.row-->	
<?php get_footer(); ?>