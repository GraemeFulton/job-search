<!--course post loop template-->
	
<?php  
$tree= display_taxonomy_tree('subject', 'uni');
?>

			<?php if (have_posts()) : while (have_posts()) : the_post();
                            $post_id=get_the_ID();
                        ?>
                    
				<div id="post-<?php echo $post_id; ?>" <?php post_class(); ?>>
                                    <div class="item">
    
                                         <div class="post_image">
                                            <?php //print the image
                                            $tree->print_post_image($group_parent_id,$post_id);
                                            ?>
                                         </div>

				<h2 class="posttitle"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

					<div class="entry">

						<?php the_excerpt( __( '<p class="serif">Read the rest of this page &rarr;</p>', 'buddypress' ) ); ?>

						<?php wp_link_pages( array( 'before' => '<div class="page-link"><p>' . __( 'Pages: ', 'buddypress' ), 'after' => '</p></div>', 'next_or_number' => 'number' ) ); ?>
						
<?php //addition: course type field
$course_type = types_render_field("course-type", array("output"=>"normal"));

//Output the trainer email
 if($course_type)
printf("Course Type: %s ",$course_type);
  
 ////////////////NEW ADDITION 
  $object_id = wp_get_post_terms($post_id, 'uni', array("fields" => "ids"));
  
  $group_parent_id= $tree->get_tag_group_leader($object_id[0]);
  
  //print the group
  $tree->print_linked_taggroup_or_tag($post_id, $object_id, $group_parent_id);
   show_ratings($post_id);

 ?>     <?php// echo "<br> ";if(function_exists("kk_star_ratings")) : echo kk_star_ratings($post_id); endif; ?>

                                            <hr>                                     
                                                    <?php // edit_post_link( __( 'Edit this page.', 'buddypress' ), '<p class="edit-link">', '</p>'); ?>

					</div>
                                            <div class="clickme"></div><!--overlay -->
				</div><!--item-->

				</div>

			<?php comments_template(); ?>

			<?php endwhile; endif; ?>
                                                        

                                
<?php do_action( 'bp_after_blog_page' ); ?>