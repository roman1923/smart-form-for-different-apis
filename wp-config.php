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
define( 'DB_NAME', 'romanwp_nvfqj' );

/** Database username */
define( 'DB_USER', 'romanwp_nvfqj' );

/** Database password */
define( 'DB_PASSWORD', 'nSzjGzFln' );

/** Database hostname */
define( 'DB_HOST', 'db24.freehost.com.ua' );

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
define( 'AUTH_KEY',         'XUBhJDXZ2WdmQ7RmcNtq' );
define( 'SECURE_AUTH_KEY',  'eaIC9GgZtGeSSaW8e5q6' );
define( 'LOGGED_IN_KEY',    'tygpiZCMBiuQt42wJ0zj' );
define( 'NONCE_KEY',        'uGD8BTDKUvUg6U0Bq8JO' );
define( 'AUTH_SALT',        '1szgs9iJ50pb5l3XORKJ' );
define( 'SECURE_AUTH_SALT', 'yIbX9bkvhYb0hGwxpM3e' );
define( 'LOGGED_IN_SALT',   'lJwsBqDsYWOW50vJ2ai6' );
define( 'NONCE_SALT',       '4J70jWQapnuppBdEmWNK' );

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
define( 'WP_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';