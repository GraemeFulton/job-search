$(document).ready(function(){


    //listen for click on job link
    $('.list-container').mousedown(function(e) {
      e.preventDefault();
      $('#myModal').modal('show');
      return;
        });


      //job link click triggered from mousedown
      $(".list-container").on("click", function(e)
      {

               e.preventDefault();
               $('#myModal').modal('show');
               return;

});


});
