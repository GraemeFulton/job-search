     <?php 	
     global $paged;
      
     $start_second_loop = false;
     $current_post_number=-1;
      
     //First do the primary loop to grab the first few
     if ( $wp_query->have_posts() ) : 
     if($paged==1){
     echo '<div class="container"><h3>Found '.$found.' jobs in your preferred location</h3></div>';
     }
			// Do we have any posts/pages in the databse that match our query?
			?>
				<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
				// If we have a page to show, start a loop that will display it
				
				//include a few from the main job results
				include('partials/primary-job-loop.php');
				
				//echo $paged;
				if($paged==2){
					$current_post_number=$wp_query->current_post+4+1;
				}
				elseif($paged>2){
					$current_post_number=$wp_query->current_post+4+(6*($paged-2))+1;
				}
				else{
					$current_post_number=$wp_query->current_post+1;
				}

					if ($current_post_number == $found) :
					// I'm the last post in the Loop
					$start_second_loop=true;
					?>
					<h2>Here's some more!</h2>					
					<?php 
					endif;
				?>
				
				
				<?php endwhile; // OK, let's stop the page loop once we've displayed it 
					endif; 
					
					if ($current_post_number == -1){
					// I'm the last post in the Loop
					$start_second_loop=true;
					}
					?>

     <?php 
     if($start_second_loop==true){
      
     	include('partials/secondary-job-loop.php');
			
     }?>			
			
 <?php if (!is_user_logged_in() && $paged==1){  ?>

      <?php echo get_next_posts_link( '<p class="sign-up-next-link"><div class="container text-center sign-up-next"><h4>Show me more!</h4></div></p>', $qp->max_num_pages ); // display older posts link ?>


 <?php }else{ ?>
 
        <div class="container paginating">
	        <div class="col-sm-2">
	        <?php previous_posts_link('<div class="pull-left pagi-button"> Previous</div>'); ?>
	        </div>
	        <div class="col-sm-8 page-navi mobile-hide desktop-show">
	         <?php wp_pagenavi(); ?>
	         </div>
	         <div class="col-sm-2">
			<?php next_posts_link( '<div class="pull-right pagi-button">Next</div>'); ?>
			</div>
			<div class="mobile-show">
			<?php wp_pagenavi_dropdown();?>
			</div>
        </div>

        
       
 <?php } ?>