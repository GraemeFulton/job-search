/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    $(document).ready(function() {

    	fullPageScroll();

    	highlightCheckBoxOptions();


    	hookButtons();

      touchSwipe();

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
			        touchSensitivity: 500,
			        normalScrollElementTouchThreshold: 5,

			        //Accessibility
			        keyboardScrolling: true,
			        animateAnchor: true,
			        recordHistory: true,

			        //Design
			        controlArrows: true,
			        resize : true,

			        menu: '#menu',
		        	navigation: true,
					navigationPosition: 'right',
					css3: true,
			        controlArrows: true,
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

    function touchSwipe(){
        $(".container-fluid").touchwipe({
         wipeLeft: function() { alert("left"); },
         wipeRight: function() { alert("right"); },
         wipeUp: function() { alert("up"); },
         wipeDown: function() { alert("down"); },
         min_move_x: 20,
         min_move_y: 20,
         preventDefaultEvents: true
        });
    }

   /*
    * Hook up buttons
    */

    function hookButtons(){


    	//Scroll down button
    	$('.btn-scroll-down').click(function(){
    		$.fn.fullpage.moveSectionDown();

    	})

      $('.btn-submit').click(function(){

          $('.container-fluid').children().css('opacity', '0.5');
          $('.loader-container').show().css('opacity', '0.9');

      })

    }
