 <?php   
  global $post;
//set up page variables
$post_id=$post->ID;
//post image
$post_image=$lg_tree->get_post_image('', $post_id); 
//subject/grouped taxonomy
$subject=$lg_tree->grouped_taxonomy_name($post_id);
//print company name, and image
$post_object_id = wp_get_post_terms($post_id, '', array("fields" => "ids"));
//$group_parent_id= $lg_tree->get_tag_group_leader($post_object_id[0]);
//get company name
$uni_name= $lg_tree->get_linked_taggroup_or_tag($post_id, $post_object_id, ''); 

$ratings= show_ratings($post_id);
?>                            

				<div id="<?php echo $post_id; ?>" <?php post_class(); ?>>
                                    <div class="item">
    
                                        <div class="post_image is-loading">
                                            <img class="course_post_image advert_image" src="<?php echo $post_image?>"> 
                                         </div>

				<h2 class="posttitle"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

                                	<div class="entry">                                    
                                          <span class="post-tag"><i class="ico fa fa-building"></i> <?php echo $uni_name;?></span>
                                          <span class="post-tag"><i class="ico fa fa-book"></i> <?php echo $subject;?></span>
                                           <?php echo $ratings;?>     
                                        </div>
                                
                                      <div class="pop-out"></div>  
                                <div class="clickme"></div><!--overlay -->
				</div><!--item-->

				</div>
