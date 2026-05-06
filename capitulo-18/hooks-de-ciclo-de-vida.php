// ninja-portfolio-enhancer.php (archivo principal del plugin)

register_activation_hook( __FILE__, 'npe_activate' );

function npe_activate(): void {
    // Verificar versión mínima de WordPress
    if ( version_compare( get_bloginfo( 'version' ), '6.0', '<' ) ) {
        deactivate_plugins( plugin_basename( __FILE__ ) );
        wp_die(
            esc_html__( 'Ninja Portfolio Enhancer requiere WordPress 6.0 o superior.', 'npe' ),
            esc_html__( 'Error de activación', 'npe' ),
            [ 'back_link' => true ]
        );
    }

    // Crear la tabla de analítica del portfolio
    npe_create_analytics_table();

    // Establecer opciones por defecto (solo si no existen)
    add_option( 'npe_settings', [
        'posts_per_page' => 12,
        'show_featured'  => true,
        'default_order'  => 'date',
    ] );

    // Guardar la versión instalada para migraciones futuras
    update_option( 'npe_db_version', NPE_VERSION );

    // Forzar regeneración de reglas de rewrite (para el CPT)
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
