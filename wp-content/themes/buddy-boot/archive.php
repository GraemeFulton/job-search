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

	<div class="archive-title pagi-top container no-pad no-pad-bottom">
		<h3><?php  echo $term->name; ?> graduate jobs</h3>
	</div>
     	<div id="primary" class="">
        <?php
        global $wp_query;
          if ($paged==0){
          	$paged=1;
       	 }

           echo '<div class="pagi-top container no-pad no-pad-bottom"><p>Page <span class="page-num">'.$paged.' of '.$wp_query->max_num_pages.'</span> for '.$term->name.' jobs</p>';
      //     include(WP_PLUGIN_DIR.'/job-recommendations/public/views/partials/selections-tags.php') ;
          echo '</div>';
                  ?>
		<section class="container list-container">

      <?php if ( have_posts() ) :
			?>

				<?php while ( have_posts() ) : the_post();
        include(WP_PLUGIN_DIR.'/job-recommendations/public/views/partials/primary-job-loop.php');
				?>



				<?php endwhile; // OK, let's stop the page loop once we've displayed it ?>

      </section>
			<?php else : // Well, if there are no posts to display and loop through, let's apologize to the reader (also your 404 error) ?>

				<article class="post error" style="margin-bottom: 0; padding-bottom: 23px;">
					<h3 class="404">Nothing posted yet</h3>
				</article>

			<?php endif; // OK, I think that takes care of both scenarios (having a page or not having a page to show) ?>

	</div>
    <?php if(!is_user_logged_in()){
      ?>
      <article class="post error container" style="padding:20px;">
        <h3 style="margin-top:10px;"><a style="float:none" href="<?php echo get_site_url(); ?>/register">Sign up now</a> to see all <?php echo $results?> <?php echo $term->name;?> graduate jobs</h3>
      </article>
      <?php
    }
    ?>
    <?php
    if(is_user_logged_in()){
     include(get_stylesheet_directory().'/partials/pagination.php');
     }
     ?>
    </section>

    <?php if(!is_user_logged_in()){

       include('page-templates/partials/page-sign-up/sign-up-panel.php');

        include('page-templates/partials/page-sign-up/sign-up-modal.php');
     }?>
    <?php get_footer(); // This fxn gets the footer.php file and renders it ?>
