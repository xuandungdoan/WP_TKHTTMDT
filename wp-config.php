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
define( 'DB_NAME', 'xuandung' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '_#HeT=5UdA$SwZ)*U0ol0hm[C>E,~SAB7^RhbJ1]eh!rr5j~~+M#I(X/r@6]#.1O' );
define( 'SECURE_AUTH_KEY',  '_>3onufHryM]fu!T]U8[33b3[WI%?>WplIVYWbYwmh|<z>PMTZ20Iu+*fOv{ag4D' );
define( 'LOGGED_IN_KEY',    '}_85-g@#%XRPeD(Y+<>M TB/!b,v-YRM(H OwpuTJs0e>D]4XmD}Ta*|V`~Vi7,>' );
define( 'NONCE_KEY',        '0F.n#QBDVkZ}HO&Kf5Yp k2e${<>[!Wsbb~s!`4$2{_vf6hRcJoz( d{Aw}jU@wO' );
define( 'AUTH_SALT',        'T`5*b_C4@iEjt8S2v .53r2{@+C6s~ de4*Z.nBSGUB)OYJbp]igTDN%^5H<N)Y|' );
define( 'SECURE_AUTH_SALT', ' e[Sn6Z~+ohla7[N.PCr;kp{!S*R<jbx0JXMnP2XS5K-4 k|EFY55!A/_-&kD-{c' );
define( 'LOGGED_IN_SALT',   '__N;eP$lvG0MGIu)C%O U-;dE@JW/?IqLPT$/9#-KX=i+U(J)fQ|BW#)%_#MMw.n' );
define( 'NONCE_SALT',       ']uIT^&7HOa2^0z*`g?XSgaaOiG>yF+M$(rFQJ]$Dox8UW&UDnC_2N>i)GM}#y=%j' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'xd_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
