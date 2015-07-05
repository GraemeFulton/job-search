       
          <?php if ($page_number==0){ 
        	$page_number=1;
     	 }
        
         echo '<div class="box-head container"><div style="float:left;"><p>Page <span class="page-num">'.$page_number.'</span> for your selections </p></div>';?>
                <?php include('sign-up-selected-panel-inline.php') ;
                echo '</div>';
                
                ?>
                
                 <?php if ($page_number==1){ ?>
                     <div class="container">
                        <h3 style="color:#999;"><i class="fa fa-thumbs-o-up"></i> Look what we've found!</h3>
                
                </div>
        <?php }?>
            
        
