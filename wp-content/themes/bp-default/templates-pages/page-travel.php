<?php 
/*
 * Template Name: Travel (All)
 * 
 * A Page for courses
*/

include (TEMPLATEPATH . '/templates-headers/header-travel.php');
do_action('enable_isotopes');

?>
<div id="page-container">
    
<div id="sidebar-left">
 <div id="sidebar-toggle">
        <div id="toggle-icon">
            <button class="fa fa-chevron-right"></button>
        </div>

    </div>
    
    <div class="filter-tabs">
        <div class="filter-tab active-filter" id="filter-tab-1"><h4>Filters</h4></div>
        <div class="filter-tab" id="filter-tab-2"><h4>More Options</h4></div>
    </div>
    
    <?php if ( function_exists( 'display_taxonomy_tree' ) ) 
        {
          $tree= display_taxonomy_tree('destination', 'destination');

          //travel type filter
           echo '<div id="Type_Filter" class="filter-tab-1"><h4 class="filter-title">Travel Type</h4><br>';
          echo '<div class="page_widget">'.widgets_on_template("Travel Type Filter")."</div></div>";
        
          //destination filter
          echo '<div class="filter-tab-1">';
          echo '<h3 class="filter-title"><i class="ico fa fa-plane"></i> Destination</h3>';
           echo '<div class="page_widget">'.widgets_on_template("Destination Filter")."</div>";
           echo '</div>';
          
           echo '<div id="Provider_Filter" class="filter-tab-2"><h3 class="filter-title">Travel Agent</h3>';
          echo '<div class="page_widget">'.widgets_on_template("Travel Provider Filter")."</div></div>";
       }
  
    ?>
    <?php do_action('the_action_hook'); ?>

</div>


<?php 
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$args= array(
        'post_type'=>'travel-opportunities',
    	'paged' => $paged,
        'orderby' => 'date',
        'order' => 'DESC'
);

query_posts( $args); ?>

	<div id="content" class='main-content'  category_type='travel-opportunities' tag_type='destination' body_type="destination">
                                <div class='selected-travel-options'id='selected-options'>
                                    <div id="selected-options-container"></div>
                                  
                                    <div class="sort-by-container">
                                         <div class="order-by">
                                         <select id="sort-box">
                                        <option value="" disabled="disabled" selected="selected">Order By</option>
                                        <option value="title">Order By Title</option>
                                        <option value="date">Order By Date</option>
                                        </select>
                                         </div>
                                         <div class="sort-a-z">
                                             &nbsp; Sort:
                                         <button class="fa fa-sort-amount-desc sort-asc sort-button sort-active"></button>
                                         <button class="fa fa-sort-amount-asc sort-desc sort-button "></button>
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
$course_type=$tree->get_taxonomy_field($post_id, 'travel-type');
//print company name, and image

$ratings= show_ratings($post_id);
?>                            
				<div id="<?php echo $post_id; ?>" <?php post_class(); ?>>
                                    <div class="item">
    
                                          <div class="post_image">
                                            <img class="travel_post_image" src="<?php echo $post_image?>"/> 
                                         </div>

				<h2 class="posttitle"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

                                	<div class="entry">                                    
                                           <?php echo $subject;?> | <?php echo $course_type;?>
                                           <?php echo $ratings;?>     
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
       
        </div><!-- .padder -->
   </div><!-- .page -->

	<div class='sidebar-main'>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
</div>