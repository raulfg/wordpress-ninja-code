// En wp-config.php (solo en desarrollo)
define( 'SAVEQUERIES', true );

// En el template o en un plugin de debug
add_action( 'shutdown', function(): void {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    global $wpdb;
    $slow_queries = array_filter(
        $wpdb->queries,
        fn( array $q ) => $q[1] > 0.01 // queries de más de 10ms
    );

    foreach ( $slow_queries as $query ) {
        error_log( sprintf( '%.4fs: %s', $query[1], $query[0] ) );
    }
} );
