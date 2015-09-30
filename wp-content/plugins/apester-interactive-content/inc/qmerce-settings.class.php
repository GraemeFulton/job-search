<?php

class Qmerce_Settings
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'addPluginPage' ) );
        add_action( 'admin_init', array( $this, 'pageInit' ) );
    }

    /**
     * Add options page
     */
    public function addPluginPage()
    {
        // This page will be under "Settings"
        add_options_page(
            'Apester Settings',
            'Apester Settings',
            'manage_options',
            'qmerce-settings-admin',
            array( $this, 'createAdminPage' )
        );
    }

    /**
     * Options page callback
     */
    public function createAdminPage()
    {
        // Set class property
        $this->options = get_option( 'qmerce-settings-admin' );

        include( QMERCE_PLUGIN_DIR . 'views/settings.tpl.php' );
    }

    /**
     * Register and add settings
     */
    public function pageInit()
    {
        register_setting(
            'qmerce-settings-fields', // Option group
            'qmerce-settings-admin', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'Authorization Settings', // Title
            array( $this, 'printSectionInfo' ), // Callback
            'qmerce-settings-admin' // Page
        );

        add_settings_field(
            'auth_token',
            'Apester authorization token',
            array( $this, 'authTokenCallback' ),
            'qmerce-settings-admin',
            'setting_section_id'
        );

        add_settings_field(
            'helper_info',
            'Where do I find my token?',
            array( $this, 'printHelperInfo' ),
            'qmerce-settings-admin',
            'setting_section_id'
        );

        add_settings_field(
            'post_types',
            'Post types for admin box',
            array( $this, 'postTypesCb' ),
            'qmerce-settings-admin',
            'setting_section_id'
        );

        add_settings_field(
            'automation_post_types',
            'Post Types with automated Apester interactive widget below the main content',
            array( $this, 'automationPostTypeCb' ),
            'qmerce-settings-admin',
            'setting_section_id'
        );
    }

    /**
     * Retrieves available post types
     * @return array
     */
    private function getPostTypes()
    {
        return get_post_types( array( 'show_in_menu' => true ), 'objects' );
    }

    /**
     * Callback for the postTypes settings field
     */
    public function postTypesCb()
    {
        $postTypes = $this->getPostTypes();

        foreach($postTypes as $postType) {
            $checked = '';

            if ( in_array( $postType->name, $this->options['post_types'] ) ) {
                $checked = 'checked';
            }

            printf(
                '<input type="checkbox" name="qmerce-settings-admin[post_types][]" value="%s" ' . $checked . '/> ' . $postType->label . ' ',
                $postType->name
            );
        }
    }

    public function automationPostTypeCb()
    {
        $postTypes = $this->getPostTypes();

        foreach($postTypes as $postType) {
            $checked = '';

            if ( in_array( $postType->name, $this->getAutomationPostTypes() ) ) {
                $checked = 'checked';
            }

            printf(
                '<input type="checkbox" name="qmerce-settings-admin[automation_post_types][]" value="%s" ' . $checked . '/> ' . $postType->label . ' ',
                $postType->name
            );
        }
    }

    private function getAutomationPostTypes()
    {
        if ($this->options['automation_post_types']) {
            return $this->options['automation_post_types'];
        }

        return array();
    }

    /**
     * Validates Apester authToken
     * @param string $value
     * @return bool
     */
    private function validateToken($value)
    {
        return (bool) preg_match( '/^[0-9a-fA-F]{24}$/', $value );
    }

    /**
     * Preserve old values
     * @return array
     */
    protected function preserveValue()
    {
        add_settings_error( 'qmerce-settings-admin', 500, 'Given authorization token is not valid' );
        $qmerceSettings = get_option( 'qmerce-settings-admin' );

        return array( 'auth_token' => $qmerceSettings['auth_token'] );
    }

    /**
     * Retrieves the names of all available post types in array
     * @return array
     */
    private function getPostTypesNames()
    {
        $postTypes = $this->getPostTypes();
        $postNames = array();

        foreach ( $postTypes as $postType ) {
            array_push( $postNames, $postType->name );
        }

        return $postNames;
    }

    /**
     * Determines if submitted post types are valid
     * @param array $postTypes
     * @return bool
     */
    private function isPostTypesValid($postTypes)
    {
        $availablePostTypes = $this->getPostTypesNames();

        foreach ( $postTypes as $postType ) {
            if ( !in_array( $postType, $availablePostTypes ) ) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param array $postTypes
     * @return array
     */
    private function sanitizePostTypes($postTypes)
    {
        if ( is_array( $postTypes ) && $this->isPostTypesValid( $postTypes ) ) {
            return $postTypes;
        }

        return array();
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     * @return array|string
     */
    public function sanitize($input)
    {
        $newInput = array( 'post_types' => $this->sanitizePostTypes( $input['post_types'] ) );
        $newInput['automation_post_types'] = $this->sanitizePostTypes( $input['automation_post_types'] );

        if( isset( $input['auth_token'] ) ) {
            if ( !$this->validateToken( $input['auth_token'] ) ) {
                return $this->preserveValue();
            }

            // Delete the unused user-id value.
            delete_option( 'qmerce-user-id' );

            $newInput['auth_token'] = sanitize_text_field( $input['auth_token'] );
        }

        return $newInput;
    }

    /**
     * Print the Section text
     */
    public function printSectionInfo()
    {
        print 'Enter your settings below:';
    }

    /**
     * Print the helper text.
     */
    public function printHelperInfo()
    {
        printf(
            'Get a token at <a href="' . APESTER_EDITOR_BASEURL . '/register" target=_blank>Apester.com</a> (you can find it in your user <a href="' . APESTER_EDITOR_BASEURL . '/user/settings" target=_blank>settings</a>.)'
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function authTokenCallback()
    {
        printf(
            '<input type="text" id="auth_token" name="qmerce-settings-admin[auth_token]" value="%s" size="24" />',
            isset($this->options['auth_token'] ) ? esc_attr( $this->options['auth_token'] ) : ''
        );
    }
}

$qmerce_settings_page = new Qmerce_Settings();
