// LearnDash: hook al completar un curso
add_action( 'learndash_user_course_completed', function( array $data ): void {
    $user_id   = $data['user']->ID;
    $course_id = $data['course']->ID;

    // Enviar a un endpoint externo (webhook de Zapier, Make, n8n, etc.)
    wp_remote_post( get_option( 'ninja_analytics_webhook_url' ), [
        'blocking' => false,
        'headers'  => [ 'Content-Type' => 'application/json' ],
        'body'     => wp_json_encode( [
            'event'     => 'course_completed',
            'user_id'   => $user_id,
            'user_email' => get_userdata( $user_id )->user_email,
            'course_id' => $course_id,
            'course'    => get_the_title( $course_id ),
            'date'      => current_time( 'c' ),
        ] ),
    ] );
} );
