
           
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
	
                        
 ?>
                <div>
    </h3>
<div class="selections-table-container selections-table-inline">
		            <?php 
		    
		               foreach ($subjects as $subject){
		               	foreach($subject as $s){
		
		               ?>
		              <div class='selected profession'><?php echo $s;?> </div>
		
		               <?php
		               	}
		
		               }
		               
		               ?>		
               <?php 


               //Locations

               foreach ($locations as $location){
               	foreach($location as $l){

               ?>
		           <div class='selected location'><?php echo $l;?> </div>
               
               <?php
               	}

               }
    ?>
 
    </div>
				<a href="<?php echo get_site_url() .'/members/'. bp_core_get_username( get_current_user_id() ) . '/profile/edit';?>" class="btn-success btn-outlined btn pull-right btn-settings"><i class="fa fa-cog"></i></a> 
        </div>
          