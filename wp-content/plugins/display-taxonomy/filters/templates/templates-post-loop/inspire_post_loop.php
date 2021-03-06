<?php if (have_posts()) : while (have_posts()) : the_post();
                                              $tree= display_taxonomy_tree('topic', 'inspire-tag');

//set up page variables
$post_id=get_the_ID();
//subject/grouped taxonomy
$subject=$tree->grouped_taxonomy_name($post_id);
?>	<div id="<?php echo $post_id; ?>" <?php post_class(); ?>>
                        <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?> <?php the_title_attribute(); ?>">

          <div class="item">
              		<?php $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );?>
          <?php if($url){?>
    			     <div class="post_image post_image_<?php echo $post_id?> is-loading">
                                            <img class="inspire_post_image advert_image" src=""/> 
                                         </div>
<?php }?>
			<h2 class="posttitle"><?php the_title(); ?></h2>

            <div class="entry">     
               <?php if(has_excerpt( $post_id ))the_excerpt(); ?> 
                <div class="read_more_btn"> <button class="btn btn-success">Read More</button>
                </div>
                <span class="inspire-cat-tag"> <?php echo '<i class="fa fa-lightbulb-o fa-2x"></i>&nbsp; '.$subject?></span>               
            </div>
                                 
        </div><!--item-->

	</div>
<?php comments_template(); ?>
<?php endwhile; endif; ?>
<?php do_action( 'bp_after_blog_page' ); ?>
