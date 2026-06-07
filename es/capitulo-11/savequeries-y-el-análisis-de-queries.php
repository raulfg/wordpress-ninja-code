// Solo en desarrollo — no en producción
add_action( 'shutdown', function(): void {
    if ( ! defined( 'SAVEQUERIES' ) || ! SAVEQUERIES ) {
        return;
    }
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    global $wpdb;

    // Ordenar por tiempo de ejecución (descendente)
    $queries = $wpdb->queries;
    usort( $queries, fn( $a, $b ) => $b[1] <=> $a[1] );

    // Mostrar las 5 queries más lentas
    echo '<div style="background:#fff;padding:20px;font-family:monospace;font-size:11px;">';
    echo '<h3>Top 5 queries más lentas</h3>';
    foreach ( array_slice( $queries, 0, 5 ) as $query ) {
        printf(
            '<p><strong>%.4fs</strong><br>%s<br><small>%s</small></p>',
            $query[1],
            esc_html( $query[0] ),
            esc_html( $query[2] )
        );
    }
    echo '</div>';
} );
