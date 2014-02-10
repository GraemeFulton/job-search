<?php 
/*
 * Template Name: Courses (All)
 * 
 * A Page for courses
*/

include (TEMPLATEPATH . '/templates-headers/header-course.php');
do_action('enable_isotopes');
?>
<div class="course-line mobile-menu"></div>


<div id="page-container" class="mobile-menu">
            
<div id="sidebar-left" class="mobile-menu-side">
    

    
    <div class="sidebar-options">
    
    <div class="filter-tabs">
        <div class="filter-tab active-filter" id="filter-tab-1"><h4>Filters</h4></div>
        <div class="filter-tab" id="filter-tab-2"><h4>More Options</h4></div>
    </div>
    
 <?php    echo '<div id="Type_Filter" class="filter-tab-1"><h4 class="filter-title">Course Type</h4><br>';
          echo '<div class="page_widget">'.widgets_on_template("Course Type Filter")."</div></div>";
    
          //Subject Filter
          echo '<div class="filter-tab-1">';
          echo '<h3 class="filter-title"><i class="ico fa fa-book"></i> Subject</h3>';
          echo '<div class="page_widget">'.widgets_on_template("Subject Filter")."</div>";
          echo '</div>';
           
       	  echo '<div id="Provider_Filter" class="filter-tab-2"><h3 class="filter-title">Provider</h3>';
          echo '<div class="page_widget">'.widgets_on_template("Course Provider Filter")."</div></div>";
                 
          echo '<div class="nav-filter filter-tab-2" ><h3><i class="ico fa fa-building"></i> University</h3>'; 
          $tree->display_select2_box('Select Universities');
          echo '</div>';
?>

    <?php do_action('the_action_hook'); ?>

</div>
</div>

<?php 
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$args= array(
        'post_type'=>'course',
    	'paged' => $paged,
        'orderby' => 'date',
        'order' => 'DESC'
);

query_posts( $args); ?>

	<div id="content"  class='main-content' category_type='course' tag_type='subject' body_type="uni">
                                 <div id='selected-options'>
                                  

                                     <div class="sort-by-container">
                                         <div class="order-by">
                                         <select id="sort-box">
                                        <option value="" disabled="disabled" selected="selected">Order By</option>
                                        <option value="title">Order By Title</option>
                                        <option value="date">Order By Date</option>
                                        </select>
                                         </div>
                                         <div class="sort-a-z">
                                             
                                             <div class="numeric-sort">&nbsp; Sort:
                                         <button class="fa fa-sort-numeric-desc sort-asc sort-button sort-active"></button>
                                         <button class="fa fa-sort-numeric-asc sort-desc sort-button "></button>
                                             </div>
                                             
                                         <div class="alpha-sort">&nbsp; Sort:
                                            <button class="fa fa-sort-alpha-asc sort-desc sort-button "></button>
                                             <button class="fa fa-sort-alpha-desc sort-asc sort-button sort-active"></button>
                                            </div>
                                         </div>
                                     </div>
                                     
                                 </div>
   
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
    
                                        <div class="post_image is-loading">
                                            <img class="course_post_image advert_image" src="<?php echo $post_image?>"/> 
                                         </div>

				<h2 class="posttitle"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

                                	<div class="entry">                                    
                                          <span class="post-tag"><i class="ico fa fa-building"></i> <?php echo $uni_name;?></span>
                                          <span class="post-tag"><i class="ico fa fa-book"></i> <?php echo $subject;?></span>
                                           <?php// echo $ratings;?>     
                                        </div>
                                
                                      <div class="pop-out"></div>  
                                <div class="clickme"></div><!--overlay -->
				</div><!--item-->

				</div>

			<?php comments_template(); ?>

			<?php endwhile; endif; ?>
                                                        

                                
<?php do_action( 'bp_after_blog_page' ); ?>
                    
	</div><!-- #content -->
        
        <div id="loaded_content"></div>
        <div id="blog-more"><p>Load More</p></div>

        </div><!-- .padder -->
   </div><!-- .page -->

   <div class='sidebar-main'>

	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
</div>