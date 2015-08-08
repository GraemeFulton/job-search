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
            <h4>Already a member?</h4>
            <a href="login" class='btn-success btn-next btn btn-login'>Log In</a>
     
        </div>
    </section> 

                <section class='row interest-row section' id="section1">
  
                     <div class='text-center'>

                      <h2 class='margin-b'>What interests you?</h2>
                <div class="container" data-anchor="slide1" id="slide1">
                    <div class='side'>
                    <div class='col-xs-4 image-box '>
                        <div class="box-container">
                        <div class='check'><input type="checkbox" name="Profession[]" value="Computing"></div>
                         <img class="box-image"  src='<?php echo get_template_directory_uri().'/images/icon-pack/computing.svg'?>'/>
                            <p class='tag'>Computing</p>
                        </div>
                    </div>   
                    <div class='col-xs-4 image-box'>
                        <div class="box-container">                             
                        <div class='check'><input type="checkbox" name="Profession[]" value="Engineering"></div>
                         <img class="box-image"  src='<?php echo get_template_directory_uri().'/images/icon-pack/engineering.svg'?>'/>
                            <p class='tag'>Engineering</p>
                        </div>                            
                    </div>                                     
                    <div class='col-xs-4 image-box'>
                        <div class="box-container">
                        <div class='check' style=''><input type="checkbox" name="Profession[]" value="Finance"></div>
                        <img class="box-image" src='<?php echo get_template_directory_uri().'/images/icon-pack/accounting.svg'?>'/>
                            <p class='tag'>Finance</p>
                        </div>
                    </div>
                    <div class='col-xs-4 image-box '>
                        <div class="box-container">                        
                        <div class='check'><input type="checkbox" name="Profession[]" value="Law"></div>
                         <img class="box-image"  src='<?php echo get_template_directory_uri().'/images/icon-pack/law.svg'?>'/>
                            <p class='tag'>Law</p>
                        </div>                            
                    </div>                    
                    <div class='col-xs-4 image-box '>
                         <div class="box-container">
                        <div class='check'><input type="checkbox" name="Profession[]" value="Management"></div>
                       <img class="box-image"  src='<?php echo get_template_directory_uri().'/images/icon-pack/business.svg'?>'/>
                            <p class='tag'>Management</p>
                         </div>
                    </div>
                    <div class='col-xs-4 image-box'>
                        <div class="box-container">                        
                        <div class='check'><input type="checkbox" name="Profession[]" value="Marketing"></div>
                         <img class="box-image"  src='<?php echo get_template_directory_uri().'/images/icon-pack/marketing.svg'?>'/>
                            <p class='tag'>Marketing</p>
                        </div>                            
                    </div>
                    <div class='col-xs-4 image-box'>
                        <div class="box-container">                        
                        <div class='check'><input type="checkbox" name="Profession[]" value="Media"></div>
                         <img class="box-image"  src='<?php echo get_template_directory_uri().'/images/icon-pack/media.svg'?>'/>
                            <p class='tag'>Media</p>
                        </div>                            
                    </div>
                    <div class='col-xs-4 image-box'>
                        <div class="box-container">                        
                        <div class='check'><input type="checkbox" name="Profession[]" value="Property"></div>
                         <img class="box-image" src='<?php echo get_template_directory_uri().'/images/icon-pack/property.svg'?>'/>
                            <p class='tag'>Property</p>
                        </div>                            
                    </div>
                      <div class='col-xs-4 image-box'>
                        <div class="box-container">                        
                        <div class='check'><input type="checkbox" name="Profession[]" value="Recruiting"></div>
                         <img class="box-image" src='<?php echo get_template_directory_uri().'/images/icon-pack/recruiting.svg'?>'/>
                            <p class='tag'>Recruiting</p>
                        </div>                            
                    </div>
                      <div class='col-xs-4 image-box'>
                        <div class="box-container">                        
                        <div class='check'><input type="checkbox" name="Profession[]" value="Fashion"></div>
                         <img class="box-image" src='<?php echo get_template_directory_uri().'/images/icon-pack/fashion.svg'?>'/>
                            <p class='tag'>Retail</p>
                        </div>                            
                    </div>
                      <div class='col-xs-4 image-box'>
                        <div class="box-container">                        
                        <div class='check'><input type="checkbox" name="Profession[]" value="Science"></div>
                         <img class="box-image" src='<?php echo get_template_directory_uri().'/images/icon-pack/science.svg'?>'/>
                            <p class='tag'>Science</p>
                        </div>                            
                    </div>
                      <div class='col-xs-4 image-box'>
                        <div class="box-container">                        
                        <div class='check'><input type="checkbox" name="Profession[]" value="Teaching"></div>
                         <img class="box-image" src='<?php echo get_template_directory_uri().'/images/icon-pack/teaching.svg'?>'/>
                            <p class='tag'>Teaching</p>
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

             <h2 class='margin-b'>What's your degree classification?</h2>
                
                    <p>This can be you predicted grade, or what you've already achieved</p>
                    <div class="btn-group" role="group" aria-label="...">
                    <button type="button" class="btn btn-degree btn-default">2:2</button>
                    <button type="button" class="btn btn-degree btn-default">2:1</button>
                    <button type="button" class="btn btn-degree btn-default">1:1</button>
                  </div>
                    <p style='margin-top:20px;'> <small>Don't worry, you can change these again later!</small></p>
                    <br>

                     <input type="submit" style="display:none;" name="submit" Value="Show me the jobs!" class='btn-success btn-next btn btn-submit'>

            </div>
        </section>
    
</form>

</div>


<?php get_footer(); ?>
<script src="<?php echo get_template_directory_uri()?>/js/map.js"></script>

</body>
</html>
