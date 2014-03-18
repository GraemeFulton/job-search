 <div class='single_post_content'>
   
     
     <div class='single_content'>
  
        <div class="single_cont">
        <div id="single_youtube_player"><?php echo $video?></div>

               <h4>Description</h4>
              <?php echo $the_content?>
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
