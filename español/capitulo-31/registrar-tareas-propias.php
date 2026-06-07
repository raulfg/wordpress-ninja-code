// El hook ejecuta el trabajo real
add_action( 'mi_plugin_sincronizar_inventario', 'mi_plugin_ejecutar_sincronizacion' );

function mi_plugin_ejecutar_sincronizacion(): void {
    // lógica de la tarea
}

// Programar en la activación del plugin
register_activation_hook( __FILE__, 'mi_plugin_activar_cron' );

function mi_plugin_activar_cron(): void {
    if ( ! wp_next_scheduled( 'mi_plugin_sincronizar_inventario' ) ) {
        wp_schedule_event( time(), 'hourly', 'mi_plugin_sincronizar_inventario' );
    }
}

// Limpiar en la desactivación
register_deactivation_hook( __FILE__, 'mi_plugin_desactivar_cron' );

function mi_plugin_desactivar_cron(): void {
    $timestamp = wp_next_scheduled( 'mi_plugin_sincronizar_inventario' );
    if ( $timestamp ) {
        wp_unschedule_event( $timestamp, 'mi_plugin_sincronizar_inventario' );
    }
}
