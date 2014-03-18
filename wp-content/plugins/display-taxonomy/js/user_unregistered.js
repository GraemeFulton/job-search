function lg_registration_popup($,postoffset, flag){
   if(postoffset>12){
       
       if(scroll_more==false){

            $('.padder').append('<div class="lg_register_now"><h4>Register now to see more results:</h4>'
                    +'<img class="sign-up-logo"src="'+homeUrl+'/wp-content/uploads/lgsquare.png"/>'
                    +'<a href="'+homeUrl+'/register"><button class=" btn-signup-xlarge">Sign Up</button></a></div>');

       }
    return true;
   }
}
