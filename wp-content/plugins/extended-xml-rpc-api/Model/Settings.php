<?php
if(!class_exists('ExtendedApi_Model_Settings'))
{
class ExtendedApi_Model_Settings
{

    public $wpdb;
    public $plguin_url;
    public $plugin_path;
    public $log_path;

    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->plugin_url = trailingslashit(WP_PLUGIN_URL . '/extended-api/');
        $this->plugin_path = ABSPATH . 'wp-content' . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . 'extendedapi' . DIRECTORY_SEPARATOR;
        $this->log_path = $this->plugin_path . 'log' . DIRECTORY_SEPARATOR . 'system.log';
        $this->skin_url = $this->plugin_url . 'skin';

        return $this;
    }

}
}