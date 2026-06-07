function ninjatheme_migration_004_batch_update(): void {
    $batch_size  = 500;
    $offset_key  = 'npe_migration_004_offset';
    $offset      = (int) get_option( $offset_key, 0 );
    $total_processed = 0;

    global $wpdb;
    $table = $wpdb->prefix . 'ninja_stats';

    while ( true ) {
        $rows = $wpdb->get_results( $wpdb->prepare(
            "SELECT ID FROM {$table} WHERE session_id = '' LIMIT %d OFFSET %d",
            $batch_size, $offset
        ) );

        if ( empty( $rows ) ) {
            // Migration complete: clean up the offset marker
            delete_option( $offset_key );
            break;
        }

        $ids = implode( ',', array_map( 'absint', wp_list_pluck( $rows, 'ID' ) ) );
        $wpdb->query( "UPDATE {$table} SET session_id = UUID() WHERE ID IN ({$ids})" );

        $offset += $batch_size;
        $total_processed += count( $rows );

        update_option( $offset_key, $offset );

        // If more than 10 seconds have passed, stop and defer to the next request
        if ( microtime( true ) - WP_START_TIMESTAMP > 10 ) {
            break;
        }
    }
}
