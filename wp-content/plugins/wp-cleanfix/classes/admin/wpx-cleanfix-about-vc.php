<?php
/**
 * Standard about view controller
 *
 * @class              WPXCleanFixAboutViewController
 * @author             =undo= <info@wpxtre.me>
 * @copyright          Copyright (C) 2012-2013 wpXtreme Inc. All Rights Reserved.
 * @date               2013-02-21
 * @version            1.1.1
 *
 */

class WPXCleanFixAboutViewController extends WPDKViewController {

  /**
   * Create an instance of WPXCleanFixAboutViewController class
   *
   * @brief Construct
   *
   * @return WPXCleanFixAboutViewController
   */
  public function __construct() {
    parent::__construct( 'wpx-cleanfix', __( 'About', WPXCLEANFIX_TEXTDOMAIN ) );

    $view = new WPXCleanFixAboutView();
    $this->view->addSubview( $view );
  }
}

/**
 * Description
 *
 * ## Overview
 *
 * Description
 *
 * @class           WPXCleanFixAboutView
 * @author          =undo= <info@wpxtre.me>
 * @copyright       Copyright (C) 2012-2013 wpXtreme Inc. All Rights Reserved.
 * @date            18/05/13
 * @version         1.0.0
 *
 */
class WPXCleanFixAboutView extends WPDKView {

  /**
   * Create an instance of WPXCleanFixAboutView class
   *
   * @brief Construct
   *
   * @return WPXCleanFixAboutView
   */
  public function __construct()
  {
    parent::__construct( 'wpx-cleanfix' );
  }

  /**
   * Display
   *
   * @brief Display
   */
  public function draw()
  {
    ?><?php _e('Please, visit wpxtre.me', WPXCLEANFIX_TEXTDOMAIN ) ?><?php
  }

}