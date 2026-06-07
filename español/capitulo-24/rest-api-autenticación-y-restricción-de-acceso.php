add_filter( 'rest_authentication_errors', function( $result ) {
    // Si ya hay un error de autenticación, no sobreescribir
    if ( ! empty( $result ) ) {
        return $result;
    }

    // Requerir autenticación para todos los endpoints de la REST API
    if ( ! is_user_logged_in() ) {
        return new WP_Error(
            'rest_not_logged_in',
            __( 'Acceso no autorizado.', 'ninjatheme' ),
            [ 'status' => 401 ]
        );
    }

    return $result;
} );
