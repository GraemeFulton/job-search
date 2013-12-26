<?php 
/*
 * Template Name: Courses (All)
 * 
 * A Page for courses
*/

include (TEMPLATEPATH . '/templates-headers/header-course.php');
do_action('enable_isotopes');
?>
<div id="page-container">
    
    
<div id="sidebar-left">
    <div class="filter-header">
    <h4>Filter</h4>
    </div>
    
 <?php      echo '<div id="Type_Filter"><h4 class="filter-title">Course Type</h4><br>';
          echo '<div class="page_widget">'.widgets_on_template("Course Type Filter")."</div></div>";
        

          //Subject Filter
            echo '<h3 class="filter-title"><i class="ico fa fa-book"></i> Subject</h3>';
           echo '<div class="page_widget">'.widgets_on_template("Subject Filter")."</div>";
           
       echo '<div id="Provider_Filter"><h3 class="filter-title">Provider</h3>';
          echo '<div class="page_widget">'.widgets_on_template("Course Provider Filter")."</div></div>";
                 
            echo '<div class="nav-filter"><h3><i class="ico fa fa-building"></i> University</h3>'; 
                    $tree->display_select2_box('Select Universities');
                    echo '</div>';
    
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
            <div class='selected-course-options'id='selected-options'></div>

	<div id="content"  class='main-content' category_type='course' tag_type='subject' body_type="uni">
                        
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
$post_object_id = wp_get_post_terms($post_id, 'uni', array("fields" => "ids"));
//$group_parent_id= $tree->get_tag_group_leader($post_object_id[0]);
//get company name
$uni_name= $tree->get_linked_taggroup_or_tag($post_id, $post_object_id, $group_parent_id); 

$ratings= show_ratings($post_id);
?>                            

				<div id="<?php echo $post_id; ?>" <?php post_class(); ?>>
                                    <div class="item">
    
                                        <div class="post_image">
                                            <img class="course_post_image" src="<?php echo $post_image?>"/> 
                                         </div>

				<h2 class="posttitle"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

                                	<div class="entry">                                    
                                           <?php echo $uni_name;?> | <?php echo $subject;?> | <?php echo $course_type;?>
                                           <?php echo $ratings;?>     
                                        </div>
                                
                                      <div class="pop-out"></div>  
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
   </div><!-- .page -->

   <div class='sidebar-main'>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
</div>