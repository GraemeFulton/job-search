<?php 
/*
 * Template Name: Courses (All)
 * 
 * A Page for courses
*/

get_header(); 

?>
<div id="sidebar-left">
    <h1> <?php echo get_the_title(); ?> </h1>
    
    
    <?php if ( function_exists( 'display_taxonomy_tree' ) ) 
        { $tree= display_taxonomy_tree('subject', 'uni');
          $tree->display_tag_groups();
        }
    
    ?>
</div>


<?php 
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$args= array(
        'post_type'=>'course',
    	'paged' => $paged,
        'orderby' => 'title',
        'order' => 'ASC'
);

query_posts( $args); ?>
	<div id="content"  category_type='course' tag_type='subject'>
                        
		<div class="padder">

		<?php do_action( 'bp_before_blog_page' ); ?>

		<div class="page" id="blog-page" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                    <div class="item">

				<h2 class="posttitle"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

					<div class="entry">

						<?php the_excerpt( __( '<p class="serif">Read the rest of this page &rarr;</p>', 'buddypress' ) ); ?>

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
  
 ////////////////NEW ADDITION 
  $object_id = wp_get_post_terms($post->ID, 'uni', array("fields" => "ids"));
  $group_parent_id= $tree->get_tag_group_leader($object_id);
  
  //print the group
  $tree->print_linked_taggroup_or_tag($post->ID, $object_id, $group_parent_id);
  
  //print the group image
  echo $image_html = s8_get_taxonomy_image(get_term_by('id', $group_parent_id, 'xili_tidy_tags_uni'), 'thumbnail'); 
     

 //////////////////////////
 $pic = types_render_field("post-image", array("output"=>"raw"));

 if($pic){
   printf('<br><img style="float:left position:relative; max-height:150px" src="%s"/>', $pic);
 }
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
