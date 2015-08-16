<?php
/**<br />
 * Template Name: Archives Template<br />
 * Description: A Page Template that lets us created a dedicated Archives page<br />
 *<br />
 * @package WordPress<br />
 * @subpackage Twenty_Eleven<br />
 * @since Twenty Eleven 1.0<br />
 */
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
global $paged;
global $wp_query;


get_header(); // This fxn gets the header.php file and renders it ?>

        <?php include(get_stylesheet_directory().'/partials/side-nav.php');?>

        <?php require(JOB_RECOMMENDATIONS.'/public/views/partials/app-bar.php'); ?>



    <section class="col-md-9 main-content-area col-md-offset-2  col-xs-12">
      <?php  include(get_stylesheet_directory().'/partials/loader.php');?>

	<div class="archive-title">
		<h3>Jobs @ <?php  echo $term->name; ?></h3>
	</div>
     	<div id="primary" class="">
<!--		<div id="content" role="main" class="span12">-->
		<section class="container list-container">
 <?php
        global $wp_query;
        if ($paged==0){
        	$paged=1;
     	 }

         echo '<div class="pagi-top container no-pad no-pad-bottom"><p>Page <span class="page-num">'.$paged.' of '.$wp_query->max_num_pages.'</span> for jobs @ '.$term->name.'</p>';?>
               <?php include('partials/selections-tags.php') ;
               echo '</div>';
                ?>
			<?php if ( have_posts() ) :
			// Do we have any posts/pages in the databse that match our query?
			?>

				<?php while ( have_posts() ) : the_post();
				// If we have a page to show, start a loop that will display it

				do_action('archive_job_loop');
				?>



				<?php endwhile; // OK, let's stop the page loop once we've displayed it ?>
                </section>
			<?php else : // Well, if there are no posts to display and loop through, let's apologize to the reader (also your 404 error) ?>

				<article class="post error">
					<h1 class="404">Nothing posted yet</h1>
				</article>

			<?php endif; // OK, I think that takes care of both scenarios (having a page or not having a page to show) ?>

<!--		</div> #content .site-content -->
	</div><!-- #primary .content-area -->
    <?php if(!is_user_logged_in()){
      ?>
      <article class="post error container" style="padding:20px;">
        <h3 style="margin-top:0px;"><a href="<?php echo get_site_url; ?>/register">Sign up</a> to see all <?php echo $results?> jobs @ <?php echo $term->name;?></h3>
                                      <p>There are more jobs @ <?php echo $term->name; ?> - sign up to see them all.</p>
      </article>
      <?php
    }
    ?>

    </section>
    <?php
    if(is_user_logged_in()){
     include(get_stylesheet_directory().'/partials/pagination.php');
     }
    else {

       include('page-templates/partials/page-sign-up/sign-up-panel.php');

        include('page-templates/partials/page-sign-up/sign-up-modal.php');
     }?>
    <?php get_footer(); // This fxn gets the footer.php file and renders it ?>
