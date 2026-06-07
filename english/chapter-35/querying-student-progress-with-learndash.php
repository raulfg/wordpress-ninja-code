/**
 * Gets course completions from the last 30 days.
 *
 * @return array Array with user_id, course_id, and completion date.
 */
function ninja_get_course_completions_last_month(): array {
    $start = strtotime( '-30 days' );
    $end   = time();

    $activity = learndash_reports_get_activity( [
        'user_id'        => 0,           // 0 = all users
        'course_id'      => 0,           // 0 = all courses
        'activity_type'  => 'course',
        'activity_status' => 'complete',
        'date_start'     => $start,
        'date_end'       => $end,
        'per_page'       => 500,
        'paged'          => 1,
    ] );

    if ( empty( $activity['results'] ) ) {
        return [];
    }

    return array_map( function( $row ): array {
        return [
            'user_id'     => (int) $row->user_id,
            'course_id'   => (int) $row->post_id,
            'completed_at' => $row->activity_updated,
        ];
    }, $activity['results'] );
}
