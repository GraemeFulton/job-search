<?php
/**
 * Term and taxonomy (category, tags, ... )
 *
 * @class              WPXCleanFixTermTaxnonomyModule
 * @author             =undo= <info@wpxtre.me>
 * @copyright          Copyright (C) 2012-2013 wpXtreme Inc. All Rights Reserved.
 * @date               06/06/12
 * @version            1.0.0
 *
 */

class WPXCleanFixTermTaxnonomyModule extends WPXCleanFixModuleView {

  /**
   * Create an instance of WPXCleanFixTermTaxnonomyModule class
   *
   * @brief Construct
   *
   * @return WPXCleanFixTermTaxnonomyModule
   */
  public function __construct() {
    parent::__construct( 'wpxcf-term-taxonom-module', __( 'Terms, taxonomie and relationships', WPXCLEANFIX_TEXTDOMAIN ), $this->rows() );
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
        'title'       => __( 'Consistent Terms', WPXCLEANFIX_TEXTDOMAIN ),
        'description' => __( 'These are orphan Terms and they don\'t exist in the taxonomy table.', WPXCLEANFIX_TEXTDOMAIN ),
        'callback'    => array(
          $this,
          'check_terms'
        ),
      ),

      array(
        'title'       => __( 'Consistent Terms/Taxonomy', WPXCLEANFIX_TEXTDOMAIN ),
        'description' => __( 'These are orphan Taxonomies and they have not a valid term linked.', WPXCLEANFIX_TEXTDOMAIN ),
        'callback'    => array(
          $this,
          'check_term_taxonomy'
        ),
      ),

      array(
        'title'       => __( 'Consistent Terms/Relationships', WPXCLEANFIX_TEXTDOMAIN ),
        'description' => __( 'Check for term_relationships table and looking for missing taxonomy id.', WPXCLEANFIX_TEXTDOMAIN ),
        'callback'    => array(
          $this,
          'check_term_relationships'
        ),
      ),

      array(
        'title'       => __( 'Orphan Post Tags', WPXCLEANFIX_TEXTDOMAIN ),
        'description' => __( 'Check for unused posts tags.', WPXCLEANFIX_TEXTDOMAIN ),
        'callback'    => array(
          $this,
          'check_orphan_tags'
        ),
      ),

      array(
        'title'       => __( 'Orphan Post Categories', WPXCLEANFIX_TEXTDOMAIN ),
        'description' => __( 'Check for unused posts categories.', WPXCLEANFIX_TEXTDOMAIN ),
        'callback'    => array(
          $this,
          'check_orphan_categories'
        ),
      ),

      array(
        'title'       => __( 'Orphan Terms', WPXCLEANFIX_TEXTDOMAIN ),
        'description' => __( 'Check for unused generic terms.', WPXCLEANFIX_TEXTDOMAIN ),
        'callback'    => array(
          $this,
          'check_orphan_terms'
        ),
      ),


    );
    return $rows;
  }

  // -----------------------------------------------------------------------------------------------------------------
  // Actions
  // -----------------------------------------------------------------------------------------------------------------

  /**
   * Check terms table consistent
   *
   * @brief Check terms table consistent
   *
   * @return WPXCleanFixModuleResponse
   */
  public function check_terms() {
    /* Questo mi fa una count generale */
    $terms = WPXCleanFixTermTaxnonomyModuleSQL::termsConsistent();

    if ( empty( $terms ) ) {
      return new WPXCleanFixModuleResponse();
    }

    $number  = count( $terms );
    $message = sprintf( _n( 'You have %s orphan term. This term doesn\'t extis as taxonomy.', 'You have %s orphan terms. These terms do not extis as taxonomy.', $number, WPXCLEANFIX_TEXTDOMAIN ), $number );
    $detail  = $this->select( $terms, 'name' );
    $actions = $this->actions( WPXCleanFixModuleButtonActionType::CLEAN, array( $this, 'repair_terms' ), __( 'Fix: click here to repair terms', WPXCLEANFIX_TEXTDOMAIN ) );

    return new WPXCleanFixModuleResponse( WPXCleanFixModuleResponseStatus::WARNING, $message, $detail, $actions );
  }

  public function repair_terms() {
    $result = WPXCleanFixTermTaxnonomyModuleSQL::repairTerms();
    return self::check_terms();
  }

  /**
   * Check term_taxonomy table consistent. These are the taxonomies that have a not valied term id linked.
   *
   * @brief Check term_taxonomy table consistent
   *
   * @return WPXCleanFixModuleResponse
   */
  public function check_term_taxonomy() {
    /* Questo mi fa una count generale */
    $terms = WPXCleanFixTermTaxnonomyModuleSQL::termTaxonomyConsistent();

    if ( empty( $terms ) ) {
      return new WPXCleanFixModuleResponse();
    }

    $number  = count( $terms );
    $message = sprintf( _n( 'You have %s orphan taxonomy. This is taxonomy have a not valid term id linked.', 'You have %s orphan taxonomies. These taxonomies have not a valid term id linked.', $number, WPXCLEANFIX_TEXTDOMAIN ), $number );
    $detail  = $this->select( $terms, 'taxonomy' );
    $actions = $this->actions( WPXCleanFixModuleButtonActionType::CLEAN, array( $this, 'repair_term_taxonomy' ), __( 'Fix: click here to repair terms and taxonomies.', WPXCLEANFIX_TEXTDOMAIN ) );

    return new WPXCleanFixModuleResponse( WPXCleanFixModuleResponseStatus::WARNING, $message, $detail, $actions );
  }

  public function repair_term_taxonomy() {
    $result = WPXCleanFixTermTaxnonomyModuleSQL::repairTermTaxonomy();
    return self::check_term_taxonomy();
  }

  /**
   * Check term_relationships table consistent.
   * Return all rows with NULL object_id or term_taxpnomy id.
   *
   * @brief Check term_relationships table consistent
   *
   * @return WPXCleanFixModuleResponse
   */
  public function check_term_relationships() {
    /* Questo mi fa una count generale */
    $rows = WPXCleanFixTermTaxnonomyModuleSQL::termRelationshipsConsistent();

    if ( empty( $rows ) ) {
      return new WPXCleanFixModuleResponse();
    }

    $number  = count( $rows );
    $message = sprintf( _n( 'You have %s row broken. This object id or term taxonomy id is not valid.', 'You have %s rows broken. These are objects\'s id or term taxonomy\'s id not valid.', $number, WPXCLEANFIX_TEXTDOMAIN ), $number );
    $detail  = sprintf( '<strong>%s</strong>', $number );
    $actions = $this->actions( WPXCleanFixModuleButtonActionType::CLEAN, array( $this, 'repair_term_relationships' ), __( 'Fix: click here to repair terms relationships.', WPXCLEANFIX_TEXTDOMAIN ) );

    return new WPXCleanFixModuleResponse( WPXCleanFixModuleResponseStatus::WARNING, $message, $detail, $actions );
  }

  public function repair_term_relationships() {
    $result = WPXCleanFixTermTaxnonomyModuleSQL::repairTermRelationship();
    return self::check_term_relationships();
  }

  /**
   * Check unused orphan post tags
   *
   * @brief Check unused orphan post tags
   *
   * @return WPXCleanFixModuleResponse
   */
  public function check_orphan_tags() {
    /* Questo mi fa una count generale */
    $terms = WPXCleanFixTermTaxnonomyModuleSQL::orphanTags();

    if ( empty( $terms ) ) {
      return new WPXCleanFixModuleResponse();
    }

    $number  = count( $terms );
    $message = sprintf( _n( 'You have %s orphan tag.',  'You have %s orphan tags.', $number, WPXCLEANFIX_TEXTDOMAIN ), $number );
    $detail  = $this->select( $terms, 'name' );
    $actions = $this->actions( WPXCleanFixModuleButtonActionType::CLEAN, array( $this, 'delete_orphan_tags' ), __( 'Fix: click here to delete in safe and permantely.', WPXCLEANFIX_TEXTDOMAIN ), true );

    return new WPXCleanFixModuleResponse( WPXCleanFixModuleResponseStatus::WARNING, $message, $detail, $actions );
  }

  public function delete_orphan_tags() {
    $result = WPXCleanFixTermTaxnonomyModuleSQL::deleteOrphanTags();
    return self::check_orphan_tags();
  }

  /**
   * Check unused orphan post categories
   *
   * @brief Check unused post categories
   *
   * @return WPXCleanFixModuleResponse
   */
  public function check_orphan_categories() {
    /* Questo mi fa una count generale */
    $terms = WPXCleanFixTermTaxnonomyModuleSQL::orphanCategories();

    if ( empty( $terms ) ) {
      return new WPXCleanFixModuleResponse();
    }

    $number  = count( $terms );
    $message = sprintf( _n( 'You have %s orphan post category.', 'You have %s orphan post categories.', $number, WPXCLEANFIX_TEXTDOMAIN ), $number );
    $detail  = $this->select( $terms, 'name' );
    $actions = $this->actions( WPXCleanFixModuleButtonActionType::CLEAN, array( $this, 'delete_orphan_categories' ), __( 'Fix: click here to delete in safe and permantely.', WPXCLEANFIX_TEXTDOMAIN ), true );

    return new WPXCleanFixModuleResponse( WPXCleanFixModuleResponseStatus::WARNING, $message, $detail, $actions );
  }

  public function delete_orphan_categories() {
    $result = WPXCleanFixTermTaxnonomyModuleSQL::deleteOrphanCategories();
    return self::check_orphan_categories();
  }

  /**
   * Check unused orphan generic terms
   *
   * @brief Check unused orphan generic terms
   *
   * @return WPXCleanFixModuleResponse
   */
  public function check_orphan_terms() {
    /* Questo mi fa una count generale */
    $terms = WPXCleanFixTermTaxnonomyModuleSQL::orphanTerms();

    if ( empty( $terms ) ) {
      return new WPXCleanFixModuleResponse();
    }

    $number  = count( $terms );
    $message = sprintf( _n( 'You have %s orphan generic term', 'You have %s orphan generic terms.', $number, WPXCLEANFIX_TEXTDOMAIN ), $number );
    $detail  = $this->select( $terms, 'name', array( 'taxonomy' ) );
    $actions = $this->actions( WPXCleanFixModuleButtonActionType::CLEAN, array( $this, 'delete_orphan_terms' ), __( 'Fix: click here in order to delete all orphan terms.', WPXCLEANFIX_TEXTDOMAIN ), true );

    return new WPXCleanFixModuleResponse( WPXCleanFixModuleResponseStatus::WARNING, $message, $detail, $actions );
  }

  public function delete_orphan_terms() {
    $result = WPXCleanFixTermTaxnonomyModuleSQL::deleteOrphanTerms();
    return self::check_orphan_terms();
  }

}


/**
 * Encapsulates all SQL method for Module Term and Taxonomy
 *
 * @class              WPXCleanFixMetaModuleSQL
 * @author             =undo= <info@wpxtre.me>
 * @copyright          Copyright (C) 2012-2013 wpXtreme Inc. All Rights Reserved.
 * @date               11/21/12
 * @version            1.0.0
 */
class WPXCleanFixTermTaxnonomyModuleSQL {

  /**
   * Return all orphan terms
   *
   * @brief Orphan terms
   *
   * @return mixed
   */
  public static function termsConsistent() {
    global $wpdb;

    $sql = <<< SQL
SELECT * FROM `$wpdb->terms` AS T
LEFT JOIN `$wpdb->term_taxonomy` AS TT ON TT.term_id = T.term_id
WHERE T.term_id <> 1
AND TT.term_taxonomy_id IS NULL
ORDER BY T.name
SQL;
    return $wpdb->get_results( $sql );
  }

  /**
   * Delete (permanently) all orphan terms. These are the terms that doesn't exists in wp_term_taxonomy table.
   *
   * @brief Delete orphan terms
   *
   * @return mixed
   */
  public static function repairTerms() {
    global $wpdb;

    $sql = <<< SQL
DELETE T FROM `$wpdb->terms` AS T
LEFT JOIN `$wpdb->term_taxonomy` AS TT ON TT.term_id = T.term_id
WHERE T.term_id <> 1
AND TT.term_taxonomy_id IS NULL
SQL;
    return $wpdb->query( $sql );
  }


  /**
   * Return all orphan taxonomies. These are the taxonomies that have a not valied term id linked.
   *
   * @brief Orphan taxonomies
   *
   * @return mixed
   */
  public static function termTaxonomyConsistent() {
    global $wpdb;

    $sql = <<< SQL
SELECT * FROM `$wpdb->term_taxonomy` AS TT
LEFT JOIN `$wpdb->terms` AS T ON T.term_id = TT.term_id
WHERE TT.term_id <> 1
AND T.term_id IS NULL
ORDER BY TT.taxonomy
SQL;
    return $wpdb->get_results( $sql );
  }

  /**
   * Delete (permanently) all orphan taxonomies. These are the taxonomies that have a not valied term id linked.
   *
   * @brief Delete orphan taxonomies
   *
   * @return mixed
   */
  public static function repairTermTaxonomy() {
    global $wpdb;

    $sql = <<< SQL
DELETE TT FROM `$wpdb->term_taxonomy` AS TT
LEFT JOIN `$wpdb->terms` AS T ON T.term_id = TT.term_id
WHERE TT.term_id <> 1
AND T.term_id IS NULL
SQL;
    return $wpdb->query( $sql );
  }

  /**
   * Return all orphan taxonomies. These are the taxonomies that have a not valied term id linked.
   *
   * @brief Orphan taxonomies
   *
   * @return mixed
   */
  public static function termRelationshipsConsistent() {
    global $wpdb;

    $sql = <<< SQL
SELECT * FROM `$wpdb->term_relationships` AS TR
LEFT JOIN `$wpdb->term_taxonomy` AS TT ON TT.term_taxonomy_id = TR.term_taxonomy_id
LEFT JOIN `$wpdb->posts` AS P ON P.ID = TR.object_id
WHERE TT.term_taxonomy_id IS NULL
OR P.ID IS NULL
SQL;
    return $wpdb->get_results( $sql );
  }

  /**
   * Delete (permanently) all orphan taxonomies. These are the taxonomies that have a not valied term id linked.
   *
   * @brief Delete orphan taxonomies
   *
   * @return mixed
   */
  public static function repairTermRelationship() {
    global $wpdb;

    $sql = <<< SQL
DELETE TR FROM `$wpdb->term_relationships` AS TR
LEFT JOIN `$wpdb->term_taxonomy` AS TT ON TT.term_taxonomy_id = TR.term_taxonomy_id
LEFT JOIN `$wpdb->posts` AS P ON P.ID = TR.object_id
WHERE TT.term_taxonomy_id IS NULL
OR P.ID IS NULL
SQL;
    return $wpdb->query( $sql );
  }


  /**
   * Return all unused tags
   *
   * @brief Orphan tags
   *
   * @return mixed
   */
  public static function orphanTags() {
    global $wpdb;

    $sql = <<< SQL
SELECT * FROM `$wpdb->terms` AS T
LEFT JOIN `$wpdb->term_taxonomy` AS TT ON T.term_id = TT.term_id
LEFT JOIN `$wpdb->term_relationships` AS TR ON TR.term_taxonomy_id = TT.term_taxonomy_id
WHERE TT.taxonomy = 'post_tag'
AND TT.count = 0
AND TR.term_taxonomy_id IS NULL
ORDER BY T.name
SQL;
    return $wpdb->get_results( $sql );
  }

  /**
   * Delete (permanently) all orphan tags
   *
   * @brief Delete orphan tags
   *
   * @return mixed
   */
  public static function deleteOrphanTags() {
    global $wpdb;

    $sql = <<< SQL
DELETE T,TT,TR FROM `$wpdb->terms` AS T
LEFT JOIN `$wpdb->term_taxonomy` AS TT ON T.term_id = TT.term_id
LEFT JOIN `$wpdb->term_relationships` AS TR ON TR.term_taxonomy_id = TT.term_taxonomy_id
WHERE TT.taxonomy = 'post_tag'
AND TT.count = 0
AND TR.term_taxonomy_id IS NULL
SQL;

    return $wpdb->query( $sql );
  }

  /**
   * Return all unused categories
   *
   * @brief Orphan categories
   *
   * @return mixed
   */
  public static function orphanCategories() {
    global $wpdb;

    $sql = <<< SQL
SELECT * FROM `$wpdb->terms` AS T
LEFT JOIN `$wpdb->term_taxonomy` AS TT ON T.term_id = TT.term_id
LEFT JOIN `$wpdb->term_relationships` AS TR ON TR.term_taxonomy_id = TT.term_taxonomy_id
WHERE TT.taxonomy = 'category'
AND T.term_id <> 1
AND TT.count = 0
AND TR.term_taxonomy_id IS NULL
ORDER BY T.name
SQL;
    return $wpdb->get_results( $sql );
  }

  /**
   * Delete (permanently) all orphan tags
   *
   * @brief Delete orphan tags
   *
   * @return mixed
   */
  public static function deleteOrphanCategories() {
    global $wpdb;

    $sql = <<< SQL
DELETE T,TT,TR FROM `$wpdb->terms` AS T
LEFT JOIN `$wpdb->term_taxonomy` AS TT ON T.term_id = TT.term_id
LEFT JOIN `$wpdb->term_relationships` AS TR ON TR.term_taxonomy_id = TT.term_taxonomy_id
WHERE TT.taxonomy = 'category'
AND T.term_id <> 1
AND TT.count = 0
AND TR.term_taxonomy_id IS NULL
SQL;
    return $wpdb->query( $sql );
  }


  /**
   * Return all unused categories
   *
   * @brief Orphan categories
   *
   * @return mixed
   */
  public static function orphanTerms() {
    global $wpdb;

    $sql = <<< SQL
SELECT * FROM `$wpdb->terms` AS T
LEFT JOIN `$wpdb->term_taxonomy` AS TT ON T.term_id = TT.term_id
LEFT JOIN `$wpdb->term_relationships` AS TR ON TR.term_taxonomy_id = TT.term_taxonomy_id
WHERE ( TT.taxonomy <> 'category' AND TT.taxonomy <> 'post_tag' )
AND T.term_id <> 1
AND TT.count = 0
AND TR.term_taxonomy_id IS NULL
ORDER BY T.name
SQL;
    return $wpdb->get_results( $sql );
  }

  /**
   * Delete (permanently) all orphan generic terms
   *
   * @brief Delete orphan generic terms
   *
   * @return mixed
   */
  public static function deleteOrphanTerms() {
    global $wpdb;

    $sql = <<< SQL
DELETE T,TT,TR FROM `$wpdb->terms` AS T
LEFT JOIN `$wpdb->term_taxonomy` AS TT ON T.term_id = TT.term_id
LEFT JOIN `$wpdb->term_relationships` AS TR ON TR.term_taxonomy_id = TT.term_taxonomy_id
WHERE ( TT.taxonomy <> 'category' AND TT.taxonomy <> 'post_tag' )
AND T.term_id <> 1
AND TT.count = 0
AND TR.term_taxonomy_id IS NULL
SQL;
    return $wpdb->query( $sql );
  }

}