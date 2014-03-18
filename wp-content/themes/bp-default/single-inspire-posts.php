<?php get_header(); ?>
    <div class="inspire-line mobile-menu"></div>

<div class='single-container mobile-menu'>
	<div id="content" class='single-content single-page'>
		<div class="padder">

			<?php do_action( 'bp_before_blog_single_post' ); ?>
			<div class="page" id="blog-single" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php
$post_id=  get_the_ID();
$image_src=get_the_image($post_id);

?>
				<div id="post-<?php echo $post_id; ?>" <?php post_class(); ?>>

					<div class="post-content">
                                            <p class="date">
							<?php printf( __( '%1$s <span>in %2$s</span>', 'buddypress' ), get_the_date(), get_the_category_list( ', ' ) ); ?>
                                                       <span class="bookmark-post-icon"><?php wpfp_link($post_id); ?></span>
							<span class="post-utility alignright"><?php edit_post_link( __( 'Edit this entry', 'buddypress' ) ); ?></span>
						</p>
						<h2 class="posttitle"><?php the_title(); ?></h2>
                                                <br>
                                                <img src="<?php echo $image_src;?>" class="archive_image"/>
                                                <hr>
                                                <div class="entry">

							<?php the_content( __( 'Read the rest of this entry &rarr;', 'buddypress' ) ); ?>

							<?php wp_link_pages( array( 'before' => '<div class="page-link"><p>' . __( 'Pages: ', 'buddypress' ), 'after' => '</p></div>', 'next_or_number' => 'number' ) ); ?>

                                                </div>

						<p class="postmetadata"><?php the_tags( '<span class="tags">' . __( 'Tags: ', 'buddypress' ), ', ', '</span>' ); ?>&nbsp;</p>

						<div class="alignleft"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'buddypress' ) . '</span> %title' ); ?></div>
						<div class="alignright"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'buddypress' ) . '</span>' ); ?></div>
					</div>

				</div>

			<?php comments_template(); ?>

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