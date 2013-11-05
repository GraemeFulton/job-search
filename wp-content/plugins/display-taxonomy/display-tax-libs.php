<?php
class Display_Taxonomy{

    //instantiate new display_taxonomy class
    public static function init() 
    {
        $class = __CLASS__;
        new $class;
    }

    //use constructor to kickstart things
    public function __construct() 
    {
        wp_enqueue_script('checkbox');
        // $this->display_tree();
        $this->display_tag_groups();
    }
    
    //not using atm
    public function display_tree()
    {
        $jobsTerms = get_terms('subject'); 

        foreach($jobsTerms as $term){
        $checked = (has_term($term->slug, 'subject', $post->ID)) ? 'checked="checked"' : '';
        echo "<input type='checkbox' name='" . $term->slug . "' value='" . $term->name . "' $checked />";
        echo "<label for='" . $term->slug . "'>" . $term->name . "</label><br>";
        }
        
    }
    
    public function display_tag_groups()
    {
        register_taxonomy( 'xili_tidy_tags_subject', 'term', array( 'hierarchical' => true, 'label'=>false, 'rewrite' => false, 'update_count_callback' => '', 'show_ui' => false ) );
               //  echo  xili_tags_group_list ( $separator = ', ', array ( 'tidy-languages-group' ), '', 'xili_tidy_tags_subject' ); 
        $jobsTerms = get_terms('xili_tidy_tags_subject'); 

        foreach($jobsTerms as $term){
            $checked = (has_term($term->slug, 'xili_tidy_tags_subject', $post->ID)) ? 'checked="checked"' : '';
            echo "<input type='checkbox' name='" . $term->slug . "' value='" . $term->name . "' obj_id=".$term->term_id." $checked />";
            echo "<label for='" . $term->slug . "'>" . $term->name . "</label><br>";
        }
        
     
            $this->get_tag_group_parent();
    }
    
    public function get_tag_group_parent(){
        
           
        global $wpdb;
        
        $sql="SELECT $wpdb->term_relationships.term_taxonomy_id
                from $wpdb->term_relationships 
                WHERE $wpdb->term_relationships.object_id ='2'";
        
        $safe_sql= $wpdb->prepare($sql);
        $results=$wpdb->get_results($sql);
        
           // $results = $wpdb->get_results ( "SELECT * FROM $wpdb->terms" );

        var_dump($results);
        
        
        
         
    foreach($results as $group)
    {       

       echo $group->term_taxonomy_id; 
       
    }
    
//    $args= array
//    (
//     'post_type'=>'course',
//      'tax_query' => array(
//         array(
//        'taxonomy' => 'subject',
//        'field' => 'slug',
//        'terms' => $tags_from_group
//        )
//        )
//    
//    );

        
        
        
//    
//        $sql="SELECT $wpdb->term_relationships.term_taxonomy_id, 
//                $wpdb->terms.term_id, $wpdb->terms.name 
//                from $wpdb->terms 
//                INNER JOIN  $wpdb->term_relationships 
//                ON $wpdb->terms.term_id = $wpdb->term_relationships.object_id WHERE name='Biology'";
    }
    
//public function dump_tags(){
//     //    register_taxonomy( 'xili_tidy_tags_subject', 'term', array( 'hierarchical' => true, 'label'=>false, 'rewrite' => false, 'update_count_callback' => '', 'show_ui' => false ) );
//    
//      $tax='art';
//    
//    $tags_from_group=xtt_tags_from_group($tax);
//    $list = implode ('","',$tags_from_group);
//    var_dump($list);
//  //  our_ajax_function($list);
//}
     
}
?>
