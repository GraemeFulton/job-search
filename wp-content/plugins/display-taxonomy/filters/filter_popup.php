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
     }
       
     /*
      * template_response
      * @param $page = bool value. if false, exit (for ajax); if true, use for page
      */
     public function template_response($page){
         
         $tree= $this->get_taxonomy_tree();
         
         $video = $this->get_video($tree);
         
         $institution = $this->get_institution_name($tree);
         
         $subject= $this->get_subject($tree);
         
         $provider= $this->get_provider_logo();
         
         $post_type=$this->get_post_type($tree);
         
         $excerpt = $this->get_excerpt_by_id($this->post_id);
         
         $ratings = $this->show_ratings($this->post_id);
         
         $link = $this->get_link($tree);
         
         //return html view
         if($page==true){
             $the_content= $this->get_content_by_id($this->post_id);
             $post_image = $this->show_post_image($tree);
              include('templates/templates-single/'.$this->template.'_single.php');
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
    
    private function get_provider_logo(){
        
      $term_id = wp_get_post_terms($this->post_id, $this->provider_taxonomy, array("fields" => "ids"));
       
      if($term_id){
          return s8_get_taxonomy_image_src(get_term_by('id', $term_id[0], $this->provider_taxonomy), 'small');
      }
         
     }
     
     private function get_post_type($tree){
         
         return $tree->get_taxonomy_field($this->post_id, $this->post_type_taxonomy);

     }
     
         
     private function get_institution_name($tree){
         
         return $tree->get_linked_taggroup_or_tag($this->post_id, '', ''); 

         
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
       
       
    
          
          
        
        
        
    }
?>
