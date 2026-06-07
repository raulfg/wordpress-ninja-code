add_action( 'admin_post_ninja_guardar_configuracion', 'ninja_procesar_configuracion' );

function ninja_procesar_configuracion(): void {
    // Verificar nonce — wp_die si falla
    if ( ! isset( $_POST['ninja_nonce'] ) ||
         ! wp_verify_nonce( $_POST['ninja_nonce'], 'ninja_guardar_configuracion' ) ) {
        wp_die( esc_html__( 'Error de seguridad. Por favor, recarga la página e inténtalo de nuevo.', 'ninjatheme' ) );
    }

    // Verificar permisos del usuario
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'No tienes permiso para realizar esta acción.', 'ninjatheme' ) );
    }

    // Sanitizar y guardar
    $api_key = isset( $_POST['api_key'] ) ? sanitize_text_field( wp_unslash( $_POST['api_key'] ) ) : '';
    update_option( 'ninja_api_key', $api_key );

    // Redirigir con mensaje de éxito
    wp_redirect( add_query_arg( 'updated', '1', wp_get_referer() ) );
    exit;
}
