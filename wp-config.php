<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'sdsd_site');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '${B9Pav!7z>r:Z<5xeT7mM.y38fI(RS7e|09RrKt7uWL(l4hX?9P4Bo mJsR_5S-');
define('SECURE_AUTH_KEY',  'qh>._T;)sa_|2/ZY6W:&s[e?1Kray(0*f~17`P6]G#KGjfyXsM4&*4-xDH}pK5w0');
define('LOGGED_IN_KEY',    'N0GyX;o;;Iww2sW }1Int} U*_l}}U8u FTva@,((g!2VC?Vn2R0u_sEsfPr=Op5');
define('NONCE_KEY',        'T%M!znEPc&3w~>tpJQX^ddFn@btZ kEEW=>i|q:bH@#fF1IwGw4ZRblC,.;Ta.E^');
define('AUTH_SALT',        '*IM]:G5+cjjVj7u@0d4!#>%yAQ`|^9(geP!5,C7S)lXY>)x CDy]gl9qvGH~{(;u');
define('SECURE_AUTH_SALT', '2zP),Lq@?s,j$A7=^~rR~yb41qG$LzAK%-O$/2GL88+&ZfTQPHVS~S91@:M:?].^');
define('LOGGED_IN_SALT',   '^x*(UYrR^|W%1c0}8wgWz+[e%*zl4e=(Dg(d.[K]Fb<_@)_V_gL,8J532!ja$nLs');
define('NONCE_SALT',       'Cj6l|<:,2$LVQB8-.ETVMeV54UMS)[:>_rtSk8H7A[OB7::cVbmI.tN@]H1=+Ht(');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
