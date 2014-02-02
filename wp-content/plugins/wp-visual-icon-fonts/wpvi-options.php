<?php
/**
 * This function introduces a single theme menu option into the WordPress 'Plugins'
 * menu.
 */
function wpvi_plugin_menu() {

    add_plugins_page(
        'WordPress Visual Icon Fonts',           // The title to be displayed in the browser window for this page.
        'Icon Fonts',           // The text to be displayed for this menu item
        'administrator',            // Which type of users can see this menu item
        'wpvi_plugin_options',   // The unique ID - that is, the slug - for this menu item
        'wpvi_plugin_display'    // The name of the function to call when rendering the page for this menu
    );

} // end wpvi_theme_menu
add_action('admin_menu', 'wpvi_plugin_menu');

/**
 * Renders a simple page to display for the theme menu defined above.
 */
function wpvi_plugin_display() {
?>
    <!-- Create a header in the default WordPress 'wrap' container -->
    <div class="wrap">

        <!-- Add the icon to the page -->
        <!-- <div id="icon-themes" class="icon32"></div> -->
        <h2>WordPress Visual Icon Font Options</h2>

        <!-- Make a call to the WordPress function for rendering errors when settings are saved. -->
        <?php settings_errors(); ?>

        <!-- Create the form that will be used to render our options -->
        <form method="post" action="options.php">
            <?php settings_fields( 'wpvi_plugin_options' ); ?>
            <?php do_settings_sections( 'wpvi_plugin_options' ); ?>
            <?php submit_button(); ?>
        </form>

    </div><!-- /.wrap -->
<?php
} // end sandbox_theme_display


/* ------------------------------------------------------------------------ *
 * Setting Registration
 * ------------------------------------------------------------------------ */

/**
 * Initializes the theme options page by registering the Sections,
 * Fields, and Settings.
 *
 * This function is registered with the 'admin_init' hook.
 */

function wpvi_initialize_theme_options() {

	// First, we register a section. This is necessary since all future options must belong to one.
	add_settings_section(
		'wpvi_settings_section',			// ID used to identify this section and with which to register options
		'',	// Title to be displayed on the administration page
		'wpvi_plugin_options_options_callback',	// Callback used to render the description of the section
		'wpvi_plugin_options'							// Page on which to add this section of options
	);


	/* ------------------------------------------------------------------------ *
	 * Settings
	 * ------------------------------------------------------------------------ */

	// Next, we will introduce the fields for toggling the visibility of content elements.
	add_settings_field(
		'font_select',						// ID used to identify the field throughout the theme
		'Select the Icon font family to use in your theme, font details, links, basic information and credits are also listed for your convenience.',							// The label to the left of the option interface element
		'wpvi_toggle_font_callback',	// The name of the function responsible for rendering the option interface
		'wpvi_plugin_options',							// The page on which this option will be displayed
		'wpvi_settings_section',			// The name of the section to which this field belongs
		array()
	);

	  // Finally, we register the fields with WordPress
    register_setting(
        'wpvi_plugin_options',
        'font_select'
    );



} // end wpvi_initialize_theme_options

add_action('admin_init', 'wpvi_initialize_theme_options');

/* ------------------------------------------------------------------------ *
 * Section Callbacks
 * ------------------------------------------------------------------------ */

/**
 * This function provides a simple description for the wpvi_plugin_options Options page.
 *
 * It is called from the 'wpvi_initialize_theme_options' function by being passed as a parameter
 * in the add_settings_section function.
 */
function wpvi_plugin_options_options_callback() {
	// echo '<p>Select which areas of content you wish to display.</p>';
} // end wpvi_wpvi_plugin_options_options_callback





/**
 * This function renders the interface elements for toggling the visibility of the header element.
 *
 * It accepts an array of arguments and expects the first element in the array to be the description
 * to be displayed next to the checkbox.
 */
function wpvi_toggle_font_callback($args) {

	// Font Awesome
	$html = '<div class="available-theme">';
	$html .= "<img src='".plugins_url( '/img/fa-cover2.png', __FILE__ )."' width='300' height='225' />";
	$html .= '<input type="radio" id="font_select_fa" name="font_select" value="fa4" ' . checked('fa4', get_option('font_select'), false) . '/>';
	$html .= '<label for="font_select_fa">Font Awesome 4.0.1</label>';
	$html .= '<em>The iconic font designed for Bootstrap</em>';
	$html .= '<p>Font Awesome - One font, 369 Icons, n a single collection, Font Awesome is a pictographic language of web-related actions.</p>';
	$html .= '<small>Created by Dave Gandy</small><br/>';
	$html .= '<a href="http://fontawesome.io/">http://fontawesome.io/</a>';
	$html .= '</div>';

	// Genericons
	$html .= '<div class="available-theme">';
	$html .= "<img src='".plugins_url( '/img/gen-cover2.png', __FILE__ )."' width='300' height='225' />";
	$html .= '<input type="radio" id="font_select_gen" name="font_select" value="genericon" ' . checked('genericon', get_option('font_select'), false) . '/>';
	$html .= '<label for="font_select_gen">Genericons</label>';
	$html .= '<em>a free, GPL, flexible icon font for blogs!</em>';
	$html .= '<p>Genericons are vector icons embedded in a webfont designed to be clean and simple keeping with a generic aesthetic.</p>';
	$html .= '<small>Created by Automatic</small><br/>';
	$html .= '<a href="http://genericons.com/">http://genericons.com/</a>';
	$html .= '</div>';

	echo $html;

} // end sandbox_toggle_header_callback



// admin style
function wpvi_op_style() {
	wp_register_style( 'wpvi-ops', plugins_url('/css/wpvi-options.css', __FILE__ ), array(), array(), $media = 'all' );
	wp_enqueue_style( 'wpvi-ops' );
}

add_action('admin_print_styles-plugins_page_wpvi_plugin_options', 'wpvi_op_style' );

