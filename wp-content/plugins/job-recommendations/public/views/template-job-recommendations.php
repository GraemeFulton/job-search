     <?php 	 if ( $wp_query->have_posts() ) : 
			// Do we have any posts/pages in the databse that match our query?
			?>



				<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
				// If we have a page to show, start a loop that will display it
				?>
<a  >
					<div class="post container">
					
                                           <?php 
                                           
                                                global $post;
                                                $job_tree=display_taxonomy_tree('profession', 'company');
                                                $link= $job_tree->types_post_type($this->post_id, 'opportunity-url', 'raw');
                                                ?>
						<div class="the-content job-feed-content">


                                            <?php
                                            //if user is not logged in, show popup links
                                            if(is_user_logged_in()==false) {

                                                 if ($paged == 1) {
                                                    ?>
                                                    <a class='job-link' href="<?php echo $link; ?>"><h4
                                                            class="title"><?php the_title(); // Display the title of the page ?></h4>
                                                    </a>

                                                <?php
                                                } else {
                                                    ?>
                                                    <a data-toggle="modal" id="add-cover-photo" data-target="#myModal"
                                                       data-href="<?php the_permalink(); ?>"><h4
                                                            class="title"><?php the_title(); // Display the title of the page
                                                            ?></h4></a>
                                                <?php

                                                }
                                            }
                                            //else show lostgrad links
                                            else{
                                                ?>
                                                <a href="<?php the_permalink(); ?>"><h4
                                                        class="title"><?php the_title(); // Display the title of the page
                                                        ?></h4></a>
                                            <?php
                                            }
                                                  ?>
							<?php the_content(); 
							// This call the main content of the page, the stuff in the main text box while composing.
							// This will wrap everything in p tags
							?>
							
							<?php wp_link_pages(); // This will display pagination links, if applicable to the page ?>
						</div><!-- the-content -->
						 <div class='pull-right go-to-page'><i class="fa fa-chevron-right go-to-page-arrow"></i></div>

					</div>
</a>
				<?php endwhile; // OK, let's stop the page loop once we've displayed it ?>

			<?php else : // Well, if there are no posts to display and loop through, let's apologize to the reader (also your 404 error) 
			include('template-job-none-found.php');
				
			endif; // OK, I think that takes care of both scenarios (having a page or not having a page to show)
                        ?>
 <?php if (!is_user_logged_in() && $paged==1){  ?>

      <?php echo get_next_posts_link( '<p class="sign-up-next-link"><div class="container text-center sign-up-next"><h4>Show me more!</h4></div></p>', $qp->max_num_pages ); // display older posts link ?>


 <?php }else{ ?>
 
        <div class="container paginating">
	        <div class="col-sm-2">
	        <?php previous_posts_link('<div class="pull-left pagi-button"> Previous</div>'); ?>
	        </div>
	        <div class="col-sm-8 page-navi mobile-hide desktop-show">
	         <?php wp_pagenavi(); ?>
	         </div>
	         <div class="col-sm-2">
			<?php next_posts_link( '<div class="pull-right pagi-button">Next</div>'); ?>
			</div>
			<div class="mobile-show">
			<?php wp_pagenavi_dropdown();?>
			</div>
        </div>

        
       
 <?php } ?>
