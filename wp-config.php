<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache


/** Enable W3 Total Cache */
/** Enable W3 Total Cache */
/** Enable W3 Total Cache */
/** Enable W3 Total Cache */
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */
// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'ntodorovic_digitel' );
/** Database username */
define( 'DB_USER', 'ntodorovic_digitel' );
/** Database password */
define( 'DB_PASSWORD', 'Duskodugousko90!' );
/** Database hostname */
define( 'DB_HOST', 'localhost' );
/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );
/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );
/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'y<~K]=ykhF]*3$+/5pd/ )(JW&%S46n1O>6<yZ73kpeEu~;}D/o=bqm5f6hG=PQ3' );
define( 'SECURE_AUTH_KEY',  'I6p{46N5LubD`kQ^=N a4*ORLOTgD[PaJXp_@4ns+,+eN.H6RLJ3zcRxqjzERUDF' );
define( 'LOGGED_IN_KEY',    'CpwiGWK;y9n7%4UBS|KD@ZFueC>_!XnmV.{AKet#KJ8c4/%xu?RWjXMynq[_@7;Y' );
define( 'NONCE_KEY',        'VT&VYMWClSw _@R.=4Q2XSH?|m[fZRv;d6{.VBJ$W>PK1bkdY] xMa7`%:z+!l~2' );
define( 'AUTH_SALT',        'V^QFoB6&%)Wl)MgWc=RTyoMW9N+:e@.BB<Q|*l@(`ZanaUNKHWq*Ym_Qd@;TppK:' );
define( 'SECURE_AUTH_SALT', '&[FF$,Y`.H3m$`G/RC$nNJ_{MW<rtV{_:) dr=6_R^KG2D3Fmi|x|k1r>MJ}3#z8' );
define( 'LOGGED_IN_SALT',   'H=eV>UxQ?:&@UVDJG.H_P{}bg3GmF%u,T.fkqT;FS:h1[-PgEz6o#nAYi;H]:N6U' );
define( 'NONCE_SALT',       'l%:YTu3z9=Ez>Fs.!GxKR9Z=t%4d5b7naI>Uj+segao5m->F>dtS9yJx2Av=*$#D' );
/**#@-*/
/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';
/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );
/* Add any custom values between this line and the "stop editing" line. */
/* That's all, stop editing! Happy publishing. */
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}
/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';