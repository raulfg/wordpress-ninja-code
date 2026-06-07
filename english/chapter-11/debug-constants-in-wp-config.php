// Enable debug mode
define( 'WP_DEBUG', true );

// Write errors to a log file instead of displaying them on screen
// (essential in production if WP_DEBUG is active)
define( 'WP_DEBUG_LOG', true );     // Writes to wp-content/debug.log
define( 'WP_DEBUG_DISPLAY', false ); // Do not display errors on screen

// Custom log path (since WordPress 5.1)
define( 'WP_DEBUG_LOG', '/var/log/wordpress/debug.log' );

// Disable script concatenation in the admin
define( 'CONCATENATE_SCRIPTS', false );

// Use non-minified versions of core scripts
define( 'SCRIPT_DEBUG', true );

// Store queries in $wpdb->queries for analysis
define( 'SAVEQUERIES', true );
