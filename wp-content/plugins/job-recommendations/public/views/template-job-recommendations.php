<section class='col-md-9 col-xs-12'>    
    
 <?php 	 if ( $wp_query->have_posts() ) : 
			// Do we have any posts/pages in the databse that match our query?

      ?>    
   <?php 
    if($paged==1){
    	echo '<h3><i class="material-icons icon-large">thumb_up</i> Found '.$found.' jobs for you</h3>';
    }
    ?>
    <section class="container list-container">
    <?php 
        global $wp_query;
        if ($paged==0){ 
        	$paged=1;
     	 }
        
         echo '<div class="pagi-top"><p>Page <span class="page-num">'.$paged.' of '.$wp_query->max_num_pages.'</span>'.$message.'</p>';?>
               <?php include('partials/selections-tags.php') ;
               echo '</div>';
                ?>

				<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
				// If we have a page to show, start a loop that will display it
				include('partials/primary-job-loop.php');
                                
				?>
				
				<?php endwhile; // OK, let's stop the page loop once we've displayed it ?>

			<?php else : // Well, if there are no posts to display and loop through, let's apologize to the reader (also your 404 error) 
			include('template-job-none-found.php');
				
			endif; // OK, I think that takes care of both scenarios (having a page or not having a page to show)
                        ?>
                                 </section>

 <?php if (!is_user_logged_in() && $paged==1){  ?>
    
        <div class="container no-pad pad-top">
      <?php echo get_next_posts_link( '<p><button class="btn btn-primary btn-large btn-raised">View more jobs</button></p>', $qp->max_num_pages ); // display older posts link ?>
        </div>

 <?php }else{ ?>

        <div class="container paginating">
	        <div class="col-sm-2 pager pull-left">
                    <li class='pull-left'>
	        <?php previous_posts_link('Previous'); ?>                        
                    </li>
	        </div>
	        <div class="col-sm-8 page-navi mobile-hide desktop-show">
	         <?php wp_pagenavi(); ?>
	         </div>
	        <div class="col-sm-2 pager pull-right">
                    <li class='pull-right'>
	        <?php next_posts_link('Next'); ?>                        
                    </li>
	        </div>
			<div class="mobile-show">
			<?php wp_pagenavi_dropdown();?>
			</div>
        </div>

        
       
 <?php } ?>
</section>