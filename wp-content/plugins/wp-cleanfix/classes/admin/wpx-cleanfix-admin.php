<?php
/**
 * Class for Manage Admin (back-end)
 *
 * @class              WPXCleanFixAdmin
 * @author             =undo= <info@wpxtre.me>
 * @copyright          Copyright (C) 2012-2013 wpXtreme Inc. All Rights Reserved.
 * @date               2013-02-28
 * @version            1.0.4
 */
class WPXCleanFixAdmin extends WPDKWordPressAdmin {

  /**
   * Array of menu from WPDKMenu::renderByArray();
   *
   * @brief Menu array
   *
   * @var array $menus
   */
  public $menus;

  // -----------------------------------------------------------------------------------------------------------------
  // Constants values
  // -----------------------------------------------------------------------------------------------------------------

  /**
   * The minumun capability to manage the CleanFix menu
   *
   * @brief Minimum capability
   */
  const MENU_CAPABILITY = 'manage_options';

  /**
   * Menu position in admin backend
   *
   * @brief Menu position
   */
  const MENU_POSITION = null;

  /**
   * Create an instance of WPXCleanFix class
   *
   * @brief Construct
   *
   * @param WPXCleanFix $plugin
   */
  public function __construct( WPXCleanFix $plugin ) {
    parent::__construct( $plugin );

    /* Plugin List */
    add_action( 'plugin_action_links_' . $this->plugin->pluginBasename, array( $this, 'plugin_action_links' ), 10, 4 );

    /* Loading Script & style for backend */
    add_action( 'admin_head', array( $this, 'admin_head' ) );

    /* Meta box management. */
    add_action( 'admin_post_save_wpx_cleanfix', array( $this, 'admin_post_save_wpx_cleanfix' ) );
    // This line below is not used because ClenFix has 1 column mode ever
    //add_filter( 'screen_layout_columns', array( $this, 'on_screen_layout_columns' ), 10, 2 );

    /* Control panel badge */
    add_filter( 'wpxm_widget_badge_'. sanitize_key( $plugin->folderName ), array( $this, 'wpxm_widget_badge' ) );

  }

  /**
   * Meta box
   */
  public function admin_post_save_wpx_cleanfix() {
    // user permission check
    if ( !current_user_can( 'manage_options' ) ) {
      wp_die( __( 'Cheatin&#8217; uh?' ) );
    }
    // cross check the given referer
    check_admin_referer( 'wp-cleanfix-general' );

    // process here your on $_POST validation and / or option saving

    // lets redirect the post request into get request (you may add additional params at the url, if you need to show save results
    wp_redirect( $_POST['_wp_http_referer'] );
  }

  /**
   * Meta box screen layout
   */
  public function on_screen_layout_columns( $columns, $screen ) {
    if ( isset( $this->menus['wpxcf_menu_main'] ) ) {
      /**
       * @var WPDKMenu $menu
       */
      $menu = $this->menus['wpxcf_menu_main'];
      if ( $screen == $menu->hookName ) {
        $columns[$menu->hookName] = 1;
      }
    }
    return $columns;
  }

  // -----------------------------------------------------------------------------------------------------------------
  // Plugin page Table List integration
  // -----------------------------------------------------------------------------------------------------------------

  /**
   * Aggiunge un link nella riga che identifica questo Plugin nella schermata con l'elenco dei Plugin nel backend di
   * WordPrsss.
   *
   * @param array $links
   *
   * @return array
   */
  public function plugin_action_links( $links ) {
    $url    = WPDKMenu::url( 'WPXCleanFixMainViewController' );
    $result = '<a href="' . $url . '">' . __( 'Clean & Fix', WPXCLEANFIX_TEXTDOMAIN ) . '</a>';
    array_unshift( $links, $result );
    return $links;
  }

  /**
   * Admin head
   */
  public function admin_head() {
    /* Added classes to body. */
    $this->bodyClasses['wpx-cleanfix'] = true;

    /* Styles */
    wp_enqueue_style( 'wpx-cleanfix-plugins-list', WPXCLEANFIX_URL_CSS . 'wpx-cleanfix-plugins-list.css', array(), WPXCLEANFIX_VERSION );
    wp_enqueue_style( 'wpx-cleanfix-admin', WPXCLEANFIX_URL_CSS . 'wpx-cleanfix-admin.css', array(), WPXCLEANFIX_VERSION );

  }

  // -----------------------------------------------------------------------------------------------------------------
  // Methods to overwrite
  // -----------------------------------------------------------------------------------------------------------------

  /**
   * @brief Set admin backend menu
   */
  public function admin_menu() {
    /* Icona */
    $icon_menu = $this->plugin->imagesURL . 'logo-16x16.png';

    /* Numero di elementi da sistemare. */
    $count = WPXCleanFixModules::init()->countWarning();

    /* Creo un badge da mettere nel menu store in caso ci siano dei plugin da aggiornare. */
    $badge = WPDKUI::badge( $count, 'wpxcf-badge' );

    $menus = array(
      'wpxcf_menu_main' => array(
        'menuTitle'  => __( 'CleanFix', WPXCLEANFIX_TEXTDOMAIN ) . $badge,
        'pageTitle'  => __( 'CleanFix', WPXCLEANFIX_TEXTDOMAIN ),
        'capability' => self::MENU_CAPABILITY,
        'icon'       => $icon_menu,
        'subMenus'   => array(

          array(
            'menuTitle'      => __( 'Clean & Fix', WPXCLEANFIX_TEXTDOMAIN ) . $badge,
            'pageTitle'      => __( 'Clean & Fix', WPXCLEANFIX_TEXTDOMAIN ),
            'capability'     => self::MENU_CAPABILITY,
            'viewController' => 'WPXCleanFixMainViewController'
          ),

          WPDKSubMenuDivider::DIVIDER,

          array(
            'menuTitle'      => __( 'About', WPXCLEANFIX_TEXTDOMAIN ),
            'viewController' => 'WPXCleanFixAboutViewController',
          ),
        )
      )
    );

    $this->menus = WPDKMenu::renderByArray( $menus );

    /* Choose my plugin widget link. */
    add_filter( 'wpxm_control_panel_widget_url-' . $this->plugin->name, array( $this, 'wpxm_control_panel_url' ) );

  }

  /**
   * Display the badge in Control Panel
   *
   * @brief Badge
   *
   * @param string $badge Defaul is empty
   *
   * @return string
   */
  public function wpxm_widget_badge( $badge ) {
    $count = WPXCleanFixModules::init()->countWarning();
    $badge = WPDKUI::badge( $count, 'wpxcf-badge' );
    return $badge;
  }

  /**
   * This hook is called when the control panel draw the link of a plugin widget
   *
   * @brief Control panel URL
   *
   * @return string|void
   */
  public function wpxm_control_panel_url() {
    return WPDKMenu::url( 'WPXCleanFixMainViewController' );
  }
}