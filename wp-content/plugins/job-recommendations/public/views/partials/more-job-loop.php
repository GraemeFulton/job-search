<div class="post container">
		<?php
			global $post;
			$job_tree=display_taxonomy_tree('profession', 'company');
			$link= $job_tree->types_post_type($this->post_id, 'opportunity-url', 'raw');

			$popup= new Popup_Filter($post->ID, 'graduate-job', 'profession', 'company');
			$popup->template_response('post_loop');
		?>
</div>
