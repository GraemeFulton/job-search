<?php

if ( function_exists('w3tc_pgcache_flush') ) {
w3tc_pgcache_flush();
w3tc_dbcache_flush();
w3tc_minify_flush();
w3tc_objectcache_flush();
$cache = ' and W3TC Caches cleared';
}

function bmp_buffer_my_post() {
//check last post time against set interval and span
    if (bmp_opt_update_time()) {
        update_option('bmp_opt_last_update', time());
        bmp_opt_buffer_my_post();
        $ready=false;
    }
}

function bmp_currentPageURL() {
    
    if(!isset($_SERVER['REQUEST_URI'])){
        $serverrequri = $_SERVER['PHP_SELF'];
    }else{
        $serverrequri =    $_SERVER['REQUEST_URI'];
    }
    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
    $protocol = bmp_strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
    return $protocol."://".$_SERVER['SERVER_NAME'].$port.$serverrequri;
}

function bmp_strleft($s1, $s2) {
	return substr($s1, 0, strpos($s1, $s2));
}

//get random post and post
function bmp_opt_buffer_my_post() {
    return bmp_generate_query();
}

function bmp_generate_query($can_requery = true)
{
    
    global $wpdb;
    $rtrn_msg="";
    $omitCats = get_option('bmp_opt_omit_cats');
    $maxAgeLimit = get_option('bmp_opt_max_age_limit');
    $ageLimit = get_option('bmp_opt_age_limit');
    $exposts = get_option('bmp_opt_excluded_post');
    $exposts = preg_replace('/,,+/', ',', $exposts);
    $bmp_opt_post_type = get_option('bmp_opt_post_type');
    $bmp_opt_no_of_post = get_option('bmp_opt_no_of_post');
    
    $bmp_opt_posted_posts = array();
    $bmp_opt_posted_posts = get_option('bmp_opt_posted_posts');
    
    if(!$bmp_opt_posted_posts)
        $bmp_opt_posted_posts = array();
        
    if($bmp_opt_posted_posts != null)
        $already_posted = implode(",", $bmp_opt_posted_posts);
    else
        $already_posted="";
    
    if (substr($exposts, 0, 1) == ",") {
        $exposts = substr($exposts, 1, strlen($exposts));
    }
    if (substr($exposts, -1, 1) == ",") {
        $exposts = substr($exposts, 0, strlen($exposts) - 1);
    }

    if (!(isset($ageLimit) && is_numeric($ageLimit))) {
        $ageLimit = bmp_opt_AGE_LIMIT;
    }

    if (!(isset($maxAgeLimit) && is_numeric($maxAgeLimit))) {
        $maxAgeLimit = bmp_opt_MAX_AGE_LIMIT;
    }
    if (!isset($omitCats)) {
        $omitCats = bmp_opt_OMIT_CATS;
    }

    if($bmp_opt_no_of_post<=0){$bmp_opt_no_of_post = 1;}
    
    if($bmp_opt_no_of_post>10){$bmp_opt_no_of_post = 10;}
    
    if($bmp_opt_post_type!='both'){
	$post_type = "post_type = '$bmp_opt_post_type' AND";
     }
     else
     {
         $post_type="(post_type = 'post' OR post_type = 'page') AND";
     }
    
    $sql = "SELECT ID,POST_TITLE
            FROM $wpdb->posts
            WHERE $post_type post_status = 'publish' ";
    
    if(is_numeric($ageLimit))
    {
        if($ageLimit > 0)
                $sql = $sql . " AND post_date <= curdate( ) - INTERVAL " . $ageLimit . " day";
    }
    
    if ($maxAgeLimit != 0) {
        $sql = $sql . " AND post_date >= curdate( ) - INTERVAL " . $maxAgeLimit . " day";
    }

    if (isset($exposts)) {
        if (trim($exposts) != '') {
            $sql = $sql . " AND ID Not IN (" . $exposts . ") ";
        }
    }

    if (isset($already_posted)) {
        if(trim($already_posted) !="")
        {
            $sql = $sql . " AND ID Not IN (" . $already_posted . ") ";
        }
    }
    if ($omitCats != '') {
        $sql = $sql . " AND NOT (ID IN (SELECT tr.object_id FROM " . $wpdb->prefix . "term_relationships AS tr INNER JOIN " . $wpdb->prefix . "term_taxonomy AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id WHERE tt.taxonomy = 'category' AND tt.term_id IN (" . $omitCats . ")))";
    }
    $sql = $sql . "
            ORDER BY RAND() 
            LIMIT $bmp_opt_no_of_post ";
   
    $oldest_post = $wpdb->get_results($sql);
    
    if($oldest_post == null)
    {
        if($can_requery)
        {
            $bmp_opt_posted_posts=array();
            update_option('bmp_opt_posted_posts', $bmp_opt_posted_posts);
           return bmp_generate_query(false);
        }
        else
        {
           return "No post found to post. Please check your settings and try again."; 
        }
    }
       
     if(isset($oldest_post)){
		 $ret = '';
		 foreach($oldest_post as $k=>$odp){
                    array_push($bmp_opt_posted_posts, $odp->ID);
         	    $ret .= 'Tweet '.($k + 1) . ' ( '. $odp->POST_TITLE .' )' . ' : ' .bmp_publish($odp->ID).'<br/>';
		}
                
                if ( function_exists('w3tc_pgcache_flush') ) {
                    w3tc_pgcache_flush();
                    w3tc_dbcache_flush();
                    w3tc_minify_flush();
                    w3tc_objectcache_flush();
                    $cache = ' and W3TC Caches cleared';
                }           
                
                update_option('bmp_opt_posted_posts', $bmp_opt_posted_posts);
		return $ret;
     }
     
     return $rtrn_msg;
   }


//send request to passed url and return the response
function bmp_send_request($url, $method='GET', $data='', $auth_user='', $auth_pass='') {
    $ch = curl_init($url);
    if (strtoupper($method) == "POST") {
        curl_sebmpt($ch, CURLOPT_POST, 1);
        curl_sebmpt($ch, CURLOPT_POSTFIELDS, $data);
    }
    if (ini_get('open_basedir') == '' && ini_get('safe_mode') == 'Off') {
        curl_sebmpt($ch, CURLOPT_FOLLOWLOCATION, 1);
    }
    curl_sebmpt($ch, CURLOPT_HEADER, 0);
    curl_sebmpt($ch, CURLOPT_RETURNTRANSFER, 1);
    if ($auth_user != '' && $auth_pass != '') {
        curl_sebmpt($ch, CURLOPT_USERPWD, "{$auth_user}:{$auth_pass}");
    }
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($httpcode != 200) {
        return $httpcode;
    }

    return $response;
}

//check time and update the last post time
function bmp_opt_update_time() {
        return bmp_to_update();
}

function bmp_to_update() {
    global $wpdb;
    $ret=0;
    //prevention from caching
    $last  = $wpdb->get_var("select SQL_NO_CACHE option_value from $wpdb->options where option_name = 'bmp_opt_last_update';");
    //$last = get_option('bmp_opt_last_update');
    $interval = get_option('bmp_opt_interval');
    
    if((trim($last)=='') || !(isset($last)))
        $last=0;
 
    if (!(isset($interval))) {
        $interval = bmp_opt_INTERVAL;
    }
    else if(!(is_numeric($interval)))
    {
        $interval = bmp_opt_INTERVAL;
    }
    
    $interval = $interval * 60 * 60;
    /*
    if (false === $last) {
        $ret = 1;
    } else if (is_numeric($last)) {
        $ret = ( (time() - $last) > ($interval ));
    }
     
     */

    if (is_numeric($last)) {
        $ret = ( (time() - $last) > ($interval ));
    }
    else{
        $ret = 0;
    }
    return $ret;
}

function bmp_get_settings() {
    global $bmp_defaults;

    $settings = $bmp_defaults;

    $wordpress_settings = get_option('bmp_settings');
    if ($wordpress_settings) {
        foreach ($wordpress_settings as $key => $value) {
            $settings[$key] = $value;
        }
    }

    return $settings;
}

function bmp_save_settings($settings) {
    update_option('bmp_settings', $settings);
}

function bmp_reset_settings()
{
    delete_option('bmp_settings');
    update_option('bmp_enable_log','');
update_option('bmp_opt_add_text','');
update_option('bmp_opt_add_text_at','beginning');
update_option('bmp_opt_age_limit',30);
update_option('bmp_opt_bitly_key','');
update_option('bmp_opt_bitly_user','');
update_option('bmp_opt_custom_hashtag_field','');
update_option('bmp_opt_custom_hashtag_option','nohashtag');
update_option('bmp_opt_custom_url_field','');
update_option('bmp_opt_custom_url_option','');
//update_option('bmp_opt_excluded_post','');
update_option('bmp_opt_hashtags','');
update_option('bmp_opt_hashtag_length','20');
update_option('bmp_opt_include_link','no');
update_option('bmp_opt_interval',4);
delete_option('bmp_opt_last_update');
update_option('bmp_opt_max_age_limit',60);
update_option('bmp_opt_omit_cats','');
update_option('bmp_opt_post_type','title');
delete_option('bmp_opt_posted_posts');
update_option('bmp_opt_url_shortener','is.gd');
update_option('bmp_opt_use_inline_hashtags','');
update_option('bmp_opt_use_url_shortner','');
update_option('bmp_opt_admin_url','');
//wp_redirect(bmp_currentPageURL());
}

 /**
    * Called when any Page, Post or Custom Post Type is published or updated, live or for a scheduled post
    *
    * @param int $postID Post ID
    */
    function bmp_publish($postID, $isPublishAction = false) {
        
    	$meta = get_post_meta($postID, 'buffer-my-post', true); // Get post meta
        $defaults = get_option('buffer-my-post'); // Get settings
        
        //if (!is_array($meta) OR count($meta) == 0) $meta['publish'] = $_POST['buffer-my-post']['publish']; // If no meta defined, this is a brand new post - read from post data
        //if ($defaults['accessToken'] == '') return false; // No access token so cannot publish to Buffer
        //if ($meta['publish'] != '1') return false; // Do not need to publish or update
        
        // Get post
        $post = get_post($postID);

                //twit_update_status($message)
		// 1. Get post categories if any exist
		$catNames = '';
		$cats = wp_get_post_categories($postID, array('fields' => 'ids'));
		if (is_array($cats) AND count($cats) > 0) {
			foreach ($cats as $key=>$catID) {
				$cat = get_category($catID);
				$catName = strtolower(str_replace(' ', '', $cat->name));
				$catNames .= '#'.$catName.' ';
			}
		}
		
		// 2. Get author
		$author = get_user_by('id', $post->post_author);
                
                // 3. Check if we have an excerpt. If we don't (i.e. it's a Page or CPT with no excerpt functionality), we need
		// to create an excerpt
		if (empty($post->post_excerpt)) {
			$excerpt = wp_trim_words(strip_shortcodes($post->post_content));
		} else {
			$excerpt = $post->post_excerpt;
		}
		
		// 4. Parse text and description
		$params['text'] = get_option('bmp_opt_post_format');
		$params['text'] = str_replace('{sitename}', get_bloginfo('name'), $params['text']);
		$params['text'] = str_replace('{title}', $post->post_title, $params['text']);
		$params['text'] = str_replace('{excerpt}', $excerpt, $params['text']);
		$params['text'] = str_replace('{category}', trim($catNames), $params['text']);
		$params['text'] = str_replace('{date}', date('dS F Y', strtotime($post->post_date)), $params['text']);
		$params['text'] = str_replace('{url}', get_permalink($postID), $params['text']);
		$params['text'] = str_replace('{author}', $author->display_name, $params['text']);
		
		// 5. Check if we can include the Featured Image (if available) in the media parameter
		// If not, just attach the Post URL
		$media['link'] = rtrim(get_permalink($post->ID), '/');
		$featuredImageID = get_post_thumbnail_id($postID);
		if ($featuredImageID > 0) {
			// Get image source
			$featuredImageSrc = wp_get_attachment_image_src($featuredImageID, 'large');
			if (is_array($featuredImageSrc)) {
				$media['title'] = $post->post_title; // Required for LinkedIn to work
				$media['picture'] = $featuredImageSrc[0];
				$media['thumbnail'] = $featuredImageSrc[0];
				$media['description'] = $post->post_title;
				unset($media['link']); // Important: if set, this attaches a link and drops the image!
			}
		}
		
		// Assign media array to media argument
		$params['media'] = $media;

		// 6. Add profile IDs
		$accessToken=  get_option("bmp_opt_access_token");
                
                /*
                $profile_url = 'https://api.bufferapp.com/1/profiles.json?access_token=' . urlencode($accessToken);
                $r = wp_remote_get($profile_url,array(
		    		'sslverify' => false
		    	));
                
                if(!function_exists('json_decode')) {
                    wp_die('A JSON library does not appear to be installed.\n\nPlease contact your server admini f you need help installing one.');
                } else {
                    $response = @json_decode($r['body']);
                    if(!isset($response) || !is_array($response)) {
			print(
				'<p>Buffer has not returned an expected result.<br />' .
				'Please check your Token.</p>'
			);
			return;
                        }
                        
                        foreach($response as $profile) {
                            //BMP_DEBUG('buffer profile is: ' . print_r($profile, true));
                            $params['profile_ids'][]=$profile->id;
                        }
                    }
                    */
                
                    $acntids=  get_option("bmp_opt_acnt_id");
                    if(isset($acntids))
                    {
                        $arracntid = explode(",",$acntids);
                        foreach($arracntid as $profid)
                            $params['profile_ids'][]=$profid;
                    }   
                    
		// 7. Send to Buffer and store response
		$result = bmp_request($accessToken, 'updates/create.json', 'post', $params);
		// update_post_meta($postID, 'buffer-my-post'.'-request', '<pre>'.print_r($params,true).'</pre>');
		update_post_meta($postID, 'buffer-my-post'.'-log', $result);
		
    }

     /**
    * Sends a GET request to the Buffer API
    *
    * @param string $accessToken Access Token
    * @param string $cmd Command
    * @param string $method Method (get|post)
    * @param array $params Parameters (optional)
    * @return mixed JSON decoded object or error string
    */
    function bmp_request($accessToken, $cmd, $method = 'get', $params = array()) {
    	// Check for access token
        //$accessToken='1/9b2a1520d3c472e98aa705b87800a4e7';
    	if ($accessToken == '') return 'Invalid access token';
		BMP_DEBUG('request is: ' . print_r($params, true));
		// Send request
		switch ($method) {
			case 'get':
				$result = wp_remote_get('https://api.bufferapp.com/1/'.$cmd.'?access_token='.$accessToken, array(
		    		'body' => $params,
		    		'sslverify' => false
		    	));
				break;
			case 'post':
				$result = wp_remote_post('https://api.bufferapp.com/1/'.$cmd.'?access_token='.$accessToken, array(
		    		'body' => $params,
		    		'sslverify' => false
		    	));
				break;
		}
                
    	BMP_DEBUG('result is: ' . print_r($result, true));
    	// Check the request is valid
    	if (is_wp_error($result)) return $result;
		if ($result['response']['code'] != 200) return 'Error '.$result['response']['code'].' whilst trying to authenticate: '.$result['response']['message'].'. Please try again.';
		return json_decode($result['body']);		
    }
    
                
?>