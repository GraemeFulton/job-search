
           
            <?php 
            $user_ID = get_current_user_id();
            
           $parent_id= xprofile_get_field_id_from_name('Profession');      
          global $bp;
              global $wpdb;
        
        
                    $args = array(
               'taxonomy'      => 'profession',
               'parent'        => 0, // get top level categories
               'orderby'       => 'name',
               'order'         => 'ASC',
               'hierarchical'  => 1,
               'pad_counts'    => 0
           );
            
            $categories = get_categories( $args );
                        
            $subjects=array();
            foreach ( $categories as $category ){
            	array_push($subjects, xprofile_get_field_data($category->name, $user_ID));
            }
            
			$args = array(
               'taxonomy'      => 'location',
               'child_of'        => 292, // make sure they're a child of united kingdon
               'orderby'       => 'name',
               'order'         => 'ASC',
               'hierarchical'  => 1,
               'pad_counts'    => 0
           );
			
			
            
            $categories = get_categories( $args );
			$locations = array(); 
            foreach ( $categories as $category ){
            	
            	$sub_args = array(
            			'taxonomy'      => 'location',
            			'parent'        => $category->term_id, // get child categories
            			'orderby'       => 'name',
            			'order'         => 'ASC',
            			'hierarchical'  => 1
            	);
            	$sub_categories = get_categories( $sub_args );
            	array_push($locations, xprofile_get_field_data($category->name, $user_ID));
            	 
            }
	
                        
            
            if ($page_number>0){ ?>
                <div class='container box-head'>
            <h3><i class="fa fa-cog"></i> Your search preferences
    </h3>


            <?php 
    
              echo '<i class="fa fa-check-square-o"></i>'; 

               foreach ($subjects as $subject){
               	foreach($subject as $s){

               ?>
               <span class='selected'><?php echo $s;?> </span>

               <?php
               	}

               }


               //Locations
                  echo '<br><i class="fa fa-map-marker"></i>'; 

               foreach ($locations as $location){
               	foreach($location as $l){

               ?>
               <span class='selected'><?php echo $l;?> </span>

               <?php
               	}

               }



    ?>
        </div>
            <?php }
            else { ?>
               
               
               
           
    

    <div class='container-fluid sign-up-panel'>
    
        <div class='container box-head'> <h3 style='margin-top:10px;'><i class="fa fa-search"></i> Your search preferences</h3></div>

        <section class='search-criteria container text-center row-flex row-flex-wrap'>           
            
            <div class='col-sm-4 welcome-profile'>
                <div class="panel panel-default flex-col">
                <h4><i class="fa fa-cog"></i> Profile settings</h4>
                <div class='avatar-circle'>
					<?php global $userdata; get_currentuserinfo(); echo get_avatar( $userdata->ID, 46 ); ?>
                </div>
                <p>Job recommendations are based on the selections you make. </p>

               <div class="refine">
                           <button class='btn-success btn-outlined btn'>Refine your settings</button> 
               </div>
            </div>
            </div>
            
            
     <div class='col-sm-4 welcome-profile'>
         <div class="panel panel-default flex-col">
         <h4><i class="fa fa-check-square-o"></i>&nbsp;&nbsp;What</h4>
         <div class="vertical-align">
         		<div class="selected-options">
		                    <?php 
		            foreach ($subjects as $subject){
		            	
		            	foreach($subject as $s){
		
		               ?>
		               <span class='selected'><?php echo $s;?> </span>
		
		               <?php
		            	}
		               }
		           ?>
         	  	</div>
         	  	     <div class="refine">
					<button class="btn-success btn-outlined btn">+</button> 
	           </div>
		</div>
         </div>
      </div>
            
            <div class='col-sm-4 welcome-profile'>
              <div class="panel panel-default flex-col">
                <h4><i class="fa fa-map-marker"></i>&nbsp;&nbsp;Where</h4>
              <div class="vertical-align">
		         	<div class="selected-options">
		                
		                   <?php 
		            foreach ($locations as $location){
		            	
		            	foreach($location as $l){
		
		               ?>
		               <span class='selected'><?php echo $l;?> </span>
		
		               <?php
		            	}
		               }
		           ?>
		           </div>
	           <div class="refine">
					<button class="btn-success btn-outlined btn">+</button> 
	           </div>
           
         	</div>
         </div>
       </div>    
        </section>
     <?php };?>
    </div>