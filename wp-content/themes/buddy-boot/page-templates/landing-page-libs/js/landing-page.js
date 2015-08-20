/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    $(document).ready(function() {

    	fullPageScroll();

    	highlightCheckBoxOptions();


    	hookButtons();
      $(window).resize(function () {
          //in order to call the functions only when the resize is finished
          $('html').addClass('hidden');
          location.reload();
      });

    	//nextButtonTextUpdater();

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
		        resize : false,
		        menu: '#pagi-menu'
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


    }
