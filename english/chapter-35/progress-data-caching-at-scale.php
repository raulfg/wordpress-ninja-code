function ninja_lms_get_progress( int $user_id, int $course_id ): array {
    $key    = "lms_progress_{$user_id}_{$course_id}";
    $group  = 'ninja_lms';
    $cached = wp_cache_get( $key, $group );

    if ( false !== $cached ) {
        return $cached;
    }

    $data = [
        'percentage' => learndash_course_progress( [
            'user_id'   => $user_id,
            'course_id' => $course_id,
        ] ),
        'completed'  => learndash_is_course_complete( $user_id, $course_id ),
        'last_step'  => learndash_user_course_last_accessed_step( $user_id, $course_id ),
    ];

    wp_cache_set( $key, $data, $group, 5 * MINUTE_IN_SECONDS );

    return $data;
}

// Invalidate on completing any course step
add_action( 'learndash_lesson_completed', function( array $data ): void {
    $key = "lms_progress_{$data['user']->ID}_{$data['course']->ID}";
    wp_cache_delete( $key, 'ninja_lms' );
} );

add_action( 'learndash_topic_completed', function( array $data ): void {
    $key = "lms_progress_{$data['user']->ID}_{$data['course']->ID}";
    wp_cache_delete( $key, 'ninja_lms' );
} );
