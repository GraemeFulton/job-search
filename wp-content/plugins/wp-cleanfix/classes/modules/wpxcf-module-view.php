<?php
/**
 * Base class used to display a single module view.
 *
 * @class              WPXCleanFixModuleView
 * @author             =undo= <info@wpxtre.me>
 * @copyright          Copyright (C) 2012-2013 wpXtreme Inc. All Rights Reserved.
 * @date               05/06/12
 * @version            1.0.0
 */

class WPXCleanFixModuleView extends WPDKView {

  private $_id;
  private $_title;
  private $_rows;


  /**
   *
   * @brief Construct
   *
   * @param string $id    Id usato per la tabella
   * @param string $title Tiolo prima colonna
   * @param array  $rows  Elenco delle righe di controllo per questo modulo
   *
   */
  public function __construct( $id, $title, $rows ) {
    $this->_id    = sanitize_key( $id );
    $this->_title = $title;
    $this->_rows  = $rows;

    parent::__construct( $this->_id );
  }

  /**
   * Drawing view
   *
   * @brief Draw
   *
   * @return string
   */
  public function draw() {

    $title_button = __( 'Refresh', WPXCLEANFIX_TEXTDOMAIN );
    $html_rows    = '';

    foreach ( $this->_rows as $data ) {

      $title       = $data['title'];
      $description = $data['description'];

      $class_name  = get_class( $data['callback'][0] );
      $action_name = $data['callback'][1];

      $response = $this->$action_name();

      $status  = $response->statusDescription;
      $detail  = $response->detail;
      $actions = $response->actions;

      $html_rows .= <<< HTML
    <tr>
        <td class="wpxcf-column-refresh"><button title="{$title_button}" class="wpxcf-button-action wpxcf-button-action-refresh" data-class_name="{$class_name}" data-action_name="{$action_name}"></button></td>
        <td class="wpxcf-column-title"><span data-placement="right" title="{$description}" class="wpdk-tooltip">{$title}</span></td>
        <td class="wpxcf-column-status">{$status}</td>
        <td class="wpxcf-column-content">{$detail}</td>
        <td class="wpxcf-column-actions">{$actions}</td>
    </tr>
HTML;
    }

    $html = <<< HTML
<table id="{$this->_id}" class="wpxcf-table" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
        {$html_rows}
    </tbody>
</table>
HTML;
    echo $html;

  }

  /**
   * Return the number of warning for badge
   *
   * @brief Get the number of warning
   *
   * @return int
   */
  public function countWarning() {
    $count = 0;
    if ( !empty( $this->_rows ) ) {
      foreach ( $this->_rows as $data ) {
        $response = call_user_func( $data['callback'] );
        if ( $response->isWarning ) {
          $count++;
        }
      }
    }
    return $count;
  }

  /**
   * Restituisce l'HTML markup per un bottone azione
   *
   * @param string $type        Tipo clean, fix
   * @param array  $callback    Callback per la chiamata al metodo
   * @param string $description Descrizione nel titolo proposta come tooltip
   * @param string $confirm     Se presente aprirà un confirm Javascript prima di eseguire l'azione. Se viene passato
   *                            il boolean TRUE verrà usata una stringa di conferma di default.
   *
   * @return string
   */
  public function actions( $type, $callback, $description, $confirm = '', $custom_check = '' ) {

    $data_attributes = array(
      'placement'   => 'left',
      'class_name'  => get_class( $callback[0] ),
      'action_name' => $callback[1]
    );

    if ( !empty( $confirm ) ) {
      if ( is_bool( $confirm ) && true === $confirm ) {
        $confirm = __( 'WARNING!! Are you sure you want to permanently delete these data? This action is not undoable.', WPXCLEANFIX_TEXTDOMAIN );
      }
      else {
        $data_attributes['confirm'] = $confirm;
      }
    }

    if ( !empty( $custom_check ) ) {
      $data_attributes['custom_check'] = $custom_check;
    }

    /* Build the data- attributes. */
    $datas = array();
    foreach ( $data_attributes as $data => $value ) {
      $datas[] = sprintf( 'data-%s="%s"', $data, $value );
    }
    $data = implode( ' ', $datas );

    $html = <<< HTML
<button title="{$description}" {$data} class="wpdk-tooltip wpxcf-button-action wpxcf-button-action-{$type}"></button>
HTML;
    return $html;
  }

  /**
   * Return the HTML markup for select control used to display more info.
   *
   * @param array  $items
   * @param string $column   Column name
   * @param array  $more     An array with extra column name
   *
   * @return string
   */
  public function select( $items, $column, $more = array() ) {
    $options = '';
    foreach ( $items as $item ) {
      $more_info = '';
      if ( !empty( $more ) ) {
        $stack = array();
        foreach ( $more as $column_name ) {
          $stack[] = $item->$column_name;
        }
        $more_info = sprintf( ' (%s)', implode( ',', $stack ) );
      }
      $options .= sprintf( '<option>%s%s</option>', $item->$column, $more_info );
    }

    $html = <<< HTML
<select class="wpdk-form-select wpxcf-select-info">
{$options}
</select>
HTML;
    return $html;
  }

}



/**
 * Button actions
 *
 * @class              WPXCleanFixModuleView
 * @author             =undo= <info@wpxtre.me>
 * @copyright          Copyright (C) 2012-2013 wpXtreme Inc. All Rights Reserved.
 * @date               05/06/12
 * @version            1.0.0
 */
class WPXCleanFixModuleButtonActionType {

  /**
   * Action Button to clean unused data
   *
   * @brief Clean action
   */
  const CLEAN = 'clean';

  /**
   * Action Button to repair and fix data
   *
   * @brief Fix action
   */
  const FIX = 'fix';
}