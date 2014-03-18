<?php get_header(); ?>

<div class='single-container mobile-menu'>
	<div id="content" class='single-content'>
		<div class="padder">

			<?php do_action( 'bp_before_blog_single_post' ); ?>

			<div class="page" id="blog-single" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				

					<div class="post-content">
						<h2 class="posttitle"><?php the_title(); ?></h2>

						<div class="entry">
							<?php the_content( __( 'Read the rest of this entry &rarr;', 'buddypress' ) ); ?>

							<?php wp_link_pages( array( 'before' => '<div class="page-link"><p>' . __( 'Pages: ', 'buddypress' ), 'after' => '</p></div>', 'next_or_number' => 'number' ) ); ?>
						</div>

					</div>

				</div>

			<?php// comments_template(); ?>

			<?php endwhile; else: ?>

				<p><?php _e( 'Sorry, no posts matched your criteria.', 'buddypress' ); ?></p>

			<?php endif; ?>

		</div>

		<?php do_action( 'bp_after_blog_single_post' ); ?>

		</div><!-- .padder -->
	</div><!-- #content -->

        <div id="item-nav" class="mobile-menu-side">
        <div class='sidebar-single sidebar-mobile-shown'>
	<?php get_sidebar(); ?>
            </div>
            </div>
</div>
<?php get_footer(); ?>