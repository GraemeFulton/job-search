<?php get_header();
$post_type=get_post_type();
?>
<div class='single-container'>

	<div id="content"class='single-content'>
		<div class="padder">

		<?php do_action( 'bp_before_archive' ); ?>

		<div class="page" id="blog-archives" role="main">
                    <h3 class="pagetitle">
                    <?php if ($post_type=='post'){
                    printf( __( '%1s&apos;s Blog', 'buddypress' ), wp_title( false, false ) );}
                    else  printf( __( 'You are browsing the archive for %1$s.', 'buddypress' ), wp_title( false, false ) );
                    ?>
                    </h3>
			<?php if ( have_posts() ) : ?>

				<?php bp_dtheme_content_nav( 'nav-above' ); ?>
                    
                <div class="archive-list">
                    
				<?php while (have_posts()) : the_post(); ?>

					<?php do_action( 'bp_before_blog_post' ); ?>
<?php
$post_id=  get_the_ID();
$image_src=get_the_image($post_id);

?>
					<div id="post-<?php echo $post_id ?>" <?php post_class(); ?>>

   <?php //display author if post type is a post 
   if($post_type=='post'){?>
        <div class="author-box">
<?php echo get_avatar( get_the_author_meta('user_email'), 50); ?>
       <p><?php printf( _x( 'by %s', 'Post written by...', 'buddypress' ), bp_core_get_userlink( $post->post_author ) ); ?></p>
						</div>
<?php } ?>

                                            
                                            <div class="post-content">
							<h2 class="posttitle"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
							<p class="date"><?php printf( __( '%1$s <span>in %2$s</span>', 'buddypress' ), get_the_date(), get_the_category_list( ', ' ) ); ?></p>

							<div class="entry">
								<?php the_content( __( 'Read the rest of this entry &rarr;', 'buddypress' ) ); ?>
								<?php wp_link_pages( array( 'before' => '<div class="page-link"><p>' . __( 'Pages: ', 'buddypress' ), 'after' => '</p></div>', 'next_or_number' => 'number' ) ); ?>
                                                            <img src="<?php echo $image_src;?>" class="archive_image"/>

                                                        </div>

							<p class="postmetadata"><?php the_tags( '<span class="tags">' . __( 'Tags: ', 'buddypress' ), ', ', '</span>' ); ?> <span class="comments"><?php comments_popup_link( __( 'No Comments &#187;', 'buddypress' ), __( '1 Comment &#187;', 'buddypress' ), __( '% Comments &#187;', 'buddypress' ) ); ?></span></p>
						</div>

					</div>

					<?php do_action( 'bp_after_blog_post' ); ?>
				<?php endwhile; ?>
                </div>

				<?php bp_dtheme_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<h2 class="center"><?php _e( 'Not Found', 'buddypress' ); ?></h2>
				<?php get_search_form(); ?>

			<?php endif; ?>

		</div>

		<?php do_action( 'bp_after_archive' ); ?>

		</div><!-- .padder -->
	</div><!-- #content -->

	<div class='sidebar-single'>
	<?php get_sidebar(); ?>
            </div>
</div>

<?php get_footer(); ?>
