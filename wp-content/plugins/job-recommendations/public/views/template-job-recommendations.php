     <?php 	 if ( $wp_query->have_posts() ) : 
			// Do we have any posts/pages in the databse that match our query?
			?>

   <div class='container box-head'>
        <?php 
        global $wp_query;
        if ($paged==0){ 
        	$paged=1;
     	 }
        
         echo '<div style="float:left;"><p>Page <span class="page-num">'.$paged.' of '.$wp_query->max_num_pages.'</span> for your selections </p></div>';?>
               <?php include('partials/selections-tags.php') ;
                ?>
        
    </div>
    
    <?php 
    if($paged==1){
    	echo '<div class="container"><h3 style="color:#999;"><i class="fa fa-thumbs-o-up"></i> We\'ve found '.$found.' jobs for you</h3></div>';
    }
    
    ?>
				<section class="container list-container">

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
