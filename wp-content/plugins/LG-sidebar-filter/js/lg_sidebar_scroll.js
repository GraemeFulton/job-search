/*
 * scroll
 * 
 * after the page scrolls down a bit, the left bar, and breadcrumbs
 * click to the top.
 */
var lastFixPos = 0;
var threshold = 800;

function scrollHandler($){

        $(document).scroll(function () {
             //dont run if small window size
    if ($(window).width() < 1025) {return;}
    
            
    var y = $(this).scrollTop();
    if (y > 320) {
        $("#lg-sidebar-filter").css({"top":"72px","height":"95%","width":"20%","margin-left":"-6px", "position":"fixed", "overflow-y":"scroll"});
        $("#lg-gridview-container").css({"margin-left":"20%", "border-left":"1px solid rgba(0,0,0,0.3)"});
       // $("#sidebar-right").css("top", "0px");
        $("#selected-options").css({"position":"fixed", "top":"70px","right":"0px", "margin":"0px"});
     //   $("#selected-options-container").css({"position":"fixed", "top":"70px","right":"0px","margin":"0px"});

        //$(".sidebar-main").css({"margin-top":"240px", "border-top":"1px solid #ccc"});

   } 
    else{ 
        $("#lg-sidebar-filter").css({"top":"","height":"80%", "position":"relative","width":"", "overflow-y":"","margin-left":""});
                $("#lg-gridview-container").css({"margin-left":"", "border-left": ""});
        $("#selected-options").css({"position":"", "top":"", "right":"", "margin":""});
       // $("#selected-options-container").css({"position":"", "top":"",  "width":"", "margin":""});
//
//        $(".sidebar-main").css({"margin-top":"", "border-top":""});

    //    $("#sidebar-right").css("top", "");
     //   $("#breadcrumbs").css({"position":"relative", "top":""});

}
 if (y > 800) {
     
     $("#to_top").fadeIn();
     
 }
 else{$("#to_top").fadeOut();}
 
 var diff = Math.abs($(window).scrollTop() - lastFixPos);
  if(diff > threshold){

           // resetCurrentActiveBox($);            

    lastFixPos = $(window).scrollTop();
  }
 

});
    
    
}