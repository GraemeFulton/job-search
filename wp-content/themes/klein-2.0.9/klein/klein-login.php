<?php
/**
 * Klein Login
 *
 * Overwrites default WordPress login style
 *
 * @package klein
 * @since 1.0.2
 */
?>
<?php
if( !function_exists('klein_login_logo_url') ){
	function klein_login_logo_url() {
		return get_bloginfo( 'url' );
	}
}
add_filter( 'login_headerurl', 'klein_login_logo_url' );
?>
<?php if( !function_exists('klein_login_logo') ){ ?>
<?php function klein_login_logo() { ?>
	<?php
		// get the logo
		$default_logo = get_template_directory_uri() . '/logo.png';
		$logo = ot_get_option( 'logo', $default_logo );
	?>
    <style type="text/css">
	
	 @import url('http://fonts.googleapis.com/css?family=PT+Sans:400,700|Montserrat:700');
       
		.login label {
			color: #BDC3C7;
			font-size: 14px;
		}

		body.login { background: #1ABC9C ;}
		body.login div#login h1 a {
			background-image: url(<?php echo $logo ?>);
            padding-bottom: 30px;
			background-position: center center;
			background-size: auto;
			width: 326px;
			height: 67px;
		}
		body.login div#login form {
			margin-left: 8px;
			padding: 26px 24px 46px;
			font-weight: normal;
			background: #ECF0F1;
			border: 1px solid #E5E5E5;
			-webkit-box-shadow: none;
			box-shadow: none;
			border-radius: 0;
			-webkit-border-radius: 0;
			-moz-border-radius: 0;
			-webkit-border-radius: 0;
			font-family: "PT Sans","Helvetica", "Times New Roman", serif;
			border-radius: 4px;
			-moz-border-radius: 4px;
			-webkit-border-radius: 4px;
		}
		
		body.login form .input, .login input[type="text"]{
			-webkit-box-shadow: none;
			box-shadow: none;
			border-radius: 0;
		}
		body.login a{
				color: #ECF0F1;
		}
		body.login .message,
		body.login #login_error{
			background: #E74C3C;
			border-bottom: 5px solid #C0392B;
			border-radius: 0;
			color: #ECF0F1;
			-webkit-border-radius: 0;
		}
		body.login .message{
			background: #F1C40F;
			border-bottom: 5px solid #F39C12;
			color: #fff;
		}
		body.login .button,
		body.login div#login form#loginform p.submit input#wp-submit {
				display: inline-block;
				padding: 0px 12px;
				margin-bottom: 0;
				font-size: 14px;
				font-weight: normal;
				line-height: 1.428571429;
				text-align: center;
				white-space: nowrap;
				vertical-align: middle;
				cursor: pointer;
				border: 1px solid rgba(0, 0, 0, 0);
				border-radius: 2px;
				-webkit-user-select: none;
				-moz-user-select: none;
				-ms-user-select: none;
				-o-user-select: none;
				user-select: none;
				color: #fff;	
				 text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.2);
				-webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.15), 0 1px 1px rgba(0, 0, 0, 0.075);
				box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.15), 0 1px 1px rgba(0, 0, 0, 0.075);
				background-image: -webkit-gradient(linear, left 0%, left 100%, from(#428bca), to(#3071a9));
				background-image: -webkit-linear-gradient(top, #428bca, 0%, #3071a9, 100%);
				background-image: -moz-linear-gradient(top, #428bca 0%, #3071a9 100%);
				background-image: linear-gradient(to bottom, #428bca 0%, #3071a9 100%);
				background-repeat: repeat-x;
				border-color: #2d6ca2;
				filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff428bca', endColorstr='#ff3071a9', GradientType=0);
		}
		
		body.login .button:active,
		body.login div#login form#loginform p.submit input#wp-submit:active
		{
			-webkit-box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
			box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
			background-image: none;
			background-color: #3071a9;
			border-color: #2d6ca2;
		}
		body.login div#login p#nav {
			text-shadow: none;
		}
		 
		body.login div#login p#backtoblog {
			text-shadow: none;
		}
		body.login div#login p#nav,
		body.login div#login p#nav a,
		body.login div#login p#backtoblog a {
			color: #ECF0F1!important;
			font-size: 14px;
			text-decoration: none;
			font-family: 'PT Sans', 'Helvetica', 'Arial', sans-serif;
		}
		
		 body.login #ce-facebook-connect-link a {
			background: #3B5A9B;
			padding: 10px 0px;
			display: block;
			margin-bottom: 20px;
			text-align: center;
			color: #ECF0F1;
			font-size: 16px;
			font-weight: bold;
			text-decoration: none;
			border-radius: 3px;
			text-transform: uppercase;
        }
		
		body.login #ce-facebook-connect-link a:active {
			position: relative;
			background: #426ABE;
		}
    </style>
<?php } 
} // end func!klein_login_logo
add_action( 'login_enqueue_scripts', 'klein_login_logo' );
?>