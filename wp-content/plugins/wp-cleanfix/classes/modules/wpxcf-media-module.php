<?php
/**
 * Media and attachment
 *
 * @author             =undo= <info@wpxtre.me>
 * @copyright          Copyright (C) 2012-2013 wpXtreme Inc. All Rights Reserved.
 * @date               06/06/12
 * @version            1.0.0
 *
 */

class WPXCleanFixMediaModule extends WPXCleanFixModuleView {

  /**
   * Create an instance of WPXCleanFixMediaModule class
   *
   * @brief Construct
   *
   * @return WPXCleanFixMediaModule
   */
  public function __construct() {
    parent::__construct( 'wpxcf-media-module', __( 'Media', WPXCLEANFIX_TEXTDOMAIN ), $this->rows() );
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
        'title' => __( 'Orphan attachments', WPXCLEANFIX_TEXTDOMAIN ),
        'description' => __( 'An orphan attachment is a custom post type without a valid parent post\'s ID (it\'s missed). An attachment usually has a null parent post or a post\'s ID', WPXCLEANFIX_TEXTDOMAIN ),
        'callback' => array(
          $this,
          'check_orphan_attachments'
        ),
      ),
    );
    return $rows;
  }

  // -----------------------------------------------------------------------------------------------------------------
  // Actions
  // -----------------------------------------------------------------------------------------------------------------

  /**
   * Check for orphan attachments
   *
   * @brief Check orphan attachments
   *
   * @return WPXCleanFixModuleResponse
   */
  public function check_orphan_attachments() {
    $posts = WPXCleanFixMediaModuleSQL::attachmentsWithNullgPost();

    if ( empty( $posts ) ) {
      return new WPXCleanFixModuleResponse();
    }
    $number  = count( $posts );
    $message = sprintf( _n( 'You have %s orphan attachment.', 'You have %s orphan attachments.', $number, WPXCLEANFIX_TEXTDOMAIN ), $number );
    $detail  = $this->select( $posts, 'post_title' );
    $actions = $this->actions( WPXCleanFixModuleButtonActionType::FIX, array( $this, 'fix_attachments_with_null_post' ), __( 'Fix: click here in order to remove invalid post parent', WPXCLEANFIX_TEXTDOMAIN ) );

    return new WPXCleanFixModuleResponse( WPXCleanFixModuleResponseStatus::WARNING, $message, $detail, $actions );
  }

  public function fix_attachments_with_null_post() {
    $result = WPXCleanFixMediaModuleSQL::fixAttachmentsWithNullgPost();
    return $this->check_orphan_attachments();
  }

}

/**
 * Encapsulates all SQL method for Module Media
 *
 * @class              WPXCleanFixMediaModuleSQL
 * @author             =undo= <info@wpxtre.me>
 * @copyright          Copyright (C) 2012-2013 wpXtreme Inc. All Rights Reserved.
 * @date               11/21/12
 * @version            1.0.0
 */
class WPXCleanFixMediaModuleSQL {

  /**
   * Return all posts of type `attachment` with `post_parent` > 0.
   *
   * @brief Orphan Attachments
   *
   * @return mixed
   */
  public static function attachmentsWithNullgPost() {
    global $wpdb;

    $sql = <<< SQL
SELECT posts_attachment.post_title, posts_attachment.ID as attachment_id
FROM `$wpdb->posts` posts_attachment
LEFT JOIN `$wpdb->posts` posts ON posts_attachment.post_parent = posts.ID
WHERE posts_attachment.post_type = 'attachment'
AND posts_attachment.post_parent > 0
AND posts.ID IS NULL
SQL;

    /* Put in cache transient. */
    $cache = get_transient( 'wpxcf-posts_attachments' );
    if ( empty( $cache ) ) {
      $cache = $wpdb->get_results( $sql );
      set_transient( 'wpxcf-posts_attachments', $cache, 60 * 60 );
    }
    return $cache;
  }

  /**
   * Return all posts of type `attachment` with `post_parent` > 0.
   *
   * @brief Orphan Attachments
   *
   * @return mixed
   */
  public static function fixAttachmentsWithNullgPost() {
    global $wpdb;

    /* Get from cache transient. */
    $cache = get_transient( 'wpxcf-posts_attachments' );
    if ( empty( $cache ) ) {
      $cache = self::attachmentsWithNullgPost();
      set_transient( 'wpxcf-posts_attachments', $cache, 60 * 60 );
    }

    $stack = array();
    foreach ( $cache as $attachment ) {
      $stack[] = $attachment->attachment_id;
    }
    $ids = implode( ',', $stack );

    $sql = <<< SQL
UPDATE `$wpdb->posts`
SET post_parent = 0
WHERE ID IN ({$ids})
SQL;

    delete_transient( 'wpxcf-posts_attachments' );

    return $wpdb->query( $sql );
  }

}