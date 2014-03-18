
            <div class="single_datagrid">
                   <?php echo $post_image?>
                   <table class="pop-out-tbl">
                       <tr><th colspan='2'>Details</th></tr>
                       <tr><td>Tagged: </td><td><?php echo $institution;?></td></tr>
                       <tr class="alt"><td>Topic: </td><td><?php echo $subject;?></td></tr>
                   </table>
                <button id='review_button' class='btn btn-success btn-large' style='background:goldenrod; border-color:goldenrod'>Write a Review</button>
                <br><div style="margin-top:5px;"><?php wpfp_link(); ?></div>     
               <div id='single_ratings'>
                     <h5>Reviews</h5>
                     <?php   echo do_shortcode('[WPCR_INSERT]' )?>
               </div>
            </div>