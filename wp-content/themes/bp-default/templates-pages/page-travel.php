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
     <div class="filter-header">
    <h4>Filter</h4>
    </div>
    
    <?php if ( function_exists( 'display_taxonomy_tree' ) ) 
        {
          $tree= display_taxonomy_tree('destination', 'destination');

           echo '<div id="Type_Filter"><h4 class="filter-title">Travel Type</h4><br>';
          echo '<div class="page_widget">'.widgets_on_template("Travel Type Filter")."</div></div>";
        
          echo '<h3 class="filter-title"><i class="ico fa fa-plane"></i> Destination</h3>';
           echo '<div class="page_widget">'.widgets_on_template("Destination Filter")."</div>";
          
           echo '<div id="Provider_Filter"><h3 class="filter-title">Travel Agent</h3>';
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
        'orderby' => 'title',
        'order' => 'ASC'
);

query_posts( $args); ?>
                <div class='selected-travel-options'id='selected-options'></div>

	<div id="content" class='main-content'  category_type='travel-opportunities' tag_type='destination' body_type="destination">
                        
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