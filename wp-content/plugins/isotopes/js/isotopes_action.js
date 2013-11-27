jQuery(window).ready(function ($) {

//$(".item").addClass("isotope-item");

   isotopes_pre_init($);
   
   scrollHandler($);
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
    
    $("#loaded_content").isotope( 'reLayout' );    
     
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
    // cache container    
     var $blogpage = $('#blog-page');
  var $container = $('#loaded_content');

    // initialize isotope
    $container.imagesLoaded(function(){
    $container.isotope({
     // options...
      itemSelector: '.hentry',
        masonry: {
           columnWidth: 0
        }
    
  
    });
    }).isotope( 'insert', $blogpage.find('.hentry') );
    
    isotopes_modal($);
}

function isotopes_modal($){
    
   $('.clickme').click(function(){ 
        disableClickMe($);

       if(! $(this).closest(".isotope-item").hasClass("activepost"))
       {//if it isnt the active post
           //$(".item").removeClass("activepost").removeClass("activepost_edge");
            $(this).css("z-index", "-1");

           $(this).siblings(".entry").children('p').show();
          $(this).closest(".item").addClass("activepost");//make it an active post
           $(this).closest(".item").prepend("<div class='close_box'>X</div>");

	   closeBoxHandler($, this);

            //get center of content box
             var pageCenter= ($("#content").width()/2);
           //get position of box clicked
              var leftOffset = ($(this).closest(".isotope-item").offset().left); 
            //work out the movement to the middle
              var movementAmount = (pageCenter-leftOffset)-100;
          
           var arrowOffset=  $(".slider-button").offset().top;
           var tp2=$(this).offset().top;
           topOffset= tp2-(arrowOffset);
             
           $(this).closest(".item").addClass("activepost_edge");//make it an active post
           $(this).closest(".isotope-item").css("z-index", "6");
             
           $(this).closest(".isotope-item").animate(
                       {
                          left:  movementAmount+350,
                          position:"absolute",
                          top: -topOffset-150
               
                        },200,function()
                        {
                  //      
                          $("#loaded_content").isotope( 'reLayout' ); 
                       $(this).closest(".isotope-item").css("z-index", "6");
                        });
  
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
                },300,"linear",function()
                {
                   $("#loaded_content").isotope( 'reLayout' ); 
                });
             
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
    
}

/*
 * closeActiveBox
 * When you scroll past an open box, and infinite scroll adds new boxes, this closes the open one
 */
function closeActiveBox($){
    
    //if there's already an active box, don't need to run this
     if(!$(".activepost").length > 0)return;       
    
           $(".clickme").closest(".isotope-item").removeClass("activepost_edger").removeClass("activepost_edge");
                      $(".clickme").closest(".activepost").children('.entry').children('p').hide();
                                      $(".close_box").remove();   


     $(".activepost").closest(".isotope-item").animate(
                {
                 'left':'0',
                 "z-index":"0",
                 position:"relative",
                 "top":"0"
                },300,"linear",function()
                {
                    $("#loaded_content").isotope( 'reLayout' ); 
                    
                });
                $(".clickme").closest(".item").removeClass("activepost").removeClass("activepost_edge");
               
            //re-enable isotope modal
           closeActiveBox($);
            disableClickMe($);
            setTimeout(function(){isotopes_modal($);}, 500);
}



function closeBoxHandler($){

$('.close_box').click(function(){ 
	
	   $(this).parent(".item").removeClass("activepost").removeClass("activepost_edge");
           $(this).parent(".item").removeClass("activepost_edger").removeClass("activepost_edge");
            $(this).siblings(".clickme").css("z-index", "1");

            $(this).siblings(".entry").children('p').hide();
                

		//   $(this).removeClass("close_box");
		   
       
               $(this).closest(".isotope-item").animate(
                {
                 'left':'0',
                 "z-index":"0",
                 position:"relative",
                 "top":"0"
                },300,"linear",function()
                {
                    
                });
              
         $(this).remove();
         enableClickMe($);	
                          $("#loaded_content").isotope( 'reLayout' ); 

	});

	
}


/*
 * scrollHandler
 * 
 * after the page scrolls down a bit, the left bar, and breadcrumbs
 * are positioned at the top.
 */
var lastFixPos = 0;
var threshold = 800;

function scrollHandler($){
    
        $(document).scroll(function () {

 var diff = Math.abs($(window).scrollTop() - lastFixPos);
  if(diff > threshold){

            resetCurrentActiveBox($);            

    lastFixPos = $(window).scrollTop();
  }
 

});
    
    
}



/*
 * resetCurrentActiveBox
 * if there is an open box, it gets closed
 */
function resetCurrentActiveBox($){
  
    closeActiveBox($);
    disableClickMe($);
    setTimeout(function(){reset_isotopes($);isotopes_modal($);}, 100);
    
    
   
}
