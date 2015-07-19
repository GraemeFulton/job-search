<?php
$location= $this->get_jobs_location($tree);
?>
                <div class="single_datagrid">
                             <?php //echo $post_image?>
                    <table class="pop-out-tbl">
                    	<tr><th><h5 class="small-title">Job details</h5></th></tr>
                        <tr><th>Company: </th><td><?php echo $institution;?></td></tr>
                        <tr class="alt"><th>Profession: </th><td><?php echo $subject;?></td></tr>
                        <tr><th>Location: </th><td><?php echo $location;?></td></tr>
                        <tr class="alt"><th>Job Type: </th><td><?php echo $post_type;?></td></tr>
                        <tr><th>Provider:</th><td><img style="float:left; position:relative; max-height:35px; max-width:80px;" src="<?php echo $provider['src']?>"/></td></tr>
                        <tr class="alt"><th>Excerpt: </td><td><?php echo $excerpt;?></td></tr>
                         <tr><th>Date Posted: </th><td><?php echo $post_date=get_the_time('Y-m-d', $this->post_id);?></td></tr>
            <?php 
        //get post date and add 30 days
        $e_date= strtotime("+30 days", strtotime($post_date)); 
        $expiry=date("Y-m-d", $e_date);
         
        $today=mktime(0,0,0,date("m"),date("d"),date("Y"));
        
        if($e_date>$today)
        {
            ?><tr class="alt"><th>Display Until: </th><td><?php echo $expiry;?></td></tr><?php       
        }else{ ?><tr class="alt"><th>Display Until: </th><td><span class="job-expiry">Expired!</span></td></tr><?php } ?> 
                    </table>
<?php echo ' <a class="btn-success btn-outlined btn apply" target="_blank" href="'.$link.'">Apply Now</a>';?>

                     
                    
                </div>