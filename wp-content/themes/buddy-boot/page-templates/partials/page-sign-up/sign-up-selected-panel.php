
                <div class='container box-head'>
            <h3><i class="fa fa-search"></i> Your search preferences
    </h3>


            <?php 
    
              echo '<i class="fa fa-check-square-o"></i>'; 
              if(isset($_GET['Profession'])) {
              	foreach ($_GET["Profession"] as $selected_profession) {
              
              		?>
                          <span class='selected'><?php echo ucfirst(str_replace("-jobs","",$selected_profession));?></span>
              
                      <?php
              
                      }
                  }
                  else echo "none";


               //Locations
                  echo '<br><i class="fa fa-map-marker"></i>'; 

				    if(isset($_GET['Location'])){
				        foreach ($_GET["Location"] as $selected_location){
				
				        ?>
				        <span class='selected'><?php echo $selected_location;?></span>
				        <?php
				
				        }
				    }
				    else echo 'none';
    		?>
        </div>
    </div>