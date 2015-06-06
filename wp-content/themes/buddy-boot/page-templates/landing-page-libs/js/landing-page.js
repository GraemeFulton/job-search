/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



    $(document).ready(function() {

        $('#fullpage').fullpage({
            verticalCentered:false,
            anchors: ['firstPage', 'secondPage', '3rdPage', '4thpage', 'lastPage'],
	menu: '#menu',
        slidesNavigation: true,
        	navigation: true,
				navigationPosition: 'right',
        
        afterLoad: function(anchorLink, index){
            //using index
             //using anchorLink
             var offset = $('.next-action').offset();
            var height = $('.next-action').height();
            var width = $('.next-action').width();
            var top = offset.top + height + "px";
            var right = offset.left + width + "px";

            $('.fp-slidesNav').css( {
                'position': 'absolute',
                'right': right,
                'top': top,
                'width':'100%'
            });
  
         
        },
                resize : true,
                menu: '#pagi-menu'


    });





        
        $('.box-container').click(function(){
            var chk = $(this).closest('.image-box').find('[type=checkbox]')
            chk.prop("checked", !chk.prop("checked"));        
            
            $(this).toggleClass('box-active')
    
        })
    });
    