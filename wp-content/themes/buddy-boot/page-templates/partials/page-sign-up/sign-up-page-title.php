       
          <?php if ($page_number==0){ 
        	$page_number=1;
     	 }
        
         echo '<div class="box-head container"><div style="float:left;"><p>Page <span class="page-num">'.$page_number.'</span> for your selections </p></div>';?>
                <?php include('sign-up-selected-panel-inline.php') ;
                echo '</div>';
                
                ?>
            
        
