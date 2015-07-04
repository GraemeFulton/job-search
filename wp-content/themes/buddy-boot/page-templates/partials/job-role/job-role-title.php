    <div class='container box-head'>
        <?php if ($page_number==0){ 
        	$page_number=1;
     	 }
        
         echo '<div style="float:left;"><p>Page <span class="page-num">'.$page_number.'</span> for your selections </p></div>';?>
               <?php include('selected-panel-inline.php') ;
                ?>
        
    </div>