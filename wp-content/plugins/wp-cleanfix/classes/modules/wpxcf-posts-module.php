<?php
/**
 * Posts and post meta
 *
 * @class              WPXCleanFixPostsModule
 * @author             =undo= <info@wpxtre.me>
 * @copyright          Copyright (C) 2012-2013 wpXtreme Inc. All Rights Reserved.
 * @date               06/06/12
 * @version            1.0.0
 */

class WPXCleanFixPostsModule extends WPXCleanFixModuleView {

  /**
   * Create an instance of WPXCleanFixPostsModule class
   *
   * @brief Construct
   *
   * @return WPXCleanFixPostsModule
   */
  function __construct() {
    parent::__construct( 'wpxcf-posts-module', __( 'Posts', WPXCLEANFIX_TEXTDOMAIN ), $this->rows() );
  }

  /**
   * Return a key value pairs array with the column of this meta box
   *
   * @brief Get the column of meta box
   *
   * @return array
   */
  private function rows() {

    $rows = array(
      array(
        'title'       => __( 'Revisions', WPXCLEANFIX_TEXTDOMAIN ),
        'description' => __( 'Post in revision. WordPress auto-generates revisions when you save a new version. If you don\'t need them, you can delete them in safe and permanently to gain space in the database', WPXCLEANFIX_TEXTDOMAIN ),
        'callback'    => array(
          $this,
          'check_posts_revisions'
        ),
      ),

      array(
        'title'       => __( 'Auto Draft', WPXCLEANFIX_TEXTDOMAIN ),
        'description' => __( 'Post in Auto Draft. WordPress saves an Auto Draft in the database every n seconds. The Auto draft is different from draft, however you can remove it in safe to gain space in the database', WPXCLEANFIX_TEXTDOMAIN ),
        'callback'    => array(
          $this,
          'check_posts_autodraft'
        ),
      ),

      array(
        'title'       => __( 'Trash', WPXCLEANFIX_TEXTDOMAIN ),
        'description' => __( 'Post in trash.', WPXCLEANFIX_TEXTDOMAIN ),
        'callback'    => array(
          $this,
          'check_posts_trash'
        ),
      ),

      array(
        'title'       => __( 'Posts without Users', WPXCLEANFIX_TEXTDOMAIN ),
        'description' => __( 'Posts with invalid user.', WPXCLEANFIX_TEXTDOMAIN ),
        'callback'    => array(
          $this,
          'check_posts_null_user'
        ),
      ),

    );
    return $rows;
  }

  // -----------------------------------------------------------------------------------------------------------------
  // Actions
  // -----------------------------------------------------------------------------------------------------------------

  /**
   * Check post revision
   *
   * @brief Posts revisions
   *
   * @return WPXCleanFixModuleResponse
   */
  public function check_posts_revisions() {
    /* Questo mi fa una count generale */
    $posts = WPXCleanFixPostsModuleSQL::postsWithType( 'revision' );

    if ( empty( $posts ) ) {
      return new WPXCleanFixModuleResponse();
    }

    $number  = count( $posts );
    $message = sprintf( _n( 'You have %s post in revision.', 'You have %s posts in revision.', $number, WPXCLEANFIX_TEXTDOMAIN ), $number );

    /* Revision, come auto draft, hanno tutti lo stesso titolo. */
    $posts = WPXCleanFixPostsModuleSQL::postsWithType( 'revision', true );

    $detail  = $this->select( $posts, 'post_title', array( 'number' ) );
    $actions = $this->actions( WPXCleanFixModuleButtonActionType::CLEAN, array( $this, 'delete_posts_revision' ), __( 'Fix: click here to delete your posts revisions.', WPXCLEANFIX_TEXTDOMAIN ), true );

    return new WPXCleanFixModuleResponse( WPXCleanFixModuleResponseStatus::WARNING, $message, $detail, $actions );

  }

  public function delete_posts_revision() {
    $result = WPXCleanFixPostsModuleSQL::deletePostsWithType( 'revision' );
    return $this->check_posts_revisions();
  }

  /**
   * Check for auto draft posts
   *
   * @brief Auto Draft
   *
   * @return WPXCleanFixModuleResponse
   */
  public function check_posts_autodraft() {
    /* postsStatus() ha come defaul auto-draft */
    $posts = WPXCleanFixPostsModuleSQL::postsWithStatus();

    if ( empty( $posts ) ) {
      return new WPXCleanFixModuleResponse();
    }

    $number  = count( $posts );
    $message = sprintf( _n( 'You have %s post in Auto draft.', 'You have %s posts in Auto draft.', $number, WPXCLEANFIX_TEXTDOMAIN ), $number );
    $posts   = WPXCleanFixPostsModuleSQL::postsWithStatus( 'auto-draft', true );
    $detail  = $this->select( $posts, 'post_title', array( 'number' ) );
    $actions = $this->actions( WPXCleanFixModuleButtonActionType::CLEAN, array( $this, 'delete_posts_autodraft' ), __( 'Fix: click here to delete your posts auto draft.', WPXCLEANFIX_TEXTDOMAIN ) );

    return new WPXCleanFixModuleResponse( WPXCleanFixModuleResponseStatus::WARNING, $message, $detail, $actions );

  }

  public function delete_posts_autodraft() {
    $result = WPXCleanFixPostsModuleSQL::deletePostsWithStatus( 'auto-draft' );
    return $this->check_posts_autodraft();
  }

  /**
   * Check for posts in trash
   *
   * @brief Trash
   *
   * @return WPXCleanFixModuleResponse
   */
  public function check_posts_trash() {
    $posts = WPXCleanFixPostsModuleSQL::postsWithStatus( 'trash' );

    if ( empty( $posts ) ) {
      return new WPXCleanFixModuleResponse();
    }
    $number  = count( $posts );
    $message = sprintf( _n( 'You have %s post in the trash.', 'You have %s posts in the trash.', $number, WPXCLEANFIX_TEXTDOMAIN ), $number );
    $posts   = WPXCleanFixPostsModuleSQL::postsWithStatus( 'trash', true );
    $detail  = $this->select( $posts, 'post_title', array( 'number' ) );
    $actions = $this->actions( WPXCleanFixModuleButtonActionType::CLEAN, array( $this, 'delete_posts_trash' ), __( 'Fix: click here to delete your posts from trash.', WPXCLEANFIX_TEXTDOMAIN ) );

    return new WPXCleanFixModuleResponse( WPXCleanFixModuleResponseStatus::WARNING, $message, $detail, $actions );
  }

  public function delete_posts_trash() {
    $result = WPXCleanFixPostsModuleSQL::deletePostsWithStatus( 'trash' );
    return $this->check_posts_trash();
  }

  /**
   * Check for posts without a valid user id linked
   *
   * @bried Users's post
   *
   * @return WPXCleanFixModuleResponse
   */
  public function check_posts_null_user() {
    $posts = WPXCleanFixPostsModuleSQL::postsWithoutUsers();

    if ( empty( $posts ) ) {
      return new WPXCleanFixModuleResponse();
    }

    $number  = count( $posts );
    $message = sprintf( _n( 'You have %s post without a valid user author liked.', 'You have %s posts without a valid user author liked.', $number, WPXCLEANFIX_TEXTDOMAIN ), $number );
    $detail  = $this->select( $posts, 'post_title' );
    $confirm = sprintf( __( 'WARNIG!! Be carefull: this action will set the \'%s\' to your selected user. Are you sure?', WPXCLEANFIX_TEXTDOMAIN ), __( 'Posts without Users', WPXCLEANFIX_TEXTDOMAIN ) );
    $actions = $this->actions( WPXCleanFixModuleButtonActionType::FIX, array( $this, 'repair_posts_null_users' ), __( 'Fix: click here fto repair post without user.', WPXCLEANFIX_TEXTDOMAIN ), $confirm, 'WPXCleanFix.users_posts();' );

    $detail .= $this->_actionsUserToPost();

    return new WPXCleanFixModuleResponse( WPXCleanFixModuleResponseStatus::WARNING, $message, $detail, $actions );
  }

  /**
   * Return the HTML markup for combo select users
   *
   * @brief Users select
   *
   * @return string
   */
  private function _actionsUserToPost() {

    $users      = array( '' => __( 'Choose a new user', WPXCLEANFIX_TEXTDOMAIN ) );
    $users_list = get_users();
    if ( $users_list ) {
      foreach ( $users_list as $user ) {
        $users[$user->ID] = sprintf( '%s (%s)', $user->display_name, $user->user_email );
      }
    }

    $item = array(
      'type'    => WPDKUIControlType::SELECT,
      'name'    => 'users_posts',
      'options' => $users
    );

    $control = new WPDKUIControlSelect( $item );
    return $control->html();
  }

  /**
   *
   * @brief Set a new user post
   *
   * @return WPXCleanFixModuleResponse
   */
  public function repair_posts_null_users( $args ) {
    if ( is_array( $args ) && !empty( $args ) ) {
      $user_id = $args[key( $args )];
      if ( !empty( $user_id ) && is_numeric( $user_id ) ) {
        $result = WPXCleanFixPostsModuleSQL::updatePostsWithoutUsers( $user_id );
      }
    }

    return $this->check_posts_null_user();
  }

}

/**
 * Encapsulates all SQL method for Module Posts
 *
 * @class              WPXCleanFixPostsModuleSQL
 * @author             =undo= <info@wpxtre.me>
 * @copyright          Copyright (C) 2012-2013 wpXtreme Inc. All Rights Reserved.
 * @date               11/21/12
 * @version            1.0.0
 */
class WPXCleanFixPostsModuleSQL {

  /**
   * Select all post ( post_title ) with a specific type.
   *
   * @brief Select posts with type
   *
   * @param string $type        attachment, post, page, revision, nav_menu_item, or custom post type.
   *                            Default `attachment`
   * @param bool   $do_distinct TRUE for distinct rows
   *
   * @return mixed
   */
  public static function postsWithType( $type = 'attachment', $do_distinct = false ) {
    global $wpdb;

    $distinct = '';
    $group_by = '';
    if ( $do_distinct ) {
      $distinct = 'DISTINCT( COUNT(*) ) AS number,';
      $group_by = 'GROUP BY post_title ORDER BY post_title';
    }

    $sql = <<< SQL
SELECT {$distinct} post_title
FROM `$wpdb->posts`
WHERE post_type = '{$type}'
{$group_by}
SQL;
    return $wpdb->get_results( $sql );
  }

  /**
   * Delete (permanently) all posts with a specific `post_type`
   *
   * @brief Delete posts with type
   *
   * @param string $type The `post_type` field: attachment, post, page, revision, nav_menu_item, or custom post type
   *
   * @return mixed
   */
  public static function deletePostsWithType( $type ) {
    global $wpdb;

    $sql = <<< SQL
DELETE FROM `$wpdb->posts`
WHERE post_type = '{$type}'
SQL;
    return $wpdb->query( $sql );
  }

  /**
   * Return the posts ( post_title ) with a specific `post_status`.
   *
   * @brief Select posts with status
   *
   * @param string $status      auto-draft, draft, inherit, publish, trash. Default `auto-draft`
   * @param bool   $do_distinct TRUE for distinct rows
   *
   * @return mixed
   */
  public static function postsWithStatus( $status = 'auto-draft', $do_distinct = false ) {
    global $wpdb;

    $distinct = '';
    $group_by = '';
    if ( $do_distinct ) {
      $distinct = 'DISTINCT( COUNT(*) ) AS number,';
      $group_by = 'GROUP BY post_title ORDER BY post_title';
    }

    $sql = <<< SQL
SELECT {$distinct} post_title
FROM `$wpdb->posts`
WHERE post_status = '{$status}'
{$group_by}
SQL;
    return $wpdb->get_results( $sql );
  }

  /**
   * Delete (permanently) all posts with a specific `post_status`
   *
   * @brief Delete posts with status
   *
   * @param string $status The `post_status` field: auto-draft, draft, inherit, publish, trash.
   *
   * @return mixed
   */
  public static function deletePostsWithStatus( $status ) {
    global $wpdb;

    $sql = <<< SQL
DELETE FROM `$wpdb->posts`
WHERE post_status = '{$status}'
SQL;
    return $wpdb->query( $sql );
  }


  /**
   * Return the posts (id) without a valid user linked
   *
   * @brief Posts without users
   *
   * @return mixed
   */
  public static function postsWithoutUsers() {
    global $wpdb;

    $sql = <<< SQL
SELECT *, posts.ID AS post_id
FROM `$wpdb->posts` posts
LEFT JOIN `$wpdb->users` users ON users.ID = posts.post_author
WHERE posts.post_status = 'publish'
AND users.ID IS NULL
SQL;
    return $wpdb->get_results( $sql );
  }

  /**
   * Update the post table and set the post_author
   *
   * @brief Update the post table
   *
   * @param int $user_id User id
   *
   * @return mixed
   */
  public static function updatePostsWithoutUsers( $user_id ) {
    global $wpdb;

    $posts = self::postsWithoutUsers();

    $stack = array();
    foreach ( $posts as $post ) {
      $stack[] = $post->post_id;
    }
    $ids = implode( ',', $stack );

    $sql = <<< SQL
UPDATE `$wpdb->posts`
SET post_author = {$user_id}
WHERE ID IN( {$ids} )
SQL;
    return $wpdb->query( $sql );
  }

}