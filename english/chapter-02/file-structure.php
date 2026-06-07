<?php

// Database connection
define( 'DB_NAME',     'database_name' );
define( 'DB_USER',     'username' );
define( 'DB_PASSWORD', 'password' );
define( 'DB_HOST',     'localhost' );
define( 'DB_CHARSET',  'utf8mb4' );
define( 'DB_COLLATE',  'utf8mb4_unicode_ci' );

// Authentication keys and salting
define( 'AUTH_KEY',         '...' );
define( 'SECURE_AUTH_KEY',  '...' );
define( 'LOGGED_IN_KEY',    '...' );
define( 'NONCE_KEY',        '...' );
define( 'AUTH_SALT',        '...' );
define( 'SECURE_AUTH_SALT', '...' );
define( 'LOGGED_IN_SALT',   '...' );
define( 'NONCE_SALT',       '...' );

// Table prefix
$table_prefix = 'wp_';

// Debug mode (development only)
define( 'WP_DEBUG', false );

/* The rest of the WordPress configuration */
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}
require_once ABSPATH . 'wp-settings.php';
