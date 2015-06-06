
<?php 
//we want to store the user's preferences in their cookies
//and will do so in javascript

$location =  json_encode( $_GET['Location']);
$profession = json_encode($_GET['Profession']);
?>
<script>       
   $.cookie("Location",'<?php echo $lo;?>' , {path:"/"});
   $.cookie("Profession",'<?php echo $lo;?>' , {path:"/"});
</script>


     <?php 	 if ( have_posts() ) : 
			// Do we have any posts/pages in the databse that match our query?
			?>



				<?php while ( have_posts() ) : the_post(); 
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

			<?php else : // Well, if there are no posts to display and loop through, let's apologize to the reader (also your 404 error) ?>
				
				<article class="post error">
					<h1 class="404">Nothing posted yet</h1>
				</article>

			<?php endif; // OK, I think that takes care of both scenarios (having a page or not having a page to show)
                        ?>
 <?php if ($paged==1){  ?>

      <?php echo get_next_posts_link( '<p class="sign-up-next-link"><div class="container text-center sign-up-next"><h4>Show me more!</h4></div></p>', $qp->max_num_pages ); // display older posts link ?>


 <?php }else{ ?>

        <div class="container paginating"><?php posts_nav_link('&nbsp;&nbsp;','<div class="pull-left pagi-button"> Previous</div>','<div class="pull-right pagi-button">Next</div>'); ?></div>

 <?php } ?>
