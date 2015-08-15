$(document).ready(function(){
  pageLoaded()
  window.onbeforeunload = showProgress;

  horizontal_menu_listener();
  side_nav_listener();

})

function side_nav_listener(){
  $('.menu li').click(function(){
    $('.box-head').children('li').fadeOut();

    $(this).addClass('active');
    $item = $(this)
    $item.siblings().removeClass('active');


    if(!$item.parents('.menu-group').hasClass('active')){

      $('.menu li.active').removeClass('active');
      $(this).addClass('active');

      var $previouslyActive = $('.menu-group.active')
      $('.menu-group.active').removeClass('active');
      $item.parents('.menu-group').addClass('active');
      $(".menu-group:not(.active)").fadeTo("fast", 0);

      swapsies($item.parents('.menu-group'), $previouslyActive)


      $item.parents('.menu-group').find('li').first().addClass('active')

    }
    else{
      $('.sub-menu .active').removeClass('active');
      $(this).addClass('active');

    }
  })
}

function horizontal_menu_listener(){

    $('.box-head li').click(function(){
      $('.box-head li.current').removeClass('current')
      $(this).addClass('current');
    })
}

var animating=false;

function swapsies(menugroup, replacegroup){

    if (animating) {
        return;
    }

    var clickedDiv = menugroup,
        prevDiv = replacegroup,
        distance = $(menugroup).offset().top - $('.menu').offset().top;

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
            $(".menu-group:not(.active)").fadeTo("fast", 1);

        });
    }

}

function showProgress() {
  $('.col-md-9.col-xs-12').children().css('opacity', '0.5');
  $('.loader-container').show().css('opacity', '0.8');
}

function pageLoaded(){
    $('.col-md-9.col-xs-12').fadeIn("100", function () {
      $('footer').css('visibility', 'visible');
      $('.sign-up-page.sign-up-panel').css('visibility', 'visible');
      setTimeout(function(){
        $('.checkbox-material').fadeTo("slow", 1);
      }, 150)


    })

    //$('.btn-settings').fadeIn();

}
