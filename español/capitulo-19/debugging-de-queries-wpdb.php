global $wpdb;

// Activar el log de errores de $wpdb
$wpdb->show_errors();

// Ejecutar la query
$results = $wpdb->get_results( $sql );

// Ver la última query ejecutada (útil en desarrollo)
if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
    error_log( '[ninja] Last query: ' . $wpdb->last_query );
    error_log( '[ninja] Last error: ' . $wpdb->last_error );
}

// Ver todas las queries del request (requiere SAVEQUERIES)
if ( defined( 'SAVEQUERIES' ) && SAVEQUERIES ) {
    $slow_queries = array_filter( $wpdb->queries, fn( $q ) => $q[1] > 0.05 );
    foreach ( $slow_queries as $query ) {
        error_log( sprintf( '[ninja] Slow query (%.4fs): %s', $query[1], $query[0] ) );
    }
}
