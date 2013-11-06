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
    
    
    /*
     * display_tag_groups
     * registers the subject taxonomy, and then prints out a hierarchical list based on xili tag groups
     */
    public function display_tag_groups()
    {
        register_taxonomy( 'xili_tidy_tags_subject', 'term', array( 'hierarchical' => true, 'label'=>false, 'rewrite' => false, 'update_count_callback' => '', 'show_ui' => false ) );
                   
        $jobsTerms = get_terms('xili_tidy_tags_subject'); 

        foreach($jobsTerms as $term)
        {
            if($term->parent==0)//if there is no parent, it is a top-level category
            {
                $checked = (has_term($term->slug, 'xili_tidy_tags_subject', $post->ID)) ? 'checked="checked"' : '';

                echo '<input type="checkbox" name="' . $term->slug . '" value="' . $term->name . '" obj_id='.$term->term_id.$checked.' />';
                echo '<label  style="font-weight:bold;" for="' . $term->slug . '">' . $term->name . '</label><br>';

                //get term children
                 $termchildren= get_term_children( $term->term_id,'xili_tidy_tags_subject' );
                 foreach($termchildren as $child)
                 {
                    $term = get_term_by( 'id', $child, 'xili_tidy_tags_subject' );
                    echo '<input type="checkbox" name="' . $term->slug . '" value="' . $term->name . '" obj_id='.$term->term_id.$checked.' />';
                    echo '<label for="' . $term->slug . '">' . $term->name . '</label><br>';
                 }

            }
        }
    }
    
    public function get_tag_group_parent(){
        
           
        global $wpdb;
        
        $sql="SELECT $wpdb->term_relationships.term_taxonomy_id
                from $wpdb->term_relationships 
                WHERE $wpdb->term_relationships.object_id ='2'";
        
        $safe_sql= $wpdb->prepare($sql);
        $results=$wpdb->get_results($sql);
    //    var_dump($results);
        foreach($results as $group)
    {       

       echo $group->term_taxonomy_id; 
       
    }
    
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
