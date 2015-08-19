<?php
/**
 * This is the secondary loop that suggests jobs when they can't be found in a given location
 */

//clear the location
//location
unset($args['tax_query'][1]);
//message used in app-bar.php

$wp_query->query($args);

if ( $wp_query->have_posts() ) :
// Do we have any posts/pages in the databse that match our query?

if($current_post_number ==-1){
        $nothing_found = true;
        $message = 'jobs in other locations matching your preferences';
}

echo '<div class="pagi-top container no-pad"><p>Page <span class="page-num">'.$paged.' of '.$wp_query->max_num_pages.'</span>'.$message.'</p>';?>
      <?php include('selections-tags.php');
      echo '</div>';
?>
<section class="container list-container">


				<?php while ( $wp_query->have_posts() ) : $wp_query->the_post();
				// If we have a page to show, start a loop that will display it

				//then do another search for all locations
				 include('more-job-loop.php');
				?>

				<?php endwhile; // OK, let's stop the page loop once we've displayed it ?>

			<?php else : // Well, if there are no posts to display and loop through, let's apologize to the reader (also your 404 error)
			$nothing_found = true;
                        $message = 'jobs in other locations matching your preferences';
                        ?>
                        <div class='container no-pad'>
                          <div class= "post">
                            <h4>Unfortunately, there are no results.</h4>
                            <?php
                            if(!is_user_logged_in()){
                                $link = get_site_url().'/register';
                            }else{
                                $link = get_site_url() .'/members/'.bp_core_get_username( get_current_user_id() ) . '/profile/edit/group/14';
                            }
                             ?>
                            <p>Try <a href="<?php echo $link; ?>">changing your search preferences</a> or filter settings.</p>
                          </div>
                        </div>
                        <?php
                      //  include('app-bar.php');

			endif; // OK, I think that takes care of both scenarios (having a page or not having a page to show)

?>
</section>
