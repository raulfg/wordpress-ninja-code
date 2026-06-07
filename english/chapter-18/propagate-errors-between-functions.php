function my_plugin_sync_user( int $user_id ): true|WP_Error {
    $user = my_plugin_get_user( $user_id );

    if ( is_wp_error( $user ) ) {
        // Propagate the error as-is — the caller knows what to do with it
        return $user;
    }

    $result = my_plugin_call_external_api( $user );

    if ( is_wp_error( $result ) ) {
        // Enrich the error with additional context before propagating
        $result->add(
            'sync_failed',
            sprintf( 'Sync failed for user %d.', $user_id )
        );
        return $result;
    }

    return true;
}
