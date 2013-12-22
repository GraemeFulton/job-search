<div class="datagrid">
    <table class="pop-out-tbl">
        <div id="youtube_player"><?php echo $video?></div>
        <tr><td>Destination: </td><td><?php echo $institution;?></td></tr>
        <tr class="alt"><td>Travel Type: </td><td><?php echo $post_type;?></td></tr>
        <tr><td>Travel Agent:</td><td><img style="float:left; position:relative; max-height:35px; max-width:80px;" src="<?php echo $provider['src']?>"/></td></tr>
        <tr class="alt"><td>Excerpt: </td><td><?php echo $excerpt;?></td></tr>
        <tr><td>Rating: </td><td><?php echo $ratings;?></td></tr>
    </table>
</div>
<?php echo replace_links('<a class="btn btn-success btn-large" href="'.$link.'">Read More</a>');?>