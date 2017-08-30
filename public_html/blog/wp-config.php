<?php
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
define('DB_NAME', 'muarenha_blog');

/** MySQL database username */
define('DB_USER', 'muarenha_net');

/** MySQL database password */
define('DB_PASSWORD', '3xslsn[nkGqX');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'P[eLZ~,>kh_2i~j(nWg+d)|5*vby~h8+L?59]V7_7x[-:-|^./sy@|z-)Q|=u<,=');
define('SECURE_AUTH_KEY',  '44|G*!vtOi7zy*y5Hd{Mi,m|gV>3}iO1smsm&PXsDL]6$E9gV<y]YN%.OW*-b&tM');
define('LOGGED_IN_KEY',    ')=Gc-6_IY%~163+S;Fh]oM_Awehe/x3/ <x+^+`0R]eT,gp#CyIEH|--lSAubzE@');
define('NONCE_KEY',        'qW9}P_w+9<F[}[OwaRf24.`<Kii_-LHtZ[K[|_{^Wcj]prmmsRL3ln;4+MFCn/{|');
define('AUTH_SALT',        '+)O|/-C!7%byK_D_lE-sP [g7e-d56B4%wzVF(sh=%W^>8M8~CD[7Of&ty 3XlQ$');
define('SECURE_AUTH_SALT', 'Z5cxZCbI&D_ 1*pXE}wQsZ Ei&B8mnK0Lhc09+/f|]hO@_wv0n1C[]17$JuWc$k+');
define('LOGGED_IN_SALT',   '0b[M=E?GY&F*te|%tjntSZ)WBKT~]+Dtr.vJg~chIP?hELq>A-{YlE;NIs}sk|6i');
define('NONCE_SALT',       '|_m~M.i |4zQ+l,W|VRH|]W/Apb.f*oJU{{dn<04z4p&y855nFRf~G+dq6)1e|CI');

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
