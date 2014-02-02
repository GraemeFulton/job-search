<?php

if ( wpdk_is_ajax() ) {

  /**
   * Ajax gateway. Register all ajax mathods.
   * This class contains all Ajax method callled by back end front end.
   *
   * @class              WPXCleanFixAjax
   * @author             =undo= <info@wpxtre.me>
   * @copyright          Copyright (C) 2012-2013 wpXtreme Inc. All Rights Reserved.
   * @date               2013-01-23
   * @version            1.0.2
   */
  class WPXCleanFixAjax extends WPDKAjax {

    /**
     * Create or return a singleton instance of WPXCleanFixAjax
     *
     * @brief Create or return a singleton instance of WPXCleanFixAjax
     *
     * @return WPXCleanFixAjax
     */
    public static function getInstance() {
      static $instance = null;
      if ( is_null( $instance ) ) {
        $instance = new WPXCleanFixAjax();
      }
      return $instance;
    }

    /**
     * Alias of getInstance();
     *
     * @brief Init the ajax register
     *
     * @return WPXCleanFixAjax
     */
    public static function init() {
      return self::getInstance();
    }

    // -------------------------------------------------------------------------------------------------------------
    // Statics: method array to register
    // -------------------------------------------------------------------------------------------------------------

    /**
     * Return the array with the list of ajax allowed methods
     *
     * @breief Allow ajax action
     *
     * @return array
     */
    protected function actions() {

      $actionsMethods = array(
        'wpxcf_action'              => true,
        'wpxcf_action_update_badge' => true
      );
      return $actionsMethods;
    }

    /**
     * Return TRUE if the class_name in input param is a registered modules, else die!
     * This check is for security reason.
     *
     * @param string $class_name The class name of a registered module
     *
     * @return bool
     */
    private function allowedModules( $class_name ) {
      $modules = WPXCleanFixModules::getInstance()->modules;
      foreach ( $modules as $module ) {
        if ( $module['class_name'] == $class_name ) {
          return true;
        }
      }
      die( -1 );
    }

    // -------------------------------------------------------------------------------------------------------------
    // Private internal
    // -------------------------------------------------------------------------------------------------------------

    /**
     * Return a standanrd response
     *
     * @brief Prepare response for common mathods
     *
     * @param WPXCleanFixModuleResponse $result
     *
     * @return array
     */
    private function prepareResponse( $result ) {
      if ( is_wp_error( $result ) ) {
        $error  = sprintf( __( 'An error occourred! Code: %s Description: %s', WPXCLEANFIX_TEXTDOMAIN ), $result->get_error_code(), $result->get_error_message() );
        $result = array(
          'message' => $error,
          'status'  => '',
          'content' => '',
          'actions' => '',
        );
      }
      else {
        $result = array(
          'status'  => $result->statusDescription,
          'content' => $result->detail,
          'actions' => $result->actions
        );
      }
      return $result;
    }

    // -------------------------------------------------------------------------------------------------------------
    // Actions methods
    // -------------------------------------------------------------------------------------------------------------

    /**
     * Get from Post the class name and method for a module. This action is potential dangerous but the class and
     * the methods must exsists and the main class must be a subclass of WPXCleanFixModuleView.
     *
     * @brief Process a comand action
     *
     * @return string JSON output
     */
    public function wpxcf_action() {

      /* Security check */
      check_ajax_referer();

      $class_name  = esc_attr( $_POST['class_name'] );
      $action_name = esc_attr( $_POST['action_name'] );
      $parameters  = $_POST['parameters'];

      /* Check allowed modules. If the modules doesn't exists die(). */
      $pass = $this->allowedModules( $class_name );

      /* Added more check from subclass WPXCleanFixModuleView */
      if ( true === $pass && class_exists( $class_name ) && is_subclass_of( $class_name, 'WPXCleanFixModuleView' ) &&
        method_exists( $class_name, $action_name )
      ) {
        $instance = new $class_name;
        $result   = $this->prepareResponse( call_user_func( array(
                                                                 $instance,
                                                                 $action_name
                                                            ), $parameters ) );
      }
      else {
        $result = array(
          'message' => __( 'SEVERE internal error!', WPXCLEANFIX_TEXTDOMAIN ),
          'status'  => '',
          'content' => '',
          'actions' => ''
        );
      }

      echo json_encode( $result );
      die();
    }

    /**
     * Used to update the badge count
     *
     * @brief Update badge
     *
     * @return string jSON output
     */
    public function wpxcf_action_update_badge() {
      $count = WPXCleanFixModules::init()->countWarning();
      if ( empty( $count ) ) {
        $result = array(
          'count' => $count
        );
      }
      else {
        $result = array(
          'count' => $count,
          'badge' => WPDKUI::badge( $count, 'wpxcf-badge' )
        );
      }
      echo json_encode( $result );
      die();
    }

  }
}
