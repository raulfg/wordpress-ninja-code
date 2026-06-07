// En la frontera entre tu código y WordPress
add_action( 'wp_ajax_mi_accion', function (): void {
    try {
        $resultado = mi_servicio_interno->ejecutar();
        wp_send_json_success( $resultado );
    } catch ( MiExcepcionDeDominio $e ) {
        wp_send_json_error(
            new WP_Error( 'domain_error', $e->getMessage() ),
            400
        );
    } catch ( \Throwable $e ) {
        error_log( '[mi-plugin] Unexpected error: ' . $e->getMessage() );
        wp_send_json_error(
            new WP_Error( 'internal_error', __( 'Error interno del servidor.', 'mi-plugin' ) ),
            500
        );
    }
} );
