add_action( 'plugins_loaded', 'npe_run_migrations' );

function npe_run_migrations(): void {
    $installed_version = get_option( 'npe_db_version', '0.0.0' );

    if ( version_compare( $installed_version, NPE_VERSION, '>=' ) ) {
        return; // Already on the correct version
    }

    // Migration to version 1.1.0: add referrer column to the analytics table
    if ( version_compare( $installed_version, '1.1.0', '<' ) ) {
        global $wpdb;
        $wpdb->query(
            "ALTER TABLE {$wpdb->prefix}npe_analytics
             ADD COLUMN referrer VARCHAR(500) NULL AFTER ip_hash"
        );
    }

    // Migration to version 1.2.0: add index by user_id
    if ( version_compare( $installed_version, '1.2.0', '<' ) ) {
        global $wpdb;
        $wpdb->query(
            "ALTER TABLE {$wpdb->prefix}npe_analytics
             ADD INDEX IF NOT EXISTS idx_user (user_id)"
        );
    }

    update_option( 'npe_db_version', NPE_VERSION );
}
