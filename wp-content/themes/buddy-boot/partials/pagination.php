<?php
if (!is_user_logged_in() && $paged==1){  ?>
     <div class="col-md-12 container no-pad pad-top">
    <?php echo get_next_posts_link( '<p><button class="btn btn-primary btn-large btn-raised">View more jobs</button></p>', $qp->max_num_pages ); // display older posts link ?>
      </div>

<?php }else{ ?>

      <div class="col-md-12 text-center paginating">
        <div class="col-sm-2 pager pull-left no-pad">
                  <li class='pull-left'>
        <?php previous_posts_link('Previous'); ?>
                  </li>
        </div>
        <div class="col-sm-8 page-navi mobile-hide desktop-show">
         <?php wp_pagenavi(); ?>
         </div>
        <div class="col-sm-2 pager pull-right no-pad">
                  <li class='pull-right'>
        <?php next_posts_link('Next'); ?>
                  </li>
        </div>
    <div class="mobile-show">
    <?php wp_pagenavi_dropdown();?>
    </div>
      </div>



<?php } ?>
