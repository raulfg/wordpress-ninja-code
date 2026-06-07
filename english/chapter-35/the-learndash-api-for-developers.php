// Does the user have access to a specific course?
$has_access = sfwd_lms_has_access( $course_id, $user_id );

// Get the user's progress in a course (0-100)
$progress = learndash_course_progress( [
    'user_id'   => $user_id,
    'course_id' => $course_id,
    'array'     => true, // returns array with 'completed', 'total', 'percentage'
] );

// Has the user completed the course?
$completed = learndash_is_course_complete( $user_id, $course_id );

// Date from which the user has access to the course
$access_from = ld_course_access_from( $course_id, $user_id );
// Returns a Unix timestamp or false if no access

// Get all lessons in a course
$lessons = learndash_get_course_lessons_list( $course_id );
