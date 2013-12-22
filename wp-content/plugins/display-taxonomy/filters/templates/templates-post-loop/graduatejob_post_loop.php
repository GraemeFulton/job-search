		<?php if (have_posts()) : while (have_posts()) : the_post();
                        $tree= display_taxonomy_tree('profession', 'company');
                        ?>
                    
<?php                    
//set up page variables
$post_id=get_the_ID();
//post image
$post_image=$tree->get_post_image($group_parent_id, $post_id); 
//subject/grouped taxonomy
$profession=$tree->grouped_taxonomy_name($post_id);
// get advert type
$job_type=types_render_field("graduate-job-type", array("output"=>"normal"));
//print company name, and image
$post_object_id = wp_get_post_terms($post_id, 'company', array("fields" => "ids"));
//get company name
$company_name= $tree->get_linked_taggroup_or_tag($post_id, $post_object_id, ''); 
//location
$location= wp_get_post_terms($post_id, 'location', array("fields" => "names"));
?>                                   
				<div id="<?php echo $post_id ?>" <?php post_class(); ?>>
                                    
                                    <div class="item">
                                        
                                        <div class="post_image">
                                            <br>
                                            <img style="position: relative; max-width:95%;" src="<?php echo $post_image?>"/> 
                                         </div>
                                        
				<h2 class="posttitle"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

                                	<?php wp_link_pages( array( 'before' => '<div class="page-link"><p>' . __( 'Pages: ', 'buddypress' ), 'after' => '</p></div>', 'next_or_number' => 'number' ) );?>
					<div class="entry">                                    
                                            <p><?php echo $company_name;?> | <?php echo $profession;?> | <?php echo $location[0]?> | <?php echo $job_type;?></p>
                                        </div>
                                
                                        <div class="pop-out"></div>
                                            <hr>                                     
					
                                            <div class="clickme"></div><!--overlay -->
				</div><!--item-->

				</div>

			<?php comments_template(); ?>

			<?php endwhile; endif; ?>
                                                        

                                
<?php do_action( 'bp_after_blog_page' ); ?>