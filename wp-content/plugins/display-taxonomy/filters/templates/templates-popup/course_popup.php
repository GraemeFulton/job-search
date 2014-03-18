<div class="datagrid">
    <table class="pop-out-tbl">
        <!--<div id="youtube_player-<?php //echo $this->post_id?>"><?php //echo $video?></div>-->
        <tr><td>Offered By: </td><td><?php echo $institution;?></td></tr>
        <tr class="alt"><td>Subject: </td><td><?php echo $subject;?></td></tr>
        <tr><td>Course Type: </td><td><?php echo $post_type;?></td></tr>
        <tr class="alt"><td>Course Provider:</td><td><img style="float:left; position:relative; max-height:35px; max-width:80px;" src="<?php echo $provider['src']?>"/></td></tr>
        <tr><td>Excerpt: </td><td><?php echo $excerpt;?></td></tr>
        <tr class="alt"><td>Course Rating: </td><td><?php echo $ratings;?></td></tr>
    </table>
</div>
<?php echo '<a class="btn btn-success btn-large" href="'.get_permalink( $this->post_id ).'">Read More</a>';?>
<?php echo ' <a class="btn btn-success btn-large enroll" target="_blank" href="'.$link.'">Enroll</a>';?>
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