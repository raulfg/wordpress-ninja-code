// On lesson completion
add_action( 'learndash_lesson_completed', function( array $data ): void {
    $user_id   = $data['user']->ID;
    $lesson_id = $data['lesson']->ID;
    $course_id = $data['course']->ID;

    // Award points, notify an external system, log in CRM, etc.
} );

// On completing a full course
add_action( 'learndash_course_completed', function( array $data ): void {
    $user_id   = $data['user']->ID;
    $course_id = $data['course']->ID;

    // Grant certificate, notify manager, unlock next course
} );
