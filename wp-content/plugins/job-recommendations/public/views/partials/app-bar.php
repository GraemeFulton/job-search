<!--template-job-recommendations-->
   <div class='no-pad box-head'>
        <?php 
        global $wp_query;
        if ($paged==0){ 
        	$paged=1;
     	 }
        
         echo '<div style="float:left;"><p>Page <span class="page-num">'.$paged.' of '.$wp_query->max_num_pages.'</span>'.$message.'</p></div>';?>
               <?php include('selections-tags.php') ;
                ?>
        
    </div>

<?php 
if($nothing_found==true){
    ?>
     <?php if ($paged<3){?>
	<div class="container container-margin-bottom">
		<h3 style="color:#999;"><i class="fa fa-thumbs-o-up"></i> We've found <?php echo $wp_query->found_posts;?> related jobs within the UK</h3>	
	   <p style="color:#999;"><i class="fa fa-info-circle"></i> There are no more jobs in the location you selected</p>
    </div>
    <?php } ?>

<?php
}   
?>