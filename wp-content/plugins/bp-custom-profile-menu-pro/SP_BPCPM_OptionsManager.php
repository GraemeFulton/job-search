<?php


if(!class_exists('SP_BPCPM_OptionsManager'))
{
    
class SP_BPCPM_Option
{
    const textField = 1;
    const dropList = 2;
    const checkbox = 3;
    
    public $key;
    public $type;
    public $meta_data;
    public $auto_render;
            
    function __construct($option_key, $option_type, $option_meta_data, $option_auto_render) 
    {
        $this->key = $option_key;
        $this->type = $option_type;
        $this->meta_data = $option_meta_data;
        $this->auto_render = $option_auto_render;
    }
}

    
class SP_BPCPM_OptionsManager {

    public function getOptionNamePrefix() {
        return get_class($this) . '_';
    }


    public function getOptionMetaData() {
        return array();
    }

    /**
     * @return array of string name of options
     */
    public function getOptionNames() {
        return array_keys($this->getOptionMetaData());
    }

    /**
     * Override this method to initialize options to default values and save to the database with add_option
     * @return void
     */
    protected function initOptions() {
    }

    /**
     * Cleanup: remove all options from the DB
     * @return void
     */
    protected function deleteSavedOptions() {
        $optionMetaData = $this->getOptionMetaData();
        if (is_array($optionMetaData)) {
            foreach ($optionMetaData as $aOptionKey => $aOption) {
                $prefixedOptionName = $this->prefix($aOptionKey); // how it is stored in DB
                delete_option($prefixedOptionName);
            }
        }
    }

    /**
     * @return string display name of the plugin to show as a name/title in HTML.
     * Just returns the class name. Override this method to return something more readable
     */
    public function getPluginDisplayName() {
        return get_class($this);
    }

    /**
     * Get the prefixed version input $name suitable for storing in WP options
     * Idempotent: if $optionName is already prefixed, it is not prefixed again, it is returned without change
     * @param  $name string option name to prefix. Defined in settings.php and set as keys of $this->optionMetaData
     * @return string
     */
    public function prefix($name) {
        $optionNamePrefix = $this->getOptionNamePrefix();
        if (strpos($name, $optionNamePrefix) === 0) { // 0 but not false
            return $name; // already prefixed
        }
        return $optionNamePrefix . $name;
    }

    /**
     * Remove the prefix from the input $name.
     * Idempotent: If no prefix found, just returns what was input.
     * @param  $name string
     * @return string $optionName without the prefix.
     */
    public function &unPrefix($name) {
        $optionNamePrefix = $this->getOptionNamePrefix();
        if (strpos($name, $optionNamePrefix) === 0) {
            return substr($name, strlen($optionNamePrefix));
        }
        return $name;
    }

    /**
     * A wrapper function delegating to WP get_option() but it prefixes the input $optionName
     * to enforce "scoping" the options in the WP options table thereby avoiding name conflicts
     * @param $optionName string defined in settings.php and set as keys of $this->optionMetaData
     * @param $default string default value to return if the option is not set
     * @return string the value from delegated call to get_option(), or optional default value
     * if option is not set.
     */
    public function getOption($optionName, $default = null) {
        $prefixedOptionName = $this->prefix($optionName); // how it is stored in DB
        $retVal = get_option($prefixedOptionName);
        if (!$retVal && $default) {
            $retVal = $default;
        }
        return $retVal;
    }

    /**
     * A wrapper function delegating to WP delete_option() but it prefixes the input $optionName
     * to enforce "scoping" the options in the WP options table thereby avoiding name conflicts
     * @param  $optionName string defined in settings.php and set as keys of $this->optionMetaData
     * @return bool from delegated call to delete_option()
     */
    public function deleteOption($optionName) {
        $prefixedOptionName = $this->prefix($optionName); // how it is stored in DB
        return delete_option($prefixedOptionName);
    }

    /**
     * A wrapper function delegating to WP add_option() but it prefixes the input $optionName
     * to enforce "scoping" the options in the WP options table thereby avoiding name conflicts
     * @param  $optionName string defined in settings.php and set as keys of $this->optionMetaData
     * @param  $value mixed the new value
     * @return null from delegated call to delete_option()
     */
    public function addOption($optionName, $value) {
        $prefixedOptionName = $this->prefix($optionName); // how it is stored in DB
        return add_option($prefixedOptionName, $value);
    }

    /**
     * A wrapper function delegating to WP add_option() but it prefixes the input $optionName
     * to enforce "scoping" the options in the WP options table thereby avoiding name conflicts
     * @param  $optionName string defined in settings.php and set as keys of $this->optionMetaData
     * @param  $value mixed the new value
     * @return null from delegated call to delete_option()
     */
    public function updateOption($optionName, $value) {
        $prefixedOptionName = $this->prefix($optionName); // how it is stored in DB
        return update_option($prefixedOptionName, $value);
    }

    /**
     * A Role Option is an option defined in getOptionMetaData() as a choice of WP standard roles, e.g.
     * 'CanDoOperationX' => array('Can do Operation X', 'Administrator', 'Editor', 'Author', 'Contributor', 'Subscriber')
     * The idea is use an option to indicate what role level a user must minimally have in order to do some operation.
     * So if a Role Option 'CanDoOperationX' is set to 'Editor' then users which role 'Editor' or above should be
     * able to do Operation X.
     * Also see: canUserDoRoleOption()
     * @param  $optionName
     * @return string role name
     */
    public function getRoleOption($optionName) {
        $roleAllowed = $this->getOption($optionName);
        if (!$roleAllowed || $roleAllowed == '') {
            $roleAllowed = 'Administrator';
        }
        return $roleAllowed;
    }

    /**
     * Given a WP role name, return a WP capability which only that role and roles above it have
     * http://codex.wordpress.org/Roles_and_Capabilities
     * @param  $roleName
     * @return string a WP capability or '' if unknown input role
     */
    protected function roleToCapability($roleName) {
        switch ($roleName) {
            case 'Super Admin':
                return 'manage_options';
            case 'Administrator':
                return 'manage_options';
            case 'Editor':
                return 'publish_pages';
            case 'Author':
                return 'publish_posts';
            case 'Contributor':
                return 'edit_posts';
            case 'Subscriber':
                return 'read';
            case 'Anyone':
                return 'read';
        }
        return '';
    }

    /**
     * @param $roleName string a standard WP role name like 'Administrator'
     * @return bool
     */
    public function isUserRoleEqualOrBetterThan($roleName) {
        if ('Anyone' == $roleName) {
            return true;
        }
        $capability = $this->roleToCapability($roleName);
        return current_user_can($capability);
    }

    /**
     * @param  $optionName string name of a Role option (see comments in getRoleOption())
     * @return bool indicates if the user has adequate permissions
     */
    public function canUserDoRoleOption($optionName) {
        $roleAllowed = $this->getRoleOption($optionName);
        if ('Anyone' == $roleAllowed) {
            return true;
        }
        return $this->isUserRoleEqualOrBetterThan($roleAllowed);
    }

    /**
     * see: http://codex.wordpress.org/Creating_Options_Pages
     * @return void
     */
    public function createSettingsMenu() {
        $pluginName = $this->getPluginDisplayName();
        //create new top-level menu
        add_menu_page($pluginName . ' Plugin Settings',
                      $pluginName,
                      'administrator',
                      get_class($this),
                      array(&$this, 'settingsPage')
        /*,plugins_url('/images/icon.png', __FILE__)*/); // if you call 'plugins_url; be sure to "require_once" it

        //call register settings function
        add_action('admin_init', array(&$this, 'registerSettings'));
    }

    public function registerSettings() {
        $settingsGroup = get_class($this) . '-settings-group';
        $optionMetaData = $this->getOptionMetaData();
        foreach ($optionMetaData as $aOptionKey => $aOption) {
            register_setting($settingsGroup, $aOption->meta_data);
        }
    }
    
    
    public function ispublicOptionKey($slug)
    {
        return SP_BPCPM_ISPUBLIC_OPTIONKEY . '-' . $slug;
    }
 
            
    /**
     * Creates HTML for the Administration page to set options for this plugin.
     * Override this method to create a customized page.
     * @return void
     */
    public function settingsPage() {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.', 'bp-custom-profile-menu'));
        }
     

        $optionMetaData = $this->getOptionMetaData();

        // Save Posted Options
        $refresh = FALSE;
        $POST_HAS_VALUES = count($_POST) > 0;
        if ($optionMetaData!=null && $POST_HAS_VALUES) 
        {
            foreach ($optionMetaData as $aOptionKey => $aOption) 
            {
                if($aOption->type != SP_BPCPM_Option::checkbox)
                {
                    if (isset($_POST[$aOptionKey])) {
                        $oldvalue = $this->getOption($aOptionKey);
                        $newvalue = $_POST[$aOptionKey];
                        if($oldvalue != $newvalue)
                        {
                            $this->updateOption($aOptionKey, $newvalue);
                            $refresh = TRUE;                        
                        }                    
                    }
                }
                else
                {
                    // A separate case is needed for checkboxes because $_POST contains not values for unchecked boxes            
                    $oldvalue = $this->getOption($aOptionKey);
                    $newvalue = NULL;
                    if(isset($_POST[$aOptionKey]))
                        $newvalue = $_POST[$aOptionKey];
                    if($oldvalue!=$newvalue)
                    {
                        $this->updateOption($aOptionKey, $newvalue);
                        $refresh = TRUE;
                    }
                }
            }
        }
        if($refresh)
        {
            // must refresh to update BP structure
            ?>
            <script type="text/javascript">
                window.location.href="";
            </script>
            <?php
            return;
        }
        
        // HTML for the page
        $settingsGroup = get_class($this) . '-settings-group';
        ?>
        <div class="wrap">
            <h2><?php echo $this->getPluginDisplayName(); echo ' '; _e('Settings', 'bp-custom-profile-menu'); ?></h2>
            <br />
            <?php
                if(!$this->SP_BPCPM_BuddyPressActivated())
                    wp_die('BuddyPress not activated.');
            ?>
            <form id="settings-form" method="post" action="">
            <?php settings_fields($settingsGroup); ?>
                <table class="form-table"><tbody>
                <?php 
                if ($optionMetaData != null) {
                    foreach ($optionMetaData as $aOptionKey => $aOption) {
                        
                        if(!$aOption->auto_render)
                            continue;
                        
                        $aOptionMeta = $aOption->meta_data;
                        
                        $displayText = is_array($aOptionMeta) ? $aOptionMeta[0] : $aOptionMeta;
                        ?>
                            <tr valign="top">
                                <th scope="row"><label for="<?php echo $aOptionKey ?>"><?php echo $displayText ?></label></th>
                                <td>
                                <?php echo $this->createFormControl($aOption, $this->getOption($aOptionKey)); ?>
                                </td>
                            </tr>
                        <?php
                    }
                }
            

                ?>
                </tbody></table>
                <input type="hidden" name="_menu_order" id="_menu_order" />
                <p class="submit">
                    <input type="submit" class="button-primary"
                           value="<?php _e('Update', 'bp-custom-profile-menu') ?>"/>
                </p>
                
                <div class="bp-profile-menu-sort">
                    <?php if(SP_BPCPM_PRO) echo'<p><strong>Drag and drop menu items to rearrange them.</strong></p>'; ?>
                    <noscript>
                        <div class="error message">
                                <p>Please enable javascript to be able to rearrange menu items.</p>
                        </div>
                    </noscript>
                    <ul id="SP_BPCPM_sortable" class="ui-sortable" style="width:350px;">
                        <?php
                            global $bp;
                            foreach ( (array) $bp->bp_nav as $user_nav_item )
                            {
                                $custom_menu = is_array($user_nav_item['screen_function']);
                                
                                $item_title = preg_replace('#<span(.*?)</span>#', '', $user_nav_item['name']);
                                $item_position = $user_nav_item['position'];
                                $html_options = null;
                                if($custom_menu && SP_BPCPM_PRO)
                                    $html_options = $this->html_menuitem_options($user_nav_item['slug'], $optionMetaData);

                                $class_tag = '';
                                if($custom_menu)
                                        $class_tag = 'class="SP_custom-item"';
                               
                                echo "<li id='item_$item_position' $class_tag><span><table border='0'><tr><td style='width:270px;'>$item_title</td><td style='font-weight:normal;'>$html_options</td></tr></table></span></li>";
                            }
                        ?>
                    </ul>
                    <?php
                        if(SP_BPCPM_PRO)
                        {
                            ?>
                            <p class="submit">
                                <input type="submit" class="button-primary"
                                       value="<?php _e('Update', 'bp-custom-profile-menu') ?>"/>
                                <input type="button" class="button-primary" id="reset-button" onclick="reset_button_click(event);"
                                       style="margin-left: 10px; background: #FF5C00; border-color: #FF5C00;" 
                                       value="<?php _e('Reset Order', 'bp-custom-profile-menu') ?>"/>
                            </p>
                            <script type="text/javascript">
                                    jQuery(document).ready(function() {
                                            jQuery("#SP_BPCPM_sortable").sortable({
                                                    update: function(event, ui) {
                                                        jQuery('#_menu_order').val(jQuery("#SP_BPCPM_sortable").sortable("serialize"));
                                                    },
                                                    'tolerance':'intersect',
                                                    'cursor':'pointer',
                                                    'items':'li',
                                                    'placeholder':'placeholder',
                                                    'nested': 'ul'
                                            });

                                            jQuery("#SP_BPCPM_sortable").disableSelection();
                                    });

                                    function reset_button_click(event) {
                                        document.getElementById('_menu_order').value = 'reset';
                                        document.getElementById('settings-form').submit();
                                    }
                            </script>
                            <?php
                        }
                        else
                        {
                            ?>
                                <div style="background-color: lightYellow; border-color: #E6DB55; margin: 15px 0 15px; padding: 0.8em; -webkit-border-radius: 3px; border-radius: 3px; border-width: 1px; border-style: solid; width:700px;">
                                     <strong>Want more control?</strong> If you like this plugin but would like to visually reorder the tabs, or get more features such as sub-tabs, public tabs, or iframe tabs, make sure to grab yourself a copy of the <strong>Pro</strong> version from <a href="http://sensibleplugins.com" target="_blank"><strong>Sensible Plugins</strong></a>.
                                </div>
                            <?php
                        }
                    ?>
                </div>
            </form>
            
        </div>
        <?php

    }

    
    protected function html_menuitem_options($item_slug, $meta_array)
    {
        return NULL;
    }

        
    /**
     * Helper-function outputs the correct form element (input tag, select tag) for the given item
     * @param  $aOptionKey string name of the option (un-prefixed)
     * @param  $aOptionMeta mixed meta-data for $aOptionKey (either a string display-name or an array(display-name, option1, option2, ...)
     * @param  $savedOptionValue string current value for $aOptionKey
     * @return void
     */
    protected function createFormControl($aOption, $savedOptionValue) 
    {
        $aOptionKey = $aOption->key;
        $aOptionMeta = $aOption->meta_data;
        
        $control_html = '';
        
        switch ($aOption->type)
        {
            case SP_BPCPM_Option::textField:
                $saved_option = esc_attr($savedOptionValue);
                $control_html = "<p><input type='text' name='$aOptionKey' id='echo $aOptionKey'
                      value='$saved_option' size='50'/></p>";                
            break;

            case SP_BPCPM_Option::dropList:
                if (is_array($aOptionMeta) && count($aOptionMeta) >= 2) 
                { 
                    $choices = array_slice($aOptionMeta, 1);
            
                    $control_html = "<select name='$aOptionKey' id='$aOptionKey'>";
                    foreach ($choices as $aChoice) 
                    {
                        $selected = ($aChoice == $savedOptionValue) ? 'selected' : '';
                        $option_value = $this->getOptionValueI18nString($aChoice);
                        $control_html .= "<option value='$aChoice' $selected>$option_value</option>";  
                    }
                    $control_html .= "</select>";
                }
            break;
        
            case SP_BPCPM_Option::checkbox:
                $checked_value = '';
                if($savedOptionValue)
                    $checked_value = "checked='TRUE'";
                $control_html = "<input type='checkbox' name='$aOptionKey' id='$aOptionKey' value='TRUE' $checked_value /> $aOptionMeta";
            break;
        }
        
        return $control_html;
    }

    /**
     * Override this method and follow its format.
     * The purpose of this method is to provide i18n display strings for the values of options.
     * For example, you may create a options with values 'true' or 'false'.
     * In the options page, this will show as a drop down list with these choices.
     * But when the the language is not English, you would like to display different strings
     * for 'true' and 'false' while still keeping the value of that option that is actually saved in
     * the DB as 'true' or 'false'.
     * To do this, follow the convention of defining option values in getOptionMetaData() as canonical names
     * (what you want them to literally be, like 'true') and then add each one to the switch statement in this
     * function, returning the "__()" i18n name of that string.
     * @param  $optionValue string
     * @return string __($optionValue) if it is listed in this method, otherwise just returns $optionValue
     */
    protected function getOptionValueI18nString($optionValue) {
        switch ($optionValue) {
            case 'true':
                return __('true', 'bp-custom-profile-menu');
            case 'false':
                return __('false', 'bp-custom-profile-menu');

            case 'Administrator':
                return __('Administrator', 'bp-custom-profile-menu');
            case 'Editor':
                return __('Editor', 'bp-custom-profile-menu');
            case 'Author':
                return __('Author', 'bp-custom-profile-menu');
            case 'Contributor':
                return __('Contributor', 'bp-custom-profile-menu');
            case 'Subscriber':
                return __('Subscriber', 'bp-custom-profile-menu');
            case 'Anyone':
                return __('Anyone', 'bp-custom-profile-menu');
        }
        return $optionValue;
    }

    /**
     * Query MySQL DB for its version
     * @return string|false
     */
    protected function getMySqlVersion() {
        global $wpdb;
        $rows = $wpdb->get_results('select version() as mysqlversion');
        if (!empty($rows)) {
             return $rows[0]->mysqlversion;
        }
        return false;
    }

    /**
     * If you want to generate an email address like "no-reply@your-site.com" then
     * you can use this to get the domain name part.
     * E.g.  'no-reply@' . $this->getEmailDomain();
     * This code was stolen from the wp_mail function, where it generates a default
     * from "wordpress@your-site.com"
     * @return string domain name
     */
    public function getEmailDomain() {
        // Get the site domain and get rid of www.
        $sitename = strtolower($_SERVER['SERVER_NAME']);
        if (substr($sitename, 0, 4) == 'www.') {
            $sitename = substr($sitename, 4);
        }
        return $sitename;
    }
}
    
    
} // endif class_exists

