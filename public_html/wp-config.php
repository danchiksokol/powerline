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
//define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/home/admin/web/plg3.bragin.ru/public_html/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'plg_db');

/** MySQL database username */
define('DB_USER', 'plg_db');

/** MySQL database password */
define('DB_PASSWORD', 'iKNMCTP8PX');

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
define('AUTH_KEY',         'hxY{Q6|zR7MLT4/oTts{w=2]8{r @qH)|Vk2eR~S(i#0,z`R+0Ammo19vX,k+ jS');
define('SECURE_AUTH_KEY',  'q^+|?)8+!XFm76a2s/;07YfZkqeO+yfSJ-kkO$jA$DBr4-b7dowItC|`q[WXTVsz');
define('LOGGED_IN_KEY',    '`38dMWueQ*bT!M=y+x_Ri$[]vYx3kUf9;g:[(xqkP0CkwCc|ho$9cb7F@ClajII+');
define('NONCE_KEY',        '>F2&qCk7kVVIo3X^Q~S+ix!{W5&zPLCcWww3_PdBUDX2WyRk&*cm*yY!Zt9MwR+8');
define('AUTH_SALT',        'Rz+bwy]W53XycJ)=fFQdJ;G ~pp)tH4j+NOl#)u5s7!tt+4U~pvj -Z?;-PFIH_.');
define('SECURE_AUTH_SALT', '*1[aTH;Pe-a>i#Kj,0snR8in>OXgT5Zb-hm:-g}fYtZ>{vBL/x-qyFE6pxFyVVWv');
define('LOGGED_IN_SALT',   'oE)ivL-nV|lS8;]|,E]1[NV%$e+]AyW<r:L)kgmC+I~JIl&Bv!{O-Q>|-5qVU&Q*');
define('NONCE_SALT',       '1KnSS1g!z])o}DH|tm<Rm`N|0{-Fb[nUyy{=yt~2kn+%kn+Ou.Ot-sg%6s[nUPl|');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_plg_braginru';

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
