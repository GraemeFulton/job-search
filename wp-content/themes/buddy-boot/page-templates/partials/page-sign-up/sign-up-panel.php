    <div class='container-fluid sign-up-panel'>
        <div class='container box-head'> <h3 style='margin-top:10px;'>Sign in to create your free account</h3></div>

        <section class='search-criteria container text-center row-flex row-flex-wrap'>           
            
            <div class='col-sm-4 welcome-profile'>
                <div class="panel panel-default flex-col">
                <h4><i class="fa fa-search"></i> Improve your search</h4>
                <div class='avatar-circle'>
                <?php  echo get_avatar( '', $size = '60' );?>
                </div>
                 <p>Your Profession(s):
            
           <?php 
           foreach ($_POST["Profession"] as $selected_profession){
               
           ?>
           <span class='selected'><?php echo $selected_profession;?> </span>
           
           <?php
               
           }
           
           ?>
<!--           <i class="fa fa-plus-circle"></i>-->
          </p>
  
           <p>Your Location(s):
            
           <?php 
           foreach ($_POST["Location"] as $selected_location){
               
           ?>
           <span class='selected'><?php echo $selected_location;?> </span>
           <?php
               
           }
           ?>
<!--                      <i class="fa fa-plus-circle"></i>-->
           </p>
               <div class="refine">
                           <button class='btn-success btn-outlined btn'>Refine your preferences</button> 
               </div>
            </div>
            </div>
            
            
     <div class='col-sm-4 welcome-profile'>
         <div class="panel panel-default flex-col">
         <h4><i class="fa fa-cog"></i> Save your preferences</h4>
          <!--SOCIAL MEDIA-->
             <div class="register-pg-social">
                 <button class='btn-success btn-outlined btn'>Sign in with email</button> 
                 <br>                
                 <button class='btn btn-large btn-fb'><a href="http://lostgrad.com/login/?loginFacebook=1&amp;redirect=http://localhost/LGWP" onclick="window.location = 'http://lostgrad.com/login/?loginFacebook=1&amp;redirect='+window.location.href; return false;">Sign in with facebook</a></button>
                 <br>
                 <button class='btn btn-large btn-twitter'><a href="http://lostgrad.com/login/?loginTwitter=1&amp;redirect=http://localhost/LGWP" onclick="window.location = 'http://lostgrad.com/login/?loginTwitter=1&amp;redirect='+window.location.href; return false;">Sign in with twitter</a></button>
             </div>
         </div>
      </div>
            
            <div class='col-sm-4 welcome-profile'>
                <div class="panel panel-default flex-col">
                <h4>Get better recommendations </h4>
                <p>We've found you some great graduate roles, but <a href="#">sign up</a> to get:</p>
                <ul>
                     <li><i class="fa fa-crosshairs"></i> Improved recommendations
                    <li><i class="fa fa-search"></i> More specific job categories   
                    <li><i class="fa fa-cog"></i> Save your preferences
                        
                </ul>
                </div>
            </div>    
        </section>
    
    </div>