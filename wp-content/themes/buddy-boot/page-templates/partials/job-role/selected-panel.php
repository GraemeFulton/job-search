
           
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
                <div class='container box-head'>
    </h3>
<div class="selections-table-container">
	<table class="selections-table">
		<tr>
			<th align="right"><i class="fa fa-check-square-o"></i></th>
			<td>
		            <?php 
		    
		               foreach ($subjects as $subject){
		               	foreach($subject as $s){
		
		               ?>
		               <div class='selected'><?php echo $s;?> </div>
		
		               <?php
		               	}
		
		               }
		               
		               ?>
			</td>	
			
		</tr>
	
		<tr>
			<th align="right"><i class="fa fa-map-marker"></i></th>
		<td>
               <?php 


               //Locations
                  echo ''; 

               foreach ($locations as $location){
               	foreach($location as $l){

               ?>
               <div class='selected'><?php echo $l;?> </div>

               <?php
               	}

               }



    ?>
    </td>
    </tr>
    </table>
    
    </div>
				<button class="btn-success btn-outlined btn"><i class="fa fa-cog"></i></button> 
        </div>
          