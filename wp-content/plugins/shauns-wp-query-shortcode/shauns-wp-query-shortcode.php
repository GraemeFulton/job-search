<?php
/*
Plugin Name: Shaun's WP Query Shortcode
Plugin URI: http://mynewsitepreview.com/shauns-wp-query-shortcode/
Description: This is an extensible plugin. It allows users to perform a custom WP query via shortcode, which can then be displayed by a plugin extension.
Version: 1.2
Author: Shaun Scovil
Author URI: http://shaunscovil.com/
License: GPL2
*/

/*  Copyright 2012  Shaun Scovil  (email : sscovil@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

add_shortcode( 'wpquery', 'mnsp_wp_query' );
function mnsp_wp_query( $atts, $content ) {
	$args = shortcode_atts( array(
		'author'				=> NULL,
		'author_name'			=> NULL,
		'cat'					=> NULL,
		'category_name'			=> NULL,
		'category__and'			=> NULL,
		'category__in'			=> NULL,
		'category__not_in'		=> NULL,
		'tag'					=> NULL,
		'tag_id'				=> NULL,
		'tag__and'				=> NULL,
		'tag__in'				=> NULL,
		'tag__not_in'			=> NULL,
		'tag_slug__and'			=> NULL,
		'tag_slug__in'			=> NULL,
		'tax_query'				=> NULL,
		'p'						=> NULL,
		'name'					=> NULL,
		'page_id'				=> NULL,
		'pagename'				=> NULL,
		'post_parent'			=> NULL,
		'post__in'				=> NULL,
		'post__not_in'			=> NULL,
		'post_type'				=> 'post',
		'post_status'			=> 'publish',
		'posts_per_page'		=> -1,
		'nopaging'				=> 'false',
		'paged'					=> NULL,
		'offset'				=> NULL,
		'order'					=> 'DESC',
		'orderby'				=> 'date',
		'ignore_sticky_posts'	=> 0,
		'year'					=> NULL,
		'monthnum'				=> NULL,
		'w'						=> NULL,
		'day'					=> NULL,
		'hour'					=> NULL,
		'minute'				=> NULL,
		'second'				=> NULL,
		'meta_key'				=> NULL,
		'meta_value'			=> NULL,
		'meta_value_num'		=> NULL,
		'meta_compare'			=> NULL,
		'meta_query'			=> NULL,
		'perm'					=> NULL,
		'cache_results'			=> NULL,
		'update_post_term_cache'=> NULL,
		'update_post_meta_cache'=> NULL,
		's'						=> NULL,
	), $atts );
	
	foreach( $args as &$arg ) {
		if( mnsp_isArrayExpression( $arg ) )
			$arg = mnsp_stringToArray( $arg );
	}

	global $shauns_wp_query;
	$shauns_wp_query = new WP_Query( $args );

	if( $shauns_wp_query->have_posts() ) {
		$output = do_shortcode( $content );
		ob_start();
		echo $output;
		$output = ob_get_contents();;
		ob_end_clean();
	}
	
	wp_reset_query();
	return $output;
}


/* Check if a string contains an array expression. */
function mnsp_isArrayExpression( $str ) {
    $toks = token_get_all("<?php $str");
    return (
        $toks[1][0] == T_ARRAY &&
        $toks[2] == '(' &&
        end($toks) == ')'
    );
}


/* If a string contains an array expression, convert that expression into an actual array. */
function mnsp_stringToArray( $str ) {
    $array = array();
    $toks = token_get_all("<?php $str");

    if ($toks[1][0] != T_ARRAY || $toks[2] != '(' || end($toks) != ')')
        return null;

    for($i=3; $i<count($toks)-1; $i+=2) {
        if (count($toks[$i]) != 3)
            return null;

        if ($toks[$i][0] == T_WHITESPACE) {
            $i--;
            continue;
        }

        if ($toks[$i][0] == T_VARIABLE || $toks[$i][0] == T_STRING)
            return null;

        $value = $toks[$i][1];
        if ($toks[$i][0] == T_CONSTANT_ENCAPSED_STRING)
            $value = substr($value, 1, strlen($value) - 2);

        $array[] = $value;

        if ($toks[$i + 1] != ',' && $toks[$i + 1] != ')' && $toks[$i + 1][0] != T_WHITESPACE)
            return null;
    }

    return $array;
}


/*** DEVELOPERS:                                                                                          ***/
/*** Create your own nested shortcode plugins by copy/pasting the function below into a new plugin file.  ***/
/*** Give your function and shortcode unique names, and enter your code inside the while...endwhile loop. ***/
/*** Use the variable $output to store your display data and pass it back to the mnsp_wp_query function.  ***/

add_shortcode( 'wpq_index', 'mnsp_wpq_index' );
function mnsp_wpq_index() {
	// Get the ID of the current page/post, to exclude from list
	global $post;
	$current = $post->ID;
	
	// Get results from Shaun's WP Query Shortcode
	global $shauns_wp_query;

	$output = '<ul class="related-pages">';

	// Begin 'The Loop'
	while( $shauns_wp_query->have_posts() ) : $shauns_wp_query->the_post();
		
		if( $post->ID !== $current )
			$output .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
		
	endwhile;

	$output .= '</ul>';

	return $output;
}

?>