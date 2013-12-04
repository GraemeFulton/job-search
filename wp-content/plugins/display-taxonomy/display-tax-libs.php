<?php
class Display_Taxonomy{

/****************************************************
* Set up - register taxonomies
****************************************************/
    
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
         
    }
    
    /*
     * register_taxonomies
     * registers the required taxonomies
     */
    private function register_taxonomies(){
         
        register_taxonomy( $this->grouped_taxonomy, 'term', array( 'hierarchical' => true, 'label'=>false, 'rewrite' => false, 'update_count_callback' => '', 'show_ui' => false ) );
        
        register_taxonomy( $this->category_type, 'term', array( 'hierarchical' => true, 'label'=>false, 'rewrite' => false, 'update_count_callback' => '', 'show_ui' => false ) );
        

    }
    
/****************************************************
* Sidebar (left ~widgets)
****************************************************/

       //not using atm
    public function display_tree()
    {
        $jobsTerms = get_terms($this->grouped_taxonomy_short); 

        foreach($jobsTerms as $term){
        $checked = (has_term($term->slug, 'subject', $post->ID)) ? 'checked="checked"' : '';
        echo "<input type='checkbox' name='" . $term->slug . "' value='" . $term->name . "' $checked />";
        echo "<label for='" . $term->slug . "'>" . $term->name . "</label><br>";
        }
        
    }
    
    /*
     * display_tag_groups
     * prints out a hierarchical list based on xili tag groups
     */
    public function display_tag_groups()
    {
        $category_type= $this->category_type;
                           
        $tag_groups = get_terms($category_type); 

        echo '<div id="subject-filter">';
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
        echo '</div>';

    }

    
      
    /*
     * display_tag_groups
     * prints out a hierarchical list based on xili tag groups
     */
    public function display_tag_groups_b()
    {
        $category_type= $this->grouped_taxonomy;
                           
        $tag_groups = get_terms($category_type); 
        
        echo '<div id="institution-filter">';

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
        echo '</div>';

    }
    
    
    /*
     * diplay_meta_group 
     * queries a piece of tag meta, such as location
     *     <link href="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">

     */
    public function display_meta_group_list($meta_key){
        
        ?>
    <div class="control-group">
        <label for="multi-append" class="control-label">Select Location(s): </label>
        <div class="controls">
          <div class="input-append">
                
            <select id="multi-append" class="select2" multiple="multiple" name="meta" style="width:110px;">
              <option></option>
    <?php
        global $wpdb;
           
        $sql="SELECT DISTINCT $wpdb->postmeta.meta_value
                from $wpdb->postmeta 
                WHERE $wpdb->postmeta.meta_key ='$meta_key'
                ORDER BY $wpdb->postmeta.meta_value ASC";
        
        $safe_sql= $wpdb->prepare($sql);
        $results=$wpdb->get_results($safe_sql);
        foreach($results as $group)
    {      
            $location=explode("|",$group->meta_value);
            $location_name=explode("+",$location[0]);
             
            if ($location_name[0]=='United')
                $location_name[0]='United Kingdom';
            
       echo '<option value="'.$location_name[0].'">'.$location_name[0].'</option>'; 
       
    }
        ?>
            </select>
          <button class="btn" id="location_search" type="button">
              <i class="glyphicon glyphicon-search"></i>
            </button>
          </div>
        </div>
      </div> 
   <script>
      $('.select2').select2({ placeholder : '' });
      
      $('.select2-remote').select2({ data: [{id:'A', text:'A'}]});

      $('button[data-select2-open]').click(function(){
        $('#' + $(this).data('select2-open')).select2('open');
      });
    </script>
    
    <?php
    
        
    }
    
/****************************************************
* Page template body functions (central region)
****************************************************/
  
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
 public function get_tag_group_leader($object_id){
           
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
  * print_linked_taggroup_or_tag
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
               echo '<a href="'.$url.'/?'.$this->grouped_taxonomy_short.'='.$list.'">'.$names[0].'</a>';
            }
     }
     else{
         
         $term_name = wp_get_post_terms($post_id, $this->grouped_taxonomy_short, array("fields" => "names"));
         $term_slug = wp_get_post_terms($post_id, $this->grouped_taxonomy_short, array("fields" => "slugs"));
        
         if($term_name[0])echo '<a href="'.$url.'/?'.$this->grouped_taxonomy_short.'='.$term_slug[0].'">'.$term_name[0].'</a>';
         
     }
 }
 
  /*
  * get_linked_taggroup_or_tag
  * @param: $post_id
  * 
  * gets all children tags from a given tag group parent, and builds an URL
  * including all tags, and returns it by echoing it straight out.
  * 
  * if the tag doesn't belong to a group, it builds the url for just the one tag
  */
 public function get_linked_taggroup_or_tag($post_id, $object_id, $group_parent_id){
          
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
               return '<a href="'.$url.'/?'.$this->grouped_taxonomy_short.'='.$list.'">'.$names[0].'</a>';
            }
     }
     else{
         
         $term_name = wp_get_post_terms($post_id, $this->grouped_taxonomy_short, array("fields" => "names"));
         $term_slug = wp_get_post_terms($post_id, $this->grouped_taxonomy_short, array("fields" => "slugs"));
        
         if($term_name[0])return '<a href="'.$url.'/?'.$this->grouped_taxonomy_short.'='.$term_slug[0].'">'.$term_name[0].'</a>';
         
     }
 }
 
 /*
  * get_location
  * @params: post id
  * returns the location name (no coordinates)
  */
 public function get_location($post_id){
     
    $location =  get_field('location', $post_id);
    $location=explode("|",$location);
    $location=explode("+",$location[0]);
    
    if ($location[0]=='United')
        $location[0]='UK';
    
    return $location[0];
     
 }
 
    /*
     * get subject field
     */
    public function grouped_taxonomy_name($post_id){
             
    $category = wp_get_post_terms($post_id, $this->category_type_short, array("fields" => "names"));    

    return $category[0];
        
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
    
     /*
  * print_post_image
  * @params:
  * prints ONE image from optional images the post may have- priority for images:
  * 1. Image attached to the institution (group parent)
  * 2. Image attached to the post (from google images)
  * 3. Image attached to the category (e.g. accounting/programmer)
  * 4. Fall back on default image
  */
 public function get_post_image($group_parent_id, $post_id){
     
    //1. Image attached to the institution (group parent)
     
     if ($this->grouped_taxonomy_short!='uni'){
     
    $institution_image = s8_get_taxonomy_image_src(get_term_by('id', $group_parent_id, $this->grouped_taxonomy), 'thumbnail');
    if ($institution_image!=false)
    {
        
         return $institution_image;
    }
   }
//else use anything associated to the tag:
             
         $term_id = wp_get_post_terms($post_id, $this->grouped_taxonomy_short, array("fields" => "ids"));
        $company_tag_image = s8_get_taxonomy_image_src(get_term_by('id', $term_id[0], $this->grouped_taxonomy_short), 'thumbnail');

        if ($company_tag_image!=false){
            return $company_tag_image['src'];
        }
        
 
//else use the google image:
        $pic = types_render_field("post-image", array("output"=>"raw"));
    
        if($pic){          
          return $pic;
        }
    
 //else use the category (accounting image):
        
        $cat_term_id = wp_get_post_terms($post_id, 'profession', array("fields" => "ids"));    
        $group_leader=$this->get_tag_group_leader($cat_term_id[0]);
       $category_image = s8_get_taxonomy_image_src(get_term_by('id', $group_leader, $this->category_type), 'medium');
     //  var_dump($category_image);
       if ($category_image!=false){
           return $category_image['src'];
        }
        
        
    
   //or finally use the dummy
     
        $dummy="http://localhost/LGWP/wp-content/uploads/post_images/dummy-job.png";
        return $dummy; 
    }
    
 
     
}
?>
