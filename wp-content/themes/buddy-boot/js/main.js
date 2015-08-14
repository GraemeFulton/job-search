$(document).ready(function(){

  $('.menu-group.active').parent().prepend($('.menu-group.active'));

  $('.menu li').click(function(){


    $(this).addClass('active');
    $item = $(this)
    $item.siblings().removeClass('active');


    if(!$item.parents('.menu-group').hasClass('active')){

      $('.menu li.active').removeClass('active');
      $(this).addClass('active');      
      swapsies($item.parents('.menu-group'), $('.menu-group.active'))
      $item.parents('.menu-group').addClass('active');
      $item.parents('.menu-group').find('li').first().addClass('active')

    }
    else{
      $('.sub-menu .active').removeClass('active');
      $(this).addClass('active');

    }



  })

})

var animating=false;

function swapsies(menugroup, replacegroup){

    if (animating) {
        return;
    }

    var clickedDiv = menugroup,
        prevDiv = replacegroup,
        distance = replacegroup.outerHeight();

    if (prevDiv.length) {
        animating = true;
        $.when(clickedDiv.animate({
            top: -distance
        }, 600),
        prevDiv.animate({
            top: 0
        }, 600)).done(function () {
            prevDiv.css('top', '0px');
            clickedDiv.css('top', '0px');
            clickedDiv.insertBefore(prevDiv);
            animating = false;
        });
    }

}
