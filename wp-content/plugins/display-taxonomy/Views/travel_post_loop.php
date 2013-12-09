<!--travel post loop template-->
	
<?php  
if (!have_posts()){echo '<h2 class="hentry no-more" style="width:100%"><br><br> Hey, we don&apos;t have any travel opportunities matching this criteria at the moment, please try a different filter.</h2>';
return;
}
?>
	<?php if (have_posts()) : while (have_posts()) : the_post();
             $tree= display_taxonomy_tree('destination', 'destination');?>
  <?php                    
//set up page variables
$post_id=get_the_ID;
//post image
$post_image=$tree->get_post_image($group_parent_id, $post_id); 
//subject/grouped taxonomy
$subject=$tree->grouped_taxonomy_name($post_id);
// get advert type
$course_type=types_render_field("travel-type", array("output"=>"normal"));
//print company name, and image
$post_object_id = wp_get_post_terms($post_id, 'company', array("fields" => "ids"));
$group_parent_id= $tree->get_tag_group_leader($post_object_id[0]);
//get provider logo
$term_id = wp_get_post_terms($post_id, 'provider', array("fields" => "ids"));
if($term_id){
    $provider= s8_get_taxonomy_image_src(get_term_by('id', $term_id[0], 'provider'), 'small');
}
$ratings= show_ratings($post_id);
?>                            

				<div id="post-<?php echo $post_id; ?>" <?php post_class(); ?>>
                                    <div class="item">
    
                                          <div class="post_image">
                                            <img style="position: relative; max-height:280px;" src="<?php echo $post_image?>"/> 
                                         </div>

				<h2 class="posttitle"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

                                	<div class="entry">                                    
                                           <?php echo $uni_name;?> | <?php echo $subject;?> | <?php echo $course_type;?>
                                           <?php echo $ratings;?>     
                                        </div>
                                
                                      <div class="pop-out">
                                            <div class="datagrid">
                                            <table class="pop-out-tbl">
                                              <tr><td>Destination: </td><td><?php echo $subject;?></td></tr>
                                               <tr class="alt"><td>Travel Type: </td><td><?php echo $course_type;?></td></tr>
                                               
                                                <tr><td>Travel Agent:</td><td><img style="float:left; position:relative; max-height:35px; max-width:80px;" src="<?php echo $provider['src']?>"/></td></tr>
                                                <tr class="alt"><td>Excerpt: </td><td><?php echo  the_excerpt( __( '<p class="serif">Read the rest of this page &rarr;</p>', 'buddypress' ) ); ?></td></tr>
                                                <tr><td>Rating: </td><td>  <?php echo $ratings;?> </td></tr>
                                            </table>
                                            </div>
                                            <?php
                                            echo replace_links('<a class="btn btn-success btn-large" href="'.(types_render_field("travel-url", array("show_name"=>"true","raw"=>"true"))).'">Read More</a>'); 
                                            ?>
                                        </div>  
                                <hr>
                                <div class="clickme"></div><!--overlay -->
				</div><!--item-->

				</div>

			<?php comments_template(); ?>

			<?php endwhile; endif; ?>
                                                        

                                
<?php do_action( 'bp_after_blog_page' ); ?>