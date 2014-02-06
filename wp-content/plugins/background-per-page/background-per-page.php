<?php /*
Plugin Name: Background Per Page
Plugin URI: http://fishcantwhistle.com
Author: Fish Can't Whistle
Version: 0.3
*/

if (!defined("BPP_url")) { define("BPP_url", WP_PLUGIN_URL.'/background-per-page'); } //NO TRAILING SLASH

if (!defined("BPP_dir")) { define("BPP_dir", WP_PLUGIN_DIR.'/background-per-page'); } //NO TRAILING SLASH

include_once('meta-boxes/meta-box.php');

$prefix = '_bpp_';

global $meta_boxes;

$meta_boxes = array();

$meta_boxes[] = array(
	'id' => 'bbp',

	'title' => 'Background',

	'pages' => array( 'post', 'page', 'bpp_settings'),

	'context' => 'normal',

	'priority' => 'high',

	'fields' => array(
		array(
			'name'		=> 'Element',
			'id'		=> "{$prefix}element",
			'type'		=> 'radio',
			'options'	=> array(
				'body'			=> 'body',
				'html'			=> 'html',
				'.page_content' => '.page_content',
				'.post_content' => '.post_content',
			),
			'std'		=> 'body',
			'desc'		=> 'Which element to apply the background to?'
		),
		array(
			'name'	=> 'Background Image',
			'desc'	=> 'Upload the image you would like to use as the background for this page/post.',
			'id'	=> "{$prefix}background",
			'type'	=> 'plupload_image',
			'max_file_uploads' => 1,
		),
		array(
			'name'		=> 'Repeat-x?',
			'id'		=> "{$prefix}repeat-x",
			'type'		=> 'radio',
			'options'	=> array(
				'yes'			=> 'Yes',
				'no'			=> 'No'
			),
			'std'		=> 'yes',
			'desc'		=> 'Repeat this image on horizontaly?'
		),
		array(
			'name'		=> 'Repeat-y?',
			'id'		=> "{$prefix}repeat-y",
			'type'		=> 'radio',
			'options'	=> array(
				'yes'			=> 'Yes',
				'no'			=> 'No'
			),
			'std'		=> 'yes',
			'desc'		=> 'Repeat this image on vertically?'
		),
		array(
			'name'		=> 'Attachment',
			'id'		=> "{$prefix}attachment",
			'type'		=> 'radio',
			'options'	=> array(
				'scroll'		=> 'Scroll',
				'fixed'			=> 'Fixed'
			),
			'std'		=> 'scroll',
			'desc'		=> 'How the background image reacts to scrolling.'
		),
		array(
			'name'		=> 'Position',
			'id'		=> "{$prefix}position",
			'type'		=> 'radio',
			'options'	=> array(
				'left'			=> 'Left',
				'center'		=> 'Center',
				'right'			=> 'Right'
			),
			'std'		=> 'center',
			'desc'		=> 'The position of the image on the page.'
		),
		array(
			'name'		=> 'Fade?',
			'id'		=> "{$prefix}fade",
			'type'		=> 'radio',
			'options'	=> array(
				'yes'			=> 'Yes',
				'no'			=> 'No'
			),
			'std'		=> 'yes',
			'desc'		=> 'Fade the bottom edge of the image out?'
		),
		array(
			'name'		=> 'Fade Height',
			'id'		=> "{$prefix}fade_height",
			'type'		=> 'text',
			'std'		=> '100',
			'desc'		=> 'How many pixels from the bottom of the image should the fade start from?'
		),
		array(
			'name'		=> 'Background colour',
			'id'		=> "{$prefix}color",
			'type'		=> 'color',
			'desc'		=> 'Use a background colour as well as or instead of an image.'
		),
	)
);

/********************* META BOX REGISTERING ***********************/

/**
 * Register meta boxes
 *
 * @return void
 */
function _bpp__register_meta_boxes()
{
	global $meta_boxes;

	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( class_exists( 'RW_Meta_Box' ) )
	{
		foreach ( $meta_boxes as $meta_box )
		{
			new RW_Meta_Box( $meta_box );
		}
	}
}
// Hook to 'admin_init' to make sure the meta box class is loaded before
// (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking page template, categories, etc.
add_action( 'admin_init', '_bpp__register_meta_boxes' );

function add_background_per_page(){

	global $post;
	
	$data = get_data($post->ID);
	
	if($data['src'] == ''){
			
		$data = get_data($post->post_parent);
		
		if($data['src'] == ''){
		
			$get = get_post($post->post_parent);
			$id = $get->post_parent;
			
			$data = get_data($id);
			
			if($data['src'] == ''){
		
				$get = get_post($get->post_parent);
				$id = $get->post_parent;
				
				$data = get_data($id);
				
				if($data['src'] == ''){
			
					$get = get_post($get->post_parent);
					$id = $get->post_parent;
					
					$data = get_data($id);
				
				}

			
			}
		
		}
	
	}
	
	$element = $data['element'];
	$src_height = $data['src_height'];
	$src_width = $data['src_width'];
	$src = $data['src'];
	$repeat = $data['repeat'];
	$color = $data['color'];
	$position = $data['position'];
	$attachment = $data['attachment'];
	$fade = $data['fade'];
	$fade_height = $data['fade_height'];
	
	if($fade == 'yes'){ 
	
		$top = $src_height - $fade_height; ?>
	
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('<div id="fade"></div>').prependTo( '<?php echo $element; ?>' );
				jQuery('#fade')
					.css('width', jQuery('body').width())
			});
		
		</script>
	
	<?php }
						
	if($src != ''){
		
		?><style type="text/css">
		
			<?php echo $element; ?>, <?php echo $element; ?>.custom-background  { 
				<?php if($color != ''){ ?>
					background-color: <?php echo $color; ?>; 
				<?php } ?>
				<?php if($src != ''){ ?>
					background-image: url('<?php echo $src; ?>'); 
				<?php } ?>
				<?php if($repeat != ''){ ?>
					background-repeat: <?php echo $repeat; ?>; 
				<?php } ?>
				<?php if($position != ''){ ?>
					background-position: <?php echo $position; ?>; 
				<?php } ?>
				<?php if($attachment != ''){ ?>
					background-attachment: <?php echo $attachment; ?>; 
				<?php } ?>
				
			}
			
			<?php echo $element; ?> > div#fade{ 
				
				position: absolute;
				top: <?php echo $top; ?>px;
				left: 0px;
				height: <?php echo $fade_height; ?>px;
							
				background-color: rgba(255,255,255,0);
			   	background-image: none;
			   	background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(rgba(255,255,255,0)), to(<?php echo $color; ?>));
			   	background-image: -webkit-linear-gradient(top, rgba(255,255,255,0), <?php echo $color; ?>);
			   	background-image:    -moz-linear-gradient(top, rgba(255,255,255,0), <?php echo $color; ?>);
			   	background-image:     -ms-linear-gradient(top, rgba(255,255,255,0), <?php echo $color; ?>);
			   	background-image:      -o-linear-gradient(top, rgba(255,255,255,0), <?php echo $color; ?>);
			}
			
		</style><?php
	
	}

}

function get_data($id){

	$element = '';
	$src = '';
	$repeat = '';
	$fade = '';
	$position = '';
	$attachment = '';
	
	$element = get_post_meta( $id, '_bpp_element', true );
	
	$images = get_post_meta( $id, '_bpp_background', false );
	
	if(is_array($images)){
	
		foreach ( $images as $att ){
		    $src = wp_get_attachment_image_src( $att, 'full' );
		    $src_width = $src[1];
		    $src_height = $src[2];
		    $src = $src[0];
		}
	
	}
	
	$x = get_post_meta( $id, '_bpp_repeat-x', true );

	$y = get_post_meta( $id, '_bpp_repeat-y', true );
	
	if($x == 'yes' && $y == 'yes'){
		$repeat = 'repeat';
	}elseif($x == 'yes' && $y == 'no'){
		$repeat = 'repeat-x';
	}elseif($y == 'yes' && $x == 'no'){
		$repeat = 'repeat-y';
	}elseif($x == 'no' && $y == 'no'){
		$repeat = 'no-repeat';
	}
	
	$color = get_post_meta( $id, '_bpp_color', true );
	
	if($color == '#'){
		$color = 'Transparent';
	}
	
	$position = get_post_meta( $id, '_bpp_position', true );
	
	$attachment = get_post_meta( $id, '_bpp_attachment', true );
	
	$fade = get_post_meta( $id, '_bpp_fade', true );
	
	$fade_height = get_post_meta( $id, '_bpp_fade_height', true );

	$data = array();

	$data['element'] = $element;
	$data['src'] = $src;
	$data['src_width'] = $src_width;
	$data['src_height'] = $src_height;
	$data['x'] = $x;
	$data['y'] = $y;
	$data['repeat'] = $repeat;
	$data['position'] = $position;
	$data['attachment'] = $attachment;
	$data['color'] = $color;
	$data['fade'] = $fade;
	$data['fade_height'] = $fade_height;
	
	return $data;

}

add_action( 'wp_head', 'add_background_per_page', 999999 );

add_custom_background();

/* Display a notice that can be dismissed */
add_action('admin_notices', 'bpp_admin_notice');
function bpp_admin_notice() {
    global $current_user ;
        $user_id = $current_user->ID;
        /* Check that the user hasn't already clicked to ignore the message */
    if ( ! get_user_meta($user_id, 'example_ignore_notice') ) {
        echo '<div class="updated"><p>';
        printf(__('<a href="%1$s">I have subscribed</a>'), '?example_nag_ignore=0');
        ?>
        <!-- Begin MailChimp Signup Form -->
		<link href="http://cdn-images.mailchimp.com/embedcode/slim-081711.css" rel="stylesheet" type="text/css">
		<style type="text/css">
			#mc_embed_signup{background:none; clear:left; font:14px Helvetica,Arial,sans-serif; }
			#mc_embed_signup .button{color: #333;};
			/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
			   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
		</style>
		<div id="mc_embed_signup">
		<form action="http://jealousdesigns.us2.list-manage.com/subscribe/post?u=a4a9840b607ebf25275bc7a46&amp;id=8ea7d99292" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
			<label for="mce-EMAIL">Sign up to our WordPress mailing list to receive news and updates about Fish Can't Whistle plugins</label>
			<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
			<input type="hidden" value="Background Per Page" name="MMERGE3">
			<div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
		</form>
		</div>

		<!--End mc_embed_signup-->
        <?php
        echo "</p></div>";
    }
}
add_action('admin_init', 'bpp_nag_ignore');
function bpp_nag_ignore() {
    global $current_user;
        $user_id = $current_user->ID;
        /* If user clicks to ignore the notice, add that to their user meta */
        if ( isset($_GET['example_nag_ignore']) && '0' == $_GET['example_nag_ignore'] ) {
             add_user_meta($user_id, 'example_ignore_notice', 'true', true);
    }
}

?>