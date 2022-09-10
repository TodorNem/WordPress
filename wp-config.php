<?php

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
define( 'DB_NAME', 'ntodorovic_portfolio' );
/** Database username */
define( 'DB_USER', 'ntodorovic_portfolio' );
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
define( 'AUTH_KEY',         'z&8}ot@ef[FWj-R!T(l&<1t,M,wnAJm)R`ww:2x[m={$gq4~98N{BJc{x%b`<O2n' );
define( 'SECURE_AUTH_KEY',  'E=-b$~nzHDuO_A8p( .){{7EKtrZa3kU4ZAwB<or[:?4?|XXwc?}~[  B#9iO|LQ' );
define( 'LOGGED_IN_KEY',    '-Rfec{^(EE|.Z8swC0d[#;gt(x3,p?y8Y1tcpM=`mZ%_^KQp+8H|h;U5dh_<9$[!' );
define( 'NONCE_KEY',        'z}#G.GtYxpn%@GHjjI0s;x*EB,bB[;#r^0)4MhUJf[BjtnH4iH~1ts&]C10zikto' );
define( 'AUTH_SALT',        'Bx9Kd|{%(UvT=5)4USJ{F! 2{|tzooH=v&@qq:if,M`Zc<Ic#=v]3Sh#1ber^%$6' );
define( 'SECURE_AUTH_SALT', ';eotiXr8nphwvnt;LQ)po<j3OK1B[VhW-on@ze!B89=W&h/Vj9ndOUgdJA:}Q+IU' );
define( 'LOGGED_IN_SALT',   ',bg$i@W?:p9{*9cX*.v~TK3im^MgYFrjAE3]?9O&rIFY*#EZ@O[_wSdJw)9_xrh6' );
define( 'NONCE_SALT',       '1g:49H%&_4MUDsQ/V#Y$Fkq=KE2/&Uh,1 YJh5]<po/dH$= ()t!X6v>z!eYMJ&R' );
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