<?php

// Twitter Members Extension for Buddypress by Charl Kruger

// $show_twittercj_in_header - Display the twitter widget using our xprofile data and return it in the members header

function show_twittercj_in_header() {

$twittercj_username= xprofile_get_field_data(get_option('twittercj_member_label')); //fetch the location field for the displayed user

	if ( $twittercj_username != "" ) { // check to see the twitter field has data
	
?>
<a href="https://twitter.com/<?php echo $twittercj_username; ?>" class="twitter-follow-button" data-show-count="<?php bp_twitter_member_count(); ?>" <?php if (get_option('twittercj-button-size')==1) echo 'data-size="large""'; ?> >Follow @<?php echo $twittercj_username; ?></a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<?php
	}

}
add_filter( 'bp_before_member_header_meta', 'show_twittercj_in_header' );

function bp_twitter_member_count() {
	if (get_option('twittercj-count')==1) {
		echo 'true';
	}
	else {
		echo 'false';
	}
}

?>