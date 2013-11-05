 <?php

abstract Class ScraperAbstract{

protected $urlToScrape;
protected $currentCategory; //current job category we'll bescraping
protected $initiativeURL;   
protected $photoURL;
protected $category_type;
protected $provider_id;
protected $last_insert_id;

public function Setup($API, $defaultCatID, $initiativeURL, $category_type, $provider_id){
    
    $this->urlToScrape = $API;
    $this->currentCategory = $defaultCatID;
    $this->initiativeURL = $initiativeURL;    
    $this->category_type = $category_type;
    $this->provider_id = $provider_id;

}


public abstract function getArray();

public abstract function scrape($h);    
    
  
public function submitPost($wpdb, $url, $post_title, $content,$photo, $tags, $post_domain, $post_cat, $entity)
{
 $slug = $this->sluggify($post_title);
  echo $slug;
    
    
    $post = array(
    'post_author' => 1,
    'post_date' => date('Y-m-d H:i:s'),
    'post_date_gmt' => date('Y-m-d H:i:s'),
    'post_content' => $content,
    'post_title' => $post_title,
    'post_name' => $slug,
    'post_excerpt' => '',
    'post_status' => 'publish',
    'comment_status' => 'open',
    'ping_status' => 'open',
    'post_modified' => date('Y-m-d H:i:s'),
    'post_modified_gmt' => date('Y-m-d H:i:s'),
    'post_parent' => 0,
    'post_type' => 'course',
    'comment_count' => 0
);

$wpdb->insert(
    'wp_posts', 
    $post,
    array( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' )
);

$this->last_insert_id = $wpdb->insert_id;
    
    
//    
//      $h->post->origUrl = $url;
//      $h->post->domain =  $post_domain;
//      $h->post->status= 'new';
//      $h->post->author="1";
//      $h->post->title = $post_title;
//      $title = html_entity_decode($h->post->title, ENT_QUOTES, 'UTF-8');
//      $h->post->url = make_url_friendly($title);
//      $h->post->content = $content;
//      $h->post->type = 'news';
//      $h->post->tags= $tags;
//      $h->post->category= $post_cat;
//      $h->post->category_type=$this->category_type;
//      $h->post->provider_id=$this->provider_id;
     $this->photoURL=$photo;
//
//  
//      $this->insertPostImage($h, $post_title, $this->photoURL, $entity);
//      return $h->addPost();   
    
  
      $this->insertPostImage($wpdb, $post_title, $this->photoURL, $entity);    
}


    
    
public function insertPostImage($wpdb, $image_title, $photoUrl, $entity){
             $LOCALPATH= "/var/www/LGWP/wp-content/uploads/post_images/";
             $URLPATH ="http://localhost/LGWP/wp-content/uploads/post_images/";
    
      $image_prefix= $image_title;
      
      if($entity->employer_name){
          $image_prefix= $entity->employer_name;
          
      }
      
      $string = preg_replace('/[^a-z0-9]+/i', '_', $image_prefix);
     $image_name ="Logo_".$string;
     $image_path= $LOCALPATH.$image_name;
     $image_path_url=$URLPATH.$image_name;
     
//////INSERT/////////////
     $lastInsertID= $wpdb->insert_id;
     $post_image = array(
    'post_id' => $lastInsertID,
    'meta_value'=>$image_path_url,
    'meta_key'=>'wpcf-post-image'
);//meta_value = free course


$wpdb->insert(
    'wp_postmeta', 
    $post_image,
    array( '%d', '%s', '%s' )
);

echo "<br><b>Meta Inserted :)</b>";
////////////////////

     if(file_exists($image_path)){
         echo "<h5 style='color:red'>Image: $image_name already exists.</h5>";
         
         return false;
     }
          
     // Assumes a correctly encoded URL
    $image = file_get_contents($photoUrl);
    
    //if no image is present, use the dummy one
    if($image === FALSE) {
        $photoUrl=$LOCALPATH."dummy_orange.jpg";
        $image = file_get_contents($photoUrl);
    }
        


    file_put_contents($image_path, $image); 
    
    //create thumbnail from original image
  
//    if (file_exists($image_path)){
//        $img = new SimpleImage();
//        $img->load($image_path);
//        $img->resize(180,180);
//        $img->save($image_path);
//    }
//      else {return false;}
  
    echo "<br><h4 style='color:green'>Image: ".$h->post->image." saved.</h4>";
    
    
}
    
    

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

    $url = trim($url, '-');

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
