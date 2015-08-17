<?php
/*
     * popup_filter
     *
     * args: arguments from display-taxonomy.js
     * returns: returns html template to ajax call
     */
    function popup_filter()
    {

         $filter = new Popup_Filter($_POST['post_id'], $_POST['category'], $_POST['tag_type'], $_POST['body_type']);


         $output= $filter->template_response();

        $response=json_encode($output);

        if(is_array($response))
        {
            print_r($response);
        }
         else{echo $response;}
         die;
    }


Class Popup_Filter{

     //post-data variables
     protected $category; //main post type like travel/grad-job/course
     protected $tag_type;//e.g. subject/profession/destination
     protected $post_id;
     protected $body_type; //e.g. uni/company

     //variables for template
     protected $provider_taxonomy;
     protected $post_type_taxonomy;

     protected $template;


     public function __construct($post_id, $category, $tag_type, $body_type){

         $this->category= $category;
         $this->post_id= $post_id;
         $this->tag_type= $tag_type;
         $this->body_type = $body_type;

         $this->set_taxonomy_types();

     }

     private function set_taxonomy_types(){

         if($this->category=='travel-opportunities'){
             $this->provider_taxonomy='travel-agent';
             $this->post_type_taxonomy='travel-type';
             $this->template = 'travel';
         }
         elseif ($this->category=='course'){
             $this->provider_taxonomy='course-provider';
             $this->post_type_taxonomy='course-type';
             $this->template = 'course';
         }
        elseif($this->category=='graduate-job'){
                 $this->post_type_taxonomy='job-type';
                 $this->provider_taxonomy= 'job-provider';
                 $this->template = 'job';

        }
        elseif($this->category=='work-experience-job'){
                 $this->post_type_taxonomy='work-experience-type';
                  $this->provider_taxonomy= 'job-provider';
                  $this->template = 'job';

         }
         elseif($this->category=='inspire'){

                  $this->template = 'inspire';
         }
     }

     protected $tree;
     public $institution;
     public $institution_with_link;
     protected $subject;
     protected $provider;
     protected $post_type;
     protected $excerpt;
     protected $link;

     public function set_properties($tree ,$pid){
         $this->tree = $this->get_institution_name($tree);

         $this->institution = $this->get_institution_name($tree);

         $this->institution_with_link = $this->get_institution_with_link($tree);

         $this->subject= $this->get_subject($tree);

         $this->provider= $this->get_provider_logo();

         $this->post_type=$this->get_post_type($tree);

         $this->excerpt = $this->get_excerpt_by_id($pid);
     }
     /*
      * template_response
      * @param $page = bool value. if false, exit (for ajax); if true, use for page
      * see middle of the function for if($page==true)
      */
     public function template_response($page){

         $tree= $this->get_taxonomy_tree();

         $institution = $this->get_institution_name($tree);

         $institution_with_link = $this->get_institution_with_link($tree);

         $subject= $this->get_subject($tree);

         $provider= $this->get_provider_logo();

         $post_type=$this->get_post_type($tree);

         $excerpt = $this->get_excerpt_by_id($this->post_id);


         $link = $this->get_link($tree);

         if($this->category=="course"){
            $instructor = $this->get_instructor($tree);
            $start_date = $tree->get_course_start_date($this->post_id);
            $course_length=$tree->get_course_length($this->post_id);
            $ratings = $this->show_ratings($this->post_id);

         }

         if($this->category=='travel'){
              $ratings = $this->show_ratings($this->post_id);

         }

         if($this->category=="inspire-posts"){
             $content= $this->get_content_by_id($this->post_id);
             $full_content=$this->generateVideoEmbeds($content);
         }

         //return html view
         if($page=='content'){
             $video = $this->get_video_url($tree);
             $the_content= $this->get_content_by_id($this->post_id);
             $post_image = $this->show_post_image($tree);
                           $ratings = $this->show_ratings($this->post_id);

              include('templates/templates-single/'.$this->template.'_single_content.php');
         }
         elseif($page=='table'){
             $video = $this->get_video_url($tree);
             $the_content= $this->get_content_by_id($this->post_id);
             $post_image = $this->show_post_image($tree);
                           $ratings = $this->show_ratings($this->post_id);

              include('templates/templates-single/'.$this->template.'_single_table.php');
         }
         elseif($page=='post_loop'){
              $the_content= $this->get_content_by_id($this->post_id);
              include('templates/templates-post-loop/'.$this->template.'_post_loop.php');
         }
         else{
         include('templates/templates-popup/'.$this->template.'_popup.php');exit;
         }

     }

     private function get_taxonomy_tree(){

         return display_taxonomy_tree($this->tag_type, $this->body_type);


     }

     private function get_video($tree){

        return $tree->show_embedded_video($this->post_id);
     }

       private function get_instructor($tree){

         return $tree->get_course_instructor($this->post_id);

     }

     private function get_subject($tree){

         return $tree->grouped_taxonomy_name($this->post_id);
     }

     private function get_link($tree){

        return $tree->types_post_type($this->post_id, 'opportunity-url', 'raw');
    }

    private function get_jobs_location($tree){

         return $tree->get_taxonomy_field($this->post_id, 'location');
     }


    private function show_post_image($tree){
         $post_image=$tree->get_post_image($group_parent_id, $this->post_id);
         return '<div id="single_post_image_box"><img id="single_post_image" src="'.$post_image.'"/></div>';

    }

    /*
     * gets a the video url and sends back the correct embed code depending on
     * video type
     */
    private function get_video_url($tree){
        $video_url=$tree->get_video_url($this->post_id, 'embedded-media');

        if($video_url=='NA' || $video_url=='N/A'){return;}

         if (strpos($video_url,'youtube') !== false) {
              return $this->get_youtube_embed($video_url);
         }
         else{

             return '<object width="630" height="400" data="'.$video_url.'"></object>';

         }
    }

    /*
     * takes the vzaar url and builds the correct embed code
     */


    private function get_youtube_embed($vid_url){
       return $this->youtubeUrlToEmbedCode($vid_url);
    }



    private function get_provider_logo(){

      $term_id = wp_get_post_terms($this->post_id, $this->provider_taxonomy, array("fields" => "ids"));

      if($term_id){
          return s8_get_taxonomy_image_src(get_term_by('id', $term_id[0], $this->provider_taxonomy), 'small');
      }

     }

     private function get_post_type($tree){

         return $tree->get_taxonomy_field($this->post_id, $this->post_type_taxonomy);

     }
     private function get_institution_with_link($tree){
       return $tree->get_linked_taggroup_or_tag($this->post_id, '', '', 1);

     }

     private function get_institution_name($tree){

         return $tree->get_linked_taggroup_or_tag($this->post_id, '', '', 0);


     }

     /*
      * WordPress: Get the Excerpt Automatically Using the Post ID Outside of the Loop
      *http://uplifted.net/programming/wordpress-get-the-excerpt-automatically-using-the-post-id-outside-of-the-loop/
      */
private function get_excerpt_by_id($post_id){
        $the_post = get_post($post_id); //Gets post ID
        $the_excerpt = $the_post->post_content; //Gets post_content to be used as a basis for the excerpt
        $excerpt_length = 24; //Sets excerpt length by word count
        $the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images
        $words = explode(' ', $the_excerpt, $excerpt_length + 1);
        if(count($words) > $excerpt_length) :
        array_pop($words);
        array_push($words, '…');
        $the_excerpt = implode(' ', $words);
        endif;
        $the_excerpt = '<p>' . $the_excerpt . '</p>';
        return $the_excerpt;
}

private function get_post_content($post_id){
            $the_post = get_post($post_id); //Gets post ID
           return $the_content= $the_post->post_content; //Gets post_content to be used as a basis for the excerpt
}

/*
 * http://wordpress.stackexchange.com/questions/9667/get-wordpress-post-content-by-post-id
 */
private function get_content_by_id($post_id){

    $my_postid = $post_id;//This is page id or post id
    $content_post = get_post($my_postid);
    $content = $content_post->post_content;
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    return $content;

}

private function show_ratings($post_id){
    global $wpdb;
    $pId = $post_id; //if using in another page, use the ID of the post/page you want to show ratings for.
    $row = $wpdb->get_results("SELECT COUNT(*) AS `total`,AVG(review_rating) AS `aggregate_rating`,MAX(review_rating) AS `max_rating` FROM wp_wpcreviews WHERE `page_id`= $pId AND `status`=1");
    $max_rating = $row[0]->max_rating;
    $aggregate_rating = $row[0]->aggregate_rating;
    $total_reviews = $row[0]->total;
    $totl = $aggregate_rating * 20;
    $wpdb->flush();

    return '<div class="sp_rating" id="wpcr_respond_1"><div class="base"><div style="width:'.$totl.'%" class="average"></div></div>&nbsp('.$total_reviews.' Reviews)</div>';


}

/**
 * Finds youtube videos links and makes them an embed.
 * search: http://www.youtube.com/watch?v=xg7aeOx2VKw
 * search: http://www.youtube.com/embed/vx2u5uUu3DE
 * search: http://youtu.be/xg7aeOx2VKw
 * replace: <iframe width="560" height="315" src="http://www.youtube.com/embed/xg7aeOx2VKw" frameborder="0" allowfullscreen></iframe>
 *
 * @param string
 * @return string
 * @see http://stackoverflow.com/questions/6621809/replace-youtube-link-with-video-player
 * @see http://stackoverflow.com/questions/5830387/how-to-find-all-youtube-video-ids-in-a-string-using-a-regex
 */
function generateVideoEmbeds($text) {
    // No youtube? Not worth processing the text.
    if ((stripos($text, 'youtube.') === false) && (stripos($text, 'youtu.be') === false)) {
        return $text;
    }

    $search = '@          # Match any youtube URL in the wild.
        [^"\'](?:https?://)?  # Optional scheme. Either http or https; We want the http thing NOT to be prefixed by a quote -> not embeded yet.
        (?:www\.)?        # Optional www subdomain
        (?:               # Group host alternatives
          youtu\.be/      # Either youtu.be,
        | youtube\.com    # or youtube.com
          (?:             # Group path alternatives
            /embed/       # Either /embed/
          | /v/           # or /v/
          | /watch\?v=    # or /watch\?v=
          )               # End path alternatives.
        )                 # End host alternatives.
        ([\w\-]{8,25})    # $1 Allow 8-25 for YouTube id (just in case).
        (?:               # Group unwanted &feature extension
            [&\w-=%]*     # Either &feature=related or any other key/value pairs
        )
        \b                # Anchor end to word boundary.
        @xsi';

    $replace = '> <div id="youtube_player-'.$this->post_id.'"><iframe width="450" height="315" src="http://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe></div>';
    $text = preg_replace($search, $replace, $text);

    return $text;
}

function youtubeUrlToEmbedCode($url){

        preg_match(
                '/[\\?\\&]v=([^\\?\\&]+)/',
                $url,
                $matches
            );
        $id = $matches[1];

        $width = '630';
        $height = '400';
        return '<object width="' . $width . '" height="' . $height . '"><param name="movie" value="http://www.youtube.com/v/' . $id . '&amp;hl=en_US&amp;fs=1?rel=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/' . $id . '&amp;hl=en_US&amp;fs=1?rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="' . $width . '" height="' . $height . '"></embed></object>';

    }

}
?>
