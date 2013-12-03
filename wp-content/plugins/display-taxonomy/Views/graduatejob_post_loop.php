<!--course post loop template-->
	
<?php  
if (!have_posts()){echo '<h2 class="hentry no-more" style="width:100%"><br><br> Hey, we don&apos;t have any jobs matching this criteria at the moment, we&apos;re working to add more!</h2>';
return;
}
?>

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
$group_parent_id= $tree->get_tag_group_leader($post_object_id[0]);
//get company name
$company_name= $tree->get_linked_taggroup_or_tag($post_id, $post_object_id, $group_parent_id); 
//get provider logo
$term_id = wp_get_post_terms($post_id, 'provider', array("fields" => "ids"));
if($term_id){
    $provider= s8_get_taxonomy_image_src(get_term_by('id', $term_id[0], 'provider'), 'small');
}
//location
$location=$tree->get_location($post_id);


?>               
                    
				<div id="post-<?php echo $post_id ?>" <?php post_class(); ?>>
                                    
                                    <div class="item">
                                        
                                        <div class="post_image">
                                            <br>
                                            <img style="position: relative; max-height:150px;" src="<?php echo $post_image?>"/> 
                                         </div>
                                        
				<h2 class="posttitle"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

                                	<?php wp_link_pages( array( 'before' => '<div class="page-link"><p>' . __( 'Pages: ', 'buddypress' ), 'after' => '</p></div>', 'next_or_number' => 'number' ) );?>
					<div class="entry">                                    
                                            <p><?php echo $company_name;?> | <?php echo $profession;?> | <?php echo $location?> | <?php echo $job_type;?></p>
                                        </div>
                                
                                        <div class="pop-out">
                                            <div class="datagrid">
                                            <table class="pop-out-tbl">
                                               <tr><td>Offered By: </td><td><?php echo $company_name;?></td></tr>
                                              <tr class="alt"><td>Profession: </td><td><?php echo $profession;?></td></tr>
                                               <tr><td>Location: </td><td><?php echo $location;?></td></tr>
                                               <tr class="alt"><td>Job Type: </td><td><?php echo $job_type;?></td></tr>
                                               
                                                <tr><td>Job Provider:</td><td><img style="float:left; position:relative; max-height:35px;" src="<?php echo $provider['src']?>"/></td></tr>
                                                <tr class="alt"><td>Job Snippet: </td><td><?php echo  the_content(); ?></td></tr>
                                            </table>
                                            </div>
                                            <?php
                                            echo replace_links('<a class="btn btn-success btn-large" href="'.(types_render_field("job-url", array("show_name"=>"true","raw"=>"true"))).'">Apply Now</a>'); 
                                            ?>
                                        </div>
                                            <hr>                                     
					
                                            <div class="clickme"></div><!--overlay -->
				</div><!--item-->

				</div>

			<?php comments_template(); ?>

			<?php endwhile; endif; ?>
                                                        

                                
<?php do_action( 'bp_after_blog_page' ); ?>