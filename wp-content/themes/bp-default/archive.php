<?php get_header(); ?>
<div class='single-container'>

	<div id="content"class='single-content'>
		<div class="padder">

		<?php do_action( 'bp_before_archive' ); ?>

		<div class="page" id="blog-archives" role="main">

			<h3 class="pagetitle"><?php printf( __( 'You are browsing the archive for %1$s.', 'buddypress' ), wp_title( false, false ) ); ?></h3>

			<?php if ( have_posts() ) : ?>

				<?php bp_dtheme_content_nav( 'nav-above' ); ?>

				<?php while (have_posts()) : the_post(); ?>

					<?php do_action( 'bp_before_blog_post' ); ?>

					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<div class="author-box">
<?php 
if ( 'course' == get_post_type() ){
           $img= types_render_field("post-image", array("output"=>"raw"));
           echo '<img width=50 src="'.$img.'"/>';

}else{
$post_id=  get_the_ID();

     $cat_term_id = wp_get_post_terms($post_id, 'profession', array("fields" => "ids")); 
       $category_image = s8_get_taxonomy_image_src(get_term_by('id', $cat_term_id[0], 'profession'), 'medium');
       if ($category_image!=false){
           echo '<img width=50 src="'.$category_image['src'].'"/>';
        }      
         else {
           $sub_category = get_term_by( 'id', $cat_term_id[0], 'profession' );
           $parent = get_term_by( 'id', $sub_category->parent, 'profession');
          $category_image = s8_get_taxonomy_image_src($parent, 'medium');
          if ($category_image!=false){
           echo '<img width=50 src="'.$category_image['src'].'"/>';
        }
         }
}  
      
       
?>
                                                    <p><?php printf( _x( 'by %s', 'Post written by...', 'buddypress' ), bp_core_get_userlink( $post->post_author ) ); ?></p>
						</div>

						<div class="post-content">
							<h2 class="posttitle"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

							<p class="date"><?php printf( __( '%1$s <span>in %2$s</span>', 'buddypress' ), get_the_date(), get_the_category_list( ', ' ) ); ?></p>

							<div class="entry">
								<?php the_content( __( 'Read the rest of this entry &rarr;', 'buddypress' ) ); ?>
								<?php wp_link_pages( array( 'before' => '<div class="page-link"><p>' . __( 'Pages: ', 'buddypress' ), 'after' => '</p></div>', 'next_or_number' => 'number' ) ); ?>
							</div>

							<p class="postmetadata"><?php the_tags( '<span class="tags">' . __( 'Tags: ', 'buddypress' ), ', ', '</span>' ); ?> <span class="comments"><?php comments_popup_link( __( 'No Comments &#187;', 'buddypress' ), __( '1 Comment &#187;', 'buddypress' ), __( '% Comments &#187;', 'buddypress' ) ); ?></span></p>
						</div>

					</div>

					<?php do_action( 'bp_after_blog_post' ); ?>

				<?php endwhile; ?>

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
