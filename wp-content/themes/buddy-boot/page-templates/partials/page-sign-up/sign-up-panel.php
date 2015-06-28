    <div class='container-fluid sign-up-panel'>
        <div class='container box-head'> <h3 style='margin-top:10px;'>Get free full access now</h3></div>

        <section class='search-criteria container text-center row-flex row-flex-wrap'>

            <div class='col-sm-4 welcome-profile'>
                <div class="panel panel-default flex-col">
                <h4><i class="fa fa-search"></i> Improve your search</h4>
                <div class='avatar-circle'>
                <?php  echo get_avatar( '', $size = '60' );?>
                </div><?php include('partials/selected-options.php');?>
                    </p>
               <div class="refine">
               		<a href="<?php echo site_url();?>/register">
                    	<button class='btn-success btn-outlined btn'>Refine your preferences</button>
                    </a>
               </div>
            </div>
            </div>


     <div class='col-sm-4 welcome-profile'>
         <div class="panel panel-default flex-col">
         <h4><i class="fa fa-cog"></i> Save your preferences</h4>
          <!--SOCIAL MEDIA-->
             <div class="register-pg-social">
                 <a href="<?php echo site_url()?>/register"><button class='btn-success btn-outlined btn'>Sign in with email</button></a>
                 <br>
                 <a href="http://lostgrad.com/login/?loginFacebook=1&amp;redirect=http://localhost/LGWP" onclick="window.location = 'http://lostgrad.com/login/?loginFacebook=1&amp;redirect='+window.location.href; return false;">
                 	<button class='btn btn-large btn-fb'>Sign in with facebook</button>
                 </a>
                 <br>
                 <a href="http://lostgrad.com/login/?loginTwitter=1&amp;redirect=http://localhost/LGWP" onclick="window.location = 'http://lostgrad.com/login/?loginTwitter=1&amp;redirect='+window.location.href; return false;">
                 	<button class='btn btn-large btn-twitter'>Sign in with twitter</button>
                 </a>
             </div>
         </div>
      </div>

            <div class='col-sm-4 welcome-profile'>
                <div class="panel panel-default flex-col">
                <h4>Get better recommendations </h4>
                <p>We've found you some great graduate roles, but <a href="<?php echo site_url();?>/register">sign up</a> to get:</p>
                <ul>
                     <li><i class="fa fa-crosshairs"></i> Improved recommendations
                    <li><i class="fa fa-search"></i> More specific job categories
                    <li><i class="fa fa-cog"></i> Save your preferences

                </ul>
                </div>
            </div>
        </section>

    </div>