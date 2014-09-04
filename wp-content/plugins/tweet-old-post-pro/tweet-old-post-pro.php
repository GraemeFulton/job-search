<?php   
#     /* 
#     Plugin Name: Revive old post Pro Add-on
#     Plugin URI: https://themeisle.com/plugins/tweet-old-post-pro/
#     Description: This addon enable the pro functions of Revive Old Post plugin.For questions, comments, or feature requests, <a href="http://themeisle.com/contact/">contact </a> us!
#     Author: ThemeIsle 
#     Version: 1.4.4
#     Author URI: https://themeisle.com/
#     */  

	define("TOPCSSFILE", plugins_url('css/style.css',__FILE__ ));


	function toppro_admin_notice() {
		global $current_user ;
		       $user_id = $current_user->ID;
		        /* Check that the user hasn't already clicked to ignore the message */
		if ( ! class_exists('CWP_TOP_Core') ) {
		    echo '<div class="error"> This is just a pro addon so you will need to install the Revive Old Post free plugin from the WordPress repository';
		 
		    echo "</p></div>";
		}
	}

	function topProAddNewAccount(){


		$twp = new CWP_TOP_Core; 
		$twp->addNewAccount();
		/*$twp->oAuthCallback = $_POST['currentURL'];
		
		$twitter = new TwitterOAuth($twp->consumer, $twp->consumerSecret);
		$requestToken = $twitter->getRequestToken($twp->oAuthCallback);

		update_option('cwp_top_oauth_token', $requestToken['oauth_token']);
		update_option('cwp_top_oauth_token_secret', $requestToken['oauth_token_secret']);



		switch ($twitter->http_code) {
			case 200:
				$url = $twitter->getAuthorizeURL($requestToken['oauth_token']);
				echo $url;
				break;
				
			default:
				return __("Could not connect to Twitter!", CWP_TEXTDOMAIN);
				break;
		}
		
		die(); // Required*/

	}

	function url_get_contents ($Url) {
		$allowurl = ini_get('allow_url_fopen') ? "enabled" : "Disabled";
		if (function_exists('file_get_contents')&& $allowurl =="enabled") {
			$output = file_get_contents($Url);
		}
		else {
	        if (!function_exists('curl_init')){ 
	            die('CURL is not installed!');
	        }
	        $ch = curl_init();
	        curl_setopt($ch, CURLOPT_URL, $Url);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        $output = curl_exec($ch);
	        curl_close($ch);
	    }
	    return $output;
    }

    function topProGetCustomCategories($postQuery, $maximum_hashtag_length){
    	$taxonomi = get_object_taxonomies( $postQuery->post_type, 'objects' );
    	$newHashtags = "";
		foreach ($taxonomi as $key => $value) {
			if (strpos($key,"category")) {
				$postCategories = get_the_terms($postQuery->ID,$key);
				
				foreach ($postCategories as $category) {
					if(strlen($category->name.$newHashtags) <= $maximum_hashtag_length || $maximum_hashtag_length == 0) { 
				 		$newHashtags = $newHashtags . " #" . preg_replace('/-/','',strtolower($category->slug)); 
				 	}
				}
			}
		}
		return $newHashtags; 
    }
	
	function topProImage($connection, $finalTweet, $id,$service='twitter') {
		//global $post, $posts;
		//$plugin_data = get_plugin_data( PLUGINPATH.'/tweet-old-post.php', $markup = true, $translate = true );
			//print_r($post);
		//print_r($plugin_data);
			
		//if ($plugin_data['Version']=='6.7.7'&&$plugin_data['Version']=='6.7.8'&&$plugin_data['Version']=='6.7.9'&&$plugin_data['Version']=='6.8'){
		//	$fullTweet = $finalTweet;
		//	$finalTweet = $finalTweet['message'];
		//}
		//echo has_post_thumbnail( $id );
		if ( strlen( $img = get_the_post_thumbnail( $id, array( 150, 150 ) ) ) ) :
		    $image_array = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'optional-size' );
		    $image = $image_array[0];
		else :
		    $post = get_post($id);
			$image = '';
			ob_start();
			ob_end_clean();
			$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);

			$image = $matches [1] [0];

		endif;

		if ($image == '')
			$status = $connection->post('statuses/update', array('status' => $finalTweet));	
		else
			$status = $connection->upload('statuses/update_with_media', array('status' => $finalTweet,'media[]' => url_get_contents($image)));
	
		return $status;
	}

	function topPostToLinkedin($finalTweet){

		$visibility="anyone";
		$content_xml.="<content><title>".$finalTweet['message']."</title><submitted-url>".$finalTweet['link']."</submitted-url></content>";
		$url = 'https://api.linkedin.com/v1/people/~/shares?oauth2_access_token='.$user["oauth_token"];


		$xml       = '<?xml version="1.0" encoding="UTF-8"?><share>
         ' . $content_xml . '
         <visibility>
           <code>' . $visibility . '</code>
         </visibility>
       </share>';
       				$headers = array(
		    "Content-type: text/xml",
		    "Content-length: " . strlen($xml),
		    "Connection: close",
		);

       	if (!function_exists('curl_version'))
       		update_option('cwp_topnew_notice',"You host does not support CURL");

		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$data = curl_exec($ch); 
		if(curl_errno($ch))
		    print curl_error($ch);
		else
		    curl_close($ch);
		return $data;		
	}

	function topLoadStyles()
		{
			global $cwp_top_settings; // Global Tweet Old Post Settings

			// Enqueue and register all scripts on plugin's page
			if(isset($_GET['page'])) {
				if ($_GET['page'] == $cwp_top_settings['slug'] || $_GET['page'] == "ExcludePosts") {

					// Enqueue and Register Main CSS File
					wp_register_style( 'cwp_top_pro_stylesheet', TOPCSSFILE, false, '1.0.0' );
			        wp_enqueue_style( 'cwp_top_pro_stylesheet' );

			      
				 }				
			}
 	
		}

	function topLoadHooks() 
		{
			// loading all actions and filters
			
			add_action('admin_enqueue_scripts', 'topLoadStyles');
			add_action('admin_notices', 'toppro_admin_notice');
		}

	topLoadHooks();


 require 'inc/cwp-plugin-update.php'; 

$MyUpdateChecker = PucFactory::buildUpdateChecker('http://api.themeisle.com/get_metadata/tweet-old-post-pro', __FILE__, 'tweet-old-post-pro' );