<?php 
/*
 * Template Name: Home Page
 * 
 * A Page for courses
*/

include (TEMPLATEPATH . '/templates-headers/header-home.php');
?>

	<div id="home-content" class='home-content'>

		<div class="padder">

		<?php do_action( 'bp_before_blog_page' ); ?>

		<div class="page" role="main">
		
		 <!----------------
        ------area 1 -----
        ------------------>
      
		<div class="home-slider-area">
		
		<!-- slider -->
		<?php echo do_shortcode("[promoslider]"); ?>
		
		<!-- description -->
		<div class="home-tag-line">
		<h2><b>Start Building Your Brighter Future</b></h2>
						<h4>Lostgrad is a free service, offering opportunities to help you unlock your full potential, and create the life you want.</h4>
		<div class="home-show-case">
		<h4><i class="ico fa fa-book"></i> Take World Class Courses, for Free</h4>
		<h4><i class="ico fa fa-plane"></i> Experience the World</h4>
		<h4><i class="ico fa fa-crosshairs"></i> Discover Your Perfect Job</h4>
		<h4><i class="ico fa fa-comments"></i> Engage in Discussions</h4>
		</div>
		<br>
		
		
		</div>
		
		</div>
        
        <!----------------
        ------area 2 -----
        ------------------>
        <div class="featured-area">
        
        <div id="Members_Feed">
        <h2><i class="ico fa fa-users"></i> Members Activity</h2>
<?php 
echo do_shortcode('[widgets_on_pages id="Member Feed"]');
?>
</div>

<?php
$post_types=['course', 'travel-opportunities','graduate-job', 'work-experience-job'];

echo '<div id="Featured_Content">';
echo '<h2><i class="ico fa fa-star-o"></i> Featured Content</h2>';
foreach($post_types as $type){

do_shortcode('[profile_favourites slug="'.$type.'"]');
//echo '<button class="profile-bookmark-item btn btn-success">See All</button>';

}
?>
</div><!-- featured area -->
</div>