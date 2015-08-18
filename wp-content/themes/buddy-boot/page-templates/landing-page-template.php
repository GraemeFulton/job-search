<?php
/**
 * Template Name: Landing page
 */

//if user logged in don't bother
if(is_user_logged_in()==true){
  wp_redirect( home_url( '/job-roll/' ) ); exit;
}
get_header();
?>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri()?>/libs/fullpage/jquery.fullPage.css">
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri()?>/page-templates/landing-page-libs/css/landing-page.css">
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri()?>/page-templates/landing-page-libs/css/animations.css">

<div class="container-fluid content-container" id="fullpage">

    <form method='GET' action='sign-up'>

      <!---------- Page 1 ---------->
      <section class="animatedParent welcome-row row section" id="section0">
        <div class="row">

          <div class='text-center'>
              <h1 class="animated bounceIn delay-250">Hello</h1>
              <h4 class="animated bounceIn delay-500">Already a member?</h4>
              <a href="login" class='delay-1000 animated bounceIn btn-primary btn-next btn btn-login'>Log In</a>
          </div>
        </div>

        <div class="row text-center">
            <div class="to-next-step"><a class="btn-primary btn-next btn btn-scroll-down">Find me a job!</a></div>
        </div>
      </section>

      <!---------- Page 2 ---------->
      <section class='animatedParent row interest-row section' id="section1">

        <div class='text-center'>
          <h2 class='margin-b'>What interests you?</h2>
            <div class="container" data-anchor="slide1" id="slide1">
              <div class='side'>
              <?php
              $professions = get_terms('profession');
              foreach($professions as $profession)
              {
                if($profession->parent==0)//if there is no parent, it is a top-level category
                {
                  if($profession->name=='Business &amp; Management')
                    $profession->name = 'Business';
                ?>
                  <div class='col-xs-4 image-box animated bounceIn'>
                    <div class="btn btn-sup btn-default btn-raised box-container">
                      <div class='check'>
                        <input type="checkbox" name="Profession[]" value="<?php echo $profession->slug; ?>">
                      </div>
                        <img class="box-image"  src='<?php echo get_template_directory_uri().'/images/icon-pack/'.str_replace(' &amp; ', '', strtolower($profession->name)).'.svg'?>'/>
                          <p class='tag'><?php echo $profession->name;?></p>
                    </div>
                  </div>
                <?php
                }
              }
              ?>
              </div>
            </div>

            <div class="row text-center">
              <div class="to-next-step">
                <a class="btn-primary btn-next btn btn-scroll-down">To the next step</a>
              </div>
            </div>
        </section>

        <!---------- Page 3 --------->
        <section class='row location-row section' id="section3">
          <div class='row text-center'>
            <h2>Where would you like to work?</h2>
            <div class="container">You have selected:
              <div id="selected">
                <span class='nowhere'>Nothing</span>
              </div>
            </div>
            <div class="spacey"></div>
            <div id="selection" class="container"></div>
            <div id="map" style='position:relative;'></div>
            <div class="spacey"></div>
          </div>
          <div class="row text-center">
            <div class="to-next-step">
              <a class="btn-primary btn-next btn btn-scroll-down">To the next step</a>
            </div>
          </div>
        </section>

        <!--------- Section 4 ---------->
        <section class='container degree-row section' id="section4">
          <div class='text-center'>
            <h2 class='margin-b'>What's your degree classification?</h2>
            <p>This can be you predicted grade, or what you've already achieved</p>
            <div class="btn-group" role="group" aria-label="...">
              <button type="button" class="btn btn-degree btn-default">2:2</button>
              <button type="button" class="btn btn-degree btn-default">2:1</button>
              <button type="button" class="btn btn-degree btn-default">1:1</button>
            </div>
            <p style='margin-top:20px;'> <small>Don't worry, you can change these again later!</small></p>
            <br>
          </div>

          <div class="row text-center">
            <input type="submit" name="submit" Value="Show me the jobs!" class='btn-primary btn-next btn btn-submit'>
          </div>
        </section>
      </form>
    </div>
    <?php get_footer(); ?>
    <script src="<?php echo get_template_directory_uri()?>/js/scaleRaphael.js"></script>
    <script src="<?php echo get_template_directory_uri()?>/libs/fullpage/vendors/jquery.slimscroll.min.js"></script>
    <script src="<?php echo get_template_directory_uri()?>/libs/fullpage/vendors/jquery.easings.min.js"></script>
    <script src="<?php echo get_template_directory_uri()?>/libs/fullpage/jquery.fullPage.min.js"></script>
    <script src="<?php echo get_template_directory_uri()?>/page-templates/landing-page-libs/js/landing-page.js"></script>
    <script src="<?php echo get_template_directory_uri()?>/page-templates/landing-page-libs/js//css3-animate-it.js"></script>
    <script src="<?php echo get_template_directory_uri()?>/js/map.js"></script>
  </body>
</html>
