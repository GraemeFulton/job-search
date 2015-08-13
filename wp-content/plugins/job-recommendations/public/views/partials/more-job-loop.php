				
					<div class="post container">
					
                                           <?php 
                                           
                                                global $post;
                                                $job_tree=display_taxonomy_tree('profession', 'company');
                                                $link= $job_tree->types_post_type($this->post_id, 'opportunity-url', 'raw');
                                                ?>

							<?php 
                                                        
                                                        $popup= new Popup_Filter($post->ID, 'graduate-job', 'profession', 'company');

                                                        $popup->template_response('post_loop');
							?>
                                                    
							
							<?php wp_link_pages(); // This will display pagination links, if applicable to the page ?>

					</div>