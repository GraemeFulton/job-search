/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    $(document).ready(function() {
    	
    	fullPageScroll();
    	
    	highlightCheckBoxOptions();
    	
    	
    	hookButtons();

    	
    	nextButtonTextUpdater();




    });
    
    
    /*
     * Activate full page scroll
     */
    function fullPageScroll(){
    	
        $('#fullpage').fullpage({
            verticalCentered:false,
            anchors: ['firstPage', 'secondPage', '3rdPage', '4thpage', 'lastPage'],

					
			        
			        //Scrolling
			        css3: true,
			        autoScrolling: true,
			        fitToSection: true,
			        scrollBar: true,
			        easing: 'easeInOutCubic',
			        easingcss3: 'ease',
			        loopBottom: false,
			        loopTop: false,
			        loopHorizontal: true,
			        continuousVertical: false,
			        scrollOverflow: false,
			        touchSensitivity: 15,
			        normalScrollElementTouchThreshold: 5,
			        
			        //Accessibility
			        keyboardScrolling: true,
			        animateAnchor: true,
			        recordHistory: true,
			        
			        //Design
			        controlArrows: true,
			        resize : false,
			        responsive: 0,

			        menu: '#menu',
		        	navigation: true,
					navigationPosition: 'right',
					css3: true,
			        controlArrows: true,
		        resize : true,
		        menu: '#pagi-menu',
		        fixedElements: '#moveDown, #moveUp'
        });
        
    }
    
    /*
     * When check box is clicked, highlight it
     */
    function highlightCheckBoxOptions(){
        $('.box-container').click(function(){
            var chk = $(this).closest('.image-box').find('[type=checkbox]')
            chk.prop("checked", !chk.prop("checked"));        
            
            $(this).toggleClass('box-active')
    
        })
    }
    
    
    
   /*
    * Hook up buttons
    */
    
    function hookButtons(){
    	
    	
    	//Scroll down button
    	$('.btn-scroll-down').click(function(){
    		$.fn.fullpage.moveSectionDown();
    		
    	})
    	//Scroll accross button
    	$('.btn-scroll-right').click(function(){
    		$.fn.fullpage.moveSlideRight();

    		
    	})
    	//Scroll accross button
    	$('.btn-scroll-left').click(function(){
    		$.fn.fullpage.moveSlideLeft();
    	})
    	
    	
    }
    
    
    /*
     * update the text on the next button 
     * depending on the hash in the url
     */
    function nextButtonTextUpdater(){
    	
    	
    	
      	if(window.location.hash) {
      		
          	$('#moveDown').children('.btn-scroll-down').fadeIn();

    	      var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
    	      console.log(hash)
    	      if(hash=='firstPage'){
    	    	  
    	    	  $('#moveDown').children('.btn-scroll-down').text('Find me a job!');  	  
    	    	  
    	    	  
    	      }
    	  }
      	else{
          	$('#moveDown').children('.btn-scroll-down').text('Find me a job!');
      	}
      	
      	$(window).bind('hashchange', function() {
          	$('#moveDown').children('.btn-scroll-down').text('Next step');
          	$('#moveDown').children('.btn-scroll-down').unbind('click',showJobsClickHandler)
          	
          	var newHash = location.hash;
              
              // hide or show button (don't show on first page)
              if(newHash=='#firstPage'){
                	$('#moveDown').children('.btn-scroll-down').text('Find me a job!');
              }
              else{
              	$('#moveDown').children('.btn-scroll-down').text('Next step');
              }
              
              //change the text
              
              if(newHash=='#3rdPage'){
              	$('#moveDown').children('.btn-scroll-down').text('To the final step');
              }
              if(newHash=='#4thpage'){
                	$('#moveDown').children('.btn-scroll-down').text('Show me the jobs!');
                	$('#moveDown').children('.btn-scroll-down').click(showJobsClickHandler);

                }
              
          });
      	
      		function showJobsClickHandler(event){
      			
          		$('.btn-submit').click();

      		}
      	
    	
    }