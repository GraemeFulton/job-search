
            <div class="single_datagrid">
                         <?php echo $post_image?>
                     <table class="pop-out-tbl">
                         <tr><th colspan='2'>Travel Opportunity Profile</th></tr>
                            <tr><td>Destination: </td><td><?php echo $institution;?></td></tr>
                            <tr class="alt"><td>Travel Type: </td><td><?php echo $post_type;?></td></tr>
                            <tr><td>Travel Agent:</td><td><img style="float:left; position:relative; max-height:35px; max-width:80px;" src="<?php echo $provider['src']?>"/></td></tr>
                            <tr class="alt"><td>Rating: </td><td><?php echo $ratings;?></td></tr>
                     </table>
                    <?php echo '<a class="btn btn-success btn-large" target="_blank" href="'.$link.'">Visit Source</a>';?>
                    <button id='review_button' class='btn btn-success btn-large' style='background:goldenrod; border-color:goldenrod'>Write a Review</button>
                                        <?php wpfp_link(); ?>
                       <div id='single_ratings'>
                  <h5>Reviews</h5>
                  <?php   echo do_shortcode('[WPCR_INSERT]' )?>
            </div>
            </div>  