<?php

$GLOBALS['relatedPostsViaTaxonomies_activate'] = new relatedPostsViaTaxonomies_activate();


class relatedPostsViaTaxonomies_activate
{

	function activate() {
		$option_post = array (
			'auto_display' => 'yes',
			'maximum_number_of_related_posts' => 10,
			'related_posts_title' => 'Related Posts via Taxonomies',
			'before_related_posts_title_and_related_posts' => '',
			'after_related_posts_title_and_related_posts' => '',
			'before_related_posts_title' => '<h2 id="related-posts-via-taxonomies-title">',
			'after_related_posts_title' => '</h2>',
			'before_related_posts' => '<ul id="related-posts-via-taxonomies-list">',
			'after_related_posts' => '</ul>',
			'before_each_related_post' => '<li>',
			'after_each_related_post' => '</li>',
			'order_by' => 'related_scores_high__date_published_new',
			'exclude_posts' => '',
			'exclude_all_categories' => '',
			'exclude_categories' => '',
			'exclude_all_tags' => '',
			'exclude_tags' => '',
			'post_types' => array( 'post' ),
			'promotion_link' => '',
			'promotion_link_text' => 'To the official site of Related Posts via Taxonomies.',
			'promotion_link_fontsize' => 12,
			'promotion_link_textalign' => 'right',
			'promotion_link_language' => 'english',
		);
		update_option( "related_posts_via_taxonomies", $option_post );
	}

} // class relatedPostsViaTaxonomies_activate





?>
