<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache


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
define( 'DB_NAME', 'ntodorovic_projekat' );
/** Database username */
define( 'DB_USER', 'ntodorovic_projekat' );
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
define( 'AUTH_KEY',         '%+{*``3{#imF>b&DkFXlk~~?`,P@Q]GJXKl58/Uf$[G><H~X]8IMh1CuWSqsT_)+' );
define( 'SECURE_AUTH_KEY',  ':.{57y%pUaWx7YfLor}fDEm_/A$b{4w..!kA6O*fnCJv=j:0Y-XZrLB$H&i(tZ6j' );
define( 'LOGGED_IN_KEY',    '|N!m@P=`uzpaOQ*wv3q=Z[ ^a?w>$lCG.Sq6Y;gbN6S5Z,,AWu^ h*I%*DF%H?dT' );
define( 'NONCE_KEY',        '(h|]e=)1K(:1c `vy$GD_@r>}#BiE:yfK:Md7HcX3Ew@Zx:=u^}ti,XL,.RL +!$' );
define( 'AUTH_SALT',        'f|:LO10>,#pou^ihmpo2dJs_(:.&jhY/4*ZgdOac}^aT1eM,)PKz?:!oTjniJGF{' );
define( 'SECURE_AUTH_SALT', '}V8]~lK@LgO,ixB=fZ8Z`l)KI4U7L}Kb2;3MU 5m;}Su;K+;Bmz`+=4TBAMb;*E=' );
define( 'LOGGED_IN_SALT',   'OhGInlVESC)5^43P 0EnU(dDNKZf9@8xen8|S:*QE~M#Z9TvP^GnLQ03$g!rlTsy' );
define( 'NONCE_SALT',       '_<tT3y]+7*Y@%byZuj{@M.3u.D=h_Z^aZL6iI>(|dmj6mhswq`UzN5(k%@Tb-oTt' );
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