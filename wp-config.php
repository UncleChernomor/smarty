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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'smartylab' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '12345CrazY' );

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
define( 'AUTH_KEY',         'atd8k/6|d4O[v;YeVC(S*G1S%sQp)^<nN6ow]+t2d7z3&es33Jc`$9ad]`%KF[hl' );
define( 'SECURE_AUTH_KEY',  'U~vrY!mZQ2e2ngapqL)RG,R=!N*A+RsdXu;5fGYek)9GufhXBCJ!/Yw`1_K$An99' );
define( 'LOGGED_IN_KEY',    'XnjSo(}1O1o.Mp#-lkX9U^-#3w-m/`wcHb$Vy2jiOoj}~D:nw n$@&|VO &YhT~^' );
define( 'NONCE_KEY',        'eTVe7XN>a(PT*Umy +4KFMVbMqS9|Mh~;VAnWOC_:W|.g1_t-4X}Ln/g@+q+7ot<' );
define( 'AUTH_SALT',        'nD3,LEE&syn*V8j;orJ3Z`^ +_uoKkl9/jr7a(H<0g@g5mV:JDa68U>AolG7ZI0d' );
define( 'SECURE_AUTH_SALT', ' -$,Wss}mRu=Qk4t[Yp;/K*lfIy$peZc4.GI`e ;dTVXD^eMfSI.7MtqG2M=a.9E' );
define( 'LOGGED_IN_SALT',   'w>=-l0ww-PF/LG?;Zfi c0az?G{8Gf*_pu &%sJ+pYL]}d|(Em~9bymzoJ|8hP^k' );
define( 'NONCE_SALT',       '|69$9c{IU^SBC ~OmNlFKZqBUg2~|n~nqY5Xg?H@~|+,7}{p-4L+;l`z]yy%D)Kr' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
