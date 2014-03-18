<?php
/**
 * Template Name: Front Page LG
 */
?>
<?php get_header(); ?>

	<!--slider-->	
        <div style="margin-bottom:42px;margin-top:10px;">
      	<?php putRevSlider( "homepage" ) ?>           
        </div>

		<div class="center" id="front-page-carousels-preloader">
			<img src="<?php echo get_template_directory_uri(); ?>/images/bx_loader.gif" alt="<?php _e( 'Loading...','klein' ); ?>" />
		</div>
		<div id="front-page-carousels" class="row">	
	<!--highlights-->
		
		<div id="front-page-highlights">
			
			<div class="clearfix home-highlights col-md-12">
				<div id="highlights">
				<?php 
					$highlights_category = get_category( ot_get_option( 'highlights_category', '0' ) );
					if( !empty( $highlights_category ) ){
						$highlights_category = $highlights_category->slug;
					}else{
						$highlights_category = 'highlights';
					}
					$args = array(
						'post_type'=>array('course', 'travel-opportunities', 'inspire-posts'),
                                                'orderby' => 'rand'
					);
				?>
				<?php query_posts( $args ); 

$tree= display_taxonomy_tree('course', 'university');

// begin query ?>
					<?php //begin loop for highlights content ?>
					<?php if( have_posts() ){ 
                                            ?>
						<?php while( have_posts() ){ ?>
							<?php the_post();
                                                        global $post;
                                                        $post_id=$post->ID;
//post image
$post_image=$tree->get_post_image($post_id); ?>
							<div class="slide klein-carousel">
								<a title="<?php echo esc_attr( the_title() ); ?>" href="<?php echo esc_url( the_permalink() ); ?>">
                                            <img class="carousel-img" src="<?php echo $post_image?>"/> 
								</a>
								<div class="font-page-highlights-content">
									
									<div class="front-page-highlights-detail">
										<h3>
											<a title="<?php echo esc_attr( the_title() ); ?>" href="<?php echo esc_url( the_permalink() ); ?>">
												<?php the_title(); ?>
											</a>
										</h3>
										<p>
											<a class="btn btn-primary btn-sm" title="<?php echo esc_attr( the_title() ); ?>" href="<?php echo esc_url( the_permalink() ); ?>">
												<?php _e( 'Read More','klein' ); ?>
											</a>
										</p>
									</div>
								</div>
							</div>
						<?php } // end while ?>
					<?php } ?>
				<?php wp_reset_query(); //reset the query ?>

				</div>
			</div>
			
			<div id="front-page-highlights-nav" class="clearfix col-md-12 break-row-bottom">
				<div class="pull-right">
					<div id="front-page-highlights-prev"></div>
					<div id="front-page-highlights-next"></div>
				</div>	
			</div>
			
		</div>
	<!--highlights end-->
	</div><!-- end #front-page-carousels-->
	<!--teaser-->
	<div id="front-page-teaser">
		<?php the_content(); ?>
	</div>
	<!--teaser end-->
	<!-- widgets area-->
	<div class="row" id="front-page-widgets">
		<!--left widget area, eight columns-->
			<div id="front-page-widgets-section-a" class="col-md-4">
				<?php dynamic_sidebar( 'front-page-sidebar-a'); ?>
			</div>
		<!--left widget area, eight columns end-->
		
		<!--right widget area, eight columns, 2 columns-->
			
		<!--right widget area (left), 4 columns-->
		<div id="front-page-widgets-section-b" class="col-md-4">
			<?php dynamic_sidebar( 'front-page-sidebar-b' ); ?>
		</div>
			<!--right widget area (left), 4 columns end-->
		
		<!--right widget area (right), 4 columns-->
		<div id="front-page-widgets-section-c" class="col-md-4">
			<?php dynamic_sidebar( 'front-page-sidebar-c' ); ?>
		</div>
		<!--right widget area (right), 4 columns end-->
		
			
	<!--right widget area, eight columns end-->
	</div>
	<!-- widgets area end -->
<?php get_footer(); ?>