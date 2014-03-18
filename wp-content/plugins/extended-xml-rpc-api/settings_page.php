<div class="wrap">
<h2>Extended API</h2>
<p>Adjust the settings below for your extended API usage needs.</p>
<h3>Shameless Donation Link</h3>
<p>This plugin will always be free, but donating to the cause helps me keep the project going. If you've found this plugin useful and would like to see improvements for a long time to come, send me some love!</p>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="E4BQR8RA7G9SA">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
<hr/>
<h2>Extended API Settings</h2>
<form method="post" action="options.php">

<div style="float: right; padding: 10px; width: 200px;"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></div>
<p>Adjusting the namespace value will require changes to the code you use to
    access the XML RPC API. For example, the default WordPress API has a namespace
    of "wp", thus a call to getPosts is usually called as wp.getPosts. The default
    namespace for the additonal functions of this plugin is "extapi". If you
    change this namespace value, your code will need to reflect your selected
    namespace.
</p>

    <?php settings_fields( 'extapi_settings' ); ?>
    Namespace: <input type="text" name="namespace" value="<?php echo get_option('namespace'); ?>" />
<p>All of the the following functions are defined and available within WordPress
    by default. Please note, not all of these will necessarily work properly in
    XML RPC requests. This settings page is intended to enable and disable functions
    for security purposes. It does not guarantee that the function will be truly
    usable from the XML RPC API. Use at your own risk.</p>

    <br clear="all" />
    <?php
        asort($extapi_available_functions);
        foreach ($extapi_available_functions as $function) :
    ?>
    <div style="float: left; width: 300px; height: 25px; padding: 5px;">
        <input type="checkbox" name="allowed_functions[]" value="<?php echo $function; ?>" <?php echo (in_array($function, get_option('allowed_functions'))) ? 'CHECKED' : ''; ?> /><?php echo $function . "<br>"; ?>
    </div>
    <?php
        endforeach;
    ?>
    <br clear="all" />
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>
</div>