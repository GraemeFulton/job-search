
                <div class='container box-head'>
<div class="selections-table-container selections-table-inline">
	<table class="selections-table">
		<tr>
		<td>
		            <?php 
		            if(isset($_GET['Profession'])) {
		            	foreach ($_GET["Profession"] as $selected_profession) {
		            
		            		?>
		                                     <div class='selected profession'><?php echo ucfirst(str_replace("-jobs","",$selected_profession));?>
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
		</td>		
		<td>	
               <?php 


               //Locations
               if(isset($_GET['Location'])){
               	foreach ($_GET["Location"] as $selected_location){
               
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
    </td>
    </tr>
    </table>
    
    </div>
				<button class="btn-success btn-outlined btn pull-right btn-settings"><i class="fa fa-cog"></i></button> 
        </div>
          