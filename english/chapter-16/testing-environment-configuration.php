<?php
// Load Composer dependencies
require_once dirname( __DIR__ ) . '/vendor/autoload.php';

// Set up test environment variables
$_tests_dir = getenv( 'WP_TESTS_DIR' );
if ( ! $_tests_dir ) {
    $_tests_dir = rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
}

require_once $_tests_dir . '/includes/functions.php';

// Load the plugin before WordPress loads the test
tests_add_filter( 'muplugins_loaded', function(): void {
    require dirname( __DIR__ ) . '/ninja-portfolio-enhancer.php';
} );

require $_tests_dir . '/includes/bootstrap.php';
