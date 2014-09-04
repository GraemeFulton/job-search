<?php

require_once('buffer-my-post.php');
require_once('bmp-core.php');

require_once('bmp-xml.php');
require_once( 'Include/bmp-debug.php' );
function bmp_admin() {
    //check permission
    
    if (current_user_can('activate_plugins')) 
        {
        $message = null;
        $message_updated = __("Buffer My Post Options Updated.", 'BufferMyPost');
        $response = null;
        $save = true;
        $settings = bmp_get_settings();

        //check if username and key provided if bitly selected
        if (isset($_POST['bmp_opt_url_shortener'])) {
            if ($_POST['bmp_opt_url_shortener'] == "bit.ly") {

                //check bitly username
                if (!isset($_POST['bmp_opt_bitly_user'])) {
                    print('
			<div id="message" class="updated fade">
				<p>' . __('Please enter bit.ly username.', 'BufferMyPost') . '</p>
			</div>');
                    $save = false;
                }
                //check bitly key
                elseif (!isset($_POST['bmp_opt_bitly_key'])) {
                    print('
			<div id="message" class="updated fade">
				<p>' . __('Please enter bit.ly API Key.', 'BufferMyPost') . '</p>
			</div>');
                    $save = false;
                }
                //if both the good to save
                else {
                    $save = true;
                }
            }
        }

        //if submit and if bitly selected its fields are filled then save
        if (isset($_POST['submit']) && $save) {
            $message = $message_updated;

            //post interval 
            if (isset($_POST['bmp_opt_interval'])) {
                if (is_numeric($_POST['bmp_opt_interval']) && $_POST['bmp_opt_interval'] > 0) {
                    update_option('bmp_opt_interval', $_POST['bmp_opt_interval']);
                } else {
                    update_option('bmp_opt_interval', "4");
                }
            }

            //minimum post age to post
            if (isset($_POST['bmp_opt_age_limit'])) {
                if (is_numeric($_POST['bmp_opt_age_limit']) && $_POST['bmp_opt_age_limit'] >= 0) {
                    update_option('bmp_opt_age_limit', $_POST['bmp_opt_age_limit']);
                } else {
                    update_option('bmp_opt_age_limit', "30");
                }
            }

            //maximum post age to post
            if (isset($_POST['bmp_opt_max_age_limit'])) {
                if (is_numeric($_POST['bmp_opt_max_age_limit']) && $_POST['bmp_opt_max_age_limit'] > 0) {
                    update_option('bmp_opt_max_age_limit', $_POST['bmp_opt_max_age_limit']);
                } else {
                    update_option('bmp_opt_max_age_limit', "0");
                }
            }

            //number of posts to post
            if (isset($_POST['bmp_opt_no_of_post'])) {
                if (is_numeric($_POST['bmp_opt_no_of_post']) && $_POST['bmp_opt_no_of_post'] > 0) {
                    update_option('bmp_opt_no_of_post', $_POST['bmp_opt_no_of_post']);
                } else {
                    update_option('bmp_opt_no_of_post', "1");
                }
            }
            
            //type of post to post
            if (isset($_POST['bmp_opt_post_type'])) {
                update_option('bmp_opt_post_type', $_POST['bmp_opt_post_type']);
            }
            
            //type of post to post
            if (isset($_POST['bmp_opt_post_format'])) {
                update_option('bmp_opt_post_format', $_POST['bmp_opt_post_format']);
            }
            
             //type of post to post
            if (isset($_POST['acntids'])) {
                update_option('bmp_opt_acnt_id', $_POST['acntids']);
            }
            
            //type of post to post
            if (isset($_POST['bmp_opt_access_token'])) {
                update_option('bmp_opt_access_token', $_POST['bmp_opt_access_token']);
            }
            
            //option to enable log
            if ( isset($_POST['bmp_enable_log'])) {
                update_option('bmp_enable_log', true);
		global $bmp_debug;
		$bmp_debug->enable( true );
                
            }
            else{
                update_option('bmp_enable_log', false);
                global $bmp_debug;
		$bmp_debug->enable( false );	
            }
        
            //categories to omit from post
            if (isset($_POST['post_category'])) {
                update_option('bmp_opt_omit_cats', implode(',', $_POST['post_category']));
            } else {
                update_option('bmp_opt_omit_cats', '');
            }
            
            

            //successful update message
            print('
			<div id="message" class="updated fade">
				<p>' . __('Buffer My Post Options Updated.', 'BufferMyPost') . '</p>
			</div>');
        }
        //post now clicked
        elseif (isset($_POST['post'])) {
            $post_msg = bmp_opt_buffer_my_post();
            print('
			<div id="message" class="updated fade">
				<p>' . __($post_msg, 'BufferMyPost') . '</p>
			</div>');
        }
        elseif (isset($_POST['reset'])) {
           bmp_reset_settings();
           echo '<script language="javascript">window.location.href= "' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=BufferMyPost&bmp=reset";</script>';
                die;
        }


        //set up data into fields from db
        
        //Current URL
        $post_format = get_option('bmp_opt_post_format');
        if (!isset($post_format) || $post_format=="") {
            $post_format = "New Post: {title} {url}";
			update_option('bmp_opt_post_format', $post_format);
        }
        
        $access_token = get_option('bmp_opt_access_token');
        if (!isset($access_token)) {
            $access_token = "";
			update_option('bmp_opt_access_token', $access_token);
        }
        
        //interval
        $interval = get_option('bmp_opt_interval');
        if (!(isset($interval) && is_numeric($interval))) {
            $interval = bmp_opt_INTERVAL;
        }

        //min age limit
        $ageLimit = get_option('bmp_opt_age_limit');
        if (!(isset($ageLimit) && is_numeric($ageLimit))) {
            $ageLimit = bmp_opt_AGE_LIMIT;
        }

        //max age limit
        $maxAgeLimit = get_option('bmp_opt_max_age_limit');
        if (!(isset($maxAgeLimit) && is_numeric($maxAgeLimit))) {
            $maxAgeLimit = bmp_opt_MAX_AGE_LIMIT;
        }

        //number of post to post
        $bmp_opt_no_of_post = get_option('bmp_opt_no_of_post');
        if (!(isset($bmp_opt_no_of_post) && is_numeric($bmp_opt_no_of_post))) {
            $bmp_opt_no_of_post = "1";
        }
        
        //buffer profile
        $acntids = get_option('bmp_opt_acnt_id');
        if (!(isset($acntids))) {
            $acntids = "";
        }
        
        //type of post to post
        $bmp_opt_post_type = get_option('bmp_opt_post_type');
        if (!isset($bmp_opt_post_type)) {
            $bmp_opt_post_type = "post";
        }
        
        //check enable log
        $bmp_enable_log = get_option('bmp_enable_log');
        if (!isset($bmp_enable_log)) {
            $bmp_enable_log = "";
        } elseif ($bmp_enable_log)
            $bmp_enable_log = "checked";
        else
            $bmp_enable_log="";
        
        //set omitted categories
        $omitCats = get_option('bmp_opt_omit_cats');
        if (!isset($omitCats)) {
            $omitCats = bmp_opt_OMIT_CATS;
        }

        $x = WP_PLUGIN_URL . '/' . str_replace(basename(__FILE__), "", plugin_basename(__FILE__));

        print('
			<div class="wrap">
				<h2>' . __('Buffer My Post by - ', 'BufferMyPost') . ' <a href="http://www.ajaymatharu.com">Ajay Matharu</a></h2>

<h3>If you like this plugin, follow <a href="http://www.twitter.com/matharuajay">@matharuajay</a> on Twitter to help keep this plugin free...FOREVER!</h3>

<a href="https://twitter.com/matharuajay" class="twitter-follow-button" data-show-count="true" data-size="large">Follow @matharuajay</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<br /><br />


				<form id="bmp_opt" name="bmp_BufferMyPost" action="" method="post">
					<input type="hidden" name="bmp_opt_action" value="bmp_opt_update_settings" />
					<fieldset class="options">
			');

        print('
                                                <div class="option">
							
						</div>
                                                <div class="option">
							<label for="bmp_opt_access_token">' . __('Your Buffer App Access Token: <br /><span class="desc">Copy your Buffer app access token here.<span> ', 'BufferMyPost') . '</label>
							<input type="text" id="bmp_opt_access_token"  style="width:500px" value="' . $access_token . '" name="bmp_opt_access_token" /> </b>
                                                       
						</div>
                                                <div class="option">
							<label for="bmp_opt_post_format" style="height:140px">' . __('Post Format <br/> <span class="desc">(Format of the Post to Buffer)</span>', 'BufferMyPost') . ':</label>
							<input type="text" style="width:500px" id="bmp_opt_post_format" value="' . $post_format . '" name="bmp_opt_post_format" /><br/>Define the post format using tags. 
                                                            Valid tags are:<br/>
{sitename}: the title of your blog<br/>
{title}: the title of your blog post<br/>
{excerpt}: a short excerpt of the post content<br/>
{category}: the first selected category for the post<br/>
{date}: the post date<br/>
{url}: the post URL<br/>
{author}: the post author <br/>
						</div>
                                                
                                               
						
						<div class="option">
							<label for="bmp_opt_interval">' . __('Minimum interval between posts: <br /><span class="desc">What should be minimum time between your posts?<span> ', 'BufferMyPost') . '</label>
							<input type="text" id="bmp_opt_interval" maxlength="5" value="' . $interval . '" name="bmp_opt_interval" /> Hour / Hours <b>(Note: If set to 0 it will take default as 4 hours)</b>
                                                       
						</div>
						
						<div class="option">
							<label for="bmp_opt_age_limit">' . __('Minimum age of post to be eligible for post: <br /><span class="desc">Include post in posts if at least this age.<span> ', 'BufferMyPost') . '</label>
							<input type="text" id="bmp_opt_age_limit" maxlength="5" value="' . $ageLimit . '" name="bmp_opt_age_limit" /> Day / Days
							<b> (enter 0 for today)</b>
                                                           
						</div>
						
						<div class="option">
							<label for="bmp_opt_max_age_limit">' . __('Maximum age of post to be eligible for post: <br /><span class="desc">Don\'t include posts older than this.<span>', 'BufferMyPost') . '</label>
                                                        <input type="text" id="bmp_opt_max_age_limit" maxlength="5" value="' . $maxAgeLimit . '" name="bmp_opt_max_age_limit" /> Day / Days
                                                       <b>(If you dont want to use this option enter 0 or leave blank)</b><br/>
							<b>Post older than specified days will not be posted.</b>
						</div>
						

                                                <div class="option">
							<label for="bmp_opt_no_of_post">' . __('Number Of Posts To Post:<br/><span class="desc">Number of posts to share each time.<span>', 'BufferMyPost') . ':</label>
							<input type="text" style="width:30px" id="bmp_opt_no_of_post" value="' . $bmp_opt_no_of_post . '" name="bmp_opt_no_of_post" /></b>  
						</div>



						<div class="option">
							<label for="bmp_opt_post_type">' . __('Post Type:<br/> <span class="desc">What type of items do you want to share?<span>', 'BufferMyPost') . ':</label>
							<select id="bmp_opt_post_type" name="bmp_opt_post_type" style="width:150px">
								<option value="post" ' . bmp_opt_optionselected("post", $bmp_opt_post_type) . '>' . __(' Post Only ', 'BufferMyPost') . ' </option>
								<option value="page" ' . bmp_opt_optionselected("page", $bmp_opt_post_type) . '>' . __(' Page Only ', 'BufferMyPost') . ' </option>
								<option value="both" ' . bmp_opt_optionselected("both", $bmp_opt_post_type) . '>' . __(' Post & Page ', 'BufferMyPost') . ' </option>
							</select>
                                                        
						</div>
                                                
                        <div class="option">
                        <label for="bmp_opt_acnt_type">' . __('Accounts:<br/> <span class="desc">What accounts do you want to post?<span>', 'BufferMyPost') . ':</label>
                        <div style="float:left">');
                                 
                                                
                  $accessToken=  get_option("bmp_opt_access_token");
                
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
			
                        }
                        else
                        {
                        foreach($response as $profile) {
                          print('<div class="buffer-account"><img src="'.$profile->avatar.'" width="48" height="48" alt="'.$profile->formatted_username.'" />
                            <input type="checkbox" name="profile" value="'.$profile->id.'" id="'.$profile->id.'" onchange="manageacntid(this,\'' . $profile->id . '\');"  />
                            <span class="'.$profile->service.'"></span></div>');
                
                        }
                        
                        }
                    }
  
        
                                                
                                                    
                                                print('
                                                    
                                                    </div></div>
                                                    
                                                <input type="hidden" name="acntids" id="acntids" value="' . $acntids . '" />
                                                <div class="option">
							<label for="bmp_enable_log">' . __('Enable Log: ', 'BufferMyPost') . '</label>
							<input type="checkbox" name="bmp_enable_log" id="bmp_enable_log" ' . $bmp_enable_log . ' /> 
                                                        <b>saves log in log folder</b>    
                                                       
						</div>

                                        
				    	<div class="option category">
				    	<div style="float:left">
						    	<label class="catlabel">' . __('Categories to Omit from posts: <br/><span class="desc">Check categories not to share.<span> ', 'BufferMyPost') . '</label> </div>
						    	<div style="float:left">
						    		<ul id="categorychecklist" class="list:category categorychecklist form-no-clear">
								');
        wp_category_checklist(0, 0, explode(',', $omitCats));
        print('				    		</ul>
              <div style="clear:both;padding-bmp:20px;">
                                                          <a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=BMPExcludePosts">Exclude specific posts</a> from selected categories.
                                                              </div>
                                                              

								</div>
                                                               
								</div>
					</fieldset>
					
                                                

                                                <h3>Note: Please click update to then click post now to reflect the changes.</h3>
						<p class="submit"><input type="submit" name="submit" onclick="javascript:return validate()" value="' . __('Update Buffer My Post Options', 'BufferMyPost') . '" />
						<input type="submit" name="post" value="' . __('Post Now', 'BufferMyPost') . '" />
                                                <input type="submit" onclick=\'return resetSettings();\' name="reset" value="' . __('Reset Settings', 'BufferMyPost') . '" />
					</p>
						
				</form><script language="javascript" type="text/javascript">
function validate()
{

 if(trim(document.getElementById("bmp_opt_interval").value) != "" && !isNumber(trim(document.getElementById("bmp_opt_interval").value)))
        {
            alert("Enter only numeric in Minimum interval between post");
		document.getElementById("bmp_opt_interval").focus();
		return false;
        }

 if(trim(document.getElementById("bmp_opt_no_of_post").value) != "" && !isNumber(trim(document.getElementById("bmp_opt_no_of_post").value)))
        {
            alert("Enter only numeric in Number Of Posts To Post");
		document.getElementById("bmp_opt_no_of_post").focus();
		return false;
        }

        if(trim(document.getElementById("bmp_opt_age_limit").value) != "" && !isNumber(trim(document.getElementById("bmp_opt_age_limit").value)))
        {
            alert("Enter only numeric in Minimum age of post");
		document.getElementById("bmp_opt_age_limit").focus();
		return false;
        }
 if(trim(document.getElementById("bmp_opt_max_age_limit").value) != "" && !isNumber(trim(document.getElementById("bmp_opt_max_age_limit").value)))
        {
            alert("Enter only numeric in Maximum age of post");
		document.getElementById("bmp_opt_max_age_limit").focus();
		return false;
        }
	if(trim(document.getElementById("bmp_opt_max_age_limit").value) != "" && trim(document.getElementById("bmp_opt_max_age_limit").value) != 0)
	{
	if(eval(document.getElementById("bmp_opt_age_limit").value) > eval(document.getElementById("bmp_opt_max_age_limit").value))
	{
		alert("Post max age limit cannot be less than Post min age iimit");
		document.getElementById("bmp_opt_age_limit").focus();
		return false;
	}
	}
}

function trim(stringToTrim) {
	return stringToTrim.replace(/^\s+|\s+$/g,"");
}



function isNumber(val)
{
    if(isNaN(val)){
        return false;
    }
    else{
        return true;
    }
}
function setFormAction()
{
    
        var loc=location.href;
        if(location.href.indexOf("&")>0)
        {
            location.href.substring(0,location.href.lastIndexOf("&"));
        }
        document.getElementById("bmp_opt").action=loc;
        
   
 }

function resetSettings()
{
   var re = confirm("This will reset all the setting, including your account, omitted categories, and your excluded posts. Are you sure you want to reset all the settings?");
   if(re==true)
   {
        document.getElementById("bmp_opt").action=location.href;
        return true;
   }
   else
   {
        return false;
   }
}

setFormAction();

 function manageacntid(ctrl,id)
				{
					
					var acntids = document.getElementById("acntids").value;
					if(ctrl.checked)
					{
						acntids=addId(acntids,id);
					}
					else
					{
						acntids=removeId(acntids,id);
					}	
					document.getElementById("acntids").value=acntids;
  
				}

function removeId(list, value) {
  list = list.split(",");
if(list.indexOf(value) != -1)
  list.splice(list.indexOf(value), 1);
  var newlist = list.join(",");
  
  if(newlist.substring(0,1) == ",")
    newlist = newlist.substring(1,newlist.length);
  
if(newlist.substring(newlist.length-1,1) == ",")
    newlist = newlist.substring(0,newlist.length-1);

  return newlist;  
}


function addId(list,value)
{
list = list.split(",");
if(list.indexOf(value) == -1)
    list.push(value);
newlist = list.join(",");
if(newlist.substring(0,1) == ",")
    newlist = newlist.substring(1,newlist.length);
  
if(newlist.substring(newlist.length-1,1) == ",")
    newlist = newlist.substring(0,newlist.length-1);

  return newlist;  
}

function setBufferIds()
{
    var acntids = document.getElementById("acntids").value;
    var arracntids = acntids.split(",");
    
for(var i=0;i<arracntids.length;i++) {
    document.getElementById(arracntids[i]).checked=true;
}
    

}
setBufferIds();
</script>');
    } else {
        print('
			<div id="message" class="updated fade">
				<p>' . __('You do not have enough permission to set the option. Please contact your admin.', 'BufferMyPost') . '</p>
			</div>');
    }
}

function bmp_opt_optionselected($opValue, $value) {
    if ($opValue == $value) {
        return 'selected="selected"';
    }
    return '';
}

function bmp_opt_head_admin() {
    $home = get_settings('siteurl');
    $base = '/' . end(explode('/', str_replace(array('\\', '/bmp-admin.php'), array('/', ''), __FILE__)));
    $stylesheet = $home . '/wp-content/plugins' . $base . '/css/buffer-my-post.css';
    echo('<link rel="stylesheet" href="' . $stylesheet . '" type="text/css" media="screen" />');
}

?>