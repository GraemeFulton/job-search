 <?php
//require('config.php');

abstract Class ScraperAbstract{

protected $urlToScrape;
protected $initiativeURL;   
protected $last_insert_id;
protected $category;
protected $wpdb;


public function Setup($API, $initiativeURL, $category){
    
    $this->urlToScrape = $API;
    $this->initiativeURL = $initiativeURL;  
    $this->category= $category;

}

public abstract function getArray();

public abstract function scrape($wpdb, $feed_type);    

public function connectToDatabase(){
    
    $connector = new Database_Connect();
    $this->wpdb = $connector->connect_database();
    
}

  
public function submitPost($wpdb, $post_title, $content,$excerpt,$photo, $tags, $post_type, $entity, $publish_date)
{        

          if($publish_date==""){
              
              $publish_date = date('Y-m-d H:i:s');
              
          }
          $slug = $this->sluggify($post_title);
        
           $post = array(
           'post_author' => 1,
           'post_date' => $publish_date,
           'post_date_gmt' => $publish_date,
           'post_content' => $content,
           'post_title' => $post_title,
           'post_name' => $slug,
           'post_excerpt' => $excerpt,
           'post_status' => 'publish',
           'comment_status' => 'open',
           'ping_status' => 'open',
           'post_modified' =>$publish_date,
           'post_modified_gmt' =>$publish_date,
           'post_parent' => 0,
           'post_type' => $post_type,
           'comment_count' => 0
       );

       $wpdb->insert(
           'wp_posts', 
           $post,
           array( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' )
       );

     //set the last insert id!
     $this->last_insert_id = $wpdb->insert_id;
    
        //insert the image
        if($photo!='dummy'){//we're not inserting dummy image urls to the database, no point 
            $this->insert_post_image($wpdb, $post_title, $photo, $entity);  
        }
}

/*
 * checkPostExists
 * Check if post exists from title
 */
public function checkPostExists($wpdb,$post_title){
        
                $sql = "SELECT post_title FROM wp_posts WHERE post_title=%s";
                $query = $wpdb->prepare($sql, $post_title);
                
                $recorded = $wpdb->get_var($query); 
        
                return $recorded;
}
    
    
/*
 * insertPostImage
 * inserts an image for the post
 */
public function insert_post_image($wpdb, $image_title, $photoUrl, $entity){
    
    if ($photoUrl=="")
        return false;
    
      $LOCALPATH= "/var/www/LGWP/wp-content/uploads/post_images/";
      $URLPATH ="http://localhost/LGWP/wp-content/uploads/post_images/";
    
      $image_prefix= $image_title;
      
      if($entity->employer_name)
        $image_prefix= $entity->employer_name;
    
      
     $string = preg_replace('/[^a-z0-9]+/i', '_', $image_prefix);
     $image_name ="Logo_".$string;
     $image_path= $LOCALPATH.$image_name;
     $image_path_url=$URLPATH.$image_name;
    
     //insert image
     $this->insert_image($wpdb, $image_path_url);
     
     if(file_exists($image_path)){
        echo "<h5 style='color:red'>Image: $image_name already exists.</h5>";
        return false;
     }
          
    // Assumes a correctly encoded URL
    $image = file_get_contents($photoUrl);
    
    //if no image is present, use the dummy one
    if($image === FALSE) {
        $photoUrl=$LOCALPATH."dummy-job.png";
        $image = file_get_contents($photoUrl);
    }
    
    file_put_contents($image_path, $image); 
  
    echo "<br><h4 style='color:green'>Image:  saved.</h4>";
}

/*
 * insert_image
 * inserts an image
 */
private function insert_image($wpdb,$image_path_url){
    
    $lastInsertID= $wpdb->insert_id;
    $post_image = array(
    'post_id' => $lastInsertID,
    'meta_value'=>$image_path_url,
    'meta_key'=>'wpcf-post-image'
    );
    $wpdb->insert(
    'wp_postmeta', 
    $post_image,
    array( '%d', '%s', '%s' )
    );
}


/*
 * sluggift
 * @param: url
 * creates a slug from an url
 */
private function sluggify($url)
{
    # Prep string with some basic normalization
    $url = strtolower($url);
    $url = strip_tags($url);
    $url = stripslashes($url);
    $url = html_entity_decode($url);

    # Remove quotes (can't, etc.)
    $url = str_replace('\'', '', $url);

    # Replace non-alpha numeric with hyphens
    $match = '/[^a-z0-9]+/';
    $replace = '-';
    $url = preg_replace($match, $replace, $url);

    $url = trim($url, '-').'-'.date("Y-m-d");

    return $url;
}

    
} 


class SimpleImage 
{   
    
    var $image; 
    var $image_type;

    function load($filename) 
    {   
    $image_info = getimagesize($filename); $this->image_type = $image_info[2]; 
    if( $this->image_type == IMAGETYPE_JPEG ) 
        {   $this->image = imagecreatefromjpeg($filename); 
        
        }
        elseif( $this->image_type == IMAGETYPE_GIF ) 
            {   $this->image = imagecreatefromgif($filename); 
            
            } elseif( $this->image_type == IMAGETYPE_PNG ) {   $this->image = imagecreatefrompng($filename); } 
    }
    
    function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {   if( $image_type == IMAGETYPE_JPEG ) { imagejpeg($this->image,$filename,$compression); } elseif( $image_type == IMAGETYPE_GIF ) {   imagegif($this->image,$filename); } elseif( $image_type == IMAGETYPE_PNG ) {   imagepng($this->image,$filename); } if( $permissions != null) {   chmod($filename,$permissions); } } 

    function output($image_type=IMAGETYPE_JPEG) {   if( $image_type == IMAGETYPE_JPEG ) { imagejpeg($this->image); } elseif( $image_type == IMAGETYPE_GIF ) {   imagegif($this->image); } elseif( $image_type == IMAGETYPE_PNG ) {   imagepng($this->image); } } 
    
    function getWidth() {   return imagesx($this->image); } 
    
    function getHeight() {   return imagesy($this->image); } 
    
    function resizeToHeight($height) {   $ratio = $height / $this->getHeight(); $width = $this->getWidth() * $ratio; $this->resize($width,$height); } 
    
    function resizeToWidth($width) { $ratio = $width / $this->getWidth(); $height = $this->getheight() * $ratio; $this->resize($width,$height); } 
    
    function scale($scale) { $width = $this->getWidth() * $scale/100; $height = $this->getheight() * $scale/100; $this->resize($width,$height); } 
    
    function resize($width,$height) { $new_image = imagecreatetruecolor($width, $height); if( $this->image_type == IMAGETYPE_GIF || $this->image_type == IMAGETYPE_PNG ) { $current_transparent = imagecolortransparent($this->image); if($current_transparent != -1) { $transparent_color = imagecolorsforindex($this->image, $current_transparent); $current_transparent = imagecolorallocate($new_image, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']); imagefill($new_image, 0, 0, $current_transparent); imagecolortransparent($new_image, $current_transparent); } elseif( $this->image_type == IMAGETYPE_PNG) { imagealphablending($new_image, false); $color = imagecolorallocatealpha($new_image, 0, 0, 0, 127); imagefill($new_image, 0, 0, $color); imagesavealpha($new_image, true); } } imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight()); $this->image = $new_image;	 } 
}
    





?>
