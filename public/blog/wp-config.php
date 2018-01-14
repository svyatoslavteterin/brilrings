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
define('DB_NAME', 'rings');

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
define('AUTH_KEY',         '|>{.|Ph|-O))Wv_#yOTY0z&$N|0zN#00c.O<1!@G@Y[icQ=e3*7bd/*t|%5njD-u');
define('SECURE_AUTH_KEY',  '-D7J-=VEe;WOrM*Z,k_~$23IbeC)e>THu$-1]~?x9fYsm]ib+)LCPxpR=|zx1x6G');
define('LOGGED_IN_KEY',    '98<ksE zwwygmGhTvM$**N*?+p&^UzB/wIuP/y}fRuj8kWz]3|8^Q:VeN4PF:j8`');
define('NONCE_KEY',        '<z,${g5#HPTS&eCEn5d{AA>k>esbm>Bi~G]H&<rGKeFeA,h ))r8;O?2gG(!Z4uS');
define('AUTH_SALT',        'TC,mL!%H3{&TN%#[F-r-dL/FihzX>)0j@oamj@v;Z2ha +bZk>!ReYd^_Gk>oR=)');
define('SECURE_AUTH_SALT', 'Y,%7o**:QH.9(=F&mNMANPfG/TWh(i=I+OkciI?c $|NnutA3SKhr<~+okw;[Raw');
define('LOGGED_IN_SALT',   'bGp-r7pDz]_=~4B_qSpxoeE-{pquR-0R~GA`,q4Uq3rw7/G<S~Std^w$LN3hyXY>');
define('NONCE_SALT',       '>~A<SIQ#(e7n%gj{8Q<B7Ky_bHQE? Lmm^E_]nu|}H-Mn~xjxQX($(q 3b|3(:t9');

define(‘WPLANG’, ‘ru_RU’);

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
