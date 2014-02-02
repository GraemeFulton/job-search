/**
 * Admin Javascript
 *
 * @class           WPXCleanFix
 * @author          =undo= <info@wpxtre.me>
 * @copyright       Copyright (C) 2012-2013 wpXtreme Inc. All Rights Reserved.
 * @date            2013-01-23
 * @version         1.0.1
 */

var WPXCleanFix = (function ( $ ) {

    /**
     * Internal class pointer
     *
     * @brief This class
     *
     * @var WPXCleanFix $this
     */
    var $this = {};

    /**
     * Attach a live event trigger on button action
     *
     * @brief Live on click
     */
    $( 'button.wpxcf-button-action' ).live( 'click', function () {

        var class_name = $( this ).data( 'class_name' );
        var action_name = $( this ).data( 'action_name' );
        var custom_check = $( this ).data( 'custom_check' );
        var parameters = false;

        if ( typeof class_name !== 'undefined' && class_name != '' && typeof action_name !== 'undefined' && action_name != '' ) {

            /* Ulteriori controlli. */
            if( typeof custom_check !== 'undefined' ) {
                var custom_result = eval( custom_check );
                if( false === custom_result.code ) {
                    return;
                }
                parameters = custom_result.parameters;
            }

            /* Verifica se l'elemento ha bisogna di conferma */
            var confirm = $( this ).data( 'confirm' );

            if ( typeof confirm !== 'undefined' && confirm != '' ) {
                var yes = window.confirm( confirm );
                if ( !yes ) {
                    return false;
                }
            }

            /* Recupero la riga di quest'azione */
            var tr = $( this ).parents( 'tr' ).css( { opacity : '0.2' } );

            $( this ).tooltip( 'hide' );

            $.post( wpdk_i18n.ajaxURL, {
                    action      : 'wpxcf_action',
                    class_name  : class_name,
                    action_name : action_name,
                    parameters  : parameters,
                    _ajax_nonce : wpxcf_i18n.ajax_nonce
                }, function ( data ) {
                    var result = $.parseJSON( data );

                    if ( typeof result.message !== 'undefined' ) {
                        alert( result.message );
                    }

                    tr.find( '.wpxcf-column-status' ).html( result.status );
                    tr.find( '.wpxcf-column-content' ).html( result.content );
                    tr.find( '.wpxcf-column-actions' ).html( result.actions );
                    tr.css( { opacity : '1' } );

                    /* Refresh table status. */
                    if ( 'checkDatabaseTablesStatus' != action_name ) {
                        $( 'button[data-action_name="checkDatabaseTablesStatus"]' ).click();
                    }
                    else {
                        _update_badge();
                    }

                    WPDK.init();
                }
            );
        }

        return false;
    } );


    /**
     * Check if an user is select in combo
     *
     * @brief Check for selected user
     *
     * @return {Boolean}
     */
    $this.users_posts = function () {
        if ( '' == $( 'select[name=users_posts]' ).val() ) {
            alert( wpxcf_i18n.pleaseSelectUser );
            $( 'select[name=users_posts]' ).focus();
            return { code : false };
        }
        else {
            return {
                code   : true,
                parameters : [ $( 'select[name=users_posts]' ).val() ]
            };
        }
    };

    /**
     * Update the badge count
     */
    function _update_badge() {
        $.post( wpdk_i18n.ajaxURL, {
                action : 'wpxcf_action_update_badge'
            }, function ( data ) {
                var result = $.parseJSON( data );

                if ( typeof result.message !== 'undefined' ) {
                    alert( result.message );
                }

                /* Se il numero di warning è maggiore di zero inserisco il badge. */
                var $badge =  $( 'span.wpxcf-badge' ).length ? $( 'span.wpxcf-badge' ) : false;

                if ( result.count > 0 ) {
                    /* Questo span dovrebbe esistere sempre; vedi WPDKUI::badge() */
                    if ( $badge) {
                        $badge.replaceWith( result.badge );
                    }
                } else {
                    /* Se non ci sono warning e c'era il badge lo elimino. */
                    if ( $badge ) {
                        $badge
                            .removeClass( 'update-plugins' )
                            .removeClass( 'wpdk-badge' )
                            .html( '' );
                    }
                }
            }
        );
    }

    // -----------------------------------------------------------------------------------------------------------------
    // Public properties
    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Version
     */
    $this.version = "1.0.1";

    // -----------------------------------------------------------------------------------------------------------------
    // End
    // -----------------------------------------------------------------------------------------------------------------

    return $this;

})( window.jQuery );