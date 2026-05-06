// LifterLMS: hook al completar una lección
add_action( 'lifterlms_lesson_completed', function( int $student_id, int $lesson_id, int $course_id ): void {
    // Limpiar el caché de progreso para este curso y usuario
    $cache_key = "progress_{$student_id}_{$course_id}";
    wp_cache_delete( $cache_key, 'ninja_lms' );
}, 10, 3 );

// Función que usa el caché correctamente
function ninja_get_cached_progress( int $user_id, int $course_id ): array {
    $cache_key = "progress_{$user_id}_{$course_id}";
    $group     = 'ninja_lms';

    $cached = wp_cache_get( $cache_key, $group );

    if ( false !== $cached ) {
        return $cached;
    }

    $progress = [
        'percentage' => (float) llms_get_user_postmeta( $user_id, $course_id, '_overall_progress' ),
        'completed'  => llms_is_course_complete( $user_id, $course_id ),
    ];

    wp_cache_set( $cache_key, $progress, $group, 300 );

    return $progress;
}
