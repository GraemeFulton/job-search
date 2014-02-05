jQuery(window).ready(function ($) {

   isotopes_pre_init($);
});


/*
 * isotopes_pre_init
 * @param {type} $
 * @returns {undefined}
 * sets up the page dimensions for isotopes
 */
function isotopes_pre_init($)
{
    
    var colWidth=175;
    var offset= 26;
    var width = $(window).width(); 
    var topOffset= 1;
    //var height = $(window).height(); 

    if (width<768)
    {
        colWidth=10;
        offset=2.5;
        topOffset=0;//CHANGE THIS TO MAKE POST GO TO TOP OF PAGE
      /////////////////////////////////
      //Top offset (for mobile)///////
      ///////////////////////////////

    }
    else 
    {
    offset=10;
    }

    if (navigator.userAgent.match(/iPhone/)) 
    {
      colWidth=10;
      offset=2.5;
    }
  
    isotopes_init($, colWidth,offset,topOffset);
}

function reset_isotopes($){
    
   var  $container= $('#loaded_content');
                       $container.isotope('destroy');

                        // initialize isotope
                        $container.isotope({
                         masonry: {
                                    columnWidth: 0
                                  }
                         });    
     	    $("#main-overlay").fadeOut();

}


/*
 * isotopes_init
 * @param {type} $
 * @param {type} colWidth
 * @param {type} offset
 * @param {type} topOffset
 * @returns {undefined}
 */
function isotopes_init($,colWidth,offset,topOffset)
{
        $('#content').prepend('<img id="ajax-loader-check-box" style="margin:10px 0 0 10px;"src="'+templateUrl+'/ajax-loader.gif"/>');

    // cache container    
     var $blogpage = $('#blog-page');
  var $container = $('#loaded_content');

    // initialize isotope
    //$(" .clickme").unbind('click');

        
    $container.isotope({
     // options...
      itemSelector: '.hentry',
        masonry: {
                   layoutMode : 'fitRows'

        },
        animationOptions: {
            duration: 800
        }
    
  
    })           

   .isotope( 'insert', $blogpage.find('.hentry') );
   $('#blog-page').show();
    //         setTimeout(function(){$('#blog-more').fadeIn(1000);}, 750);
    setTimeout(function(){$('.post_image').removeClass('is-loading');}, 1000);
    setTimeout(function(){$container.isotope('reLayout');}, 1050);

  setTimeout(function(){$('#ajax-loader-check-box').fadeOut('medium'); }, 100);
  //setTimeout(function(){$("#loaded_content").isotope( 'reLayout' ); }, 500);

    
setTimeout(function(){isotopes_modal($)},1300 )
}

function isotopes_modal($){
     $(" .clickme").unbind('click');
     $(" .clickme").bind('click');

    popup_listener($);
   $('.clickme').on('click',function(){ 
console.log('clik')
       disableClickMe($);

       if(! $(this).closest(".isotope-item").hasClass("activepost"))
       {//if it isnt the active post
           $("#main-overlay").fadeIn();

           
           $(this).css("z-index", "-1");
           $(this).siblings(".pop-out").show();
           $(this).siblings(".entry").hide();

          $(this).closest(".item").addClass("activepost");//make it an active post
           $(this).closest(".item").prepend("<div class='close_box'>X</div>");

            relayoutListener($)
            
            //get center of content box
                var pageCenter= ($(window).width()/2);
           //get position of box clicked
                var leftOffset = ($(this).closest(".isotope-item").offset().left); 
            //work out the movement to the middle
                var leftAnimation = (pageCenter-leftOffset)- $('.activepost').width()/2;
            //top offset
                var topAnimation= ($(this).offset().top)-($(window).scrollTop()+70);
             
           $(this).closest(".item").addClass("activepost_edge");//make it an active post
           $(this).closest(".isotope-item").css("z-index", "6");
             
           $(this).closest(".isotope-item").animate(
                       {
                          left:  leftAnimation,
                          position:"absolute",
                          top: -topAnimation
               
                        },320);
  
       }
       
       else
       {
           $(this).closest(".item").removeClass("activepost").removeClass("activepost_edge");
           $(this).closest(".isotope-item").removeClass("activepost_edger").removeClass("activepost_edge");
                
              $(this).closest(".isotope-item").animate(
                {
                 'left':'0',
                 "z-index":"0",
                 position:"relative",
                 "top":"0"
                },360,"linear");
             
         $("#loaded_content").isotope( 'reLayout' ); 
         enableClickMe($);
       };

      

    });
    

}

function disableClickMe($){
     $(".close_box").remove();

     $(" .clickme").unbind('click');
     $(".close_box").bind('click');
     

}

function enableClickMe($){
   
            isotopes_modal($);	
            graylien_infinite_scroll($);
                
}

/*
 * closeActiveBox
 * When you scroll past an open box, and infinite scroll adds new boxes, this closes the open one
 */
function closeActiveBox($){
    
    //if there's already an active box, don't need to run this
  //  if(!$(".activepost").length > 0)return;       
	    $("#main-overlay").fadeOut();

           $(".clickme").closest(".isotope").removeClass("activepost_edge");
           $(".clickme").closest(".activepost").children('.pop-out').hide();
           $(".clickme").closest(".activepost").children('.entry').show();

           $(".close_box").remove();   


     $(".activepost").closest(".isotope-item").animate(
                {
                 'left':'0',
                 "z-index":"0",
                 position:"relative",
                 "top":"0"
                },360,"linear");
                
                $(".activepost .clickme").css("z-index", "999");

                $(".clickme").closest(".item").removeClass("activepost").removeClass("activepost_edge");
               
            //re-enable isotope modal
              enableClickMe($);	
}




function closeBoxHandler($, post_id){

$('.close_box').unbind('click');
$('.close_box').bind('click',function(){ 
	    $("#main-overlay").fadeOut();

           $(this).parent(".item").removeClass("activepost").removeClass("activepost_edge");
           $(this).parent(".item").removeClass("activepost_edger").removeClass("activepost_edge");
            $(this).siblings(".clickme").css("z-index", "1");

            $(this).siblings(".pop-out").hide();
            $(this).siblings(".entry").show();
                

		//   $(this).removeClass("close_box");
		   
       
               $(this).closest(".isotope-item").animate(
                {
                 'left':'0',
                 "z-index":"0",
                 position:"relative",
                 "top":"0"
                },360,"linear");
              
         $(this).remove();
         enableClickMe($);	
        
            //stop any video
//            setTimeout(function(){
//                    var video = $("#youtube_player-"+post_id+"").children(":first").attr("src");
//                $("#youtube_player-"+post_id+"").children(":first").attr("src","");
//                $("#youtube_player-"+post_id+"").children(":first").attr("src",video);
//            }, 850)

	});

	
}


function relayoutListener($){

   var  $container= $('#loaded_content');

 if(!$(".activepost").length > 0){
        $container.isotope('reLayout');  
      //  setTimeout(isotopes_modal($), 500)
    } else{
        
        //when the active box is closed, do a relayout
        $('.close_box').unbind('click');
        
        $('.close_box').bind('click',function(){ 
        
         $("#main-overlay").fadeOut();

           $(this).parent(".item").removeClass("activepost").removeClass("activepost_edge");
           $(this).parent(".item").removeClass("activepost_edger").removeClass("activepost_edge");
            $(this).siblings(".clickme").css("z-index", "1");

            $(this).siblings(".pop-out").hide();
            $(this).siblings(".entry").show();
                

		//   $(this).removeClass("close_box");
		   
       
               $(this).closest(".isotope-item").animate(
                {
                 'left':'0',
                 "z-index":"0",
                 position:"relative",
                 "top":"0"
                },360,"linear", function(){
                    
                    $container.isotope('reLayout');
                    alert('relaying')
                   // setTimeout(isotopes_modal($), 500)
                });
              
         $(this).remove();
            graylien_infinite_scroll($);
        
        });
    } setTimeout(isotopes_modal($), 1500);

}

/*
 * resetCurrentActiveBox
 * if there is an open box, it gets closed
 */
function resetCurrentActiveBox($){
  
    closeActiveBox($);
    disableClickMe($);
//    setTimeout(function(){reset_isotopes($);isotopes_modal($);   
//    }, 100);
    
    
   
}
