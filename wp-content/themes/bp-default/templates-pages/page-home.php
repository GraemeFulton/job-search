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
                    <div class="center-wrapper">
		<!-- slider -->
		<?php echo do_shortcode("[promoslider]"); ?>
		
		<!-- description -->
		<div class="home-tag-line">
		<h1>Start Building Your Brighter Future, For Free.</h1>
						<h4>Lostgrad is a free service, offering opportunities to help you unlock your true potential, and create the life you want.</h4>
		<div class="home-show-case">
		<h4><i class="ico fa fa-book"></i> Take Free World Class Courses</h4>
		<h4><i class="ico fa fa-plane"></i> Experience the World</h4>
		<h4><i class="ico fa fa-crosshairs"></i> Discover Your Perfect Job</h4>
		<h4><i class="ico fa fa-comments"></i> Engage in Discussions</h4>
		</div>
		<br>
		
				<?php echo do_shortcode('[widgets_on_pages id="Login Widget"]'); ?>
		
		</div>
                    </div>
		</div>
        
        <!----------------
        ------area 2 -----
        ------------------>
        <div class="featured-area">
            <div class="center-wrapper">
                        <div id="Members_Feed">
                        <h2><i class="ico fa fa-users"></i> Members</h2>
                        <?php 
                echo do_shortcode('[widgets_on_pages id="Members Box"]');
                ?>
                <!-- <h4><i class="ico fa fa-users"></i> Groups</h4> -->
                <?php 
                //echo do_shortcode('[widgets_on_pages id="Groups Box"]');
                ?>
                <h2><i class="ico fa fa-comments-o"></i> Member Activity</h2>
                <?php 
                echo do_shortcode('[widgets_on_pages id="Member Feed"]');
                ?>

                </div>

                <?php
                $post_types=['course', 'work-experience-job','graduate-job', 'travel-opportunities'];

                echo '<div id="Featured_Content">';
                echo '<h2><i class="ico fa fa-star-o"></i> Featured</h2>';
                foreach($post_types as $type){

                do_shortcode('[profile_favourites slug="'.$type.'" user="admin"]');
                //echo '<button class="profile-bookmark-item btn btn-success">See All</button>';

                }
                echo '<div class="inspire-featured">';
                do_shortcode('[profile_favourites slug="inspire-posts" user="admin"]');
                echo '</div>';
                ?>
          </div>
</div><!-- featured area -->
</div>