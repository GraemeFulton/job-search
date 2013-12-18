
	<?php if (have_posts()) : while (have_posts()) : the_post();
             $tree= display_taxonomy_tree('destination', 'destination');?>
   <?php                    
//set up page variables
$post_id=get_the_ID();
//post image
$post_image=$tree->get_post_image($group_parent_id, $post_id); 
//subject/grouped taxonomy
$subject=$tree->grouped_taxonomy_name($post_id);
// get advert type
$course_type=types_render_field("travel-type", array("output"=>"normal"));
//print company name, and image

//get provider logo
$term_id = wp_get_post_terms($post_id, 'provider', array("fields" => "ids"));
$provider_name= wp_get_post_terms($post_id, 'provider', array("fields" => "names"));

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
                                           <?php echo $provider_name[0];?> | <?php echo $subject;?> | <?php echo $course_type;?>
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