<?php
/**
 * Template Name: Front Page (Slider Revolution)
 */
?>
<?php get_header(); ?>

	<!--slider-->		
		<?php 
			$featured_category = get_category( ot_get_option( 'featured_category', '0' ) );
			if( !empty( $featured_category ) ){
				$featured_category = $featured_category->slug;
			}else{
				$featured_category = 'featured';
			}
		
		?>
		<?php		
			$args = array(
				'category_name' => $featured_category
			);
		?>
		<div class="center" id="front-page-carousels-preloader">
			<img src="<?php echo get_template_directory_uri(); ?>/images/bx_loader.gif" alt="<?php _e( 'Loading...','klein' ); ?>" />
		</div>
		<div id="front-page-carousels">
	
	
	<!--highlights-->
		
		<div class="row" id="front-page-highlights">
			
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
						'category_name' => $highlights_category
					);
				?>
				<?php query_posts( $args ); // begin query ?>
					<?php //begin loop for highlights content ?>
					<?php if( have_posts() ){ ?>
						<?php while( have_posts() ){ ?>
							<?php the_post(); ?>
							<?php if( has_post_thumbnail() ){ ?>
							<div class="slide klein-carousel">
								<a title="<?php echo esc_attr( the_title() ); ?>" href="<?php echo esc_url( the_permalink() ); ?>">
									<?php the_post_thumbnail( 'klein-thumbnail' ); ?>
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
							<?php } ?>
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
	<?php $page_content = get_the_content(); ?>
	<?php if( !empty ( $page_content ) ){ ?>
		<div class="clearfix" id="front-page-teaser">
			<?php echo $page_content; ?>
		</div>
	<?php } ?>
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
	<!-- widgets area end -->
<?php get_footer(); ?>