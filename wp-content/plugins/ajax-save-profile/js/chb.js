$(document).ready(function(){

  var type='';
  if($('form').hasClass('profession')){
    type='profession';
  }
  else if($('form').hasClass('location')){
    type='location';
  }

  $(':checkbox').change(function() {

      show_saving();

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
          show_saved();
        }
      })

  });

});

function show_saving(){
  $bottomleft = $('#profile-edit-form').find('.bottom-left');
  $bottomleft.fadeIn()
  $bottomleft.empty().append('Saving')
}

function show_saved(){

  $bottomleft.empty().append('Saved').delay(2000).queue(function(next){
    $bottomleft = $('#profile-edit-form').find('.bottom-left');
      $bottomleft = $(this).parents('#profile-edit-form').find('.bottom-left');
        $bottomleft.fadeOut();
        next();
  });
}
