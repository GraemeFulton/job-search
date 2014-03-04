<?php
/**
 * Main CleanFix class
 *
 * @class              WPXCleanFix
 * @author             =undo= <info@wpxtre.me>
 * @copyright          Copyright (C) 2012-2013 wpXtreme Inc. All Rights Reserved.
 * @date               2013-02-06
 * @version            1.0.5
 */
final class WPXCleanFix extends WPDKWordPressPlugin {

  /**
   * Create and return a singleton instance of WPXCleanFix class
   *
   * @brief Init
   *
   * @param string $file The main file of this plugin. Usually __FILE__ (main.php)
   *
   * @return WPXCleanFix
   */
  public static function boot( $file ) {
    static $instance = null;
    if ( is_null( $instance ) ) {
      $instance = new WPXCleanFix( $file );
      do_action( __CLASS__ );
    }
    return $instance;
  }

  /**
   * Create an instance of WPXCleanFix class
   *
   * @brief Construct
   *
   * @param string $file The main file of this plugin. Usually __FILE__ (main.php)
   *
   * @return WPXCleanFix
   */
  public function __construct( $file ) {
    parent::__construct( $file );

    $this->defines();
    $this->registerClasses();

    WPXCleanFixModules::init();

  }

  /**
   * Dynamic defines
   *
   * @brief Set defines
   */
  private function defines() {
    require_once( 'defines.php' );
  }

  /**
   * Register all autoload classes
   *
   * @brief Autoload classes
   */
  private function registerClasses() {

    $includes = array(
      $this->classesPath . 'admin/wpx-cleanfix-main-vc.php'           => array(
        'WPXCleanFixMainViewController',
        'WPXCleanFixMainView'
      ),
      $this->classesPath . 'admin/wpx-cleanfix-admin.php'    => 'WPXCleanFixAdmin',
      $this->classesPath . 'admin/wpx-cleanfix-about-vc.php' => 'WPXCleanFixAboutViewController',
      $this->classesPath . 'core/wpxcf-ajax.php'             => 'WPXCleanFixAjax',
      $this->classesPath . 'modules/wpxcf-modules.php'       => 'WPXCleanFixModules',

      $this->classesPath . 'modules/wpxcf-module-view.php'     => array(
        'WPXCleanFixModuleView',
        'WPXCleanFixModuleButtonActionType'
      ),

      $this->classesPath . 'modules/wpxcf-module-response.php' => array(
        'WPXCleanFixModuleResponseStatus',
        'WPXCleanFixModuleResponse'
      ),
    );

    /* Admin backend area. */
    $this->registerAutoloadClass( $includes );

  }

  // -----------------------------------------------------------------------------------------------------------------
  // Methods to overwrite
  // -----------------------------------------------------------------------------------------------------------------

  /**
   * Called when Ajax
   *
   * @brief Ajax
   */
  public function ajax() {
    WPXCleanFixAjax::init();
  }

  /**
   * Called when admin
   *
   * @brief Admin
   */
  public function admin() {
    $admin = new WPXCleanFixAdmin( $this );
  }

  /**
   * Called when we are in frontend
   *
   * @brief Theme frontend
   */
  public function theme() {
    /* To overwrite. */
  }

  /**
   * Called when the plugin is activate
   *
   * @brief Activation
   */
  public function activation() {
    /* To overwrite. */
  }

  /**
   * Called when the plugin is deactivated
   *
   * @brief Deactivation
   */
  public function deactivation() {
    /* To overwrite. */
  }

  /**
   * Init your own configuration settings
   *
   * @brief Configuration
   */
  public function configuration() {
    /* To overwrite */
  }

  /**
   * Do log in easy way
   *
   * @brief Helper for log
   *
   * @param mixed  $txt
   * @param string $title Optional. Any free string text to context the log
   *
   */
  public static function log( $txt, $title = '' ) {
    /**
     * @var WPXCleanFix $me
     */
    $me = $GLOBALS[__CLASS__];
    $me->log->log( $txt, $title );
  }

}
?>
