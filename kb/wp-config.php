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
define( 'DB_NAME', 'siteiptv_wp535' );

/** MySQL database username */
define( 'DB_USER', 'siteiptv_wp535' );

/** MySQL database password */
define( 'DB_PASSWORD', 'S]6mWp7[91' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         'u1zq6jzp4a9ajwpqehmzz84dccdrmllyk2cb5iwu40mafzp5f7mscgfeyw2g1unz' );
define( 'SECURE_AUTH_KEY',  'jazzblbhgtgdw6cg1mqotulcfyjhrvvgo2apflytoypzop22wcdibgjmrtksd4jy' );
define( 'LOGGED_IN_KEY',    'adgiwlcxvy4dgau6eyd0r0ig0v6mh3mu5jgwkpa3lbbejqpkvsvkee4zl7qn1zcm' );
define( 'NONCE_KEY',        'pjk3rbfgatf3lnfltaq4x4hzmehlfa6oy44h5apog3jox6fbi53fw4xisioavikj' );
define( 'AUTH_SALT',        'pfxb66mwngnb2k7xbv1ylebpp8dau5rzsfsnmapmthvenfj2lyhldkbwg4vdladg' );
define( 'SECURE_AUTH_SALT', 'h8f9hvqtxe2yy3dubznzaes7anq2vmtgxtwa4bqhzfbgwr1lbnenpzsmw39pwy8q' );
define( 'LOGGED_IN_SALT',   'bblkomvddivmq4dd2ectqq5hr6vtaakwjnobhz2qh4x8axdm4asd2ux4ed4j79ty' );
define( 'NONCE_SALT',       'klkcqtvpn8fyucppauvw1ixmrhpaojegglbow1df74bgxjxufl3cd2hgymqpxtmt' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpuh_';

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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
