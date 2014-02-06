/**
 * Part of the Sideways8 Simple Taxonomy Images plugin.
 * For WP 3.3-3.4.x
 */
jQuery(document).ready(function($) {
    var tbframe_interval;
    // Add our image by showing the media uploader
    $('#s8_tax_add_image').click(function() {
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        tbframe_interval = setInterval(function() {$('#TB_iframeContent').contents().find('.savesend .button').val('Use This Image');}, 2000);
        return false;
    });

    // Remove our image info so it won't be there when we save
    $('#s8_tax_remove_image').click(function() {
        $('#s8_tax_image').val('');
        $('#s8_tax_image_classes').val('');
        $('#s8_tax_image_preview').css('display', 'none');
        $('#s8_tax_add_image').css('display', 'inline-block');
        $('#s8_tax_remove_image').css('display', 'none');
    });

    // Runs from the media uploader
    window.send_to_editor = function(html) {
        clearInterval(tbframe_interval);
        img = $(html).find('img').andSelf().filter('img');
        imgurl = img.attr('src');
        imgclass = img.attr('class');
        $('#s8_tax_image').val(imgurl);
        $('#s8_tax_image_classes').val(imgclass);
        $('#s8_tax_image_preview').attr('src', imgurl).css('display', 'block');
        $('#s8_tax_add_image').css('display', 'none');
        $('#s8_tax_remove_image').css('display', 'inline-block');
        tb_remove();
    };
});
