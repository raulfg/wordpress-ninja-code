// In wp-config.php (development only)
define( 'SAVEQUERIES', true );

// In the template or in a debug plugin
add_action( 'shutdown', function(): void {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    global $wpdb;
    $slow_queries = array_filter(
        $wpdb->queries,
        fn( array $q ) => $q[1] > 0.01 // queries taking more than 10ms
    );

    foreach ( $slow_queries as $query ) {
        error_log( sprintf( '%.4fs: %s', $query[1], $query[0] ) );
    }
} );
