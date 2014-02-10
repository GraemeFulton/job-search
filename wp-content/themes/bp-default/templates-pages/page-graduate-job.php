<?php 
/*
 * Template Name: Graduate Jobs (All)
 * 
 * A Page for courses
*/

include (TEMPLATEPATH . '/templates-headers/header-graduate-job.php');
do_action('enable_isotopes');

?>
<div class="graduatejob-line mobile-menu"></div>


<div id="page-container" class="mobile-menu">
            
<div id="sidebar-left" class="mobile-menu-side">
    

    
    <div class="sidebar-options">
    
    <div class="filter-tabs">
        <div class="filter-tab active-filter" id="filter-tab-1"><h4>Filters</h4></div>
        <div class="filter-tab" id="filter-tab-2"><h4>More Options</h4></div>
    </div>
    <?php if ( function_exists( 'display_taxonomy_tree' ) ) 
        { $tree= display_taxonomy_tree('profession', 'company');
          
        
          echo '<div id="Type_Filter" class="filter-tab-1"><h4 class="filter-title">Job Type</h4><br>';
          echo '<div class="page_widget">'.widgets_on_template("Job Type Filter")."</div></div>";
         
          //Profession Filter
           echo '<div class="filter-tab-1">';
           echo '<h3 class="filter-title"><i class="ico fa fa-crosshairs"></i> Profession</h3>';
           echo '<div class="page_widget">'.widgets_on_template("Profession Filter")."</div>";
           echo '</div>';
         //Location Filter 
           echo '<div class="filter-tab-2">';
           echo '<h3 class="filter-title"><i class="ico fa fa-map-marker"></i> Location</h3>';
           echo '<div class="page_widget">'.widgets_on_template("Location Filter")."</div>";
           echo '</div>';

           //company filter
           echo '<div class="nav-filter filter-tab-2"><h3><i class="ico fa fa-building"></i> Company</h3>'; 
                    $tree->display_select2_box('Select Companies');
                    echo '</div>';

          echo '<div id="Provider_Filter" class="filter-tab-2"><h3 class="filter-title">Provider</h3>';
          echo '<div class="page_widget">'.widgets_on_template("Job Provider Filter")."</div></div>";
                //  echo '</div>';
       
        }
    
    ?>
</div>
</div>

<?php 
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$args= array(
        'post_type'=>'graduate-job',
    	'paged' => $paged,
        'orderby'=>'date',
        'order' => 'DESC'
);




query_posts( $args); ?>

	<div id="content"   class='main-content' category_type='graduate-job' tag_type='profession' body_type="company">
        <div class='selected-job-options'id='selected-options'>
                                  
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
                                        
                                         <div class="post_image is-loading">
                                            <img class="job_post_image advert_image" src="<?php echo $post_image?>"/> 
                                         </div>
                                        
				<h2 class="posttitle"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

                                	<?php wp_link_pages( array( 'before' => '<div class="page-link"><p>' . __( 'Pages: ', 'buddypress' ), 'after' => '</p></div>', 'next_or_number' => 'number' ) );?>
					<div class="entry">                                    
                                         <span class="post-tag"><i class="ico fa fa-building"></i> <?php echo $company_name;?></span> 
                                         <span class="post-tag"><i class="ico fa fa-crosshairs"></i> <?php echo $profession;?> </span>
                                         <span class="post-tag"><i class="ico fa fa-map-marker"></i> <?php echo $location[0]?></span>
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

             <div id="selected-options-container"class="selected-job-options">
        <h4 class="options-title"><i style="margin-top:-15px;"class="fa fa-search"></i> &nbsp;Selected: </h4><div class="clear_both"></div>
                                          <div id="nothing_selected">Nothing Selected. Please use the filters available on the left to find what you want.</div>
    </div>
             
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>

</div>