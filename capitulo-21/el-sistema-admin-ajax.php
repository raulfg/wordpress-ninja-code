// Para usuarios autenticados
add_action( 'wp_ajax_ninja_guardar_favorito', 'ninja_guardar_favorito' );

// Para usuarios no autenticados (y también para autenticados si se registra aquí)
add_action( 'wp_ajax_nopriv_ninja_guardar_favorito', 'ninja_guardar_favorito' );

function ninja_guardar_favorito(): void {
    // Verificar nonce antes de hacer cualquier otra cosa
    check_ajax_referer( 'ninja-favorito-nonce', 'nonce' );

    $post_id = filter_input( INPUT_POST, 'post_id', FILTER_VALIDATE_INT );

    if ( ! $post_id ) {
        wp_send_json_error( [ 'mensaje' => 'ID de post inválido.' ], 400 );
    }

    // Lógica de negocio
    $resultado = ninja_toggle_favorito( get_current_user_id(), $post_id );

    wp_send_json_success( [ 'favorito' => $resultado ] );
}
