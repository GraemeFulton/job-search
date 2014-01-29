<?php 
/*
 * Template Name: Courses (All)
 * 
 * A Page for courses
*/

get_header();
do_action('enable_isotopes');

?>
<div id="page-container">
    
    
<div id="sidebar-left">
    <div class="filter-header">
    <h4>Blog Posts</h4>
    </div>
    		<a href="<?php echo site_url();?>/new-post"<button class="btn btn-success">Add New Post</button></a>
    
    <?php 
     //Subject Filter
          echo '<div class="filter-tab-1">';
          echo '<h3 class="filter-title"><i class="ico fa fa-book"></i> Category</h3>';
          echo '<div class="page_widget">'.widgets_on_template("Category Filter")."</div>";
          echo '</div>';
    ?>
</div>


<?php 
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$args= array(
    	'paged' => $paged,
        'orderby' => 'date',
        'order' => 'DESC'
);

query_posts( $args); ?>
	<div id="content"  class='main-content'>
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

		<div class="page" id="blog-page-standard" role="main">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <?php                    
//set up page variables
$post_id=$post->ID;

$ratings= show_ratings($post_id);
?>                            

	<div id="<?php echo $post_id; ?>" <?php post_class(); ?>>
          <div class="item">
              		<?php $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );?>
          <?php if($url){?>
    			<div class="post_image">
    			<div class="course_post_image">
<img src="<?php echo $url; ?>" longdesc="URL_2" alt="Text_2" />
    			</div>
                 </div>
<?php }?>
			<h2 class="posttitle"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

            <div class="entry">     
             <?php if(has_excerpt( $post_id ))the_excerpt(); ?> 
<div class="author-box">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), '50' ); ?>
						<p><?php printf( _x( 'by %s', 'Post written by...', 'buddypress' ), str_replace( '<a href=', '<a rel="author" href=', bp_core_get_userlink( $post->post_author ) ) ); ?></p>
					</div>
           <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?> <?php the_title_attribute(); ?>"><button class="btn btn-success">Read More</button></a>
            
		    </div>
                                
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

  <script>
        var $container = jQuery('.main-content');
    
        // initialize isotope
        $container.isotope({
        	getSortData : {
        	    order : function ( $elem ) {
        	      return $elem.find('.order').text();
        	    }
        	  },
         // options...
          itemSelector: '.post',
          sortBy : 'order' 
        });
        </script>
