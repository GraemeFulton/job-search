jQuery(document).ready(function($) {

    // Chosen Select Box replacement
    $('#icon_select').chosen({
    	disable_search_threshold: 10
    });

    var icowrap = $(".ico-wrap");
    var icotrig = $("#ico-trig");

    // icons button - toggle select
    $("#ico-trig, #ico-close").on("click", function() {
        icowrap.toggle();
        icotrig.toggle();
    });

    // FA4 CHZN icons
    $('#icon_select_chzn .chzn-results li').each(function() {
        $(this).addClass( 'wpvigen wpvigen-'+$(this).text() );
    });

    // - Gericons
    $("#icon_select").change(function() {
        var iconVal = $("#icon_select :selected").val();
            send_to_editor("&nbsp;<i class=\"wpvigen wpvigen-"+iconVal+"\"><span style=\"color:transparent;display:none;\">icon-"+iconVal+"</span></i>&nbsp;");
        return false;
    })

});