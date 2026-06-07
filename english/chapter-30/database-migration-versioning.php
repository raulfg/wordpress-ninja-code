<?php

function ninja_run_migrations(): void {
    $db_version    = '1.3.0';
    $stored_version = get_option( 'ninja_db_version', '0.0.0' );

    if ( version_compare( $stored_version, $db_version, '>=' ) ) {
        return; // Already at the correct version
    }

    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    // dbDelta creates or alters tables incrementally
    $sql = "CREATE TABLE {$wpdb->prefix}ninja_analytics (
        id          BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        post_id     BIGINT(20) UNSIGNED NOT NULL,
        event_type  VARCHAR(50)         NOT NULL,
        event_date  DATETIME            NOT NULL,
        user_id     BIGINT(20) UNSIGNED     NULL,
        PRIMARY KEY (id),
        KEY idx_post_event (post_id, event_type),
        KEY idx_date (event_date)
    ) {$charset_collate};";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta( $sql );

    update_option( 'ninja_db_version', $db_version );
}

add_action( 'plugins_loaded', 'ninja_run_migrations' );
