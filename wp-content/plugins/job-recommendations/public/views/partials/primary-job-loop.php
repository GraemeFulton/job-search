					<div class="post container">
					
                                           <?php 
                                           
                                                global $post;
                                                $job_tree=display_taxonomy_tree('profession', 'company');
                                                $link= $job_tree->types_post_type($post->ID, 'opportunity-url', 'raw');
                                                $location =get_post_meta($post->ID, 'location');
                                                ?>
							<?php 
                                                        
                                                        $popup= new Popup_Filter($post->ID, 'graduate-job', 'profession', 'company');

                                                        $popup->template_response('post_loop');
							?>
                                                    
					</div>