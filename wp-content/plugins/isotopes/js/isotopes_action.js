jQuery(document).ready(function ($) {



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
    
    $("#blog-page").isotope( 'reLayout' );    
     
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
    var $container = $('#blog-page');

    // initialize isotope
    $container.isotope({
     // options...
        masonry: {
           columnWidth: 0
        }
  
    });
    
    
   $('.click_to_post').click(function(e) { //this prevents title going to post-box
    
       e.preventDefault(); 
   });

   $('.clickme').click(function(){ 
	        
        disableClickMe();

       if(! $(this).closest(".item").hasClass("activepost"))
       {//if it isnt the active post
           //$(".item").removeClass("activepost").removeClass("activepost_edge");
           $(this).siblings(".post_image_wrapper").css("float", "left").css("margin-left", "10px");//move the image a bit
           $(this).siblings(".show_post_title").css("margin-left", "10px").css("margin-right", "10px");//move title to the right a bit

           $(this).siblings(".view_more_btn").show();
           $(this).siblings(".post-list-text").show();
           $(this).siblings(".facebook_twitter_buttons").show();//show facebook/twitter
           $(this).siblings(".show_vote_button").show();
           $(this).closest(".item").addClass("activepost");//make it an active post
           $(this).closest(".clickme").append("<div class='close_box'>X</div>")

	   closeBoxHandler();
             
       
           //get center of content box
           var pageCenter= ($("#main-content-left").width()/2);
           //get position of box clicked
          var leftOffset = ($(this).closest(".isotope-item").offset().left); 
            //work out the movement to the middle
          var movementAmount = (pageCenter-leftOffset)+offset;
          
  
      
            
            var arrowOffset= $(".slider-button").offset().top;
            
             var tp2=$(this).closest(".isotope-item").offset().top;
           topOffset= tp2-(arrowOffset)+250;
             
               $(this).closest(".item").addClass("activepost_edge");//make it an active post
                $(this).closest(".isotope-item").css("z-index", "6");

             
           $(this).closest(".box").animate(
                       {
                          left:  movementAmount,
                          position:"absolute",
                          top: -topOffset
               
                        },300,function()
                        {
                          $(".content").isotope( 'reLayout' ); 
                       $(this).closest(".isotope-item").css("z-index", "6");
                        });
  
       }
       
       else
       {
           $(this).closest(".item").removeClass("activepost").removeClass("activepost_edge");
           $(this).closest(".isotope-item").removeClass("activepost_edger").removeClass("activepost_edge");
           $(this).siblings(".view_more_btn").hide();
           $(this).siblings(".post-list-text").hide();
           $(this).siblings(".facebook_twitter_buttons").hide();
           $(this).siblings(".show_vote_button").hide();
           $(this).siblings(".post_image_wrapper").css("margin-left", "0px");//reset post_image_wrapper
           $(this).siblings(".show_post_title").css("margin-left", "6px").css("margin-right", "0px");//reset post_image_wrapper
       
       
              $(this).closest(".isotope-item").animate(
                {
                 'left':'0',
                 "z-index":"0",
                 position:"relative",
                 "top":"0"
                },300,"linear",function()
                {
                   $(".content").isotope( 'reLayout' ); 
                });
             
         $(".content").isotope( 'reLayout' ); 
         enableClickMe();
       };

      

    });
    
    //add click event to post_image - simply trigger the clickme click event
     $('.click_to_post').click(function(){ $(this).parent().siblings(".clickme").click(); });
    

}

function disableClickMe(){
	
             $(".clickme").unbind('click');
             $(".close_box").bind('click');

}

function enableClickMe(){
	
	$(".clickme").bind('click', function(){
		
		clickMeHandler();
		
		});
		
}

/*
 * closeActiveBox
 * When you scroll past an open box, and infinite scroll adds new boxes, this closes the open one
 */
function closeActiveBox(){
           $(".clickme").closest(".isotope-item").removeClass("activepost_edger").removeClass("activepost_edge");
           $(".clickme").siblings(".view_more_btn").hide();
           $(".clickme").siblings(".post-list-text").hide();
           $(".clickme").siblings(".facebook_twitter_buttons").hide();
           $(".clickme").siblings(".show_vote_button").hide();
           $(".clickme").siblings(".post_image_wrapper").css("margin-left", "0px");//reset post_image_wrapper
           $(".clickme").siblings(".show_post_title").css("margin-left", "6px").css("margin-right", "0px");//reset post_image_wrapper
     $(".activepost").closest(".isotope-item").animate(
                {
                 'left':'0',
                 "z-index":"0",
                 position:"relative",
                 "top":"0"
                },300,"linear",function()
                {
                    $(".content").isotope( 'reLayout' ); 
                    
                });
                $(".clickme").closest(".item").removeClass("activepost").removeClass("activepost_edge");
    $(".close_box").remove();     
}


function closeBoxHandler(){

$('.close_box').click(function(){ 
	
			$(this).closest(".item").removeClass("activepost").removeClass("activepost_edge");
           $(this).closest(".isotope-item").removeClass("activepost_edger").removeClass("activepost_edge");
           $(this).parent().siblings(".view_more_btn").hide();
           $(this).parent().siblings(".post-list-text").hide();
           $(this).parent().siblings(".facebook_twitter_buttons").hide();
           $(this).parent().siblings(".show_vote_button").hide();
           $(this).parent().siblings(".post_image_wrapper").css("margin-left", "0px");//reset post_image_wrapper
           $(this).parent().siblings(".show_post_title").css("margin-left", "6px").css("margin-right", "0px");//reset post_image_wrapper
		   $(this).removeClass("close_box");
		   
       
               $(this).closest(".isotope-item").animate(
                {
                 'left':'0',
                 "z-index":"0",
                 position:"relative",
                 "top":"0"
                },300,"linear",function()
                {
                    $(".content").isotope( 'reLayout' ); 
                    
                });
              
         $(".content").isotope( 'reLayout' ); 
         $(this).remove();
         enableClickMe();	
	});
	
}



function clickMeHandler(){
	    $(".box").show();

	 $('.click_to_post').click(function(e) { //this prevents title going to post-box
    
       e.preventDefault(); 
   });

   $('.clickme').click(function(){ 
	           $(this).closest(".clickme").append("<div class='close_box'>X</div>")

	   closeBoxHandler();
	   
	   	   disableClickMe();
                   

       if(! $(this).closest(".item").hasClass("activepost"))
       {//if it isnt the active post
           //$(".item").removeClass("activepost").removeClass("activepost_edge");
           $(this).siblings(".post_image_wrapper").css("float", "left").css("margin-left", "10px");//move the image a bit
           $(this).siblings(".show_post_title").css("margin-left", "10px").css("margin-right", "10px");//move title to the right a bit

           $(this).siblings(".view_more_btn").show();
           $(this).siblings(".post-list-text").show();
           $(this).siblings(".facebook_twitter_buttons").show();//show facebook/twitter
           $(this).siblings(".show_vote_button").show();
           $(this).closest(".item").addClass("activepost");//make it an active post
           
                          $('.activepost_edger').css({"z-index": "4"});
             
          ///////////////////
          //Left offset///////
          /////////////////// 
           //get center of content box
           var pageCenter= ($("#main-content-left").width()/2);
           //get position of box clicked
          var leftOffset = ($(this).closest(".isotope-item").offset().left); 
            //work out the movement to the middle
          var movementAmount = (pageCenter-leftOffset)+offset;
          
           ///////////////////
          //Right offset///////
          ///////////////////
        
          var rt = ($(window).width() - ($("#main-content-left").offset().left + $("#main-content-left").outerWidth()));
          var rt2 = ($(window).width() - ($(this).closest(".isotope-item").offset().left + $(this).closest(".isotope-item").outerWidth()));   
          var rightOffset= rt-rt2;
          var rightOffset= -rightOffset;
  
         
           if (topOffset!==0){
            
            var arrowOffset= $(".slider-button").offset().top;
            
            var tp=Math.floor(window.innerHeight/2);
             var tp2=$(this).closest(".isotope-item").offset().top;
             console.log("middle: "+arrowOffset);
                          console.log("ofset top: "+tp2);

             topOffset= tp2-(arrowOffset)+250;
             console.log("topOFfset: "+topOffset);
             
            
         }
         
    var width = $(window).width(); 
    if(!((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)))){     
          
           //right end
           if( rightOffset<80)
           { 
               $('.activepost_edgerLeft').css("z-index", "5");
                $(this).closest(".isotope-item").addClass("activepost_edger");//make it an active post
            
           }
        
          //right middle
                else  if( rightOffset>150 && rightOffset<600)
           {
                  $('.activepost_edgerLeft').css({"z-index": "5"});
                   $(this).closest(".isotope-item").addClass("activepost_edger");//make it an active post

          
           }
           //left middle
            else  if( rightOffset>700 && rightOffset<1300)
           {
                $('.activepost_edger').css({"z-index": "4"});
               $(this).closest(".isotope-item").addClass("activepost_edgerLeft");//make it an active post
               $(this).closest(".item").addClass("activepost_edge");//make it an active post
               $(this).closest(".isotope-item").addClass("activepost_edger");//make it an active post
                $(this).closest(".isotope-item").css("z-index", "6");

              
           }

               $(this).closest(".item").addClass("activepost_edge");//make it an active post
                $(this).closest(".isotope-item").css("z-index", "6");

               $(this).closest(".isotope-item").animate(
                       {
                          left:  movementAmount,
                          position:"absolute",
                          top: -topOffset
               
                        },300,function()
                        {
                           $(".content").isotope( 'reLayout' ); 
                      
                        });
         }
         else{
                $(this).closest(".isotope-item").css("z-index", "6");

           
                            $(".content").isotope( 'reLayout' ); 
                        
			 
			 }  
       }
       
       else
       {
           $(this).closest(".item").removeClass("activepost").removeClass("activepost_edge");
           $(this).closest(".isotope-item").removeClass("activepost_edger").removeClass("activepost_edge");
           $(this).siblings(".view_more_btn").hide();
           $(this).siblings(".post-list-text").hide();
           $(this).siblings(".facebook_twitter_buttons").hide();
           $(this).siblings(".show_vote_button").hide();
           $(this).siblings(".post_image_wrapper").css("margin-left", "0px");//reset post_image_wrapper
           $(this).siblings(".show_post_title").css("margin-left", "6px").css("margin-right", "0px");//reset post_image_wrapper
       
       
              $(this).closest(".isotope-item").animate(
                {
                 'left':'0',
                 "z-index":"0",
                 position:"relative",
                 "top":"0"
                },300,"linear",function()
                {
                    $(".content").isotope( 'reLayout' ); 
                });
              
         $(".content").isotope( 'reLayout' ); 
         enableClickMe();
       };

      

    });
    
    //add click event to post_image - simply trigger the clickme click event
     $('.click_to_post').click(function(){ $(this).parent().siblings(".clickme").click(); });
	
	
}
