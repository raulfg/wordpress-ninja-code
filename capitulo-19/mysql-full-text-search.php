// Crear índice FULLTEXT en wp_posts (ejecutar una sola vez)
function ninja_create_fulltext_index(): void {
    global $wpdb;

    // Verificar si el índice ya existe
    $index_exists = $wpdb->get_var(
        "SELECT COUNT(*) FROM information_schema.STATISTICS
         WHERE table_schema = DATABASE()
         AND table_name = '{$wpdb->posts}'
         AND index_name = 'ninja_fulltext'"
    );

    if ( $index_exists ) {
        return;
    }

    // Los índices FULLTEXT requieren la tabla entera bloqueada durante la creación
    // Ejecutar esto en horas de bajo tráfico o durante la instalación
    $wpdb->query(
        "ALTER TABLE {$wpdb->posts}
         ADD FULLTEXT INDEX ninja_fulltext (post_title, post_content)"
    );
}

register_activation_hook( __FILE__, 'ninja_create_fulltext_index' );
