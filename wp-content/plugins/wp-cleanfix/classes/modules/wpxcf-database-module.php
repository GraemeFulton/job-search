<?php
/**
 * Database clean & fix module
 *
 * @class              WPXCleanFixDatabaseModule
 * @author             =undo= <info@wpxtre.me>
 * @copyright          Copyright (C) 2012-2013 wpXtreme Inc. All Rights Reserved.
 * @date               05/06/12
 * @version            1.0.0
 *
 */

class WPXCleanFixDatabaseModule extends WPXCleanFixModuleView {

  /**
   * Create an instance of WPXCleanFixDatabaseModule class
   *
   * @brief Construct
   *
   * @return WPXCleanFixDatabaseModule
   */
  public function __construct() {
    parent::__construct( 'wpxcf-database-module', __( 'Tables', WPXCLEANFIX_TEXTDOMAIN ), $this->rows() );
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
        'title'       => __( 'Tables', WPXCLEANFIX_TEXTDOMAIN ),
        'description' => __( 'Database table status', WPXCLEANFIX_TEXTDOMAIN ),
        'callback'    => array( $this, 'checkDatabaseTablesStatus' ),
      ),
    );
    return $rows;
  }

  /**
   * Return ad array with the supported database table type
   *
   * @brief Get the supported databse table type
   *
   * @return array
   */
  private function engine() {
    $engine = array(
      'MyISAM',
      'ISAM',
      'HEAP',
      'MEMORY',
      'ARCHIVE'
    );
    return $engine;
  }

  /**
   * Return the HTML markup for detail
   *
   * @param array $info A key value pairs array with additional information
   *
   * @return string
   */
  private function detail( $info ) {

    $tables     = $info['tables'];
    $total_gain = $info['total_gain'];

    $html_rows = '';

    foreach ( $tables as $name => $table ) {
      $engine = $table['engine'];
      $gain   = $table['gain'];

      $html_rows .= <<< HTML
<tr>
    <td class="wpxcf-table-more-info-column-engine">{$engine}</td>
    <td class="wpxcf-table-more-info-column-name">{$name}</td>
    <td class="wpxcf-table-more-info-column-gain">{$gain}</td>
</tr>
HTML;
    }

    $table_engine = __( 'Table Engine', WPXCLEANFIX_TEXTDOMAIN );
    $table_name   = __( 'Table Name', WPXCLEANFIX_TEXTDOMAIN );
    $table_gain   = __( 'Table Gain', WPXCLEANFIX_TEXTDOMAIN );

    $total_string = __( 'Total Gain', WPXCLEANFIX_TEXTDOMAIN );
    $total_gain   = sprintf( '%6.2f Kb', $total_gain );

    $html = <<< HTML
<div class="wpxcf-table-more-info">
    <table class="wpxcf-table-more-info-header" border="0" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
                <th class="wpxcf-table-more-info-column-engine">{$table_engine}</th>
                <th class="wpxcf-table-more-info-column-name">{$table_name}</th>
                <th class="wpxcf-table-more-info-column-gain">{$table_gain}</th>
            </tr>
        </thead>
    </table>
    <div class="wpxcf-table-more-info-scroller">
        <table class="wpxcf-table-more-info-body" border="0" cellspacing="0" cellpadding="0">
            <tbody>
                {$html_rows}
            </tbody>
            <tfoot>
                <tr>
                <td colspan="2">{$total_string}</td>
                <td colspan="2">{$total_gain}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
HTML;
    return $html;

  }

  /**
   * Restituisce un array con l'elenco delle tabelle che hanno bisogno di un'ottimizzazione e il guadagno totale
   * ricavato.
   *
   * @return array
   */
  private function tablesToOptimize() {
    global $wpdb;

    $tables     = array();
    $total_gain = 0;

    $sql    = sprintf( 'SHOW TABLE STATUS FROM `%s`', DB_NAME );
    $result = $wpdb->get_results( $sql );

    if ( !empty( $result ) ) {
      $total_gain = 0;
      foreach ( $result as $table ) {
        $gain = round( floatval( $table->Data_free ) / 1024, 2 );
        if ( $gain > 0 ) {
          $total_gain += $gain;
          $tables[$table->Name] = array(
            'engine' => $table->Engine,
            'gain'   => sprintf( '%6.2f Kb', $gain )
          );
        }
      }
    }
    return array(
      'tables'     => $tables,
      'total_gain' => $total_gain
    );
  }

  // -----------------------------------------------------------------------------------------------------------------
  // Actions
  // -----------------------------------------------------------------------------------------------------------------

  /**
   * Restituisce l'elenco delle tabelle da ottimizzare
   *
   * @return WPXCleanFixModuleResponse
   */
  public function checkDatabaseTablesStatus() {

    /* Elenco delle tabelle che hanno bisogno di essere ottimizzate. */
    $result     = $this->tablesToOptimize();
    $tables     = $result['tables'];
    $total_gain = $result['total_gain'];

    if ( empty( $tables ) ) {
      return new WPXCleanFixModuleResponse();
    }
    $number  = count( $tables );
    $message = sprintf( _n( 'You have %s table to optimize for a gain of %s.', 'You have %s tables to optimize for a gain of %s.', $number, WPXCLEANFIX_TEXTDOMAIN ), $number, sprintf( '%6.2f Kb', $total_gain ) );
    $detail  = $this->detail( $result );
    $actions = $this->actions( WPXCleanFixModuleButtonActionType::FIX, array( $this, 'database_optimize' ), __( 'Fix: click here in order to optimize your table. This action is safe.', WPXCLEANFIX_TEXTDOMAIN ) );

    return new WPXCleanFixModuleResponse( WPXCleanFixModuleResponseStatus::WARNING, $message, $detail, $actions );
  }

  /**
   * Ottimizza solo le tabelle che ne hanno bisogno, comprese quelle di tipo innoDB.
   *
   * @brief Optimize tables
   *
   * @return WPXCleanFixModuleResponse|WP_Error
   */
  public function database_optimize() {
    global $wpdb;

    $infodb = $this->tablesToOptimize();
    $tables = $infodb['tables'];
    $engine = $this->engine();

    $optimize_tables = array();
    $innodb_tables   = array();
    foreach ( $tables as $name => $info ) {
      if ( in_array( $info['engine'], $engine ) ) {
        $optimize_tables[] = $name;
      }
      else {
        $innodb_tables[] = $name;
      }
    }

    /* MyISAM and other... */
    if ( !empty( $optimize_tables ) ) {
      $list_name = join( ', ', $optimize_tables );
      $result    = $wpdb->query( 'OPTIMIZE TABLE ' . $list_name );
      if ( is_wp_error( $result ) ) {
        return $result;
      }
    }

    /* InnoDB */
    if ( !empty( $innodb_tables ) ) {
      foreach ( $innodb_tables as $inno_name ) {
        $result = $wpdb->query( 'ALTER TABLE ' . $inno_name . ' ENGINE=InnoDB' );
        if ( is_wp_error( $result ) ) {
          return $result;
        }
      }
    }

    return $this->checkDatabaseTablesStatus();

  }

}
