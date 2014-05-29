<?php

$GLOBALS['relatedPostsViaTaxonomies_display'] = new relatedPostsViaTaxonomies_display();


class relatedPostsViaTaxonomies_display
{

	function core() {

		global $wpdb;
		
		$option_data = get_option("related_posts_via_taxonomies");
		$title = stripslashes( "$option_data[related_posts_title]" );
		$wrap_before = stripslashes( "$option_data[before_related_posts_title_and_related_posts]" );
		$wrap_after = "$option_data[after_related_posts_title_and_related_posts]";
		$before_title = stripslashes( "$option_data[before_related_posts_title]" );
		$after_title = "$option_data[after_related_posts_title]";
		$before_entries = stripslashes( "$option_data[before_related_posts]" );
		$after_entries = "$option_data[after_related_posts]";
		$before_entry = stripslashes( "$option_data[before_each_related_post]" );
		$after_entry = "$option_data[after_each_related_post]";
		$number_of_posts_to_show = "$option_data[maximum_number_of_related_posts]";
		$order_by = "$option_data[order_by]";
		$exclude_posts = "$option_data[exclude_posts]";
		if ( $exclude_posts ) {
			$exclude_posts .= ',';
		}
		$exclude_posts .= get_the_ID();
		if ( !$option_data['exclude_categories'] ){ $option_data['exclude_categories'] = array(); }
		$exclude_categories_str = implode( ",", $option_data['exclude_categories'] );
		if ( !$option_data['exclude_tags'] ){ $option_data['exclude_tags'] = array(); }
		$exclude_tags_str = implode( ",", $option_data['exclude_tags'] );
		if ( !$option_data['post_types'] ){ $option_data['post_types'] = array(); }
		$post_types_str = "'";
		$post_types_str .= implode( "','", $option_data['post_types'] );
		$post_types_str .= "'";
		if ( !$number_of_posts_to_show ) { $number_of_posts_to_show = 10;}

		if ( $title ){
			$title = "{$before_title}{$title}{$after_title}";
		}

		$args = "SELECT term_taxonomy_id FROM {$wpdb->term_relationships} WHERE object_id = " . get_the_ID();

		if ( $exclude_categories_str ) {
			$args .= " AND term_taxonomy_id NOT IN ( {$exclude_categories_str} )";
		}

		if ( $exclude_tags_str ) {
			$args .= " AND term_taxonomy_id NOT IN ( {$exclude_tags_str} )";
		}

		$exclude_term_taxonomy_ids = $wpdb->get_col( "SELECT term_taxonomy_id FROM {$wpdb->term_taxonomy} WHERE taxonomy = 'link_category'" );
		if ( $exclude_term_taxonomy_ids ) {
			$exclude_term_taxonomy_ids_str = implode( ",", $exclude_term_taxonomy_ids );
			$args .= " AND term_taxonomy_id NOT IN ( {$exclude_term_taxonomy_ids_str} )";
		}

		$custom_taxonomies = get_taxonomies( array( '_builtin' => false ), 'names' );
		if ( $custom_taxonomies ) {
			foreach ( $custom_taxonomies as $custom_taxonomy ) {
				$option_data_key = "exclude_{$custom_taxonomy}";
				if ( $option_data[$option_data_key] ) {
					$exclude_custom_taxonomies_str[$option_data_key] = implode( ",", $option_data[$option_data_key] );
					$args .= " AND term_taxonomy_id NOT IN ( {$exclude_custom_taxonomies_str[$option_data_key]} )";
				}
			}
		}

		$term_taxonomy_ids = $wpdb->get_col( "$args" );
		if ( !$term_taxonomy_ids ) { return; }
		$term_taxonomy_ids_str = implode( ",", $term_taxonomy_ids );
		
		$object_ids = array();
		$object_ids = $wpdb->get_col( "SELECT object_id FROM {$wpdb->term_relationships} WHERE term_taxonomy_id IN ( {$term_taxonomy_ids_str} ) AND object_id NOT IN ( {$exclude_posts} )" );
		if ( !$object_ids ) { return; }
		
		$object_ids = array_count_values( $object_ids );
		
		arsort( $object_ids );
		

		$entries ='';
		if ( $order_by == "related_scores_high__speedy" ) {
			$count = 1;
			foreach ( $object_ids as $object_id => $relevancy_score ) {
				$related_post = $wpdb->get_row( "SELECT ID FROM {$wpdb->posts} WHERE ID = {$object_id} AND post_type IN ( {$post_types_str} ) AND post_status = 'publish'" );
				if ( $related_post ) {
					$entries .= "{$before_entry}";
					$entries .= '<a href="' . get_permalink( $related_post->ID ) . '" title="' . get_the_title( $related_post->ID ) . '">' . get_the_title( $related_post->ID ) . '</a>';
					$entries .= " ({$relevancy_score})";
					$entries .= "{$after_entry}";
					if ( $count++ >= $number_of_posts_to_show ) {
						break;
					}
				}
			}
		} else {
			$relevancy_scores = array();
			$post_ids = array();
			$post_date = array();
			$post_modified = array();
			foreach ( $object_ids as $object_id => $relevancy_score ) {
				$related_post = $wpdb->get_row( "SELECT ID, post_date, post_modified FROM {$wpdb->posts} WHERE ID = {$object_id} AND post_type IN ( {$post_types_str} ) AND post_status = 'publish'" );
				if ( $related_post ) {
					array_push( $relevancy_scores, $relevancy_score );
					array_push( $post_ids, $related_post->ID );
					array_push( $post_date, $related_post->post_date );
					array_push( $post_modified, $related_post->post_modified );
				}
			}
			if ( $post_ids ) {	
				if ( $order_by == "related_scores_high__date_published_old" ){
					array_multisort( $relevancy_scores, SORT_DESC, $post_date, SORT_ASC, $post_ids, SORT_ASC, $post_modified, SORT_ASC );
				} elseif ( $order_by == "related_scores_low__date_published_new" ) {
					array_multisort( $relevancy_scores, SORT_ASC, $post_date, SORT_DESC, $post_ids, SORT_DESC, $post_modified, SORT_DESC );
				} elseif ( $order_by == "related_scores_low__date_published_old" ) {
					array_multisort( $relevancy_scores, SORT_ASC, $post_date, SORT_ASC, $post_ids, SORT_ASC, $post_modified, SORT_ASC );
				} elseif ( $order_by == "related_scores_high__date_modified_new" ) {
					array_multisort( $relevancy_scores, SORT_DESC, $post_modified, SORT_DESC, $post_date, SORT_DESC, $post_ids, SORT_DESC );
				} elseif ( $order_by == "related_scores_high__date_modified_old" ) {
					array_multisort( $relevancy_scores, SORT_DESC, $post_modified, SORT_ASC, $post_date, SORT_ASC, $post_ids, SORT_ASC );
				} elseif ( $order_by == "related_scores_low__date_modified_new" ) {
					array_multisort( $relevancy_scores, SORT_ASC, $post_modified, SORT_DESC, $post_date, SORT_DESC, $post_ids, SORT_DESC );
				} elseif ( $order_by == "related_scores_low__date_modified_old" ) {
					array_multisort( $relevancy_scores, SORT_ASC, $post_modified, SORT_ASC, $post_date, SORT_ASC, $post_ids, SORT_ASC );
				} elseif ( $order_by == "date_published_new" ) {
					array_multisort( $post_date, SORT_DESC, $post_ids, SORT_DESC, $post_modified, SORT_DESC, $relevancy_scores, SORT_DESC );
				} elseif ( $order_by == "date_published_old" ) {
					array_multisort( $post_date, SORT_ASC, $post_ids, SORT_ASC, $post_modified, SORT_ASC, $relevancy_scores, SORT_DESC );
				} elseif ( $order_by == "date_modified_new" ) {
					array_multisort( $post_modified, SORT_DESC, $post_date, SORT_DESC, $post_ids, SORT_DESC, $relevancy_scores, SORT_DESC );
				} elseif ( $order_by == "date_modified_old" ) {
					array_multisort( $post_modified, SORT_ASC, $post_date, SORT_ASC, $post_ids, SORT_ASC, $relevancy_scores, SORT_DESC );
				} else {
					array_multisort( $relevancy_scores, SORT_DESC, $post_date, SORT_DESC, $post_ids, SORT_DESC, $post_modified, SORT_DESC );
				}
				$count = 1;
				foreach ( $post_ids as $key => $post_id ) {
					$link= get_permalink($post_id);

					$entries .= "{$before_entry}";
					$entries .= '<a href="'.$link.'">';
					$entries .= '<img class= "taxonomy_related_img" src="'.get_the_image($post_id).'"/></a><br>';
					$entries .= '<a href="' . $link . '" title="' . get_the_title( $post_id ) . '">' . get_the_title( $post_id ) . '</a>';
					if ( is_user_logged_in() ) { $entries .= " ($relevancy_scores[$key])"; }
					$entries .= "{$after_entry}";
					if ( $count++ >= $number_of_posts_to_show ) {
						break;
					}
				}
			}
		}
		if ( !$entries ) { return; }
		$output = $wrap_before.$title.$before_entries.$entries.$after_entries;
		if ( $option_data['promotion_link'] ) {
			$output .= '<p style="font-size: ' . $option_data['promotion_link_fontsize'] . 'px; text-align: ' . $option_data['promotion_link_textalign'] . ';">';
			if ( $option_data['promotion_link_language'] == 'japanese' ) {
				$output .= '<a href="http://alphasis.info/kaihatu/wordpress-plugins/related-posts-via-taxonomies/" title="To the official site of Related Posts via Taxonomies." target="_blank">' . $option_data['promotion_link_text'] . '</a>';
			} else {
				$output .= '<a href="http://alphasis.info/developments/wordpress-plugins/related-posts-via-taxonomies/" title="To the official site of Related Posts via Taxonomies." target="_blank">' . $option_data['promotion_link_text'] . '</a>';
			}
			$output .= '</p>';
		}
		$output .= $wrap_after;
		return $output;

	} // function core()

} // class relatedPostsViaTaxonomies_display





?>
