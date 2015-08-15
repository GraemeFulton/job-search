<section class='col-md-9 col-xs-12'>
  <?php  include(get_stylesheet_directory().'/partials/loader.php');?>

 <?php
     global $paged;

     $start_second_loop = false;
     $current_post_number=-1;

     //First do the primary loop to grab the first few
     if ( $wp_query->have_posts() ) :
     ?>

      <?php if($paged==1){

     echo '<h3><i class="material-icons icon-large">thumb_up</i> Found '.$found.' jobs in your preferred location</h3>';
     } ?>

    <section class="container list-container">

    <?php
        global $wp_query;
        if ($paged==0){
        	$paged=1;
     	 }

         echo '<div class="pagi-top container no-pad"><p>Page <span class="page-num">'.$paged.' of '.$wp_query->max_num_pages.'</span>'.$message.'</p>';?>
               <?php include('selections-tags.php');
               echo '</div>';
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
                                </section>

	<div class="container-margin-bottom container-margin-top">
		<h3><i class="material-icons icon-large">thumb_up</i> Here's some related jobs elsewhere in the UK</h3>
	   <p><i class="fa fa-info-circle"></i> There are no more jobs in the location you selected</p>
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

 <?php if (!is_user_logged_in() && $paged==1){  ?>

       <div class="col-md-9 pull-right no-pad pad-top">
           <div class='container no-pad pad-top'>
      <?php echo get_next_posts_link( '<p><button class="btn btn-primary btn-large btn-raised">View more jobs</button></p>', $qp->max_num_pages ); // display older posts link ?>
            </div>
       </div>

 <?php }else{ ?>

        <div class="container col-md-12 paginating">
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
