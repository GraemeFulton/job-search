$(document).ready(function(){

  $(':checkbox').change(function() {

      var option_selected = $(this).val();

      $.ajax({
        type:'post',
        url:ajax_var.url,
        datatype:'text',

        data: {
          'action':'ajax_save',
          'selected':option_selected
          },
        success:function(data){

        }
      })

  });

});
