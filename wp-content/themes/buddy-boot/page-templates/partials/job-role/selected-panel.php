<section class="container-fluid sign-up-panel">    
    <div class='container box-head'>
            <?php if ($page_number==0){ ?>
            <h3><i class="fa fa-cog"></i> Search settings
    </h3>


            <?php 
     $user_ID = get_current_user_id();
    $subjects = xprofile_get_field_data('Subjects', $user_ID);
              echo "Professions:"; 

               foreach ($subjects as $subject){

               ?>
               <span class='selected'><?php echo $subject;?> </span>

               <?php

               }


               //Locations
                  echo "<br>Locations:"; 

               foreach ($subjects as $subject){

               ?>
               <span class='selected'><?php echo $subject;?> </span>

               <?php

               }



    ?>
            <?php }
            else { ?>
               
               
               
            <?php };?>
        </div>
    </section>

    <div class='container-fluid sign-up-panel'>
        <div class='container box-head'> <h3 style='margin-top:10px;'><i class="fa fa-cog"></i> Search settings</h3></div>

        <section class='search-criteria container text-center row-flex row-flex-wrap'>           
            
            <div class='col-sm-4 welcome-profile'>
                <div class="panel panel-default flex-col">
                <h4><i class="fa fa-search"></i> Your preferences</h4>
                <div class='avatar-circle'>
                <?php  echo get_avatar( '', $size = '60' );?>
                </div>
                <p>Job recommendations are based on the selections you make. </p>

               <div class="refine">
                           <button class='btn-success btn-outlined btn'>Refine your preferences</button> 
               </div>
            </div>
            </div>
            
            
     <div class='col-sm-4 welcome-profile'>
         <div class="panel panel-default flex-col">
         <h4><i class="fa fa-check-square-o"></i>&nbsp;&nbsp;What</h4>
                    <?php 
            foreach ($subjects as $subject){

               ?>
               <span class='selected'><?php echo $subject;?> </span>

               <?php

               }
           ?>
         </div>
      </div>
            
            <div class='col-sm-4 welcome-profile'>
                <div class="panel panel-default flex-col">
                <h4><i class="fa fa-map-marker"></i>&nbsp;&nbsp;Where</h4>
                      <?php 
            foreach ($subjects as $subject){

               ?>
               <span class='selected'><?php echo $subject;?> </span>

               <?php

               }
           ?>
                </div>
            </div>    
        </section>
    
    </div>