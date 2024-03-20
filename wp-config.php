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

 * @link https://wordpress.org/support/article/editing-wp-config-php/

 *

 * @package WordPress

 */


// ** MySQL settings - You can get this info from your web host ** //

/** The name of the database for WordPress */

define( 'DB_NAME', "shadloobag" );


/** MySQL database username */

define( 'DB_USER', "root" );


/** MySQL database password */

define( 'DB_PASSWORD', "" );


/** MySQL hostname */

define( 'DB_HOST', "localhost" );


/** Database Charset to use in creating database tables. */

define( 'DB_CHARSET', 'utf8' );


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

define('AUTH_KEY',         '5s(L(cK,@~F:d>1~ZW&liA_68Gv]$&Cq1lK& ~( [`p75/Of5Ml/3P%b*k@+k/u@');

define('SECURE_AUTH_KEY',  'j8sN8(OBwg@XTd!>Zu~.+=; 6pKp/+60Kwp2*6g,3qZHQVA&EHHDqjbIBg+z<NVQ');

define('LOGGED_IN_KEY',    'VB9_-:n?Pqho~0-o+Br#1XN/R=W#4:|WU3dWF>*Jz06ec>:_kOW6x4Oz-9Fpp6Rp');

define('NONCE_KEY',        'Ed9#sqiZ%C;#rVD=KP#G=e~w4)fD/~!ep>S{k 3PaQMaF!gb+d`s#|pAi]qu9@#q');

define('AUTH_SALT',        'OU^P5}cNYJQr?BXCpkKk<a!hRQh~?UReawP@DN|QTsYOm@w+WG!%4Zc.<o8J)TfJ');

define('SECURE_AUTH_SALT', '~8L@b8+n;&5|<)se!+Sy=elMY=0f I%^]6o#$:O}*)Th;brcHE[_Ib>k(l|<HA.z');

define('LOGGED_IN_SALT',   ']zW(Ve#<Cza8 2CdL6(u+fUut5*~wY);g$,LABf775P2ah#<{0s.rbTE|OPo}o*$');

define('NONCE_SALT',       'UCqisj7G]m8Ti/GW*xYZ)tCk-RK@iA:l*bx }bC!-*cO>MHo h,y,xjO}.oU/k9p');


/**#@-*/


/**

 * WordPress Database Table prefix.

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



/* That's all, stop editing! Happy publishing. */


/** Absolute path to the WordPress directory. */

if ( ! defined( 'ABSPATH' ) ) {

	define( 'ABSPATH', __DIR__ . '/' );

}


/** Sets up WordPress vars and included files. */

require_once ABSPATH . 'wp-settings.php';

