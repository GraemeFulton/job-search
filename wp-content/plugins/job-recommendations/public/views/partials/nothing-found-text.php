       <div class='container box-head'>
        <?php 
        global $wp_query;
        if ($paged==0){ 
        	$paged=1;
     	 }
        
         echo '<div style="float:left;"><p>Page <span class="page-num">'.$paged.' of '.$wp_query->max_num_pages.'</span> jobs in other locations matching your preferences </p></div>'
               .'<a href="'.get_site_url() .'/members/'. bp_core_get_username( get_current_user_id() ) . '/profile/edit" class="btn-primary btn-raised btn pull-right btn-settings"><i class="fa fa-cog"></i></a>';
         ?>
    </div>

    <?php if ($paged<3){?>
	<div class="container container-margin-bottom">
		<h3 style="color:#999;"><i class="fa fa-thumbs-o-up"></i> We've found <?php echo $wp_query->found_posts;?> related jobs within the UK</h3>	
	   <p style="color:#999;"><i class="fa fa-info-circle"></i> There are no more jobs in the location you selected</p>
    </div>
    <?php } ?>