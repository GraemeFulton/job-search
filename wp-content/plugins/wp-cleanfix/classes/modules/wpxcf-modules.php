<?php
/**
 * Modello dei module. Usare questa classe per aggiungere i moduli dei meta box.
 *
 * @class              WPXCleanFixModules
 * @author             =undo= <info@wpxtre.me>
 * @copyright          Copyright (C) 2012-2013 wpXtreme Inc. All Rights Reserved.
 * @date               05/06/12
 * @version            1.0.0
 */
class WPXCleanFixModules {

  /**
   * CleanFix modules array list
   *
   * @brief All CleanFix modules
   *
   * @var array $modules
   */
  public $modules;

  /**
   * Return a singleton instance of WPXCleanFixModules class.
   * This method includes all file module and count the warning.
   *
   * @brief Init
   *
   * @return WPXCleanFixModules
   */
  public static function init() {
    static $instance = null;
    if ( is_null( $instance ) ) {
      $instance = new WPXCleanFixModules();
    }
    return $instance;
  }

  /**
   * Return an singleton instance of WPXCleanFixModules class. This static method is an alias of init().
   *
   * @brief Get instance
   *
   * @return WPXCleanFixModules
   */
  public static function getInstance() {
    return self::init();
  }

  /**
   * Create an instance of WPXCleanFixModules class
   *
   * @brief Construct
   */
  private function __construct() {
    $this->modules = $this->modules();
    $this->includes();
  }

  /**
   * Includes all registered modules.
   *
   * @brief Include modules
   *
   * @note Call from main
   *
   */
  private function includes() {
    foreach ( $this->modules as $meta ) {
      include_once( $meta['filename'] );
    }
  }

  /**
   * List of all modules (meta box).
   *
   * @todo Add icon array key
   *
   * @return array
   */
  private function modules() {
    $modules = array(
      'wpxcf-database-module'      => array(
        'filename'   => 'wpxcf-database-module.php',
        'title'      => __( 'Database', WPXCLEANFIX_TEXTDOMAIN ),
        'class_name' => 'WPXCleanFixDatabaseModule',
      ),

      'wpxcf-posts-module'         => array(
        'filename'   => 'wpxcf-posts-module.php',
        'title'      => __( 'Posts, Page and Custom Post Type', WPXCLEANFIX_TEXTDOMAIN ),
        'class_name' => 'WPXCleanFixPostsModule',
      ),

      'wpxcf-media-module'         => array(
        'filename'   => 'wpxcf-media-module.php',
        'title'      => __( 'Media', WPXCLEANFIX_TEXTDOMAIN ),
        'class_name' => 'WPXCleanFixMediaModule',
      ),

      'wpxcf-meta-module'          => array(
        'filename'   => 'wpxcf-meta-module.php',
        'title'      => __( 'Meta data and cache', WPXCLEANFIX_TEXTDOMAIN ),
        'class_name' => 'WPXCleanFixMetaModule',
      ),

      'wpxcf-term-taxonomy-module' => array(
        'filename'   => 'wpxcf-term-taxonomy-module.php',
        'title'      => __( 'Terms and taxonomies', WPXCLEANFIX_TEXTDOMAIN ),
        'class_name' => 'WPXCleanFixTermTaxnonomyModule',
      ),
    );

    return $modules;
  }

  /**
   * Return the warning count for this module. Used for badge.
   *
   * @brief Count warning
   *
   * @return int
   *
   */
  public function countWarning() {
    $count = 0;

    foreach ( $this->modules as $module ) {
      $class_name = $module['class_name'];
      if ( !class_exists( $class_name ) ) {
        include_once( $module['filename'] );
      }
      $instance = new $class_name;
      $count += call_user_func( array( $instance, 'countWarning' ) );
    }
    return $count;
  }

  /**
   * Do add_meta_box() for each module.
   *
   * @brief Register WordPress meta box
   */
  public function registerMetaBox() {
    $screen = get_current_screen();

    foreach ( $this->modules as $key => $module ) {
      $class_name = $module['class_name'];
      if ( !class_exists( $class_name ) ) {
        include_once( $module['filename'] );
      }
      $instance = new $class_name;
      $callback = array(
        $instance,
        'display'
      );
      add_meta_box( $key, $module['title'], $callback, $screen->id, 'normal', 'core' );
    }
  }
}
