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
        <tr><td>Rating: </td><td><?php echo $ratings;?></td></tr>
    </table>
</div>
<?php echo replace_links('<a class="btn btn-success btn-large" href="'.$link.'">Apply Now</a>');?>