// Server: add data to the Heartbeat response
add_filter( 'heartbeat_received', 'ninja_heartbeat_handler', 10, 2 );

function ninja_heartbeat_handler( array $response, array $data ): array {
    // $data contains what the frontend sent in the 'data' field.
    // $response is the array that will be returned to the frontend.

    if ( isset( $data['ninja_check_notifications'] ) ) {
        $user_id      = get_current_user_id();
        $unread_count = ninja_get_unread_notifications( $user_id );

        $response['ninja_notifications'] = [
            'count' => $unread_count,
        ];
    }

    return $response;
}
