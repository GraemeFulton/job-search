<?php 
/*
 * Template Name: Courses (Paid)
 * 
 * A Page for courses
*/

get_header(); 

	 get_sidebar('left');

?>
<?php 
$args= array(
        'post_type'=>'course',
    
'meta_query' => array(
        array(
            'key' => 'wpcf-course-type',
            'value'=>'"2"',
            'compare' => 'LIKE'
        )
    )
);




query_posts( $args); ?>

	<div id="content">
            
		<div class="padder">

		<?php do_action( 'bp_before_blog_page' ); ?>

		<div class="page" id="blog-page" role="main">

                    
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h2 class="posttitle"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

					<div class="entry">

						<?php the_content( __( '<p class="serif">Read the rest of this page &rarr;</p>', 'buddypress' ) ); ?>

						<?php wp_link_pages( array( 'before' => '<div class="page-link"><p>' . __( 'Pages: ', 'buddypress' ), 'after' => '</p></div>', 'next_or_number' => 'number' ) ); ?>
						
<?php //addition: company name
$linked_company= get_field('Company') ;
//var_dump($linked_company);
$linked_co = $linked_company[0];
if ($linked_co)
echo 'Institution: <a href="'. $linked_co->guid.'">'. $linked_co->post_title.'</a> ';

?>
<?php //addition: course type field
 
$course_type = types_render_field("course-type", array("output"=>"normal"));
 
//Output the trainer email
 if($course_type)
printf("| Course Type: %s",$course_type);
?>
                                            <hr>                                       
                                                    <?php // edit_post_link( __( 'Edit this page.', 'buddypress' ), '<p class="edit-link">', '</p>'); ?>

					</div>

				</div>

			<?php comments_template(); ?>

			<?php endwhile; endif; ?>

		</div><!-- .page -->

		<?php do_action( 'bp_after_blog_page' ); ?>

		</div><!-- .padder -->
	</div><!-- #content -->

	<div class='sidebar-main'>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
