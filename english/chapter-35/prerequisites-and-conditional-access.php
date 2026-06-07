/**
 * Checks if the user can access a course with prerequisites.
 *
 * @param int $user_id
 * @param int $course_id
 * @return bool
 */
function user_can_access_course( int $user_id, int $course_id ): bool {
    // Check whether prerequisites are configured for the course
    $prerequisites = get_post_meta( $course_id, 'course_prerequisite', true );

    if ( empty( $prerequisites ) ) {
        return sfwd_lms_has_access( $course_id, $user_id );
    }

    // Verify all prerequisites are completed
    foreach ( (array) $prerequisites as $prereq_id ) {
        if ( ! learndash_is_course_complete( $user_id, (int) $prereq_id ) ) {
            return false;
        }
    }

    return sfwd_lms_has_access( $course_id, $user_id );
}
