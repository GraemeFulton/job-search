<?php

/* update gallery count by flickr */
add_filter('acn_gallery_count', 'acn_flickr_count');
function acn_flickr_count($count) {
	global $post;
	preg_match_all( "@flickr\.com/photos/([^/]*)/([^/]*)/@i", $post->post_content, $matches['flickr.com'], PREG_SET_ORDER );
	foreach($matches as $match) {
		foreach($match as $submatch) {
			$count++;
		}
	}
	return $count;
}

/* Show featured image from external source */
add_action('acn_featured_image_external', 'acn_flickr_featured');
function acn_flickr_featured($layout) {
	global $post, $acn;
	preg_match_all( "@flickr\.com/photos/([^/]*)/([^/]*)/@i", $post->post_content, $matches['flickr.com'], PREG_SET_ORDER );
	foreach($matches as $match) {
		$i = 0;
		foreach($match as $submatch) {
			$i++;
			if ($i == 1) {
				$result = $acn->get_image_external_array($submatch[0]);
				echo '<div class="acn-media '.$acn->grid_class('acn-media', $layout).'">
					<a href="'.get_permalink($post->ID).'">'.$acn->get_thumbnail_external( $layout, $result['html'] ,$result['title'] ).'</a>
					<a href="'.$result['html'].'" class="acn-full-image" rel="prettyPhoto" title="'.$result['title'].'"><i class="icon-resize-full"></i></a>';
					if ( ( $acn->get_option('show_social') || $acn->social === 'yes' ) && $social !== 'no' ) {
					echo '<div class="acn-socialbar">
							<div class="shareme" data-url="'.get_permalink($post->ID).'" data-text="'.$post->post_title.'"></div>
					</div><div class="acn-clear"></div>';
					}
				echo '</div>';
			}
		}
	}
}

/* paste flickr gallery urls */
add_action('acn_external_image_links', 'acn_flickr_photo_urls');
function acn_flickr_photo_urls($show_first) {
	global $post, $acn;
	$urls = array();
	preg_match_all( "@flickr\.com/photos/([^/]*)/([^/]*)/@i", $post->post_content, $matches['flickr.com'], PREG_SET_ORDER );
	foreach($matches as $match) {
		foreach($match as $submatch) {
			$urls[] = $submatch[0];
		}
	}
	
	$i = 0;
	if (count($urls)>1 && $show_first=1) {
		$count = count($urls);
	} else {
		$count = null;
	}
	foreach($urls as $url) {
		$i++;
		if ($i == 1) {
		$acn->get_gallery_link( $url, $show_first, $count );
		} else {
		$acn->get_gallery_link( $url, $show_first=0, $count );
		}
	}
}