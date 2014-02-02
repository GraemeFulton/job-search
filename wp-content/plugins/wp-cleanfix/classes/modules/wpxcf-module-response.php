<?php
/**
 * Status response constants
 *
 * @class              WPXCleanFixModuleResponseStatus
 * @author             =undo= <info@wpxtre.me>
 * @copyright          Copyright (C) 2012-2013 wpXtreme Inc. All Rights Reserved.
 * @date               21/11/12
 * @version            1.0.0
 *
 */
class WPXCleanFixModuleResponseStatus {

  /**
   * Define status ok
   *
   * @brief Ok
   */
  const OK = 'ok';

  /**
   * The status of response
   *
   * @brief Status
   *
   * @var string $status
   */
  const WARNING = 'warning';
}



/**
 * Classe standard usata nelle risposte dei controlli. Un qualsiasi modulo risponde sempre con questa classe o con un
 * WP_Error. In questo modo la risposto può essere elaborata con semplicità.
 *
 * @class              WPXCleanFixModuleResponse
 * @author             =undo= <info@wpxtre.me>
 * @copyright          Copyright (C) 2012-2013 wpXtreme Inc. All Rights Reserved.
 * @date               06/06/12
 * @version            1.0.0
 *
 */
class WPXCleanFixModuleResponse {

  /**
   * Define status ok
   *
   * @deprecated Use WPXCleanFixModuleResponseStatus::OK instead
   *
   * @brief Ok
   */
  const STATUS_OK = 'ok';

  /**
   * Define the warning status
   *
   * @deprecated Use WPXCleanFixModuleResponseStatus::WARNING instead
   *
   * @brief Warning
   */
  const STATUS_WARNING = 'warning';

  /**
   * The status of response
   *
   * @brief Status
   *
   * @var string $status
   */
  public $status;

  /**
   * Description of the status
   *
   * @brief Status description
   *
   * @var string $statusDescription
   */
  public $statusDescription;

  /**
   * More detail for the status response
   *
   * @brief Detail
   *
   * @var string $detail
   */
  public $detail;

  /**
   * @brief Actions
   *
   * @var string $actions
   */
  public $actions;

  /**
   * TRUE if warning
   *
   * @brief Is warning
   *
   * @var bool $isWarning
   */
  public $isWarning;

  /**
   * Create an instance of WPXCleanFixModuleResponse class
   *
   * @brief Construct
   *
   * @param string       $status  The status
   * @param bool|string  $message Optional message
   * @param string       $detail  Optional detail
   * @param array|string $actions Actions
   *
   * @return WPXCleanFixModuleResponse
   */
  public function __construct( $status = WPXCleanFixModuleResponseStatus::OK, $message = false, $detail = '', $actions = '' ) {
    if ( empty( $message ) ) {
      if ( WPXCleanFixModuleResponseStatus::OK === $status ) {
        $message = __( 'All works.', WPXCLEANFIX_TEXTDOMAIN );
      }
    }

    $this->isWarning = ( WPXCleanFixModuleResponseStatus::WARNING === $status );

    $this->status  = $status;
    $this->detail  = $detail;
    $this->actions = $actions;

    $this->statusDescription( $message );
  }

  /**
   * Set the propertiy statusDescription with a status HTML tag
   *
   * @brief Status description
   */
  private function statusDescription( $message ) {
    $this->statusDescription = <<< HTML
<span title="{$message}" class="wpdk-tooltip wpxcf-status-{$this->status}"></span>
HTML;
  }

}
