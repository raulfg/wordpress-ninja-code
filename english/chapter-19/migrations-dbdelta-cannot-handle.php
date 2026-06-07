function ninjatheme_run_migrations(): void {
    $current = (int) get_option( 'npe_schema_revision', 0 );

    if ( $current < 1 ) {
        ninjatheme_migration_001_add_session_column();
        update_option( 'npe_schema_revision', 1 );
    }

    if ( $current < 2 ) {
        ninjatheme_migration_002_backfill_event_types();
        update_option( 'npe_schema_revision', 2 );
    }

    if ( $current < 3 ) {
        ninjatheme_migration_003_drop_legacy_column();
        update_option( 'npe_schema_revision', 3 );
    }
}

function ninjatheme_migration_001_add_session_column(): void {
    global $wpdb;
    $table = $wpdb->prefix . 'ninja_stats';

    // Check if the column already exists before adding it
    $column_exists = $wpdb->get_var( $wpdb->prepare(
        "SELECT COUNT(*) FROM information_schema.COLUMNS
         WHERE TABLE_SCHEMA = %s
           AND TABLE_NAME   = %s
           AND COLUMN_NAME  = 'session_id'",
        DB_NAME, $table
    ) );

    if ( ! $column_exists ) {
        $wpdb->query( "ALTER TABLE {$table} ADD COLUMN session_id varchar(64) NOT NULL DEFAULT '' AFTER user_id" );
    }
}

function ninjatheme_migration_002_backfill_event_types(): void {
    global $wpdb;
    $table = $wpdb->prefix . 'ninja_stats';

    // Normalize event_type values that were stored in uppercase
    $wpdb->query(
        "UPDATE {$table} SET event_type = LOWER(event_type) WHERE event_type != LOWER(event_type)"
    );
}

function ninjatheme_migration_003_drop_legacy_column(): void {
    global $wpdb;
    $table = $wpdb->prefix . 'ninja_stats';

    $column_exists = $wpdb->get_var( $wpdb->prepare(
        "SELECT COUNT(*) FROM information_schema.COLUMNS
         WHERE TABLE_SCHEMA = %s AND TABLE_NAME = %s AND COLUMN_NAME = 'legacy_ref'",
        DB_NAME, $table
    ) );

    if ( $column_exists ) {
        $wpdb->query( "ALTER TABLE {$table} DROP COLUMN legacy_ref" );
    }
}
