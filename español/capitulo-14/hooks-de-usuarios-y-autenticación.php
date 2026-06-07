// Después de que el usuario se autentica correctamente
add_action( 'wp_login', function ( string $user_login, WP_User $user ): void {
    update_user_meta( $user->ID, '_ultimo_login', current_time( 'mysql' ) );
}, 10, 2 );

// Cuando se registra un nuevo usuario
add_action( 'user_register', function ( int $user_id ): void {
    // Asignar rol, enviar email de bienvenida, etc.
} );

// Filter para redirigir tras el login
add_filter( 'login_redirect', function ( string $redirect_to, string $requested_redirect_to, WP_User|WP_Error $user ): string {
    if ( $user instanceof WP_User && $user->has_cap( 'manage_options' ) ) {
        return admin_url( 'index.php' );
    }
    return home_url( '/mi-cuenta/' );
}, 10, 3 );
