global $wpdb;

// Enable $wpdb error logging
$wpdb->show_errors();

// Run the query
$results = $wpdb->get_results( $sql );

// Inspect the last executed query (useful during development)
if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
    error_log( '[ninja] Last query: ' . $wpdb->last_query );
    error_log( '[ninja] Last error: ' . $wpdb->last_error );
}

// Inspect all queries for the request (requires SAVEQUERIES)
if ( defined( 'SAVEQUERIES' ) && SAVEQUERIES ) {
    $slow_queries = array_filter( $wpdb->queries, fn( $q ) => $q[1] > 0.05 );
    foreach ( $slow_queries as $query ) {
        error_log( sprintf( '[ninja] Slow query (%.4fs): %s', $query[1], $query[0] ) );
    }
}
