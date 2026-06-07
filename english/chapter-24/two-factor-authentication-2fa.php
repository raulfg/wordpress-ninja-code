// Redirect to 2FA setup if the user has not activated it
add_action( 'wp_login', function( string $user_login, WP_User $user ): void {
    // Only apply to administrators and editors
    if ( ! array_intersect( $user->roles, [ 'administrator', 'editor' ] ) ) {
        return;
    }

    // Check if the user has 2FA configured
    $has_2fa = get_user_meta( $user->ID, '_two_factor_enabled_providers', true );

    if ( empty( $has_2fa ) ) {
        // Force logout and redirect to 2FA setup
        wp_logout();
        wp_redirect( add_query_arg( [
            'action'    => 'setup_2fa',
            'redirect'  => urlencode( admin_url() ),
        ], wp_login_url() ) );
        exit;
    }
}, 10, 2 );
