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
      <section class='row interest-row section' id="section1">

        <div class='text-center animatedParent'>
            <h2 class='margin-b animated materialInBottom'>What interests you?</h2>
            <div class="container animatedParent animated materialInBottomGrow delay-750 background-white" data-anchor="slide1" id="slide1">
              <div class='side'>
              <?php
              $professions = get_terms('profession');
              $counter =0;
              foreach($professions as $profession)
              {
                if($profession->parent==0)//if there is no parent, it is a top-level category
                {
                  $counter+=1;

                  if($profession->name=='Business &amp; Management')
                    $profession->name = 'Business';
                    if($counter<4){$delay='001';} elseif($counter<7){$delay='002';} elseif($counter<10){$delay='003';}elseif($counter<13){$delay='004';}
                ?>
                  <div class='<?php echo 'count'.$counter;?> col-xs-4 image-box  delay-<?php echo $delay; ?>'>
                    <div class="btn btn-sup btn-default box-container">
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
            <div class="animatedParent">
              <div class="row text-center  animated materialInBottom delay-2000">
                <div class="to-next-step">
                  <a class="btn-primary btn-next btn-raised btn btn-scroll-down">To the next step</a>
                </div>
              </div>
            </div>
        </section>

        <!---------- Page 3 --------->
        <section class='row location-row section animatedParent' id="section3">
          <div class='row text-center materialInUpShort animated'>
            <div class="animatedParent">
              <h2 class="">Where would you like to work?</h2>
            </div>
            <div class="container">You have selected:
              <div id="selected">
                <span class='nowhere'>Nothing</span>
              </div>
            </div>
            <div class="spacey"></div>
            <div id="selection" class="container"></div>
            <div class="animatedParent">
            <div id="map"class="animated materialInBottom delay-001" style='position:relative;'></div>
          </div>
            <div class="spacey"></div>
            <div class="row text-center">
              <div class="to-next-step">
                <a class="btn-primary btn-next btn-raised btn btn-scroll-down">To the next step</a>
              </div>
            </div>
          </div>

        </section>

        <!--------- Section 4 ---------->
        <section class='container degree-row section' id="section4">
          <div class='text-center'>

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
    <script src="<?php echo get_template_directory_uri()?>/page-templates/landing-page-libs/js/css3-animate-it.js"></script>
    <script src="<?php echo get_template_directory_uri()?>/js/map.js"></script>
  </body>
</html>
