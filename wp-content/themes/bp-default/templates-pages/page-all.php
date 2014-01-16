<?php 
/*
 * Template Name: Home Page
 * 
 * A Page for courses
*/

get_header();
?>

<div id="page-container">

	<div id="home-content" class='home-content'>

		<div class="padder">

		<?php do_action( 'bp_before_blog_page' ); ?>

		<div class="page" role="main">
                        
<?php 
$post_types=['course', 'graduate-job', 'work-experience-job', 'travel-opportunities'];

foreach($post_types as $type){
	
echo '<div class="home-content home-content-'.$type.'">';

$args= array(
        'post_type'=>array($type),
    	'paged' => $paged,
        'orderby'=>'rand',
        'order' => 'DESC',
		'posts_per_page'=>'20'
);

?>
	<div class="hentry post-head">
                                    
             <h1><?php echo $type;?></h1>

				</div>
<?php 

shuffle(query_posts( $args)); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); 

$post_image= get_the_image($post->ID);

?>
		<div id="<?php echo $post_id ?>" <?php post_class(); ?>>
                                    
              <div class="home_item hentry"data-category="<?php echo $type;?>">
                                        
                       <img class="home_post_image" src="<?php echo $post_image?>"/> 
                       	<h2 class="home-posttitle"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                                                              				
                                					
				</div><!--item-->

				</div>
			
<?php endwhile; endif; 
echo '</div>';
}?>
		                 

                               	
	</div><!-- #content -->
        
       
        </div><!-- .padder -->
   </div><!-- #content -->

<!-- 	 <div class='sidebar-main'> -->
	<?php //get_sidebar(); ?>
<!-- </div> -->
<?php get_footer(); ?>

</div>
   <script> 
         var $container = jQuery('.home-content');
    
         // initialize isotope
         $container.isotope({
         	getSortData : {
         	    order : function ( $elem ) {
         	      return $elem.find('.order').text();
         	    }
         	  },
          // options...
           itemSelector: '.hentry',
           sortBy : 'order' 
         });
        </script>