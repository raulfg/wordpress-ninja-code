function mi_plugin_sincronizar_usuario( int $user_id ): true|WP_Error {
    $user = mi_plugin_obtener_usuario( $user_id );

    if ( is_wp_error( $user ) ) {
        // Propagar el error tal cual — el llamador sabe qué hacer con él
        return $user;
    }

    $resultado = mi_plugin_llamar_api_externa( $user );

    if ( is_wp_error( $resultado ) ) {
        // Enriquecer el error con contexto adicional antes de propagar
        $resultado->add(
            'sync_failed',
            sprintf( 'Sincronización fallida para usuario %d.', $user_id )
        );
        return $resultado;
    }

    return true;
}
