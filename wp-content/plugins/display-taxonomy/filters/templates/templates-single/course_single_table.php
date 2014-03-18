     <div class="single_datagrid">
                   <?php echo $post_image?>
                   <table class="pop-out-tbl">
                       <tr><th colspan='2'>Course Profile</th></tr>
                       <tr><td>Offered By: </td><td><?php echo $institution;?></td></tr>
                       <tr class="alt"><td>Subject: </td><td><?php echo $subject;?></td></tr>
                       <tr><td>Course Type: </td><td><?php echo $post_type;?></td></tr>
                       <tr class="alt"><td>Course Provider:</td><td><img style="float:left; position:relative; max-height:35px; max-width:80px;" src="<?php echo $provider['src']?>"/></td></tr>
                       <tr><td>Instructor:</td><td><?php echo $instructor?></td></tr>
                         <tr class="alt"><td>Start Date:</td><td><?php echo $start_date;?></td></tr>
                       <tr><td>Length:</td><td><?php echo $course_length;?></td></tr>
                       <tr class="alt"><td>Course Rating: </td><td><?php echo $ratings;?></td></tr>
                   </table>
                <?php echo '<a class="btn btn-success btn-large enroll" target="_blank" href="'.$link.'">Enroll</a>';?> 
                <button id='review_button' class='btn btn-success btn-large' style='background:goldenrod; border-color:goldenrod'>Write a Review</button>
                <br><div style="margin-top:5px;"><?php wpfp_link(); ?></div>     
               <div id='single_ratings'>
                     <h5>Reviews</h5>
                     <?php   echo do_shortcode('[WPCR_INSERT]' )?>
               </div>
            </div>