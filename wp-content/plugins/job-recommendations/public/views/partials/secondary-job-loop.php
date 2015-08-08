<?php
/**
 * This is the secondary loop that suggests jobs when they can't be found in a given location
 */
 
//clear the location
//location
unset($args['tax_query'][1]);

$wp_query->query($args);

if ( $wp_query->have_posts() ) :
// Do we have any posts/pages in the databse that match our query?

if($current_post_number ==-1){
	?>
	<article class="post container">
 	<p class="404">We've found <?php echo $wp_query->found_posts;;?> jobs, but none in your preferred location, what about these?</p>
</article> 
	<?php 
}
?>
			

				<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
				// If we have a page to show, start a loop that will display it

				//then do another search for all locations
				 include('more-job-loop.php');
				?>
				
				<?php endwhile; // OK, let's stop the page loop once we've displayed it ?>

			<?php else : // Well, if there are no posts to display and loop through, let's apologize to the reader (also your 404 error) 
			include('../template-job-none-found.php');
				
			endif; // OK, I think that takes care of both scenarios (having a page or not having a page to show)
                    
?>
