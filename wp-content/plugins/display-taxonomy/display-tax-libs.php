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

     /*
      * prints the taxonomy heirarchy for the current taxonomy
      */
    public function display_tree()
    {
        $tag = get_terms($this->grouped_taxonomy_short); 

        echo '<div id="subject-filter">';
          foreach($tag as $tags)
          {
              if($tags->parent==0)//if there is no parent, it is a top-level category
              {
                  $checked = (has_term($tags->slug, $this->grouped_taxonomy_short, $tags->ID)) ? 'checked="checked"' : '';

                  echo '<input type="checkbox" name="' . $tags->slug . '" value="' . $tags->name . '" obj_id='.$tags->term_id.$checked.' />';
                  echo '<label  style="font-weight:bold;" for="' . $tags->slug . '">' . $tags->name . '</label><br>';

                  //get term children
                   $termchildren= get_term_children( $tags->term_id,$this->grouped_taxonomy_short );
                   foreach($termchildren as $child)
                   {
                      $term = get_term_by( 'id', $child, $this->grouped_taxonomy_short );
                      echo '<input type="checkbox" name="' . $term->slug . '" value="' . $term->name . '" obj_id='.$term->term_id.$checked.' />';
                      echo '<label for="' . $term->slug . '">' . $term->name . '</label><br>';
                   }

              }
          }
          echo '</div>';
        
    }
    
      
    public function display_select2_box($title){
               ?>
    <div class="control-group">
        <label for="<?php echo $this->grouped_taxonomy_short;?>-filter" class="control-label"><?php echo $title?>: </label>
        <div class="controls">
          <div class="input-append">
                
            <select id="<?php echo $this->grouped_taxonomy_short;?>-multi-append" class="select2" multiple="multiple" name="meta" style="width:80%;">
              <option></option>
    <?php
       $tags = get_terms($this->grouped_taxonomy_short); 
       
        foreach($tags as $tag)
    {      
            
       echo '<option value="'.$tag->slug.'" name="'.$tag->name.'">'.$tag->name.'</option>'; 
       
    }?>
            </select>
          <button class="btn" id="<?php echo $this->grouped_taxonomy_short;?>_search" type="button">
              <i class="glyphicon glyphicon-search"></i>
            </button>
          </div>
        </div>
      </div>     
    <?php }
    
    /*
     * display_main_select2_box
     * Giant select search box at the top
     */
      public function display_main_select2_box(){ ?>
    <div class="control-group">
        <label for="<?php echo $this->grouped_taxonomy_short;?>-main-filter" class="control-label"><?php echo $title?>: </label>
        <div class="controls">
          <div class="main-input-append">
                
            <select id="main-multi-append" class="select2_main" multiple="multiple" name="meta" style="width:80%;">
              <option></option>
    <?php
       $tags1 = get_terms($this->grouped_taxonomy_short); 
       $tags2 = get_terms($this->category_type_short); 
       
       if($tags1){
                echo '<optgroup label="'.$this->grouped_taxonomy_short.'">';
                 foreach($tags1 as $tag)
                 {      

                echo '<option value="'.$tag->slug.'" name="'.$tag->name.'">'.$tag->name.'</option>'; 

                  }
                    echo '</optgroup>"';
       }
       if($tags2){
            echo '<optgroup label="'.$this->category_type_short.'">';
                 foreach($tags2 as $tag)
                 {      

                echo '<option value="'.$tag->slug.'" name="'.$tag->name.'">'.$tag->name.'</option>'; 

                  }
                    echo '</optgroup>"';
           
           
       }?>
            </select>
          <button class="btn" id="main_search_filter_button" type="button">
              <i class="glyphicon glyphicon-search"></i>
            </button>
          </div>
        </div>
      </div> 
   <script>
      $('.select2_main').select2({ placeholder : 'Search for Courses' });
      
      $('button[data-select2-open]').click(function(){
        $('#' + $(this).data('select2-open')).select2('open');
      });
    </script>
    <?php }
    /*
     * display_linked_taxonomy_hierarchy_list
     * 
     * displays a hierarchical taxonomy linked to the current page
     * this is similar to display_tree, but is parameterized, and only shows
     * the children of the hierarchy e.g provider
     * 
     * it's a hierarchical taxonomy so we can show different taxonomies depending on the slug
     */
    public function display_linked_taxonomy_hierarchy_list($taxonomy, $slug){
         $tag = get_terms($taxonomy); 

        echo '<div id="'.$taxonomy.'-filter">';
          foreach($tag as $tags)
          {
              if($tags->parent==0 && $tags->slug==$slug)//if there is no parent, it is a top-level category
              {
//                  $checked = (has_term($tags->slug, $taxonomy, $tags->ID)) ? 'checked="checked"' : '';
//
//                  echo '<input type="checkbox" name="' . $tags->slug . '" value="' . $tags->name . '" obj_id='.$tags->term_id.$checked.' />';
//                  echo '<label  style="font-weight:bold;" for="' . $tags->slug . '">' . $tags->name . '</label><br>';

                  //get term children
                   $termchildren= get_term_children( $tags->term_id,$taxonomy );
                   foreach($termchildren as $child)
                   {
                      $term = get_term_by( 'id', $child, $taxonomy );
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
                echo '<label  style="font-weight:normal; font-size:13.4px" for="' . $group->slug . '">' . $group->name . '</label><br>';

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
     * queries a piece of tag meta: currently tailored for location filter (needs refactoring)
     *     <link href="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">

     */
    public function display_meta_group_select_box($meta_key){?>
    <div class="control-group">
        <label for="<?php echo $meta_key;?>-filter" class="control-label">Select Location(s): </label>
        <div class="controls">
          <div class="input-append">
                
            <select id="multi-append" class="select2" multiple="multiple" name="meta" style="width:110px;">
              <option></option>
    <?php
       $results = $this->meta_query($meta_key);
       
        foreach($results as $group)
    {      
            $location=explode("|",$group->meta_value);
            $location_name=explode("+",$location[0]);
             
            if ($location_name[0]=='United')
                $location_name[0]='United Kingdom';
            
       echo '<option value="'.$location_name[0].'">'.$location_name[0].'</option>'; 
       
    }?>
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
    <?php }
    /*
     * meta_query
     * @param: meta_key - e.g. 'location'
     * returns a meta key values (for the meta key provided as the param)
     * associated to a category type
     */
    private function meta_query($meta_key){
         global $wpdb;
           
        $sql="SELECT DISTINCT $wpdb->postmeta.meta_value
                from $wpdb->postmeta 
                WHERE $wpdb->postmeta.meta_key ='$meta_key'
                ORDER BY $wpdb->postmeta.meta_value ASC";
        
        $safe_sql= $wpdb->prepare($sql);
        
        return $wpdb->get_results($safe_sql);
        
    }
    
    /*
     * display_category_type_options
     * @param: meta_key: e.g. job_type/course_type/travel_type
     * displays radio options to display the type of category type:
     * e.g. category type= course ; options would be free/
     */
    public function display_category_type_options($meta_key){
        
        $results = $this->meta_query($meta_key);

        echo '<div id="category-type-filter"><form>';
        echo '<input type="radio" name="option" value="clear" checked/>All<br>';

        foreach($results as $result)
        {
            $result = str_replace('"', "-", $result->meta_value);
            
            $parts = explode(':', $result);
            $safe_name = $parts[5];
            $safe_name=$this->clean_string($safe_name);
                        
            echo '<input type="radio" name="option" value="' .$result. '"/>'.$safe_name.'<br>';
        }

        echo '</form></div>';

        
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
    $deepest_category= end($category);
    return $deepest_category;
        
    }
     /*
     * get subject field
     */
    public function grouped_taxonomy_slug($post_id){
             
    $category = wp_get_post_terms($post_id, $this->category_type_short, array("fields" => "slugs"));    
    $deepest_category= end($category);
    return $deepest_category;
        
    }
    
    
     /*
     * get type field (e.g. travel type, course type...)
     */
    public function get_taxonomy_field($post_id, $type){
             
    $category = wp_get_post_terms($post_id, $type, array("fields" => "names"));    
    $deepest_category= end($category);
    return $deepest_category;
        
    }
 
 /*
  * get_xili_post_image
  * @params:
  * prints ONE image from optional images the post may have- priority for images:
  * 1. Image attached to the institution (group parent)
  * 2. Image attached to the post (from google images)
  * 3. Image attached to the category (e.g. accounting/programmer)
  * 4. Fall back on default image
  */
 public function get_xili_post_image($group_parent_id, $post_id){
     
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
    
 /*
  * print_post_image **USING** THIS ONE
  * @params:
  * prints ONE image from optional images the post may have- priority for images:
  * 1. Image attached to the institution (group parent)
  * 2. Image attached to the post (from google images)
  * 3. Image attached to the category (e.g. accounting/programmer)
  * 4. Fall back on default image
  */
 public function get_post_image($group_parent_id, $post_id){
     
     //use featured image
     if (has_post_thumbnail( $post_id) ){
    $image = wp_get_attachment_image_src( get_post_thumbnail_id($post_id ), 'single-post-thumbnail' );
    return $image[0]; 
    
     }
         
  //else use anything associated to the tag:
             
         $term_id = wp_get_post_terms($post_id, $this->grouped_taxonomy_short, array("fields" => "ids"));
        $company_tag_image = s8_get_taxonomy_image_src(get_term_by('id', $term_id[0], $this->grouped_taxonomy_short), 'full');

        if ($company_tag_image!=false){
            return $company_tag_image['src'];
        }
        
        
  //else use the google/post image - dont use for jobs(profession):
if($this->grouped_taxonomy_short!='company'){
        $pic = types_render_field("post-image", array("output"=>"raw", "post_id"=>$post_id));
    
        if($pic){          
          return $pic;
        }
}
 //else get random category image
     if($this->grouped_taxonomy_short=='company'){
     $name= $this->grouped_taxonomy_slug($post_id);
     $image= $this->get_random_image($name);
     if($image!=null)return $image;
     }
           
 //else use the category (accounting image):
        if($this->grouped_taxonomy_short=='company'){
        $cat_term_id = wp_get_post_terms($post_id, 'profession', array("fields" => "ids")); 
       $category_image = s8_get_taxonomy_image_src(get_term_by('id', $cat_term_id[0], 'profession'), 'medium');
       if ($category_image!=false){
           return $category_image['src'];
        }
       else {
           $sub_category = get_term_by( 'id', $cat_term_id[0], 'profession' );
           $parent = get_term_by( 'id', $sub_category->parent, 'profession');
          $category_image = s8_get_taxonomy_image_src($parent, 'medium');
          if ($category_image!=false){
           return $category_image['src'];
        } 
       }
        }
        

    
   //or finally use the dummy
     
        $dummy="http://localhost/LGWP/wp-content/uploads/post_images/dummy-job.png";
        return $dummy; 
    }
    
    	/**
	 * Gets a random category header image
	 *
	 * @since 1.2
	 * @author  WP Theme Tutorial, Curtis McHale
	 * @access public
	 *
	 * @uses get_template_directory()		Returns the file path to the currently active parent theme
	 * @uses $this->make_file_path_uri()	Turns the file path in to a URI for the image HTML
	 */
	private function get_random_image($name){
                
                $path = plugin_dir_path( __FILE__ )."images/random/".$name."/";

		$images =  glob( $path . '*.{jpg}', GLOB_BRACE );

		$random_image = $images[ array_rand( $images ) ];

		$random_image = $this->make_file_path_uri( $name, $random_image );

		return $random_image;

	} // get_random_image
    
    /**
	 * Changes a filepath in to a URI
	 *
	 * @param   string  $file_path  req     The filepath for our image
	 * @return  string  $uri                The URI determined from the provided filepath
	 *
	 * @uses pathinfo()                         Returns array of information about our filepath
	 * @uses get_stylesheet_directory_uri()     Returns the URI for the stylesheet director
	 */
	private function make_file_path_uri( $name,$file_path ){

		$path_info = pathinfo( $file_path );

                if($path_info["basename"]!=''){
		$uri = plugins_url()."/display-taxonomy/images/random/".$name."/". $path_info["basename"];
                
		return $uri;
                }
                else return null;
	} // make_file_path_uri

    
    
    public function show_embedded_video($post_id){
        
        $field='embedded-media';
        
        $pic = do_shortcode("[types field='embedded-media' id='".$post_id."' width='450' height='315']");
    
        if($pic)          
        return $pic;
        
    }
    
    public function get_course_instructor($post_id){
              
        $instructor= do_shortcode("[types field='course-instructor' id='".$post_id."]");

        if($instructor)
        return $instructor;
        else return "N/A";
    }    
    
       public function get_course_start_date($post_id){
              
        $start_date= do_shortcode("[types field='start-date' id='".$post_id."]");

        if($start_date)
        return $start_date;
        else return "N/A";
    }    
    
    public function get_course_length($post_id){
         $length= do_shortcode("[types field='course-length' id='".$post_id."]");

        if($length)
        return $length;
        else return "N/A";
        
    }
    
    public function types_post_type($post_id, $field, $display){
        
        $pic = do_shortcode("[types field='$field' id='".$post_id."' output='".$display."']");
    
        if($pic)         
        return $pic;        
    }
    
    public function get_video_url($post_id){
        
           $vid_url= get_post_meta( $post_id, 'wpcf-embedded-media', true );

        if($vid_url)
        return $vid_url;
        else return "NA";
    
    }
    
    
    
    /************************************
     *******UTILITY FUNCTIONS************ 
     *************************************/
    private function clean_string($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    $string = str_replace('_', '-', $string); // Replaces all spaces with hyphens.

    $string= preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
     return ucwords(str_replace('-', ' ', $string)); // Replaces all spaces with hyphens.

    }
 
     
}
?>
