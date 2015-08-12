<div class="container list-main-content">
    <div class="pull-left col-xs-8">
    <?php   //if user is not logged in, show popup links
        if(is_user_logged_in()==false) {
            if ($paged == 1) {?>
            <a class='job-link' href="<?php echo $link; ?>">
                <h4 class="title"><?php the_title(); // Display the title of the page ?></h4>
            </a>
    <?php } else { ?>
            <a data-toggle="modal" id="add-cover-photo" data-target="#myModal" data-href="<?php the_permalink(); ?>">
                <h4 class="title">
                    <?php the_title(); // Display the title of the page ?>
                </h4>
            </a>
    <?php }
    }//else show lostgrad links
    else{ ?>
    <a href="<?php the_permalink(); ?>">
        <h4 class="title">
        <?php the_title(); // Display the title of the page
    ?></h4>
    </a>
    <?php
    } ?>
    </div>
    <div class="col-xs-4 pull-right">
        <!--<div id="youtube_player-<?php //echo $this->post_id?>"><?php //echo $video?></div>-->
        <?php
        $post_date=get_the_time('Y-m-d', $this->post_id);
           $now = time(); // or your date as well
            $your_date = strtotime($post_date);
            $datediff = $now - $your_date;
            $total_days= floor($datediff/(60*60*24));
            $days_ago = '';
            if ($total_days>30){
                $days_ago = '<div class="time pull-right">30+ days ago</div>';
            }
            else{
               '<div class="time pull-right">'. $days_ago = ''.$total_days.' days ago</div>';
            }
            echo $days_ago;
            ?>     
    </div>
</div>
    
    
    <?php 
    $location= $this->get_jobs_location($tree);
    ?>
<div class="container no-pad">
   <? echo $excerpt;?>
         <i class="fa fa-building-o"></i> <span><?php echo $institution;?></span>&nbsp;
    <i class="fa fa-map-marker"></i> <span><?php echo $location;?></span>&nbsp; 
</div>

