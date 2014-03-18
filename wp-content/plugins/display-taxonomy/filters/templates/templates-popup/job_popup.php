<?php 
$location= $this->get_jobs_location($tree);
?>
<div class="datagrid">
    <table class="pop-out-tbl">
        <!--<div id="youtube_player-<?php //echo $this->post_id?>"><?php //echo $video?></div>-->
        <tr><td>Offered By: </td><td><?php echo $institution;?></td></tr>
        <tr class="alt"><td>Profession: </td><td><?php echo $subject;?></td></tr>
        <tr><td>Location: </td><td><?php echo $location;?></td></tr>
        <tr class="alt"><td>Job Type: </td><td><?php echo $post_type;?></td></tr>
        <tr><td>Job Provider:</td><td><img style="float:left; position:relative; max-height:35px; max-width:80px;" src="<?php echo $provider['src']?>"/></td></tr>
        <tr class="alt"><td>Excerpt: </td><td><?php echo $excerpt;?></td></tr>
        <tr><td>Date Posted: </td><td><?php echo $post_date=get_the_time('Y-m-d', $this->post_id);?></td></tr>
        <?php 
        //get post date and add 30 days
        $e_date= strtotime("+30 days", strtotime($post_date)); 
        $expiry=date("Y-m-d", $e_date);
         
        $today=mktime(0,0,0,date("m"),date("d"),date("Y"));
        
        if($e_date>$today)
        {
            ?><tr class="alt"><td>Display Until: </td><td><?php echo $expiry;?></td></tr><?php       
        }else{ ?><tr class="alt"><td>Display Until: </td><td><span class="job-expiry">Expired!</span></td></tr><?php } ?>        
    </table>
</div>
<?php echo '<a class="btn btn-success btn-large" href="'.get_permalink( $this->post_id ).'">Read More</a>';?>
<?php echo ' <a class="btn btn-success btn-large apply" target="_blank" href="'.$link.'">Apply Now</a>';?>
<?php wpfp_link($this->post_id); ?>
<script>
    var $= jQuery;
    
     $('.wpfp-link').on('click', function() {
        dhis = $(this);
        wpfp_do_js( dhis, 1 );
        // for favorite post listing page
        if (dhis.hasClass('remove-parent')) {
            dhis.parent("li").fadeOut();
        }
        return false;
    });
</script>
