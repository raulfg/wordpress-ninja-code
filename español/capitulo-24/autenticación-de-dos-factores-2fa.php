// Redirigir a la configuración de 2FA si el usuario no lo ha activado
add_action( 'wp_login', function( string $user_login, WP_User $user ): void {
    // Solo aplicar a administradores y editores
    if ( ! array_intersect( $user->roles, [ 'administrator', 'editor' ] ) ) {
        return;
    }

    // Verificar si el usuario tiene 2FA configurado
    $has_2fa = get_user_meta( $user->ID, '_two_factor_enabled_providers', true );

    if ( empty( $has_2fa ) ) {
        // Forzar logout y redirigir a la configuración de 2FA
        wp_logout();
        wp_redirect( add_query_arg( [
            'action'    => 'setup_2fa',
            'redirect'  => urlencode( admin_url() ),
        ], wp_login_url() ) );
        exit;
    }
}, 10, 2 );
