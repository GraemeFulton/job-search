/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


    $(document).ready(function() {

        $('#fullpage').fullpage({
verticalCentered:false,

afterLoad: function(anchorLink, index){
            //using index
            if(index == '2'){
        }
        },
                resize : false,
                menu: '#pagi-menu',


    });


        
        $('.box-container').click(function(){
            console.log('monk')
            var chk = $(this).closest('.image-box').find('[type=checkbox]')
            chk.prop("checked", !chk.prop("checked"));        
            
            $(this).toggleClass('box-active')
    
        })
    });
    