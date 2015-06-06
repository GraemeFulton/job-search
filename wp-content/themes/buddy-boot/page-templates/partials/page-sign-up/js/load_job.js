$(document).ready(function(){
   
    var height = "innerHeight" in window 
               ? window.innerHeight
               : document.documentElement.offsetHeight;
               
    var width = $(window).width();
    var win = window;
   
      
    //allow 2 clicks
  
//   var y = 0;
//   $('.job-link').click(function(e){
//       
//       if(y>1){
//           e.preventDefault();
//           $('#myModal').modal('show');
//       }
//       y+=1;
//   })
   
   
 ////////////////////////////////////////////////////////
 var html='';

 //create html for popup:
 
 var output='';
 //bootstrap
 output+='<link rel="stylesheet" type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">'
 output+='<style>.redirect{margin-top:'+(height/4-100)+';} h4{color:#888; margin-bottom:0px; padding-bottom:0px;}.loader{width:150px; margin-top:-10px;</style>';
 
 //content
 output+= '<div class="container text-center redirect"><h4>We are forwarding you to the job advert site.</h4><br>';
 output+= '<img class="loader" src="'+url+'js/ajax-loader.gif"/>';
 output+= '</div>';

 
 
 ////////////////////////////////////////////////////////
    var y = 0;


$('.job-link').mousedown(function(event) {
            switch (event.which) {
             
                case 2:
                    //alert('Middle mouse button pressed');
                    $('.job-link').click()
                    break;
                case 3:
                    //alert('Right mouse button pressed');
                    $('.job-link').click()
                    break;
                default:
                    //alert('You have a strange mouse');
                    $(this).attr('target','_self"');
            }
        });

   
  $(".job-link").on("click", function(e) {
      
          //allow 2 clicks

             if(y>1){
           e.preventDefault();
           $('#myModal').modal('show');
           return;
       }
       y+=1
        ////////////////////////////////////////////////////////

    var link = this;
     var wind= window.open('', '', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width='+width/2+',height='+height/2+',left=40,top=150');
    wind.document.body.innerHTML = '';
      wind.document.write(output);
      setTimeout(function(){
          wind.focus();     
          
      }, 150)
 

       e.preventDefault();
 
     //could just set timeout and load url:
        setTimeout(function(){
            
            wind.location.href=(link.href)
            
        }, 1200)

    
    //but lets load the html first
            
//             $.ajax({          
//            type:  'POST',
//            async:true,   //NOTE THIS
//            url:   url+'get_url.php',
//            data: {
//             'url': 'http://www.indeed.co.uk/viewjob?cmp=Bing-Web-Services&t=Java+Developer&jk=ed6ca78df72c08aa&sjdu=QwrRXKrqZ3CNX5W-O9jEvZwQkdvp3vspj8pA1b5F-zDXC-f--cLIQkX5_uplgsyGsHtm9_N-dO0LQX8RLIC7LA&pub=pub-indeed',
//         },
//         dataType: "html",
//            success: function(data){
//                
//                html=data;
//                console.log(html)
//                
//        //add jquery so we can remove the loading gif, whilst the timeout is running   
//        wind.document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>');
//   
//        setTimeout(function(){
//
//            wind.document.body.innerHTML = ''
//            wind.document.write(html);
//
//        }, 800)
//                
//                
//                
//            }
//         }); 
        
   

});
   
   
});