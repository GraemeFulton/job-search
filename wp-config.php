<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'lgwp');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'jinkster2312');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');


define('BP_AVATAR_ORIGINAL_MAX_FILESIZE', 51200000);
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'e|<(o#;-t4A!siXkMCLD~IR<Fuj;keRnx^ ^8!QK~3o8%X`%lY(ZD;J2{K5iAu;-');
define('SECURE_AUTH_KEY',  '&U+| :C16nUoiSVUjmp|%l@@)a?Psg?f_@ao9g<uP$g.f%Y-;a}TWClx(~Y:a{_a');
define('LOGGED_IN_KEY',    '^ARQNqnF+OS0k7e3^MpRdEDih-C}at`uu|i1lB6]U/<p4e8/a-5=2zy)9u|wfzMP');
define('NONCE_KEY',        '^pfa[e0F1um{]>j~g{Ka3`)]>E_lZIL]P7~Fy{3;9BsgVbSOOD~?O?|Zf7U:NAB!');
define('AUTH_SALT',        'n-g*MBg5E#x=Ofd-}vTXO:sAN.L:k+sw :80Z1 R(KChQs]8FArm+O<v-n!5v/i>');
define('SECURE_AUTH_SALT', 'wkRXm=y6yX*1w]d30MJ7^obX!19]|j`BO84D?YFy2yaH2KI4C0C*+*?cIN=/H<y7');
define('LOGGED_IN_SALT',   '-C|+fP!WZ<~$n0 Q!+}K~wu$l7$-Bd!1ujT7I~o9Ciq{p-*vh<.WmbpcW? f|(n{');
define('NONCE_SALT',       '&dSp^AJcn61<V04wI|/B0<XR5@Vq1nj|o7QSpEXD{u/+%RHf^Dcq05A!,i1F)gxs');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

define('FS_METHOD', 'direct');



?>
