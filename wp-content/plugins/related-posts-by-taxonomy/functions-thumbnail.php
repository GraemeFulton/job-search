<?php
/**
 * Related Posts by Taxonomy Gallery.
 *
 * Altered WordPress gallery_shortcode() for displaying the related post thumbnails.
 *
 * @since 0.2
 *
 * @global string $wp_version
 * @global string $post
 * @param array   $args          Attributes of the shortcode.
 * @param array   $related_posts Array with related post objects that have a post thumbnail.
 * @return string HTML content to display gallery.
 */
function km_rpbt_related_posts_by_taxonomy_gallery( $args, $related_posts = array() ) {

	if ( empty( $related_posts ) ) {
		return '';
	}

	$post = get_post();

	static $instance = 0;
	$instance++;

	// WordPress >= 3.9 supports html5 tags for the gallery shortcode
	$html5 = current_theme_supports( 'html5', 'gallery' );

	$defaults = array(
		'id'         => $post ? $post->ID : 0,
		'itemtag'    => $html5 ? 'figure'     : 'dl',
		'icontag'    => $html5 ? 'div'        : 'dt',
		'captiontag' => $html5 ? 'figcaption' : 'dd',
		'columns'    => 3,
		'size'       => 'thumbnail',
		'caption'    => 'post_title', // 'post_title', 'post_excerpt', 'attachment_caption', attachment_alt, or a custom string
	);

	/* Can be filtered in WordPress > 3.5 (hook: shortcode_atts_gallery) */
	$args = shortcode_atts( $defaults, $args, 'gallery' );

	/**
	 * Filter the function arguments.
	 *
	 * @since 0.2.1
	 *
	 * @param array   $args Function arguments.
	 */
	$filtered_args = apply_filters( 'related_posts_by_taxonomy_gallery', $args );

	$args = array_merge( $defaults, (array) $filtered_args );
	extract( $args );

	$id = intval( $id );

	if ( is_feed() ) {
		$output = "\n";
		foreach ( (array) $related_posts as $related ) {

			$thumbnail_id = get_post_thumbnail_id(  $related->ID  );
			$post_thumbnail = wp_get_attachment_image( $thumbnail_id, $size );

			/**
			 * Filter the related post gallery image in the feed.
			 *
			 * @since 0.3
			 *
			 * @param string  $post_thumbnail Html image tag or empty string.
			 * @param object  $related        Related post object
			 * @param array   $args           Function arguments.
			 */
			$gallery_image = apply_filters( 'related_posts_by_taxonomy_rss_post_thumbnail', $post_thumbnail, $related, $args );

			if ( $gallery_image ) {
				$url = get_permalink(  $related->ID );
				$post_title =  esc_attr(  $related->post_title );

				$output .=  "<a href='$url' title='$post_title'>$gallery_image</a>\n";
			}
		}
		return $output;
	}

	$itemtag = tag_escape( $itemtag );
	$captiontag = tag_escape( $captiontag );
	$icontag = tag_escape( $icontag );
	$valid_tags = wp_kses_allowed_html( 'post' );
	if ( ! isset( $valid_tags[ $itemtag ] ) )
		$itemtag = 'dl';
	if ( ! isset( $valid_tags[ $captiontag ] ) )
		$captiontag = 'dd';
	if ( ! isset( $valid_tags[ $icontag ] ) )
		$icontag = 'dt';

	$columns = intval( $columns );
	$itemwidth = $columns > 0 ? floor( 100/$columns ) : 100;
	$float = is_rtl() ? 'right' : 'left';

	$selector = "gallery-{$instance}";

	$gallery_style = $gallery_div = '';

	/**
	 * Filter whether to print default gallery styles.
	 * 
	 * Note: This is a WordPress core filter hook
	 *
	 * @since 3.1.0
	 *
	 * @param bool    $print Whether to print default gallery styles.
	 *                       Defaults to false if the theme supports HTML5 galleries.
	 *                       Otherwise, defaults to true.
	 */
	if ( apply_filters( 'use_default_gallery_style', ! $html5 ) ) {
		$gallery_style = "
		<style type='text/css'>
			#{$selector} {
				margin: auto;
			}
			#{$selector} .gallery-item {
				float: {$float};
				margin-top: 10px;
				text-align: center;
				width: {$itemwidth}%;
			}
			#{$selector} img {
				border: 2px solid #cfcfcf;
			}
			#{$selector} .gallery-caption {
				margin-left: 0;
			}
			/* see gallery_shortcode() in wp-includes/media.php */
		</style>\n\t\t";
	}

	$size_class = sanitize_html_class( $size );
	$gallery_div = "<div id='$selector' class='gallery related-gallery related-galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
	$output = apply_filters( 'gallery_style', $gallery_style . $gallery_div );

	$i = 0;
	$item_output = '';

	foreach ( (array) $related_posts as $related ) {

		$image_output = $_caption = '';

		$thumbnail_id = get_post_thumbnail_id(  $related->ID  );
		$post_thumbnail = wp_get_attachment_image( $thumbnail_id, $size );

		/**
		 * Filter the gallery image.
		 *
		 * @since 0.3
		 *
		 * @param string  $post_thumbnail Html image tag or empty string.
		 * @param object  $related        Related post object
		 * @param array   $args           Function arguments.
		 */
		$gallery_image = apply_filters( 'related_posts_by_taxonomy_post_thumbnail', $post_thumbnail, $related, $args );

		if ( !$gallery_image ) {
			continue;
		}

		$url = get_permalink(  $related->ID );
		$post_title_attr =  esc_attr( $related->post_title );

		$image_output =  "<a href='$url' title='$post_title_attr'>$gallery_image</a>";

		$image_meta  = wp_get_attachment_metadata( $thumbnail_id );

		$orientation = '';
		if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
			$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
		}

		$item_output .= "<{$itemtag} class='gallery-item'>";
		$item_output .= "
			<{$icontag} class='gallery-icon {$orientation}'>
				$image_output
			</{$icontag}>";

		if ( 'post_title' === $caption ) {
			$_caption = $related->post_title;
		} elseif ( 'post_excerpt' === $caption ) {
			setup_postdata( $related );
			$_caption = apply_filters( 'the_excerpt', get_the_excerpt() );
			wp_reset_postdata();
		} elseif ( 'attachment_caption' === $caption ) {
			$attachment = get_post( $thumbnail_id );
			$_caption = ( isset( $attachment->post_excerpt ) ) ? $attachment->post_excerpt : '';
		} elseif ( 'attachment_alt' === $caption ) {
			$_caption = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
		}

		/**
		 * Filter the related post thumbnail caption.
		 *
		 * @since 0.3
		 *
		 * @param string  $caption Options 'post_title', 'attachment_caption', attachment_alt, or a custom string. Default: post_title.
		 * @param object  $related Related post object.
		 * @param array   $args    Function arguments.
		 */
		$_caption = apply_filters( 'related_posts_by_taxonomy_caption',  wptexturize( $_caption ), $related, $args );

		if ( $captiontag && !empty( $_caption ) ) {
			$item_output .= "
				<{$captiontag} class='wp-caption-text gallery-caption'>
				" . $_caption . "
				</{$captiontag}>";
		}
		$item_output .= "</{$itemtag}>";

		if ( ! $html5 && $columns > 0 && ++$i % $columns == 0 ) {
			$item_output .= '<br style="clear: both" />';
		}
	}

	if ( !$item_output ) {
		return '';
	}

	$output .= $item_output;

	if ( ! $html5 && $columns > 0 && $i % $columns !== 0 ) {
		$output .= "
			<br style='clear: both' />";
	}

	$output .= "
		</div>\n";

	return $output;
}
