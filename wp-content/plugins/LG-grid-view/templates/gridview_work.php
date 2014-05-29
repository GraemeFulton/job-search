<?php         
global $post;
//set up page variables
$post_id=$post->ID;

        
//post image
$post_image=$lg_tree->get_post_image('', $post_id); 
//subject/grouped taxonomy
$profession=$lg_tree->grouped_taxonomy_name($post_id);
//print company name, and image
$post_object_id = wp_get_post_terms($post_id, 'company', array("fields" => "ids"));
//get company name
$company_name= $lg_tree->get_linked_taggroup_or_tag($post_id, $post_object_id, ''); 
//location
$location= wp_get_post_terms($post_id, 'location', array("fields" => "names"));
?>                                   
				<div id="<?php echo $post_id ?>" <?php post_class(); ?>>
                                    
                                    <div class="item">
      <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?> <?php the_title_attribute(); ?>">
                                    
                                         <div class="post_image is-loading">
                                            <img class="job_post_image advert_image" src="<?php echo $post_image?>"/> 
                                         </div>
                                        
				<h2 class="posttitle"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

                                	<?php wp_link_pages( array( 'before' => '<div class="page-link"><p>' . __( 'Pages: ', 'buddypress' ), 'after' => '</p></div>', 'next_or_number' => 'number' ) );?>
					<div class="entry">                                    
                                         <span class="post-tag"><i class="ico fa fa-building"></i> <?php echo $company_name;?></span> 
                                         <span class="post-tag"><i class="ico fa fa-crosshairs"></i> <?php echo $profession;?> </span>
                                         <span class="post-tag"><i class="ico fa fa-map-marker"></i> <?php echo $location[0]?></span>
                                        </div>
                                
                                        <div class="pop-out"></div>
					
				</div><!--item-->
</a>
				</div>
