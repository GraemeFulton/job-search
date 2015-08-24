$(document).ready(function(){

    //get the height and width
    var height = "innerHeight" in window
               ? window.innerHeight
               : document.documentElement.offsetHeight;

    var width = $(window).width();
    var win = window;

    //set the output html for popup:

     var output='';
     //bootstrap
     output+='<link rel="stylesheet" type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">'
     output+='<style>.redirect{margin-top:'+(height/4-100)+';} h4{color:#888; margin-bottom:0px; padding-bottom:0px;}.loader{width:150px; margin-top:-10px;</style>';

     //content
     output+= '<div class="container text-center redirect"><h4>We are forwarding you to the job advert site.</h4><br>';
     output+= '<img class="loader" src="'+url+'js/ajax-loader.gif"/>';
     output+= '</div>';


     //set the click counter
     var y = 0;


    //listen for click on job link
    $('.job-link').mousedown(function(event) {
      e.preventDefault();
      $('#myModal').modal('show');
      return;
            // switch (event.which) {
            //
            //     case 2:
            //         //Middle mouse button pressed
            //         $('.job-link').click()
            //         break;
            //     case 3:
            //         //Right mouse button pressed
            //         $('.job-link').click()
            //         break;
            //     default:
            //         //strange mouse
            //         $(this).attr('target','_self"');
            // }
        });


      //job link click triggered from mousedown
      $(".job-link").on("click", function(e)
      {

          //allow 2 clicks
          // if(y>1){
               e.preventDefault();
               $('#myModal').modal('show');
               return;
          //  }
       //increment the counter so we can allow an extra click
      //  y+=1;

          //if the counter is greater than 1, the modeal is shown, so set the window contents
      //     var link = this;
      //     var wind= window.open('', '', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width='+width/2+',height='+height/2+',left=40,top=150');
      //     wind.document.body.innerHTML = '';
      //     wind.document.write(output);
       //
      //     setTimeout(function(){
      //     wind.focus();
      //     }, 150)
       //
       //
      //  e.preventDefault();
       //
      //   //could just set timeout and load url:
      //   setTimeout(function(){
       //
      //       wind.location.href=(link.href)
       //
      //   }, 1200)


});


});
