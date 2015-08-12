					<div class="post container">
					
                                           <?php 
                                           
                                                global $post;
                                                $job_tree=display_taxonomy_tree('profession', 'company');
                                                $link= $job_tree->types_post_type($post->ID, 'opportunity-url', 'raw');
                                                $location =get_post_meta($post->ID, 'location');
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
							<?php 
                                                        
                                                        $popup= new Popup_Filter($post->ID, 'graduate-job', 'profession', 'company');

                                                        $popup->template_response('post_loop');
							?>
                                                    
							
							<?php wp_link_pages(); // This will display pagination links, if applicable to the page ?>
						</div><!-- the-content -->
						 <div class='pull-right go-to-page'><i class="fa fa-chevron-right go-to-page-arrow"></i></div>

					</div>