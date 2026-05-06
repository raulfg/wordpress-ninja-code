// Servidor: añadir datos a la respuesta de Heartbeat
add_filter( 'heartbeat_received', 'ninja_heartbeat_handler', 10, 2 );

function ninja_heartbeat_handler( array $response, array $data ): array {
    // $data contiene lo que el frontend envió en el campo 'data'
    // $response es el array que se devolverá al frontend

    if ( isset( $data['ninja_check_notifications'] ) ) {
        $user_id      = get_current_user_id();
        $unread_count = ninja_get_unread_notifications( $user_id );

        $response['ninja_notifications'] = [
            'count' => $unread_count,
        ];
    }

    return $response;
}
