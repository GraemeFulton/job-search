<?php
/**
 * This is the secondary loop that suggests jobs when they can't be found in a given location
 */

//clear the location
//location
unset($args['tax_query'][1]);
//message used in app-bar.php
global $paged;
$wp_query->query($args);

if(isset($nothing_found)){
if($nothing_found==true){
    ?>
     <?php
     if ($paged<3) {
       ?>
	<div class="container-margin-bottom container">
		<h3><i class="fa fa-thumbs-o-up"></i> We've found <?php echo $wp_query->found_posts; ?> related jobs within the UK</h3>
	   <p><i class="fa fa-info-circle"></i> There are no more jobs in the location you selected</p>
    </div>
    <?php
  }
}
}


if ( $wp_query->have_posts() ) :
// Do we have any posts/pages in the databse that match our query?

if($current_post_number ==-1){
        $nothing_found = true;
        $message = 'jobs in other locations matching your preferences';
}
if($start_second_loop!==true){
echo '<div class="pagi-top container no-pad"><p>Page <span class="page-num">'.$paged.' of '.$wp_query->max_num_pages.'</span>'.$message.'</p>';?>
      <?php include('selections-tags.php');
      echo '</div>';
}
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
                                $link = get_site_url() .'/members/'.bp_core_get_username( get_current_user_id() ) . '/profile/edit/group/4';
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
