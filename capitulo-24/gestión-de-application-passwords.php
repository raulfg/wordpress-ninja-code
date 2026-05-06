// Limitar qué roles pueden crear Application Passwords
add_filter( 'wp_is_application_passwords_available_for_user', function( bool $available, WP_User $user ): bool {
    // Solo administradores pueden crear Application Passwords
    if ( ! in_array( 'administrator', $user->roles, true ) ) {
        return false;
    }
    return $available;
}, 10, 2 );

// Log de uso de Application Passwords
add_action( 'wp_authenticate_application_password_errors', function(
    WP_Error $error,
    WP_User $user,
    array $token_data
): void {
    if ( $error->has_errors() ) {
        error_log( sprintf(
            '[security] Application Password failed for user %s from IP %s',
            $user->user_login,
            $_SERVER['REMOTE_ADDR'] ?? 'unknown'
        ) );
    }
}, 10, 3 );
