<div class="datagrid">
    <table class="pop-out-tbl">       
        <?php echo $full_content;?>
    </table>
</div>
<?php echo '<a class="btn btn-success btn-large" href="'.$link.'">Learn Now</a>';?>
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
