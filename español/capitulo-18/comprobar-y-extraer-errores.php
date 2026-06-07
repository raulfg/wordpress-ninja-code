$resultado = mi_plugin_obtener_usuario( $user_id );

if ( is_wp_error( $resultado ) ) {
    // Loguear el error técnico
    error_log(
        sprintf(
            '[mi-plugin] %s: %s',
            $resultado->get_error_code(),
            $resultado->get_error_message()
        )
    );

    // Mostrar mensaje al usuario si corresponde
    echo '<p class="error">' . esc_html( $resultado->get_error_message() ) . '</p>';
    return;
}

// Aquí $resultado es WP_User con seguridad
