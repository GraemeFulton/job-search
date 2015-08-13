     <?php 	
     global $paged;
      
     $start_second_loop = false;
     $current_post_number=-1;
      
     //First do the primary loop to grab the first few
     if ( $wp_query->have_posts() ) : 
     
     ?>
        <div class='container box-head'>
        <?php 
        global $wp_query;
        if ($paged==0){ 
        	$paged=1;
     	 }
        
         echo '<div style="float:left;"><p>Page <span class="page-num">'.$paged.' of '.$wp_query->max_num_pages.'</span> for your selections </p></div>'
               .'<a href="'.get_site_url() .'/members/'. bp_core_get_username( get_current_user_id() ) . '/profile/edit" class="btn-success btn-outlined btn pull-right btn-settings"><i class="fa fa-cog"></i></a>';
         ?>
        
    </div>
     
     <?php 
     
     if($paged==1){
     	
     echo '<div class="container"><h3 style="color:#999;"><i class="fa fa-thumbs-o-up"></i> We\'ve found '.$found.' jobs in your preferred location</h3></div>';
     }
			// Do we have any posts/pages in the databse that match our query?
			?>
				<section class="container list-container">

				<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
				// If we have a page to show, start a loop that will display it
				
				//include a few from the main job results
				include('partials/primary-job-loop.php');
				
				//echo $paged;
				if($paged==2){
					$current_post_number=$wp_query->current_post+4+1;
				}
				elseif($paged>2){
					$current_post_number=$wp_query->current_post+4+(6*($paged-2))+1+2;
				}
				else{
					$current_post_number=$wp_query->current_post+1;
				}
				//echo $current_post_number;

					if ($current_post_number == $found) :
					// I'm the last post in the Loop
					$start_second_loop=true;
					?>
	<div class="container container-margin-bottom">
		<h3 style="color:#999;"><i class="fa fa-hand-o-right"></i> Here's some related jobs elsewhere in the UK</h3>	
	   <p style="color:#999;"><i class="fa fa-info-circle"></i> There are no more jobs in the location you selected</p>
    </div>					<?php 
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
