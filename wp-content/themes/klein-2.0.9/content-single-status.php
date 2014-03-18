<?php
/**
 * The template for displaying status (single page)
 *
 * @package Klein
 *
 */
?>
<?php global $post; ?>

<div id="content" <?php echo post_class(); ?> role="main">
	<?php while ( have_posts() ) : the_post(); ?>
	
		<div class="clearfix">
			<div class="blog-author entry-content-author">
				<?php klein_author(); ?>
			</div>
			<div class="blog-content">
					<?php if( has_post_thumbnail() ){ ?>
						<div class="clearfix center entry-content-thumbnail">
							<?php the_post_thumbnail( 'full', array( 'class' => 'scale-with-grid' ) ); ?>
						</div>
					<?php } ?>
				<div class="blog-pad entry-content">
					<?php the_content(); ?>
				</div>
				<div class="blog-pad blog-content-meta">
					<?php klein_entry_meta(); ?>
				</div>
				<div class="blog-pad">
					<?php klein_content_nav( 'nav-below' ); ?>
				</div>
			</div>
			
			<div class="clear"></div>
		</div>
		
		
		
		<div class="clearfix">
		
		<?php
			// If comments are open or we have at least one comment, load up the comment template
			if ( comments_open() || '0' != get_comments_number() )
				comments_template();
		?>
		</div>
	<?php endwhile; // end of the loop. ?>
</div><!-- #content -->
