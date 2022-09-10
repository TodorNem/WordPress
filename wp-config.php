<?php
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
define( 'DB_NAME', 'ntodorovic_roman' );

/** Database username */
define( 'DB_USER', 'ntodorovic_roman' );

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
define( 'AUTH_KEY',         '?b_XQdrrDcliFP2Q6FMM(&(@},tkc<z=t^feId2{i{dk$Ujw&:^KoWEk9z9<oaB$' );
define( 'SECURE_AUTH_KEY',  'S9l@9-<X< zKq1Qp.=6U!<O.?Y|))kGl FY$|oLW*pbvbc5Xl%$1nhlau`)ro`ls' );
define( 'LOGGED_IN_KEY',    'xX2JWnlWe+I ,JRE.F ~E%itZB$1PDwDc@7z;$xB,N-k@iKEbm.o`V+a!GxlQ`O*' );
define( 'NONCE_KEY',        'XOR2vKheYM%Oleol6KJEph9f^hY#uWPwB`}qPuTcTM{=)PA)<;}l/w6!Ng]zc(A0' );
define( 'AUTH_SALT',        '3a41r[2lriZk[%@&p%0/t,Pr{J4gZV>7ufAtt9h{jdlpr+w1/_<z4D`)p!ew|ecE' );
define( 'SECURE_AUTH_SALT', 'bL^^O>iM,0Au`[g$^!HwOWh:9S-wH8o8^[K@%K[k,HbRnGX<r&+qD~5DiL:bDQ.3' );
define( 'LOGGED_IN_SALT',   '(]4VNnhqLtEu2I# ^9/(bh?mDg)InBX=C,Q-Kpz6xc;M$NfE]!Z.AbqP3+_MyxTE' );
define( 'NONCE_SALT',       'cYHyrr_}{ZkRGdo>B8hZY2Q>P&)+F}F2*zT0ll4.D),gtounoOC$:II8ROI3CqB2' );

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
