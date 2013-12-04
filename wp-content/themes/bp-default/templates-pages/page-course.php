<?php 
/*
 * Template Name: Courses (All)
 * 
 * A Page for courses
*/

include (TEMPLATEPATH . '/templates-headers/header-course.php');

?>
<div id="page-container">
    
<div id="sidebar-left">
    <h2>Sort Courses:</h2>
    <hr>
    <h2>Subject</h2>
    
    <?php if ( function_exists( 'display_taxonomy_tree' ) ) 
        {
        global $tree;
          $tree= display_taxonomy_tree('subject', 'uni');
          $tree->display_tag_groups();
          
          echo '<hr><h2>University</h2>'; $tree->display_tag_groups_b();
       }
       // 
    
    ?>
    <?php do_action('the_action_hook'); ?>

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
    
	<div id="content"  category_type='course' tag_type='subject' body_type="uni">
                        
		<div class="padder">

		<?php do_action( 'bp_before_blog_page' ); ?>

		<div class="page" id="blog-page" role="main">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <?php                    
//set up page variables
$post_id=$post->ID;
//post image
$post_image=$tree->get_post_image($group_parent_id, $post_id); 
//subject/grouped taxonomy
$subject=$tree->grouped_taxonomy_name($post_id);
// get advert type
$course_type=types_render_field("course-type", array("output"=>"normal"));
//print company name, and image
$post_object_id = wp_get_post_terms($post_id, 'company', array("fields" => "ids"));
$group_parent_id= $tree->get_tag_group_leader($post_object_id[0]);
//get company name
$uni_name= $tree->get_linked_taggroup_or_tag($post_id, $post_object_id, $group_parent_id); 
//get provider logo
$term_id = wp_get_post_terms($post_id, 'provider', array("fields" => "ids"));
if($term_id){
    $provider= s8_get_taxonomy_image_src(get_term_by('id', $term_id[0], 'provider'), 'small');
}
$ratings= show_ratings($post_id);
?>                            

				<div id="post-<?php echo $post_id; ?>" <?php post_class(); ?>>
                                    <div class="item">
    
                                          <div class="post_image">
                                            <img style="position: relative; max-height:150px;" src="<?php echo $post_image?>"/> 
                                         </div>

				<h2 class="posttitle"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

                                	<div class="entry">                                    
                                           <?php echo $uni_name;?> | <?php echo $subject;?> | <?php echo $course_type;?>
                                           <?php echo $ratings;?>     
                                        </div>
                                
                                      <div class="pop-out">
                                            <div class="datagrid">
                                            <table class="pop-out-tbl">
                                               <tr class="alt"><td>Offered By: </td><td><?php echo $uni_name;?></td></tr>
                                              <tr><td>Subject: </td><td><?php echo $subject;?></td></tr>
                                               <tr class="alt"><td>Course Type: </td><td><?php echo $course_type;?></td></tr>
                                               
                                                <tr><td>Course Provider:</td><td><img style="float:left; position:relative; max-height:35px; max-width:80px;" src="<?php echo $provider['src']?>"/></td></tr>
                                                <tr class="alt"><td>Course Excerpt: </td><td><?php echo  the_excerpt( __( '<p class="serif">Read the rest of this page &rarr;</p>', 'buddypress' ) ); ?></td></tr>
                                                <tr><td>Course Rating: </td><td>  <?php echo $ratings;?> </td></tr>
                                            </table>
                                            </div>
                                            <?php
                                            echo replace_links('<a class="btn btn-success btn-large" href="'.(types_render_field("course-url", array("show_name"=>"true","raw"=>"true"))).'">Learn Now</a>'); 
                                            ?>
                                        </div>  
                                <hr>
                                <div class="clickme"></div><!--overlay -->
				</div><!--item-->

				</div>

			<?php comments_template(); ?>

			<?php endwhile; endif; ?>
                                                        

                                
<?php do_action( 'bp_after_blog_page' ); ?>
                    
	
	</div><!-- #content -->
        
        <div id="loaded_content"></div>
       
        </div><!-- .padder -->
  <div class="nav-more">
             <a href="#" id="blog-more" style="height:100px;"><h4>Load More</h4></a>
        </div>
   </div><!-- .page -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
</div>