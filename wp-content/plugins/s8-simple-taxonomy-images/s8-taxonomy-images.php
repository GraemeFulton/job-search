<?php
/**
 * Plugin Name: Sideways8 Simple Taxonomy Images
 * Plugin URI: http://sideways8.com/plugins/s8-simple-taxonomy-images/
 * Description: This plugin was designed with themers and developers in mind. It allows for an easy way to quickly add category, tag, and custom taxonomy images to your taxonomy terms. Check our site (http://sideways8.com/plugins/s8-simple-taxonomy-images/) or the WordPress repository (http://wordpress.org/extend/plugins/s8-simple-taxonomy-images) for documentation on how to use this plugin.
 * Tags: s8, sideways8, sideways 8, taxonomy images, category images, taxonomy, category
 * Version: 0.8.4
 * Author: Sideways8 Interactive
 * Author URI: http://sideways8.com/
 * License: GPLv3
 */
/**
 * @package S8_Simple_Taxonomy_Images
 */

define('S8_STI_FILE', __FILE__);

// Include additional files
include_once( plugin_dir_path( S8_STI_FILE ) . 'inc/s8-sti-functions.php' );

/**
 * Main class containing internal functionality needed
 * Class S8_Simple_Taxonomy_Images
 */
class S8_Simple_Taxonomy_Images {
    private $version = '0.8.4';

    /**
     * Setup our actions!
     * @since 0.8.0
     */
    function __construct() {
        if ( get_option( 's8_sti_version' ) != $this->version ) $this->update();
        // Add base actions
        add_action( 'admin_head', array( $this, 'init' ) );
        add_action( 'edit_term', array( $this, 'save_fields' ), 10, 3 );
        add_action( 'create_term', array( $this, 'save_fields' ), 10, 3 );
        //add_action('get_terms_args', 's8_taxonomy_images_filter_order', 10, 2); TODO: Evaluate how well our filter would work
        //add_shortcode('s8-taxonomy-list', array($this, 'shortcode_term_list')); TODO: Get shortcode working
    }

    /**
     * Adds our form fields to the WP add/edit term forms
     * @since 0.8.0
     */
    function init() {
        $taxes = get_taxonomies();
        if ( is_array( $taxes ) ) {
            foreach ( $taxes as $tax ) {
                add_action( $tax . '_add_form_fields', array( $this, 'add_fields' ) );
                add_action( $tax . '_edit_form_fields', array( $this, 'edit_fields' ) );
                // Add our thumbnail column to taxonomy overviews
                add_filter( "manage_edit-{$tax}_columns", array( $this, 'add_taxonomy_column' ) );
                add_filter( "manage_{$tax}_custom_column", array( $this, 'edit_taxonomy_columns' ), 10, 3 );
            }
        }
    }

    /**
     * Adds our custom fields to the WP add term form
     * @since 0.8.0
     */
    function add_fields() {
        global $wp_version;
        $this->setup_field_scripts();
        // Make it look better if it is 3.5 or later
        $before_3_5 = false;
        if ( version_compare( $wp_version, '3.5', '<' ) ) $before_3_5 = true;
        /*?>
        <div class="form-field">
            <label for="s8_tax_order">Sort Order</label>
            <input type="number" name="s8_tax_order" id="s8_tax_order" size="4" min="0" max="9999" value="" />
        </div>*/ ?>
        <div class="form-field" style="overflow: hidden;">
            <label><?php _e( 'Image' ); ?></label>
            <input type="hidden" name="s8_tax_image" id="s8_tax_image" value="" />
            <input type="hidden" name="s8_tax_image_classes" id="s8_tax_image_classes" value="" />
            <br/>
            <img src="" id="s8_tax_image_preview" style="max-width:300px;max-height:300px;float:left;display:none;padding:0 10px 5px 0;" />
            <a href="#" class="<?php echo ( $before_3_5 ) ? '' : 'button'; ?>" id="s8_tax_add_image"><?php _e( 'Add/Change Image' ); ?></a>
            <a href="#" class="<?php echo ( $before_3_5 ) ? '' : 'button'; ?>" id="s8_tax_remove_image" style="display: none;"><?php _e( 'Remove Image' ); ?></a>
        </div>
        <?php
    }

    /**
     * Adds our custom fields to the WP edit term form
     * @param $taxonomy Object A WP Taxonomy term object
     * @since 0.8.0
     */
    function edit_fields( $taxonomy ) {
        $this->setup_field_scripts();
        /*?>
        <tr class="form-field">
            <th><label for="s8_tax_order">Sort Order</label></th>
            <td><input type="number" name="s8_tax_order" id="s8_tax_order" size="4" min="0" max="9999" value="<?php echo $taxonomy->term_group; ?>" /></td>
        </tr>*/ ?>
        <tr class="form-field">
            <th><label for="s8_tax_image"><?php _e( 'Image' ); ?></label></th>
            <td>
                <?php $image = s8_get_taxonomy_image_src($taxonomy, 'full'); ?>
                <input type="hidden" name="s8_tax_image" id="s8_tax_image" value="<?php echo ($image)?$image['src']:''; ?>" />
                <input type="hidden" name="s8_tax_image_classes" id="s8_tax_image_classes" value="" />
                <?php $image = s8_get_taxonomy_image_src($taxonomy);  ?>
                <img src="<?php echo ($image)?$image['src']:''; ?>" id="s8_tax_image_preview" style="max-width: 300px;max-height: 300px;float:left;display: <?php echo($image['src'])?'block':'none'; ?>;padding: 0 10px 5px 0;" />
                <a href="#" class="button" id="s8_tax_add_image" style=""><?php _e( 'Add/Change Image' ); ?></a>
                <a href="#" class="button" id="s8_tax_remove_image" style="display: <?php echo ( $image['src'] ) ? 'inline-block' : 'none'; ?>;"><?php _e( 'Remove Image' ); ?></a>
            </td>
        </tr>
        <?php
    }

    function setup_field_scripts() {
        global $wp_version;
        if ( version_compare( $wp_version, '3.5', '<' ) ) { // WP Version 3.4.x and lower
            wp_enqueue_style( 'thickbox' );
            wp_enqueue_script( 's8-taxonomy-images', plugins_url( '/js/s8-taxonomy-images-legacy.js', S8_STI_FILE ), array( 'jquery', 'thickbox' ) );
        } else { // Version 3.5.x+
            wp_enqueue_media();
            wp_enqueue_script( 's8-taxonomy-images', plugins_url( '/js/s8-taxonomy-images.js', S8_STI_FILE ), array( 'jquery' ) );
        }
    }

    /**
     * Saves the data from our custom fields on the WP add/edit term form
     * @param $term_id
     * @param null $tt_id
     * @param null $taxonomy
     * @since 0.8.0
     */
    function save_fields($term_id, $tt_id = null, $taxonomy = null) {
        // THE FOLLOWING BLOCK IS NOT USED AT THIS TIME AND MAY NEVER BE ENABLED FOR VARIOUS REASONS.
        /*if(isset($_POST['s8_tax_order']) && ($order = (int)$_POST['s8_tax_order'])) {
            global $wpdb;
            $wpdb->query($wpdb->prepare("UPDATE $wpdb->terms SET term_group = $order WHERE term_id = $term_id;"));
            //wp_update_term($term_id, $taxonomy, array('term_group' => $order));
        }*/ // END UNUSED CODE
        // Save our info
        $option = "s8_tax_image_{$taxonomy}_{$term_id}";
        if ( isset( $_POST['s8_tax_image'] ) && ( $src = $_POST['s8_tax_image'] ) ) {
            if ( $src != '' ) {
                if ( isset( $_POST['s8_tax_image_classes'] ) && preg_match( '/wp-image-([0-9]{1,99})/', $_POST['s8_tax_image_classes'], $matches ) ) {
                    // We have the ID from the class, use it.
                    update_option( $option, $matches[1] );
                } else {
                    global $wpdb;
                    $attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE guid='%s';", $src) );
                    // See if we found the attachment ID, otherwise save URL instead.
                    if ( 0 < absint( $attachment[0] ) )
                        update_option( $option, $attachment[0] );
                    else
                        update_option( $option, $src );
                }
            }
            else {
                $test = get_option( $option );
                if ( $test )
                    delete_option( $option );
            }
        }
        else {
            $test = get_option( $option );
            if ( $test )
                delete_option( $option );
        }
    }

    /**
     * Adds the new column to all taxonomy management screens
     * @param $columns
     * @return mixed
     * @since 0.8.3
     */
    function add_taxonomy_column( $columns ) {
        $columns['s8_tax_image_thumb'] = 'Taxonomy Image';
        return $columns;
    }

    /**
     * Adds the thumbnail to all terms in the taxonomy management screens (if they have a thumbnail we can get).
     * @param $out
     * @param $column_name
     * @param $term_id
     * @return bool|String
     * @since 0.8.3
     */
    function edit_taxonomy_columns( $out, $column_name, $term_id ) {
        if ( $column_name != 's8_tax_image_thumb' ) return $out;
        $term = get_term( $term_id, $_GET['taxonomy'] );
        $image = s8_get_taxonomy_image( $term, array( 50, 50 ) );
        if ( $image ) $out = $image;
        return $out;
    }

    /**
     * Changes orderby to term_group for specific queries, not in use yet...
     * @param $args
     * @param $taxonomies
     * @return mixed
     * @since 0.8.0
     */
    /*function filter_order($args, $taxonomies) {
        if(is_admin()) return $args; // Avoid doing anything in the admin area.
        $args['orderby'] = 'term_group';
        return $args;
    }*/

    /**
     * For our future shortcode...still working out what it will actually do.
     * @param $atts
     * @since 0.8.0
     */
    /*function shortcode_term_list($atts) {
        extract(shortcode_atts(array(
            'taxonomy' => 'category',
            'show_children' => 0,
            'show_titles' => 0,
        ), $atts));
    }*/

    /**
     * Allows us to update anything that needs updating
     * @since 0.8.4
     */
    function update() {
        update_option( 's8_sti_version', $this->version );
    }
}
new S8_Simple_Taxonomy_Images;
