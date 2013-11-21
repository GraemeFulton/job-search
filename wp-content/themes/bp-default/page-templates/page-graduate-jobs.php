<?php 
/*
 * Template Name: Graduate Jobs (All)
 * 
 * A Page for courses
*/

get_header(); 

?>
<div id="sidebar-left">
    <h1> <?php echo get_the_title(); ?> </h1>
    
    
    <?php if ( function_exists( 'display_taxonomy_tree' ) ) 
        { $tree= display_taxonomy_tree('profession', 'company');
          $tree->display_tag_groups();
        }
    
    ?>
</div>


<?php 
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$args= array(
        'post_type'=>'graduate-job',
    	'paged' => $paged,
        'orderby'=>'title',
        'order' => 'ASC'
);




query_posts( $args); ?>
	<div id="content"  category_type='graduate-job' tag_type='profession'>
		<div class="padder">

		<?php do_action( 'bp_before_blog_page' ); ?>

		<div class="page" id="blog-page" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                    
                                    <div class="item">
                                        
                                        <div class="post_image">
                                            <?php //print the image
                                            $tree->print_post_image($group_parent_id, $post->ID);
                                            ?>
                                         </div>
                                        
				<h2 class="posttitle"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

					<div class="entry">

						<?php the_excerpt( __( '<p class="serif">Read the rest of this page &rarr;</p>', 'buddypress' ) ); ?>

						<?php wp_link_pages( array( 'before' => '<div class="page-link"><p>' . __( 'Pages: ', 'buddypress' ), 'after' => '</p></div>', 'next_or_number' => 'number' ) ); ?>
                   
<?php 

// print advert type
printf("Job Type: %s ", types_render_field("graduate-job-type", array("output"=>"normal")));
 
//print company name, and image
$post_object_id = wp_get_post_terms($post->ID, 'company', array("fields" => "ids"));
$group_parent_id= $tree->get_tag_group_leader($post_object_id[0]);
  
//print the name
$tree->print_linked_taggroup_or_tag($post->ID, $post_object_id, $group_parent_id);
  


 ?>
                                            <hr>                                     
                                                    <?php // edit_post_link( __( 'Edit this page.', 'buddypress' ), '<p class="edit-link">', '</p>'); ?>

					</div>
                                            <div class="clickme"></div><!--overlay -->
				</div><!--item-->

				</div>

			<?php comments_template(); ?>

			<?php endwhile; endif; ?>
                                                        

                                
<?php do_action( 'bp_after_blog_page' ); ?>
	
	</div><!-- #content -->
       
        </div><!-- .padder -->
  <div class="nav-more">
             <a href="#" id="blog-more" style="height:100px;"><h4>Load More</h4></a>
        </div>
   </div><!-- .page -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
