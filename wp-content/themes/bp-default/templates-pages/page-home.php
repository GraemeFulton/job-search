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
		
		<!-- description -->
		<div class="home-tag-line">
                    <div class="tagline">
		<h1>Build A Brighter Future.</h1>
                    </div>
               <!-- panel-->
                <div class="login_panel">
		
				<?php echo do_shortcode('[widgets_on_pages id="Login Widget"]'); ?>
                    
                    <div id="social_box">
                                <!--facebook login-->
                  <a href="http://localhost/LGWP/login/?loginFacebook=1&redirect=http://localhost/LGWP" onclick="window.location = 'http://localhost/LGWP/login/?loginFacebook=1&redirect='+window.location.href; return false;">

                      <div class="new-fb-btn new-fb-4 new-fb-default-anim"><div class="new-fb-4-1"><div class="new-fb-4-1-1">Log In with facebook</div></div></div>                
                 </a>
                                <br>
                <a href="http://localhost/LGWP/login/?loginTwitter=1&redirect=http://localhost/LGWP" onclick="window.location = 'http://localhost/LGWP/login/?loginTwitter=1&redirect='+window.location.href; return false;"> 
                    <div class="new-twitter-btn new-twitter-4 new-twitter-default-anim"><div class="new-twitter-4-1"><div class="new-twitter-4-1-1">Log In with twitter</div></div></div>

                </a>
                    </div>

                
                <!----->
                </div>
                <!-- panel-->
         
                
                
                </div>
                    </div>
		</div>
        
        <!----------------
        ------area 2 -----
        ------------------>
        <div class="featured-area">
            <div class="center-wrapper">
               

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
</div><!-- featured area -->
</div>