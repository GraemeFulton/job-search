<?php
class Display_Taxonomy{

    protected $category_type= '';
    protected $category_type_short='';
    protected $grouped_taxonomy='';
    protected $grouped_taxonomy_short='';

    //instantiate new display_taxonomy class
    public static function init() 
    {
        $class = __CLASS__;
        new $class;
    }

    //use constructor to kickstart things
    public function __construct($category_type, $grouped_taxonomy) 
    {
        $this->category_type= 'xili_tidy_tags_'.$category_type;
        $this->category_type_short= $category_type;
        $this->grouped_taxonomy= 'xili_tidy_tags_'.$grouped_taxonomy; 
        $this->grouped_taxonomy_short= $grouped_taxonomy; 

        $this->register_taxonomies();
        
     //   $this->add_action_hooks();
 
    }
    
//    private function add_action_hooks(){
//        
//            add_action('the_action_hook', array($this,'the_action_callback' ));
//            add_action('display_category_filters', array($this,'display_tree' ));
//
//    }

    
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
     * register_taxonomies
     * registers the required taxonomies
     */
    private function register_taxonomies(){
         
        register_taxonomy( $this->grouped_taxonomy, 'term', array( 'hierarchical' => true, 'label'=>false, 'rewrite' => false, 'update_count_callback' => '', 'show_ui' => false ) );
        
        register_taxonomy( $this->category_type, 'term', array( 'hierarchical' => true, 'label'=>false, 'rewrite' => false, 'update_count_callback' => '', 'show_ui' => false ) );
        

    }

    /*
     * display_tag_groups
     * prints out a hierarchical list based on xili tag groups
     */
    public function display_tag_groups()
    {
        $category_type= $this->category_type;
                           
        $tag_groups = get_terms($category_type); 

        foreach($tag_groups as $group)
        {
            if($group->parent==0)//if there is no parent, it is a top-level category
            {
                $checked = (has_term($group->slug, $this->category_type, $post->ID)) ? 'checked="checked"' : '';

                echo '<input type="checkbox" name="' . $group->slug . '" value="' . $group->name . '" obj_id='.$group->term_id.$checked.' />';
                echo '<label  style="font-weight:bold;" for="' . $group->slug . '">' . $group->name . '</label><br>';

                //get term children
                 $termchildren= get_term_children( $group->term_id,$this->category_type );
                 foreach($termchildren as $child)
                 {
                    $term = get_term_by( 'id', $child, $this->category_type );
                    echo '<input type="checkbox" name="' . $term->slug . '" value="' . $term->name . '" obj_id='.$term->term_id.$checked.' />';
                    echo '<label for="' . $term->slug . '">' . $term->name . '</label><br>';
                 }

            }
        }
    }
    
    /*
     * this is currently unused
     */
    public function get_tag_group_parent($id){
        
           
        global $wpdb;
        
        $sql="SELECT $wpdb->term_relationships.term_taxonomy_id
                from $wpdb->term_relationships 
                WHERE $wpdb->term_relationships.object_id ='$id'";
        
        $safe_sql= $wpdb->prepare($sql);
        $results=$wpdb->get_results($safe_sql);
        foreach($results as $group)
    {       

       echo $group->term_taxonomy_id; 
       
    }
    
 }
 
 /*
  * get_tag_group_leader
  * @param: object_id
  * from a given object_id (tag id), this returns the parent id of the group
  */
 public function get_tag_group_leader( $object_id){
           
     global $wpdb;
     
     if ($object_id){
     
    $sql="SELECT $wpdb->term_taxonomy.term_id 
          FROM $wpdb->term_relationships INNER JOIN $wpdb->term_taxonomy
          ON $wpdb->term_taxonomy.term_taxonomy_id=$wpdb->term_relationships.term_taxonomy_id
          WHERE $wpdb->term_relationships.object_id ='$object_id'";
        
    $safe_sql= $wpdb->prepare($sql);
    $results=$wpdb->get_results($safe_sql);
    
    $group_tag_parent= $results[0]->term_id;
    
    return $group_tag_parent;
     }
    
  }
 
 /*
  * all_tags_from_group_url
  * @param: $post_id
  * 
  * gets all children tags from a given tag group parent, and builds an URL
  * including all tags, and returns it by echoing it straight out.
  * 
  * if the tag doesn't belong to a group, it builds the url for just the one tag
  */
 public function print_linked_taggroup_or_tag($post_id, $object_id, $group_parent_id){
          
     // $object_id = wp_get_post_terms($post_id, 'uni', array("fields" => "ids"));
      
     // $group_parent_id= $this->get_tag_group_leader($object_id);

      $url = get_bloginfo('url');
      
     if ($group_parent_id)
     {
            if($object_id)
            {
                $tags_from_group= xtt_tags_from_group(intval($group_parent_id),'array',$this->grouped_taxonomy, $this->grouped_taxonomy_short);
                $slugs=array();
                $names=array();

                foreach($tags_from_group as $tags)
                {
                    array_push($slugs, $tags['tag_slug']);
                    array_push($names, $tags['tag_name']);
                }

               $list = implode ( ',', $slugs );

               if($names[0])
               echo '| Offered by: <a href="'.$url.'/?uni='.$list.'">'.$names[0].'</a>';
            }
     }
     else{
         
         $term_name = wp_get_post_terms($post_id, $this->grouped_taxonomy_short, array("fields" => "names"));
         $term_slug = wp_get_post_terms($post_id, $this->grouped_taxonomy_short, array("fields" => "slugs"));
        
         if($term_name[0])echo '| Offered by: <a href="'.$url.'/?uni='.$term_slug[0].'">'.$term_name[0].'</a>';
         
     }
 }
 
 
 /*
  * print_post_image
  * @params:
  * prints ONE image from optional images the post may have- priority for images:
  * 1. Image attached to the institution (group parent)
  * 2. Image attached to the post (from google images)
  * 3. Image attached to the category (e.g. accounting/programmer)
  * 4. Fall back on default image
  */
 public function print_post_image($group_parent_id, $post_id){
     
    //1. Image attached to the institution (group parent)
     
     if ($this->grouped_taxonomy_short!='uni'){
     
    $institution_image = s8_get_taxonomy_image_src(get_term_by('id', $group_parent_id, $this->grouped_taxonomy), 'thumbnail');
    if ($institution_image!=false)
    {
        printf('<br><img style="float:left position:relative; max-height:150px; " src="%s"/>', $institution_image['src']);
         
         return;
    }
   }
//else use anything associated to the tag:
             
         $term_id = wp_get_post_terms($post_id, $this->grouped_taxonomy_short, array("fields" => "ids"));
        $company_tag_image = s8_get_taxonomy_image_src(get_term_by('id', $term_id[0], $this->grouped_taxonomy_short), 'thumbnail');

        if ($company_tag_image!=false){
        printf('<br><img style="float:left position:relative; max-height:150px; " src="%s"/>', $company_tag_image['src']);
            return;
        }
        
 
//else use the google image:
        $pic = types_render_field("post-image", array("output"=>"raw"));
    
        if($pic){
          printf('<br><img style="float:left position:relative; max-height:150px;" src="%s"/>', $pic);
          
          return;
        }
    
 //else use the category (accounting image):
        
        $cat_term_id = wp_get_post_terms($post_id, 'profession', array("fields" => "ids"));    
        $group_leader=$this->get_tag_group_leader($cat_term_id[0]);
       $category_image = s8_get_taxonomy_image_src(get_term_by('id', $group_leader, $this->category_type), 'medium');
     //  var_dump($category_image);
       if ($category_image!=false){
        printf('<br><img style="float:left position:relative; max-height:150px; " src="%s"/>', $category_image['src']);
           return;
        }
        
        
    
   //or finally use the dummy
     
        $dummy="http://localhost/LGWP/wp-content/uploads/post_images/dummy-job.png";
        printf('<br><img style="float:left position:relative; max-height:150px;" src="%s"/>', $dummy);
        return;
    }
     
}
?>
