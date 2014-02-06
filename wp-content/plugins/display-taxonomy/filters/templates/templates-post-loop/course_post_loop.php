			<?php if (have_posts()) : while (have_posts()) : the_post();
                        $tree= display_taxonomy_tree('subject', 'uni');
                        ?>
                    
<?php                    
//set up page variables
$post_id=get_the_ID();
//post image
$post_image=$tree->get_post_image($group_parent_id, $post_id); 
//subject/grouped taxonomy
$subject=$tree->grouped_taxonomy_name($post_id);
// get advert type
$course_type=types_render_field("course-type", array("output"=>"normal"));
//print company name, and image
$post_object_id = wp_get_post_terms($post_id, 'uni', array("fields" => "ids"));
//$group_parent_id= $tree->get_tag_group_leader($post_object_id[0]);
//get company name
$uni_name= $tree->get_linked_taggroup_or_tag($post_id, $post_object_id, $group_parent_id); 

$ratings= show_ratings($post_id);
?>                            
				<div id="<?php echo $post_id; ?>" <?php post_class(); ?>>
                                    <div class="item">
    
                                         <div class="post_image post_image_<?php echo $post_id?> is-loading">
                                            <img class="course_post_image advert_image" src=""/> 
                                         </div>

				<h2 class="posttitle"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

                                	<div class="entry">                                    
                                       <i class="ico fa fa-building"></i> <?php echo $uni_name;?> <br>
                                          <i class="ico fa fa-book"></i> <?php echo $subject;?>
                                           <?php// echo $ratings;?>      
                                        </div>
                                
                                      <div class="pop-out"></div>  
                                <div class="clickme"></div><!--overlay -->
				</div><!--item-->

				</div>

			<?php comments_template(); ?>

			<?php endwhile; endif; ?>
                                                
<?php do_action( 'bp_after_blog_page' ); ?>