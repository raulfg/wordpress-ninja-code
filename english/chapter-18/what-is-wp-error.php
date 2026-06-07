function my_plugin_get_user( int $user_id ): WP_User|WP_Error {
    if ( $user_id <= 0 ) {
        return new WP_Error(
            'invalid_user_id',
            __( 'The user ID is not valid.', 'my-plugin' ),
            [ 'user_id' => $user_id ]
        );
    }

    $user = get_user_by( 'id', $user_id );

    if ( ! $user ) {
        return new WP_Error(
            'user_not_found',
            sprintf(
                /* translators: %d is the user ID */
                __( 'No user found with ID %d.', 'my-plugin' ),
                $user_id
            )
        );
    }

    return $user;
}
