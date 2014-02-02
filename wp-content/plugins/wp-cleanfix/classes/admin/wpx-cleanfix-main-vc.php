<?php
/**
 * Main view controller
 *
 * @class              WPXCleanFixMainViewController
 * @author             =undo= <info@wpxtre.me>
 * @copyright          Copyright (C) 2012-2013 wpXtreme Inc. All Rights Reserved.
 * @date               05/06/12
 * @version            1.0.0
 */

class WPXCleanFixMainViewController extends WPDKViewController {

  /**
   * Create an instance of WPXCleanFixMainViewController class
   *
   * @brief Construct
   *
   * @return WPXCleanFixMainViewController
   */
  public function __construct() {
    parent::__construct( 'wpxcf-main', __( 'Clean & Fix', WPXCLEANFIX_TEXTDOMAIN ) );
    $view = new WPXCleanFixMainView();
    $this->view->addSubview( $view );
  }

  /**
   * This static method is called when the head of this view controller is loaded by WordPress.
   *
   * @brief Head
   */
  public static function didHeadLoad() {
    /* Scripts */
    wp_enqueue_script( 'wpx-cleanfix-admin',
      WPXCLEANFIX_URL_JAVASCRIPT . 'wpx-cleanfix-admin.js', array(), WPXCLEANFIX_VERSION, true );

    $localization = array(
      'ajax_nonce'       => wp_create_nonce(),

      /* Localization. */
      'pleaseSelectUser' => __( 'Please, select an user before continue.', WPXCLEANFIX_TEXTDOMAIN )
    );

    wp_localize_script( 'wpx-cleanfix-admin', 'wpxcf_i18n', $localization );
  }

  /**
   * This static method is called when the head of this view controller is loaded by WordPress.
   *
   * @brief Head
   */
  public static function willLoad() {
    wp_enqueue_script( 'common' );
    wp_enqueue_script( 'wp-lists' );
    wp_enqueue_script( 'postbox' );

    /* Register meta box. */
    WPXCleanFixModules::init()->registerMetaBox();
  }

}

/**
 * The custom view
 *
 * @class         WPXCleanFixMainView
 * @author        =undo= <info@wpxtre.me>
 * @copyright     Copyright (C) 2012-2013 wpXtreme Inc. All Rights Reserved.
 * @date          2013-02-06
 * @version       1.0.0
 */
class WPXCleanFixMainView extends WPDKView {

  /**
   * Create an instance of WPXCleanFixMainView class
   *
   * @brief Construct
   *
   * @return WPXCleanFixMainView
   */
  public function __construct() {
    parent::__construct( 'wpxcf-main' );
  }

  /**
   * Drawing view
   *
   * @brief Draw
   */
  public function draw() {
    global $screen_layout_columns;

    $screen = get_current_screen();

    ?>

  <?php wp_nonce_field( 'wpx_cleanfix' ); ?>
  <?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ) ?>
  <?php wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ) ?>
  <input type="hidden" name="action" value="save_wpx_cleanfix"/>

  <div id="poststuff"
       class="metabox-holder<?php echo ( $screen_layout_columns == 2 ) ? ' has-right-sidebar' : ''; ?>">
    <div id="side-info-column" class="inner-sidebar">
      <?php echo 'static' ?>
    </div>
    <div id="post-body" class="has-sidebar">
      <div id="post-body-content" class="has-sidebar-content">
        <?php do_meta_boxes( $screen->id, 'normal', '' ) ?>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    //<![CDATA[
    jQuery( document ).ready( function () {
      // close postboxes that should be closed
      jQuery( '.if-js-closed' ).removeClass( 'if-js-closed' ).addClass( 'closed' );
      // postboxes setup
      postboxes.add_postbox_toggles( '<?php echo $screen->id ?>' );
    } );
    //]]>
  </script>

  <?php
  }
}
