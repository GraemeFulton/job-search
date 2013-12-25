<?php 
/*
 * Template Name: Graduate Jobs (All)
 * 
 * A Page for courses
*/

include (TEMPLATEPATH . '/templates-headers/header-graduate-job.php');
do_action('enable_isotopes');

?>

<div id="page-container">

<div id="sidebar-left">
    <div class="filter-header">
     <h4>Filters</h4>
     </div>
    <?php if ( function_exists( 'display_taxonomy_tree' ) ) 
        { $tree= display_taxonomy_tree('profession', 'company');
          
        
              echo '<div id="Type_Filter"><h4 class="filter-title">Job Type</h4>';
          echo '<div class="page_widget">'.widgets_on_template("Job Type Filter")."</div></div>";
         
          //Profession Filter
           echo '<h3 class="filter-title"><i class="ico fa fa-crosshairs"></i> Profession</h3>';
           echo '<div class="page_widget">'.widgets_on_template("Profession Filter")."</div>";
                  
         //Location Filter         
           echo '<h3 class="filter-title"><i class="ico fa fa-map-marker"></i> Location</h3>';
           echo '<div class="page_widget">'.widgets_on_template("Location Filter")."</div>"; 
           
            echo '<div class="nav-filter"><h3><i class="ico fa fa-building"></i> Company</h3>'; 
                    $tree->display_select2_box('Select Companies');
                    echo '</div>';

          echo '<div id="Provider_Filter"><h3 class="filter-title">Provider</h3>';
          echo '<div class="page_widget">'.widgets_on_template("Job Provider Filter")."</div></div>";
                //  echo '</div>';
       
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
        <div class='selected-job-options'id='selected-options'></div>

	<div id="content"   class='main-content' category_type='graduate-job' tag_type='profession' body_type="company">

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
//get company name
$company_name= $tree->get_linked_taggroup_or_tag($post_id, $post_object_id, ''); 
//location
$location= wp_get_post_terms($post_id, 'location', array("fields" => "names"));
?>                                   
				<div id="<?php echo $post_id ?>" <?php post_class(); ?>>
                                    
                                    <div class="item">
                                        
                                        <div class="post_image">
                                            <br>
                                            <img style="position: relative; max-width:95%;" src="<?php echo $post_image?>"/> 
                                         </div>
                                        
				<h2 class="posttitle"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

                                	<?php wp_link_pages( array( 'before' => '<div class="page-link"><p>' . __( 'Pages: ', 'buddypress' ), 'after' => '</p></div>', 'next_or_number' => 'number' ) );?>
					<div class="entry">                                    
                                            <p><?php echo $company_name;?> | <?php echo $profession;?> | <?php echo $location[0]?> | <?php echo $job_type;?></p>
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