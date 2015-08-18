<section class='col-md-9 col-md-offset-2 col-xs-12 main-content-area'>
<?php  include(get_stylesheet_directory().'/partials/loader.php');?>
 <?php 	 if ( $wp_query->have_posts() ) :
			// Do we have any posts/pages in the databse that match our query?
?>
    <?php
        global $wp_query;
        if ($paged==0){
          $paged=1;
       }

         echo '<div class="pagi-top container no-pad">';
         if($paged==1){
           echo '<h3><i class="material-icons icon-large">thumb_up</i> Found '.number_format($found).' jobs for you</h3>';
         }
        echo '<p>Page <span class="page-num">'.$paged.' of '.$wp_query->max_num_pages.'</span>'.$message.'</p>';?>
        <?php include('partials/selections-tags.php') ;
          echo '</div>';
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

    <?php include(get_stylesheet_directory().'/partials/pagination.php');?>
</section>
