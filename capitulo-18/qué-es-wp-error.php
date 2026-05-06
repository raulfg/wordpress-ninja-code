function mi_plugin_obtener_usuario( int $user_id ): WP_User|WP_Error {
    if ( $user_id <= 0 ) {
        return new WP_Error(
            'invalid_user_id',
            __( 'El ID de usuario no es válido.', 'mi-plugin' ),
            [ 'user_id' => $user_id ]
        );
    }

    $user = get_user_by( 'id', $user_id );

    if ( ! $user ) {
        return new WP_Error(
            'user_not_found',
            sprintf(
                /* translators: %d es el ID del usuario */
                __( 'No se encontró el usuario con ID %d.', 'mi-plugin' ),
                $user_id
            )
        );
    }

    return $user;
}
