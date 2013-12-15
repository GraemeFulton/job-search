<?php 
/*
 * Template Name: Work Experience (All)
 * 
 * A Page for courses
*/

include (TEMPLATEPATH . '/templates-headers/header-work-experience.php');
?>

<div id="page-container">

<div id="sidebar-left">
    <div class="filter-header">
     <h4>Filters</h4>
     </div>
    <?php if ( function_exists( 'display_taxonomy_tree' ) ) 
        { $tree= display_taxonomy_tree('profession', 'company');
          
        
//            echo '<div class="nav-filter"><h4>Job Type</h4>';
//          $tree->display_category_type_options('job_type');
//          echo '</div>';
         
          //Profession Filter
           echo '<h3 class="filter-title"><i class="ico fa fa-crosshairs"></i> Profession</h3>';
           widgets_on_template("Profession Filter");
                  
         //Location Filter         
           echo '<h3 class="filter-title"><i class="ico fa fa-map-marker"></i> Location</h3>';
           widgets_on_template("Location Filter"); 
           
                    echo '<div class="nav-filter"><h3>Company</h3>'; 
                    $tree->display_tag_groups_b();
                    echo '</div>';
//          echo '<hr><h2>Location</h2>';
//          $tree->display_meta_group_select_box('location');
          
          echo '<div class="nav-filter"><h3>Provider</h3>';
          $tree->display_linked_taxonomy_hierarchy_list('provider', 'job-providers');
                  echo '</div>';


        }
    
    ?>
</div>

<?php 
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$args= array(
        'post_type'=>'work-experience-job',
    	'paged' => $paged,
        'orderby'=>'title',
        'order' => 'ASC'
);




query_posts( $args); ?>
	<div id="content"  category_type='work-experience-job' tag_type='profession' body_type="company" fn="group_filter">
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
$profession=$tree->grouped_taxonomy_name($post_id);
// get advert type
$job_type=types_render_field("graduate-job-type", array("output"=>"normal"));
//print company name, and image
$post_object_id = wp_get_post_terms($post_id, 'company', array("fields" => "ids"));
$group_parent_id= $tree->get_tag_group_leader($post_object_id[0]);
//get company name
$company_name= $tree->get_linked_taggroup_or_tag($post_id, $post_object_id, $group_parent_id); 
//get provider logo
$term_id = wp_get_post_terms($post_id, 'provider', array("fields" => "ids"));
if($term_id){
    $provider= s8_get_taxonomy_image_src(get_term_by('id', $term_id[0], 'provider'), 'small');
}
//location
$location=$tree->get_location($post_id);


?>               
                    
				<div id="post-<?php echo $post_id ?>" <?php post_class(); ?>>
                                    
                                    <div class="item">
                                        
                                        <div class="post_image">
                                            <br>
                                            <img style="position: relative; max-height:150px;" src="<?php echo $post_image?>"/> 
                                         </div>
                                        
				<h2 class="posttitle"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

                                	<?php wp_link_pages( array( 'before' => '<div class="page-link"><p>' . __( 'Pages: ', 'buddypress' ), 'after' => '</p></div>', 'next_or_number' => 'number' ) );?>
					<div class="entry">                                    
                                            <p><?php echo $company_name;?> | <?php echo $profession;?> | <?php echo $location?> | <?php echo $job_type;?></p>
                                        </div>
                                
                                        <div class="pop-out">
                                            <div class="datagrid">
                                            <table class="pop-out-tbl">
                                               <tr><td>Offered By: </td><td><?php echo $company_name;?></td></tr>
                                              <tr class="alt"><td>Profession: </td><td><?php echo $profession;?></td></tr>
                                               <tr><td>Location: </td><td><?php echo $location;?></td></tr>
                                               <tr class="alt"><td>Job Type: </td><td><?php echo $job_type;?></td></tr>
                                               
                                                <tr><td>Job Provider:</td><td><img style="float:left; position:relative; max-height:35px;" src="<?php echo $provider['src']?>"/></td></tr>
                                                <tr class="alt"><td>Job Snippet: </td><td><?php echo  the_content(); ?></td></tr>
                                            </table>
                                            </div>
                                            <?php
                                            echo replace_links('<a class="btn btn-success btn-large" href="'.(types_render_field("job-url", array("show_name"=>"true","raw"=>"true"))).'">Apply Now</a>'); 
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

   </div><!-- .page -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>

</div>