/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    $(document).ready(function() {
    	
    	fullPageScroll();
    	
    	highlightCheckBoxOptions();
    	
    	
    	hookButtons();





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
			        scrollingSpeed: 700,
			        autoScrolling: true,
			        fitToSection: true,
			        scrollBar: false,
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