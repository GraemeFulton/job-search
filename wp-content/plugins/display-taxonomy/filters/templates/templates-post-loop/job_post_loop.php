<?php 
$location= $this->get_jobs_location($tree);
?>
<div class="datagrid">
    <?php echo $excerpt;?>
        <!--<div id="youtube_player-<?php //echo $this->post_id?>"><?php //echo $video?></div>-->
Company: <?php echo $institution;?> | Profession:<?php echo $subject;?> | Location: <?php echo $location;?> | Job Type: <?php echo $post_type;?> | Job Provider:<img style="float:left; position:relative; max-height:35px; max-width:80px;" src="<?php echo $provider['src']?>"/>
        | Date Posted: <?php echo $post_date=get_the_time('Y-m-d', $this->post_id);?>
        <?php 
        //get post date and add 30 days
        $e_date= strtotime("+30 days", strtotime($post_date)); 
        $expiry=date("Y-m-d", $e_date);
         
        $today=mktime(0,0,0,date("m"),date("d"),date("Y"));
        
        if($e_date>$today)
        {
            ?><?php       
        }else{ ?>| <span class="job-expiry">30 days old</span><?php } ?>        
</div>