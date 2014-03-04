<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php
//set up page variables
$post_id=get_the_ID();

$ratings= show_ratings($post_id);
?>
	<div id="<?php echo $post_id; ?>" <?php post_class(); ?>>
         <div class="item">
           		<?php $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );?>
          <?php if($url){?>
    		           <div class="post_image post_image_<?php echo $post_id?> is-loading">
                                            <img class="course_post_image advert_image" src=""/>
                                         </div>
<?php }?><h2 class="posttitle"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

            <div class="entry">     
             <?php if(has_excerpt( $post_id ))the_excerpt(); ?>
<div class="author-box">
	<?php echo get_avatar( get_the_author_meta( 'user_email' ), '50' ); ?>
</div>
           <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?> <?php the_title_attribute(); ?>"><button class="btn btn-success">Read More</button></a>
            
		    </div>
                                
        </div><!--item-->

	</div>
<?php comments_template(); ?>
<?php endwhile; endif; ?>
<?php do_action( 'bp_after_blog_page' ); ?>
