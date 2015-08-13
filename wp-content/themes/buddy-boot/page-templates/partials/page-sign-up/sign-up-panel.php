    <div class='container-fluid sign-up-panel'>
        <div class='container no-pad'> <h3 style='margin-top:10px; color:#999'>Get free full access now</h3></div>

        <section class='search-criteria container row-flex row-flex-wrap'>

            <div class='col-sm-4 welcome-profile'>
                <div class="panel panel-default flex-col">
                    <h2 class=""><i class="material-icons icon-large">trending_up</i></h2>
                <h4>Get better recommendations</h4>
                <div class='avatar-circle'>
                <?php  echo get_avatar( '', $size = '60' );?>
                </div><?php include('partials/selected-options.php');?>
                    </p>
                    <p>Signing up gives you access to more specific job categories, giving you more tailored recommendations</p>
               <div class="refine">
               		<a class='waves-effect waves-light btn btn-white' href="<?php echo site_url();?>/register">
                           Refine your preferences
                        </a>
               </div>
            </div>
            </div>


     <div class='col-sm-4 welcome-profile'>
         <div class="panel panel-default flex-col">
                    <h2 class=""><i class="material-icons icon-large">mood</i></h2>
             
         <h4>It's free to use</h4>         
         <p>It will be free forever to search and discover job opportunities.</p>
                 <a href="<?php echo site_url()?>/register"><button class='btn btn-white' style="margin-bottom:20px;">Sign up with email</button></a>         
         <p>Or sign up using a social media account: </p>
          <!--SOCIAL MEDIA-->
             <div class="register-pg-social">
                 <a href="http://lostgrad.com/login/?loginFacebook=1&amp;redirect=http://localhost/LGWP" onclick="window.location = 'http://lostgrad.com/login/?loginFacebook=1&amp;redirect='+window.location.href; return false;">
                 	<button class='btn btn-fb'>Sign up with facebook</button>
                 </a>
                 <br>
                 <a href="http://lostgrad.com/login/?loginTwitter=1&amp;redirect=http://localhost/LGWP" onclick="window.location = 'http://lostgrad.com/login/?loginTwitter=1&amp;redirect='+window.location.href; return false;">
                 	<button class='btn btn-twitter'>Sign up with twitter</button>
                 </a>
             </div>
         </div>
      </div>

            <div class='col-sm-4 welcome-profile'>
                <div class="panel panel-default flex-col">
                    <h2 class=""><i class="material-icons icon-large">search</i></h2>
                    
                <h4>Try the search</h4>
                <p>Try out the search feature below, make sure you <a href="<?php echo site_url();?>/register">sign up</a> to see all results.</p>
                <?php get_search_form(); ?>

                </div>
            </div>
        </section>

    </div>