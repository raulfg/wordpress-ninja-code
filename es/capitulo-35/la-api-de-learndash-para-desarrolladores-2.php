// Al completar una lección
add_action( 'learndash_lesson_completed', function( array $data ): void {
    $user_id   = $data['user']->ID;
    $lesson_id = $data['lesson']->ID;
    $course_id = $data['course']->ID;

    // Conceder puntos, notificar a un sistema externo, registrar en CRM, etc.
} );

// Al completar un curso completo
add_action( 'learndash_course_completed', function( array $data ): void {
    $user_id   = $data['user']->ID;
    $course_id = $data['course']->ID;

    // Conceder certificado, notificar al responsable, desbloquear siguiente curso
} );
