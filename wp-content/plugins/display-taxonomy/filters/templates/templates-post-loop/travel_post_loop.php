<?php if (have_posts()) : while (have_posts()) : the_post();

  $tree= display_taxonomy_tree('destination', 'destination');
//set up page variables
$post_id=get_the_ID();
//post image
$post_image=$tree->get_post_image($group_parent_id, $post_id);
//subject/grouped taxonomy
$subject=$tree->grouped_taxonomy_name($post_id);
// get advert type
$course_type=$tree->get_taxonomy_field($post_id, 'travel-type');
//print company name, and image

$ratings= show_ratings($post_id);
?>
				<div id="<?php echo $post_id; ?>" <?php post_class(); ?>>
                                    <div class="item">
  <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?> <?php the_title_attribute(); ?>">

                                              <div class="post_image post_image_<?php echo $post_id?> is-loading">
                                            <img class="travel_post_image advert_image" src=""/> 
                                         </div>

				<h2 class="posttitle"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

                                	<div class="entry">                                    
                                           <?php echo $subject;?> | <?php echo $course_type;?>
                                           <?php echo $ratings;?>
                                        </div>
                                
                                      <div class="pop-out"></div>  
				</div><!--item-->
</a>
				</div>
			<?php comments_template(); ?>
	<?php endwhile; endif; ?>
<?php do_action( 'bp_after_blog_page' ); ?>
