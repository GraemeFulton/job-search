<?php
/**
 * Facebook login index
 */


if( !class_exists( 'GEARS_MODULES_FACEBOOK_LOGIN' ))
{

class GEARS_MODULES_FACEBOOK_LOGIN{
	
	var $facebook = '';
	var $registrant_settings = '';
	var $button_label = '';
	
	function __construct( $app_id = '', $app_secret = '', $registrant_settings, $button_label = "" ){
		
		$this->button_label = $button_label;
		
		// include the facebook library
		require GEARS_APP_PATH . 'modules/facebook-login/src/facebook.php';
		
		// appId and secret should be set in klein theme options. Itegration.
		$this->facebook = new Facebook(array(
			  'appId'  => $app_id,
			  'secret' => $app_secret,
		));
		
		$this->registrant_settings = $registrant_settings;
		
		//integrate facebook login link to default wordpress login form
		add_action( 'login_form', array( $this, 'integrate' ) );
		
		//integrates with buddypress registration
		add_action( 'bp_before_register_page', array( $this, 'integrate' ) );
		
		//add return url action that will handle the facebook api callback data
		add_action( 'wp_ajax_gears_fb_connect', array( $this, 'connect' ) );
			add_action( 'wp_ajax_nopriv_gears_fb_connect', array( $this, 'connect' ) );
		
		//add custom error message to login
		add_action( 'login_head', array( $this, 'custom_error_message' ) );
		
		//add facebook login button to login modal
		//add_filter( 'login_form_bottom', array( $this, 'modal_fb_connect' ) );
	}
	

	public function connect(){
		// get the user
		$user = $this->facebook->getUser();

		// We may or may not have this data based on whether the user is logged in.
		//
		// If we have a $user id here, it means we know the user is logged into
		// Facebook, but we don't know if the access token is valid. An access
		// token is invalid if the user logged out of Facebook.

		if( $user ){
			try{
				// Proceed knowing you have a logged in user who's authenticated.
				$user_profile = $this->facebook->api('/me');
				// generate new username of the user
				if( 'unique' == $this->registrant_settings ){
					$username = $user_profile['username'] . '_' . $this->alphaID( $user_profile['id'] );
				}else{
					$username = $user_profile['username'];
				}
				
				$useremail = $user_profile['email'];
				
				// check if the same username already exists in the database
				// if username already exist, do not create new user
				// rather, just logged the user
				if( username_exists( $username ) and email_exists( $useremail ) ){
					$user = get_user_by( 'login', $username );
					wp_set_auth_cookie ( $user->ID );
					// if buddypress is enabled redirect to its profile
					if( function_exists( 'bp_loggedin_user_domain' ) ){
						wp_safe_redirect( bp_core_get_user_domain( $user->ID ) );
					}else{// else just redirect to homepage
						wp_safe_redirect( get_bloginfo( 'url' ) );
					}
				}else{
				
					// create new username for the user
					// and email the password to the user
					$password = wp_generate_password();
					$user_id = wp_create_user( $username, $password, $useremail );
					
					if( is_numeric( $user_id ) ){
						//email the user his credentials
						wp_new_user_notification( $user_id, $password );
						wp_set_auth_cookie ( $user_id );
						
						if( function_exists( 'bp_loggedin_user_domain' ) ){
							wp_safe_redirect( bp_core_get_user_domain( $user_id ) );
						}else{
							// else just redirect to homepage
							wp_safe_redirect( get_bloginfo( 'url' ) );
						}
					}else{
						wp_safe_redirect( wp_login_url() . '?error=true&type=gears_username_or_email_exists' );
						return;
					}
				}
				
			}catch ( FacebookApiException $e ){
				error_log($e);
				$user = null;
				wp_safe_redirect( wp_login_url() . '?error=true&type=fb_error' );
			}
		}
		
		die();
	}
	
	public function integrate(){
		?>
			<?php 
				$login_url = $this->facebook->getLoginUrl(
					array(
						'redirect_uri' => admin_url( 'admin-ajax.php?action=gears_fb_connect')
					)	
				); 
			?>
			<p class="login-facebook-connect">
				<a class="btn btn-primary" href="<?php echo $login_url; ?>" title="<?php echo $this->button_label; ?>">
					<?php echo $this->button_label; ?>
				</a>
			</p>
		<?php
	}
	
	public function custom_error_message(){
	
		$wp_error = new WP_Error();
		
		if( isset( $_GET['error'] ) and isset( $_GET['type'] ) ){
			if( $_GET['type'] == 'gears_username_or_email_exists' ){
				add_filter( 'login_message', array( $this, 'custom_error_message_text' ) );
			}
			
			if( $_GET['type'] == 'fb_error'){
				add_filter( 'login_message', array( $this, 'custom_fb_error_message_text' ) );
			}
		}
	}
	
	public function custom_error_message_text(){
		?>
		<div id="login_error">
			<?php 
				_e(
				'The username or email you are trying to connect with your facebook account is already registered.',
				'community-essentials'
				); 
			?>
		</div>
		<?php
	}
	
	public function custom_fb_error_message_text(){
	?>
		<div id="login_error">
			<?php 
				_e(
				'There was an error trying to communicate with the Facebook API. Please come back again later.',
				'community-essentials'
				); 
			?>
		</div>
		<?php
	}
	
	/**
	 * Translates a number to a short alhanumeric version
	 *
	 * Translated any number up to 9007199254740992
	 * to a shorter version in letters e.g.:
	 * 9007199254740989 --> PpQXn7COf
	 *
	 * specifiying the second argument true, it will
	 * translate back e.g.:
	 * PpQXn7COf --> 9007199254740989
	 *
	 * this function is based on any2dec && dec2any by
	 * fragmer[at]mail[dot]ru
	 * see: http://nl3.php.net/manual/en/function.base-convert.php#52450
	 *
	 * If you want the alphaID to be at least 3 letter long, use the
	 * $pad_up = 3 argument
	 *
	 * In most cases this is better than totally random ID generators
	 * because this can easily avoid duplicate ID's.
	 * For example if you correlate the alpha ID to an auto incrementing ID
	 * in your database, you're done.
	 *
	 * The reverse is done because it makes it slightly more cryptic,
	 * but it also makes it easier to spread lots of IDs in different
	 * directories on your filesystem. Example:
	 * $part1 = substr($alpha_id,0,1);
	 * $part2 = substr($alpha_id,1,1);
	 * $part3 = substr($alpha_id,2,strlen($alpha_id));
	 * $destindir = "/".$part1."/".$part2."/".$part3;
	 * // by reversing, directories are more evenly spread out. The
	 * // first 26 directories already occupy 26 main levels
	 *
	 * more info on limitation:
	 * - http://blade.nagaokaut.ac.jp/cgi-bin/scat.rb/ruby/ruby-talk/165372
	 *
	 * if you really need this for bigger numbers you probably have to look
	 * at things like: http://theserverpages.com/php/manual/en/ref.bc.php
	 * or: http://theserverpages.com/php/manual/en/ref.gmp.php
	 * but I haven't really dugg into this. If you have more info on those
	 * matters feel free to leave a comment.
	 *
	 * The following code block can be utilized by PEAR's Testing_DocTest
	 * <code>
	 * // Input //
	 * $number_in = 2188847690240;
	 * $alpha_in  = "SpQXn7Cb";
	 *
	 * // Execute //
	 * $alpha_out  = alphaID($number_in, false, 8);
	 * $number_out = alphaID($alpha_in, true, 8);
	 *
	 * if ($number_in != $number_out) {
	 *    echo "Conversion failure, ".$alpha_in." returns ".$number_out." instead of the ";
	 *    echo "desired: ".$number_in."\n";
	 * }
	 * if ($alpha_in != $alpha_out) {
	 *    echo "Conversion failure, ".$number_in." returns ".$alpha_out." instead of the ";
	 *    echo "desired: ".$alpha_in."\n";
	 * }
	 *
	 * // Show //
	 * echo $number_out." => ".$alpha_out."\n";
	 * echo $alpha_in." => ".$number_out."\n";
	 * echo alphaID(238328, false)." => ".alphaID(alphaID(238328, false), true)."\n";
	 *
	 * // expects:
	 * // 2188847690240 => SpQXn7Cb
	 * // SpQXn7Cb => 2188847690240
	 * // aaab => 238328
	 *
	 * </code>
	 *
	 * @author   Kevin van Zonneveld <kevin@vanzonneveld.net>
	 * @author   Simon Franz
	 * @author   Deadfish
	 * @copyright 2008 Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD Licence
	 * @version   SVN: Release: $Id: alphaID.inc.php 344 2009-06-10 17:43:59Z kevin $
	 * @link   http://kevin.vanzonneveld.net/
	 *
	 * @param mixed   $in      String or long input to translate
	 * @param boolean $to_num  Reverses translation when true
	 * @param mixed   $pad_up  Number or boolean padds the result up to a specified length
	 * @param string  $passKey Supplying a password makes it harder to calculate the original ID
	 *
	 * @return mixed string or long
	 */
	private function alphaID($in, $to_num = false, $pad_up = false, $passKey = null)
	{
	  $index = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	  if ($passKey !== null) {
		  // Although this function's purpose is to just make the
		  // ID short - and not so much secure,
		  // with this patch by Simon Franz (http://blog.snaky.org/)
		  // you can optionally supply a password to make it harder
		  // to calculate the corresponding numeric ID

		  for ($n = 0; $n<strlen($index); $n++) {
			  $i[] = substr( $index,$n ,1);
		  }

		  $passhash = hash('sha256',$passKey);
		  $passhash = (strlen($passhash) < strlen($index))
			  ? hash('sha512',$passKey)
			  : $passhash;

		  for ($n=0; $n < strlen($index); $n++) {
			  $p[] =  substr($passhash, $n ,1);
		  }

		  array_multisort($p,  SORT_DESC, $i);
		  $index = implode($i);
	  }

	  $base  = strlen($index);

	  if ($to_num) {
		  // Digital number  <<--  alphabet letter code
		  $in  = strrev($in);
		  $out = 0;
		  $len = strlen($in) - 1;
		  for ($t = 0; $t <= $len; $t++) {
			  $bcpow = bcpow($base, $len - $t);
			  $out   = $out + strpos($index, substr($in, $t, 1)) * $bcpow;
		  }

		  if (is_numeric($pad_up)) {
			  $pad_up--;
			  if ($pad_up > 0) {
				  $out -= pow($base, $pad_up);
			  }
		  }
		  $out = sprintf('%F', $out);
		  $out = substr($out, 0, strpos($out, '.'));
	  } else {
		  // Digital number  -->>  alphabet letter code
		  if (is_numeric($pad_up)) {
			  $pad_up--;
			  if ($pad_up > 0) {
				  $in += pow($base, $pad_up);
			  }
		  }

		  $out = "";
		  for ($t = floor(log($in, $base)); $t >= 0; $t--) {
			  $bcp = bcpow($base, $t);
			  $a   = floor($in / $bcp) % $base;
			  $out = $out . substr($index, $a, 1);
			  $in  = $in - ($a * $bcp);
		  }
		  $out = strrev($out); // reverse
	  }

	  return $out;
	}
}

}
?>