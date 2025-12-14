<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'sheikh_bassam_kayed' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define('AUTH_KEY',         'JW<cL+?VufC4dz)?jNT:h$FE%nEexRS~XdA}n,+yzK/4eS6gv_#{$6b]G1t=ufBK');
define('SECURE_AUTH_KEY',  'gezk}:|AQ/&[6:gh(@0r)7As1dSAo}^(fqT2|NQB$a;7p>-*Tv#Ek:*x`T6KVPgX');
define('LOGGED_IN_KEY',    'z+z|i|Z&,f|o$`!6Wrbsaapv+w#32QY8T);8r|0^ G,?{^8_w{{V92n}Gk=:PgO ');
define('NONCE_KEY',        'Ck-[+D#]*Ew3)Fgb@%8X_FB~C3:&i=rlVT_z}S{LP oSA3*>}4u-UTjmQ*BW1n*L');
define('AUTH_SALT',        '#(D+,zt =hk $fC6yMiv%+EitnM-mH#n1J%P|wb`J x$_|UdZL[q?E9t2-9qxrJ+');
define('SECURE_AUTH_SALT', '|vf-6^LKo +S|{?=F[T7i+tGE%t@jcdA+bf{1|whEuwJ#Xm`{|Mo[j3JoDM-N/fV');
define('LOGGED_IN_SALT',   'LwR2k1(S9F1lsEt8,5-*ouN:+t0jd&I7Y<y(D3a]W]mS)-.fVL+cQ.WobvIVbk3i');
define('NONCE_SALT',       'a0M[wmV$%`rgmVP>1WX/a5hD[{cf2exaDL83ESUNfv6.DDNU[5:S$ky|tjO3zR%u');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

