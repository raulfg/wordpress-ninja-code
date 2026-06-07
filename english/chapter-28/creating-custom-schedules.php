add_filter( 'cron_schedules', function( array $schedules ): array {
    $schedules['every_15_minutes'] = [
        'interval' => 900,
        'display'  => 'Every 15 minutes',
    ];
    $schedules['every_4_hours'] = [
        'interval' => 14400,
        'display'  => 'Every 4 hours',
    ];
    return $schedules;
} );

// Schedule an event if it is not already scheduled
if ( ! wp_next_scheduled( 'ninja_portfolio_sync' ) ) {
    wp_schedule_event( time(), 'every_4_hours', 'ninja_portfolio_sync' );
}

// Event handler
add_action( 'ninja_portfolio_sync', function(): void {
    // Synchronization logic
} );
