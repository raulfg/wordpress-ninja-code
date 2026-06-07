/**
 * Gets quiz scores for all users.
 *
 * @param int $quiz_id Quiz ID.
 * @return array Array indexed by user_id with the best score.
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

        // Keep only the highest score per user
        if ( ! isset( $scores[ $user_id ] ) || $score > $scores[ $user_id ] ) {
            $scores[ $user_id ] = $score;
        }
    }

    return $scores;
}
