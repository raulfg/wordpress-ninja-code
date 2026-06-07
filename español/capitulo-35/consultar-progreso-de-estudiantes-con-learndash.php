/**
 * Obtiene las finalizaciones de curso de los últimos 30 días.
 *
 * @return array Array con user_id, course_id y fecha de finalización.
 */
function ninja_get_course_completions_last_month(): array {
    $start = strtotime( '-30 days' );
    $end   = time();

    $activity = learndash_reports_get_activity( [
        'user_id'        => 0,           // 0 = todos los usuarios
        'course_id'      => 0,           // 0 = todos los cursos
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
