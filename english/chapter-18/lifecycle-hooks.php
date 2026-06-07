// ninja-portfolio-enhancer.php (plugin main file)

register_activation_hook( __FILE__, 'npe_activate' );

function npe_activate(): void {
    // Verify minimum WordPress version
    if ( version_compare( get_bloginfo( 'version' ), '6.0', '<' ) ) {
        deactivate_plugins( plugin_basename( __FILE__ ) );
        wp_die(
            esc_html__( 'Ninja Portfolio Enhancer requires WordPress 6.0 or higher.', 'npe' ),
            esc_html__( 'Activation error', 'npe' ),
            [ 'back_link' => true ]
        );
    }

    // Create the portfolio analytics table
    npe_create_analytics_table();

    // Set default options (only if they do not exist)
    add_option( 'npe_settings', [
        'posts_per_page' => 12,
        'show_featured'  => true,
        'default_order'  => 'date',
    ] );

    // Save the installed version for future migrations
    update_option( 'npe_db_version', NPE_VERSION );

    // Force rewrite rules regeneration (for the CPT)
    flush_rewrite_rules();
}

function npe_create_analytics_table(): void {
    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();
    $table_name      = $wpdb->prefix . 'npe_analytics';

    $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
        id         BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        post_id    BIGINT(20) UNSIGNED NOT NULL,
        event_type VARCHAR(50)         NOT NULL,
        event_date DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
        user_id    BIGINT(20) UNSIGNED     NULL,
        ip_hash    VARCHAR(64)             NULL,
        PRIMARY KEY (id),
        KEY idx_post_event (post_id, event_type),
        KEY idx_date (event_date)
    ) {$charset_collate};";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta( $sql );
}
