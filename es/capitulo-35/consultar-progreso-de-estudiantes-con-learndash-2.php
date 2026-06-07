/**
 * Obtiene las puntuaciones del quiz para todos los usuarios.
 *
 * @param int $quiz_id ID del quiz.
 * @return array Array indexado por user_id con la mejor puntuación.
 */
function ninja_get_quiz_scores( int $quiz_id ): array {
    $activity = learndash_reports_get_activity( [
        'user_id'        => 0,
        'activity_type'  => 'quiz',
        'post_ids'       => [ $quiz_id ],
        'per_page'       => 1000,
        'paged'          => 1,
    ] );

    $scores = [];

    foreach ( $activity['results'] ?? [] as $row ) {
        $user_id = (int) $row->user_id;
        $score   = (float) $row->activity_meta_percentage;

        // Mantener solo la puntuación más alta por usuario
        if ( ! isset( $scores[ $user_id ] ) || $score > $scores[ $user_id ] ) {
            $scores[ $user_id ] = $score;
        }
    }

    return $scores;
}
