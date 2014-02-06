<?php
/**
 * Post meta, user meta and options cache and transient table
 *
 * @class              WPXCleanFixMetaModule
 * @author             =undo= <info@wpxtre.me>
 * @copyright          Copyright (C) 2012-2013 wpXtreme Inc. All Rights Reserved.
 * @date               06/06/12
 * @version            1.0.0
 *
 */

class WPXCleanFixMetaModule extends WPXCleanFixModuleView {

  /**
   * Create an instance of WPXCleanFixMetaModule class
   *
   * @brief Construct
   *
   * @return WPXCleanFixMetaModule
   */
  public function __construct() {
    parent::__construct( 'wpxcf-meta-module', __( 'Meta tables and temporary cache', WPXCLEANFIX_TEXTDOMAIN ), $this->rows() );
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
        'title'       => __( 'Orphan post meta', WPXCLEANFIX_TEXTDOMAIN ),
        'description' => __( 'Post Meta without post. These are the extra properties for a generic post (post, page, custom post type, etc...). Sometimes, post meta records may exist without relative post: in this case, post meta are orphan and can be deleted', WPXCLEANFIX_TEXTDOMAIN ),
        'callback'    => array( $this, 'check_orphan_post_meta' ), ),

      array(
        'title'       => __( 'Temporary', WPXCLEANFIX_TEXTDOMAIN ),
        'description' => __( 'These records are used by WordPress for temporary data. If you like you can delete them in safe.', WPXCLEANFIX_TEXTDOMAIN ),
        'callback'    => array(
          $this,
          'check_temporary_postmeta'
        ),
      ),

      array(
        'title'       => __( 'Orphan user meta', WPXCLEANFIX_TEXTDOMAIN ),
        'description' => __( 'User Meta without user. These are extra properties for user. May exist some records without the relative user', WPXCLEANFIX_TEXTDOMAIN ),
        'callback'    => array(
          $this,
          'check_orphan_user_meta'
        ),
      ),
    );
    return $rows;
  }

  // -----------------------------------------------------------------------------------------------------------------
  // Actions
  // -----------------------------------------------------------------------------------------------------------------

  /**
   * Check for post meta without a valid post id linked.
   *
   * @brief Orphan post meta
   *
   * @return WPXCleanFixModuleResponse
   */
  public function check_orphan_post_meta() {
    /* Questo mi fa una count generale */
    $posts = WPXCleanFixMetaModuleSQL::postMetaWithoutPosts();

    if ( empty( $posts ) ) {
      return new WPXCleanFixModuleResponse();
    }

    $number  = count( $posts );
    $message = sprintf( _n( 'You have %s orphan post meta.','You have %s orphan post meta.', $number, WPXCLEANFIX_TEXTDOMAIN ), $number );

    $posts = WPXCleanFixMetaModuleSQL::postMetaWithoutPosts( true );

    $detail  = $this->select( $posts, 'meta_key', array( 'number' ) );
    $actions = $this->actions( WPXCleanFixModuleButtonActionType::CLEAN, array( $this, 'delete_orphan_post_meta' ), __( 'Fix: click here to delete in safe and permantely.', WPXCLEANFIX_TEXTDOMAIN ) );

    return new WPXCleanFixModuleResponse( WPXCleanFixModuleResponseStatus::WARNING, $message, $detail, $actions );
  }

  public function delete_orphan_post_meta() {
    $result = WPXCleanFixMetaModuleSQL::deletePostMetaWithoutPosts();
    return $this->check_orphan_post_meta();
  }

  /**
   * Check for temporary post meta `_edit_lock`
   *
   * @brief Check for temporary post meta
   *
   * @return WPXCleanFixModuleResponse
   */
  public function check_temporary_postmeta() {
    /* Questo mi fa una count generale */
    $posts = WPXCleanFixMetaModuleSQL::temporaryPostMeta();

    if ( empty( $posts ) ) {
      return new WPXCleanFixModuleResponse();
    }

    $number = count( $posts );
    $message = sprintf( _n( 'You have %s temporary post meta.', 'You have %s temporary post meta.', $number, WPXCLEANFIX_TEXTDOMAIN ), $number );

    $posts = WPXCleanFixMetaModuleSQL::temporaryPostMeta( true );

    $detail  = $this->select( $posts, 'meta_key', array( 'number' ) );
    $actions = $this->actions( WPXCleanFixModuleButtonActionType::CLEAN, array( $this, 'delete_temporary_postmeta' ), __( 'Fix: click here to delete in safe and permantely.', WPXCLEANFIX_TEXTDOMAIN ) );

    return new WPXCleanFixModuleResponse( WPXCleanFixModuleResponseStatus::WARNING, $message, $detail, $actions );

  }

  public function delete_temporary_postmeta() {
    $result = WPXCleanFixMetaModuleSQL::deleteTemporaryPostMeta();
    return $this->check_temporary_postmeta();
  }

  /**
   * Check for user meta witout a valid user id linked.
   *
   * @brief Check orphan user meta
   *
   * @return WPXCleanFixModuleResponse
   */
  public function check_orphan_user_meta() {
    /* Questo mi fa una count generale */
    $posts = WPXCleanFixMetaModuleSQL::userMetaWithoutUser();

    if ( empty( $posts ) ) {
      return new WPXCleanFixModuleResponse();
    }

    $number = count( $posts );
    $message = sprintf( _n( 'You have %s orphan user meta.', 'You have %s orphan user meta.', $number, WPXCLEANFIX_TEXTDOMAIN ), $number );

    $posts = WPXCleanFixMetaModuleSQL::userMetaWithoutUser( true );

    $detail  = $this->select( $posts, 'meta_key', array( 'number' ) );
    $actions = $this->actions( WPXCleanFixModuleButtonActionType::CLEAN, array( $this, 'delete_user_meta_without_user' ), __( 'Fix: click here to delete in safe and permantely.', WPXCLEANFIX_TEXTDOMAIN ) );

    return new WPXCleanFixModuleResponse( WPXCleanFixModuleResponseStatus::WARNING, $message, $detail, $actions );

  }

  public function delete_user_meta_without_user() {
    $result = WPXCleanFixMetaModuleSQL::deleteUserMetaWithoutUser();
    return $this->check_orphan_user_meta();
  }

}


/**
 * Encapsulates all SQL method for Module Meta
 *
 * @class              WPXCleanFixMetaModuleSQL
 * @author             =undo= <info@wpxtre.me>
 * @copyright          Copyright (C) 2012-2013 wpXtreme Inc. All Rights Reserved.
 * @date               11/21/12
 * @version            1.0.0
 */
class WPXCleanFixMetaModuleSQL {

  /**
   * Return all meta (id and key) without valid post linked
   *
   * @brief Orphan post meta
   *
   * @param bool   $do_distinct TRUE for distinct rows
   *
   * @return mixed
   */
  public static function postMetaWithoutPosts( $do_distinct = false ) {
    global $wpdb;

    $distinct = '';
    $group_by = '';
    if ( $do_distinct ) {
      $distinct = 'DISTINCT( COUNT(*) ) AS number,';
      $group_by = 'GROUP BY post_meta.meta_key';
    }

    $sql = <<< SQL
SELECT {$distinct} post_meta.meta_id, post_meta.meta_key
FROM `$wpdb->postmeta` post_meta
LEFT JOIN `$wpdb->posts` posts ON posts.ID = post_meta.post_id
WHERE posts.ID IS NULL
{$group_by}
ORDER BY post_meta.meta_key
SQL;

    return $wpdb->get_results( $sql );
  }

  /**
   * Delete (permanently) all post meta without a valied post id linked.
   *
   * @brief Delete orphan post meta
   *
   * @return mixed
   */
  public static function deletePostMetaWithoutPosts() {
    global $wpdb;

    $sql = <<< SQL
DELETE post_meta FROM `$wpdb->postmeta` post_meta
LEFT JOIN `$wpdb->posts` posts ON posts.ID = post_meta.post_id
WHERE posts.ID IS NULL
SQL;

    return $wpdb->query( $sql );
  }

  /**
   * Return the know temporary post meta.
   *
   * @brief Temporary post meta
   *
   * @param bool   $do_distinct TRUE for distinct rows
   *
   * @return mixed
   */
  public static function temporaryPostMeta( $do_distinct = false ) {
    global $wpdb;

    $distinct = '';
    $group_by = '';
    if ( $do_distinct ) {
      $distinct = 'DISTINCT( COUNT(*) ) AS number,';
      $group_by = 'GROUP BY post_meta.meta_key';
    }

    $sql = <<< SQL
SELECT {$distinct} post_meta.meta_id, post_meta.meta_key
FROM `$wpdb->postmeta` post_meta
LEFT JOIN `$wpdb->posts` posts ON posts.ID = post_meta.post_id
WHERE posts.ID IS NOT NULL
AND (
   post_meta.meta_key = '_edit_lock'
OR post_meta.meta_key = '_edit_last'
OR post_meta.meta_key = '_wp_old_slug'
   )
{$group_by}
ORDER BY post_meta.meta_key
SQL;

    return $wpdb->get_results( $sql );
  }

  /**
   * Delete (permanently) all post meta with meta_key equal to input param.
   *
   * @return mixed
   */
  public static function deleteTemporaryPostMeta() {
    global $wpdb;

    $sql = <<< SQL
DELETE post_meta FROM `$wpdb->postmeta` post_meta
LEFT JOIN `$wpdb->posts` posts ON posts.ID = post_meta.post_id
WHERE posts.ID IS NOT NULL
AND (
   post_meta.meta_key = '_edit_lock'
OR post_meta.meta_key = '_edit_last'
OR post_meta.meta_key = '_wp_old_slug'
   )
SQL;

    return $wpdb->query( $sql );
  }

  /**
   * Return all user meta (id, key) without a valued user id linked.
   *
   * @brief Orphan user name
   *
   * @param bool   $do_distinct TRUE for distinct rows
   *
   * @return mixed
   */
  public static function userMetaWithoutUser( $do_distinct = false ) {
    global $wpdb;

    $distinct = '';
    $group_by = '';
    if ( $do_distinct ) {
      $distinct = 'DISTINCT( COUNT(*) ) AS number,';
      $group_by = 'GROUP BY user_meta.meta_key';
    }

    $sql = <<< SQL
SELECT {$distinct} user_meta.umeta_id, user_meta.meta_key
FROM `$wpdb->usermeta` user_meta
LEFT JOIN `$wpdb->users` users ON users.ID = user_meta.user_id
WHERE users.ID IS NULL
{$group_by}
ORDER BY user_meta.meta_key
SQL;

    return $wpdb->get_results( $sql );
  }

  /**
   * Delete (permanently) all user meta withput a valied user id linked.
   *
   * @brief Delete orphan user meta
   *
   * @return mixed
   */
  public static function deleteUserMetaWithoutUser() {
    global $wpdb;

    $sql = <<< SQL
DELETE user_meta
FROM `$wpdb->usermeta` user_meta
LEFT JOIN `$wpdb->users` users ON users.ID = user_meta.user_id
WHERE users.ID IS NULL
SQL;

    return $wpdb->query( $sql );
  }

}