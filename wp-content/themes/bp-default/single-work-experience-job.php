<?php get_header(); ?>
    <div class="workexperience-line mobile-menu"></div>

<div class='single-container mobile-menu'>
    
	<div id="content" class='single-content'>
		<div class="padder"> 

			<?php do_action( 'bp_before_blog_single_post' ); ?>

			<div class="page" id="blog-single" role="main">

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					
                                    <span class="post-utility alignright"><?php edit_post_link( __( 'Edit this entry', 'buddypress' ) ); ?></span>

                                    <h2 class="posttitle"><?php the_title(); ?></h2><br>

                                    <?php the_content( __(  ) );?>
                                    
                                    <?php  $post_id= get_the_ID();
                                            $popup= new Popup_Filter($post_id, 'work-experience-job', 'profession', 'company');
                                            $popup->template_response(true);
                                            ?>
					<div class="alignleft"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'buddypress' ) . '</span> %title' ); ?></div>
						<div class="alignright"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'buddypress' ) . '</span>' ); ?></div>
					

				</div>
                            

			<?php comments_template(); ?>


		</div>

		<?php do_action( 'bp_after_blog_single_post' ); ?>

		</div><!-- .padder -->
	</div><!-- #content -->

         <div id="item-nav" class="mobile-menu-side">
        <div class='sidebar-single sidebar-mobile-shown'>
	<?php get_sidebar(); ?>
            </div>
            </div>
</div>
<?php get_footer(); ?>