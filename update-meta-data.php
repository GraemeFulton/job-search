<?php
include('wp-load.php');



global $wpdb;

$args = array(
    'numberposts' => 200,
    'offset' => 0,
    'category' => 0,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'post_type' => 'graduate-job',
    'post_status' => 'draft, publish, future, pending, private',
    'suppress_filters' => true );


    $recent_posts = wp_get_recent_posts( $args, ARRAY_A );

 ?>

 <h2>Recent Posts</h2>
<ul>
<?php
	foreach( $recent_posts as $recent ){
		echo '<li><a href="' . get_permalink($recent["ID"]) . '">' .   $recent["post_title"].'</a> </li> ';

    $meta_info = explode('|', $recent['post_content']);

    foreach ($meta_info as $meta) {
        $meta_data = explode(':', $meta);

        if (strpos($meta_data[0],'Company') !== false) {
          wp_set_object_terms($recent['ID'],$meta_data[1],'company');
        }
        elseif (strpos($meta_data[0],'Location') !== false) {
          wp_set_object_terms($recent['ID'],$meta_data[1],'location');
        }
        elseif (strpos($meta_data[0],'Profession') !== false) {
          wp_set_object_terms($recent['ID'],$meta_data[1],'profession');
        }
        elseif (strpos($meta_data[0],'Provider') !== false) {
          wp_set_object_terms($recent['ID'],$meta_data[1],'job-provider');
        }

        //INSERT JOB TYPE
        //wp_set_object_terms($last_insert_id,$this->job_type,$this->job_type_taxonomy);


    }
	}
?>
</ul>

<?php

function find_between($string, $start, $end, $trim = true, $greedy = false) {
    $pattern = '/' . preg_quote($start) . '(.*';
    if (!$greedy) $pattern .= '?';
    $pattern .= ')' . preg_quote($end) . '/';
    preg_match($pattern, $string, $matches);
    $string = $matches[0];
    if ($trim) {
        $string = substr($string, strlen($start));
        $string = substr($string, 0, -strlen($start) + 1);
    }
    return $string;
}


 ?>
