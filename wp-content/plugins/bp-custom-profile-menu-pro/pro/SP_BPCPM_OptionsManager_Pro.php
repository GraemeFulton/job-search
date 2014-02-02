<?php

/*
 *	THIS SOURCE CODE AND ANY ACCOMPANYING DOCUMENTATION ARE PROTECTED BY UNITED STATES 
 *	INTELLECTUAL PROPERTY LAW AND INTERNATIONAL TREATIES. UNAUTHORIZED REPRODUCTION OR 
 *	DISTRIBUTION IS SUBJECT TO CIVIL AND CRIMINAL PENALTIES. YOU SHALL NOT DEVELOP NOR
 *	MAKE AVAILABLE ANY WORK THAT COMPETES WITH A "SENSIBLE PLUGINS" PRODUCT DERIVED FROM THIS 
 *	SOURCE CODE. THIS SOURCE CODE MAY NOT BE RESOLD OR REDISTRIBUTED ON A STAND ALONE BASIS.
 *
 *	USAGE OF THIS SOURCE CODE IS BOUND BY THE LICENSE AGREEMENT PROVIDED WITH THE 
 *	DOWNLOADED PRODUCT.
 *
 *      Copyright 2012 Sensible Plugins. All rights reserved.
 *
 *
 *	This notice may not be removed from this file.
 *
 */

require_once (SP_BP_ABSPATH . 'SP_BPCPM_OptionsManager.php');

class SP_BPCPM_OptionsManager_Pro extends SP_BPCPM_OptionsManager
{
    // overrides super class
    public function settingsPage()
    {
        $refresh = FALSE;
        if (isset($_POST[SP_BPCPM_MENU_ORDER_OPTIONKEY])) 
        {
            $data = $_POST[SP_BPCPM_MENU_ORDER_OPTIONKEY];
            
            if(!empty($data))
            {
                $this->updateMenuOrderOption($data);
                $refresh = TRUE;
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
        
        parent::settingsPage();
    }
    
    // overrides super class
    protected function html_menuitem_options($item_slug, $meta_array) 
    {
        $html_options = parent::html_menuitem_options($item_slug, $meta_array);
        
        // Create the ispublic checkbox
        $option_key = $this->ispublicOptionKey($item_slug);
        $aOption = $meta_array[$option_key];
        $aOptionValue = $this->getOption($option_key);
        $html_options .= $this->createFormControl($aOption, $aOptionValue);
        
        return $html_options;
    }
}

?>
