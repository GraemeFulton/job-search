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
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri()?>/css/landing-page.css">
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri()?>/page-templates/landing-page-libs/css/animations.css">
<?php include(get_stylesheet_directory().'/partials/loader.php');?>

<div class="container-fluid content-container" id="fullpage">

    <form method='GET' action='sign-up'>

      <!---------- Page 1 ---------->
      <section class="animatedParent welcome-row row section" id="section0">
        <div class="row row1 animated shadow-z-1 materialInTop delay-250 text-center">
          <div class="animatedParent">
            <h1 class="materialInTop animated delay-750">Find more graduate jobs here than any other site</h1>
          </div>
        </div>
        <div class="container animated materialInBottomGrowLarge delay-2500 text-center">
          <div class="card container slide1content">
            <div class="row text-center">
            <h1>How it works</h1>
          </div>

        <section class="how-to col-md-12 text-center">
        <div class="col-md-3 text-center">
            <h2 class=""><i class="material-icons icon-large">work</i></h2>
            <h2>Choose your industry</h2>
            <p>Find jobs from over 30 categories, within 12 industries.</p>
        </div>
         <div class="img col-md-1 text-center">
            <i class="material-icons arrow-right large-arrow">keyboard_arrow_right</i>
            <i class="material-icons arrow-down large-arrow">keyboard_arrow_down</i>
         </div>
         <div class="col-md-3 text-center">
           <h2 class=""><i class="material-icons icon-large">location_on</i></h2>
           <h2>Choose your location</h2>
           <p>Target roles throughout the entire UK, from Yorkshire to London.</p>
         </div>
         <div class="img col-md-1 text-center">
            <i class="material-icons arrow-right large-arrow">keyboard_arrow_right</i>
            <i class="material-icons arrow-down large-arrow">keyboard_arrow_down</i>
         </div>
         <div class="col-md-3 text-center">
           <h2 class=""><i class="material-icons icon-large">mood</i></h2>
           <h2>Get job recommendations</h2>
           <p>Companies such as <span class="highlight">Ernst &amp; Young</span>, the <span class="highlight">BBC</span> and even <span class="highlight">BMW</span>.</p>
         </div>

         </section>

           <div class="row text-center">
             <a class="btn-primary btn-next btn-raised btn btn-scroll-down animated materialInUpShort delay-3500">Start now</a>
           </div>
          </div>
          <div class="row text-center" style="display:none">
            <a href="login" style="font-size:13px;" class='pull-right btn-primary btn-next btn btn-login'>Log In</a>
          </div>
        </div>
      </section>

      <!---------- Page 2 ---------->
      <section class='row interest-row section animatedParent' id="section1">
<div class="materialInUpShort animated animatedParent">
        <div class='text-center animatedParent'>
            <h2 class='margin-b'>Choose your industry</h2>
            <div class="container animated materialInBottomGrow delay-1000 background-white" data-anchor="slide1" id="slide1">
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
                  <div class='<?php echo 'count'.$counter;?> col-xs-4 image-box   delay-<?php echo $delay; ?>'>
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
            <div class="row text-center ">
                <div class="to-next-step">
                  <a class="btn-primary btn-next btn-raised btn btn-scroll-down">To the final step</a>
                </div>
              </div>

    </div>
        </section>

        <!---------- Page 3 --------->
        <section class='row location-row section animatedParent' id="section3">

          <div class='row text-center materialInUpShort animated'>
            <div class="animatedParent">
              <h2 class="">Choose your location</h2>
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
                <input type="submit" name="submit" Value="View Jobs" class='btn-primary btn-next btn btn-submit'>
              </div>
            </div>
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
