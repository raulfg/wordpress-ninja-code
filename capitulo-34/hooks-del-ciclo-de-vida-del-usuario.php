// Usuario registrado: configurar defaults, enviar email de bienvenida
add_action( 'user_register', function ( int $user_id ): void {
    update_user_meta( $user_id, 'suscripcion_estado', 'inactiva' );
    update_user_meta( $user_id, 'suscripcion_plan', 'free' );
} );

// Perfil actualizado: sincronizar con servicio externo si cambió el email
add_action( 'profile_update', function ( int $user_id, WP_User $old_data ): void {
    $new_user = get_userdata( $user_id );

    if ( $new_user->user_email !== $old_data->user_email ) {
        mi_plugin_sincronizar_email_externo( $user_id, $new_user->user_email );
    }
}, 10, 2 );

// Antes de eliminar: limpiar datos del plugin
add_action( 'delete_user', function ( int $user_id ): void {
    global $wpdb;
    $wpdb->delete(
        $wpdb->prefix . 'mi_plugin_suscripciones',
        [ 'user_id' => $user_id ],
        [ '%d' ]
    );
} );
