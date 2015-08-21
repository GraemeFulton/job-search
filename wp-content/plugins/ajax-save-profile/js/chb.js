$(document).ready(function(){

  var type='';
  if($('form').hasClass('profession')){
    type='profession';
  }
  else if($('form').hasClass('location')){
    type='location';
  }

  $(':checkbox').change(function() {

      var option_selected = $(this).val();

      $.ajax({
        type:'post',
        url:ajax_var.url,
        datatype:'text',

        data: {
          'action':'ajax_save',
          'selected':option_selected,
          'type':type
          },
        success:function(data){

        }
      })

  });

});
