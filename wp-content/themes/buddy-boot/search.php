<?php
/**
 * The template for displaying any single page.
 *
 */

get_header(); // This fxn gets the header.php file and renders it
global $paged;
global $wp_query;
?>
 <? include(get_stylesheet_directory().'/partials/side-nav.php');?>
 <?php require(JOB_RECOMMENDATIONS.'/public/views/partials/app-bar.php'); ?>


    <section class="col-md-9 main-content-area  col-md-offset-2  col-xs-12">
      <?php  include(get_stylesheet_directory().'/partials/loader.php');?>

              <h3 class="pagi-top container no-pad-bottom no-pad" style='margin-bottom:15px;'>
                <?php
                  $results = $wp_query->found_posts;
                  if($results>1){
                    $term = ' results';
                  }else $term = ' result';
                ?>
              Found <?php echo $results.$term.' for "'.$_GET['s'].'"'; ?>
            </h3>
			<?php if ( have_posts() ) :

      global $wp_query;
        if ($paged==0){
        	$paged=1;
     	 }

         echo '<div class="pagi-top container no-pad-bottom no-pad"><p>Page <span class="page-num">'.$paged.' of '.$wp_query->max_num_pages.'</span> for your search</p>';?>
               <?php include('partials/selections-tags.php') ;
               echo '</div>';

			// Do we have any posts/pages in the databse that match our query?
			?>
      <section class="container list-container">


				<?php
        $post_count = 0;
        while ( have_posts() ) : the_post();
				// If we have a page to show, start a loop that will display it
        $post_count+=1;
				?>
				<?php
        if(!is_user_logged_in()){
          if($post_count<4){
            do_action('job_search_results_loop');
          }
          elseif($post_count==5){
            ?>
          </section>
          <section class="container list-container post error container" style="padding:20px;">
            <article >
    					<h3 style="margin-top:18px;"><a href="<?php echo get_site_url(); ?>/register" style="float:none;">Sign up now</a> to see all <?php echo $results?> results</h3>
            </article>
          </section>
            <?php
          }
        }else do_action('job_search_results_loop');
        ?>
				<?php endwhile; // OK, let's stop the page loop once we've displayed it ?>

			<?php else : // Well, if there are no posts to display and loop through, let's apologize to the reader (also your 404 error) ?>

				<article class="post error container" style="padding:20px;">
					<h3 style="margin-top:0px;">Sorry, nothing found</h3>
                                        <p>Try searching for something else, or browse recommended jobs:</p>
                                        <a class="btn-success btn-outlined btn" href="<?php echo get_site_url(); ?>/job-roll">Recommended Jobs</a>
				</article>

			<?php endif; // OK, I think that takes care of both scenarios (having a page or not having a page to show) ?>
<!--		</div> #content .site-content -->
<?php
if(is_user_logged_in()){
 include(get_stylesheet_directory().'/partials/pagination.php');
 }
else {
  echo '</section>';
   include('page-templates/partials/page-sign-up/sign-up-panel.php');

    include('page-templates/partials/page-sign-up/sign-up-modal.php');
 }?>

</section>
<?php get_footer(); // This fxn gets the footer.php file and renders it ?>
