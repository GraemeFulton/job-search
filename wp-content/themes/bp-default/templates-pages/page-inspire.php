<?php 
/*
 * Template Name: Inspire
 * 
 * A Page for inspire
*/

include (TEMPLATEPATH . '/templates-headers/header-inspire.php');
do_action('enable_isotopes');
?>
<div id="page-container" class="blog-page-container">
    
    
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
    
    <?php 
     //Category Filter
          echo '<div class="filter-tab-1">';
          echo '<h3 class="filter-title"><i class="ico fa fa-lightbulb-o"></i> &nbsp;Topics</h3><br>';
          echo '<div class="page_widget">'.widgets_on_template("Topic Filter")."</div>";
          echo '</div>';

 echo '<div class="nav-filter filter-tab-2" ><h3><i class="ico fa fa-tags"></i> Tags</h3>'; 
          $tree->display_select2_box('Select Tags');
          echo '</div>';  
          
                    
          echo '<div class="filter-tab-2">';
          echo '<div class="page_widget">More Options Coming Soon!</div></div>';
                  
          ?>
    
    
</div>


<?php 
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$args= array(
        'post_type'=>'inspire-posts',
    	'paged' => $paged,
        'orderby' => 'date',
        'order' => 'DESC'
);

query_posts( $args); ?>
	<div id="content"  class='main-content' category_type='inspire-posts' tag_type='topic' body_type="inspire-tag">
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
$post_id=get_the_ID();
//subject/grouped taxonomy
$subject=$tree->grouped_taxonomy_name($post_id);
?>                            

	<div id="<?php echo $post_id; ?>" <?php post_class(); ?>>
          <div class="item">
              		<?php $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );?>
          <?php if($url){?>
    			<div class="post_image is-loading">
                                            <img class="inspire_post_image advert_image" src="<?php echo $url?>"/> 
                 </div>
<?php }?>
			<h2 class="posttitle"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

            <div class="entry">     
             <?php if(has_excerpt( $post_id ))the_excerpt(); ?> 
                <div class="read_more_btn"> <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?> <?php the_title_attribute(); ?>"><button class="btn btn-success">Read More</button></a>
                </div>
                <span class="inspire-cat-tag"> <?php echo '<i class="fa fa-lightbulb-o fa-2x"></i>&nbsp; '.$subject?></span>               
              
            
		    </div>
                                 
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

    <div id="selected-options-container"class="selected-blog-options">
        <h4 class="options-title"><i style="margin-top:-15px;"class="fa fa-search"></i> &nbsp;Selected: </h4><div class="clear_both"></div>
                                          <div id="nothing_selected">Nothing Selected. Please use the filters available on the left to find what you want.</div>
    </div>
       
       
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
</div>
