<?php
if(!is_user_logged_in()){

	?>


		            <?php
		            if(isset($_COOKIE["profession"])) {
									$selected_professions= StripSlashes($_COOKIE["profession"]);
									//unserialize them
									$professions = unserialize($selected_professions);
		            	foreach ($professions as $selected_profession) {

										$name = ucfirst(str_replace("-jobs","",$selected_profession));
										$name = ucfirst(str_replace("-management","",$name));

		            		?>
		                           <div class='selected profession'><?php echo $name;?>
		                          </div>
		                                  <?php

		                                  }
		                              }
		                              else{

		                              	?>
		                              	  <div class='selected profession'>
		                              	  No profession selected
		                          </div>

		                              	<?php
		                              }

		               ?>

               <?php


               //Locations
               if(isset($_COOKIE['location'])){
								 $selected_locations= StripSlashes($_COOKIE["location"]);
 								//unserialize them
 								$locations = unserialize($selected_locations);
               	foreach ($locations as $selected_location){

               		?>
               				     <div class='selected location'> <?php echo $selected_location;?>
               				       </div>
               				        <?php

               				        }
               				    }
    else{

		                              	?>
		                              	  <div class='selected profession'>
		                              	  No location selected
		                          </div>

		                              	<?php
		                              }
    ?>
	<?php

}
else {
?>

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
    </h3>
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

<?php } ?>
