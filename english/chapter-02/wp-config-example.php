<?php
/**
 * WordPress Configuration - Development Example
 *
 * This file contains the most important settings for
 * a WordPress development environment
 */

// ** Database configuration ** //
define( 'DB_NAME', 'wordpress' );
define( 'DB_USER', 'wordpress' );
define( 'DB_PASSWORD', 'wordpress_password' );
define( 'DB_HOST', 'localhost' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );

/**
 * Unique authentication keys
 * Generate at: https://api.wordpress.org/secret-key/1.1/salt/
 */
define( 'AUTH_KEY',         'put-your-unique-authentication-key-here' );
define( 'SECURE_AUTH_KEY',  'put-your-unique-secure-authentication-key-here' );
define( 'LOGGED_IN_KEY',    'put-your-unique-logged-in-key-here' );
define( 'NONCE_KEY',        'put-your-unique-nonce-key-here' );
define( 'AUTH_SALT',        'put-your-authentication-salt-here' );
define( 'SECURE_AUTH_SALT', 'put-your-secure-authentication-salt-here' );
define( 'LOGGED_IN_SALT',   'put-your-logged-in-salt-here' );
define( 'NONCE_SALT',       'put-your-nonce-salt-here' );

/**
 * WordPress database table prefix
 * You can change this prefix for added security
 */
$table_prefix = 'wp_';

/**
 * Development settings
 */
// Enable debug mode
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );

// Additional debug for development
define( 'SCRIPT_DEBUG', true );
define( 'SAVEQUERIES', true );

// Memory configuration
define( 'WP_MEMORY_LIMIT', '256M' );

// File configuration
define( 'FS_METHOD', 'direct' );

// Disable automatic updates in development
define( 'WP_AUTO_UPDATE_CORE', false );

// Site URLs (useful for Docker)
define( 'WP_HOME', 'http://localhost:8080' );
define( 'WP_SITEURL', 'http://localhost:8080' );

/**
 * Additional optional settings
 */

// Increase file upload time limit
define( 'WP_HTTP_BLOCK_EXTERNAL', false );

// Configure custom uploads directory
// define( 'UPLOADS', 'wp-content/uploads' );

// Enable multisite (uncomment once configured)
// define( 'WP_ALLOW_MULTISITE', true );

// SSL configuration (in production)
// define( 'FORCE_SSL_ADMIN', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
