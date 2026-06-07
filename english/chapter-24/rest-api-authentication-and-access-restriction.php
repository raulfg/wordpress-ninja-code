add_filter( 'rest_authentication_errors', function( $result ) {
    // If there is already an authentication error, do not overwrite it
    if ( ! empty( $result ) ) {
        return $result;
    }

    // Require authentication for all REST API endpoints
    if ( ! is_user_logged_in() ) {
        return new WP_Error(
            'rest_not_logged_in',
            __( 'Unauthorized access.', 'ninjatheme' ),
            [ 'status' => 401 ]
        );
    }

    return $result;
} );
