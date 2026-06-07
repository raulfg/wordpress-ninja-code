add_action( 'shutdown', function(): void {
    if ( ! defined( 'SAVEQUERIES' ) || ! SAVEQUERIES ) {
        return;
    }
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    global $wpdb;

    $slow = array_filter(
        $wpdb->queries,
        fn( array $q ) => $q[1] > 0.05 // > 50ms
    );

    foreach ( $slow as [$sql, $time, $backtrace] ) {
        error_log( sprintf(
            "SLOW QUERY (%.4fs):\n%s\nCalled from: %s\n",
            $time,
            $sql,
            $backtrace
        ) );
    }
} );
