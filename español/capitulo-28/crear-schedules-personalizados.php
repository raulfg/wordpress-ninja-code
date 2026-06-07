add_filter( 'cron_schedules', function( array $schedules ): array {
    $schedules['cada_15_minutos'] = [
        'interval' => 900,
        'display'  => 'Cada 15 minutos',
    ];
    $schedules['cada_4_horas'] = [
        'interval' => 14400,
        'display'  => 'Cada 4 horas',
    ];
    return $schedules;
} );

// Programar un evento si no está ya programado
if ( ! wp_next_scheduled( 'ninja_portfolio_sync' ) ) {
    wp_schedule_event( time(), 'cada_4_horas', 'ninja_portfolio_sync' );
}

// Handler del evento
add_action( 'ninja_portfolio_sync', function(): void {
    // Lógica de sincronización
} );
