         
 <div class='single_post_content'>
   
     
     <div class='single_content'>
           <div id="single_youtube_player"><?php echo $video?></div>

            <div class="single_datagrid">
                   <?php echo $post_image?>
                   <table class="pop-out-tbl">
                       <tr><th colspan='2'>Course Profile</th></tr>
                       <tr><td>Offered By: </td><td><?php echo $institution;?></td></tr>
                       <tr class="alt"><td>Subject: </td><td><?php echo $subject;?></td></tr>
                       <tr><td>Course Type: </td><td><?php echo $post_type;?></td></tr>
                       <tr class="alt"><td>Course Provider:</td><td><img style="float:left; position:relative; max-height:35px; max-width:80px;" src="<?php echo $provider['src']?>"/></td></tr>
                       <tr><td>Course Rating: </td><td><?php echo $ratings;?></td></tr>
                   </table>
               <?php echo '<a class="btn btn-success btn-large" href="'.$link.'">Learn Now</a>';?>
               <button id='review_button' class='btn btn-success btn-large' style='background:goldenrod; border-color:goldenrod'>Write a Review</button>
                                           <?php wpfp_link(); ?>
               
            </div>
           
           
        <h4>Description</h4>
       <?php echo $the_content?>

        <div id='single_ratings'>
              <h5>Reviews</h5>
              <?php   echo do_shortcode('[WPCR_INSERT]' )?> 
        </div>
     </div>
            
 </div>

  <script>
       var open=false;
        jQuery('#review_button').click(function()
        {
            
            if (open==false){   
            jQuery('#wpcr_button_1').trigger('click');
            open=true;
        }
                           
            jQuery('body').scrollTo('#wpcr_commentform ');
        })
   </script>
     
     
     