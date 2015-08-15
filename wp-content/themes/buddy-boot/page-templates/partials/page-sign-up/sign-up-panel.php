    <div class='container-fluid col-md-12 sign-up-panel row-flex row-flex-wrap'>
        <div class='container no-pad'> <h3 style='margin-top:10px; color:#999'>Get free full access now</h3></div>

        <section class='search-criteria container'>

            <div class='col-md-4 col-xs-12'>
                <div class="panel panel-default flex-col">
                    <h2 class=""><i class="material-icons icon-large">trending_up</i></h2>
                <h4>Get better recommendations</h4>
                <div class='avatar-circle'>
                <?php  echo get_avatar( '', $size = '60' );?>
                </div><?php include('partials/selected-options.php');?>
                    </p>
                    <p>Signing up gives you access to more specific job categories, giving you more tailored recommendations.</p>
               <div class="refine">
               		<a class='btn-raised btn' href="<?php echo site_url();?>/register">
                           Refine your preferences
                        </a>
               </div>
             </div>
            </div>


     <div class='col-md-4 col-xs-12'>
         <div class="panel panel-default flex-col">
            <h2 class=""><i class="material-icons icon-large">mood</i></h2>

         <h4>It's free to use</h4>
         <p>It's free forever to search and discover job opportunities.</p>
                 <a href="<?php echo site_url()?>/register"><button class='btn btn-raised' style="margin-bottom:20px;">Sign up with email</button></a>
         <p>Or sign up using a social media account: </p>
          <!--SOCIAL MEDIA-->
             <div class="register-pg-social">
                 <a href="http://lostgrad.com/login/?loginFacebook=1&amp;redirect=http://localhost/LGWP" onclick="window.location = 'http://lostgrad.com/login/?loginFacebook=1&amp;redirect='+window.location.href; return false;">
                 	<button class='btn btn-raised btn-fb'>Sign up with facebook</button>
                 </a>
                 <br>
                 <a href="http://lostgrad.com/login/?loginTwitter=1&amp;redirect=http://localhost/LGWP" onclick="window.location = 'http://lostgrad.com/login/?loginTwitter=1&amp;redirect='+window.location.href; return false;">
                 	<button class='btn btn-raised btn-twitter'>Sign up with twitter</button>
                 </a>
             </div>
           </div>
      </div>

            <div class='col-md-4 col-xs-12'>
                <div class="panel panel-default flex-col">
                    <h2 class=""><i class="material-icons icon-large">search</i></h2>

                <h4>Try the search</h4>
                <p>Use key word searches to discover jobs from all over the UK.</p>
                <br>
                    <?php get_search_form(); ?>
                <br>
                <p>Members can see full sets of results from their searches, so <a href="<?php echo site_url();?>/register">sign up</a> now.</p>

            </div>
          </div>
        </section>

    </div>
