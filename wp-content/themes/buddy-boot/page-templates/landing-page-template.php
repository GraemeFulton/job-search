<?php
/**
 * Template Name: Landing page
 */

//if user logged in don't bother
if(is_user_logged_in()==true){
            wp_redirect( home_url( '/job-roll/' ) ); exit;

}


?>
<?php get_header(); ?>
<script src="<?php echo get_template_directory_uri()?>/js/scaleRaphael.js"></script>
<script src="<?php echo get_template_directory_uri()?>/libs/fullpage/vendors/jquery.slimscroll.min.js"></script>
<script src="<?php echo get_template_directory_uri()?>/libs/fullpage/vendors/jquery.easings.min.js"></script>
<script src="<?php echo get_template_directory_uri()?>/libs/fullpage/jquery.fullPage.min.js"></script>
<script src="<?php echo get_template_directory_uri()?>/page-templates/landing-page-libs/js/landing-page.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri()?>/libs/fullpage/jquery.fullPage.css">
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri()?>/page-templates/landing-page-libs/css/landing-page.css">

<div class="container-fluid content-container" id="fullpage">
    <div class="to-next-step" id="moveDown"><a class="btn-success btn-next btn btn-scroll-down">Next</a></div>
    <form method="get" action='sign-up'>

    <section class="welcome-row row section" id="section0">
        <div class='text-center'>
            <h1>Hello</h1>
            <p>Take these 3 simple steps, and we'll suggest some jobs for you:</p>
            <h4>Already a member?</h4>
            <a href="login" class='btn-success btn-next btn btn-login'>Log In</a>
             <h4>Want to get started?</h4>
            <h1><a class='btn-success btn-next btn btn-scroll-down'>Find me a job!</a></h1>

        </div>
    </section>

                <section class='row interest-row section' id="section1">
                     <div class='text-center'>

                         <h2>What do you want to do?</h2>

                <div class="slide" data-anchor="slide1" id="slide1">
                    <p>Choose as many as you like!</p>
                    <div class='side'>
                    <div class='col-lg-1 col-md-2 col-sm-3 col-xs-4 col-lg-offset-4 col-md-offset-2 col-xs-offset-2 col-sm-offset-1 image-box'>
                        <div class="box-container">
                        <div class='check' style=''><input type="checkbox" name="Profession[]" value="Finance"></div>
                        <img class="box-image" src='<?php echo get_template_directory_uri().'/images/icons/pound.svg'?>'/>
                            <p class='tag'>Finance</p>
                        </div>
                    </div>
                    <div class='col-lg-1 col-md-2 col-sm-3 col-xs-4 image-box '>
                         <div class="box-container">
                        <div class='check'><input type="checkbox" name="Profession[]" value="Management"></div>
                       <img class="box-image"  src='<?php echo get_template_directory_uri().'/images/icons/case.svg'?>'/>
                            <p class='tag'>Management</p>
                         </div>
                    </div>
                    <div class='col-lg-1 col-md-2 col-sm-3 col-xs-4 image-box col-xs-offset-2 col-lg-offset-0 col-md-offset-0 col-sm-offset-0'>
                        <div class="box-container">
                        <div class='check'><input type="checkbox" name="Profession[]" value="Computing"></div>
                         <img class="box-image"  src='<?php echo get_template_directory_uri().'/images/icons/computing.svg'?>'/>
                            <p class='tag'>Computing</p>
                        </div>
                    </div>
                    <div class='col-lg-1 col-md-2 col-sm-3 col-xs-4 image-box col-sm-offset-1 col-lg-offset-0 col-md-offset-0 col-xs-offset-0'>
                        <div class="box-container">                        
                        <div class='check'><input type="checkbox" name="Profession[]" value="Marketing"></div>
                         <img class="box-image"  src='<?php echo get_template_directory_uri().'/images/icons/target.svg'?>'/>
                            <p class='tag'>Marketing</p>
                        </div>                            
                    </div>
                    
                         <div class='col-lg-1 col-md-2 col-md-offset-2 col-sm-3 col-xs-4 col-lg-offset-4 image-box col-sm-offset-0 col-xs-offset-2 '>
                        <div class="box-container">                             
                        <div class='check'><input type="checkbox" name="Profession[]" value="Engineering"></div>
                         <img class="box-image"  src='<?php echo get_template_directory_uri().'/images/icons/gears.svg'?>'/>
                            <p class='tag'>Engineering</p>
                        </div>                            
                    </div>
                    <div class='col-lg-1 col-md-2 col-sm-3 col-xs-4 image-box '>
                        <div class="box-container">                        
                        <div class='check'><input type="checkbox" name="Profession[]" value="Law"></div>
                         <img class="box-image"  src='<?php echo get_template_directory_uri().'/images/icons/law.svg'?>'/>
                            <p class='tag'>Law</p>
                        </div>                            
                    </div>
                    <div class='col-lg-1 col-md-2 col-sm-3 col-xs-4 image-box col-xs-offset-2 col-lg-offset-0 col-md-offset-0 col-sm-offset-1'>
                        <div class="box-container">                        
                        <div class='check'><input type="checkbox" name="Profession[]" value="Media"></div>
                         <img class="box-image"  src='<?php echo get_template_directory_uri().'/images/icons/thumb2.svg'?>'/>
                            <p class='tag'>Media</p>
                        </div>                            
                    </div>
                    <div class='col-lg-1 col-md-2 col-sm-3 col-xs-4 image-box'>
                        <div class="box-container">                        
                        <div class='check'><input type="checkbox" name="Profession[]" value="Retail"></div>
                         <img class="box-image" src='<?php echo get_template_directory_uri().'/images/icons/hanger.svg'?>'/>
                            <p class='tag'>Retail</p>
                        </div>                            
                    </div>

                    <div class='col-sm-12 col-xs-12 next-action'>
                        <a class='btn-large btn-custom btn btn-scroll-right'>Other Categories</a>
<!--                        <button class='btn-success btn-next btn'>Next Step</button>-->
                    </div>
                        </div>
  
                </div>
                </div>
        <div class='slide' data-anchor="slide2" id="slide2">
  <div class='text-center'>
      <h5>Here's some more categories:</h5>
                    <div class='side'>
                        <div class="side-pad">
                    <div class='col-lg-1 col-md-2 col-sm-3 col-xs-4 col-lg-offset-4 col-md-offset-2 col-xs-offset-2 col-sm-offset-1 image-box'>
                        <div class="box-container">
                        <div class='check' style=''><input type="checkbox" name="Profession[]" value="Media"></div>
                        <img class="box-image" src='<?php echo get_template_directory_uri().'/images/icons/pound.svg'?>'/>
                            <p class='tag'>Media</p>
                        </div>
                    </div>
                    <div class='col-lg-1 col-md-2 col-sm-3 col-xs-4 image-box '>
                         <div class="box-container">
                        <div class='check'><input type="checkbox" name="Profession[]" value="Property"></div>
                       <img class="box-image"  src='<?php echo get_template_directory_uri().'/images/icons/case.svg'?>'/>
                            <p class='tag'>Property</p>
                         </div>
                    </div>
                    <div class='col-lg-1 col-md-2 col-sm-3 col-xs-4 image-box col-xs-offset-2 col-lg-offset-0 col-md-offset-0 col-sm-offset-0'>
                        <div class="box-container">
                        <div class='check'><input type="checkbox" name="Profession[]" value="Recruiting"></div>
                         <img class="box-image"  src='<?php echo get_template_directory_uri().'/images/icons/computing.svg'?>'/>
                            <p class='tag'>Recruiting</p>
                        </div>
                    </div>
                    <div class='col-lg-1 col-md-2 col-sm-3 col-xs-4 image-box col-sm-offset-1 col-lg-offset-0 col-md-offset-0 col-xs-offset-0'>
                        <div class="box-container">                        
                        <div class='check'><input type="checkbox" name="Profession[]" value="BiScienceke"></div>
                         <img class="box-image"  src='<?php echo get_template_directory_uri().'/images/icons/target.svg'?>'/>
                            <p class='tag'>Science</p>
                        </div>                            
                    </div>
                    
                         <div class='col-lg-1 col-md-2 col-md-offset-2 col-sm-3 col-xs-4 col-lg-offset-4 image-box col-sm-offset-0 col-xs-offset-2 '>
                        <div class="box-container">                             
                        <div class='check'><input type="checkbox" name="Profession[]" value="Teaching"></div>
                         <img class="box-image"  src='<?php echo get_template_directory_uri().'/images/icons/gears.svg'?>'/>
                            <p class='tag'>Teaching</p>
                        </div>                            
                    </div>
                    <div class='col-lg-1 col-md-2 col-sm-3 col-xs-4 image-box '>
                        <div class="box-container">                        
                        <div class='check'><input type="checkbox" name="Profession[]" value="Catering"></div>
                         <img class="box-image"  src='<?php echo get_template_directory_uri().'/images/icons/law.svg'?>'/>
                            <p class='tag'>Catering</p>
                        </div>                            
                    </div>
                    <div class='col-lg-1 col-md-2 col-sm-3 col-xs-4 image-box col-xs-offset-2 col-lg-offset-0 col-md-offset-0 col-sm-offset-1'>
                        <div class="box-container">                        
                        <div class='check'><input type="checkbox" name="Profession[]" value="Media"></div>
                         <img class="box-image"  src='<?php echo get_template_directory_uri().'/images/icons/thumb2.svg'?>'/>
                            <p class='tag'>Media</p>
                        </div>                            
                    </div>
                    <div class='col-lg-1 col-md-2 col-sm-3 col-xs-4 image-box'>
                        <div class="box-container">                        
                        <div class='check'><input type="checkbox" name="Profession[]" value="Retail"></div>
                         <img class="box-image" src='<?php echo get_template_directory_uri().'/images/icons/hanger.svg'?>'/>
                            <p class='tag'>Retail</p>
                        </div>                            
                    </div>

                    <div class='col-sm-12 col-xs-12 next-action'>
                        <a class='btn-large btn-custom btn btn-scroll-left'><i class="fa fa-arrow-left"></i></a>
                        <a class='btn-large btn-custom btn btn-scroll-right'><i class="fa fa-arrow-right"></i></a>
                                                

<!--                        <button class='btn-success btn-next btn'>Next Step</button>-->
                    </div>
                        </div>
                    </div>
  
                </div>
            </div>
                    
        </section>
   
        <section class='row location-row section' id="section3">
            <div class='text-center'>
            <h2>Where would you like to work?</h2>

                                     <div class="container">You have selected: <div id="selected"><span class='nowhere'>Nothing</span></div>
                                     </div>
                 
                                     <div class="spacey"></div>
                                        <div id="selection" class="container"></div>
                                     <div id="map" style='position:relative;'></div>

                                     <div class="spacey"></div>


                 
            </div>
        </section>
    
            <section class='container degree-row section' id="section4">
            <div class='text-center'>

             <h2>What's your degree classification?</h2>
                
                    <p>This can be you predicted grade, or what you've already achieved</p>
                    <div class="btn-group" role="group" aria-label="...">
                    <button type="button" class="btn btn-degree btn-default">2:2</button>
                    <button type="button" class="btn btn-degree btn-default">2:1</button>
                    <button type="button" class="btn btn-degree btn-default">1:1</button>
                  </div>
                    <p style='margin-top:20px;'> <small>Don't worry, you can change these again later!</small></p>
                    <br>

                     <input type="submit" name="submit" Value="Show me the jobs!" class='btn-success btn-next btn'>

            </div>
        </section>
    
</form>

</div>


<?php get_footer(); ?>
<script src="<?php echo get_template_directory_uri()?>/js/map.js"></script>

</body>
</html>
