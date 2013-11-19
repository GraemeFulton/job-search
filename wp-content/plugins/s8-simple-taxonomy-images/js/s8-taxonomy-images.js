/**
 * Part of the Sideways8 Simple Taxonomy Images plugin.
 * For WP 3.5.x+
 */
jQuery(document).ready(function($) {
    var s8_sti_media_file_frame;
    // Attach the upload/add button to our functionality
    $( '#s8_tax_add_image' ).on( 'click', function(e) {
        e.preventDefault();
        if ( s8_sti_media_file_frame ) {
            s8_sti_media_file_frame.open();
            return;
        }
        // Create media frame using data elements from the clicked element
        s8_sti_media_file_frame = wp.media.frames.file_frame = wp.media( {
            title: 'Select An Image',
            button: { text: 'Use Image' },
            class: $(this).attr('id')
        } );
        // What to do when the image is selected
        s8_sti_media_file_frame.on( 'select', function() {
            var attachment = s8_sti_media_file_frame.state().get('selection').first().toJSON();
            $( '#s8_tax_image_preview' ).attr( 'src', attachment.url ).css( 'display', 'block' );
            // Put the attachment ID where we can save it
            $( '#s8_tax_image' ).attr( 'value', attachment.id );
            $( '#s8_tax_remove_image' ).css( 'display', 'inline-block' );
        } );
        // Open the modal
        s8_sti_media_file_frame.open();
    } );
    // Attach the remove button to our functionality
    $( '#s8_tax_remove_image' ).on( 'click', function(e) {
        e.preventDefault();
        $(this).css( 'display', 'none' );
        $( '#s8_tax_image_preview' ).css( 'display', 'none' );
        $( '#s8_tax_image' ).attr( 'value', '' );
    } );
});
