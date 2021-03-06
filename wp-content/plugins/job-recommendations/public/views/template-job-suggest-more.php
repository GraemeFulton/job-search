<?php
if(strpos($_SERVER['REQUEST_URI'],'sign-up')){
include('partials/app-bar.php');
}
?>


<section class='col-md-9 main-content-area  col-md-offset-2 col-xs-12'>
  <?php  include(get_stylesheet_directory().'/partials/loader.php');?>

 <?php
     global $paged;

     $start_second_loop = false;
     $current_post_number=-1;

     //First do the primary loop to grab the first few
     if ( $wp_query->have_posts() ) :
      if($paged==1){
          echo '<div class="pagi-top container no-pad"><h3><i class="material-icons icon-large">thumb_up</i> Found '.number_format($found).' jobs in your preferred location</h3></div>';
        }

      global $wp_query;
      if ($paged==0){
         	$paged=1;
      }
      echo '<div class="pagi-top container no-pad"><p>Page <span class="page-num">'.$paged.' of '.$wp_query->max_num_pages.'</span>'.$message.'</p>';?>
      <?php include('partials/selections-tags.php');
      echo '</div>';
      ?>

    <section class="container list-container">
      <?php while ( $wp_query->have_posts() ) : $wp_query->the_post();
				//include a few from the main job results
				include('partials/primary-job-loop.php');
				if($paged==2){
					$current_post_number=$wp_query->current_post+4+1;
				}
				elseif($paged>2){
					$current_post_number=$wp_query->current_post+4+(6*($paged-2))+1+2;
				}
				else{
					$current_post_number=$wp_query->current_post+1;
				}


        if ($current_post_number == $found){
				// I'm the last post in the Loop
				$start_second_loop=true;
					?>
        </section>
          <div class="container-margin-bottom pagi-top container no-pad container-margin-top">
        		<h3><i class="material-icons icon-large">thumb_up</i> Here's some related jobs elsewhere in the UK</h3>
        	  <p><i class="fa fa-info-circle"></i> There are no more jobs in the location you selected</p>
          </div>
          <?php
        }
        endwhile; // OK, let's stop the page loop once we've displayed it
			endif;
      ?>
    </section>
    <?php
  	 if ($current_post_number == -1){
  	    // I'm the last post in the Loop
  	   $start_second_loop=true;
  	  }

    if($start_second_loop==true){
      ?>
      <section class='col-md-9 main-content-area  col-md-offset-2 col-xs-12' style="margin-top:0px!important;">
       	<?php include('partials/secondary-job-loop.php');
        include(get_stylesheet_directory().'/partials/pagination.php');?>
      </section>
        <?php
    }else{
    include(get_stylesheet_directory().'/partials/pagination.php');
    }
    ?>

  </section>
