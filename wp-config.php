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
define('DB_NAME', 'code95_db');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         '}8>;AZiMjviOeaJo*m,`T*xbwmC@R92V08 |?I&f=g*wa)</0bOr=sXxVQPj:-2O');
define('SECURE_AUTH_KEY',  '=xx:Fu!^duY4<-Aaq=WV1{bqliJ49]hi;Z5ke-vVat@WZ~9moAX%1LPP4%Tb>?Zj');
define('LOGGED_IN_KEY',    'Cp6HUm4#CFZ>[]clvNPO+pd~40lijoD`3)8_m.HEui</%S:Yp(T<z4g`hU?&r$|a');
define('NONCE_KEY',        'uU4GLa7QDDTy-3VsAw@f#1A5wYZiEesQ)](;eqHCz7J~0^*N550pG (_L6cqJMn-');
define('AUTH_SALT',        'F;JzKCK?ke&MB7q}Y+Tc*`|.zhdDa?j%tJW9gK:*h^+^H[wVdT+z7EQ7nYu/QXy7');
define('SECURE_AUTH_SALT', '%{83%N6 BxlJ$lHo&0j+r5/RbpCTv@kt!^[AE)4up_^[aD@L~];/3z]*J?Wl,L#Q');
define('LOGGED_IN_SALT',   'E#2#k4}1@5#7(4E;c|*|j^E~hId-)<t`^I`ARm~8]WZs4`/kDKPl3ReTu!Id+)C7');
define('NONCE_SALT',       '.qzJW7LfIRNdE!;5rU8Ph(q=wFBr3n?Z#<$<$^I#0Hq|wg!d?$Jk]`dByOeFLkge');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
