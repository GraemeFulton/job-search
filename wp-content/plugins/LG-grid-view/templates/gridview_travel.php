  <?php           
       
  global $post;
//set up page variables
$post_id=$post->ID;
//post image
$post_image=$lg_tree->get_post_image($group_parent_id, $post_id); 
//subject/grouped taxonomy
$subject=$lg_tree->grouped_taxonomy_name($post_id);
// get advert type
$course_type=$lg_tree->get_taxonomy_field($post_id, 'travel-type');
//print company name, and image

$ratings= show_ratings($post_id);
?>                            
				<div id="<?php echo $post_id; ?>" <?php post_class(); ?>>
                                    <div class="item">
    
                                        <div class="post_image is-loading">
                                            <img class="travel_post_image advert_image" src="<?php echo $post_image?>"/> 
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
