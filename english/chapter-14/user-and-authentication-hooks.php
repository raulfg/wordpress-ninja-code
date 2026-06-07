// After the user authenticates successfully
add_action( 'wp_login', function ( string $user_login, WP_User $user ): void {
    update_user_meta( $user->ID, '_last_login', current_time( 'mysql' ) );
}, 10, 2 );

// When a new user registers
add_action( 'user_register', function ( int $user_id ): void {
    // Assign role, send welcome email, etc.
} );

// Filter to redirect after login
add_filter( 'login_redirect', function ( string $redirect_to, string $requested_redirect_to, WP_User|WP_Error $user ): string {
    if ( $user instanceof WP_User && $user->has_cap( 'manage_options' ) ) {
        return admin_url( 'index.php' );
    }
    return home_url( '/my-account/' );
}, 10, 3 );
